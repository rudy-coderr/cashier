# RBAC Strengthening Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Consolidate role checks to `role_id` only, fix unauthorized redirects to send each user to their own dashboard, and register a `@role` Blade directive for future use.

**Architecture:** Add `roleName()` and `dashboardRoute()` helpers to the `User` model as the single source of truth, then update `RequireRole` middleware and `LoginController` to use them. Register `@role`/`@endrole` Blade directives in `AppServiceProvider`.

**Tech Stack:** Laravel 11, PHP 8.2, PHPUnit, MySQL

---

## File Map

| File | Action | What changes |
|---|---|---|
| `app/Models/User.php` | Modify | Add `roleName()` and `dashboardRoute()` methods |
| `app/Http/Middleware/RequireRole.php` | Modify | Use `roleName()`, fix unauthorized redirect to use `dashboardRoute()`, remove `DB` import |
| `app/Http/Controllers/LoginController.php` | Modify | Replace role-check blocks in `login()` and `verifyOtp()` with `dashboardRoute()`, remove `DB` import |
| `app/Providers/AppServiceProvider.php` | Modify | Register `@role` / `@endrole` Blade directives |
| `tests/Unit/UserRoleHelpersTest.php` | Create | Unit tests for `roleName()` and `dashboardRoute()` |
| `tests/Feature/RequireRoleMiddlewareTest.php` | Create | Feature test for unauthorized redirect behaviour |
| `tests/Feature/LoginRedirectTest.php` | Create | Feature test for login redirect per role |

---

## Task 1: Add `roleName()` and `dashboardRoute()` to User model

**Files:**
- Modify: `app/Models/User.php`
- Create: `tests/Unit/UserRoleHelpersTest.php`

- [ ] **Step 1: Create the unit test file**

Create `tests/Unit/UserRoleHelpersTest.php`:

```php
<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserRoleHelpersTest extends TestCase
{
    use RefreshDatabase;

    private function roleId(string $name): int
    {
        return DB::table('roles')->where('name', $name)->value('id');
    }

    public function test_role_name_returns_lowercase_name_for_known_role(): void
    {
        $user = User::factory()->create(['role_id' => $this->roleId('admin')]);
        $this->assertSame('admin', $user->roleName());
    }

    public function test_role_name_returns_null_when_role_id_is_null(): void
    {
        $user = User::factory()->create(['role_id' => null]);
        $this->assertNull($user->roleName());
    }

    public function test_dashboard_route_returns_correct_route_for_each_role(): void
    {
        $cases = [
            'admin'      => 'admin.dashboard',
            'maker'      => 'dashboard',
            'reviewer'   => 'reviewer',
            'accountant' => 'accountant.approval',
        ];

        foreach ($cases as $roleName => $expectedRoute) {
            $user = User::factory()->create(['role_id' => $this->roleId($roleName)]);
            $this->assertSame($expectedRoute, $user->dashboardRoute(), "Failed for role: {$roleName}");
        }
    }

    public function test_dashboard_route_returns_dashboard_when_no_role(): void
    {
        $user = User::factory()->create(['role_id' => null]);
        $this->assertSame('dashboard', $user->dashboardRoute());
    }
}
```

- [ ] **Step 2: Run the tests to confirm they fail**

```bash
php artisan test tests/Unit/UserRoleHelpersTest.php
```

Expected: FAIL — `roleName` and `dashboardRoute` methods do not exist yet.

- [ ] **Step 3: Add methods to User model**

Replace the full contents of `app/Models/User.php` with:

```php
<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'email',
        'password',
        'phone_number',
        'address',
        'position',
        'status',
        'profile_picture',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roleName(): ?string
    {
        if (empty($this->role_id)) {
            return null;
        }
        $name = DB::table('roles')->where('id', $this->role_id)->value('name');
        return $name ? strtolower($name) : null;
    }

    public function dashboardRoute(): string
    {
        return match ($this->roleName()) {
            'admin'      => 'admin.dashboard',
            'maker'      => 'dashboard',
            'reviewer'   => 'reviewer',
            'accountant' => 'accountant.approval',
            default      => 'dashboard',
        };
    }
}
```

- [ ] **Step 4: Run the tests to confirm they pass**

```bash
php artisan test tests/Unit/UserRoleHelpersTest.php
```

Expected: PASS — all 4 tests green.

- [ ] **Step 5: Commit**

```bash
git add app/Models/User.php tests/Unit/UserRoleHelpersTest.php
git commit -m "Add roleName and dashboardRoute helpers to User model"
```

---

## Task 2: Refactor RequireRole Middleware

**Files:**
- Modify: `app/Http/Middleware/RequireRole.php`
- Create: `tests/Feature/RequireRoleMiddlewareTest.php`

- [ ] **Step 1: Create the feature test**

Create `tests/Feature/RequireRoleMiddlewareTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RequireRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role): User
    {
        $roleId = DB::table('roles')->where('name', $role)->value('id');
        return User::factory()->create([
            'role_id' => $roleId,
            'status'  => 'active',
        ]);
    }

    public function test_reviewer_hitting_admin_route_is_redirected_to_reviewer_dashboard(): void
    {
        $reviewer = $this->userWithRole('reviewer');

        $this->actingAs($reviewer)
            ->get('/admin')
            ->assertRedirect(route('reviewer'));
    }

    public function test_maker_hitting_admin_route_is_redirected_to_maker_dashboard(): void
    {
        $maker = $this->userWithRole('maker');

        $this->actingAs($maker)
            ->get('/admin')
            ->assertRedirect(route('dashboard'));
    }

    public function test_accountant_hitting_admin_route_is_redirected_to_accountant_dashboard(): void
    {
        $accountant = $this->userWithRole('accountant');

        $this->actingAs($accountant)
            ->get('/admin')
            ->assertRedirect(route('accountant.approval'));
    }

    public function test_admin_can_access_admin_route(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)
            ->get('/admin')
            ->assertStatus(200);
    }
}
```

- [ ] **Step 2: Run to confirm tests fail**

```bash
php artisan test tests/Feature/RequireRoleMiddlewareTest.php
```

Expected: FAIL — redirect currently goes to `route('dashboard')` for all roles, not each role's own route.

- [ ] **Step 3: Refactor RequireRole middleware**

Replace the full contents of `app/Http/Middleware/RequireRole.php` with:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        if (strtolower($role) !== $user->roleName()) {
            $previous = url()->previous();
            $currentUrl = url()->full();
            if ($previous && $previous !== $currentUrl) {
                return redirect()->to($previous)->with('error', 'Unauthorized access.');
            }
            return redirect()->route($user->dashboardRoute())->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
```

- [ ] **Step 4: Run tests to confirm they pass**

```bash
php artisan test tests/Feature/RequireRoleMiddlewareTest.php
```

Expected: PASS — each role redirects to its own dashboard.

- [ ] **Step 5: Commit**

```bash
git add app/Http/Middleware/RequireRole.php tests/Feature/RequireRoleMiddlewareTest.php
git commit -m "Refactor RequireRole middleware to use User helpers and fix unauthorized redirect"
```

---

## Task 3: Refactor LoginController

**Files:**
- Modify: `app/Http/Controllers/LoginController.php`
- Create: `tests/Feature/LoginRedirectTest.php`

- [ ] **Step 1: Create the feature test**

Create `tests/Feature/LoginRedirectTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role, string $password = 'password'): User
    {
        $roleId = DB::table('roles')->where('name', $role)->value('id');
        return User::factory()->create([
            'role_id'  => $roleId,
            'password' => bcrypt($password),
            'status'   => 'active',
        ]);
    }

    private function attemptLogin(User $user, string $password = 'password')
    {
        return $this->post('/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);
    }

    public function test_admin_is_redirected_to_admin_dashboard_after_login(): void
    {
        $user = $this->userWithRole('admin');
        $this->attemptLogin($user)->assertRedirect(route('admin.dashboard'));
    }

    public function test_maker_is_redirected_to_maker_dashboard_after_login(): void
    {
        $user = $this->userWithRole('maker');
        $this->attemptLogin($user)->assertRedirect(route('dashboard'));
    }

    public function test_reviewer_is_redirected_to_reviewer_dashboard_after_login(): void
    {
        $user = $this->userWithRole('reviewer');
        $this->attemptLogin($user)->assertRedirect(route('reviewer'));
    }

    public function test_accountant_is_redirected_to_accountant_dashboard_after_login(): void
    {
        $user = $this->userWithRole('accountant');
        $this->attemptLogin($user)->assertRedirect(route('accountant.approval'));
    }

    public function test_wrong_password_does_not_redirect_to_dashboard(): void
    {
        $user = $this->userWithRole('admin');
        $this->attemptLogin($user, 'wrongpassword')->assertRedirect('/login');
    }
}
```

- [ ] **Step 2: Run to confirm tests fail**

```bash
php artisan test tests/Feature/LoginRedirectTest.php
```

Expected: FAIL — current code uses `DB::table('roles')` inline and `position` fallback instead of `dashboardRoute()`.

- [ ] **Step 3: Refactor LoginController**

Replace the full contents of `app/Http/Controllers/LoginController.php` with:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\AuditLog;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey   = Str::lower($request->input('email')).'|'.$request->ip();
        $maxAttempts   = 5;
        $decaySeconds  = 60 * 5;

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = (int) ceil($seconds / 60);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$minutes} minute(s).",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            try {
                AuditLog::create([
                    'user_id'     => $user->id,
                    'action'      => 'login',
                    'description' => 'User logged in',
                    'ip_address'  => $request->ip(),
                ]);
            } catch (\Throwable $e) { /* silent */ }

            return redirect()->intended(route($user->dashboardRoute()));
        }

        RateLimiter::hit($throttleKey, $decaySeconds);
        $attemptsLeft = $maxAttempts - RateLimiter::attempts($throttleKey);

        $message = 'The provided credentials do not match our records.';
        if ($attemptsLeft > 0) {
            $message .= " You have {$attemptsLeft} attempt(s) remaining.";
        } else {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = (int) ceil($seconds / 60);
            $message = "Too many login attempts. Please try again in {$minutes} minute(s).";
        }

        return back()->withErrors(['email' => $message])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        try {
            if ($user) {
                AuditLog::create([
                    'user_id'     => $user->id,
                    'action'      => 'logout',
                    'description' => 'User logged out',
                    'ip_address'  => $request->ip(),
                ]);
            }
        } catch (\Throwable $e) { /* ignore */ }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function showOtpForm()
    {
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $userId   = session('pending_login_user');
        $remember = session('pending_login_remember', false);

        if (! $userId) {
            return redirect()->route('login')->with('error', 'No pending login found.');
        }

        $cached = Cache::get('login_otp_'.$userId);
        if (! $cached || $cached !== $data['otp']) {
            return back()->withErrors(['otp' => 'Invalid or expired code.'])->withInput();
        }

        Cache::forget('login_otp_'.$userId);
        session()->forget(['pending_login_user', 'pending_login_remember']);

        Auth::loginUsingId($userId, $remember);

        $user = Auth::user();

        try {
            AuditLog::create([
                'user_id'     => $user->id,
                'action'      => 'login',
                'description' => 'User logged in (OTP)',
                'ip_address'  => $request->ip(),
            ]);
        } catch (\Throwable $e) { /* silent */ }

        return redirect()->intended(route($user->dashboardRoute()));
    }
}
```

- [ ] **Step 4: Run tests to confirm they pass**

```bash
php artisan test tests/Feature/LoginRedirectTest.php
```

Expected: PASS — all 5 tests green.

- [ ] **Step 5: Run all tests to check for regressions**

```bash
php artisan test
```

Expected: All tests pass.

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/LoginController.php tests/Feature/LoginRedirectTest.php
git commit -m "Refactor LoginController to use dashboardRoute, remove DB dependency"
```

---

## Task 4: Register @role Blade Directive

**Files:**
- Modify: `app/Providers/AppServiceProvider.php`

- [ ] **Step 1: Add the Blade directives to AppServiceProvider**

Replace the full contents of `app/Providers/AppServiceProvider.php` with:

```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            if (! $user) {
                $view->with('notif_data', []);
                return;
            }
            $notifications = $user->notifications()->latest()->take(20)->get();
            $notif_data = $notifications->map(function ($n) {
                $d = $n->data ?? [];
                return [
                    'id'     => $n->id,
                    'icon'   => $d['icon'] ?? 'bi-bell',
                    'cls'    => $d['cls'] ?? 'ni-gold',
                    'text'   => $d['message'] ?? ($d['text'] ?? ''),
                    'time'   => $d['time'] ?? ($n->created_at ? $n->created_at->diffForHumans() : ''),
                    'ts'     => $n->created_at ? $n->created_at->toIso8601String() : null,
                    'unread' => $n->read_at ? false : true,
                    'data'   => $d,
                ];
            })->toArray();
            $view->with('notif_data', $notif_data);
        });

        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->roleName() === {$expression}): ?>";
        });

        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });
    }
}
```

- [ ] **Step 2: Run all tests to confirm nothing broke**

```bash
php artisan test
```

Expected: All tests pass.

- [ ] **Step 3: Manually verify the directive compiles correctly**

```bash
php artisan tinker --execute="echo Blade::compileString(\"@role('admin')hello@endrole\");"
```

Expected output contains:
```
<?php if(auth()->check() && auth()->user()->roleName() === 'admin'): ?>hello<?php endif; ?>
```

- [ ] **Step 4: Commit**

```bash
git add app/Providers/AppServiceProvider.php
git commit -m "Register @role and @endrole Blade directives"
```

---

## Task 5: Push to Remote

- [ ] **Step 1: Push all commits**

```bash
git push origin master
git push origin master:main
```

- [ ] **Step 2: Verify on GitHub**

Confirm all 4 new commits appear on both `master` and `main` branches at `https://github.com/jestonibesteves-eng/cashierdemo`.
