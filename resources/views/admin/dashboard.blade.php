<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard — DAR Cashier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="icon" href="{{ asset('img/dar_logo_square.jpg') }}" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --green-deep:   #14532d;
      --green-dark:   #0f1f15;
      --green-mid:    #15803d;
      --green-accent: #16a34a;
      --green-light:  #f0fdf4;
      --slate-50:     #f8fafc;
      --slate-100:    #f1f5f9;
      --slate-200:    #e2e8f0;
      --slate-300:    #cbd5e1;
      --slate-400:    #94a3b8;
      --slate-500:    #64748b;
      --slate-600:    #475569;
      --slate-700:    #334155;
      --slate-800:    #1e293b;
      --slate-900:    #0f172a;
      --gold:         #d97706;
      --red:          #dc2626;
      --font:         'JetBrains Mono', monospace;
      --serif:        'Cormorant Garamond', serif;
    }

    html, body { height: 100%; font-family: var(--font); background: var(--slate-100); color: var(--slate-800); }

    /* ── STRIPE ── */
    .stripe { height: 3px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); position: fixed; top: 0; left: 0; right: 0; z-index: 999; }

    /* ── LAYOUT ── */
    .layout { display: flex; min-height: 100vh; padding-top: 3px; }

    /* ── SIDEBAR ── */
    .sidebar {
      width: 256px;
      flex-shrink: 0;
      background: #fff;
      border-right: 1px solid var(--slate-200);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 3px;
      bottom: 0;
      left: 0;
      z-index: 100;
      overflow: hidden;
    }

    /* Sidebar header */
    .sb-header {
      flex-shrink: 0;
      background: linear-gradient(135deg, var(--green-deep) 0%, var(--green-dark) 100%);
      padding: 14px 12px 12px;
      position: relative;
      overflow: hidden;
    }

    .sb-header::after {
      content: '';
      position: absolute;
      top: -30px; right: -30px;
      width: 100px; height: 100px;
      background: radial-gradient(circle, rgba(255,255,255,.07) 0%, transparent 70%);
      pointer-events: none;
    }

    .sb-brand {
      display: flex;
      align-items: flex-start;
      gap: 9px;
      position: relative;
      z-index: 1;
      margin-bottom: 10px;
    }

    .sb-logo {
      width: 34px; height: 34px;
      border-radius: 9px;
      background: rgba(255,255,255,.95);
      border: 1px solid rgba(255,255,255,.4);
      overflow: hidden;
      flex-shrink: 0;
      padding: 3px;
      display: flex; align-items: center; justify-content: center;
    }

    .sb-logo img { width: 100%; height: 100%; object-fit: contain; display: block; }

    .sb-brand-text { padding-top: 1px; }
    .sb-brand-text .t1 { font-size: 8.5px; font-weight: 600; color: rgba(255,255,255,.45); letter-spacing: .1em; text-transform: uppercase; line-height: 1; margin-bottom: 3px; }
    .sb-brand-text .t2 { font-size: 10px; font-weight: 700; color: rgba(255,255,255,.9); line-height: 1.25; letter-spacing: -.01em; }

    .sb-online {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 2px 8px;
      border-radius: 99px;
      background: rgba(255,255,255,.1);
      border: 1px solid rgba(255,255,255,.15);
      font-size: 8px; color: rgba(255,255,255,.55);
      letter-spacing: .05em;
      position: relative; z-index: 1;
    }

    .sb-online-dot { width: 5px; height: 5px; border-radius: 50%; background: #4ade80; box-shadow: 0 0 5px #4ade80; flex-shrink: 0; }

    /* Sidebar nav */
    .sb-nav { flex: 1; overflow-y: auto; padding: 8px 0; }
    .sb-nav::-webkit-scrollbar { width: 3px; }
    .sb-nav::-webkit-scrollbar-thumb { background: var(--slate-200); border-radius: 4px; }

    .sb-section { font-size: 9px; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--slate-400); padding: 16px 14px 6px; }

    .sb-item {
      display: flex; align-items: center; gap: 9px;
      padding: 5px 10px 5px 12px;
      margin: 0 8px;
      border-radius: 8px;
      text-decoration: none;
      color: var(--slate-500);
      font-size: 11.5px;
      font-weight: 500;
      transition: background .12s, color .12s;
      position: relative;
      cursor: pointer;
    }

    .sb-item:hover { background: var(--slate-50); color: var(--slate-700); }

    .sb-item.active {
      background: var(--green-light);
      color: var(--green-deep);
      font-weight: 600;
    }

    .sb-item.active::before {
      content: '';
      position: absolute;
      left: -8px; top: 0; bottom: 0;
      width: 3px;
      background: var(--green-accent);
      border-radius: 0 3px 3px 0;
    }

    .sb-chip {
      width: 18px; height: 18px;
      border-radius: 5px;
      display: flex; align-items: center; justify-content: center;
      font-size: 9px;
      flex-shrink: 0;
    }

    .chip-green  { background: #dcfce7; color: #15803d; }
    .chip-amber  { background: #fef3c7; color: #d97706; }
    .chip-rose   { background: #fce7f3; color: #be185d; }
    .chip-blue   { background: #dbeafe; color: #1d4ed8; }
    .chip-violet { background: #ede9fe; color: #7c3aed; }

    .sb-item.active .sb-chip { opacity: 1; }
    .sb-item:not(.active) .sb-chip { opacity: .55; }

    /* Sidebar footer */
    .sb-footer {
      flex-shrink: 0;
      border-top: 1px solid var(--slate-100);
      background: #fafafa;
      padding: 8px 10px;
    }

    .sb-user {
      display: flex; align-items: center; gap: 9px;
      padding: 6px;
      border-radius: 8px;
      margin-bottom: 4px;
    }

    .sb-avatar {
      width: 26px; height: 26px;
      border-radius: 8px;
      background: linear-gradient(135deg, var(--green-accent), #4ade80);
      display: flex; align-items: center; justify-content: center;
      font-size: 9px; font-weight: 800; color: #fff;
      flex-shrink: 0; overflow: hidden;
    }

    .sb-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .sb-user-name { font-size: 11px; font-weight: 700; color: var(--slate-800); }
    .sb-user-role { font-size: 9px; color: var(--slate-400); text-transform: capitalize; }

    .sb-signout {
      display: flex; align-items: center; gap: 8px;
      width: 100%; padding: 7px 10px;
      border-radius: 7px;
      border: none; background: none;
      font-family: var(--font); font-size: 11.5px;
      color: rgba(220,38,38,.6);
      cursor: pointer;
      transition: background .12s, color .12s;
    }

    .sb-signout:hover { background: #fef2f2; color: var(--red); }

    /* ── MAIN ── */
    .main {
      flex: 1;
      margin-left: 256px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Top bar */
    .topbar {
      background: #fff;
      border-bottom: 1px solid var(--slate-200);
      padding: 0 28px;
      height: 52px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-shrink: 0;
      position: sticky;
      top: 3px;
      z-index: 50;
    }

    .topbar-left {
      display: flex; align-items: center; gap: 6px;
      font-size: 10px; color: var(--slate-400); letter-spacing: .05em;
    }

    .topbar-left .sep { color: var(--slate-300); }
    .topbar-left .current { color: var(--slate-600); font-weight: 600; }

    .topbar-right { display: flex; align-items: center; gap: 8px; }

    .tb-user {
      display: flex; align-items: center; gap: 8px;
      padding: 5px 10px 5px 6px;
      border-radius: 8px;
      border: 1px solid var(--slate-200);
      background: var(--slate-50);
      cursor: pointer;
      transition: background .12s, border-color .12s;
      position: relative;
      user-select: none;
    }

    .tb-user:hover { background: var(--slate-100); border-color: var(--slate-300); }

    .tb-avatar {
      width: 24px; height: 24px;
      border-radius: 6px;
      background: linear-gradient(135deg, var(--green-accent), #4ade80);
      display: flex; align-items: center; justify-content: center;
      font-size: 8.5px; font-weight: 800; color: #fff; flex-shrink: 0; overflow: hidden;
    }

    .tb-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .tb-name { font-size: 11px; font-weight: 600; color: var(--slate-700); }
    .tb-caret { font-size: 9px; color: var(--slate-400); transition: transform .15s; }
    .tb-user.open .tb-caret { transform: rotate(180deg); }

    .tb-dropdown {
      position: absolute; top: calc(100% + 6px); right: 0;
      min-width: 200px;
      background: #fff;
      border: 1px solid var(--slate-200);
      border-radius: 10px;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,.07), 0 10px 30px -8px rgba(0,0,0,.1);
      overflow: hidden;
      opacity: 0; pointer-events: none;
      transform: translateY(-4px);
      transition: opacity .15s, transform .15s;
      z-index: 200;
    }

    .tb-user.open .tb-dropdown { opacity: 1; pointer-events: all; transform: translateY(0); }

    .tb-drop-header { padding: 12px 14px 10px; border-bottom: 1px solid var(--slate-100); }
    .tb-drop-name { font-size: 11.5px; font-weight: 700; color: var(--slate-800); }
    .tb-drop-email { font-size: 10px; color: var(--slate-400); margin-top: 1px; }

    .tb-drop-item {
      display: flex; align-items: center; gap: 9px;
      padding: 9px 14px;
      font-size: 11px; font-weight: 500; color: var(--slate-600);
      text-decoration: none; cursor: pointer;
      transition: background .1s;
      border: none; background: none; width: 100%; text-align: left;
      font-family: var(--font);
    }

    .tb-drop-item:hover { background: var(--slate-50); }
    .tb-drop-item.danger { color: var(--red); }
    .tb-drop-item.danger:hover { background: #fef2f2; }
    .tb-drop-divider { border: none; border-top: 1px solid var(--slate-100); margin: 3px 0; }

    /* ── PAGE CONTENT ── */
    .page { flex: 1; padding: 28px 32px 60px; max-width: 1160px; width: 100%; }

    .page-title-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; gap: 12px; flex-wrap: wrap; }
    .page-title { font-family: var(--serif); font-size: 1.9rem; font-weight: 700; color: var(--slate-900); line-height: 1; letter-spacing: -.02em; }
    .page-sub { font-size: 10px; color: var(--slate-400); margin-top: 5px; letter-spacing: .03em; }

    /* Stat cards */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px; }

    .stat-card {
      background: #fff;
      border: 1px solid var(--slate-200);
      border-radius: 12px;
      padding: 16px 18px;
      transition: box-shadow .15s, border-color .15s;
      text-decoration: none;
      display: block;
    }

    .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.06); border-color: var(--slate-300); }

    .stat-card-inner { display: flex; align-items: center; gap: 12px; }

    .stat-chip {
      width: 36px; height: 36px;
      border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
      font-size: 14px;
      flex-shrink: 0;
    }

    .stat-value { font-size: 1.4rem; font-weight: 700; color: var(--slate-900); line-height: 1.1; letter-spacing: -.02em; }
    .stat-label { font-size: 9.5px; color: var(--slate-400); margin-top: 3px; letter-spacing: .03em; }

    /* Alerts */
    .alert { display: flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: 8px; margin-bottom: 18px; font-size: 11px; }
    .alert-success { background: var(--green-light); color: var(--green-mid); border: 1px solid #bbf7d0; }
    .alert-danger  { background: #fef2f2; color: var(--red); border: 1px solid #fecaca; }

    /* Cards */
    .card {
      background: #fff;
      border: 1px solid var(--slate-200);
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 16px;
    }

    .card-head {
      padding: 13px 18px;
      border-bottom: 1px solid var(--slate-100);
      display: flex; align-items: center; justify-content: space-between; gap: 10px;
    }

    .card-title {
      display: flex; align-items: center; gap: 8px;
      font-size: 11px; font-weight: 700; color: var(--slate-700);
      letter-spacing: .04em; text-transform: uppercase;
    }

    .card-title-chip {
      width: 18px; height: 18px; border-radius: 5px;
      display: flex; align-items: center; justify-content: center;
      font-size: 9px; flex-shrink: 0;
    }

    .card-body { padding: 18px; }

    /* Table */
    .data-table { width: 100%; border-collapse: collapse; font-size: 11px; }
    .data-table thead tr { border-bottom: 1px solid var(--slate-200); }
    .data-table thead th { padding: 8px 10px; font-size: 9px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--slate-400); text-align: left; white-space: nowrap; }
    .data-table tbody tr { border-bottom: 1px solid var(--slate-100); transition: background .1s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: var(--slate-50); }
    .data-table tbody td { padding: 10px; color: var(--slate-600); vertical-align: middle; }
    .data-table .empty-row td { padding: 20px; text-align: center; color: var(--slate-400); font-style: italic; }

    /* Badges */
    .badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 9px; font-weight: 700; letter-spacing: .05em; text-transform: capitalize; }
    .badge-approved  { background: #dcfce7; color: #15803d; }
    .badge-pending   { background: #fef3c7; color: #d97706; }
    .badge-rejected  { background: #fce7f3; color: #be185d; }
    .badge-submitted { background: #dbeafe; color: #1d4ed8; }

    /* Dash grid */
    .dash-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    /* Quick stats */
    .quick-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .qs-card { padding: 12px 14px; border: 1px solid var(--slate-200); border-radius: 8px; background: var(--slate-50); }
    .qs-value { font-size: 1.1rem; font-weight: 700; color: var(--slate-900); letter-spacing: -.01em; }
    .qs-label { font-size: 9px; color: var(--slate-400); margin-top: 2px; letter-spacing: .03em; }

    /* Fund bars */
    .fund-section { margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--slate-100); }
    .fund-section-label { font-size: 9px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--slate-400); margin-bottom: 10px; }
    .fund-item { margin-bottom: 10px; }
    .fund-item:last-child { margin-bottom: 0; }
    .fund-item-row { display: flex; justify-content: space-between; font-size: 10px; color: var(--slate-600); margin-bottom: 5px; }
    .fund-item-row span:last-child { font-weight: 700; color: var(--slate-700); }
    .fund-bar-track { height: 4px; border-radius: 4px; background: var(--slate-200); overflow: hidden; }
    .fund-bar-fill { height: 100%; border-radius: 4px; background: var(--green-accent); }

    /* Btn */
    .btn { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 7px; border: 1px solid var(--slate-200); background: var(--slate-50); color: var(--slate-500); font-family: var(--font); font-size: 10px; font-weight: 600; cursor: pointer; transition: all .12s; text-decoration: none; white-space: nowrap; }
    .btn:hover { background: var(--slate-100); border-color: var(--slate-300); color: var(--slate-700); }

    @media (max-width: 1024px) { .stat-row { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 768px) {
      .sidebar { display: none; }
      .main { margin-left: 0; }
      .dash-grid { grid-template-columns: 1fr; }
      .page { padding: 20px 16px 48px; }
    }
    @media (max-width: 560px) { .stat-row { grid-template-columns: 1fr 1fr; } }
  </style>
</head>
<body>

@php
  $authUser = auth()->user();
  $displayName = trim(($authUser->first_name ?? '') . ' ' . ($authUser->last_name ?? '')) ?: ($authUser->name ?? 'Administrator');
  $initials = strtoupper(substr($displayName, 0, 1) . (strpos($displayName, ' ') !== false ? substr($displayName, strpos($displayName,' ')+1, 1) : ''));
@endphp

<div class="stripe"></div>

<div class="layout">

  <!-- ── SIDEBAR ── -->
  <aside class="sidebar">

    <div class="sb-header">
      <div class="sb-brand">
        <div class="sb-logo">
          <img src="{{ asset('img/dar_logo_square.jpg') }}" alt="DAR Logo" />
        </div>
        <div class="sb-brand-text">
          <div class="t1">Republic of the Philippines</div>
          <div class="t2">Department of Agrarian Reform<br>Regional Office V</div>
        </div>
      </div>
      <div class="sb-online">
        <span class="sb-online-dot"></span>
        System Online
      </div>
    </div>

    <nav class="sb-nav">

      <div class="sb-section">Main</div>
      <a href="{{ route('admin.dashboard') }}" class="sb-item active">
        <span class="sb-chip chip-green"><i class="bi bi-grid-1x2-fill"></i></span>
        Dashboard
      </a>

      <div class="sb-section">Management</div>
      <a href="{{ route('admin.users') }}" class="sb-item">
        <span class="sb-chip chip-amber"><i class="bi bi-people-fill"></i></span>
        Users
      </a>

      <div class="sb-section">Monitoring</div>
      <a href="{{ route('admin.auditlogs') }}" class="sb-item">
        <span class="sb-chip chip-rose"><i class="bi bi-journal-text"></i></span>
        Audit Logs
      </a>
      <a href="{{ route('admin.history') }}" class="sb-item">
        <span class="sb-chip chip-blue"><i class="bi bi-receipt"></i></span>
        Transaction History
      </a>

    </nav>

    <div class="sb-footer">
      <div class="sb-user">
        <div class="sb-avatar">
          @if(!empty($authUser->profile_picture) && \Illuminate\Support\Facades\Storage::disk('public')->exists($authUser->profile_picture))
            <img src="{{ asset('storage/' . $authUser->profile_picture) }}" alt="{{ $displayName }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
          @else
            {{ $initials }}
          @endif
        </div>
        <div>
          <div class="sb-user-name">{{ $displayName }}</div>
          <div class="sb-user-role">Admin</div>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="sb-signout">
          <i class="bi bi-box-arrow-right"></i>
          Sign Out
        </button>
      </form>
    </div>

  </aside>

  <!-- ── MAIN ── -->
  <div class="main">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <span>Admin</span>
        <span class="sep">/</span>
        <span class="current">Dashboard</span>
      </div>
      <div class="topbar-right">
        <div class="tb-user" id="tbUser" onclick="toggleTbDropdown()">
          <div class="tb-avatar">
            @if(!empty($authUser->profile_picture) && \Illuminate\Support\Facades\Storage::disk('public')->exists($authUser->profile_picture))
              <img src="{{ asset('storage/' . $authUser->profile_picture) }}" alt="{{ $displayName }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;">
            @else
              {{ $initials }}
            @endif
          </div>
          <span class="tb-name">{{ $displayName }}</span>
          <i class="bi bi-chevron-down tb-caret"></i>

          <div class="tb-dropdown">
            <div class="tb-drop-header">
              <div class="tb-drop-name">{{ $displayName }}</div>
              <div class="tb-drop-email">{{ $authUser->email ?? '' }}</div>
            </div>
            <a class="tb-drop-item" href="{{ route('profile') }}">
              <i class="bi bi-person-circle"></i> My Profile
            </a>
            <div class="tb-drop-divider"></div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
              @csrf
              <button type="submit" class="tb-drop-item danger">
                <i class="bi bi-box-arrow-right"></i> Sign Out
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Page content -->
    <div class="page">

      @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
      @endif

      <div class="page-title-row">
        <div>
          <div class="page-title">Dashboard</div>
          <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
        </div>
      </div>

      <!-- Stat cards -->
      <div class="stat-row">
        <a class="stat-card" href="{{ route('admin.users') }}">
          <div class="stat-card-inner">
            <div class="stat-chip chip-green"><i class="bi bi-people-fill"></i></div>
            <div>
              <div class="stat-value">{{ $totalUsers ?? '—' }}</div>
              <div class="stat-label">Total Users</div>
            </div>
          </div>
        </a>

        <a class="stat-card" href="{{ route('admin.history') }}">
          <div class="stat-card-inner">
            <div class="stat-chip chip-blue"><i class="bi bi-receipt"></i></div>
            <div>
              <div class="stat-value">{{ $totalTransactions ?? '—' }}</div>
              <div class="stat-label">Total Transactions</div>
            </div>
          </div>
        </a>

        <a class="stat-card" href="{{ route('accountant.approval') }}">
          <div class="stat-card-inner">
            <div class="stat-chip chip-amber"><i class="bi bi-hourglass-split"></i></div>
            <div>
              <div class="stat-value">{{ $pendingApprovals ?? '—' }}</div>
              <div class="stat-label">Pending Approvals</div>
            </div>
          </div>
        </a>

        <a class="stat-card" href="{{ route('admin.history') }}">
          <div class="stat-card-inner">
            <div class="stat-chip chip-violet"><i class="bi bi-cash-coin"></i></div>
            <div>
              <div class="stat-value" style="font-size:1.1rem;">₱{{ number_format($totalCollected ?? 0, 2) }}</div>
              <div class="stat-label">Total Collected</div>
            </div>
          </div>
        </a>
      </div>

      <!-- Latest transactions -->
      <div class="card">
        <div class="card-head">
          <div class="card-title">
            <span class="card-title-chip chip-blue"><i class="bi bi-clock-history"></i></span>
            Latest Transactions
          </div>
        </div>
        <div class="card-body" style="padding:0;">
          <table class="data-table">
            <thead>
              <tr>
                <th>OP #</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Fund</th>
                <th>Status</th>
                <th>When</th>
              </tr>
            </thead>
            <tbody>
              @forelse(collect($recentPayments ?? [])->take(5) as $p)
                <tr>
                  <td>{{ $p->op_number }}</td>
                  <td>{{ $p->name }}</td>
                  <td>₱{{ number_format($p->amount, 2) }}</td>
                  <td>{{ $p->fund_type }}</td>
                  @php
                    $rawStatus = $p->status ?? '';
                    $statusSlug = strtolower($rawStatus);
                    if ($statusSlug === 'accountant_rejected') $statusSlug = 'rejected';
                    $statusLabel = $statusSlug === 'rejected' ? 'Rejected' : ucwords(str_replace('_', ' ', $rawStatus));
                  @endphp
                  <td><span class="badge badge-{{ $statusSlug }}">{{ $statusLabel }}</span></td>
                  <td>{{ optional($p->updated_at)->diffForHumans() }}</td>
                </tr>
              @empty
                <tr class="empty-row"><td colspan="6">No recent transactions.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Bottom grid -->
      <div class="dash-grid">

        <!-- Recent users -->
        <div class="card" style="margin-bottom:0;">
          <div class="card-head">
            <div class="card-title">
              <span class="card-title-chip chip-amber"><i class="bi bi-people-fill"></i></span>
              Recent Users
            </div>
          </div>
          <div class="card-body" style="padding:0;">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Joined</th>
                </tr>
              </thead>
              <tbody>
                @forelse(collect($recentUsers ?? [])->take(5) as $ru)
                  <tr>
                    <td>{{ trim(($ru->first_name ?? '') . ' ' . ($ru->last_name ?? '')) }}</td>
                    <td>{{ $ru->email }}</td>
                    <td>{{ $ru->position ?? '—' }}</td>
                    <td>{{ $ru->created_at->format('M d, Y') }}</td>
                  </tr>
                @empty
                  <tr class="empty-row"><td colspan="4">No recent users found.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- System overview -->
        <div class="card" style="margin-bottom:0;">
          <div class="card-head">
            <div class="card-title">
              <span class="card-title-chip chip-violet"><i class="bi bi-pie-chart-fill"></i></span>
              System Overview
            </div>
            <button id="toggle-funds" class="btn">Toggle Funds</button>
          </div>
          <div class="card-body">
            <div class="quick-stats">
              <div class="qs-card">
                <div class="qs-value">{{ $approvedCount ?? '—' }}</div>
                <div class="qs-label">Approved Today</div>
              </div>
              <div class="qs-card">
                <div class="qs-value">{{ $rejectedCount ?? '—' }}</div>
                <div class="qs-label">Rejected Today</div>
              </div>
              <div class="qs-card">
                <div class="qs-value">{{ $activeUsers ?? '—' }}</div>
                <div class="qs-label">Active Users</div>
              </div>
              <div class="qs-card">
                <div class="qs-value">{{ $logsToday ?? '—' }}</div>
                <div class="qs-label">Log Entries Today</div>
              </div>
              <div class="qs-card">
                <div class="qs-value">₱{{ number_format($avgAmount ?? 0, 2) }}</div>
                <div class="qs-label">Avg. Transaction</div>
              </div>
              <div class="qs-card">
                <div class="qs-value">{{ $fundsUsed ?? '5' }}</div>
                <div class="qs-label">Funds Active</div>
              </div>
            </div>

            <div class="fund-section" id="fund-breakdown">
              <div class="fund-section-label">Fund Breakdown</div>
              @foreach(['Fund 01 — Regular' => 65, 'Fund 03 — ARF' => 20, 'Fund 07 — Trust' => 10, 'Fund 02 (LP/GOP)' => 5] as $fund => $pct)
                <div class="fund-item">
                  <div class="fund-item-row">
                    <span>{{ $fund }}</span>
                    <span>{{ $pct }}%</span>
                  </div>
                  <div class="fund-bar-track">
                    <div class="fund-bar-fill" style="width:{{ $pct }}%;"></div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Topbar dropdown
  const tbUser = document.getElementById('tbUser');
  function toggleTbDropdown() { tbUser.classList.toggle('open'); }
  document.addEventListener('click', e => { if (!tbUser.contains(e.target)) tbUser.classList.remove('open'); });

  // Fund toggle
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('toggle-funds');
    const fb  = document.getElementById('fund-breakdown');
    if (btn && fb) btn.addEventListener('click', () => { fb.style.display = fb.style.display === 'none' ? '' : 'none'; });
  });

  // Logout confirmation
  document.querySelectorAll('form[action="{{ route('logout') }}"]').forEach(f => {
    f.addEventListener('submit', function(ev) {
      ev.preventDefault();
      Swal.fire({
        title: 'Sign out?',
        text: 'Are you sure you want to sign out?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sign out',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#14532d'
      }).then(result => { if (result.isConfirmed) f.submit(); });
    });
  });
</script>
</body>
</html>
