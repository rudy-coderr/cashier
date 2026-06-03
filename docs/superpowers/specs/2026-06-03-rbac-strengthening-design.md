# RBAC Strengthening & Page Accessibility — Design Spec

**Date:** 2026-06-03
**Scope:** Strengthen role-based access control and fix page accessibility across all roles.

---

## Problem

The current RBAC has three concrete issues:

1. **Dual role source** — both `role_id` (FK to `roles` table) and `position` (plain text) are used to determine a user's role. They can get out of sync, making role checks unpredictable.
2. **Wrong unauthorized redirect** — `RequireRole` middleware falls back to `route('dashboard')`, which is the Maker route. Any non-Maker who hits an unauthorized URL gets sent to the wrong dashboard.
3. **Duplicated role logic** — the same `DB::table('roles')->where('id', $user->role_id)->value('name')` query and role→route mapping appear independently in `RequireRole`, `LoginController::login()`, and `LoginController::verifyOtp()`.

---

## Decisions

- `role_id` is the single source of truth for all role checks.
- `position` is kept on the `users` table for display purposes only (job title label) — never used in access control logic.
- Unauthorized access redirects the user to their own role's dashboard with a flash error.

---

## Roles & Dashboard Routes

| Role | Dashboard Route |
|---|---|
| `admin` | `admin.dashboard` |
| `maker` | `dashboard` |
| `reviewer` | `reviewer` |
| `accountant` | `accountant.approval` |
| _(unknown)_ | `dashboard` (safe fallback) |

---

## Section 1 — User Model Helpers

**File:** `app/Models/User.php`

Add two public methods:

### `roleName(): ?string`

Looks up the user's role name from the `roles` table via `$this->role_id`. Returns the lowercase name (e.g., `"admin"`) or `null` if `role_id` is unset. This is the single place in the codebase that performs this lookup.

### `dashboardRoute(): string`

Calls `$this->roleName()` and returns the named Laravel route for that role using the table above. Falls back to `"dashboard"` for unrecognised or null roles.

These two methods become the authoritative API for role identity throughout the app.

---

## Section 2 — RequireRole Middleware

**File:** `app/Http/Middleware/RequireRole.php`

Replace the inline `DB::table('roles')` query and `position` fallback with `$user->roleName()`.

Replace the hardcoded unauthorized redirect:
```php
// Before
return redirect()->route('dashboard')->with('error', 'Unauthorized access.');

// After
return redirect()->route($user->dashboardRoute())->with('error', 'Unauthorized access.');
```

The `previous URL` redirect path remains unchanged — it only applies when the user arrived by typing a URL directly.

---

## Section 3 — LoginController

**File:** `app/Http/Controllers/LoginController.php`

Replace the duplicated role-check blocks in both `login()` and `verifyOtp()` with a single call:

```php
return redirect()->intended(route($user->dashboardRoute()));
```

The `DB` facade import can be removed from `LoginController` as it is no longer used there after this change.

---

## Section 4 — Navigation Safety

**File:** `app/Providers/AppServiceProvider.php`

Register a `@role` Blade directive:

```php
Blade::directive('role', function ($role) {
    return "<?php if(auth()->check() && auth()->user()->roleName() === trim({$role}, \"'\\\"")): ?>";
});

Blade::directive('endrole', function () {
    return '<?php endif; ?>';
});
```

Since each role already has its own Blade view, no existing nav needs to change immediately. The directive is available for future shared partials and makes role-gating explicit when needed.

---

## What Does Not Change

- The `roles` table and its 4 entries (`admin`, `maker`, `reviewer`, `accountant`) — no migrations needed.
- The `position` column — kept as-is, used only for display.
- Route definitions in `web.php` — no changes to route groups or middleware application.
- Individual role Blade views — no nav changes required since views are already role-separated.

---

## Files Changed

| File | Change |
|---|---|
| `app/Models/User.php` | Add `roleName()` and `dashboardRoute()` |
| `app/Http/Middleware/RequireRole.php` | Use `roleName()`, fix unauthorized redirect |
| `app/Http/Controllers/LoginController.php` | Use `dashboardRoute()` in `login()` and `verifyOtp()`, remove `DB` import |
| `app/Providers/AppServiceProvider.php` | Register `@role` / `@endrole` Blade directives |
