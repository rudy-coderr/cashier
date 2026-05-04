<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payments — DAR Cashier</title>
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

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      color: var(--text-dark);
    }

    .top-stripe {
      height: 4px;
      background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red));
    }

    /* ── HEADER ── */
    .page-header {
      background: var(--green-deep);
      padding: 16px 32px;
      display: flex;
      align-items: center;
      gap: 14px;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .header-seal {
      width: 38px; height: 38px;
      border-radius: 50%;
      background: var(--gold);
      display: flex; align-items: center; justify-content: center;
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
      width: 1px; height: 30px;
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

    .btn-new-payment {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      background: var(--gold);
      border: none;
      border-radius: 8px;
      color: var(--green-deep);
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: .75rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      text-decoration: none;
      transition: background .15s, transform .12s;
      cursor: pointer;
    }

    .btn-new-payment:hover {
      background: var(--gold-light);
      color: var(--green-deep);
      transform: translateY(-1px);
    }

    /* ── PAGE BODY ── */
    .page-body {
      max-width: 1200px;
      margin: 0 auto;
      padding: 36px 24px 60px;
    }

    /* ── PAGE TITLE ROW ── */
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

    /* ── STAT CARDS ── */
    .stat-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 24px;
    }

    .stat-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 12px;
      padding: 16px 18px;
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .stat-icon {
      width: 40px; height: 40px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0;
    }

    .si-green { background: var(--green-light); color: var(--green-accent); }
    .si-gold  { background: #fdf3dc; color: var(--gold); }
    .si-amber { background: #fff7ed; color: #c2640a; }
    .si-red   { background: #fdf0ef; color: var(--red); }

    .stat-info {}
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
      letter-spacing: .3px;
    }

    /* ── TOOLBAR ── */
    .toolbar {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
      flex-wrap: wrap;
    }

    .search-wrap {
      position: relative;
      flex: 1;
      min-width: 200px;
    }

    .search-wrap i {
      position: absolute;
      left: 11px; top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: .88rem;
      pointer-events: none;
    }

    .search-wrap input {
      width: 100%;
      padding: 9px 12px 9px 34px;
      border: 1.5px solid var(--border);
      border-radius: 9px;
      font-family: 'DM Sans', sans-serif;
      font-size: .85rem;
      color: var(--text-dark);
      background: var(--surface);
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    .search-wrap input:focus {
      border-color: var(--green-accent);
      box-shadow: 0 0 0 3px rgba(45,122,79,.1);
    }

    .filter-select {
      padding: 9px 32px 9px 12px;
      border: 1.5px solid var(--border);
      border-radius: 9px;
      font-family: 'DM Sans', sans-serif;
      font-size: .82rem;
      color: var(--text-dark);
      background: var(--surface);
      outline: none;
      appearance: none;
      -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238a9e90' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      cursor: pointer;
      transition: border-color .2s;
    }

    .filter-select:focus { border-color: var(--green-accent); }

    /* ── TABLE CARD ── */
    .table-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
    }

    .table-card-header {
      padding: 14px 22px;
      background: linear-gradient(90deg, var(--green-mid), var(--green-deep));
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    .table-card-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1rem;
      font-weight: 700;
      color: var(--gold-light);
      display: flex;
      align-items: center;
      gap: 9px;
    }

    .table-card-title i { font-size: .95rem; }

    .table-record-count {
      font-size: .68rem;
      font-weight: 600;
      padding: 3px 10px;
      border-radius: 20px;
      background: rgba(201,153,42,.2);
      color: var(--gold-light);
      border: 1px solid rgba(201,153,42,.25);
    }

    /* Table */
    .payments-table {
      width: 100%;
      border-collapse: collapse;
    }

    .payments-table thead tr {
      background: #faf8f4;
      border-bottom: 1.5px solid var(--border);
    }

    .payments-table thead th {
      padding: 11px 16px;
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: var(--text-mid);
      white-space: nowrap;
    }

    .payments-table thead th:first-child { padding-left: 22px; }
    .payments-table thead th:last-child  { padding-right: 22px; }

    .payments-table tbody tr {
      border-bottom: 1px solid var(--border);
      transition: background .13s;
      cursor: pointer;
    }

    .payments-table tbody tr:last-child { border-bottom: none; }
    .payments-table tbody tr:hover { background: #f9f7f2; }

    .payments-table tbody td {
      padding: 13px 16px;
      font-size: .85rem;
      color: var(--text-dark);
      vertical-align: middle;
    }

    .payments-table tbody td:first-child { padding-left: 22px; }
    .payments-table tbody td:last-child  { padding-right: 22px; }

    /* Row ID badge */
    .row-id {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px; height: 28px;
      border-radius: 7px;
      background: var(--green-light);
      color: var(--green-accent);
      font-size: .72rem;
      font-weight: 700;
    }

    /* Payor cell */
    .payor-cell { display: flex; align-items: center; gap: 10px; }
    .payor-avatar {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: var(--green-mid);
      color: #fff;
      font-size: .75rem;
      font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .payor-name { font-weight: 600; font-size: .87rem; color: var(--text-dark); }
    .payor-contact { font-size: .72rem; color: var(--muted); margin-top: 1px; }

    /* Amount */
    .amount-cell {
      font-weight: 700;
      font-size: .92rem;
      color: var(--green-mid);
    }

    /* Transaction type badge */
    .txn-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 20px;
      background: #f0f4f2;
      color: var(--text-mid);
      font-size: .72rem;
      font-weight: 600;
      white-space: nowrap;
      max-width: 200px;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* Fund badge */
    .fund-badge {
      display: inline-block;
      padding: 3px 9px;
      border-radius: 20px;
      background: #fdf3dc;
      color: var(--gold);
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: .3px;
      white-space: nowrap;
    }

    /* OP Number */
    .op-number {
      font-size: .78rem;
      font-family: 'DM Sans', sans-serif;
      color: var(--text-mid);
      font-weight: 500;
    }

    /* Date */
    .date-cell .date-main { font-size: .82rem; color: var(--text-dark); font-weight: 500; }
    .date-cell .date-time { font-size: .7rem; color: var(--muted); margin-top: 2px; }

    /* Status badge */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: .4px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .sb-approved { background: var(--green-light); color: var(--green-accent); }
    .sb-waiting  { background: #fdf3dc; color: #a0700a; }
    .sb-rejected { background: #fdf0ef; color: var(--red); }
    .sb-default  { background: #f0f4f2; color: var(--muted); }

    /* Action buttons */
    .action-btn {
      width: 30px; height: 30px;
      border-radius: 7px;
      border: 1.5px solid var(--border);
      background: #faf8f4;
      color: var(--text-mid);
      display: inline-flex; align-items: center; justify-content: center;
      font-size: .85rem;
      cursor: pointer;
      transition: background .15s, border-color .15s, color .15s;
      text-decoration: none;
    }

    .action-btn:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }

    /* Empty row */
    .empty-row td {
      padding: 60px 20px;
      text-align: center;
    }

    .empty-icon { font-size: 2.4rem; color: var(--border); margin-bottom: 12px; }
    .empty-text { font-size: .85rem; color: var(--muted); }

    /* Table footer */
    .table-footer {
      padding: 12px 22px;
      background: #faf8f4;
      border-top: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      flex-wrap: wrap;
    }

    .table-footer-info { font-size: .75rem; color: var(--muted); }
    .table-footer-info strong { color: var(--text-mid); }

    /* Pagination */
    .pagination-wrap { display: flex; align-items: center; gap: 4px; }

    .page-btn {
      width: 30px; height: 30px;
      border-radius: 7px;
      border: 1.5px solid var(--border);
      background: var(--surface);
      color: var(--text-mid);
      font-size: .78rem;
      font-weight: 600;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      transition: background .15s, border-color .15s, color .15s;
      font-family: 'DM Sans', sans-serif;
    }

    .page-btn:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }
    .page-btn.active { background: var(--green-mid); border-color: var(--green-mid); color: #fff; }
    .page-btn:disabled { opacity: .4; cursor: not-allowed; }

    /* Detail drawer overlay */
    .drawer-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.45);
      z-index: 500;
    }

    .drawer-overlay.open { display: block; }

    .detail-drawer {
      position: fixed;
      top: 0; right: 0;
      width: 420px;
      max-width: 100vw;
      height: 100vh;
      background: var(--surface);
      box-shadow: -8px 0 40px rgba(0,0,0,.18);
      display: flex;
      flex-direction: column;
      transform: translateX(100%);
      transition: transform .28s cubic-bezier(.16,1,.3,1);
      z-index: 501;
    }

    .detail-drawer.open { transform: translateX(0); }

    .drawer-head {
      padding: 18px 22px;
      background: var(--green-deep);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-shrink: 0;
    }

    .drawer-head-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--gold-light);
    }

    .drawer-head-sub {
      font-size: .6rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: rgba(245,240,232,.35);
      margin-top: 2px;
    }

    .drawer-close {
      width: 32px; height: 32px;
      border-radius: 8px;
      background: rgba(255,255,255,.08);
      border: none;
      color: rgba(245,240,232,.55);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      font-size: 1rem;
      transition: background .15s, color .15s;
    }

    .drawer-close:hover { background: rgba(255,255,255,.15); color: var(--cream); }

    .drawer-body {
      flex: 1;
      overflow-y: auto;
      padding: 22px;
    }

    .drawer-body::-webkit-scrollbar { width: 4px; }
    .drawer-body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .drawer-section-title {
      font-size: .65rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 7px;
    }

    .drawer-section-title i { color: var(--green-accent); }

    .drawer-field { margin-bottom: 14px; }

    .drawer-field-label {
      font-size: .7rem;
      font-weight: 600;
      color: var(--muted);
      letter-spacing: .4px;
      text-transform: uppercase;
      margin-bottom: 3px;
    }

    .drawer-field-value {
      font-size: .88rem;
      color: var(--text-dark);
      font-weight: 500;
      line-height: 1.45;
      word-break: break-word;
    }

    .drawer-divider { border: none; border-top: 1px dashed var(--border); margin: 18px 0; }

    /* Alert */
    .alert-bar {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 18px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: .84rem;
      font-weight: 500;
    }

    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }

    @media (max-width: 900px) {
      .stat-row { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
      .page-body { padding: 20px 14px 48px; }
      .page-header { padding: 14px 18px; }
      .stat-row { grid-template-columns: 1fr 1fr; }
      .payments-table thead { display: none; }
      .payments-table tbody td { display: block; padding: 6px 16px; }
      .payments-table tbody td:first-child { padding-top: 14px; }
      .payments-table tbody td:last-child { padding-bottom: 14px; }
      .detail-drawer { width: 100vw; }
    }
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
    <div class="header-page">Payments</div>
    <div class="header-actions">
      <a class="btn-new-payment" href="{{ route('dashboard') }}">
        <i class="bi bi-plus-lg"></i> New Payment
      </a>
    </div>
  </header>

  <div class="page-body">

    @if(session('success'))
      <div class="alert-bar alert-success">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
      </div>
    @endif

    <!-- ── PAGE TITLE ── -->
    <div class="page-title-row">
      <div>
        <div class="page-title">Payment Records</div>
        <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
      </div>
    </div>

    <!-- ── STAT CARDS ── -->
    <div class="stat-row">
      <div class="stat-card">
        <div class="stat-icon si-green"><i class="bi bi-receipt"></i></div>
        <div class="stat-info">
          <div class="stat-value">{{ $payments->total() ?? count($payments) }}</div>
          <div class="stat-label">Total Transactions</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-gold"><i class="bi bi-cash-coin"></i></div>
        <div class="stat-info">
          <div class="stat-value">₱{{ number_format($payments->sum('amount'), 2) }}</div>
          <div class="stat-label">Total Amount Collected</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-amber"><i class="bi bi-hourglass-split"></i></div>
        <div class="stat-info">
          <div class="stat-value">{{ $payments->where('status', 'waiting')->count() }}</div>
          <div class="stat-label">Awaiting Approval</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-green"><i class="bi bi-check-circle"></i></div>
        <div class="stat-info">
          <div class="stat-value">{{ $payments->where('status', 'approved')->count() }}</div>
          <div class="stat-label">Approved</div>
        </div>
      </div>
    </div>

    <!-- ── TOOLBAR ── -->
    <div class="toolbar">
      <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="tbl-search" placeholder="Search by name, O.P. number, or transaction type…" oninput="filterTable()" />
      </div>
      <select class="filter-select" id="filter-status" onchange="filterTable()">
        <option value="">All Statuses</option>
        <option value="approved">Approved</option>
        <option value="waiting">Waiting</option>
        <option value="rejected">Rejected</option>
      </select>
      <select class="filter-select" id="filter-fund" onchange="filterTable()">
        <option value="">All Funds</option>
        <option value="F01">Fund 01 — Regular</option>
        <option value="F03">Fund 03 — ARF</option>
        <option value="F07">Fund 07 — Trust</option>
        <option value="F02-LP">LP Split — Fund 02</option>
        <option value="F02-GOP">GOP Split — Fund 02</option>
      </select>
    </div>

    <!-- ── TABLE CARD ── -->
    <div class="table-card">

      <div class="table-card-header">
        <div class="table-card-title">
          <i class="bi bi-table"></i> Transactions Log
        </div>
        <span class="table-record-count" id="record-count">
          {{ count($payments) }} record{{ count($payments) !== 1 ? 's' : '' }}
        </span>
      </div>

      <table class="payments-table" id="payments-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Payor</th>
            <th>Amount</th>
            <th>Transaction Type</th>
            <th>Fund</th>
            <th>O.P. Number</th>
            <th>Date</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="table-body">
          @forelse($payments as $p)
            @php
              $status    = $p->status ?? 'waiting';
              $statusMap = ['approved' => 'sb-approved', 'waiting' => 'sb-waiting', 'rejected' => 'sb-rejected'];
              $statusCls = $statusMap[$status] ?? 'sb-default';
              $statusIcon = match($status) {
                'approved' => 'bi-check-circle-fill',
                'waiting'  => 'bi-hourglass-split',
                'rejected' => 'bi-x-circle-fill',
                default    => 'bi-circle'
              };
              $initials  = strtoupper(substr($p->name, 0, 1)) . (str_contains($p->name, ' ') ? strtoupper(substr(strrchr($p->name, ' '), 1, 1)) : '');
              $txnLabel  = ucwords(str_replace('_', ' ', $p->transaction_type ?? ''));
              $fundLabel = $p->fund_type ?? '—';

              $meta = $p->meta ?? [];
              $details = [];
              if (!empty($p->contact))      $details['Contact']      = $p->contact;
              if (!empty($p->address))      $details['Address']      = $p->address;
              if (!empty($p->email))        $details['Email']        = $p->email;
              if (!empty($p->payment_mode)) $details['Payment Mode'] = ucfirst(str_replace('_', ' ', $p->payment_mode));
              if (is_array($meta)) {
                foreach ($meta as $k => $v) {
                  if ($v === null || $v === '') continue;
                  $details[$k] = is_array($v) ? implode(', ', $v) : $v;
                }
              }
            @endphp
            <tr
              data-search="{{ strtolower($p->name . ' ' . ($p->op_number ?? '') . ' ' . ($p->transaction_type ?? '')) }}"
              data-status="{{ $status }}"
              data-fund="{{ $p->fund_type ?? '' }}"
              onclick="openDrawer({{ $p->id }})"
            >
              <td><span class="row-id">{{ $p->id }}</span></td>
              <td>
                <div class="payor-cell">
                  <div class="payor-avatar">{{ $initials }}</div>
                  <div>
                    <div class="payor-name">{{ $p->name }}</div>
                    <div class="payor-contact">{{ $p->email ?? ($p->contact ?? '—') }}</div>
                  </div>
                </div>
              </td>
              <td><span class="amount-cell">₱{{ number_format($p->amount, 2) }}</span></td>
              <td><span class="txn-badge"><i class="bi bi-tag"></i> {{ $txnLabel ?: '—' }}</span></td>
              <td><span class="fund-badge">{{ $fundLabel }}</span></td>
              <td><span class="op-number">{{ $p->op_number ?? '—' }}</span></td>
              <td>
                <div class="date-cell">
                  <div class="date-main">{{ $p->created_at->format('M d, Y') }}</div>
                  <div class="date-time">{{ $p->created_at->format('h:i A') }}</div>
                </div>
              </td>
              <td>
                <span class="status-badge {{ $statusCls }}">
                  <i class="bi {{ $statusIcon }}"></i>
                  {{ ucfirst($status) }}
                </span>
              </td>
              <td onclick="event.stopPropagation()">
                <a href="#" class="action-btn" title="View Details" onclick="openDrawer({{ $p->id }}); return false;">
                  <i class="bi bi-eye"></i>
                </a>
              </td>
            </tr>

            <!-- Drawer data (hidden) -->
            <script>
              window.__drawers = window.__drawers || {};
              window.__drawers[{{ $p->id }}] = {
                id:      {{ $p->id }},
                name:    @json($p->name),
                email:   @json($p->email ?? '—'),
                contact: @json($p->contact ?? '—'),
                address: @json($p->address ?? '—'),
                amount:  @json('₱' . number_format($p->amount, 2)),
                txn:     @json($txnLabel ?: '—'),
                fund:    @json($fundLabel),
                op:      @json($p->op_number ?? '—'),
                mode:    @json(ucfirst(str_replace('_', ' ', $p->payment_mode ?? 'cash'))),
                status:  @json(ucfirst($status)),
                statusCls: @json($statusCls),
                statusIcon: @json($statusIcon),
                date:    @json($p->created_at->format('F d, Y — h:i A')),
                details: @json($details),
              };
            </script>

          @empty
            <tr class="empty-row">
              <td colspan="9">
                <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                <div class="empty-text">No payment records found.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="table-footer">
        <span class="table-footer-info" id="footer-info">
          Showing <strong>{{ count($payments) }}</strong>
          {{ isset($payments->total) ? 'of <strong>' . $payments->total() . '</strong>' : '' }}
          records
        </span>
        @if(method_exists($payments, 'links'))
          <div class="pagination-wrap">
            {{ $payments->links() }}
          </div>
        @endif
      </div>

    </div><!-- /table-card -->

  </div><!-- /page-body -->

  <!-- ══════ DETAIL DRAWER ══════ -->
  <div class="drawer-overlay" id="drawer-overlay" onclick="closeDrawer()"></div>

  <div class="detail-drawer" id="detail-drawer">
    <div class="drawer-head">
      <div>
        <div class="drawer-head-title" id="drawer-payor-name">—</div>
        <div class="drawer-head-sub">Transaction Details</div>
      </div>
      <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x-lg"></i></button>
    </div>

    <div class="drawer-body" id="drawer-body">
      <!-- populated by JS -->
    </div>
  </div>

  <script>
    /* ── Table filter ── */
    function filterTable() {
      const q      = document.getElementById('tbl-search').value.toLowerCase();
      const status = document.getElementById('filter-status').value.toLowerCase();
      const fund   = document.getElementById('filter-fund').value.toLowerCase();
      const rows   = document.querySelectorAll('#table-body tr[data-search]');
      let visible  = 0;

      rows.forEach(row => {
        const matchQ = !q      || row.dataset.search.includes(q);
        const matchS = !status || row.dataset.status === status;
        const matchF = !fund   || row.dataset.fund.toLowerCase() === fund;
        const show   = matchQ && matchS && matchF;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
      });

      document.getElementById('record-count').textContent =
        visible + (visible === 1 ? ' record' : ' records');
      document.getElementById('footer-info').innerHTML =
        'Showing <strong>' + visible + '</strong> of <strong>' + rows.length + '</strong> records';
    }

    /* ── Detail Drawer ── */
    function openDrawer(id) {
      const d = window.__drawers?.[id];
      if (!d) return;

      document.getElementById('drawer-payor-name').textContent = d.name;

      let html = '';

      // Status strip
      html += `<div class="status-badge ${d.statusCls}" style="margin-bottom:18px; font-size:.75rem; padding:6px 14px;">
        <i class="bi ${d.statusIcon}"></i> ${d.status}
      </div>`;

      // Core info
      html += `<div class="drawer-section-title"><i class="bi bi-person-lines-fill"></i> Payor Information</div>`;
      html += field('Full Name', d.name);
      html += field('Email Address', d.email);
      html += field('Contact Number', d.contact);
      html += field('Address', d.address);

      html += `<hr class="drawer-divider">`;
      html += `<div class="drawer-section-title"><i class="bi bi-card-checklist"></i> Transaction Details</div>`;
      html += field('Transaction Type', d.txn);
      html += field('Fund', d.fund);
      html += field('Amount', d.amount);
      html += field('Order of Payment No.', d.op);
      html += field('Payment Mode', d.mode);
      html += field('Date Processed', d.date);

      // Extra details from meta
      if (d.details && Object.keys(d.details).length > 0) {
        html += `<hr class="drawer-divider">`;
        html += `<div class="drawer-section-title"><i class="bi bi-info-circle"></i> Additional Information</div>`;
        for (const [k, v] of Object.entries(d.details)) {
          html += field(k.replace(/_/g,' ').replace(/\b\w/g, c => c.toUpperCase()), v);
        }
      }

      document.getElementById('drawer-body').innerHTML = html;

      document.getElementById('drawer-overlay').classList.add('open');
      document.getElementById('detail-drawer').classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function field(label, value) {
      return `<div class="drawer-field">
        <div class="drawer-field-label">${label}</div>
        <div class="drawer-field-value">${value || '—'}</div>
      </div>`;
    }

    function closeDrawer() {
      document.getElementById('drawer-overlay').classList.remove('open');
      document.getElementById('detail-drawer').classList.remove('open');
      document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
  </script>

</body>
</html>