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
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); min-height: 100vh; color: var(--text-dark); }
    .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

    /* HEADER */
    .page-header { background: var(--green-deep); padding: 16px 32px; display: flex; align-items: center; gap: 14px; position: sticky; top: 0; z-index: 100; }
    .header-seal { width: 38px; height: 38px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }
    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }
    .btn-new-payment { display: flex; align-items: center; gap: 6px; padding: 8px 16px; background: var(--gold); border: none; border-radius: 8px; color: var(--green-deep); font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: .75rem; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; transition: background .15s, transform .12s; cursor: pointer; }
    .btn-new-payment:hover { background: var(--gold-light); color: var(--green-deep); transform: translateY(-1px); }

    /* PAGE BODY */
    .page-body { max-width: 1200px; margin: 0 auto; padding: 36px 24px 60px; }
    .page-title-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

    /* STAT CARDS */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
    .stat-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .si-green { background: var(--green-light); color: var(--green-accent); }
    .si-gold  { background: #fdf3dc; color: var(--gold); }
    .si-amber { background: #fff7ed; color: #c2640a; }
    .stat-value { font-size: 1.35rem; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
    .stat-label { font-size: .7rem; color: var(--muted); font-weight: 400; margin-top: 2px; }

    /* TOOLBAR */
    .toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
    .search-wrap { position: relative; flex: 1; min-width: 200px; }
    .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .88rem; pointer-events: none; }
    .search-wrap input { width: 100%; padding: 9px 12px 9px 34px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .85rem; color: var(--text-dark); background: var(--surface); outline: none; transition: border-color .2s, box-shadow .2s; }
    .search-wrap input:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); }
    .filter-select { padding: 9px 32px 9px 12px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .82rem; color: var(--text-dark); background: var(--surface); outline: none; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238a9e90' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; cursor: pointer; transition: border-color .2s; }
    .filter-select:focus { border-color: var(--green-accent); }

    /* TABLE */
    .table-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; }
    .table-card-header { padding: 14px 22px; background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .table-card-title { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 9px; }
    .table-record-count { font-size: .68rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; background: rgba(201,153,42,.2); color: var(--gold-light); border: 1px solid rgba(201,153,42,.25); }
    .payments-table { width: 100%; border-collapse: collapse; }
    .payments-table thead tr { background: #faf8f4; border-bottom: 1.5px solid var(--border); }
    .payments-table thead th { padding: 11px 16px; font-size: .68rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--text-mid); white-space: nowrap; }
    .payments-table thead th:first-child { padding-left: 22px; }
    .payments-table thead th:last-child  { padding-right: 22px; }
    .payments-table tbody tr { border-bottom: 1px solid var(--border); transition: background .13s; cursor: pointer; }
    .payments-table tbody tr:last-child { border-bottom: none; }
    .payments-table tbody tr:hover { background: #f9f7f2; }
    .payments-table tbody td { padding: 13px 16px; font-size: .85rem; color: var(--text-dark); vertical-align: middle; }
    .payments-table tbody td:first-child { padding-left: 22px; }
    .payments-table tbody td:last-child  { padding-right: 22px; }
    .row-id { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; background: var(--green-light); color: var(--green-accent); font-size: .72rem; font-weight: 700; }
    .payor-cell { display: flex; align-items: center; gap: 10px; }
    .payor-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--green-mid); color: #fff; font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .payor-name { font-weight: 600; font-size: .87rem; color: var(--text-dark); }
    .payor-contact { font-size: .72rem; color: var(--muted); margin-top: 1px; }
    .amount-cell { font-weight: 700; font-size: .92rem; color: var(--green-mid); }
    .txn-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; background: #f0f4f2; color: var(--text-mid); font-size: .72rem; font-weight: 600; white-space: nowrap; max-width: 200px; overflow: hidden; text-overflow: ellipsis; }
    .fund-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; background: #fdf3dc; color: var(--gold); font-size: .68rem; font-weight: 700; white-space: nowrap; }
    .op-number { font-size: .78rem; color: var(--text-mid); font-weight: 500; }
    .date-cell .date-main { font-size: .82rem; color: var(--text-dark); font-weight: 500; }
    .date-cell .date-time { font-size: .7rem; color: var(--muted); margin-top: 2px; }
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; white-space: nowrap; }
    .sb-approved { background: var(--green-light); color: var(--green-accent); }
    .sb-waiting  { background: #fdf3dc; color: #a0700a; }
    .sb-rejected { background: #fdf0ef; color: var(--red); }
    .sb-default  { background: #f0f4f2; color: var(--muted); }
    .action-btn { width: 30px; height: 30px; border-radius: 7px; border: 1.5px solid var(--border); background: #faf8f4; color: var(--text-mid); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; cursor: pointer; transition: background .15s, border-color .15s, color .15s; text-decoration: none; }
    .action-btn:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }
    .empty-row td { padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 2.4rem; color: var(--border); margin-bottom: 12px; }
    .empty-text { font-size: .85rem; color: var(--muted); }
    .table-footer { padding: 12px 22px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .table-footer-info { font-size: .75rem; color: var(--muted); }
    .table-footer-info strong { color: var(--text-mid); }
    .pagination-wrap { display: flex; align-items: center; gap: 4px; }

    /* DRAWER */
    .drawer-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 500; }
    .drawer-overlay.open { display: block; }
    .detail-drawer { position: fixed; top: 0; right: 0; width: 420px; max-width: 100vw; height: 100vh; background: var(--surface); box-shadow: -8px 0 40px rgba(0,0,0,.18); display: flex; flex-direction: column; transform: translateX(100%); transition: transform .28s cubic-bezier(.16,1,.3,1); z-index: 501; }
    .detail-drawer.open { transform: translateX(0); }
    .drawer-head { padding: 15px 18px; background: var(--green-deep); display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-shrink: 0; }
    .drawer-head-left { flex: 1; min-width: 0; }
    .drawer-head-title { font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; font-weight: 700; color: var(--gold-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .drawer-head-sub { font-size: .58rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.35); margin-top: 2px; }
    .drawer-head-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

    /* ── PRINT BUTTON ── */
    .drawer-print-btn {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 6px 13px;
      background: var(--gold);
      border: none; border-radius: 7px;
      color: var(--green-deep);
      font-family: 'DM Sans', sans-serif;
      font-size: .7rem; font-weight: 700;
      letter-spacing: .8px; text-transform: uppercase;
      cursor: pointer;
      transition: background .15s, transform .12s;
      white-space: nowrap;
    }
    .drawer-print-btn:hover { background: var(--gold-light); transform: translateY(-1px); }

    .drawer-close { width: 30px; height: 30px; border-radius: 7px; background: rgba(255,255,255,.08); border: none; color: rgba(245,240,232,.55); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: .95rem; transition: background .15s, color .15s; }
    .drawer-close:hover { background: rgba(255,255,255,.15); color: var(--cream); }
    .drawer-body { flex: 1; overflow-y: auto; padding: 22px; }
    .drawer-body::-webkit-scrollbar { width: 4px; }
    .drawer-body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    .drawer-section-title { font-size: .65rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); margin-bottom: 12px; display: flex; align-items: center; gap: 7px; }
    .drawer-section-title i { color: var(--green-accent); }
    .drawer-field { margin-bottom: 14px; }
    .drawer-field-label { font-size: .7rem; font-weight: 600; color: var(--muted); letter-spacing: .4px; text-transform: uppercase; margin-bottom: 3px; }
    .drawer-field-value { font-size: .88rem; color: var(--text-dark); font-weight: 500; line-height: 1.45; word-break: break-word; }
    .drawer-divider { border: none; border-top: 1px dashed var(--border); margin: 18px 0; }
    .alert-bar { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: .84rem; font-weight: 500; }
    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }

    @media (max-width: 900px) { .stat-row { grid-template-columns: repeat(2,1fr); } }
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
      <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
  @endif

  <div class="page-title-row">
    <div>
      <div class="page-title">Payment Records</div>
      <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
    </div>
  </div>

  <!-- STAT CARDS -->
  <div class="stat-row">
    <div class="stat-card">
      <div class="stat-icon si-green"><i class="bi bi-receipt"></i></div>
      <div class="stat-info">
        <div id="stat-total-count" class="stat-value">{{ $payments->total() ?? count($payments) }}</div>
        <div class="stat-label">Total Transactions</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-gold"><i class="bi bi-cash-coin"></i></div>
      <div class="stat-info">
        <div id="stat-total-amount" class="stat-value">₱{{ number_format($payments->sum('amount'), 2) }}</div>
        <div class="stat-label">Total Amount Collected</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-amber"><i class="bi bi-hourglass-split"></i></div>
      <div class="stat-info">
        <div id="stat-awaiting-count" class="stat-value">{{ $payments->where('status', 'waiting')->count() }}</div>
        <div class="stat-label">Awaiting Approval</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-green"><i class="bi bi-check-circle"></i></div>
      <div class="stat-info">
        <div id="stat-approved-count" class="stat-value">{{ $payments->where('status', 'approved')->count() }}</div>
        <div class="stat-label">Approved</div>
      </div>
    </div>
  </div>

  <!-- TOOLBAR -->
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

  <!-- TABLE CARD -->
  <div class="table-card">
    <div class="table-card-header">
      <div class="table-card-title"><i class="bi bi-table"></i> Transactions Log</div>
      <span class="table-record-count" id="record-count">{{ count($payments) }} record{{ count($payments) !== 1 ? 's' : '' }}</span>
    </div>

    <table class="payments-table" id="payments-table">
      <thead>
        <tr>
          <th>#</th><th>Payor</th><th>Amount</th><th>Transaction Type</th>
          <th>Fund</th><th>O.P. Number</th><th>Date</th><th>Status</th><th></th>
        </tr>
      </thead>
      <tbody id="table-body">
        @forelse($payments as $p)
          @php
            $status     = $p->status ?? 'waiting';
            $statusMap  = ['approved'=>'sb-approved','waiting'=>'sb-waiting','rejected'=>'sb-rejected'];
            $statusCls  = $statusMap[$status] ?? 'sb-default';
            $statusIcon = match($status) {
              'approved' => 'bi-check-circle-fill',
              'waiting'  => 'bi-hourglass-split',
              'rejected' => 'bi-x-circle-fill',
              default    => 'bi-circle'
            };
            $initials  = strtoupper(substr($p->name, 0, 1)) . (str_contains($p->name, ' ') ? strtoupper(substr(strrchr($p->name,' '),1,1)) : '');
            $txnNames = [
              'appeal_fee'               => 'Appeal Fee',
              'bidding_documents'        => 'Bidding Documents',
              'cash_bond'                => 'Cash Bond',
              'certification_copy_fee'   => 'Certification, Copy Fee and Reproduction Cost',
              'consignment'              => 'Consignment',
              'execution_judgment'       => 'Execution of Judgment Involving Money',
              'filing_fee'               => 'Filing Fee and Inspection Cost',
              'income_unserviceable'     => 'Income from Sale of Unserviceable Property',
              'legal_research'           => 'Legal Research',
              'performance_bond'         => 'Performance Bond',
              'refund_cash_advances'     => 'Refund of Cash Advances',
              'refund_overpayment'       => 'Refund of Overpayment',
              'settlement_disallowances' => 'Settlement of Notice of Disallowances',
              'unwithheld_remittances'   => 'Unwithheld Remittances',
            ];
            $rawTxn   = $p->transaction_type ?? '';
            $txnLabel = $txnNames[$rawTxn] ?? ucwords(str_replace('_',' ', $rawTxn));
            $fundLabel = $p->fund_type ?? '—';
            $meta      = $p->meta ?? [];
            $details   = [];
            if (!empty($p->contact))      $details['Contact']      = $p->contact;
            if (!empty($p->address))      $details['Address']      = $p->address;
            if (!empty($p->email))        $details['Email']        = $p->email;
            if (!empty($p->payment_mode)) $details['Payment Mode'] = ucfirst(str_replace('_',' ',$p->payment_mode));
            if (is_array($meta)) {
              foreach ($meta as $k => $v) {
                if ($v === null || $v === '') continue;
                $details[$k] = is_array($v) ? implode(', ', $v) : $v;
              }
            }
          @endphp
            <tr data-id="{{ $p->id }}" data-search="{{ strtolower($p->name.' '.($p->op_number??'').' '.($p->transaction_type??'')) }}"
              data-status="{{ $status }}" data-fund="{{ $p->fund_type??'' }}"
              onclick="openDrawer({{ $p->id }})">
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
            <td><span class="amount-cell">₱{{ number_format($p->amount,2) }}</span></td>
            <td><span class="txn-badge"><i class="bi bi-tag"></i> {{ $txnLabel ?: '—' }}</span></td>
            <td><span class="fund-badge">{{ $fundLabel }}</span></td>
            <td><span class="op-number">{{ $p->op_number ?? '—' }}</span></td>
            <td>
              <div class="date-cell">
                <div class="date-main">{{ $p->created_at->format('M d, Y') }}</div>
                <div class="date-time">{{ $p->created_at->format('h:i A') }}</div>
              </div>
            </td>
            <td><span class="status-badge {{ $statusCls }}"><i class="bi {{ $statusIcon }}"></i> {{ ucfirst($status) }}</span></td>
            <td onclick="event.stopPropagation()">
              <a href="#" class="action-btn" title="View" onclick="openDrawer({{ $p->id }});return false;"><i class="bi bi-eye"></i></a>
            </td>
          </tr>

          {{-- Drawer data store --}}
          <script>
            window.__drawers = window.__drawers || {};
            window.__drawers[{{ $p->id }}] = {
              id:         {{ $p->id }},
              name:       @json($p->name),
              email:      @json($p->email ?? '—'),
              contact:    @json($p->contact ?? '—'),
              address:    @json($p->address ?? '—'),
              amount:     @json('₱'.number_format($p->amount,2)),
              amountRaw:  @json(number_format($p->amount,2)),
              amountNum:  @json((float)$p->amount),
              txn:        @json($txnLabel ?: '—'),
              fund:       @json($fundLabel),
              op:         @json($p->op_number ?? '—'),
              mode:       @json(ucfirst(str_replace('_',' ',$p->payment_mode ?? 'cash'))),
              status:     @json(ucfirst($status)),
              statusCls:  @json($statusCls),
              statusIcon: @json($statusIcon),
              date:       @json($p->created_at->format('F d, Y — h:i A')),
              dateShort:  @json($p->created_at->format('m/d/Y')),
              details:    @json($details),
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
        {{ isset($payments->total) ? 'of <strong>'.$payments->total().'</strong>' : '' }} records
      </span>
      @if(method_exists($payments,'links'))
        <div class="pagination-wrap">{{ $payments->links() }}</div>
      @endif
    </div>
  </div>

</div><!-- /page-body -->

<!-- DETAIL DRAWER -->
<div class="drawer-overlay" id="drawer-overlay" onclick="closeDrawer()"></div>

<div class="detail-drawer" id="detail-drawer">
  <div class="drawer-head">
    <div class="drawer-head-left">
      <div class="drawer-head-title" id="drawer-payor-name">—</div>
      <div class="drawer-head-sub">Transaction Details</div>
    </div>
    <div class="drawer-head-actions">
      <button class="drawer-print-btn" onclick="printOrderOfPayment()">
        <i class="bi bi-printer-fill"></i> Print O.P.
      </button>
      <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x-lg"></i></button>
    </div>
  </div>
  <div class="drawer-body" id="drawer-body"></div>
</div>

<script>
  /* ── Filter ── */
  function filterTable() {
    const q = document.getElementById('tbl-search').value.toLowerCase();
    const s = document.getElementById('filter-status').value.toLowerCase();
    const f = document.getElementById('filter-fund').value.toLowerCase();
    const rows = document.querySelectorAll('#table-body tr[data-search]');
    let v = 0;
    rows.forEach(r => {
      const show = (!q || r.dataset.search.includes(q))
                && (!s || r.dataset.status === s)
                && (!f || r.dataset.fund.toLowerCase() === f);
      r.style.display = show ? '' : 'none';
      if (show) v++;
    });
    document.getElementById('record-count').textContent = v + (v === 1 ? ' record' : ' records');
    document.getElementById('footer-info').innerHTML = 'Showing <strong>' + v + '</strong> of <strong>' + rows.length + '</strong> records';
  }

  /* ── Drawer ── */
  let __active = null;

  function openDrawer(id) {
    const d = window.__drawers?.[id];
    if (!d) return;
    __active = d;
    document.getElementById('drawer-payor-name').textContent = d.name;
    let h = '';
    h += `<div class="status-badge ${d.statusCls}" style="margin-bottom:18px;font-size:.75rem;padding:6px 14px;"><i class="bi ${d.statusIcon}"></i> ${d.status}</div>`;
    h += `<div class="drawer-section-title"><i class="bi bi-person-lines-fill"></i> Payor Information</div>`;
    h += df('Full Name', d.name) + df('Email', d.email) + df('Contact Number', d.contact) + df('Address', d.address);
    h += `<hr class="drawer-divider">`;
    h += `<div class="drawer-section-title"><i class="bi bi-card-checklist"></i> Transaction Details</div>`;
    h += df('Transaction Type', d.txn) + df('Fund', d.fund) + df('Amount', d.amount) + df('Order of Payment No.', d.op) + df('Payment Mode', d.mode) + df('Date Processed', d.date);
    if (d.details && Object.keys(d.details).length) {
      h += `<hr class="drawer-divider">`;
      h += `<div class="drawer-section-title"><i class="bi bi-info-circle"></i> Additional Information</div>`;
      for (const [k, v] of Object.entries(d.details)) h += df(k.replace(/_/g,' ').replace(/\b\w/g,c=>c.toUpperCase()), v);
    }
    document.getElementById('drawer-body').innerHTML = h;
    document.getElementById('drawer-overlay').classList.add('open');
    document.getElementById('detail-drawer').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function df(label, value) {
    return `<div class="drawer-field"><div class="drawer-field-label">${label}</div><div class="drawer-field-value">${value||'—'}</div></div>`;
  }

  function closeDrawer() {
    document.getElementById('drawer-overlay').classList.remove('open');
    document.getElementById('detail-drawer').classList.remove('open');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });

  /* ════════════════════════════════════════════════════
     AMOUNT IN WORDS  (Philippine Peso)
  ════════════════════════════════════════════════════ */
  function amountInWords(amount) {
    const ones = ['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine',
                  'Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen',
                  'Seventeen','Eighteen','Nineteen'];
    const tens = ['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];

    function say(n) {
      if (n === 0) return '';
      if (n < 20)  return ones[n] + ' ';
      if (n < 100) return tens[Math.floor(n/10)] + (n%10 ? '-' + ones[n%10] : '') + ' ';
      if (n < 1000) return ones[Math.floor(n/100)] + ' Hundred ' + say(n%100);
      if (n < 1000000) return say(Math.floor(n/1000)) + 'Thousand ' + say(n%1000);
      if (n < 1000000000) return say(Math.floor(n/1000000)) + 'Million ' + say(n%1000000);
      return say(Math.floor(n/1000000000)) + 'Billion ' + say(n%1000000000);
    }

    const total   = Math.round(amount * 100);
    const pesos   = Math.floor(total / 100);
    const centavos = total % 100;

    let words = '';
    if (pesos === 0 && centavos === 0) return 'Zero Pesos Only';
    if (pesos > 0) words += say(pesos).trim() + (pesos === 1 ? ' Peso' : ' Pesos');
    if (centavos > 0) words += ' and ' + say(centavos).trim() + (centavos === 1 ? ' Centavo' : ' Centavos');
    else words += ' Only';
    return words;
  }

  /* ════════════════════════════════════════════════════
     PRINT ORDER OF PAYMENT  (Appendix 28 — 2-UP landscape)
  ════════════════════════════════════════════════════ */
  function printOrderOfPayment() {
    const d = __active;
    if (!d) return;

    /* ── Abbreviation expansion map ── */
    const abbrevMap = {
      'txn':   'Transaction',
      'exec':  'Execution',
      'asmt':  'Assessment',
      'amt':   'Amount',
      'no':    'Number',
      'num':   'Number',
      'ref':   'Reference',
      'dept':  'Department',
      'div':   'Division',
      'sec':   'Section',
      'acct':  'Account',
      'pymnt': 'Payment',
      'pymt':  'Payment',
      'pmt':   'Payment',
      'rec':   'Record',
      'yr':    'Year',
      'mo':    'Month',
      'lddap': 'LDDAP',
      'ada':   'ADA',
      'ors':   'ORS',
      'bur':   'Bureau',
      'rpt':   'Report',
      'adv':   'Advance',
    };

    function expandLabel(raw) {
      return raw
        .replace(/_/g, ' ')
        .replace(/([a-z])([A-Z])/g, '$1 $2')   // camelCase → words
        .split(/\s+/)
        .map(w => {
          const low = w.toLowerCase();
          return abbrevMap[low]
            ? abbrevMap[low]
            : w.charAt(0).toUpperCase() + w.slice(1).toLowerCase();
        })
        .join(' ');
    }

    /* Build purpose string from txn type + extra fields */
    const purposeParts = [d.txn];
    if (d.details) {
      for (const [k, v] of Object.entries(d.details)) {
        // Skip these fields entirely from the purpose line
        if (['Contact','Email','Payment Mode','Address'].includes(k)) continue;
        // For remark-type keys, show value only (no label)
        const isRemark = /remark/i.test(k);
        purposeParts.push(isRemark ? v : expandLabel(k) + ': ' + v);
      }
    }
    const purpose    = esc(purposeParts.join('  |  '));
    const amtWords   = esc(amountInWords(d.amountNum || parseFloat(d.amountRaw.replace(/,/g,'')) || 0));
    const entityName = 'Department of Agrarian Reform Regional Office 5';

    /* Single OP block — rendered twice */
    function opBlock() {
      return `
      <div class="op-wrap">

        <div class="appendix">Appendix 28</div>

        <!-- Header meta -->
        <div class="meta-grid">
          <div class="meta-line"><span class="meta-label">Entity Name&nbsp;:</span><span class="uline">${esc(entityName)}</span></div>
          <div class="meta-line"><span class="meta-label">Serial No.&nbsp;:</span><span class="uline">${esc(d.op)}</span></div>
          <div class="meta-line"><span class="meta-label">Fund Cluster&nbsp;:</span><span class="uline">${esc(d.fund)}</span></div>
          <div class="meta-line"><span class="meta-label">Date&nbsp;:</span><span class="uline">${esc(d.dateShort)}</span></div>
        </div>

        <!-- Title -->
        <div class="op-title">ORDER OF PAYMENT</div>

        <!-- To -->
        <p>The Collecting Officer<br>Cash/Treasury Unit</p>

        <!-- Please issue -->
        <p>Please issue Official Receipt in favor of
          <span class="inline-uline">${esc(d.name)}</span>
          <span class="field-label-small">(Name of Payor)</span>
        </p>

        <!-- Address -->
        <p>
          <span class="inline-uline addr-line">${esc(d.address)}</span>
          <span class="field-label-small">(Address/Office of Payor)</span>
        </p>

        <!-- Amount: words in the long field, figures in the (P___) box -->
        <div class="amount-row">
          in the amount of
          <span class="amt-field"><span class="auto-shrink">${amtWords}</span></span>
          <span>(P</span>
          <span class="peso-box">${esc(d.amountRaw)}</span>
          <span>)</span>
        </div>

        <!-- Purpose -->
        <div class="for-payment">for payment of</div>
        <div class="purpose-field">${purpose}</div>
        <div class="purpose-label">(Purpose)</div>

        <br>

        <!-- Per Bill with dated field -->
        <div class="bill-row">
          per Bill No. <span class="bill-field"></span>
          &nbsp;&nbsp;dated <span class="date-field"></span>.
        </div>

        <!-- Bank section -->
        <div class="bank-intro">Please deposit the collections under Bank Account/s:</div>
        <table class="bank-table">
          <thead>
            <tr>
              <th class="col-no">No.</th>
              <th class="col-name">Name of Bank</th>
              <th class="col-amt">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr><td class="col-no">&nbsp;</td><td class="col-name">&nbsp;</td><td class="col-amt">P</td></tr>
            <tr><td class="col-no">&nbsp;</td><td class="col-name">&nbsp;</td><td class="col-amt">&nbsp;</td></tr>
          </tbody>
        </table>

        <!-- Signature -->
        <div class="sig-section">
          <div class="sig-block">
            <span class="sig-name-underline">&nbsp;</span>
            <div class="sig-role-label">Division/Unit/Authorized Official</div>
          </div>
        </div>

      </div><!-- /op-wrap -->`;
    }

    const html = `<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order of Payment — ${esc(d.name)}</title>
<style>
  /* ── Page: A4 landscape, two equal columns ── */
  @page {
    size: A4 landscape;
    margin: 10mm 12mm;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 10pt;
    color: #000;
    background: #fff;
    line-height: 1.35;
  }

  /* ── Two-column layout ── */
  .page-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0 10mm;
    width: 100%;
    height: 100%;
  }
  .op-wrap {
    padding: 0;
    border-right: 1px dashed #bbb; /* cut guide between copies */
    padding-right: 8mm;
  }
  .op-wrap:last-child {
    border-right: none;
    padding-right: 0;
    padding-left: 8mm;
  }

  /* ── Appendix label ── */
  .appendix { text-align: right; font-size: 8pt; font-style: italic; margin-bottom: 3mm; }

  /* ── Header meta ── */
  .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2mm 6mm; margin-bottom: 2mm; }
  .meta-line { display: flex; align-items: flex-end; gap: 4pt; font-size: 9.5pt; }
  .meta-label { white-space: nowrap; }
  .uline { border-bottom: 1px solid #000; padding: 0 2pt 1pt; flex: 1; font-size: 9.5pt; }

  /* ── Title ── */
  .op-title { text-align: center; font-size: 13pt; font-weight: bold; letter-spacing: 1.5pt; margin: 4mm 0 5mm; }

  /* ── Body text ── */
  p { margin-bottom: 3.5mm; font-size: 10pt; }
  .inline-uline { display: inline-block; border-bottom: 1px solid #000; min-width: 140pt; padding: 0 3pt 1pt; vertical-align: bottom; font-size: clamp(7.5pt, 10pt, 10pt); }
  .addr-line { min-width: 200pt; }
  .field-label-small { display: block; text-align: center; font-size: 7.5pt; }

  /* ── Amount in figures + words ── */
  .amount-row { display: flex; align-items: flex-end; gap: 4pt; margin-bottom: 3mm; font-size: 10pt; }
  .amount-row .amt-field { flex: 1; border-bottom: 1px solid #000; padding: 0 3pt 1pt; font-style: italic; overflow: hidden; }
  .amount-row .peso-box  { border-bottom: 1px solid #000; padding: 0 3pt 1pt; min-width: 60pt; }
  /* shrinks text to fit if too long */
  .auto-shrink { display: inline-block; max-width: 100%; font-size: clamp(7pt, 9.5pt, 10pt); white-space: nowrap; }

  /* ── Purpose block ── */
  .for-payment { margin-bottom: 1.5mm; font-size: 10pt; }
  .purpose-field { border-bottom: 1px solid #000; padding: 2pt 3pt; font-size: clamp(7.5pt, 10pt, 10pt); min-height: 17pt; width: 100%; margin-bottom: 1pt; word-break: break-word; }
  .purpose-label { text-align: center; font-size: 7.5pt; }

  /* ── Per Bill ── */
  .bill-row { display: flex; align-items: flex-end; gap: 4pt; margin-bottom: 4mm; font-size: 10pt; }
  .bill-field { border-bottom: 1px solid #000; min-width: 70pt; padding: 0 3pt 1pt; display: inline-block; }
  .date-field { border-bottom: 1px solid #000; min-width: 55pt; padding: 0 3pt 1pt; display: inline-block; }

  /* ── Bank table ── */
  .bank-intro { font-size: 10pt; margin-bottom: 2mm; }
  .bank-table { width: 100%; border-collapse: collapse; }
  .bank-table th { font-weight: normal; text-decoration: underline; padding: 2pt 3pt; font-size: 10pt; text-align: left; }
  .bank-table td { height: 16pt; border-bottom: 1px solid #000; padding: 1pt 3pt; font-size: 10pt; }
  .bank-table .col-no   { width: 12%; }
  .bank-table .col-name { width: 55%; }
  .bank-table .col-amt  { width: 33%; }

  /* ── Signature ── */
  .sig-section { margin-top: 8mm; display: flex; justify-content: flex-end; align-items: flex-end; gap: 8pt; }
  .sig-block { text-align: center; }
  .sig-name-underline { display: block; border-bottom: 2px solid #000; min-width: 160pt; padding: 0 4pt 2pt; font-size: 10pt; font-weight: bold; text-align: center; min-height: 18pt; }
  .sig-role-label { font-size: 8pt; text-align: center; margin-top: 2pt; }
  .approved-aside { font-size: 9.5pt; }
  .approved-aside .lbl { font-weight: bold; }
  .approved-aside .val { font-size: 9pt; margin-top: 2pt; }

  @media print {
    body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  }
</style>
</head>
<body>

<div class="page-grid">
  ${opBlock()}
  ${opBlock()}
</div>

<script>
  window.onload = function () {
    window.print();
    window.onafterprint = function () { window.close(); };
  };
<\/script>
</body>
</html>`;

    const win = window.open('', '_blank', 'width=1100,height=800,scrollbars=yes');
    win.document.write(html);
    win.document.close();
  }

  /* HTML escape helper */
  function esc(s) {
    if (!s) return '';
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }
</script>

<script>
  // Poll server for payment status updates and refresh table badges and counts
  (function pollPayments(){
    async function refresh(){
      try{
        const res = await fetch('{{ route('payments.json') }}', {cache:'no-store'});
        if (!res.ok) return;
        const list = await res.json();
        const byId = {};
        list.forEach(p => byId[p.id] = p);

        // update rows
        document.querySelectorAll('#table-body tr[data-id]').forEach(tr => {
          const id = tr.getAttribute('data-id');
          const d = byId[id];
          if (!d) return;
          // update status badge
          const sb = tr.querySelector('.status-badge');
          if (sb) {
            let cls = 'sb-default';
            let icon = 'bi-circle';
            const st = (d.status||'waiting').toLowerCase();
            if (st === 'approved') { cls = 'sb-approved'; icon = 'bi-check-circle-fill'; }
            else if (st === 'rejected') { cls = 'sb-rejected'; icon = 'bi-x-circle-fill'; }
            else if (st === 'waiting') { cls = 'sb-waiting'; icon = 'bi-hourglass-split'; }
            sb.className = 'status-badge ' + cls;
            sb.innerHTML = '<i class="bi '+icon+'"></i> ' + (st.charAt(0).toUpperCase()+st.slice(1));
          }
        });

        // update summary counts
        const total = list.length;
        const sum = list.reduce((s,it)=> s + (parseFloat(it.amountRaw||it.amount||0)||0), 0);
        const awaiting = list.filter(it=> (it.status||'waiting') === 'waiting').length;
        const approved = list.filter(it=> (it.status||'waiting') === 'approved').length;

        const elTotal = document.getElementById('stat-total-count');
        if (elTotal) elTotal.textContent = total;
        const elAmount = document.getElementById('stat-total-amount');
        if (elAmount) elAmount.textContent = '₱' + sum.toFixed(2);
        const elAwait = document.getElementById('stat-awaiting-count');
        if (elAwait) elAwait.textContent = awaiting;
        const elApp = document.getElementById('stat-approved-count');
        if (elApp) elApp.textContent = approved;

        const rc = document.getElementById('record-count');
        if (rc) rc.textContent = total + ' record' + (total !== 1 ? 's' : '');

        const footer = document.getElementById('footer-info');
        if (footer) footer.innerHTML = 'Showing <strong>'+ document.querySelectorAll('#table-body tr[data-id]:not([style*="display: none"])').length +'</strong>' + (total? ' of <strong>'+total+'</strong>':'') + ' records';
      }catch(e){ /* ignore */ }
    }
    // initial
    refresh();
    // poll every 8 seconds
    setInterval(refresh, 8000);
  })();
</script>

</body>
</html>