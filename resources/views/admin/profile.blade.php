<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile — DAR Cashier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    /* ════════════════════════════════════════════
       VARIABLES & RESET
    ════════════════════════════════════════════ */
    :root {
      --green-deep:   #0e2a1a;
      --green-mid:    #1a4a2e;
      --green-accent: #2d7a4f;
      --green-light:  #e8f4ee;
      --gold:         #c9992a;
      --gold-light:   #e8c46a;
      --cream:        #f5f0e8;
      --border:       #e2ddd5;
      --text-dark:    #0e2a1a;
      --text-mid:     #3d5045;
      --muted:        #8a9e90;
      --bg:           #f4f1eb;
      --surface:      #ffffff;
      --red:          #a0251c;
      --radius-sm:    8px;
      --radius-md:    12px;
      --radius-lg:    14px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      color: var(--text-dark);
    }

    /* ════════════════════════════════════════════
       TOP STRIPE
    ════════════════════════════════════════════ */
    .top-stripe {
      height: 4px;
      background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red));
    }

    /* ════════════════════════════════════════════
       HEADER
    ════════════════════════════════════════════ */
    .page-header {
      background: var(--green-deep);
      padding: 16px 32px;
      display: flex;
      align-items: center;
      gap: 14px;
      position: sticky;
      top: 0;
      z-index: 200;
    }

    .header-seal {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: var(--gold);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      flex-shrink: 0;
    }

    .header-text .t1 {
      font-size: .58rem;
      letter-spacing: 2.5px;
      text-transform: uppercase;
      color: rgba(245,240,232,.35);
      font-weight: 300;
    }

    .header-text .t2 {
      font-size: .85rem;
      font-weight: 600;
      color: var(--cream);
    }

    .header-sep {
      width: 1px;
      height: 30px;
      background: rgba(245,240,232,.15);
      margin: 0 4px;
    }

    .header-page {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--gold-light);
    }

    .header-actions {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .btn-logout {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      border: 1px solid rgba(201,153,42,.35);
      border-radius: var(--radius-sm);
      color: var(--green-deep);
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: .75rem;
      letter-spacing: .5px;
      cursor: pointer;
      transition: all .18s ease;
      box-shadow: 0 2px 6px rgba(0,0,0,.08);
    }

    .btn-logout:hover {
      background: linear-gradient(135deg, #d6a73b, #f0cf7b);
      transform: translateY(-1px);
    }

    /* ════════════════════════════════════════════
       LAYOUT
    ════════════════════════════════════════════ */
    .outer-wrapper {
      display: flex;
      min-height: calc(100vh - 72px);
    }

    /* ════════════════════════════════════════════
       SIDEBAR
    ════════════════════════════════════════════ */
    .sidebar {
      width: 260px;
      flex-shrink: 0;
      background: var(--green-deep);
      border-right: 1px solid rgba(255,255,255,.07);
      position: sticky;
      top: 72px;
      height: calc(100vh - 72px);
      display: flex;
      flex-direction: column;
    }

    .sidebar-inner {
      flex: 1;
      overflow-y: auto;
      padding: 24px 0 0;
    }

    .sidebar-inner::-webkit-scrollbar { width: 3px; }
    .sidebar-inner::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,.12);
      border-radius: 4px;
    }

    .sidebar-profile {
      padding: 0 22px 20px;
      display: flex;
      align-items: center;
      gap: 11px;
    }

    .profile-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .85rem;
      font-weight: 700;
      color: var(--green-deep);
      flex-shrink: 0;
    }

    .profile-name {
      font-size: .83rem;
      font-weight: 600;
      color: var(--cream);
    }

    .profile-role {
      font-size: .63rem;
      color: rgba(245,240,232,.35);
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-top: 2px;
    }

    .sidebar-divider {
      border: none;
      border-top: 1px solid rgba(255,255,255,.07);
      margin: 0 22px 16px;
    }

    .nav-section-label {
      padding: 0 22px;
      font-size: .6rem;
      font-weight: 700;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: rgba(245,240,232,.28);
      margin-bottom: 6px;
      margin-top: 12px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 10px 22px;
      cursor: pointer;
      transition: background .15s;
      border-left: 3px solid transparent;
      text-decoration: none;
    }

    .nav-item:hover { background: rgba(255,255,255,.04); }

    .nav-item.active {
      background: rgba(45,122,79,.18);
      border-left-color: var(--gold);
    }

    .nav-icon {
      width: 32px;
      height: 32px;
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .88rem;
      flex-shrink: 0;
      transition: background .15s, color .15s;
    }

    .nav-item:not(.active) .nav-icon {
      background: rgba(255,255,255,.07);
      color: rgba(245,240,232,.55);
    }

    .nav-item.active .nav-icon {
      background: var(--gold);
      color: var(--green-deep);
    }

    .nav-label {
      font-size: .81rem;
      font-weight: 600;
      color: rgba(245,240,232,.7);
    }

    .nav-item.active .nav-label { color: var(--cream); }

    .sidebar-footer {
      padding: 14px 22px;
      border-top: 1px solid rgba(255,255,255,.07);
      flex-shrink: 0;
    }

    .sidebar-footer-label {
      font-size: .6rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: rgba(245,240,232,.3);
      margin-bottom: 4px;
    }

    .sidebar-footer-value {
      font-size: .73rem;
      color: rgba(245,240,232,.5);
      font-weight: 300;
    }

    /* ════════════════════════════════════════════
       MAIN CONTENT
    ════════════════════════════════════════════ */
    .main-content { flex: 1; min-width: 0; }

    .page-body {
      max-width: 900px;
      margin: 0 auto;
      padding: 36px 28px 60px;
    }

    /* ════════════════════════════════════════════
       PAGE TITLE ROW
    ════════════════════════════════════════════ */
    .page-title-row {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      margin-bottom: 28px;
      gap: 16px;
      flex-wrap: wrap;
    }

    .page-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.7rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 3px;
    }

    .page-sub {
      font-size: .8rem;
      color: var(--muted);
      font-weight: 300;
    }

    /* ════════════════════════════════════════════
       ALERT BARS
    ════════════════════════════════════════════ */
    .alert-bar {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 18px;
      border-radius: var(--radius-sm);
      margin-bottom: 20px;
      font-size: .84rem;
      font-weight: 500;
    }

    .alert-success {
      background: var(--green-light);
      color: var(--green-accent);
      border: 1px solid rgba(45,122,79,.2);
    }

    .alert-danger {
      background: #fdf0ef;
      color: var(--red);
      border: 1px solid rgba(160,37,28,.2);
    }

    /* ════════════════════════════════════════════
       ACTION BUTTONS
    ════════════════════════════════════════════ */
    .btn-action {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      border-radius: var(--radius-sm);
      font-size: .76rem;
      font-weight: 600;
      border: 1.5px solid var(--border);
      background: var(--surface);
      color: var(--text-mid);
      cursor: pointer;
      transition: all .15s;
      text-decoration: none;
      white-space: nowrap;
    }

    .btn-action:hover {
      background: var(--green-light);
      border-color: var(--green-accent);
      color: var(--green-accent);
    }

    .btn-action.btn-primary {
      background: var(--green-accent);
      border-color: var(--green-accent);
      color: #fff;
    }

    .btn-action.btn-primary:hover {
      background: var(--green-mid);
      border-color: var(--green-mid);
      color: #fff;
    }

    .btn-action.btn-danger {
      background: #fdf0ef;
      border-color: rgba(160,37,28,.25);
      color: var(--red);
    }

    .btn-action.btn-danger:hover {
      background: var(--red);
      border-color: var(--red);
      color: #fff;
    }

    /* ════════════════════════════════════════════
       PROFILE HERO CARD
    ════════════════════════════════════════════ */
    .profile-hero {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden;
      margin-bottom: 20px;
    }

    .profile-hero-banner {
      height: 80px;
      background: linear-gradient(135deg, var(--green-mid), var(--green-deep));
      position: relative;
    }

    .profile-hero-banner::after {
      content: '';
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(
        45deg,
        rgba(201,153,42,.04) 0px,
        rgba(201,153,42,.04) 1px,
        transparent 1px,
        transparent 18px
      );
    }

    .profile-hero-body {
      padding: 0 28px 24px;
      display: flex;
      align-items: flex-end;
      gap: 20px;
      flex-wrap: wrap;
    }

    .profile-hero-avatar {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.7rem;
      font-weight: 700;
      color: var(--green-deep);
      border: 4px solid var(--surface);
      margin-top: -40px;
      flex-shrink: 0;
      position: relative;
      z-index: 1;
    }

    .profile-hero-info {
      flex: 1;
      padding-top: 12px;
      min-width: 0;
    }

    .profile-hero-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--text-dark);
      line-height: 1.2;
    }

    .profile-hero-meta {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-top: 5px;
      flex-wrap: wrap;
    }

    .profile-hero-role {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 10px;
      border-radius: 20px;
      background: var(--green-light);
      color: var(--green-accent);
      font-size: .7rem;
      font-weight: 700;
      border: 1px solid rgba(45,122,79,.15);
    }

    .profile-hero-email {
      font-size: .78rem;
      color: var(--muted);
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .profile-hero-actions {
      display: flex;
      gap: 8px;
      padding-top: 12px;
      align-items: center;
      flex-shrink: 0;
    }

    /* ════════════════════════════════════════════
       TWO-COLUMN GRID
    ════════════════════════════════════════════ */
    .profile-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .profile-grid.full { grid-template-columns: 1fr; }

    /* ════════════════════════════════════════════
       DASH CARD (shared)
    ════════════════════════════════════════════ */
    .dash-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden;
      margin-bottom: 20px;
    }

    .dash-card-head {
      padding: 14px 20px;
      background: linear-gradient(90deg, var(--green-mid), var(--green-deep));
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
    }

    .dash-card-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: .95rem;
      font-weight: 700;
      color: var(--gold-light);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .dash-card-body { padding: 24px; }

    /* ════════════════════════════════════════════
       FORM FIELDS
    ════════════════════════════════════════════ */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .form-grid.full-col { grid-template-columns: 1fr; }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .form-group.span-2 { grid-column: 1 / -1; }

    .form-label {
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .5px;
      text-transform: uppercase;
      color: var(--muted);
    }

    .form-control-dar {
      padding: 9px 13px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      font-family: 'DM Sans', sans-serif;
      font-size: .82rem;
      color: var(--text-dark);
      background: #faf8f4;
      outline: none;
      transition: border-color .15s, box-shadow .15s, background .15s;
      width: 100%;
    }

    .form-control-dar:focus {
      border-color: var(--green-accent);
      box-shadow: 0 0 0 3px rgba(45,122,79,.08);
      background: #fff;
    }

    .form-control-dar[readonly] {
      background: #f4f1eb;
      color: var(--muted);
      cursor: not-allowed;
    }

    .form-hint {
      font-size: .68rem;
      color: var(--muted);
      margin-top: 2px;
    }

    /* ════════════════════════════════════════════
       FORM SECTION DIVIDER
    ════════════════════════════════════════════ */
    .form-section-sep {
      grid-column: 1 / -1;
      border: none;
      border-top: 1px dashed var(--border);
      margin: 4px 0;
    }

    .form-section-label {
      grid-column: 1 / -1;
      font-size: .65rem;
      font-weight: 700;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: -4px;
    }

    /* ════════════════════════════════════════════
       FORM FOOTER (submit row)
    ════════════════════════════════════════════ */
    .form-footer {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
      margin-top: 20px;
    }

    /* ════════════════════════════════════════════
       INFO ROWS (read-only display)
    ════════════════════════════════════════════ */
    .info-row {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid var(--border);
      gap: 12px;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
      font-size: .72rem;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .5px;
      flex-shrink: 0;
      width: 140px;
    }

    .info-value {
      font-size: .82rem;
      color: var(--text-dark);
      font-weight: 500;
      text-align: right;
      flex: 1;
    }

    /* ════════════════════════════════════════════
       PASSWORD STRENGTH
    ════════════════════════════════════════════ */
    .strength-bar {
      display: flex;
      gap: 4px;
      margin-top: 6px;
    }

    .strength-seg {
      flex: 1;
      height: 3px;
      border-radius: 3px;
      background: var(--border);
      transition: background .2s;
    }

    .strength-seg.weak   { background: var(--red); }
    .strength-seg.fair   { background: #c2640a; }
    .strength-seg.good   { background: var(--gold); }
    .strength-seg.strong { background: var(--green-accent); }

    .strength-label {
      font-size: .67rem;
      color: var(--muted);
      margin-top: 4px;
    }

    /* ════════════════════════════════════════════
       ACTIVITY LOG ITEMS
    ════════════════════════════════════════════ */
    .activity-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 12px 0;
      border-bottom: 1px solid var(--border);
    }

    .activity-item:last-child { border-bottom: none; }

    .activity-dot {
      width: 32px;
      height: 32px;
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .82rem;
      flex-shrink: 0;
      margin-top: 1px;
    }

    .activity-dot.ad-green { background: var(--green-light); color: var(--green-accent); }
    .activity-dot.ad-blue  { background: #eef3fc; color: #2a5fa0; }
    .activity-dot.ad-amber { background: #fff7ed; color: #c2640a; }
    .activity-dot.ad-red   { background: #fdf0ef; color: var(--red); }

    .activity-text {
      flex: 1;
      min-width: 0;
    }

    .activity-desc {
      font-size: .8rem;
      color: var(--text-dark);
      font-weight: 500;
    }

    .activity-time {
      font-size: .7rem;
      color: var(--muted);
      margin-top: 2px;
    }

    /* ════════════════════════════════════════════
       RESPONSIVE
    ════════════════════════════════════════════ */
    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }
      .sidebar { width: 100%; height: auto; position: static; }
      .sidebar-profile, .sidebar-divider, .nav-section-label, .sidebar-footer { display: none; }
      .sidebar-inner { display: flex; overflow-x: auto; padding: 8px 0; }
      .nav-item { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
      .nav-item.active { border-bottom-color: var(--gold); }
      .page-body { padding: 20px 16px 48px; }
      .profile-grid { grid-template-columns: 1fr; }
      .form-grid { grid-template-columns: 1fr; }
      .form-group.span-2 { grid-column: auto; }
      .form-section-label, .form-section-sep { grid-column: auto; }
      .profile-hero-body { flex-direction: column; align-items: flex-start; }
      .profile-hero-actions { width: 100%; }
      .info-label { width: 110px; }
    }
  </style>
</head>
<body>

  <div class="top-stripe"></div>

  <!-- ══ HEADER ══ -->
  <header class="page-header">
    <div class="header-seal">🌾</div>
    <div class="header-text">
      <div class="t1">Republic of the Philippines</div>
      <div class="t2">Department of Agrarian Reform</div>
    </div>
    <div class="header-sep"></div>
    <div class="header-page">Admin Panel</div>
    <div class="header-actions">
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn-logout">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
    </div>
  </header>

  <div class="outer-wrapper">

    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar">
      <div class="sidebar-inner">

        <div class="sidebar-profile">
          <div class="profile-avatar">AD</div>
          <div>
            <div class="profile-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
            <div class="profile-role">Admin</div>
          </div>
        </div>

        <hr class="sidebar-divider">

        <div class="nav-section-label">Main</div>
        <a class="nav-item" href="{{ route('admin.dashboard') }}">
          <div class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></div>
          <span class="nav-label">Dashboard</span>
        </a>

        <div class="nav-section-label" style="margin-top:16px;">Management</div>
        <a class="nav-item" href="{{ route('admin.users') }}">
          <div class="nav-icon"><i class="bi bi-people-fill"></i></div>
          <span class="nav-label">Users</span>
        </a>

        <div class="nav-section-label" style="margin-top:16px;">Monitoring</div>
        <a class="nav-item" href="{{ route('admin.auditlogs') }}">
          <div class="nav-icon"><i class="bi bi-journal-text"></i></div>
          <span class="nav-label">Audit Logs</span>
        </a>
        <a class="nav-item" href="{{ route('admin.history') }}">
          <div class="nav-icon"><i class="bi bi-receipt"></i></div>
          <span class="nav-label">Transaction History</span>
        </a>

        <div class="nav-section-label" style="margin-top:16px;">Account</div>
        <a class="nav-item active" href="{{ route('profile') }}">
          <div class="nav-icon"><i class="bi bi-person-circle"></i></div>
          <span class="nav-label">My Profile</span>
        </a>

      </div>

      <div class="sidebar-footer">
        <div class="sidebar-footer-label">System</div>
        <div class="sidebar-footer-value">DAR Cashier — Regional Office V</div>
      </div>
    </aside>

    <!-- ══ MAIN CONTENT ══ -->
    <main class="main-content">
      <div class="page-body">

        @if(session('success'))
          <div class="alert-bar alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
          </div>
        @endif
        @if(session('error'))
          <div class="alert-bar alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
          </div>
        @endif
        @if($errors->any())
          <div class="alert-bar alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i>
            Please fix the errors below before saving.
          </div>
        @endif

        <!-- Page Title -->
        <div class="page-title-row">
          <div>
            <div class="page-title">My Profile</div>
            <div class="page-sub">Manage your account information and security settings</div>
          </div>
        </div>

        <!-- ══ PROFILE HERO ══ -->
        @php
          $user = auth()->user();
          $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: ($user->name ?? 'Administrator');
          $initials = collect(explode(' ', $fullName))
                        ->filter()
                        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                        ->take(2)
                        ->implode('');
        @endphp

        <div class="profile-hero">
          <div class="profile-hero-banner"></div>
          <div class="profile-hero-body">
            <div class="profile-hero-avatar">{{ $initials ?: 'AD' }}</div>
            <div class="profile-hero-info">
              <div class="profile-hero-name">{{ $fullName }}</div>
              <div class="profile-hero-meta">
                <span class="profile-hero-role">
                  <i class="bi bi-shield-fill-check"></i>
                  {{ ucfirst($user->position ?? $user->role ?? 'Administrator') }}
                </span>
                <span class="profile-hero-email">
                  <i class="bi bi-envelope"></i>
                  {{ $user->email ?? '—' }}
                </span>
              </div>
            </div>
            <div class="profile-hero-actions">
              <span style="font-size:.72rem;color:var(--muted);">
                <i class="bi bi-clock"></i>
                Member since {{ optional($user->created_at)->format('M Y') }}
              </span>
            </div>
          </div>
        </div>

        <!-- ══ TWO COLUMN: Edit Info + Account Details ══ -->
        <div class="profile-grid">

          <!-- Edit Personal Information -->
          <div class="dash-card">
            <div class="dash-card-head">
              <div class="dash-card-title">
                <i class="bi bi-person-lines-fill"></i> Personal Information
              </div>
            </div>
            <div class="dash-card-body">
              <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                <div class="form-grid">

                  <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input
                      type="text"
                      name="first_name"
                      class="form-control-dar"
                      value="{{ old('first_name', $user->first_name ?? '') }}"
                      placeholder="First name"
                    >
                    @error('first_name')
                      <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input
                      type="text"
                      name="last_name"
                      class="form-control-dar"
                      value="{{ old('last_name', $user->last_name ?? '') }}"
                      placeholder="Last name"
                    >
                    @error('last_name')
                      <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label class="form-label">Middle Name</label>
                    <input
                      type="text"
                      name="middle_name"
                      class="form-control-dar"
                      value="{{ old('middle_name', $user->middle_name ?? '') }}"
                      placeholder="Middle name (optional)"
                    >
                  </div>

                  <div class="form-group">
                    <label class="form-label">Position / Role</label>
                    <input
                      type="text"
                      name="position"
                      class="form-control-dar"
                      value="{{ old('position', $user->position ?? '') }}"
                      placeholder="e.g. Cashier"
                    >
                  </div>

                  <hr class="form-section-sep">
                  <div class="form-section-label">Contact</div>

                  <div class="form-group span-2">
                    <label class="form-label">Email Address</label>
                    <input
                      type="email"
                      name="email"
                      class="form-control-dar"
                      value="{{ old('email', $user->email ?? '') }}"
                      placeholder="email@dar.gov.ph"
                    >
                    @error('email')
                      <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group span-2">
                    <label class="form-label">Username</label>
                    <input
                      type="text"
                      name="username"
                      class="form-control-dar"
                      value="{{ old('username', $user->username ?? '') }}"
                      placeholder="username"
                    >
                    @error('username')
                      <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                    @enderror
                  </div>

                </div>

                <div class="form-footer">
                  <button type="submit" class="btn-action btn-primary">
                    <i class="bi bi-check-lg"></i> Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Account Details (read-only) -->
          <div style="display:flex;flex-direction:column;gap:20px;">

            <div class="dash-card" style="margin-bottom:0;">
              <div class="dash-card-head">
                <div class="dash-card-title">
                  <i class="bi bi-info-circle-fill"></i> Account Details
                </div>
              </div>
              <div class="dash-card-body">
                <div class="info-row">
                  <span class="info-label">Account ID</span>
                  <span class="info-value">#{{ str_pad($user->id ?? 0, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Role</span>
                  <span class="info-value">{{ ucfirst($user->position ?? $user->role ?? '—') }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Status</span>
                  <span class="info-value">
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:2px 10px;border-radius:20px;background:var(--green-light);color:var(--green-accent);font-size:.68rem;font-weight:700;">
                      <span style="width:6px;height:6px;border-radius:50%;background:var(--green-accent);display:inline-block;"></span>
                      Active
                    </span>
                  </span>
                </div>
                <div class="info-row">
                  <span class="info-label">Joined</span>
                  <span class="info-value">{{ optional($user->created_at)->format('F d, Y') ?? '—' }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Last Updated</span>
                  <span class="info-value">{{ optional($user->updated_at)->format('F d, Y') ?? '—' }}</span>
                </div>
              </div>
            </div>

          </div>

        </div><!-- /.profile-grid -->

        <!-- ══ CHANGE PASSWORD (full width) ══ -->
        <div class="dash-card">
          <div class="dash-card-head">
            <div class="dash-card-title">
              <i class="bi bi-shield-lock-fill"></i> Change Password
            </div>
          </div>
          <div class="dash-card-body">
            <form method="POST" action="{{ route('profile.password') }}">
              @csrf
              @method('PATCH')
              <div class="form-grid">

                <div class="form-group span-2">
                  <label class="form-label">Current Password</label>
                  <input
                    type="password"
                    name="current_password"
                    class="form-control-dar"
                    placeholder="Enter your current password"
                    autocomplete="current-password"
                  >
                  @error('current_password')
                    <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label class="form-label">New Password</label>
                  <input
                    type="password"
                    name="password"
                    id="new-password"
                    class="form-control-dar"
                    placeholder="New password"
                    autocomplete="new-password"
                  >
                  <div class="strength-bar">
                    <div class="strength-seg" id="seg1"></div>
                    <div class="strength-seg" id="seg2"></div>
                    <div class="strength-seg" id="seg3"></div>
                    <div class="strength-seg" id="seg4"></div>
                  </div>
                  <div class="strength-label" id="strength-text">Enter a password</div>
                  @error('password')
                    <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label class="form-label">Confirm New Password</label>
                  <input
                    type="password"
                    name="password_confirmation"
                    class="form-control-dar"
                    placeholder="Repeat new password"
                    autocomplete="new-password"
                  >
                  <span class="form-hint">Must match the new password above.</span>
                </div>

              </div>

              <div class="form-footer">
                <button type="submit" class="btn-action btn-primary">
                  <i class="bi bi-lock-fill"></i> Update Password
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- ══ RECENT ACTIVITY ══ -->
        <div class="dash-card">
          <div class="dash-card-head">
            <div class="dash-card-title">
              <i class="bi bi-activity"></i> Recent Activity
            </div>
          </div>
          <div class="dash-card-body">
            @forelse($recentActivity ?? [] as $act)
              @php
                $actAction = strtolower($act->action ?? '');
                $dotCls = match(true) {
                  str_contains($actAction, 'login')  => 'ad-green',
                  str_contains($actAction, 'logout') => 'ad-blue',
                  str_contains($actAction, 'update') => 'ad-amber',
                  str_contains($actAction, 'delete') => 'ad-red',
                  default                             => 'ad-blue',
                };
                $dotIcon = match(true) {
                  str_contains($actAction, 'login')  => 'bi-box-arrow-in-right',
                  str_contains($actAction, 'logout') => 'bi-box-arrow-right',
                  str_contains($actAction, 'update') => 'bi-pencil',
                  str_contains($actAction, 'delete') => 'bi-trash',
                  default                             => 'bi-activity',
                };
              @endphp
              <div class="activity-item">
                <div class="activity-dot {{ $dotCls }}">
                  <i class="bi {{ $dotIcon }}"></i>
                </div>
                <div class="activity-text">
                  <div class="activity-desc">{{ $act->description ?? $act->action }}</div>
                  <div class="activity-time">
                    {{ optional($act->created_at)->diffForHumans() }}
                    @if($act->ip_address ?? false)
                      &nbsp;·&nbsp; <span style="font-family:'Courier New',monospace;">{{ $act->ip_address }}</span>
                    @endif
                  </div>
                </div>
              </div>
            @empty
              <div style="padding:24px 0;text-align:center;color:var(--muted);font-style:italic;font-size:.82rem;">
                <i class="bi bi-clock-history" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                No recent activity recorded.
              </div>
            @endforelse
          </div>
        </div>

      </div><!-- /.page-body -->
    </main>

  </div><!-- /.outer-wrapper -->

  <script>
    /* Password strength meter */
    const pwInput   = document.getElementById('new-password');
    const segs      = [1,2,3,4].map(i => document.getElementById('seg' + i));
    const strengthTxt = document.getElementById('strength-text');

    function scorePassword(pw) {
      if (!pw) return 0;
      let score = 0;
      if (pw.length >= 8)  score++;
      if (pw.length >= 12) score++;
      if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
      if (/[0-9]/.test(pw)) score++;
      if (/[^A-Za-z0-9]/.test(pw)) score++;
      return Math.min(score, 4);
    }

    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    const cls    = ['', 'weak', 'fair', 'good', 'strong'];

    if (pwInput) {
      pwInput.addEventListener('input', () => {
        const score = scorePassword(pwInput.value);
        segs.forEach((seg, i) => {
          seg.className = 'strength-seg';
          if (i < score) seg.classList.add(cls[score]);
        });
        strengthTxt.textContent = pwInput.value ? labels[score] || 'Enter a password' : 'Enter a password';
        strengthTxt.style.color = score <= 1 ? 'var(--red)' : score === 2 ? '#c2640a' : score === 3 ? 'var(--gold)' : 'var(--green-accent)';
      });
    }
  </script>

</body>
</html>