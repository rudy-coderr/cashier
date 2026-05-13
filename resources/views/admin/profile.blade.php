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

    /* TOP STRIPE */
    .top-stripe {
      height: 4px;
      background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red));
    }

    /* HEADER */
    .page-header {
      background: var(--green-deep);
      padding: 14px 28px;
      display: flex;
      align-items: center;
      gap: 12px;
      position: sticky;
      top: 0;
      z-index: 200;
    }

    .header-seal {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: var(--gold);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem; flex-shrink: 0;
    }

    .header-text .t1 {
      font-size: .55rem; letter-spacing: 2px;
      text-transform: uppercase;
      color: rgba(245,240,232,.35); font-weight: 300;
    }

    .header-text .t2 {
      font-size: .82rem; font-weight: 600; color: var(--cream);
    }

    .header-sep {
      width: 1px; height: 28px;
      background: rgba(245,240,232,.15); margin: 0 4px;
    }

    .header-page {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; font-weight: 700; color: var(--gold-light);
    }

    .header-actions { margin-left: auto; }

    .btn-logout {
      display: flex; align-items: center; gap: 6px;
      padding: 7px 14px;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      border: none; border-radius: var(--radius-sm);
      color: var(--green-deep);
      font-family: 'DM Sans', sans-serif;
      font-weight: 700; font-size: .73rem; cursor: pointer;
      transition: all .18s ease;
    }

    .btn-logout:hover {
      background: linear-gradient(135deg, #d6a73b, #f0cf7b);
      transform: translateY(-1px);
    }

    /* LAYOUT */
    .outer-wrapper {
      display: flex;
      min-height: calc(100vh - 68px);
    }

    /* SIDEBAR */
    .sidebar {
      width: 240px; flex-shrink: 0;
      background: var(--green-deep);
      border-right: 1px solid rgba(255,255,255,.07);
      position: sticky; top: 68px;
      height: calc(100vh - 68px);
      display: flex; flex-direction: column;
    }

    .sidebar-inner { flex: 1; padding: 20px 0; overflow-y: auto; }
    .sidebar-inner::-webkit-scrollbar { width: 3px; }
    .sidebar-inner::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }

    .sidebar-profile {
      padding: 0 18px 18px;
      display: flex; align-items: center; gap: 10px;
    }

    .profile-avatar {
      width: 38px; height: 38px; border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      display: flex; align-items: center; justify-content: center;
      font-size: .82rem; font-weight: 700; color: var(--green-deep); flex-shrink: 0;
    }

    .profile-name { font-size: .8rem; font-weight: 600; color: var(--cream); }
    .profile-role {
      font-size: .6rem; color: rgba(245,240,232,.35);
      letter-spacing: 1px; text-transform: uppercase; margin-top: 2px;
    }

    .sidebar-divider {
      border: none; border-top: 1px solid rgba(255,255,255,.07);
      margin: 0 18px 14px;
    }

    .nav-section-label {
      padding: 0 18px;
      font-size: .58rem; font-weight: 700; letter-spacing: 2px;
      text-transform: uppercase; color: rgba(245,240,232,.28);
      margin-bottom: 4px; margin-top: 10px;
    }

    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 9px 18px; cursor: pointer;
      border-left: 3px solid transparent;
      text-decoration: none; transition: background .15s;
    }

    .nav-item:hover { background: rgba(255,255,255,.04); }

    .nav-item.active {
      background: rgba(45,122,79,.18);
      border-left-color: var(--gold);
    }

    .nav-icon {
      width: 30px; height: 30px; border-radius: var(--radius-sm);
      display: flex; align-items: center; justify-content: center;
      font-size: .85rem; flex-shrink: 0;
    }

    .nav-item:not(.active) .nav-icon { background: rgba(255,255,255,.07); color: rgba(245,240,232,.55); }
    .nav-item.active .nav-icon { background: var(--gold); color: var(--green-deep); }

    .nav-label { font-size: .78rem; font-weight: 600; color: rgba(245,240,232,.7); }
    .nav-item.active .nav-label { color: var(--cream); }

    .sidebar-footer {
      padding: 12px 18px;
      border-top: 1px solid rgba(255,255,255,.07); flex-shrink: 0;
    }

    .sidebar-footer-label { font-size: .58rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.3); margin-bottom: 3px; }
    .sidebar-footer-value { font-size: .7rem; color: rgba(245,240,232,.5); font-weight: 300; }

    /* MAIN */
    .main-content { flex: 1; min-width: 0; }

    .page-body {
      max-width: 780px;
      margin: 0 auto;
      padding: 32px 28px 60px;
    }

    /* ALERT BARS */
    .alert-bar {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 18px; border-radius: var(--radius-sm);
      margin-bottom: 20px; font-size: .84rem; font-weight: 500;
    }

    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }
    .alert-danger  { background: #fdf0ef; color: var(--red); border: 1px solid rgba(160,37,28,.2); }

    /* PAGE TITLE */
    .page-title-row { margin-bottom: 24px; }
    .page-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.55rem; font-weight: 700; color: var(--text-dark);
    }
    .page-sub { font-size: .78rem; color: var(--muted); font-weight: 300; margin-top: 2px; }

    /* PROFILE HERO */
    .profile-hero {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden; margin-bottom: 20px;
    }

    .profile-hero-banner {
      height: 72px;
      background: linear-gradient(135deg, var(--green-mid), var(--green-deep));
      position: relative;
    }

    .profile-hero-banner::after {
      content: ''; position: absolute; inset: 0;
      background: repeating-linear-gradient(45deg,rgba(201,153,42,.04) 0px,rgba(201,153,42,.04) 1px,transparent 1px,transparent 18px);
    }

    .profile-hero-body {
      padding: 0 24px 20px;
      display: flex; align-items: flex-end; gap: 18px; flex-wrap: wrap;
    }

    .profile-hero-avatar {
      width: 72px; height: 72px; border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem; font-weight: 700; color: var(--green-deep);
      border: 4px solid var(--surface);
      margin-top: -36px; flex-shrink: 0;
      position: relative; z-index: 1;
    }

    .profile-hero-info { flex: 1; padding-top: 10px; min-width: 0; }

    .profile-hero-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.3rem; font-weight: 700; color: var(--text-dark);
    }

    .profile-hero-meta {
      display: flex; align-items: center; gap: 12px;
      margin-top: 5px; flex-wrap: wrap;
    }

    .profile-hero-role {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 10px; border-radius: 20px;
      background: var(--green-light); color: var(--green-accent);
      font-size: .68rem; font-weight: 700; border: 1px solid rgba(45,122,79,.15);
    }

    .profile-hero-email {
      font-size: .75rem; color: var(--muted);
      display: flex; align-items: center; gap: 4px;
    }

    .profile-hero-since {
      font-size: .7rem; color: var(--muted);
      padding-top: 12px; align-self: flex-end; flex-shrink: 0;
    }

    /* BIG CARD WITH TABS */
    .profile-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden;
    }

    /* TAB NAV */
    .tab-nav {
      display: flex;
      border-bottom: 1.5px solid var(--border);
      background: var(--surface);
    }

    .tab-btn {
      flex: 1;
      padding: 13px 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: .78rem; font-weight: 600; color: var(--muted);
      background: none; border: none;
      border-bottom: 2.5px solid transparent;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 6px;
      transition: color .15s, border-color .15s;
      margin-bottom: -1.5px;
    }

    .tab-btn:hover { color: var(--text-dark); }
    .tab-btn.active { color: var(--green-accent); border-bottom-color: var(--green-accent); }
    .tab-btn i { font-size: .9rem; }

    /* TAB PANES */
    .tab-pane { display: none; padding: 24px; }
    .tab-pane.active { display: block; }

    /* INFO ROWS */
    .info-row {
      display: flex; justify-content: space-between; align-items: center;
      padding: 10px 0; border-bottom: 1px solid var(--border); gap: 10px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: .68rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; flex-shrink: 0; }
    .info-value { font-size: .8rem; color: var(--text-dark); font-weight: 500; text-align: right; }

    .badge-active {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 2px 9px; border-radius: 20px;
      background: var(--green-light); color: var(--green-accent);
      font-size: .65rem; font-weight: 700;
    }
    .badge-active span { width: 6px; height: 6px; border-radius: 50%; background: var(--green-accent); display: inline-block; }

    /* FORM */
    .form-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-group { display: flex; flex-direction: column; gap: 4px; }
    .form-group.span-2 { grid-column: 1 / -1; }

    .form-label {
      font-size: .67rem; font-weight: 700;
      letter-spacing: .5px; text-transform: uppercase; color: var(--muted);
    }

    .form-control-dar {
      padding: 8px 12px;
      border: 1.5px solid var(--border); border-radius: var(--radius-sm);
      font-family: 'DM Sans', sans-serif; font-size: .8rem;
      color: var(--text-dark); background: #faf8f4;
      outline: none; width: 100%;
      transition: border-color .15s, box-shadow .15s, background .15s;
    }

    .form-control-dar:focus {
      border-color: var(--green-accent);
      box-shadow: 0 0 0 3px rgba(45,122,79,.08);
      background: #fff;
    }

    .form-control-dar[readonly] { background: #f4f1eb; color: var(--muted); cursor: not-allowed; }

    .form-hint { font-size: .65rem; color: var(--muted); margin-top: 2px; }

    .form-section-sep { grid-column: 1/-1; border: none; border-top: 1px dashed var(--border); margin: 4px 0; }
    .form-section-label { grid-column: 1/-1; font-size: .62rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); margin-bottom: -4px; }

    .form-footer {
      display: flex; justify-content: flex-end; gap: 8px;
      padding-top: 16px; border-top: 1px solid var(--border); margin-top: 16px;
    }

    .btn-action {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 8px 16px; border-radius: var(--radius-sm);
      font-size: .76rem; font-weight: 600;
      border: 1.5px solid var(--border);
      background: var(--surface); color: var(--text-mid);
      cursor: pointer; transition: all .15s;
    }

    .btn-action:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }

    .btn-action.btn-primary { background: var(--green-accent); border-color: var(--green-accent); color: #fff; }
    .btn-action.btn-primary:hover { background: var(--green-mid); border-color: var(--green-mid); color: #fff; }

    /* PASSWORD STRENGTH */
    .strength-bar { display: flex; gap: 4px; margin-top: 5px; }
    .strength-seg { flex: 1; height: 3px; border-radius: 3px; background: var(--border); transition: background .2s; }
    .strength-seg.weak   { background: var(--red); }
    .strength-seg.fair   { background: #c2640a; }
    .strength-seg.good   { background: var(--gold); }
    .strength-seg.strong { background: var(--green-accent); }
    .strength-label { font-size: .65rem; color: var(--muted); margin-top: 4px; }

    /* ACTIVITY LOG */
    .activity-item { display: flex; align-items: flex-start; gap: 11px; padding: 11px 0; border-bottom: 1px solid var(--border); }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot { width: 30px; height: 30px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; }
    .activity-dot.ad-green { background: var(--green-light); color: var(--green-accent); }
    .activity-dot.ad-blue  { background: #eef3fc; color: #2a5fa0; }
    .activity-dot.ad-amber { background: #fff7ed; color: #c2640a; }
    .activity-dot.ad-red   { background: #fdf0ef; color: var(--red); }
    .activity-text { flex: 1; min-width: 0; }
    .activity-desc { font-size: .78rem; color: var(--text-dark); font-weight: 500; }
    .activity-time { font-size: .68rem; color: var(--muted); margin-top: 2px; }
    .activity-empty { text-align: center; padding: 28px 0; color: var(--muted); font-style: italic; font-size: .8rem; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }
      .sidebar { width: 100%; height: auto; position: static; }
      .sidebar-profile, .sidebar-divider, .nav-section-label, .sidebar-footer { display: none; }
      .sidebar-inner { display: flex; overflow-x: auto; padding: 8px 0; }
      .nav-item { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
      .nav-item.active { border-bottom-color: var(--gold); }
      .page-body { padding: 20px 16px 48px; }
      .tab-nav { overflow-x: auto; }
      .tab-btn { white-space: nowrap; font-size: .72rem; padding: 11px 10px; }
      .form-grid { grid-template-columns: 1fr; }
      .form-group.span-2 { grid-column: auto; }
      .form-section-label, .form-section-sep { grid-column: auto; }
    }
  </style>
</head>
<body>

    @php
      $user = $user ?? auth()->user();
    @endphp

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
        <a class="nav-item " href="{{ route('admin.dashboard') }}">
          <div class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></div>
          <span class="nav-label">Dashboard</span>
        </a>

        <div class="nav-section-label" style="margin-top:16px;">Management</div>
        <a class="nav-item" href="{{ route('admin.users') }}">
          <div class="nav-icon"><i class="bi bi-people-fill"></i></div>
          <span class="nav-label">Users</span>
        </a>
        <a class="nav-item active" href="{{ route('profile') }}">
          <div class="nav-icon"><i class="bi bi-person-circle"></i></div>
          <span class="nav-label">My Profile</span>
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

      </div>

      <div class="sidebar-footer">
        <div class="sidebar-footer-label">System</div>
        <div class="sidebar-footer-value">DAR Cashier — Regional Office V</div>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <div class="page-body">

        @if(session('success'))
          <div class="alert-bar alert-success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
          </div>
        @endif
        @if(session('error'))
          <div class="alert-bar alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
          </div>
        @endif
        @if($errors->any())
          <div class="alert-bar alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i> Please fix the errors below before saving.
          </div>
        @endif

        <!-- PAGE TITLE -->
        <div class="page-title-row">
          <div class="page-title">My Profile</div>
          <div class="page-sub">Manage your account information and security settings</div>
        </div>

        <!-- PROFILE HERO -->
        @php
          if (!isset($initials) || !isset($fullName)) {
            $authUser = auth()->user();
            $u = $user ?? $authUser ?? null;

            if (!isset($initials)) {
              $initials = 'AD';
              if ($u) {
                $nameStr = trim((($u->first_name ?? '') . ' ' . ($u->last_name ?? '')) ?: ($u->name ?? ''));
                if (!$nameStr) { $nameStr = $u->name ?? ''; }
                if ($nameStr) {
                  $parts = preg_split('/\s+/', $nameStr);
                  if (count($parts) >= 2) {
                    $initials = strtoupper(substr($parts[0],0,1) . substr($parts[count($parts)-1],0,1));
                  } else {
                    $initials = strtoupper(substr($nameStr,0,1));
                  }
                }
              }
            }

            if (!isset($fullName)) {
              if ($u) {
                $fn = trim(($u->first_name ?? '') . ' ' . ($u->middle_name ?? '') . ' ' . ($u->last_name ?? ''));
                $fn = preg_replace('/\s+/', ' ', trim($fn));
                if (!$fn) { $fn = $u->name ?? 'Administrator'; }
                $fullName = $fn;
              } else {
                $fullName = 'Administrator';
              }
            }
          }
        @endphp
        <div class="profile-hero">
          <div class="profile-hero-banner"></div>
          <div class="profile-hero-body">
            <div class="profile-hero-avatar">
              @if(!empty($user->profile_picture) && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_picture))
                <img src="{{ asset('storage/'.$user->profile_picture) }}" alt="Avatar" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:4px solid var(--surface);" />
              @else
                {{ $initials ?: 'AD' }}
              @endif
            </div>
            <div class="profile-hero-info">
              <div class="profile-hero-name">{{ $fullName }}</div>
              <div class="profile-hero-meta">
                <span class="profile-hero-role">
                  <i class="bi bi-shield-fill-check"></i>
                  {{ ucfirst($user->position ?? $user->role ?? 'Administrator') }}
                </span>
                <span class="profile-hero-email">
                  <i class="bi bi-envelope"></i> {{ $user->email ?? '—' }}
                </span>
              </div>
            </div>
            <div class="profile-hero-since">
              <i class="bi bi-clock"></i>
              Member since {{ optional($user->created_at)->format('M Y') }}
            </div>
          </div>
        </div>

        <!-- SINGLE PROFILE CARD WITH TABS -->
        <div class="profile-card">

          <!-- TAB NAVIGATION -->
          <div class="tab-nav">
            <button class="tab-btn active" onclick="switchTab('details', this)" type="button">
              <i class="bi bi-info-circle-fill"></i> Account Details
            </button>
            <button class="tab-btn" onclick="switchTab('personal', this)" type="button">
              <i class="bi bi-person-lines-fill"></i> Personal Info
            </button>
            <button class="tab-btn" onclick="switchTab('password', this)" type="button">
              <i class="bi bi-shield-lock-fill"></i> Password
            </button>
            <button class="tab-btn" onclick="switchTab('activity', this)" type="button">
              <i class="bi bi-activity"></i> Activity
            </button>
          </div>

          <!-- TAB: ACCOUNT DETAILS -->
          <div class="tab-pane active" id="tab-details">
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
                <span class="badge-active"><span></span> Active</span>
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

          <!-- TAB: PERSONAL INFORMATION -->
          <div class="tab-pane" id="tab-personal">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="form-grid">

                <div class="form-group">
                  <label class="form-label">First Name</label>
                  <input type="text" name="first_name" class="form-control-dar"
                    value="{{ old('first_name', $user->first_name ?? '') }}" placeholder="First name">
                  @error('first_name')
                    <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label class="form-label">Last Name</label>
                  <input type="text" name="last_name" class="form-control-dar"
                    value="{{ old('last_name', $user->last_name ?? '') }}" placeholder="Last name">
                  @error('last_name')
                    <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label class="form-label">Middle Name</label>
                  <input type="text" name="middle_name" class="form-control-dar"
                    value="{{ old('middle_name', $user->middle_name ?? '') }}" placeholder="Middle name (optional)">
                </div>

                <div class="form-group">
                  <label class="form-label">Position / Role</label>
                  <input type="text" name="position" class="form-control-dar"
                    value="{{ old('position', $user->position ?? '') }}" placeholder="e.g. Cashier">
                </div>

                <hr class="form-section-sep">
                <div class="form-section-label">Contact</div>

                <div class="form-group span-2">
                  <label class="form-label">Email Address</label>
                  <input type="email" name="email" class="form-control-dar"
                    value="{{ old('email', $user->email ?? '') }}" placeholder="email@dar.gov.ph">
                  @error('email')
                    <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group span-2">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" class="form-control-dar"
                    value="{{ old('username', $user->username ?? '') }}" placeholder="username">
                  @error('username')
                    <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group span-2">
                  <label class="form-label">Profile Avatar</label>
                  <input type="file" name="profile_picture" accept="image/*" class="form-control-dar" />
                  <span class="form-hint">Upload a square image for best results. Max 2MB.</span>
                  @error('profile_picture')
                    <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                  @enderror
                </div>

              </div>
              <div class="form-footer">
                <button type="reset" class="btn-action">
                  <i class="bi bi-x-lg"></i> Cancel
                </button>
                <button type="submit" class="btn-action btn-primary">
                  <i class="bi bi-check-lg"></i> Save Changes
                </button>
              </div>
            </form>
          </div>

          <!-- TAB: CHANGE PASSWORD -->
          <div class="tab-pane" id="tab-password">
            <form method="POST" action="{{ route('profile.password') }}">
              @csrf
              @method('PATCH')
              <div class="form-grid">

                <div class="form-group span-2">
                  <label class="form-label">Current Password</label>
                  <input type="password" name="current_password" class="form-control-dar"
                    placeholder="Enter your current password" autocomplete="current-password">
                  @error('current_password')
                    <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label class="form-label">New Password</label>
                  <input type="password" name="password" id="new-password" class="form-control-dar"
                    placeholder="New password" autocomplete="new-password">
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
                  <input type="password" name="password_confirmation" class="form-control-dar"
                    placeholder="Repeat new password" autocomplete="new-password">
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

          <!-- TAB: RECENT ACTIVITY -->
          <div class="tab-pane" id="tab-activity">
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
              <div class="activity-empty">
                <i class="bi bi-clock-history" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                No recent activity recorded.
              </div>
            @endforelse
          </div>

        </div><!-- /.profile-card -->

      </div><!-- /.page-body -->
    </main>

  </div><!-- /.outer-wrapper -->

  <script>
    // Tab switcher
    function switchTab(id, btn) {
      document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.getElementById('tab-' + id).classList.add('active');
      btn.classList.add('active');
    }

    // Open the correct tab if there are validation errors
    @if($errors->hasAny(['first_name','last_name','email','username','middle_name','position']))
      switchTab('personal', document.querySelectorAll('.tab-btn')[1]);
    @elseif($errors->hasAny(['current_password','password']))
      switchTab('password', document.querySelectorAll('.tab-btn')[2]);
    @endif

    // Password strength meter
    const pwInput     = document.getElementById('new-password');
    const segs        = [1,2,3,4].map(i => document.getElementById('seg' + i));
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
        strengthTxt.textContent = pwInput.value ? (labels[score] || 'Enter a password') : 'Enter a password';
        strengthTxt.style.color = score <= 1 ? 'var(--red)' : score === 2 ? '#c2640a' : score === 3 ? 'var(--gold)' : 'var(--green-accent)';
      });
    }
  </script>

</body>
</html>