<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard — DAR Cashier</title>
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
       STAT CARDS
    ════════════════════════════════════════════ */
    .stat-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 28px;
    }

    .stat-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-md);
      padding: 16px 18px;
      transition: box-shadow .2s;
    }

    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }

    .stat-card a {
      display: flex;
      align-items: center;
      gap: 14px;
      text-decoration: none;
      color: inherit;
      width: 100%;
    }

    .stat-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0;
    }

    .si-green { background: var(--green-light); color: var(--green-accent); }
    .si-gold  { background: #fdf3dc; color: var(--gold); }
    .si-amber { background: #fff7ed; color: #c2640a; }
    .si-blue  { background: #eef3fc; color: #2a5fa0; }

    .stat-value {
      font-size: 1.35rem;
      font-weight: 700;
      color: var(--text-dark);
      line-height: 1.2;
    }

    .stat-label {
      font-size: .7rem;
      color: var(--muted);
      font-weight: 400;
      margin-top: 2px;
    }

    /* ════════════════════════════════════════════
       DATA TABLES
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
      padding: 8px 10px;
      font-size: .68rem;
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
      padding: 10px 10px;
      color: var(--text-mid);
      vertical-align: middle;
    }

    .data-table .empty-row td {
      padding: 18px;
      text-align: center;
      color: var(--muted);
      font-style: italic;
    }

    /* Status badges */
    .badge-status {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: .5px;
      text-transform: capitalize;
    }

    .badge-approved  { background: var(--green-light); color: var(--green-accent); }
    .badge-pending   { background: #fff7ed; color: #c2640a; }
    .badge-rejected  { background: #fdf0ef; color: var(--red); }

    /* ════════════════════════════════════════════
       DASH CARDS
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

    .dash-card-body { padding: 20px; }

    /* ════════════════════════════════════════════
       BOTTOM DASH GRID
    ════════════════════════════════════════════ */
    .dash-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
      margin-bottom: 18px;
    }

    /* ════════════════════════════════════════════
       SYSTEM OVERVIEW QUICK STATS
    ════════════════════════════════════════════ */
    .quick-stats {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 0;
    }

    .quick-stat {
      padding: 13px 16px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      background: #faf8f4;
    }

    .qs-value {
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--text-dark);
    }

    .qs-label {
      font-size: .68rem;
      color: var(--muted);
      margin-top: 3px;
    }

    /* ════════════════════════════════════════════
       FUND BREAKDOWN
    ════════════════════════════════════════════ */
    .fund-breakdown-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 18px 0 10px;
    }

    .fund-breakdown-label {
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--muted);
    }

    .fund-item { margin-bottom: 10px; }
    .fund-item:last-child { margin-bottom: 0; }

    .fund-item-row {
      display: flex;
      justify-content: space-between;
      font-size: .76rem;
      color: var(--text-mid);
      margin-bottom: 5px;
    }

    .fund-item-row span:last-child { font-weight: 700; }

    .fund-bar-track {
      height: 5px;
      border-radius: 4px;
      background: var(--border);
      overflow: hidden;
    }

    .fund-bar-fill {
      height: 100%;
      border-radius: 4px;
      background: var(--green-accent);
    }

    /* ════════════════════════════════════════════
       SECTION DIVIDER
    ════════════════════════════════════════════ */
    .section-divider {
      border: none;
      border-top: 1px dashed var(--border);
      margin: 16px 0;
    }

    /* ════════════════════════════════════════════
       RESPONSIVE
    ════════════════════════════════════════════ */
    @media (max-width: 1024px) {
      .stat-row { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }
      .sidebar { width: 100%; height: auto; position: static; }
      .sidebar-profile, .sidebar-divider, .nav-section-label, .sidebar-footer { display: none; }
      .sidebar-inner { display: flex; overflow-x: auto; padding: 8px 0; }
      .nav-item { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
      .nav-item.active { border-bottom-color: var(--gold); }
      .dash-grid { grid-template-columns: 1fr; }
      .page-body { padding: 20px 16px 48px; }
      .page-title-row { flex-direction: column; align-items: flex-start; }
      .page-title-actions { width: 100%; }
    }

    @media (max-width: 560px) {
      .stat-row { grid-template-columns: 1fr 1fr; }
      .quick-stats { grid-template-columns: 1fr 1fr; }
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
        <a class="nav-item active" href="{{ route('admin.dashboard') }}">
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
            <div class="page-title">Dashboard</div>
            <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
          </div>
          <div class="page-title-actions">
          </div>
        </div>

        <!-- Stat Cards -->
        <div class="stat-row">
          <div class="stat-card">
            <a href="{{ route('admin.users') }}">
              <div class="stat-icon si-green"><i class="bi bi-people-fill"></i></div>
              <div>
                <div class="stat-value">{{ $totalUsers ?? '—' }}</div>
                <div class="stat-label">Total Users</div>
              </div>
            </a>
          </div>

          <div class="stat-card">
            <a href="{{ route('payments.index') }}">
              <div class="stat-icon si-gold"><i class="bi bi-receipt"></i></div>
              <div>
                <div class="stat-value">{{ $totalTransactions ?? '—' }}</div>
                <div class="stat-label">Total Transactions</div>
              </div>
            </a>
          </div>

          <div class="stat-card">
            <a href="{{ route('accountant.approval') }}">
              <div class="stat-icon si-amber"><i class="bi bi-hourglass-split"></i></div>
              <div>
                <div class="stat-value">{{ $pendingApprovals ?? '—' }}</div>
                <div class="stat-label">Pending Approvals</div>
              </div>
            </a>
          </div>

          <div class="stat-card">
            <a href="{{ route('admin.history') }}">
              <div class="stat-icon si-blue"><i class="bi bi-cash-coin"></i></div>
              <div>
                <div class="stat-value">₱{{ number_format($totalCollected ?? 0, 2) }}</div>
                <div class="stat-label">Total Collected</div>
              </div>
            </a>
          </div>
        </div>

        <!-- Latest Transactions (full-width) -->
        <div class="dash-card" style="margin-bottom: 18px;">
          <div class="dash-card-head">
            <div class="dash-card-title">
              <i class="bi bi-clock-history"></i> Latest Transactions
            </div>
          </div>
          <div class="dash-card-body">
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
                    <td>
                      <span class="badge-status badge-{{ $statusSlug }}">
                        {{ $statusLabel }}
                      </span>
                    </td>
                    <td>{{ optional($p->updated_at)->diffForHumans() }}</td>
                  </tr>
                @empty
                  <tr class="empty-row">
                    <td colspan="6">No recent transactions.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- Bottom Grid: Recent Users + System Overview -->
        <div class="dash-grid">

          <!-- Recent Users -->
          <div class="dash-card">
            <div class="dash-card-head">
              <div class="dash-card-title">
                <i class="bi bi-people-fill"></i> Recent Users
              </div>
            </div>
            <div class="dash-card-body">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
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
                    <tr class="empty-row">
                      <td colspan="4">No recent users found.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <!-- System Overview -->
          <div class="dash-card">
            <div class="dash-card-head">
              <div class="dash-card-title">
                <i class="bi bi-pie-chart-fill"></i> System Overview
              </div>
            </div>
            <div class="dash-card-body">

              <div class="quick-stats">
                <div class="quick-stat">
                  <div class="qs-value">{{ $approvedCount ?? '—' }}</div>
                  <div class="qs-label">Approved Today</div>
                </div>
                <div class="quick-stat">
                  <div class="qs-value">{{ $rejectedCount ?? '—' }}</div>
                  <div class="qs-label">Rejected Today</div>
                </div>
                <div class="quick-stat">
                  <div class="qs-value">{{ $activeUsers ?? '—' }}</div>
                  <div class="qs-label">Active Users</div>
                </div>
                <div class="quick-stat">
                  <div class="qs-value">{{ $logsToday ?? '—' }}</div>
                  <div class="qs-label">Log Entries Today</div>
                </div>
                <div class="quick-stat">
                  <div class="qs-value">₱{{ number_format($avgAmount ?? 0, 2) }}</div>
                  <div class="qs-label">Avg. Transaction</div>
                </div>
                <div class="quick-stat">
                  <div class="qs-value">{{ $fundsUsed ?? '5' }}</div>
                  <div class="qs-label">Funds Active</div>
                </div>
              </div>

              <hr class="section-divider">

              <div class="fund-breakdown-header">
                <div class="fund-breakdown-label">Fund Breakdown</div>
                <button id="toggle-funds" class="btn-action">Toggle</button>
              </div>

              <div id="fund-breakdown">
                @foreach(['Fund 01 — Regular' => 65, 'Fund 03 — ARF' => 20, 'Fund 07 — Trust' => 10, 'Fund 02 (LP/GOP)' => 5] as $fund => $pct)
                  <div class="fund-item">
                    <div class="fund-item-row">
                      <span>{{ $fund }}</span>
                      <span>{{ $pct }}%</span>
                    </div>
                    <div class="fund-bar-track">
                      <div class="fund-bar-fill" style="width: {{ $pct }}%;"></div>
                    </div>
                  </div>
                @endforeach
              </div>

            </div>
          </div>

        </div><!-- /.dash-grid -->

      </div><!-- /.page-body -->
    </main>

  </div><!-- /.outer-wrapper -->

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const btn = document.getElementById('toggle-funds');
      const fb  = document.getElementById('fund-breakdown');
      if (btn && fb) {
        btn.addEventListener('click', () => {
          fb.style.display = fb.style.display === 'none' ? '' : 'none';
        });
      }
    });
  </script>

</body>
</html>