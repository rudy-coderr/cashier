<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Notifications — DAR Cashier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
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

    /* ── TOP STRIPE & HEADER ── */
    .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

    .page-header {
      background: var(--green-deep); padding: 14px 28px;
      display: flex; align-items: center; gap: 14px;
      position: sticky; top: 0; z-index: 300; height: 62px;
    }
    .header-seal { width: 44px; height: 44px; border-radius: 10px; background: #fff; padding: 3px; overflow: hidden; flex-shrink: 0; box-shadow: 0 1px 6px rgba(0,0,0,.2); }
    .header-seal img { width: 100%; height: 100%; object-fit: contain; display: block; }
    .header-text .t1 { font-size: .56rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .83rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 28px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }
    .reviewer-badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 4px 11px; border-radius: 20px;
      background: rgba(201,153,42,.18); border: 1px solid rgba(201,153,42,.35);
      color: var(--gold-light); font-size: .66rem; font-weight: 700;
      letter-spacing: 1.2px; text-transform: uppercase;
    }
    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 8px; position: relative; }

    /* Notification icon */
    .notif-btn { position: relative; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 10px; background: rgba(255,255,255,.07); border: none; color: rgba(245,240,232,.55); cursor: pointer; transition: background .15s, color .15s; flex-shrink: 0; }
    .notif-btn:hover { background: rgba(255,255,255,.14); color: var(--cream); }
    .notif-btn i { font-size: 1.25rem; }
    .notif-badge { position: absolute; top: 6px; right: 6px; min-width: 18px; height: 18px; padding: 0 6px; border-radius: 12px; background: var(--red); color: #fff; font-size: .72rem; font-weight: 700; line-height: 18px; text-align: center; display: none; }
    .notif-badge.show { display: inline-block; }

    /* User chip */
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
    .app-layout { display: flex; min-height: calc(100vh - 66px); }

    .app-sidebar {
      width: 260px; flex-shrink: 0; background: var(--green-deep);
      border-right: 1px solid rgba(255,255,255,.07); display: flex; flex-direction: column;
      position: sticky; top: 66px; height: calc(100vh - 66px); overflow-y: auto; z-index: 200;
    }
    .app-sidebar::-webkit-scrollbar { width: 3px; }
    .app-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }
    .sidebar-inner { display: flex; flex-direction: column; height: 100%; padding: 20px 0 0; }
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
    .sidebar-footer { margin-top: auto; padding: 14px 10px; border-top: 1px solid rgba(255,255,255,.06); }
    .btn-logout { background: none; border: none; color: var(--cream); font-size: .78rem; cursor: pointer; padding: 7px 13px; display: flex; align-items: center; gap: 6px; border-radius: 8px; font-family: 'DM Sans', sans-serif; font-weight: 500; letter-spacing: .4px; transition: background .15s; opacity: .75; }
    .btn-logout:hover { background: rgba(255,255,255,.1); opacity: 1; }
    .sidebar-footer .btn-logout { width: 100%; background: rgba(255,255,255,.05); color: rgba(245,240,232,.6); border-radius: 8px; padding: 9px 14px; border: 1px solid rgba(255,255,255,.08); opacity: 1; justify-content: center; }
    .sidebar-footer .btn-logout:hover { background: rgba(255,255,255,.1); color: var(--cream); }

    .app-main { flex: 1; min-width: 0; display: flex; flex-direction: column; }

    /* ── PAGE BODY ── */
    .page-body { max-width: 1100px; margin: 0 auto; padding: 32px 28px 60px; width: 100%; }

    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

    /* ── TOOLBAR ── */
    .notif-toolbar {
      display: flex; align-items: center; justify-content: space-between;
      gap: 12px; margin-bottom: 20px; flex-wrap: wrap;
    }
    .notif-filters { display: flex; gap: 8px; flex-wrap: wrap; }
    .filter-pill {
      padding: 6px 16px; border-radius: 20px; font-size: .75rem; font-weight: 700;
      cursor: pointer; border: 1.5px solid var(--border); background: var(--surface);
      color: var(--text-mid); transition: all .15s; letter-spacing: .3px;
    }
    .filter-pill:hover { border-color: var(--green-accent); color: var(--green-accent); }
    .filter-pill.active { background: var(--green-mid); border-color: var(--green-mid); color: #fff; }
    .filter-pill.active-gold { background: var(--gold); border-color: var(--gold); color: var(--green-deep); }
    .notif-actions { display: flex; gap: 8px; }
    .btn-mark-all {
      display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px;
      border: 1.5px solid var(--green-accent); border-radius: 9px; background: transparent;
      color: var(--green-accent); font-family: 'DM Sans', sans-serif; font-size: .76rem;
      font-weight: 700; cursor: pointer; transition: all .15s;
    }
    .btn-mark-all:hover { background: var(--green-light); }
    .btn-clear-all {
      display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px;
      border: 1.5px solid #e8c5c5; border-radius: 9px; background: transparent;
      color: var(--red); font-family: 'DM Sans', sans-serif; font-size: .76rem;
      font-weight: 700; cursor: pointer; transition: all .15s;
    }
    .btn-clear-all:hover { background: #fdf0ef; }

    /* ── NOTIFICATION CARDS ── */
    .notif-list-wrap { display: flex; flex-direction: column; gap: 0; }

    .notif-date-header {
      display: flex; align-items: center; gap: 10px;
      font-size: .62rem; font-weight: 700; letter-spacing: 1.6px;
      text-transform: uppercase; color: var(--muted); margin: 24px 0 10px;
    }
    .notif-date-header:first-child { margin-top: 0; }
    .notif-date-header::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    .notif-card {
      display: flex; align-items: flex-start; gap: 14px;
      padding: 16px 20px; background: var(--surface); border: 1.5px solid var(--border);
      border-radius: 12px; margin-bottom: 8px; cursor: pointer;
      transition: box-shadow .15s, border-color .15s, background .15s;
      position: relative; overflow: hidden;
    }
    .notif-card::before {
      content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
      background: transparent; transition: background .15s;
    }
    .notif-card.unread { background: #f7fbf8; border-color: #c8e6d4; }
    .notif-card.unread::before { background: var(--green-accent); }
    .notif-card:hover { box-shadow: 0 4px 18px rgba(14,42,26,.1); border-color: #b5d8c2; }
    .notif-card.unread:hover { background: #f0f8f3; }

    /* Type variants */
    .notif-card.type-approved.unread { background: #f5fbf6; border-color: #b8dfc8; }
    .notif-card.type-approved.unread::before { background: var(--green-accent); }
    .notif-card.type-waiting.unread { background: #fdf8ed; border-color: #e8d5a0; }
    .notif-card.type-waiting.unread::before { background: var(--gold); }
    .notif-card.type-rejected.unread { background: #fdf2f1; border-color: #e8bcba; }
    .notif-card.type-rejected.unread::before { background: var(--red); }
    .notif-card.type-forwarded.unread { background: #eef3fb; border-color: #b0cae8; }
    .notif-card.type-forwarded.unread::before { background: var(--blue); }
    .notif-card.type-system.unread { background: #f5f4fb; border-color: #ccc8e8; }
    .notif-card.type-system.unread::before { background: #6b5fad; }

    .notif-icon-wrap {
      width: 42px; height: 42px; border-radius: 11px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem; flex-shrink: 0;
    }
    .ni-green  { background: var(--green-light); color: var(--green-accent); }
    .ni-gold   { background: #fdf3dc; color: var(--gold); }
    .ni-red    { background: #fdf0ef; color: var(--red); }
    .ni-blue   { background: var(--blue-light); color: var(--blue); }
    .ni-purple { background: #f0eeff; color: #6b5fad; }

    .notif-content { flex: 1; min-width: 0; }
    .notif-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; margin-bottom: 4px; }
    .notif-title { font-size: .88rem; font-weight: 700; color: var(--text-dark); line-height: 1.3; }
    .notif-card:not(.unread) .notif-title { font-weight: 500; color: var(--text-mid); }
    .notif-meta { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
    .notif-time { font-size: .7rem; color: var(--muted); white-space: nowrap; }
    .unread-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--green-accent); flex-shrink: 0; }
    .type-waiting  .unread-dot { background: var(--gold); }
    .type-rejected .unread-dot { background: var(--red); }
    .type-forwarded .unread-dot { background: var(--blue); }
    .type-system .unread-dot { background: #6b5fad; }
    .notif-body { font-size: .81rem; color: var(--text-mid); line-height: 1.55; margin-bottom: 8px; }
    .notif-card:not(.unread) .notif-body { color: var(--muted); }
    .notif-tags { display: flex; gap: 6px; flex-wrap: wrap; }
    .notif-tag {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 9px; border-radius: 20px; font-size: .65rem; font-weight: 700;
      letter-spacing: .4px; text-transform: uppercase;
    }
    .tag-approved { background: var(--green-light); color: var(--green-accent); }
    .tag-waiting  { background: #fdf3dc; color: #a0700a; }
    .tag-rejected { background: #fdf0ef; color: var(--red); }
    .tag-forwarded { background: var(--blue-light); color: var(--blue); }
    .tag-system   { background: #f0eeff; color: #6b5fad; }
    .tag-amount   { background: #faf8f4; color: var(--text-mid); border: 1px solid var(--border); }

    .notif-card-actions { display: flex; align-items: center; gap: 6px; flex-shrink: 0; flex-direction: column; justify-content: flex-start; }
    .card-action-btn {
      width: 30px; height: 30px; border-radius: 7px; border: 1.5px solid var(--border);
      background: #faf8f4; color: var(--text-mid); display: flex; align-items: center;
      justify-content: center; cursor: pointer; font-size: .8rem; transition: all .15s;
    }
    .card-action-btn:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }
    .card-action-btn.delete:hover { background: #fdf0ef; border-color: #e8c5c5; color: var(--red); }

    /* ── EMPTY STATE ── */
    .notif-empty-state {
      text-align: center; padding: 80px 20px;
      display: none;
    }
    .notif-empty-state.show { display: block; }
    .empty-icon-wrap {
      width: 72px; height: 72px; border-radius: 50%;
      background: var(--green-light); display: flex; align-items: center;
      justify-content: center; margin: 0 auto 16px; font-size: 1.8rem; color: var(--green-accent);
    }
    .empty-title { font-family: 'Cormorant Garamond', serif; font-size: 1.25rem; font-weight: 700; color: var(--text-mid); margin-bottom: 6px; }
    .empty-sub { font-size: .82rem; color: var(--muted); font-weight: 300; }

    /* ── SUMMARY BAR ── */
    .summary-bar {
      display: flex; align-items: center; gap: 16px;
      padding: 11px 18px; background: var(--surface); border: 1.5px solid var(--border);
      border-radius: 10px; margin-bottom: 20px; flex-wrap: wrap;
    }
    .summary-item { display: flex; align-items: center; gap: 7px; font-size: .78rem; color: var(--text-mid); }
    .summary-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .summary-count { font-weight: 700; color: var(--text-dark); }
    .summary-sep { width: 1px; height: 14px; background: var(--border); }

    /* ── ALERT BAR ── */
    .alert-bar { display: flex; align-items: center; gap: 10px; padding: 11px 17px; border-radius: 10px; margin-bottom: 18px; font-size: .83rem; font-weight: 500; }
    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }
    .alert-danger  { background: #fdf0ef; color: var(--red); border: 1px solid rgba(160,37,28,.2); }

    /* ── CONFIRM MODAL ── */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(14,42,26,.5); backdrop-filter: blur(3px); z-index: 900; align-items: center; justify-content: center; padding: 20px; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: var(--surface); border-radius: 14px; width: 100%; max-width: 400px; box-shadow: 0 16px 48px rgba(14,42,26,.2); overflow: hidden; animation: mIn .18s ease; }
    @keyframes mIn { from { opacity:0; transform:translateY(12px) scale(.97); } to { opacity:1; transform:none; } }
    .modal-head { padding: 16px 20px; background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); display: flex; align-items: center; justify-content: space-between; }
    .modal-head-title { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 8px; }
    .modal-close-btn { background: none; border: none; color: rgba(245,240,232,.5); font-size: 1rem; cursor: pointer; padding: 4px; border-radius: 6px; display: flex; align-items: center; transition: color .15s; }
    .modal-close-btn:hover { color: var(--cream); }
    .modal-body-inner { padding: 20px; font-size: .85rem; color: var(--text-mid); line-height: 1.6; }
    .modal-footer-inner { padding: 13px 20px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }
    .btn-cancel { padding: 8px 16px; border: 1.5px solid var(--border); border-radius: 8px; background: var(--surface); color: var(--text-mid); font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 600; cursor: pointer; transition: background .15s; }
    .btn-cancel:hover { background: var(--bg); }
    .btn-confirm-red { padding: 8px 18px; border: none; border-radius: 8px; background: var(--red); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .btn-confirm-red:hover { background: #8b1f18; }

    @media (max-width: 768px) {
      .app-layout { flex-direction: column; }
      .app-sidebar { width: 100%; height: auto; position: static; flex-direction: row; overflow-x: auto; border-right: none; border-bottom: 1px solid rgba(255,255,255,.07); }
      .sidebar-inner { flex-direction: row; padding: 0; }
      .sidebar-nav { flex-direction: row; padding: 10px 12px; gap: 6px; overflow-x: auto; }
      .sidebar-footer { display: none; }
      .page-body { padding: 18px 14px 48px; }
      .notif-toolbar { flex-direction: column; align-items: flex-start; }
    }
  </style>
</head>
<body>

@php
  $authUser    = auth()->user();
  $displayName = trim(($authUser->first_name ?? '') . ' ' . ($authUser->last_name ?? '')) ?: ($authUser->name ?? 'Administrator');
  $sidebarInitials = strtoupper(substr($displayName, 0, 2));
@endphp

<div class="top-stripe"></div>

<!-- ══ HEADER ══ -->
<header class="page-header">
  <div class="header-seal"><img src="{{ asset('img/dar_logo_square.jpg') }}" alt="DAR logo" /></div>
  <div class="header-text">
    <div class="t1">Republic of the Philippines</div>
    <div class="t2">Department of Agrarian Reform</div>
  </div>
  <div class="header-sep"></div>
  <div class="header-page">Notifications</div>
  <div class="reviewer-badge" style="margin-left:10px;">
    <i class="bi bi-bell-fill"></i> Notification Center
  </div>
  <div class="header-actions">
    <a href="{{ route('reviewer') }}" class="notif-btn" title="Back to Dashboard" style="text-decoration:none;">
      <i class="bi bi-arrow-left"></i>
    </a>

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
          <div class="header-user-role">{{ ucfirst($authUser->position ?? $authUser->role ?? 'Admin') }}</div>
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

<!-- ══ LAYOUT ══ -->
<div class="app-layout">

  <!-- ── SIDEBAR ── -->
  <aside class="app-sidebar">
    <div class="sidebar-inner">
      <nav class="sidebar-nav">
        <a href="{{ route('reviewer') }}" class="app-nav-link">
          <span class="nav-icon"><i class="bi bi-journal-text"></i></span>
          <span class="nav-label">Review Transactions</span>
        </a>
        <a href="{{ route('reviewer', ['open_funds' => 1]) }}" class="app-nav-link">
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

  <!-- ── MAIN ── -->
  <div class="app-main">
    <div class="page-body">

      @if(session('success'))
        <div class="alert-bar alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert-bar alert-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
      @endif

      <!-- Page heading -->
      <div style="margin-bottom: 22px; display:flex; align-items:flex-end; justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <div>
          <div class="page-title">All Notifications</div>
          <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
        </div>
        <a href="{{ route('reviewer') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.78rem;font-weight:700;color:var(--green-accent);text-decoration:none;">
          <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
      </div>

      <!-- Summary bar -->
      <div class="summary-bar" id="summary-bar">
        <div class="summary-item">
          <div class="summary-dot" style="background:var(--green-accent);"></div>
          <span>Total: <span class="summary-count" id="count-total">0</span></span>
        </div>
        <div class="summary-sep"></div>
        <div class="summary-item">
          <div class="summary-dot" style="background:var(--red);"></div>
          <span>Unread: <span class="summary-count" id="count-unread">0</span></span>
        </div>
        <div class="summary-sep"></div>
        <div class="summary-item">
          <div class="summary-dot" style="background:var(--gold);"></div>
          <span>Waiting: <span class="summary-count" id="count-waiting">0</span></span>
        </div>
        <div class="summary-sep"></div>
        <div class="summary-item">
          <div class="summary-dot" style="background:var(--green-accent);"></div>
          <span>Approved: <span class="summary-count" id="count-approved">0</span></span>
        </div>
        <div class="summary-sep"></div>
        <div class="summary-item">
          <div class="summary-dot" style="background:var(--red);"></div>
          <span>Rejected: <span class="summary-count" id="count-rejected">0</span></span>
        </div>
      </div>

      <!-- Toolbar: filters + actions -->
      <div class="notif-toolbar">
        <div class="notif-filters" id="notif-filters">
          <button class="filter-pill active" data-filter="all" onclick="setFilter('all', this)">All</button>
          <button class="filter-pill" data-filter="unread" onclick="setFilter('unread', this)">Unread</button>
          <button class="filter-pill" data-filter="approved" onclick="setFilter('approved', this)">Approved</button>
          <button class="filter-pill" data-filter="waiting" onclick="setFilter('waiting', this)">Waiting</button>
          <button class="filter-pill" data-filter="rejected" onclick="setFilter('rejected', this)">Rejected</button>
          <button class="filter-pill" data-filter="forwarded" onclick="setFilter('forwarded', this)">Forwarded</button>
        </div>
        <div class="notif-actions">
          <button class="btn-mark-all" onclick="markAllRead()">
            <i class="bi bi-check2-all"></i> Mark All Read
          </button>
          <button class="btn-clear-all" onclick="openClearModal()">
            <i class="bi bi-trash3"></i> Clear All
          </button>
        </div>
      </div>

      <!-- Notifications list -->
      <div id="notif-list-container">
        <div id="group-today"></div>
        <div id="group-yesterday"></div>
        <div id="group-older"></div>
      </div>

      <!-- Empty state -->
      <div class="notif-empty-state" id="empty-state">
        <div class="empty-icon-wrap"><i class="bi bi-bell-slash"></i></div>
        <div class="empty-title">No Notifications Found</div>
        <div class="empty-sub">You're all caught up! There are no notifications matching your current filter.</div>
      </div>

      <!-- Loading skeleton -->
      <div id="loading-state" style="text-align:center; padding:60px 20px; color:var(--muted); font-size:.84rem;">
        <i class="bi bi-arrow-repeat" style="font-size:1.5rem; display:block; margin-bottom:10px; animation:spin 1s linear infinite;"></i>
        Loading notifications…
      </div>
    </div>
  </div>
</div>

<!-- ── CLEAR ALL CONFIRM MODAL ── -->
<div class="modal-overlay" id="clear-modal" onclick="handleClearOverlay(event)">
  <div class="modal-box">
    <div class="modal-head">
      <div class="modal-head-title"><i class="bi bi-trash3"></i> Clear All Notifications</div>
      <button class="modal-close-btn" onclick="closeClearModal()"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="modal-body-inner">
      Are you sure you want to <strong>delete all notifications</strong>? This action cannot be undone and all notification history will be permanently removed.
    </div>
    <div class="modal-footer-inner">
      <button class="btn-cancel" onclick="closeClearModal()">Cancel</button>
      <button class="btn-confirm-red" onclick="clearAllNotifications()">
        <i class="bi bi-trash3"></i> Yes, Clear All
      </button>
    </div>
  </div>
</div>

<style>
  @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

<script>
  /* ── USER DROPDOWN ── */
  const headerWrap = document.getElementById('headerUserWrap');
  function toggleHeaderDropdown() { headerWrap.classList.toggle('open'); }
  document.addEventListener('click', e => { if (!headerWrap.contains(e.target)) headerWrap.classList.remove('open'); });

  /* ── NOTIFICATIONS DATA & RENDERING ── */
  let ALL_NOTIFS = [];
  let currentFilter = 'all';

  const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  async function fetchAll() {
    try {
      const res = await fetch('/notifications', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      if (!res.ok) throw new Error('fetch failed');
      const raw = await res.json();
      ALL_NOTIFS = raw.map(n => ({
        id:       n.id,
        unread:   !(n.read === true),
        status:   (n.data?.status || 'waiting').toLowerCase(),
        name:     n.data?.name || n.data?.op_number || 'Unknown Payor',
        amount:   n.data?.amount ? '₱' + parseFloat(n.data.amount).toLocaleString('en-PH', { minimumFractionDigits: 2 }) : null,
        fund:     n.data?.fund_type || null,
        op:       n.data?.op_number || null,
        created:  n.created_at || null,
        raw:      n,
      }));
      document.getElementById('loading-state').style.display = 'none';
      render();
    } catch (e) {
      document.getElementById('loading-state').innerHTML = '<i class="bi bi-exclamation-circle" style="font-size:1.4rem;display:block;margin-bottom:8px;color:var(--red);"></i> Failed to load notifications.';
    }
  }

  function timeAgo(dateStr) {
    if (!dateStr) return '';
    try {
      const then = new Date(dateStr), now = new Date();
      const sec = Math.floor((now - then) / 1000);
      if (sec < 10) return 'just now';
      if (sec < 60) return sec + 's ago';
      const min = Math.floor(sec / 60);
      if (min < 60) return min + 'm ago';
      const hr = Math.floor(min / 60);
      if (hr < 24) return hr + 'h ago';
      const days = Math.floor(hr / 24);
      if (days < 30) return days + 'd ago';
      return then.toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
    } catch(e) { return ''; }
  }

  function isToday(dateStr) {
    if (!dateStr) return false;
    const d = new Date(dateStr), now = new Date();
    return d.toDateString() === now.toDateString();
  }

  function isYesterday(dateStr) {
    if (!dateStr) return false;
    const d = new Date(dateStr), yest = new Date();
    yest.setDate(yest.getDate() - 1);
    return d.toDateString() === yest.toDateString();
  }

  function getNotifConfig(status) {
    const map = {
      approved:  { icon: 'bi-check-circle-fill',    cls: 'ni-green',  tagCls: 'tag-approved', label: 'Approved',  typeCls: 'type-approved',  msg: 'has been approved and is ready for printing.' },
      waiting:   { icon: 'bi-hourglass-split',       cls: 'ni-gold',   tagCls: 'tag-waiting',  label: 'Waiting',   typeCls: 'type-waiting',   msg: 'is awaiting your review and action.' },
      rejected:  { icon: 'bi-x-circle-fill',         cls: 'ni-red',    tagCls: 'tag-rejected', label: 'Rejected',  typeCls: 'type-rejected',  msg: 'was rejected. Please check and take action.' },
      forwarded: { icon: 'bi-arrow-right-circle-fill', cls: 'ni-blue', tagCls: 'tag-forwarded', label: 'Forwarded', typeCls: 'type-forwarded', msg: 'has been forwarded to the Accountant.' },
    };
    return map[status] || { icon: 'bi-bell-fill', cls: 'ni-purple', tagCls: 'tag-system', label: 'Update', typeCls: 'type-system', msg: 'has a status update.' };
  }

  function buildCard(n) {
    const cfg   = getNotifConfig(n.status);
    const uCls  = n.unread ? 'unread' : '';
    const dot   = n.unread ? '<div class="unread-dot"></div>' : '';
    const tags  = [
      `<span class="notif-tag ${cfg.tagCls}"><i class="bi ${cfg.icon}"></i> ${cfg.label}</span>`,
      n.fund   ? `<span class="notif-tag tag-amount"><i class="bi bi-bank2"></i> ${esc(n.fund)}</span>` : '',
      n.amount ? `<span class="notif-tag tag-amount"><i class="bi bi-cash-coin"></i> ${esc(n.amount)}</span>` : '',
      n.op     ? `<span class="notif-tag tag-amount"><i class="bi bi-hash"></i> ${esc(n.op)}</span>` : '',
    ].filter(Boolean).join('');

    return `
    <div class="notif-card ${uCls} ${cfg.typeCls}" data-id="${n.id}" data-status="${n.status}" data-unread="${n.unread}" onclick="readAndView('${n.id}')">
      <div class="notif-icon-wrap ${cfg.cls}"><i class="bi ${cfg.icon}"></i></div>
      <div class="notif-content">
        <div class="notif-top">
          <div class="notif-title">Transaction for ${esc(n.name)} ${cfg.msg.split(' ').slice(0, 3).join(' ')}…</div>
          <div class="notif-meta">
            <span class="notif-time">${timeAgo(n.created)}</span>
            ${dot}
          </div>
        </div>
        <div class="notif-body">Payment record for <strong>${esc(n.name)}</strong> ${cfg.msg}</div>
        <div class="notif-tags">${tags}</div>
      </div>
      <div class="notif-card-actions" onclick="event.stopPropagation()">
        ${n.unread ? `<button class="card-action-btn" title="Mark as read" onclick="markOneRead('${n.id}')"><i class="bi bi-check2"></i></button>` : ''}
        <button class="card-action-btn delete" title="Delete" onclick="deleteOne('${n.id}')"><i class="bi bi-trash3"></i></button>
      </div>
    </div>`;
  }

  function render() {
    let list = ALL_NOTIFS;

    if (currentFilter === 'unread')    list = list.filter(n => n.unread);
    else if (currentFilter !== 'all')  list = list.filter(n => n.status === currentFilter);

    // Update counts
    document.getElementById('count-total').textContent    = ALL_NOTIFS.length;
    document.getElementById('count-unread').textContent   = ALL_NOTIFS.filter(n => n.unread).length;
    document.getElementById('count-waiting').textContent  = ALL_NOTIFS.filter(n => n.status === 'waiting').length;
    document.getElementById('count-approved').textContent = ALL_NOTIFS.filter(n => n.status === 'approved').length;
    document.getElementById('count-rejected').textContent = ALL_NOTIFS.filter(n => n.status === 'rejected').length;

    const today     = list.filter(n => isToday(n.created));
    const yesterday = list.filter(n => isYesterday(n.created));
    const older     = list.filter(n => !isToday(n.created) && !isYesterday(n.created));

    function buildGroup(items, label) {
      if (!items.length) return '';
      return `<div class="notif-date-header">${label}</div>` + items.map(buildCard).join('');
    }

    document.getElementById('group-today').innerHTML     = buildGroup(today,     'Today');
    document.getElementById('group-yesterday').innerHTML = buildGroup(yesterday, 'Yesterday');
    document.getElementById('group-older').innerHTML     = buildGroup(older,     'Earlier');

    const empty = document.getElementById('empty-state');
    if (list.length === 0) empty.classList.add('show');
    else empty.classList.remove('show');
  }

  function setFilter(f, el) {
    currentFilter = f;
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    render();
  }

  async function markOneRead(id) {
    try {
      await fetch('/notifications/' + id + '/read', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF }
      });
    } catch(e) {}
    const n = ALL_NOTIFS.find(x => x.id === id);
    if (n) n.unread = false;
    render();
  }

  async function markAllRead() {
    try {
      await fetch('{{ route('notifications.mark_all') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        credentials: 'same-origin'
      });
    } catch(e) {}
    ALL_NOTIFS.forEach(n => n.unread = false);
    render();
  }

  async function deleteOne(id) {
    try {
      await fetch('/notifications/' + id, {
        method: 'DELETE',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF }
      });
    } catch(e) {}
    ALL_NOTIFS = ALL_NOTIFS.filter(n => n.id !== id);
    render();
  }

  async function clearAllNotifications() {
    closeClearModal();
    try {
      await fetch('{{ route('notifications.clear_all') }}', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        credentials: 'same-origin'
      });
    } catch(e) {}
    ALL_NOTIFS = [];
    render();
  }

  function readAndView(id) {
    markOneRead(id);
    // Redirect reviewer to dashboard showing only this notification
    window.location = '/reviewer?notif_id=' + encodeURIComponent(id);
  }

  /* ── CLEAR MODAL ── */
  function openClearModal()  { document.getElementById('clear-modal').classList.add('open'); document.body.style.overflow = 'hidden'; }
  function closeClearModal() { document.getElementById('clear-modal').classList.remove('open'); document.body.style.overflow = ''; }
  function handleClearOverlay(e) { if (e.target === document.getElementById('clear-modal')) closeClearModal(); }
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeClearModal(); });

  function esc(s) {
    return String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  /* ── INIT ── */
  fetchAll();

  // Refresh times every 30s
  setInterval(() => render(), 30000);
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  (function(){
    try {
      document.querySelectorAll('form[action="{{ route('logout') }}"]').forEach(f => {
        f.addEventListener('submit', function(ev){
          ev.preventDefault();
          Swal.fire({
            title: 'Log out?', text: 'Are you sure you want to log out?', icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Yes, log out', cancelButtonText: 'Cancel'
          }).then(r => { if (r.isConfirmed) f.submit(); });
        });
      });
    } catch(e) {}
  })();
</script>

</body>
</html>