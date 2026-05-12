<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Audit Logs — DAR Cashier</title>
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
    .main-content {
      flex: 1;
      min-width: 0;
    }

    .page-body {
      max-width: 1100px;
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
      margin-bottom: 24px;
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

    .page-title-actions {
      display: flex;
      gap: 8px;
      align-items: center;
      flex-wrap: wrap;
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

    /* ════════════════════════════════════════════
       FILTER BAR
    ════════════════════════════════════════════ */
    .filter-bar {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-md);
      padding: 14px 18px;
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
      margin-bottom: 18px;
    }

    .filter-bar input,
    .filter-bar select {
      padding: 7px 11px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      font-family: 'DM Sans', sans-serif;
      font-size: .78rem;
      color: var(--text-dark);
      background: var(--bg);
      outline: none;
      transition: border-color .15s;
    }

    .filter-bar input:focus,
    .filter-bar select:focus {
      border-color: var(--green-accent);
    }

    .filter-bar input { width: 220px; }

    .filter-bar select { width: 160px; }

    .filter-label {
      font-size: .7rem;
      font-weight: 700;
      color: var(--muted);
      letter-spacing: 1px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .filter-sep {
      width: 1px;
      height: 20px;
      background: var(--border);
      flex-shrink: 0;
    }

    /* ════════════════════════════════════════════
       DASH CARD
    ════════════════════════════════════════════ */
    .dash-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden;
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

    .dash-card-count {
      font-size: .7rem;
      font-weight: 600;
      padding: 3px 10px;
      border-radius: 20px;
      background: rgba(201,153,42,.18);
      color: var(--gold-light);
      letter-spacing: .5px;
    }

    .dash-card-body { padding: 0; }

    /* ════════════════════════════════════════════
       DATA TABLE
    ════════════════════════════════════════════ */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      font-size: .82rem;
    }

    .data-table thead tr {
      border-bottom: 2px solid var(--border);
    }

    .data-table thead th {
      padding: 10px 16px;
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--muted);
      text-align: left;
      white-space: nowrap;
      background: #faf8f4;
    }

    .data-table tbody tr {
      border-bottom: 1px solid var(--border);
      transition: background .12s;
    }

    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #faf8f4; }

    .data-table tbody td {
      padding: 11px 16px;
      color: var(--text-mid);
      vertical-align: middle;
    }

    .data-table .empty-row td {
      padding: 24px;
      text-align: center;
      color: var(--muted);
      font-style: italic;
    }

    /* Row number */
    .td-num {
      font-size: .72rem;
      color: var(--muted);
      font-weight: 500;
      width: 44px;
    }

    /* User cell */
    .user-cell {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .user-avatar {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--green-accent), var(--green-mid));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .6rem;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    .user-name {
      font-weight: 600;
      color: var(--text-dark);
      font-size: .8rem;
    }

    /* Action badge */
    .action-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: .67rem;
      font-weight: 700;
      letter-spacing: .4px;
      white-space: nowrap;
    }

    .ab-login    { background: var(--green-light); color: var(--green-accent); }
    .ab-logout   { background: #f0f4ff; color: #2a5fa0; }
    .ab-create   { background: #fdf3dc; color: var(--gold); }
    .ab-update   { background: #fff7ed; color: #c2640a; }
    .ab-delete   { background: #fdf0ef; color: var(--red); }
    .ab-view     { background: #f0f4ff; color: #2a5fa0; }
    .ab-default  { background: #f4f1eb; color: var(--muted); }

    /* Description */
    .td-desc {
      max-width: 320px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-size: .79rem;
      color: var(--text-mid);
    }

    /* IP address */
    .td-ip {
      font-family: 'Courier New', monospace;
      font-size: .74rem;
      color: var(--muted);
    }

    /* Date */
    .td-date {
      font-size: .76rem;
      color: var(--muted);
      white-space: nowrap;
    }

    /* ════════════════════════════════════════════
       PAGINATION
    ════════════════════════════════════════════ */
    .pagination-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px;
      border-top: 1.5px solid var(--border);
      background: #faf8f4;
      flex-wrap: wrap;
      gap: 12px;
    }

    .pagination-info {
      font-size: .75rem;
      color: var(--muted);
    }

    .pagination-info strong {
      color: var(--text-mid);
    }

    .pagination-controls {
      display: flex;
      gap: 4px;
      align-items: center;
    }

    .page-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      border-radius: var(--radius-sm);
      border: 1.5px solid var(--border);
      background: var(--surface);
      color: var(--text-mid);
      font-size: .78rem;
      font-weight: 600;
      cursor: pointer;
      transition: all .15s;
      text-decoration: none;
    }

    .page-btn:hover {
      background: var(--green-light);
      border-color: var(--green-accent);
      color: var(--green-accent);
    }

    .page-btn.active {
      background: var(--green-accent);
      border-color: var(--green-accent);
      color: #fff;
    }

    .page-btn.disabled {
      opacity: .4;
      cursor: not-allowed;
      pointer-events: none;
    }

    /* ════════════════════════════════════════════
       EMPTY STATE
    ════════════════════════════════════════════ */
    .empty-state {
      padding: 48px 24px;
      text-align: center;
    }

    .empty-state-icon {
      font-size: 2.2rem;
      color: var(--border);
      margin-bottom: 12px;
    }

    .empty-state-title {
      font-size: .9rem;
      font-weight: 600;
      color: var(--text-mid);
      margin-bottom: 4px;
    }

    .empty-state-sub {
      font-size: .78rem;
      color: var(--muted);
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
       RESPONSIVE
    ════════════════════════════════════════════ */
    @media (max-width: 1024px) {
      .filter-bar input { width: 160px; }
    }

    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }
      .sidebar { width: 100%; height: auto; position: static; }
      .sidebar-profile, .sidebar-divider, .nav-section-label, .sidebar-footer { display: none; }
      .sidebar-inner { display: flex; overflow-x: auto; padding: 8px 0; }
      .nav-item { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
      .nav-item.active { border-bottom-color: var(--gold); }
      .page-body { padding: 20px 16px 48px; }
      .page-title-row { flex-direction: column; align-items: flex-start; }
      .page-title-actions { width: 100%; }
      .filter-bar { gap: 8px; }
      .filter-bar input,
      .filter-bar select { width: 100%; }
      .filter-sep { display: none; }
      td.td-ip,
      th:nth-child(4) { display: none; }
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
        <a class="nav-item active" href="{{ route('admin.auditlogs') }}">
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

        <!-- Page Title -->
        <div class="page-title-row">
          <div>
            <div class="page-title">Audit Logs</div>
            <div class="page-sub">System audit trail — all user actions are recorded here</div>
          </div>
          <div class="page-title-actions">
            <a href="{{ route('admin.auditlogs') }}" class="btn-action">
              <i class="bi bi-arrow-clockwise"></i> Refresh
            </a>
            {{-- Export button if needed --}}
            {{-- <a href="#" class="btn-action"><i class="bi bi-download"></i> Export CSV</a> --}}
          </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
          <span class="filter-label">Filter</span>
          <div class="filter-sep"></div>
          <form method="GET" action="{{ route('admin.auditlogs') }}" style="display:contents;">
            <input
              type="text"
              name="search"
              placeholder="Search user or description…"
              value="{{ request('search') }}"
            >
            <select name="action">
              <option value="">All Actions</option>
              <option value="login"   {{ request('action') === 'login'   ? 'selected' : '' }}>Login</option>
              <option value="logout"  {{ request('action') === 'logout'  ? 'selected' : '' }}>Logout</option>
              <option value="create"  {{ request('action') === 'create'  ? 'selected' : '' }}>Create</option>
              <option value="update"  {{ request('action') === 'update'  ? 'selected' : '' }}>Update</option>
              <option value="delete"  {{ request('action') === 'delete'  ? 'selected' : '' }}>Delete</option>
              <option value="view"    {{ request('action') === 'view'    ? 'selected' : '' }}>View</option>
            </select>
            <button type="submit" class="btn-action" style="background:var(--green-accent);border-color:var(--green-accent);color:#fff;">
              <i class="bi bi-search"></i> Search
            </button>
            @if(request('search') || request('action'))
              <a href="{{ route('admin.auditlogs') }}" class="btn-action">
                <i class="bi bi-x-lg"></i> Clear
              </a>
            @endif
          </form>
        </div>

        <!-- Audit Logs Table Card -->
        <div class="dash-card">
          <div class="dash-card-head">
            <div class="dash-card-title">
              <i class="bi bi-journal-text"></i> System Audit Trail
            </div>
            @if(isset($logs))
              <div class="dash-card-count">{{ $logs->total() }} entries</div>
            @endif
          </div>

          <div class="dash-card-body">
            @if(!isset($logs) || $logs->count() === 0)
              <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-journal-x"></i></div>
                <div class="empty-state-title">No audit logs found</div>
                <div class="empty-state-sub">
                  @if(request('search') || request('action'))
                    Try adjusting your filters.
                  @else
                    Activity will appear here once users start performing actions.
                  @endif
                </div>
              </div>
            @else
              <table class="data-table">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Date &amp; Time</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($logs as $log)
                    @php
                      $action  = strtolower($log->action ?? '');
                      $badgeCls = match(true) {
                        str_contains($action, 'login')  => 'ab-login',
                        str_contains($action, 'logout') => 'ab-logout',
                        str_contains($action, 'create') => 'ab-create',
                        str_contains($action, 'update') => 'ab-update',
                        str_contains($action, 'delete') => 'ab-delete',
                        str_contains($action, 'view')   => 'ab-view',
                        default                          => 'ab-default',
                      };
                      $badgeIcon = match(true) {
                        str_contains($action, 'login')  => 'bi-box-arrow-in-right',
                        str_contains($action, 'logout') => 'bi-box-arrow-right',
                        str_contains($action, 'create') => 'bi-plus-circle',
                        str_contains($action, 'update') => 'bi-pencil',
                        str_contains($action, 'delete') => 'bi-trash',
                        str_contains($action, 'view')   => 'bi-eye',
                        default                          => 'bi-activity',
                      };

                      // Build display name from available user attributes
                      $u = $log->user;
                      if ($u) {
                        $userName = $u->name ?? trim(($u->first_name ?? '') . ' ' . ($u->middle_name ?? '') . ' ' . ($u->last_name ?? ''));
                        if (empty(trim($userName))) {
                          $userName = $u->username ?? $u->email ?? '—';
                        }
                      } else {
                        $userName = '—';
                      }

                      // Compute initials safely
                      $initials = collect(explode(' ', $userName))
                                    ->filter()
                                    ->map(fn($w) => strtoupper(substr($w,0,1)))
                                    ->take(2)
                                    ->implode('');
                      if (empty($initials)) $initials = '?';
                    @endphp
                    <tr>
                      <td>
                        <div class="user-cell">
                          <div class="user-avatar">{{ $initials !== '—' ? $initials : '?' }}</div>
                          <span class="user-name">{{ $userName }}</span>
                        </div>
                      </td>
                      <td>
                        <span class="action-badge {{ $badgeCls }}">
                          <i class="bi {{ $badgeIcon }}"></i>
                          {{ $log->action }}
                        </span>
                      </td>
                      <td>
                        <span class="td-desc" title="{{ $log->description }}">{{ $log->description }}</span>
                      </td>
                      <td class="td-ip">{{ $log->ip_address ?? '—' }}</td>
                      <td class="td-date">{{ optional($log->created_at)->format('Y-m-d H:i') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <div class="pagination-row">
                <div class="pagination-info">
                  Showing
                  <strong>{{ $logs->firstItem() }}</strong>–<strong>{{ $logs->lastItem() }}</strong>
                  of <strong>{{ $logs->total() }}</strong> entries
                </div>
                <div class="pagination-controls">
                  @if($logs->onFirstPage())
                    <span class="page-btn disabled"><i class="bi bi-chevron-left"></i></span>
                  @else
                    <a class="page-btn" href="{{ $logs->appends(request()->query())->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                  @endif

                  @foreach($logs->appends(request()->query())->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url)
                    @if($page == $logs->currentPage())
                      <span class="page-btn active">{{ $page }}</span>
                    @else
                      <a class="page-btn" href="{{ $url }}">{{ $page }}</a>
                    @endif
                  @endforeach

                  @if($logs->hasMorePages())
                    <a class="page-btn" href="{{ $logs->appends(request()->query())->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                  @else
                    <span class="page-btn disabled"><i class="bi bi-chevron-right"></i></span>
                  @endif
                </div>
              </div>
            @endif
          </div>
        </div>

      </div><!-- /.page-body -->
    </main>

  </div><!-- /.outer-wrapper -->

</body>
</html>