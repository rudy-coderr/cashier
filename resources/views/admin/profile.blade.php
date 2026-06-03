<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile — DAR Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="icon" href="{{ asset('img/dar_logo_square.jpg') }}" />
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
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); min-height: 100vh; color: var(--text-dark); }

    /* ── TOP STRIPE ── */
    .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

    /* ── HEADER ── */
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
    .header-seal { width: 38px; height: 38px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
    .header-seal img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
    .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }
    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }

    /* ── HEADER USER DROPDOWN ── */
    .header-user-wrap { position: relative; }
    .header-user {
      display: flex; align-items: center; gap: 10px;
      padding: 6px 12px 6px 8px;
      background: rgba(245,240,232,.07);
      border: 1px solid rgba(245,240,232,.12);
      border-radius: 10px;
      cursor: pointer;
      transition: background .15s, border-color .15s;
      user-select: none;
    }
    .header-user:hover { background: rgba(245,240,232,.13); border-color: rgba(245,240,232,.22); }
    .header-avatar {
      width: 32px; height: 32px; border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      display: flex; align-items: center; justify-content: center;
      font-size: .72rem; font-weight: 700; color: var(--green-deep);
      overflow: hidden; flex-shrink: 0;
      border: 2px solid rgba(201,153,42,.35);
    }
    .header-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
    .header-user-name { font-size: .76rem; font-weight: 600; color: var(--cream); line-height: 1.2; }
    .header-user-role { font-size: .6rem; color: rgba(245,240,232,.4); letter-spacing: .8px; text-transform: uppercase; }
    .header-user-caret { font-size: .65rem; color: rgba(245,240,232,.4); margin-left: 2px; transition: transform .2s; }
    .header-user-wrap.open .header-user-caret { transform: rotate(180deg); }

    /* Dropdown menu */
    .header-dropdown {
      position: absolute; top: calc(100% + 8px); right: 0;
      min-width: 200px;
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 12px;
      box-shadow: 0 8px 28px rgba(14,42,26,.18);
      overflow: hidden;
      opacity: 0; pointer-events: none;
      transform: translateY(-6px);
      transition: opacity .18s ease, transform .18s ease;
      z-index: 300;
    }
    .header-user-wrap.open .header-dropdown { opacity: 1; pointer-events: all; transform: translateY(0); }

    .dropdown-header {
      padding: 14px 16px 10px;
      border-bottom: 1px solid var(--border);
    }
    .dropdown-header-name { font-size: .84rem; font-weight: 700; color: var(--text-dark); }
    .dropdown-header-email { font-size: .72rem; color: var(--muted); margin-top: 2px; }

    .dropdown-item {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 16px;
      font-size: .81rem; font-weight: 600; color: var(--text-mid);
      text-decoration: none; cursor: pointer;
      transition: background .13s;
      border: none; background: none; width: 100%; text-align: left;
      font-family: 'DM Sans', sans-serif;
    }
    .dropdown-item:hover { background: var(--bg); }
    .dropdown-item i { font-size: 1rem; flex-shrink: 0; }
    .dropdown-item.danger { color: var(--red); }
    .dropdown-item.danger:hover { background: #fdf0ef; }
    .dropdown-divider { border: none; border-top: 1px solid var(--border); margin: 4px 0; }

    /* ── LAYOUT ── */
    .outer-wrapper { display: flex; min-height: calc(100vh - 72px); }

    /* ── SIDEBAR ── */
    .sidebar {
      width: 260px; flex-shrink: 0; background: var(--green-deep);
      border-right: 1px solid rgba(255,255,255,.07);
      position: sticky; top: 72px; height: calc(100vh - 72px);
      display: flex; flex-direction: column;
    }
    .sidebar-inner { flex: 1; overflow-y: auto; padding: 24px 0 0; }
    .sidebar-inner::-webkit-scrollbar { width: 3px; }
    .sidebar-inner::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }
    .sidebar-profile { padding: 0 22px 20px; display: flex; align-items: center; gap: 11px; }
    .profile-avatar-sm {
      width: 40px; height: 40px; border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      display: flex; align-items: center; justify-content: center;
      font-size: .85rem; font-weight: 700; color: var(--green-deep); flex-shrink: 0;
      overflow: hidden;
    }
    .profile-name { font-size: .83rem; font-weight: 600; color: var(--cream); }
    .profile-role { font-size: .63rem; color: rgba(245,240,232,.35); letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }
    .sidebar-divider { border: none; border-top: 1px solid rgba(255,255,255,.07); margin: 0 22px 16px; }
    .nav-section-label { padding: 0 22px; font-size: .6rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(245,240,232,.28); margin-bottom: 6px; margin-top: 12px; }
    .nav-item { display: flex; align-items: center; gap: 11px; padding: 10px 22px; cursor: pointer; transition: background .15s; border-left: 3px solid transparent; text-decoration: none; }
    .nav-item:hover { background: rgba(255,255,255,.04); }
    .nav-item.active { background: rgba(45,122,79,.18); border-left-color: var(--gold); }
    .nav-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .88rem; flex-shrink: 0; transition: background .15s, color .15s; }
    .nav-item:not(.active) .nav-icon { background: rgba(255,255,255,.07); color: rgba(245,240,232,.55); }
    .nav-item.active .nav-icon { background: var(--gold); color: var(--green-deep); }
    .nav-label { font-size: .81rem; font-weight: 600; color: rgba(245,240,232,.7); }
    .nav-item.active .nav-label { color: var(--cream); }
    .sidebar-footer { padding: 14px 22px; border-top: 1px solid rgba(255,255,255,.07); flex-shrink: 0; }
    .sidebar-footer-label { font-size: .6rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.3); margin-bottom: 4px; }
    .sidebar-footer-value { font-size: .73rem; color: rgba(245,240,232,.5); font-weight: 300; }

    /* ── MAIN ── */
    .main-content { flex: 1; min-width: 0; }
    .page-body { max-width: 900px; margin: 0 auto; padding: 36px 28px 60px; }

    /* ── ALERTS ── */
    .alert-bar { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: .84rem; font-weight: 500; }
    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }
    .alert-danger   { background: #fdf0ef; color: var(--red); border: 1px solid rgba(160,37,28,.2); }

    /* ── PAGE TITLE ── */
    .page-title-row { margin-bottom: 24px; }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

    /* ── PROFILE HERO ── */
    .profile-hero {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
      margin-bottom: 20px;
    }
    .profile-hero-banner {
      height: 90px;
      background: linear-gradient(120deg, var(--green-deep) 0%, var(--green-mid) 50%, #1e5c38 100%);
      position: relative;
    }
    .profile-hero-banner::after {
      content: '';
      position: absolute; inset: 0;
      background: repeating-linear-gradient(
        45deg,
        rgba(255,255,255,.03) 0px, rgba(255,255,255,.03) 1px,
        transparent 1px, transparent 12px
      );
    }
    .profile-hero-avatar-wrap {
      padding: 0 24px;
      margin-top: -36px;
      position: relative;
      z-index: 1;
      display: inline-block;
    }
    .profile-hero-avatar-container {
      position: relative;
      width: 72px; height: 72px;
      display: inline-block;
      cursor: pointer;
    }
    .profile-hero-avatar-container:hover .avatar-camera-overlay { opacity: 1; }
    .profile-hero-avatar {
      width: 72px; height: 72px; border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      display: flex; align-items: center; justify-content: center;
      font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-weight: 700;
      color: var(--green-deep);
      border: 4px solid var(--surface);
      box-shadow: 0 2px 12px rgba(0,0,0,.15);
      overflow: hidden;
      flex-shrink: 0;
    }
    .avatar-camera-overlay {
      position: absolute; inset: 0; border-radius: 50%;
      background: rgba(0,0,0,.45);
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      gap: 2px; opacity: 0; transition: opacity .2s ease; pointer-events: none;
    }
    .avatar-camera-overlay i { font-size: 1.1rem; color: #fff; }
    .avatar-camera-overlay span { font-size: .5rem; color: rgba(255,255,255,.85); font-weight: 600; letter-spacing: .5px; text-transform: uppercase; }
    .avatar-file-input { display: none; }

    .profile-hero-body {
      padding: 8px 24px 20px;
      display: flex; align-items: flex-start; gap: 18px; flex-wrap: wrap;
    }
    .profile-hero-info { flex: 1; min-width: 0; padding-top: 4px; }
    .profile-hero-name { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 700; color: var(--text-dark); }
    .profile-hero-meta { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-top: 4px; }
    .profile-hero-role, .profile-hero-email {
      display: flex; align-items: center; gap: 5px;
      font-size: .75rem; color: var(--muted); font-weight: 400;
    }
    .profile-hero-role { color: var(--green-accent); font-weight: 600; }
    .profile-hero-since {
      display: flex; align-items: center; gap: 5px;
      font-size: .73rem; color: var(--muted); padding-top: 4px; flex-shrink: 0;
    }

    /* ── PROFILE CARD (TABS) ── */
    .profile-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
    }

    /* ── TAB NAV ── */
    .tab-nav {
      display: flex;
      background: linear-gradient(90deg, var(--green-mid), var(--green-deep));
    }
    .tab-btn {
      display: flex; align-items: center; gap: 7px;
      padding: 14px 22px;
      background: none; border: none; border-bottom: 3px solid transparent;
      font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600;
      color: rgba(245,240,232,.5); cursor: pointer;
      transition: color .15s, border-color .15s, background .15s;
      letter-spacing: .2px;
    }
    .tab-btn:hover { color: var(--cream); background: rgba(255,255,255,.05); }
    .tab-btn.active { color: var(--gold-light); border-bottom-color: var(--gold); background: rgba(255,255,255,.04); }

    /* ── TAB PANES ── */
    .tab-pane { display: none; padding: 28px 28px 32px; }
    .tab-pane.active { display: block; }

    /* ── INFO ROWS ── */
    .info-row {
      display: flex; align-items: center; justify-content: space-between;
      padding: 14px 0; border-bottom: 1px solid var(--border); gap: 16px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: .72rem; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: var(--muted); flex-shrink: 0; }
    .info-value { font-size: .88rem; color: var(--text-dark); font-weight: 500; text-align: right; }
    .badge-active {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 3px 10px; border-radius: 20px;
      background: var(--green-light); color: var(--green-accent);
      font-size: .72rem; font-weight: 700;
    }
    .badge-active span { width: 6px; height: 6px; border-radius: 50%; background: var(--green-accent); animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .4; } }

    /* ── FORM ── */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.span-2 { grid-column: span 2; }
    .form-label { font-size: .72rem; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: var(--text-mid); }
    .form-control-dar {
      padding: 10px 13px;
      border: 1.5px solid var(--border); border-radius: 9px;
      font-family: 'DM Sans', sans-serif; font-size: .875rem; color: var(--text-dark);
      background: var(--surface); outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-control-dar:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); }
    .form-control-dar:disabled { background: var(--bg); color: var(--muted); cursor: not-allowed; }
    textarea.form-control-dar { resize: vertical; }
    .form-hint { font-size: .72rem; color: var(--muted); }
    .form-section-sep { grid-column: span 2; border: none; border-top: 1px solid var(--border); margin: 4px 0; }
    .form-section-label { grid-column: span 2; font-size: .68rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); margin-top: -6px; }
    .form-footer {
      display: flex; align-items: center; justify-content: flex-end; gap: 10px;
      margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);
    }
    .btn-action {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 9px 18px; border-radius: 8px; font-family: 'DM Sans', sans-serif;
      font-size: .78rem; font-weight: 700; cursor: pointer; transition: all .15s;
      border: 1.5px solid var(--border); background: var(--surface); color: var(--text-mid);
      text-decoration: none;
    }
    .btn-action:hover { background: var(--bg); }
    .btn-action.btn-primary {
      background: linear-gradient(135deg, var(--green-accent), var(--green-mid));
      color: #fff; border-color: transparent;
      box-shadow: 0 2px 8px rgba(14,42,26,.18);
    }
    .btn-action.btn-primary:hover { background: linear-gradient(135deg, #35906d, var(--green-accent)); transform: translateY(-1px); }

    /* ── PASSWORD STRENGTH ── */
    .strength-bar { display: flex; gap: 4px; margin-top: 8px; }
    .strength-seg { flex: 1; height: 4px; border-radius: 4px; background: var(--border); transition: background .3s; }
    .strength-seg.weak   { background: var(--red); }
    .strength-seg.fair   { background: #c2640a; }
    .strength-seg.good   { background: var(--gold); }
    .strength-seg.strong { background: var(--green-accent); }
    .strength-label { font-size: .72rem; color: var(--muted); margin-top: 5px; }

    /* ── ACTIVITY TAB ── */
    .activity-item { display: flex; align-items: flex-start; gap: 14px; padding: 14px 0; border-bottom: 1px solid var(--border); }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
      width: 34px; height: 34px; border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
      font-size: .88rem; flex-shrink: 0;
    }
    .ad-green { background: var(--green-light); color: var(--green-accent); }
    .ad-blue  { background: #e8f0fd; color: #2563c7; }
    .ad-amber { background: #fdf3dc; color: var(--gold); }
    .ad-red   { background: #fdf0ef; color: var(--red); }
    .activity-text { flex: 1; min-width: 0; }
    .activity-desc { font-size: .85rem; color: var(--text-dark); font-weight: 500; line-height: 1.4; }
    .activity-time { font-size: .72rem; color: var(--muted); margin-top: 3px; }
    .activity-empty { padding: 40px 0; text-align: center; color: var(--muted); font-size: .85rem; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }
      .sidebar { width: 100%; height: auto; position: static; }
      .sidebar-profile, .sidebar-divider, .nav-section-label, .sidebar-footer { display: none; }
      .sidebar-inner { display: flex; overflow-x: auto; padding: 8px 0; }
      .nav-item { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
      .nav-item.active { border-bottom-color: var(--gold); }
      .page-body { padding: 20px 16px 48px; }
      .form-grid { grid-template-columns: 1fr; }
      .form-group.span-2 { grid-column: span 1; }
      .form-section-sep, .form-section-label { grid-column: span 1; }
      .profile-hero-body { flex-direction: column; gap: 10px; }
      .profile-hero-since { margin-left: 0; }
      .header-user-name, .header-user-role { display: none; }
    }
    @media (max-width: 540px) {
      .tab-btn { padding: 12px 14px; font-size: .72rem; }
      .tab-pane { padding: 20px 16px 24px; }
      .page-header { padding: 12px 16px; gap: 10px; }
      .header-text .t1 { display: none; }
    }
  </style>
</head>
<body>

@php
  $user = $user ?? auth()->user();
  $authUser = auth()->user();

  $nameParts = preg_split('/\s+/', trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));
  $initials = count($nameParts) >= 2
    ? strtoupper(substr($nameParts[0],0,1) . substr($nameParts[count($nameParts)-1],0,1))
    : strtoupper(substr($user->name ?? 'AD', 0, 2));
  $fullName = trim(($user->first_name ?? '') . ' ' . ($user->middle_name ?? '') . ' ' . ($user->last_name ?? ''));
  $fullName = preg_replace('/\s+/', ' ', $fullName) ?: ($user->name ?? 'Administrator');

  $displayName = trim(($authUser->first_name ?? '') . ' ' . ($authUser->last_name ?? '')) ?: ($authUser->name ?? 'Administrator');
  $sidebarInitials = strtoupper(substr($displayName, 0, 2));
@endphp

<div class="top-stripe"></div>

<header class="page-header">
  <div class="header-seal">
    <img src="{{ asset('img/dar_logo_square.jpg') }}" alt="DAR logo" />
  </div>
  <div class="header-text">
    <div class="t1">Republic of the Philippines</div>
    <div class="t2">Department of Agrarian Reform</div>
  </div>
  <div class="header-sep"></div>
  <div class="header-page">Admin Panel</div>
  <div class="header-actions">
    <div class="header-user-wrap" id="headerUserWrap">
      <!-- Trigger chip -->
      <div class="header-user" onclick="toggleHeaderDropdown()">
        <div class="header-avatar">
          @if(!empty($authUser->profile_picture) && \Illuminate\Support\Facades\Storage::disk('public')->exists($authUser->profile_picture))
            <img src="{{ asset('storage/' . $authUser->profile_picture) }}" alt="{{ $displayName }}">
          @else
            {{ $sidebarInitials }}
          @endif
        </div>
        <div>
          <div class="header-user-name">{{ $displayName }}</div>
          <div class="header-user-role">{{ ucfirst($authUser->position ?? $authUser->role ?? 'Admin') }}</div>
        </div>
        <i class="bi bi-chevron-down header-user-caret"></i>
      </div>

      <!-- Dropdown -->
      <div class="header-dropdown">
        <div class="dropdown-header">
          <div class="dropdown-header-name">{{ $displayName }}</div>
          <div class="dropdown-header-email">{{ $authUser->email ?? '' }}</div>
        </div>
        <a class="dropdown-item" href="{{ route('profile') }}">
          <i class="bi bi-person-circle"></i> My Profile
        </a>
        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
          @csrf
          <button type="submit" class="dropdown-item danger">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</header>

<div class="outer-wrapper">

  <aside class="sidebar">
    <div class="sidebar-inner">
      <div class="sidebar-profile">
        <div class="profile-avatar-sm">
          @if(!empty($authUser->profile_picture) && \Illuminate\Support\Facades\Storage::disk('public')->exists($authUser->profile_picture))
            <img src="{{ asset('storage/' . $authUser->profile_picture) }}" alt="{{ $displayName }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%; display:block;">
          @else
            {{ $sidebarInitials }}
          @endif
        </div>
        <div>
          <div class="profile-name">{{ $displayName }}</div>
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
    </div>

    <div class="sidebar-footer">
      <div class="sidebar-footer-label">System</div>
      <div class="sidebar-footer-value">DAR Cashier — Regional Office V</div>
    </div>
  </aside>

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

      <div class="page-title-row">
        <div class="page-title">My Profile</div>
        <div class="page-sub">Manage your account information and security settings</div>
      </div>

      <!-- PROFILE HERO -->
      <div class="profile-hero">
        <div class="profile-hero-banner"></div>

        <!-- Avatar with camera overlay -->
        <div class="profile-hero-avatar-wrap">
          <div class="profile-hero-avatar-container" onclick="document.getElementById('hero-pic-input').click()" title="Change profile picture">
            <div class="profile-hero-avatar">
              @if(!empty($user->profile_picture) && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_picture))
                <img id="hero-avatar-img" src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $fullName }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%; display:block;">
              @else
                {{ $initials }}
              @endif
            </div>
            <div class="avatar-camera-overlay">
              <i class="bi bi-camera-fill"></i>
              <span>Change</span>
            </div>
          </div>
          <input type="file" id="hero-pic-input" class="avatar-file-input" accept="image/*" onchange="previewHeroAvatar(this)">
        </div>

        <!-- Info row -->
        <div class="profile-hero-body">
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

      <!-- PROFILE CARD + TABS -->
      <div class="profile-card">
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
            <span class="info-label">Username</span>
            <span class="info-value">{{ $user->username ?? '—' }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $user->email ?? '—' }}</span>
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

        <!-- TAB: PERSONAL INFO -->
        <div class="tab-pane" id="tab-personal">
          <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-grid">

              <div class="form-group span-2">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" id="tab-pic-input" accept="image/*" class="form-control-dar">
                @if(!empty($user->profile_picture) && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_picture))
                  <div class="form-hint" style="margin-top:8px;">
                    Current: <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="profile" style="height:48px; border-radius:6px; vertical-align:middle; margin-left:8px;">
                  </div>
                @endif
                @error('profile_picture')
                  <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                @enderror
              </div>

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
                  value="{{ old('position', $user->position ?? '') }}" placeholder="e.g. Administrator">
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
              <i class="bi bi-clock-history" style="font-size:1.5rem; display:block; margin-bottom:8px; opacity:.4;"></i>
              No recent activity recorded.
            </div>
          @endforelse
        </div>

      </div><!-- /.profile-card -->

    </div><!-- /.page-body -->
  </main>

</div><!-- /.outer-wrapper -->

<script>
  /* ── HEADER DROPDOWN ── */
  const headerWrap = document.getElementById('headerUserWrap');

  function toggleHeaderDropdown() {
    headerWrap.classList.toggle('open');
  }

  document.addEventListener('click', function(e) {
    if (!headerWrap.contains(e.target)) {
      headerWrap.classList.remove('open');
    }
  });

  /* ── HERO AVATAR PREVIEW ── */
  function previewHeroAvatar(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
      const container = document.querySelector('.profile-hero-avatar');
      container.innerHTML = '<img src="' + e.target.result + '" style="width:100%; height:100%; object-fit:cover; border-radius:50%; display:block;">';
      // Sync to Personal Info tab file input
      const tabInput = document.getElementById('tab-pic-input');
      if (tabInput) {
        const dt = new DataTransfer();
        dt.items.add(input.files[0]);
        tabInput.files = dt.files;
      }
      // Switch to Personal Info tab so user can save
      switchTab('personal', document.querySelectorAll('.tab-btn')[1]);
    };
    reader.readAsDataURL(input.files[0]);
  }

  /* ── TAB SWITCHER ── */
  function switchTab(id, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + id).classList.add('active');
    btn.classList.add('active');
  }

  /* Auto-open correct tab on validation errors */
  @if($errors->hasAny(['first_name','last_name','email','username','middle_name','position','profile_picture']))
    switchTab('personal', document.querySelectorAll('.tab-btn')[1]);
  @elseif($errors->hasAny(['current_password','password']))
    switchTab('password', document.querySelectorAll('.tab-btn')[2]);
  @endif

  /* ── PASSWORD STRENGTH ── */
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  (function(){
    try {
      const logoutForms = document.querySelectorAll('form[action="{{ route('logout') }}"]');
      logoutForms.forEach(f => f.addEventListener('submit', function(ev){
        ev.preventDefault();
        Swal.fire({
          title: 'Log out?',
          text: 'Are you sure you want to log out?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, log out',
          cancelButtonText: 'Cancel'
        }).then(result => { if (result.isConfirmed) f.submit(); });
      }));
    } catch (e) {}
  })();
</script>