<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaction History — DAR Cashier</title>
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
      max-width: 1200px;
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

    .page-title-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 20px;
      background: var(--green-light);
      color: var(--green-accent);
      font-size: .72rem;
      font-weight: 700;
      border: 1px solid rgba(45,122,79,.15);
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
       FILTER CARD
    ════════════════════════════════════════════ */
    .filter-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 18px 20px;
      margin-bottom: 18px;
    }

    .filter-card-title {
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 14px;
      display: flex;
      align-items: center;
      gap: 7px;
    }

    .filter-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr) auto;
      gap: 12px;
      align-items: end;
    }

    .filter-group { display: flex; flex-direction: column; gap: 5px; }

    .filter-label {
      font-size: .68rem;
      font-weight: 600;
      color: var(--text-mid);
      letter-spacing: .5px;
    }

    .filter-input {
      padding: 8px 11px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      font-family: 'DM Sans', sans-serif;
      font-size: .8rem;
      color: var(--text-dark);
      background: #faf8f4;
      transition: border-color .15s, box-shadow .15s;
      outline: none;
      width: 100%;
    }

    .filter-input:focus {
      border-color: var(--green-accent);
      box-shadow: 0 0 0 3px rgba(45,122,79,.08);
      background: #fff;
    }

    .filter-actions {
      display: flex;
      gap: 8px;
      align-items: flex-end;
      padding-bottom: 1px;
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

    .dash-card-meta {
      font-size: .72rem;
      color: rgba(245,240,232,.45);
    }

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
      background: #faf8f4;
    }

    .data-table thead th {
      padding: 11px 14px;
      font-size: .67rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--muted);
      text-align: left;
      white-space: nowrap;
    }

    .data-table tbody tr {
      border-bottom: 1px solid var(--border);
      transition: background .12s;
    }

    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #faf8f4; }

    .data-table tbody td {
      padding: 11px 14px;
      color: var(--text-mid);
      vertical-align: middle;
    }

    .data-table .empty-row td {
      padding: 40px;
      text-align: center;
      color: var(--muted);
      font-style: italic;
    }

    /* ════════════════════════════════════════════
       STATUS BADGES
    ════════════════════════════════════════════ */
    .badge-status {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: .5px;
      text-transform: capitalize;
      white-space: nowrap;
    }

    .badge-status::before {
      content: '';
      display: inline-block;
      width: 6px;
      height: 6px;
      border-radius: 50%;
    }

    .badge-approved { background: var(--green-light); color: var(--green-accent); }
    .badge-approved::before { background: var(--green-accent); }
    .badge-pending  { background: #fff7ed; color: #c2640a; }
    .badge-pending::before  { background: #c2640a; }
    .badge-rejected { background: #fdf0ef; color: var(--red); }
    .badge-rejected::before { background: var(--red); }

    /* ════════════════════════════════════════════
       FUND TAG
    ════════════════════════════════════════════ */
    .fund-tag {
      display: inline-block;
      padding: 3px 9px;
      border-radius: 6px;
      font-size: .68rem;
      font-weight: 600;
      background: #eef3fc;
      color: #2a5fa0;
      white-space: nowrap;
    }

    /* ════════════════════════════════════════════
       AMOUNT CELL
    ════════════════════════════════════════════ */
    .amount-cell {
      font-weight: 700;
      color: var(--text-dark);
      font-variant-numeric: tabular-nums;
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
       RESPONSIVE
    ════════════════════════════════════════════ */
    @media (max-width: 1100px) {
      .filter-grid { grid-template-columns: 1fr 1fr 1fr; }
      .filter-actions { grid-column: 1 / -1; }
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
      .filter-grid { grid-template-columns: 1fr 1fr; }
      .data-table { font-size: .75rem; }
      .data-table thead th, .data-table tbody td { padding: 9px 10px; }
    }

    @media (max-width: 560px) {
      .filter-grid { grid-template-columns: 1fr; }
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
    <div class="header-page">Transaction History</div>
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
        <a class="nav-item" href="{{ route('profile') }}">
          <div class="nav-icon"><i class="bi bi-person-circle"></i></div>
          <span class="nav-label">My Profile</span>
        </a>

        <div class="nav-section-label" style="margin-top:16px;">Monitoring</div>
        <a class="nav-item" href="{{ route('admin.auditlogs') }}">
          <div class="nav-icon"><i class="bi bi-journal-text"></i></div>
          <span class="nav-label">Audit Logs</span>
        </a>
        <a class="nav-item active" href="{{ route('admin.history') }}">
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

        <!-- Alert Messages -->
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
            <div class="page-title">Transaction History</div>
            <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
          </div>
          <div class="page-title-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-action">
              <i class="bi bi-arrow-left"></i> Back
            </a>
            <span class="page-title-badge">
              <i class="bi bi-receipt"></i> All Transactions
            </span>
          </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
          <div class="filter-card-title">
            <i class="bi bi-funnel-fill"></i> Filter Transactions
          </div>
          <form method="GET" action="{{ route('admin.history') }}">
            <div class="filter-grid">

              <div class="filter-group">
                <label class="filter-label">Search</label>
                <input
                  type="text"
                  name="search"
                  class="filter-input"
                  placeholder="Name, OP #…"
                  value="{{ request('search') }}"
                />
              </div>

              <div class="filter-group">
                <label class="filter-label">Status</label>
                <select name="status" class="filter-input">
                  <option value="">All Statuses</option>
                  <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                  <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                  <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
              </div>

              <div class="filter-group">
                <label class="filter-label">Fund Type</label>
                <select name="fund_type" class="filter-input">
                  <option value="">All Funds</option>
                  <option value="Fund 01" {{ request('fund_type') === 'Fund 01' ? 'selected' : '' }}>Fund 01 — Regular</option>
                  <option value="Fund 02" {{ request('fund_type') === 'Fund 02' ? 'selected' : '' }}>Fund 02 (LP/GOP)</option>
                  <option value="Fund 03" {{ request('fund_type') === 'Fund 03' ? 'selected' : '' }}>Fund 03 — ARF</option>
                  <option value="Fund 07" {{ request('fund_type') === 'Fund 07' ? 'selected' : '' }}>Fund 07 — Trust</option>
                </select>
              </div>

              <div class="filter-group">
                <label class="filter-label">Date From</label>
                <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}" />
              </div>

              <div class="filter-group">
                <label class="filter-label">Date To</label>
                <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}" />
              </div>

              <div class="filter-actions">
                <button type="submit" class="btn-action btn-primary">
                  <i class="bi bi-search"></i> Search
                </button>
                <a href="{{ route('admin.history') }}" class="btn-action">
                  <i class="bi bi-x-circle"></i> Reset
                </a>
              </div>

            </div>
          </form>
        </div>

        <!-- Transactions Table -->
        <div class="dash-card">
          <div class="dash-card-head">
            <div class="dash-card-title">
              <i class="bi bi-clock-history"></i> All Transactions
            </div>
            <div class="dash-card-meta">
              Total {{ $transactions->total() ?? $transactions->count() ?? 0 }} records
            </div>
          </div>

          <table class="data-table">
            <thead>
              <tr>
                <th>Type</th>
                <th>Fund</th>
                <th>Payer</th>
                <th>Amount</th>
                <th>Mode</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transactions as $t)
                <tr>
                  <td>{{ $t->transaction_type ?? '—' }}</td>
                  <td><span class="fund-tag">{{ $t->fund_type ?? '—' }}</span></td>
                  <td>{{ $t->name ?? ($t->email ?? '—') }}</td>
                  <td class="amount-cell">₱{{ number_format($t->amount, 2) }}</td>
                  <td>{{ $t->payment_mode ?? '—' }}</td>
                  <td>
                    @php $s = strtolower($t->status ?? ''); @endphp
                    @if(in_array($s, ['approved','paid','completed']))
                      <span class="badge-status badge-approved">{{ $t->status }}</span>
                    @elseif(in_array($s, ['waiting','pending']))
                      <span class="badge-status badge-pending">{{ $t->status }}</span>
                    @elseif(in_array($s, ['rejected','failed','canceled','cancelled']))
                      <span class="badge-status badge-rejected">{{ $t->status }}</span>
                    @else
                      <span class="badge-status" style="background:#f3f4f6;color:#374151;">{{ $t->status }}</span>
                    @endif
                  </td>
                  <td>
                    {{ optional($t->created_at)->format('M d, Y') }}<br>
                    <small style="color:var(--muted);font-size:.67rem;">{{ optional($t->created_at)->format('h:i A') }}</small>
                  </td>
                </tr>
              @empty
                <tr class="empty-row">
                  <td colspan="7">
                    <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                    No transactions found.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>

        </div><!-- /.dash-card -->

      </div><!-- /.page-body -->
    </main>

  </div><!-- /.outer-wrapper -->

</body>
</html>