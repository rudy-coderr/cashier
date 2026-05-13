<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Users — DAR Cashier</title>
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
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); min-height: 100vh; color: var(--text-dark); }
    .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

    /* ── HEADER ── */
    .page-header { background: var(--green-deep); padding: 16px 32px; display: flex; align-items: center; gap: 14px; position: sticky; top: 0; z-index: 200; }
    .header-seal { width: 38px; height: 38px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }
    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }
    .btn-logout { display: flex; align-items: center; gap: 6px; padding: 8px 16px; background: linear-gradient(135deg, var(--gold), var(--gold-light)); border: 1px solid rgba(201,153,42,.35); border-radius: 8px; color: var(--green-deep); font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: .75rem; letter-spacing: .5px; cursor: pointer; transition: all .18s ease; box-shadow: 0 2px 6px rgba(0,0,0,.08); }
    .btn-logout:hover { background: linear-gradient(135deg, #d6a73b, #f0cf7b); transform: translateY(-1px); }

    /* ── LAYOUT ── */
    .outer-wrapper { display: flex; min-height: calc(100vh - 72px); }

    /* ── SIDEBAR ── */
    .sidebar { width: 260px; flex-shrink: 0; background: var(--green-deep); border-right: 1px solid rgba(255,255,255,.07); position: sticky; top: 72px; height: calc(100vh - 72px); display: flex; flex-direction: column; }
    .sidebar-inner { flex: 1; overflow-y: auto; padding: 24px 0 0; }
    .sidebar-inner::-webkit-scrollbar { width: 3px; }
    .sidebar-inner::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }
    .sidebar-profile { padding: 0 22px 20px; display: flex; align-items: center; gap: 11px; }
    .profile-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-light)); display: flex; align-items: center; justify-content: center; font-size: .85rem; font-weight: 700; color: var(--green-deep); flex-shrink: 0; }
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
    .page-body { max-width: 1100px; margin: 0 auto; padding: 36px 28px 60px; }
    .page-title-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }
    .btn-action { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 9px; border: none; font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 700; cursor: pointer; transition: background .15s, transform .12s; letter-spacing: .3px; }
    .btn-primary { background: var(--green-mid); color: #fff; }
    .btn-primary:hover { background: var(--green-accent); transform: translateY(-1px); }

    /* ── STAT CARDS ── */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
    .stat-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; transition: box-shadow .2s; }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .si-green { background: var(--green-light); color: var(--green-accent); }
    .si-gold  { background: #fdf3dc; color: var(--gold); }
    .si-amber { background: #fff7ed; color: #c2640a; }
    .si-red   { background: #fdf0ef; color: var(--red); }
    .stat-value { font-size: 1.35rem; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
    .stat-label { font-size: .7rem; color: var(--muted); font-weight: 400; margin-top: 2px; }

    /* ── TOOLBAR ── */
    .toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
    .search-wrap { position: relative; flex: 1; min-width: 200px; }
    .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .88rem; pointer-events: none; }
    .search-wrap input { width: 100%; padding: 9px 12px 9px 34px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .85rem; color: var(--text-dark); background: var(--surface); outline: none; transition: border-color .2s, box-shadow .2s; }
    .search-wrap input:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); }
    .filter-select { padding: 9px 32px 9px 12px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .82rem; color: var(--text-dark); background: var(--surface); outline: none; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238a9e90' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; cursor: pointer; transition: border-color .2s; }
    .filter-select:focus { border-color: var(--green-accent); }

    /* ── TABLE CARD ── */
    .table-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; }
    .table-card-header { padding: 14px 22px; background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .table-card-title { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 9px; }
    .table-record-count { font-size: .68rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; background: rgba(201,153,42,.2); color: var(--gold-light); border: 1px solid rgba(201,153,42,.25); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr { background: #faf8f4; border-bottom: 1.5px solid var(--border); }
    .data-table thead th { padding: 11px 16px; font-size: .68rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--text-mid); white-space: nowrap; }
    .data-table thead th:first-child { padding-left: 22px; }
    .data-table thead th:last-child  { padding-right: 22px; }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .13s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #f9f7f2; }
    .data-table tbody td { padding: 13px 16px; font-size: .85rem; color: var(--text-dark); vertical-align: middle; }
    .data-table tbody td:first-child { padding-left: 22px; }
    .data-table tbody td:last-child  { padding-right: 22px; }
    .row-id { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; background: var(--green-light); color: var(--green-accent); font-size: .72rem; font-weight: 700; }
    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--green-mid); color: #fff; font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .user-name  { font-weight: 600; font-size: .87rem; color: var(--text-dark); }
    .user-email { font-size: .72rem; color: var(--muted); margin-top: 1px; }
    .role-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: .68rem; font-weight: 700; white-space: nowrap; }
    .rb-admin      { background: #fdf3dc; color: var(--gold); }
    .rb-cashier    { background: var(--green-light); color: var(--green-accent); }
    .rb-reviewer   { background: #eef3fc; color: #2a5fa0; }
    .rb-accountant { background: #fdf0ef; color: var(--red); }
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; white-space: nowrap; }
    .sb-active   { background: var(--green-light); color: var(--green-accent); }
    .sb-inactive { background: #fdf0ef; color: var(--red); }
    .action-btn { width: 30px; height: 30px; border-radius: 7px; border: 1.5px solid var(--border); background: #faf8f4; color: var(--text-mid); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; cursor: pointer; transition: background .15s, border-color .15s, color .15s; text-decoration: none; }
    .action-btn:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }
    .action-btn.danger:hover { background: #fdf0ef; border-color: #f0a8a8; color: var(--red); }
    .date-main { font-size: .82rem; color: var(--text-dark); font-weight: 500; }
    .date-time  { font-size: .7rem; color: var(--muted); margin-top: 2px; }
    .empty-row td { padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 2.4rem; color: var(--border); margin-bottom: 12px; }
    .empty-text { font-size: .85rem; color: var(--muted); }
    .table-footer { padding: 12px 22px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .table-footer-info { font-size: .75rem; color: var(--muted); }
    .table-footer-info strong { color: var(--text-mid); }

    /* ── ALERT ── */
    .alert-bar { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: .84rem; font-weight: 500; }
    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }
    .alert-danger   { background: #fdf0ef; color: var(--red); border: 1px solid rgba(160,37,28,.2); }

    /* ── MODAL BASE ── */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1000; align-items: center; justify-content: center; padding: 20px; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: var(--surface); border-radius: 16px; width: 100%; overflow: hidden; animation: modalIn .22s cubic-bezier(.16,1,.3,1); }
    @keyframes modalIn { from { opacity: 0; transform: translateY(16px) scale(.97); } to { opacity: 1; transform: none; } }
    .modal-head { padding: 16px 22px; background: var(--green-deep); display: flex; align-items: center; justify-content: space-between; }
    .modal-head-title { font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; font-weight: 700; color: var(--gold-light); }
    .modal-close { width: 30px; height: 30px; border-radius: 7px; background: rgba(255,255,255,.08); border: none; color: rgba(245,240,232,.55); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s; }
    .modal-close:hover { background: rgba(255,255,255,.15); color: var(--cream); }
    .modal-body { padding: 22px; overflow-y: auto; max-height: calc(100vh - 180px); }
    .modal-foot { padding: 14px 22px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; flex-shrink: 0; }
    .btn-cancel { padding: 8px 16px; border: 1.5px solid var(--border); border-radius: 8px; background: #faf8f4; color: var(--text-mid); font-family: 'DM Sans', sans-serif; font-size: .82rem; font-weight: 600; cursor: pointer; }

    /* ── FORM SECTIONS (Add User) ── */
    .modal-box-wide { max-width: 560px; }
    .modal-box-narrow { max-width: 480px; }

    .section-block { margin-bottom: 20px; }
    .section-block:last-child { margin-bottom: 0; }
    .section-label {
      font-size: .62rem;
      font-weight: 700;
      letter-spacing: 1.8px;
      text-transform: uppercase;
      color: var(--muted);
      padding-bottom: 8px;
      border-bottom: 1px solid var(--border);
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .section-label i { font-size: .8rem; color: var(--green-accent); }

    .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .field-grid .col-full { grid-column: 1 / -1; }

    .form-field { display: flex; flex-direction: column; gap: 4px; }
    .form-field label { font-size: .78rem; font-weight: 600; color: var(--text-mid); }
    .form-field label .req { color: var(--red); margin-left: 2px; }
    .form-field .field-hint { font-size: .7rem; color: var(--muted); margin-top: 2px; }

    .form-field input,
    .form-field select,
    .form-field textarea {
      width: 100%;
      padding: 9px 13px;
      border: 1.5px solid var(--border);
      border-radius: 8px;
      font-family: 'DM Sans', sans-serif;
      font-size: .87rem;
      color: var(--text-dark);
      background: #faf8f4;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
      appearance: none;
    }
    .form-field input:focus,
    .form-field select:focus,
    .form-field textarea:focus {
      border-color: var(--green-accent);
      box-shadow: 0 0 0 3px rgba(45,122,79,.1);
      background: #fff;
    }
    .form-field textarea { resize: none; }

    .select-wrap { position: relative; }
    .select-wrap select { padding-right: 32px; cursor: pointer; }
    .select-wrap::after {
      content: '';
      pointer-events: none;
      position: absolute;
      right: 11px; top: 50%;
      transform: translateY(-50%);
      border: 4px solid transparent;
      border-top-color: var(--muted);
      margin-top: 2px;
    }

    .pw-wrap { position: relative; }
    .pw-wrap input { padding-right: 38px; }
    .pw-toggle {
      position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: var(--muted); font-size: .9rem; padding: 0;
      display: flex; align-items: center;
    }
    .pw-toggle:hover { color: var(--green-accent); }

    /* ── RESPONSIVE ── */
    @media (max-width: 1024px) { .stat-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }
      .sidebar { width: 100%; height: auto; position: static; }
      .sidebar-profile, .sidebar-divider, .nav-section-label, .sidebar-footer { display: none; }
      .sidebar-inner { display: flex; overflow-x: auto; padding: 8px 0; }
      .nav-item { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
      .nav-item.active { border-bottom-color: var(--gold); }
      .page-body { padding: 20px 16px 48px; }
      .field-grid { grid-template-columns: 1fr; }
      .field-grid .col-full { grid-column: 1; }
    }
    @media (max-width: 560px) { .stat-row { grid-template-columns: 1fr 1fr; } }
  </style>
</head>
<body>

<div class="top-stripe"></div>

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
      <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </form>
  </div>
</header>

<div class="outer-wrapper">

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
      <a class="nav-item active" href="{{ route('admin.users') }}">
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

    {{-- Session messages are shown via SweetAlert2 toasts/modal. --}}

    <div class="page-title-row">
      <div>
        <div class="page-title">Users</div>
        <div class="page-sub">Manage system accounts and role assignments</div>
      </div>
      <button class="btn-action btn-primary" onclick="openAddUserModal()">
        <i class="bi bi-person-plus-fill"></i> Add User
      </button>
    </div>

    <div class="stat-row">
      <div class="stat-card">
        <div class="stat-icon si-green"><i class="bi bi-people-fill"></i></div>
        <div><div class="stat-value">{{ $totalUsers ?? '—' }}</div><div class="stat-label">Total Users</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-gold"><i class="bi bi-person-badge-fill"></i></div>
        <div><div class="stat-value">{{ $makerCount ?? '—' }}</div><div class="stat-label">Makers</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-amber"><i class="bi bi-person-check-fill"></i></div>
        <div><div class="stat-value">{{ $reviewerCount ?? '—' }}</div><div class="stat-label">Reviewers</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-red"><i class="bi bi-person-gear"></i></div>
        <div><div class="stat-value">{{ $accountantCount ?? '—' }}</div><div class="stat-label">Accountants</div></div>
      </div>
    </div>

    <div class="toolbar">
      <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="user-search" placeholder="Search by name or email…" oninput="filterUsers()" />
      </div>
      <select class="filter-select" id="filter-role" onchange="filterUsers()">
        <option value="">All Roles</option>
        <option value="admin">Admin</option>
        <option value="maker">Maker</option>
        <option value="reviewer">Reviewer</option>
        <option value="accountant">Accountant</option>
      </select>
      <select class="filter-select" id="filter-user-status" onchange="filterUsers()">
        <option value="">All Statuses</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    </div>

    <div class="table-card">
      <div class="table-card-header">
        <div class="table-card-title"><i class="bi bi-people-fill"></i> System Users</div>
        <span class="table-record-count" id="users-count">{{ count($users ?? []) }} record{{ count($users ?? []) !== 1 ? 's' : '' }}</span>
      </div>
      <table class="data-table">
        <thead>
          <tr>
            <th>Profile</th><th>Name</th><th>Role</th><th>Status</th><th>Created</th><th>Actions</th>
          </tr>
        </thead>
        <tbody id="users-tbody">
          @forelse(collect($users ?? [])->take(5) as $u)
            @php
              $initials = strtoupper(substr($u->name,0,1)) . (str_contains($u->name,' ') ? strtoupper(substr(strrchr($u->name,' '),1,1)) : '');
              $roleCls  = match($u->role ?? '') { 'admin'=>'rb-admin','maker'=>'rb-cashier','reviewer'=>'rb-reviewer','accountant'=>'rb-accountant', default=>'rb-cashier' };
              $uStatus  = ($u->is_active ?? true) ? 'active' : 'inactive';
            @endphp
            <tr data-id="{{ $u->id }}" data-search="{{ strtolower($u->name.' '.$u->email) }}" data-email="{{ $u->email ?? '' }}" data-role="{{ strtolower($u->role ?? '') }}" data-status="{{ $uStatus }}" data-first="{{ $u->first_name ?? '' }}" data-middle="{{ $u->middle_name ?? '' }}" data-last="{{ $u->last_name ?? '' }}" data-username="{{ $u->username ?? '' }}" data-phone_number="{{ $u->phone_number ?? '' }}" data-address="{{ $u->address ?? '' }}" data-position="{{ $u->position ?? '' }}" data-created="{{ $u->created_at }}">
              <td style="width:56px;text-align:center;">
                <div class="user-avatar">{{ $initials }}</div>
              </td>
              <td>
                <div>
                  <div class="user-name">{{ $u->name }}</div>
                  <div class="user-email">{{ $u->email }}</div>
                </div>
              </td>
              <td><span class="role-badge {{ $roleCls }}">{{ ucfirst($u->role ?? '—') }}</span></td>
              <td>
                <span class="status-badge {{ $uStatus === 'active' ? 'sb-active' : 'sb-inactive' }}">
                  <i class="bi {{ $uStatus === 'active' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                  {{ ucfirst($uStatus) }}
                </span>
              </td>
              <td><div class="date-main">{{ $u->created_at->format('M d, Y') }}</div></td>
              <td>
                <div style="display:flex;gap:6px;">
                  <a href="#" class="action-btn" title="Edit" onclick="openEditUserModal({{ $u->id }}); return false;"><i class="bi bi-pencil"></i></a>
                  <a href="#" class="action-btn" title="View" onclick="openViewUserModal({{ $u->id }}); return false;"><i class="bi bi-eye"></i></a>
                  <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" style="display:inline;" class="confirm-delete" data-name="{{ addslashes($u->name) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-btn danger" title="Delete"><i class="bi bi-trash3"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr class="empty-row">
              <td colspan="6">
                <div class="empty-icon"><i class="bi bi-people"></i></div>
                <div class="empty-text">No users found.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="table-footer">
        <span class="table-footer-info" id="users-footer">Showing <strong>{{ min(count($users ?? []), 5) }}</strong> of <strong>{{ count($users ?? []) }}</strong> records</span>
        @if(method_exists($users ?? collect(), 'links'))
          <div>{{ $users->links() }}</div>
        @endif
      </div>
    </div>

  </div>
  </main>
</div>

  {{-- ══════════════════════════════
       VIEW USER MODAL
       ══════════════════════════════ --}}
  <div class="modal-overlay" id="view-user-modal" onclick="closeModalOutside(event,'view-user-modal')">
    <div class="modal-box modal-box-wide">
      <div class="modal-head">
        <div class="modal-head-title"><i class="bi bi-person-circle" style="margin-right:7px;font-size:.9rem;"></i>User Profile</div>
        <button class="modal-close" onclick="closeModal('view-user-modal')"><i class="bi bi-x-lg"></i></button>
      </div>
      <div class="modal-body">
        <div class="section-block">
          <div class="section-label"><i class="bi bi-person-fill"></i> Profile</div>
          <div style="display:flex;gap:12px;align-items:center;">
            <div style="width:64px;height:64px;border-radius:8px;background:var(--green-mid);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;" id="view-avatar">JD</div>
            <div>
              <div style="font-weight:700;font-size:1.05rem;" id="view-fullname">Juan Dela Cruz</div>
              <div style="color:var(--muted);" id="view-email">user@dar.gov.ph</div>
            </div>
          </div>
        </div>

        <div class="section-block">
          <div class="section-label"><i class="bi bi-gear-fill"></i> Account</div>
          <div class="field-grid">
            <div class="form-field">
              <label>Username</label>
              <div id="view-username" class="field-hint"></div>
            </div>
            <div class="form-field">
              <label>Role</label>
              <div id="view-position" class="field-hint"></div>
            </div>
            <div class="form-field">
              <label>Status</label>
              <div id="view-status" class="field-hint"></div>
            </div>
            <div class="form-field">
              <label>Created</label>
              <div id="view-created" class="field-hint"></div>
            </div>
          </div>
        </div>

        <div class="section-block">
          <div class="section-label"><i class="bi bi-telephone-fill"></i> Contact</div>
          <div class="field-grid">
            <div class="form-field">
              <label>Phone</label>
              <div id="view-phone_number" class="field-hint"></div>
            </div>
            <div class="form-field col-full">
              <label>Address</label>
              <div id="view-address" class="field-hint"></div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-foot">
        <button type="button" class="btn-cancel" onclick="closeModal('view-user-modal')">Close</button>
        <button type="button" class="btn-action btn-primary" onclick="openEditUserModal(currentViewUserId)">Edit</button>
      </div>
    </div>
  </div>

{{-- ══════════════════════════════════════════
     ADD USER MODAL — Organized with sections
     ══════════════════════════════════════════ --}}
<div class="modal-overlay" id="add-user-modal" onclick="closeModalOutside(event,'add-user-modal')">
  <div class="modal-box modal-box-wide">
    <div class="modal-head">
      <div class="modal-head-title"><i class="bi bi-person-plus-fill" style="margin-right:7px;font-size:.9rem;"></i>Add New User</div>
      <button class="modal-close" onclick="closeModal('add-user-modal')"><i class="bi bi-x-lg"></i></button>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf
      <div class="modal-body">

        {{-- SECTION 1: Personal Information --}}
        <div class="section-block">
          <div class="section-label"><i class="bi bi-person-fill"></i> Personal Information</div>
          <div class="field-grid">
            <div class="form-field">
              <label>First Name <span class="req">*</span></label>
              <input type="text" name="first_name" placeholder="e.g. Juan" required />
            </div>
            <div class="form-field">
              <label>Last Name <span class="req">*</span></label>
              <input type="text" name="last_name" placeholder="e.g. Dela Cruz" required />
            </div>
            <div class="form-field">
              <label>Middle Name</label>
              <input type="text" name="middle_name" placeholder="Optional" />
            </div>
            <div class="form-field">
              <label>Phone Number</label>
              <input type="text" name="phone_number" placeholder="09xx-xxx-xxxx" />
            </div>
            <div class="form-field col-full">
              <label>Address</label>
              <textarea name="address" rows="2" placeholder="Optional address"></textarea>
            </div>
          </div>
        </div>

        {{-- SECTION 2: Account Details --}}
        <div class="section-block">
          <div class="section-label"><i class="bi bi-envelope-fill"></i> Account Details</div>
          <div class="field-grid">
            <div class="form-field col-full">
              <label>Email Address <span class="req">*</span></label>
              <input type="email" name="email" placeholder="user@dar.gov.ph" required />
            </div>
            <div class="form-field">
              <label>Username</label>
              <input type="text" name="username" placeholder="Optional" />
            </div>
            <div class="form-field">
              <label>Role / Position <span class="req">*</span></label>
              <div class="select-wrap">
                <select name="position" required>
                  <option value="" disabled selected>Select role…</option>
                  <option value="maker">Maker</option>
                  <option value="reviewer">Reviewer</option>
                  <option value="accountant">Accountant</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>
            <div class="form-field">
              <label>Status</label>
              <div class="select-wrap">
                <select name="status">
                  <option value="active" selected>Active</option>
                  <option value="inactive">Inactive</option>
                  <option value="banned">Banned</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        {{-- SECTION 3: Security --}}
        <div class="section-block">
          <div class="section-label"><i class="bi bi-shield-lock-fill"></i> Security</div>
          <div style="padding:10px 4px;">
            <p style="font-size:.9rem;color:var(--muted);margin:0;">
              <i class="bi bi-info-circle" style="margin-right:6px;"></i>
              A secure password will be auto-generated and emailed to the user. They can change it after first login.
            </p>
          </div>
        </div>

      </div>{{-- /modal-body --}}

      <div class="modal-foot">
        <button type="button" class="btn-cancel" onclick="closeModal('add-user-modal')">Cancel</button>
        <button type="submit" class="btn-action btn-primary"><i class="bi bi-person-check-fill"></i> Create User</button>
      </div>
    </form>
  </div>
</div>

{{-- ══════════════════════════════
     EDIT USER MODAL
     ══════════════════════════════ --}}
<div class="modal-overlay" id="edit-user-modal" onclick="closeModalOutside(event,'edit-user-modal')">
  <div class="modal-box modal-box-wide">
    <div class="modal-head">
      <div class="modal-head-title"><i class="bi bi-pencil-fill" style="margin-right:7px;font-size:.9rem;"></i>Edit User</div>
      <button class="modal-close" onclick="closeModal('edit-user-modal')"><i class="bi bi-x-lg"></i></button>
    </div>
    <form method="POST" id="edit-user-form" action="">
      @csrf @method('PATCH')
      <div class="modal-body">

        {{-- Personal Information --}}
        <div class="section-block">
          <div class="section-label"><i class="bi bi-person-fill"></i> Personal Information</div>
          <div class="field-grid">
            <div class="form-field">
              <label>First Name <span class="req">*</span></label>
              <input type="text" name="first_name" id="edit-first_name" placeholder="First name" required />
            </div>
            <div class="form-field">
              <label>Last Name <span class="req">*</span></label>
              <input type="text" name="last_name" id="edit-last_name" placeholder="Last name" required />
            </div>
            <div class="form-field">
              <label>Middle Name</label>
              <input type="text" name="middle_name" id="edit-middle_name" placeholder="Optional" />
            </div>
            <div class="form-field">
              <label>Phone Number</label>
              <input type="text" name="phone_number" id="edit-phone_number" placeholder="09xx-xxx-xxxx" />
            </div>
            <div class="form-field col-full">
              <label>Address</label>
              <textarea name="address" id="edit-address" rows="2" placeholder="Optional address"></textarea>
            </div>
          </div>
        </div>

        {{-- Account Details --}}
        <div class="section-block">
          <div class="section-label"><i class="bi bi-envelope-fill"></i> Account Details</div>
          <div class="field-grid">
            <div class="form-field col-full">
              <label>Email Address <span class="req">*</span></label>
              <input type="email" name="email" id="edit-email" placeholder="user@dar.gov.ph" required />
            </div>
            <div class="form-field">
              <label>Username</label>
              <input type="text" name="username" id="edit-username" placeholder="Optional" />
            </div>
            <div class="form-field">
              <label>Role / Position <span class="req">*</span></label>
              <div class="select-wrap">
                <select name="position" id="edit-position" required>
                  <option value="" disabled>Select role…</option>
                  <option value="maker">Maker</option>
                  <option value="reviewer">Reviewer</option>
                  <option value="accountant">Accountant</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>
            <div class="form-field">
              <label>Status</label>
              <div class="select-wrap">
                <select name="status" id="edit-status">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                  <option value="banned">Banned</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        {{-- Security --}}
        <div class="section-block">
          <div class="section-label"><i class="bi bi-shield-lock-fill"></i> Security</div>
          <div class="field-grid">
            <div class="form-field">
              <label>New Password <span style="font-size:.7rem;color:var(--muted);font-weight:400;">(leave blank to keep current)</span></label>
              <div class="pw-wrap">
                <input type="password" name="password" id="edit-pw" placeholder="Leave blank to keep current" />
                <button type="button" class="pw-toggle" onclick="togglePw('edit-pw', this)" tabindex="-1">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div class="form-field">
              <label>Confirm Password</label>
              <div class="pw-wrap">
                <input type="password" name="password_confirmation" id="edit-pw-confirm" placeholder="Re-enter password" />
                <button type="button" class="pw-toggle" onclick="togglePw('edit-pw-confirm', this)" tabindex="-1">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
          </div>
          <p style="font-size:.72rem;color:var(--muted);margin-top:8px;"><i class="bi bi-info-circle" style="margin-right:4px;"></i>Password must be at least 8 characters long.</p>
        </div>

      </div>
      <div class="modal-foot">
        <button type="button" class="btn-cancel" onclick="closeModal('edit-user-modal')">Cancel</button>
        <button type="submit" class="btn-action btn-primary"><i class="bi bi-check-lg"></i> Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
  /* ── Filter ── */
  function filterUsers() {
    const q  = document.getElementById('user-search').value.toLowerCase();
    const r  = document.getElementById('filter-role').value.toLowerCase();
    const s  = document.getElementById('filter-user-status').value.toLowerCase();
    const rows = document.querySelectorAll('#users-tbody tr[data-search]');
    let v = 0;
    rows.forEach(row => {
      const show = (!q || row.dataset.search.includes(q))
                && (!r || row.dataset.role === r)
                && (!s || row.dataset.status === s);
      row.style.display = show ? '' : 'none';
      if (show) v++;
    });
    document.getElementById('users-count').textContent = v + (v === 1 ? ' record' : ' records');
    document.getElementById('users-footer').innerHTML = 'Showing <strong>' + v + '</strong> of <strong>' + rows.length + '</strong> records';
  }

  /* ── Modals ── */
  function openAddUserModal() {
    document.getElementById('add-user-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function openEditUserModal(id) {
    const row = document.querySelector(`#users-tbody tr[data-id="${id}"]`);
    if (!row) return;
    const ds = row.dataset;
    document.getElementById('edit-user-form').action = '/admin/users/' + id;
    document.getElementById('edit-first_name').value = ds.first || '';
    document.getElementById('edit-middle_name').value = ds.middle || '';
    document.getElementById('edit-last_name').value = ds.last || '';
    document.getElementById('edit-username').value = ds.username || '';
    document.getElementById('edit-email').value = ds.email || '';
    // prefer explicit position dataset if present
    if (document.getElementById('edit-position')) document.getElementById('edit-position').value = ds.position || ds.role || '';
    if (document.getElementById('edit-status')) document.getElementById('edit-status').value = ds.status || '';
    if (document.getElementById('edit-phone_number')) document.getElementById('edit-phone_number').value = ds.phone_number || '';
    if (document.getElementById('edit-address')) document.getElementById('edit-address').value = ds.address || '';
    document.getElementById('edit-pw').value = '';
    document.getElementById('edit-pw-confirm').value = '';
    document.getElementById('edit-user-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  let currentViewUserId = null;
  function openViewUserModal(id) {
    const row = document.querySelector(`#users-tbody tr[data-id="${id}"]`);
    if (!row) return;
    currentViewUserId = id;
    const ds = row.dataset;
    const avatarEl = document.getElementById('view-avatar');
    const first = ds.first || '';
    const last = ds.last || '';
    const initials = (first.charAt(0) || '') + (last.charAt(0) || '');
    if (avatarEl) avatarEl.textContent = initials.toUpperCase();
    document.getElementById('view-fullname').textContent = [ds.first, ds.middle, ds.last].filter(Boolean).join(' ');
    document.getElementById('view-email').textContent = ds.email || '';
    document.getElementById('view-username').textContent = ds.username || '';
    document.getElementById('view-position').textContent = ds.position || ds.role || '';
    document.getElementById('view-status').textContent = ds.status || '';
    document.getElementById('view-phone_number').textContent = ds.phone_number || '';
    document.getElementById('view-address').textContent = ds.address || '';
    document.getElementById('view-created').textContent = ds.created || '';
    document.getElementById('view-user-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
  }

  function closeModalOutside(e, id) {
    if (e.target === document.getElementById(id)) closeModal(id);
  }

  /* ── Password toggle ── */
  function togglePw(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.className = 'bi bi-eye-slash';
    } else {
      input.type = 'password';
      icon.className = 'bi bi-eye';
    }
  }

  /* ── Escape key ── */
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal-overlay.open').forEach(m => {
        m.classList.remove('open');
        document.body.style.overflow = '';
      });
    }
  });
</script>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Show SweetAlert for session messages
  @if(session('success'))
    Swal.fire({icon: 'success', title: 'Success', text: {!! json_encode(session('success')) !!}, timer: 2500, showConfirmButton: false});
  @endif
  @if(session('error'))
    Swal.fire({icon: 'error', title: 'Error', text: {!! json_encode(session('error')) !!}});
  @endif

  // Confirm delete
  document.querySelectorAll('.confirm-delete').forEach(form => {
    form.addEventListener('submit', function(e){
      e.preventDefault();
      const name = this.dataset.name || 'this user';
      Swal.fire({
        title: 'Delete user?',
        text: `Delete ${name}? This cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Delete',
      }).then(result => {
        if (result.isConfirmed) this.submit();
      });
    });
  });

  // Confirm toggle
  document.querySelectorAll('.confirm-toggle').forEach(form => {
    form.addEventListener('submit', function(e){
      e.preventDefault();
      const name = this.dataset.name || 'this user';
      Swal.fire({
        title: 'Change status?',
        text: `Toggle status for ${name}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, toggle',
      }).then(result => {
        if (result.isConfirmed) this.submit();
      });
    });
  });
});
</script>