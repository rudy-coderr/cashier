<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>My Profile — DAR Reviewer</title>
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
      --blue:         #1a4a7a;
      --blue-light:   #e8f0fa;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); min-height: 100vh; color: var(--text-dark); }

    /* ── TOP STRIPE ── */
    .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

    /* ── HEADER ── */
    .page-header {
      background: var(--green-deep);
      padding: 14px 28px;
      display: flex;
      align-items: center;
      gap: 14px;
      position: sticky;
      top: 0;
      z-index: 300;
      height: 62px;
    }
    .header-seal { width: 44px; height: 44px; border-radius: 10px; background: #fff; padding: 3px; overflow: hidden; flex-shrink: 0; box-shadow: 0 1px 6px rgba(0,0,0,.2); }
    .header-seal img { width: 100%; height: 100%; object-fit: contain; display: block; }
    .header-text .t1 { font-size: .56rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .83rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 28px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 700; color: var(--gold-light); }
    .reviewer-badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 4px 11px; border-radius: 20px;
      background: rgba(201,153,42,.18); border: 1px solid rgba(201,153,42,.35);
      color: var(--gold-light); font-size: .66rem; font-weight: 700;
      letter-spacing: 1.2px; text-transform: uppercase;
      margin-left: 10px;
    }
    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 8px; position: relative; }

    /* Notification */
    .notif-btn { position: relative; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 10px; background: rgba(255,255,255,.07); border: none; color: rgba(245,240,232,.55); cursor: pointer; transition: background .15s, color .15s; flex-shrink: 0; }
    .notif-btn:hover { background: rgba(255,255,255,.14); color: var(--cream); }
    .notif-btn i { font-size: 1.25rem; }
    .notif-badge { position: absolute; top: 6px; right: 6px; min-width: 18px; height: 18px; padding: 0 6px; border-radius: 12px; background: var(--red); color: #fff; font-size: .72rem; font-weight: 700; line-height: 18px; text-align: center; display: none; box-shadow: 0 1px 0 rgba(0,0,0,.08); }
    .notif-badge.show { display: inline-block; }
    .notif-dropdown { display: none; position: absolute; top: calc(100% + 10px); right: 0; width: 300px; background: var(--surface); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 8px 32px rgba(0,0,0,.18); z-index: 400; overflow: hidden; }
    .notif-dropdown.open { display: block; animation: dropIn .18s cubic-bezier(.16,1,.3,1); }
    @keyframes dropIn { from { opacity:0; transform: translateY(-6px); } to { opacity:1; transform:none; } }
    .notif-drop-head { padding: 12px 16px; background: var(--green-deep); display: flex; align-items: center; justify-content: space-between; }
    .notif-drop-title { font-size: .78rem; font-weight: 600; color: var(--gold-light); letter-spacing: .5px; }
    .notif-drop-mark { font-size: .68rem; color: rgba(245,240,232,.45); cursor: pointer; background: none; border: none; font-family: 'DM Sans', sans-serif; transition: color .15s; }
    .notif-drop-mark:hover { color: var(--cream); }
    .notif-list { max-height: 260px; overflow-y: auto; }
    .notif-list::-webkit-scrollbar { width: 3px; }
    .notif-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    .notif-item { display: flex; align-items: flex-start; gap: 10px; padding: 11px 16px; border-bottom: 1px solid var(--border); transition: background .12s; cursor: pointer; }
    .notif-item:last-child { border-bottom: none; }
    .notif-item.unread { background: #f5fbf7; }
    .notif-item:hover { background: #f0f7f3; }
    .notif-item, .notif-item a { text-decoration: none; color: inherit; }
    .notif-item-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; }
    .ni-green { background: var(--green-light); color: var(--green-accent); }
    .ni-gold  { background: #fdf3dc; color: var(--gold); }
    .ni-red   { background: #fdf0ef; color: var(--red); }
    .notif-item-body { flex: 1; min-width: 0; }
    .notif-item-text { font-size: .78rem; color: var(--text-dark); line-height: 1.4; }
    .notif-item-time { font-size: .67rem; color: var(--muted); margin-top: 3px; }
    .notif-unread-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green-accent); flex-shrink: 0; margin-top: 6px; }
    .notif-empty { padding: 30px 16px; text-align: center; }
    .notif-empty i { font-size: 1.6rem; color: var(--border); display: block; margin-bottom: 8px; }
    .notif-empty p { font-size: .78rem; color: var(--muted); }
    .notif-drop-foot { padding: 9px 16px; border-top: 1px solid var(--border); text-align: center; }
    .notif-drop-foot a { font-size: .72rem; color: var(--green-accent); text-decoration: none; font-weight: 600; }
    .notif-drop-foot a:hover { text-decoration: underline; }


    /* ── HEADER USER CHIP ── */
    .header-user-wrap { position: relative; }
    .header-user { display: flex; align-items: center; gap: 10px; padding: 6px 12px 6px 8px; background: rgba(245,240,232,.07); border: 1px solid rgba(245,240,232,.12); border-radius: 10px; cursor: pointer; transition: background .15s, border-color .15s; user-select: none; }
    .header-user:hover { background: rgba(245,240,232,.13); border-color: rgba(245,240,232,.22); }
    .header-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-light)); display: flex; align-items: center; justify-content: center; font-size: .72rem; font-weight: 700; color: var(--green-deep); overflow: hidden; flex-shrink: 0; border: 2px solid rgba(201,153,42,.35); }
    .header-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
    .header-user-name { font-size: .76rem; font-weight: 600; color: var(--cream); line-height: 1.2; }
    .header-user-role { font-size: .6rem; color: rgba(245,240,232,.4); letter-spacing: .8px; text-transform: uppercase; }
    .header-user-caret { font-size: .65rem; color: rgba(245,240,232,.4); margin-left: 2px; transition: transform .2s; }
    .header-user-wrap.open .header-user-caret { transform: rotate(180deg); }
    .header-dropdown { position: absolute; top: calc(100% + 8px); right: 0; min-width: 200px; background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; box-shadow: 0 8px 28px rgba(14,42,26,.18); overflow: hidden; opacity: 0; pointer-events: none; transform: translateY(-6px); transition: opacity .18s ease, transform .18s ease; z-index: 300; }
    .header-user-wrap.open .header-dropdown { opacity: 1; pointer-events: all; transform: translateY(0); }
    .dropdown-header { padding: 14px 16px 10px; border-bottom: 1px solid var(--border); }
    .dropdown-header-name { font-size: .84rem; font-weight: 700; color: var(--text-dark); }
    .dropdown-header-email { font-size: .72rem; color: var(--muted); margin-top: 2px; }
    .dropdown-item { display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: .81rem; font-weight: 600; color: var(--text-mid); text-decoration: none; cursor: pointer; transition: background .13s; border: none; background: none; width: 100%; text-align: left; font-family: 'DM Sans', sans-serif; }
    .dropdown-item:hover { background: var(--bg); }
    .dropdown-item i { font-size: 1rem; flex-shrink: 0; }
    .dropdown-item.danger { color: var(--red); }
    .dropdown-item.danger:hover { background: #fdf0ef; }
    .dropdown-divider { border: none; border-top: 1px solid var(--border); margin: 4px 0; }

    /* ── LAYOUT ── */
    .app-layout { display: flex; min-height: calc(100vh - 62px); }

    /* ── SIDEBAR ── */
    .app-sidebar {
      width: 260px; flex-shrink: 0; background: var(--green-deep);
      border-right: 1px solid rgba(255,255,255,.07);
      display: flex; flex-direction: column;
      position: sticky; top: 62px; height: calc(100vh - 62px);
      overflow-y: auto; z-index: 200;
    }
    .app-sidebar::-webkit-scrollbar { width: 3px; }
    .app-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }
    .sidebar-inner { display: flex; flex-direction: column; height: 100%; padding: 20px 0 0; }

    /* Nav links */
    .sidebar-nav { display: flex; flex-direction: column; gap: 6px; padding: 0 10px; }
    .app-nav-link {
      display: flex; align-items: center; gap: 12px; padding: 12px 16px;
      color: rgba(245,240,232,.95); text-decoration: none; border-radius: 10px;
      font-size: 1rem; font-weight: 700; transition: background .15s, color .15s;
      border-left: 3px solid transparent;
    }
    .app-nav-link .nav-icon { width: 36px; text-align: center; color: var(--gold); font-size: 1.05rem; flex-shrink: 0; }
    .app-nav-link:hover { background: rgba(255,255,255,.06); color: var(--cream); }
    .app-nav-link.active { background: rgba(45,122,79,.16); border-left-color: var(--gold); color: var(--cream); font-weight: 800; }

    /* Sidebar footer logout */
    .sidebar-footer { margin-top: auto; padding: 14px 10px; border-top: 1px solid rgba(255,255,255,.06); flex-shrink: 0; }
    .btn-logout {
      background: none; border: none; color: var(--cream); font-size: .78rem;
      cursor: pointer; padding: 7px 13px; display: flex; align-items: center; gap: 6px;
      border-radius: 8px; font-family: 'DM Sans', sans-serif; font-weight: 500;
      letter-spacing: .4px; transition: background .15s; opacity: .75;
    }
    .btn-logout:hover { background: rgba(255,255,255,.1); opacity: 1; }
    .sidebar-footer .btn-logout {
      width: 100%; background: rgba(255,255,255,.05); color: rgba(245,240,232,.6);
      border-radius: 8px; padding: 9px 14px; border: 1px solid rgba(255,255,255,.08); opacity: 1;
      justify-content: center;
    }
    .sidebar-footer .btn-logout:hover { background: rgba(255,255,255,.1); color: var(--cream); }

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
      background: linear-gradient(120deg, var(--green-deep) 0%, #1a3a5e 50%, #0e2238 100%);
      position: relative;
    }
    .profile-hero-banner::after {
      content: '';
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(
        45deg,
        rgba(255,255,255,.03) 0px,
        rgba(255,255,255,.03) 1px,
        transparent 1px,
        transparent 12px
      );
    }
    /* Reviewer role stripe accent */
    .profile-hero-banner::before {
      content: '';
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--blue), var(--gold), var(--blue));
      z-index: 1;
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
      background: linear-gradient(135deg, var(--blue), #2d6abf);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-weight: 700;
      color: #fff;
      border: 4px solid var(--surface);
      box-shadow: 0 2px 12px rgba(0,0,0,.15);
      overflow: hidden;
      flex-shrink: 0;
    }
    .avatar-camera-overlay {
      position: absolute; inset: 0; border-radius: 50%;
      background: rgba(0,0,0,.45);
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      gap: 2px;
      opacity: 0;
      transition: opacity .2s ease;
      pointer-events: none;
    }
    .avatar-camera-overlay i { font-size: 1.1rem; color: #fff; }
    .avatar-camera-overlay span { font-size: .5rem; color: rgba(255,255,255,.85); font-weight: 600; letter-spacing: .5px; text-transform: uppercase; }
    .avatar-file-input { display: none; }
    .profile-hero-body {
      padding: 8px 24px 20px;
      display: flex;
      align-items: flex-start;
      gap: 18px;
      flex-wrap: wrap;
    }
    .profile-hero-info { flex: 1; min-width: 0; padding-top: 4px; }
    .profile-hero-name { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 700; color: var(--text-dark); }
    .profile-hero-meta { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-top: 4px; }
    .profile-hero-role {
      display: flex; align-items: center; gap: 5px;
      font-size: .75rem; color: var(--blue); font-weight: 600;
    }
    .profile-hero-email {
      display: flex; align-items: center; gap: 5px;
      font-size: .75rem; color: var(--muted); font-weight: 400;
    }
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
      background: linear-gradient(90deg, #1a3a5e, var(--green-deep));
      border-bottom: none;
    }
    .tab-btn {
      display: flex; align-items: center; gap: 7px;
      padding: 14px 22px;
      background: none; border: none; border-bottom: 3px solid transparent;
      font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600;
      color: rgba(245,240,232,.5); cursor: pointer; transition: color .15s, border-color .15s, background .15s;
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
      padding: 14px 0;
      border-bottom: 1px solid var(--border);
      gap: 16px;
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
    .badge-active span {
      width: 6px; height: 6px; border-radius: 50%; background: var(--green-accent);
      animation: pulse 2s infinite;
    }
    .badge-reviewer {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 3px 10px; border-radius: 20px;
      background: var(--blue-light); color: var(--blue);
      font-size: .72rem; font-weight: 700;
    }
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
      margin-top: 24px; padding-top: 20px;
      border-top: 1px solid var(--border);
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

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
      .app-layout { flex-direction: column; }
      .app-sidebar { width: 100%; height: auto; position: static; flex-direction: row; overflow-x: auto; border-right: none; border-bottom: 1px solid rgba(255,255,255,.07); }
      .sidebar-inner { flex-direction: row; padding: 0; }
      .sidebar-profile, .sidebar-divider, .nav-section-label, .sidebar-footer { display: none; }
      .sidebar-nav { flex-direction: row; padding: 8px 12px; gap: 6px; overflow-x: auto; }
      .app-nav-link { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; border-radius: 8px; }
      .app-nav-link.active { border-bottom-color: var(--gold); }
      .page-body { padding: 20px 16px 48px; }
      .form-grid { grid-template-columns: 1fr; }
      .form-group.span-2 { grid-column: span 1; }
      .form-section-sep, .form-section-label { grid-column: span 1; }
      .profile-hero-body { flex-direction: column; gap: 10px; }
    }
    @media (max-width: 540px) {
      .tab-btn { padding: 12px 14px; font-size: .72rem; }
      .tab-pane { padding: 20px 16px 24px; }
    }
  </style>
</head>
<body>

@php
  $authUser    = auth()->user();
  $displayName = trim(($authUser->first_name ?? '') . ' ' . ($authUser->last_name ?? '')) ?: ($authUser->name ?? 'Reviewer');
  $sidebarInitials = strtoupper(substr($displayName, 0, 2));
@endphp

@php
  $user = auth()->user();
  $nameParts = preg_split('/\s+/', trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));
  $initials = count($nameParts) >= 2
    ? strtoupper(substr($nameParts[0],0,1) . substr($nameParts[count($nameParts)-1],0,1))
    : strtoupper(substr($user->name ?? 'RV', 0, 2));
  $fullName = trim(($user->first_name ?? '') . ' ' . ($user->middle_name ?? '') . ' ' . ($user->last_name ?? ''));
  $fullName = preg_replace('/\s+/', ' ', $fullName) ?: ($user->name ?? 'Reviewer');
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
  <div class="header-page">Reviewer</div>
  <div class="reviewer-badge">
    <i class="bi bi-shield-check"></i> Reviewer Access
  </div>

  <div class="header-actions">
    <!-- Notification -->
    <div class="notif-wrapper">
      <button 
        class="notif-btn" 
        id="notif-btn"
        onclick="toggleNotifDropdown(event)"
        title="Notifications"
      >
        <i class="bi bi-bell"></i>
        <span class="notif-badge" id="notif-badge">0</span>
      </button>

      <!-- Notification Dropdown -->
      <div class="notif-dropdown" id="notif-dropdown">

        <div class="notif-drop-head">
          <span class="notif-drop-title">Notifications</span>

          <button 
            class="notif-drop-mark"
            onclick="markAllRead()"
          >
            Mark all as read
          </button>
        </div>

        <div class="notif-list" id="notif-list">
          <div class="notif-empty"><i class="bi bi-bell-slash"></i><p>No notifications yet.</p></div>
        </div>

        <div class="notif-drop-foot">
          <a href="{{ route('notifications.page') }}">View all notifications</a>
        </div>

      </div>
    </div>

    <!-- User chip -->
    <div class="header-user-wrap" id="headerUserWrap">
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
          <div class="header-user-role">{{ ucfirst($authUser->position ?? $authUser->role ?? 'Reviewer') }}</div>
        </div>
        <i class="bi bi-chevron-down header-user-caret"></i>
      </div>
      <div class="header-dropdown">
        <div class="dropdown-header">
          <div class="dropdown-header-name">{{ $displayName }}</div>
          <div class="dropdown-header-email">{{ $authUser->email ?? '' }}</div>
        </div>
        <a class="dropdown-item" href="{{ route('reviewer.profile') }}">
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

<div class="app-layout">

  <!-- SIDEBAR -->
  <aside class="app-sidebar" id="app-sidebar">
    <div class="sidebar-inner">

      <nav class="sidebar-nav">
        <a href="{{ route('reviewer') }}"
           class="app-nav-link">
          <span class="nav-icon"><i class="bi bi-journal-text"></i></span>
          <span class="nav-label">Review Transactions</span>
        </a>
        <a href="{{ route('reviewer', ['open_funds' => 1]) }}"
           class="app-nav-link">
          <span class="nav-icon"><i class="bi bi-plus-circle"></i></span>
          <span class="nav-label">New Transaction</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
      </div>

    </div>
  </aside>

  <!-- MAIN -->
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

        <div class="profile-hero-avatar-wrap">
          <div class="profile-hero-avatar-container" onclick="document.getElementById('hero-pic-input').click()" title="Change profile picture">
            <div class="profile-hero-avatar">
              @if(!empty($user->profile_picture))
                <img id="hero-avatar-img" src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $fullName }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
              @else
                <span id="hero-avatar-initials">{{ $initials }}</span>
              @endif
            </div>
            <div class="avatar-camera-overlay">
              <i class="bi bi-camera-fill"></i>
              <span>Change</span>
            </div>
          </div>
          <input type="file" id="hero-pic-input" class="avatar-file-input" accept="image/*" onchange="previewHeroAvatar(this)">
        </div>

        <div class="profile-hero-body">
          <div class="profile-hero-info">
            <div class="profile-hero-name">{{ $fullName }}</div>
            <div class="profile-hero-meta">
              <span class="profile-hero-role"><i class="bi bi-shield-check"></i> Reviewer</span>
              <span class="profile-hero-email"><i class="bi bi-envelope"></i> {{ $user->email ?? '—' }}</span>
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
        </div>

        <!-- TAB: ACCOUNT DETAILS -->
        <div class="tab-pane active" id="tab-details">
          <div class="info-row">
            <span class="info-label">Account ID</span>
            <span class="info-value">#{{ str_pad($user->id ?? 0, 5, '0', STR_PAD_LEFT) }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value"><span class="badge-reviewer"><i class="bi bi-shield-check"></i> Reviewer</span></span>
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
            <span class="info-label">Phone</span>
            <span class="info-value">{{ $user->phone_number ?? '—' }}</span>
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
          <form method="POST" action="{{ route('reviewer.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-grid">

              <div class="form-group span-2">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" accept="image/*" class="form-control-dar">
                @error('profile_picture')
                  <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control-dar"
                  value="{{ old('first_name', $user->first_name ?? '') }}" placeholder="First name" required>
                @error('first_name')
                  <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control-dar"
                  value="{{ old('last_name', $user->last_name ?? '') }}" placeholder="Last name" required>
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
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control-dar"
                  value="{{ old('username', $user->username ?? '') }}" placeholder="username">
                @error('username')
                  <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                @enderror
              </div>

              <hr class="form-section-sep">
              <div class="form-section-label">Contact</div>

              <div class="form-group span-2">
                <label class="form-label">Email Address (read-only)</label>
                <input type="email" class="form-control-dar" value="{{ $user->email ?? '' }}" disabled>
                <span class="form-hint">Email cannot be changed. Contact your administrator.</span>
              </div>

              <div class="form-group span-2">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control-dar"
                  value="{{ old('phone_number', $user->phone_number ?? '') }}" placeholder="+63 9XX XXX XXXX">
                @error('phone_number')
                  <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                @enderror
              </div>

              <div class="form-group span-2">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control-dar" rows="3"
                  placeholder="Your address">{{ old('address', $user->address ?? '') }}</textarea>
                @error('address')
                  <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                @enderror
              </div>

            </div>
            <div class="form-footer">
              <a href="{{ route('reviewer') }}" class="btn-action">
                <i class="bi bi-x-lg"></i> Cancel
              </a>
              <button type="submit" class="btn-action btn-primary">
                <i class="bi bi-check-lg"></i> Save Changes
              </button>
            </div>
          </form>
        </div>

        <!-- TAB: CHANGE PASSWORD -->
        <div class="tab-pane" id="tab-password">
          <form method="POST" action="{{ route('reviewer.profile.password') }}">
            @csrf
            @method('PATCH')
            <div class="form-grid">

              <div class="form-group span-2">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control-dar"
                  placeholder="Enter your current password" autocomplete="current-password" required>
                @error('current_password')
                  <span class="form-hint" style="color:var(--red);">{{ $message }}</span>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label">New Password</label>
                <input type="password" name="password" id="new-password" class="form-control-dar"
                  placeholder="New password" autocomplete="new-password" required>
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
                  placeholder="Repeat new password" autocomplete="new-password" required>
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

      </div><!-- /.profile-card -->

    </div><!-- /.page-body -->
  </main>

</div><!-- /.app-layout -->

<script>
  /* ── HEADER DROPDOWN ── */
  const headerWrap = document.getElementById('headerUserWrap');
  function toggleHeaderDropdown() { headerWrap.classList.toggle('open'); }
  document.addEventListener('click', function(e) {
    if (!headerWrap.contains(e.target)) headerWrap.classList.remove('open');
  });

  /* ── HERO AVATAR PREVIEW ── */
  function previewHeroAvatar(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
      const container = document.querySelector('.profile-hero-avatar');
      container.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">';
      const tabInput = document.querySelector('input[name="profile_picture"]');
      if (tabInput) {
        const dt = new DataTransfer();
        dt.items.add(input.files[0]);
        tabInput.files = dt.files;
      }
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
  @if($errors->hasAny(['first_name','last_name','middle_name','username','phone_number','address']))
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

  /* ─── NOTIFICATION SYSTEM ─── */
  let NOTIF_DATA = [];
  let notifOpen = false;

  function fetchNotifications() {
    if (!document.getElementById('notif-list')) return;
    fetch('/notifications', { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
      .then(r => r.json())
      .then(items => {
        NOTIF_DATA = items.map(i => ({
          id: i.id,
          icon: i.data.icon || 'bi-hourglass-split',
          cls: i.data.cls || 'ni-gold',
          name: i.data.name || i.data.op_number || 'Transaction',
          status: i.data.status || 'waiting',
          _created: i.created_at || null,
          time: '',
          unread: !(i.read === true),
        }));
        NOTIF_DATA.forEach(n => { n.time = n._created ? timeAgo(n._created) : ''; });
        renderNotifList();
      }).catch(e => { console.warn('Failed to load notifications', e); });
  }

  function timeAgo(dateString) {
    try {
      const then = new Date(dateString);
      const now = new Date();
      const sec = Math.floor((now - then) / 1000);
      if (sec < 5) return 'just now';
      if (sec < 60) return sec + ' seconds ago';
      const min = Math.floor(sec / 60);
      if (min < 60) return min + (min === 1 ? ' minute ago' : ' minutes ago');
      const hr = Math.floor(min / 60);
      if (hr < 24) return hr + (hr === 1 ? ' hour ago' : ' hours ago');
      const days = Math.floor(hr / 24);
      if (days < 30) return days + (days === 1 ? ' day ago' : ' days ago');
      return then.toLocaleDateString();
    } catch (e) { return ''; }
  }

  function renderNotifList() {
    const list = document.getElementById('notif-list');
    const badge = document.getElementById('notif-badge');
    if (!list || !badge) return;
    const unreadCount = NOTIF_DATA.filter(n => n.unread).length;
    if (unreadCount > 0) {
      badge.classList.add('show');
      badge.textContent = unreadCount > 99 ? '99+' : String(unreadCount);
      badge.setAttribute('title', unreadCount + ' unread notifications');
    } else { badge.classList.remove('show'); badge.textContent = ''; badge.removeAttribute('title'); }

    if (NOTIF_DATA.length === 0) {
      list.innerHTML = '<div class="notif-empty"><i class="bi bi-bell-slash"></i><p>No notifications yet.</p></div>';
      return;
    }

    list.innerHTML = NOTIF_DATA.map(n => {
      let actionText = '';
      if (n.status === 'approved') actionText = 'has been approved.';
      else if (n.status === 'waiting') actionText = 'is awaiting your review.';
      else if (n.status === 'rejected') actionText = 'was rejected. Please review.';
      const message = `Transaction for ${n.name} ${actionText}`;
      return `
      <a href="/reviewer?notif_id=${n.id}" class="notif-item${n.unread ? ' unread' : ''}" onclick="readNotif(${n.id})">
        <div class="notif-item-icon ${n.cls}"><i class="bi ${n.icon}"></i></div>
        <div class="notif-item-body">
          <div class="notif-item-text">${message}</div>
          <div class="notif-item-time">${n.time}</div>
        </div>
        ${n.unread ? '<div class="notif-unread-dot"></div>' : ''}
      </a>
      `;
    }).join('');
  }

  function readNotif(id) {
    fetch('/notifications/' + id + '/read', { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' }})
      .then(() => { const n = NOTIF_DATA.find(x => x.id === id); if (n) n.unread = false; renderNotifList(); })
      .catch(() => { const n = NOTIF_DATA.find(x => x.id === id); if (n) n.unread = false; renderNotifList(); });
  }

  function markAllRead() {
    fetch('{{ route('notifications.mark_all') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      credentials: 'same-origin'
    }).then(r => { if (!r.ok) throw new Error('network'); return r.json(); }).then(json => { if (json && json.ok) { NOTIF_DATA.forEach(n => n.unread = false); renderNotifList(); } }).catch(err => { console.warn('Failed to mark all read', err); NOTIF_DATA.forEach(n => n.unread = false); renderNotifList(); });
  }

  function toggleNotifDropdown(e) {
    e.stopPropagation();
    const dropdown = document.getElementById('notif-dropdown');
    notifOpen = !notifOpen;
    if (notifOpen) { dropdown.classList.add('open'); renderNotifList(); }
    else dropdown.classList.remove('open');
  }

  document.addEventListener('click', function(e) {
    const btn = document.getElementById('notif-btn');
    const dropdown = document.getElementById('notif-dropdown');
    if (notifOpen && btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.remove('open'); notifOpen = false;
    }
  });

  window.addEventListener('load', function() { fetchNotifications(); });


</script>

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

</body>
</html>