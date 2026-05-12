<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accountant — Payment Approvals</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>

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
    .page-header { background: var(--green-deep); padding: 16px 32px; display: flex; align-items: center; gap: 14px; position: sticky; top: 0; z-index: 100; }
    .header-seal { width: 38px; height: 38px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }
    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }
    .btn-back { display: flex; align-items: center; gap: 6px; padding: 8px 16px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15); border-radius: 8px; color: var(--cream); font-family: 'DM Sans', sans-serif; font-weight: 500; font-size: .75rem; letter-spacing: .5px; text-decoration: none; transition: background .15s; }
    .btn-logout {
      display: flex; align-items: center; gap: 6px; padding: 8px 16px;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      border: 1px solid rgba(201,153,42,.35); border-radius: 8px; color: var(--green-deep);
      font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: .75rem; letter-spacing: .5px;
      cursor: pointer; transition: all .18s ease; box-shadow: 0 2px 6px rgba(0,0,0,.08);
    }
    .btn-logout:hover { background: linear-gradient(135deg, #d6a73b, #f0cf7b); transform: translateY(-1px); box-shadow: 0 4px 10px rgba(0,0,0,.12); }
    .btn-logout:active { transform: translateY(0); }
    .btn-logout i { font-size: .82rem; }
    .btn-back:hover { background: rgba(255,255,255,.15); color: var(--cream); }

    /* ── PAGE BODY ── */
    .page-body { max-width: 1200px; margin: 0 auto; padding: 36px 24px 60px; }
    .page-title-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

    /* ── ALERT ── */
    .alert-bar { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: .84rem; font-weight: 500; }
    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }
    .alert-danger   { background: #fdf0ef; color: var(--red); border: 1px solid rgba(160,37,28,.2); }

    /* ── STAT CARDS ── */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
    .stat-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; }
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
    .filter-select { padding: 9px 32px 9px 12px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .82rem; color: var(--text-dark); background: var(--surface); outline: none; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238a9e90' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; cursor: pointer; transition: border-color .2s; }
    .filter-select:focus { border-color: var(--green-accent); }

    /* ── TABLE CARD ── */
    .table-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; }
    .table-card-header { padding: 14px 22px; background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .table-card-title { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 9px; }
    .table-record-count { font-size: .68rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; background: rgba(201,153,42,.2); color: var(--gold-light); border: 1px solid rgba(201,153,42,.25); }

    /* ── APPROVED TABLE CARD HEADER (distinct teal-green tone) ── */
    .table-card-header-approved {
      padding: 14px 22px;
      background: linear-gradient(90deg, #0f3d2a, #1a5c3a);
      display: flex; align-items: center; justify-content: space-between; gap: 12px;
    }
    .approved-count-badge {
      font-size: .68rem; font-weight: 600; padding: 3px 10px; border-radius: 20px;
      background: rgba(45,122,79,.35); color: #a3e4bc; border: 1px solid rgba(45,122,79,.4);
    }

    .approvals-table { width: 100%; border-collapse: collapse; }
    .approvals-table thead tr { background: #faf8f4; border-bottom: 1.5px solid var(--border); }
    .approvals-table thead th { padding: 11px 16px; font-size: .68rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--text-mid); white-space: nowrap; }
    .approvals-table thead th:first-child { padding-left: 22px; }
    .approvals-table thead th:last-child  { padding-right: 22px; }
    .approvals-table tbody tr { border-bottom: 1px solid var(--border); transition: background .13s; }
    .approvals-table tbody tr:last-child { border-bottom: none; }
    .approvals-table tbody tr:hover { background: #f9f7f2; }
    .approvals-table tbody td { padding: 13px 16px; font-size: .85rem; color: var(--text-dark); vertical-align: middle; }
    .approvals-table tbody td:first-child { padding-left: 22px; }
    .approvals-table tbody td:last-child  { padding-right: 22px; }

    /* Approved table rows get a very subtle green tint on hover */
    .approved-table tbody tr:hover { background: #f2faf5; }

    /* ── CELLS ── */
    .row-id { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; background: var(--green-light); color: var(--green-accent); font-size: .72rem; font-weight: 700; }
    .payor-cell { display: flex; align-items: center; gap: 10px; }
    .payor-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--green-mid); color: #fff; font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .payor-avatar-approved { background: var(--green-accent); }
    .payor-name { font-weight: 600; font-size: .87rem; color: var(--text-dark); }
    .payor-contact { font-size: .72rem; color: var(--muted); margin-top: 1px; }
    .amount-cell { font-weight: 700; font-size: .92rem; color: var(--green-mid); }
    .fund-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; background: #fdf3dc; color: var(--gold); font-size: .68rem; font-weight: 700; white-space: nowrap; }
    .op-number { font-size: .78rem; color: var(--text-mid); font-weight: 500; }
    .date-main { font-size: .82rem; color: var(--text-dark); font-weight: 500; }
    .date-time  { font-size: .7rem; color: var(--muted); margin-top: 2px; }

    /* ── APPROVED DATE CELL ── */
    .approved-on-main { font-size: .82rem; color: var(--green-accent); font-weight: 600; }
    .approved-on-time { font-size: .7rem; color: var(--muted); margin-top: 2px; }

    /* ── APPROVED CHECK MARK ── */
    .approved-stamp {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 5px 12px; border-radius: 20px;
      background: var(--green-light); color: var(--green-accent);
      font-size: .72rem; font-weight: 700; letter-spacing: .4px; text-transform: uppercase;
      border: 1px solid rgba(45,122,79,.2);
    }

    /* ── STATUS BADGES ── */
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; white-space: nowrap; }
    .sb-approved { background: var(--green-light); color: var(--green-accent); }
    .sb-waiting  { background: #fdf3dc; color: #a0700a; }
    .sb-rejected { background: #fdf0ef; color: var(--red); }

    /* ── ACTION BUTTONS ── */
    .actions-cell { display: flex; align-items: center; gap: 6px; }
    .btn-approve { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border: none; border-radius: 7px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s; letter-spacing: .3px; }
    .btn-approve:hover { background: var(--green-mid); }
    .btn-reject  { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border: 1.5px solid #e8c5c5; border-radius: 7px; background: #fdf0ef; color: var(--red); font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s, border-color .15s; letter-spacing: .3px; }
    .btn-reject:hover { background: #fde0de; border-color: #f0a8a8; }

    /* ── TABLE FOOTER ── */
    .table-footer { padding: 12px 22px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .table-footer-info { font-size: .75rem; color: var(--muted); }
    .table-footer-info strong { color: var(--text-mid); }
    .pagination-wrap { display: flex; align-items: center; gap: 4px; }

    /* ── SECTION DIVIDER ── */
    .section-divider {
      display: flex; align-items: center; gap: 14px;
      margin: 36px 0 20px;
    }
    .section-divider-line { flex: 1; height: 1px; background: var(--border); }
    .section-divider-label {
      display: flex; align-items: center; gap: 8px;
      font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 700;
      color: var(--green-accent); white-space: nowrap;
    }
    .section-divider-label i { font-size: 1rem; }

    /* ── APPROVED TOTAL STRIP ── */
    .approved-total-strip {
      display: flex; align-items: center; justify-content: space-between;
      background: var(--green-light); border: 1px solid rgba(45,122,79,.2);
      border-radius: 10px; padding: 11px 18px; margin-bottom: 14px;
      flex-wrap: wrap; gap: 10px;
    }
    .approved-total-label { font-size: .8rem; color: var(--green-mid); font-weight: 500; display: flex; align-items: center; gap: 7px; }
    .approved-total-amount { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 700; color: var(--green-deep); }

    /* ── APPROVED SEARCH TOOLBAR ── */
    .approved-toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; flex-wrap: wrap; }

    /* ── EMPTY STATE ── */
    .empty-row td { padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 2.4rem; color: var(--border); margin-bottom: 12px; }
    .empty-text { font-size: .85rem; color: var(--muted); }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) { .stat-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) {
      .page-body { padding: 20px 14px 48px; }
      .page-header { padding: 14px 18px; }
      .stat-row { grid-template-columns: 1fr 1fr; }
      .approvals-table thead { display: none; }
      .approvals-table tbody td { display: block; padding: 6px 16px; }
      .approvals-table tbody td:first-child { padding-top: 14px; }
      .approvals-table tbody td:last-child  { padding-bottom: 14px; }
    }
  </style>
</head>
<body>

<div class="top-stripe"></div>

{{-- ── HEADER ── --}}
<header class="page-header">
  <div class="header-seal">🌾</div>
  <div class="header-text">
    <div class="t1">Republic of the Philippines</div>
    <div class="t2">Department of Agrarian Reform</div>
  </div>
  <div class="header-sep"></div>
  <div class="header-page">Payment Approvals</div>
  <div class="header-actions">
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
      @csrf
      <button type="submit" class="btn-logout">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </div>
</header>

<div class="page-body">

  {{-- ── FLASH MESSAGES ── --}}
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

  {{-- ── PAGE TITLE ── --}}
  <div class="page-title-row">
    <div>
      <div class="page-title">Accountant — Approval Queue</div>
      <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
    </div>
  </div>

  {{-- ── STAT CARDS ── --}}
  @php
    $total    = $payments->total() ?? count($payments);
    $waiting  = $payments->whereIn('status', ['forwarded', 'accountant_rejected'])->count();
    $approved = \App\Models\Payment::where('status', 'approved')->count();
    $rejected = \App\Models\Payment::where('status', 'accountant_rejected')->count();

    // Fetch all approved payments for the bottom table
    $approvedPayments = \App\Models\Payment::where('status', 'approved')
                          ->orderByDesc('updated_at')
                          ->get();
    $approvedTotal = $approvedPayments->sum('amount');
  @endphp

  <div class="stat-row">
    <div class="stat-card">
      <div class="stat-icon si-green"><i class="bi bi-receipt"></i></div>
      <div>
        <div class="stat-value">{{ $total }}</div>
        <div class="stat-label">Total Transactions</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-amber"><i class="bi bi-hourglass-split"></i></div>
      <div>
        <div class="stat-value">{{ $waiting }}</div>
        <div class="stat-label">Awaiting Approval</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-green"><i class="bi bi-check-circle"></i></div>
      <div>
        <div class="stat-value">{{ $approved }}</div>
        <div class="stat-label">Approved</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-red"><i class="bi bi-x-circle"></i></div>
      <div>
        <div class="stat-value">{{ $rejected }}</div>
        <div class="stat-label">Rejected</div>
      </div>
    </div>
  </div>

  {{-- ── TOOLBAR ── --}}
  <div class="toolbar">
    <div class="search-wrap">
      <i class="bi bi-search"></i>
      <input type="text" id="tbl-search" placeholder="Search by payor name or O.P. number…" oninput="filterTable()"/>
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

  {{-- ── PENDING / REVIEW TABLE CARD ── --}}
  <div class="table-card">
    <div class="table-card-header">
      <div class="table-card-title">
        <i class="bi bi-clipboard2-check"></i> Transactions for Review
      </div>
      <span class="table-record-count" id="record-count">
        {{ count($payments) }} record{{ count($payments) !== 1 ? 's' : '' }}
      </span>
    </div>

    <table class="approvals-table" id="approvals-table">
      <thead>
        <tr>
          <th>Payor</th>
          <th>Amount</th>
          <th>Fund</th>
          <th>O.P. Number</th>
          <th>Date Submitted</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @forelse($payments as $p)
          @php
            $status    = $p->status ?? 'submitted';
            $statusMap = [
              'approved'           => 'sb-approved',
              'forwarded'          => 'sb-waiting',
              'under_review'       => 'sb-waiting',
              'submitted'          => 'sb-waiting',
              'accountant_rejected'=> 'sb-rejected',
              'rejected'           => 'sb-rejected',
            ];
            $statusCls  = $statusMap[$status] ?? 'sb-waiting';
            $statusIcon = match($status) {
              'approved'                        => 'bi-check-circle-fill',
              'accountant_rejected', 'rejected' => 'bi-x-circle-fill',
              default                           => 'bi-hourglass-split',
            };
            $nameParts = explode(' ', trim($p->name));
            $initials  = strtoupper(substr($nameParts[0], 0, 1)) . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '');
          @endphp

          <tr
            data-search="{{ strtolower($p->name . ' ' . ($p->op_number ?? '')) }}"
            data-status="{{ $status }}"
            data-fund="{{ $p->fund_type ?? '' }}"
          >
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
            <td><span class="fund-badge">{{ $p->fund_type ?? '—' }}</span></td>
            <td><span class="op-number">{{ $p->op_number ?? '—' }}</span></td>
            <td>
              <div class="date-main">{{ $p->created_at->format('M d, Y') }}</div>
              <div class="date-time">{{ $p->created_at->format('h:i A') }}</div>
            </td>
            <td>
              <span class="status-badge {{ $statusCls }}">
                <i class="bi {{ $statusIcon }}"></i> {{ ucwords(str_replace('_', ' ', $status)) }}
              </span>
            </td>
            <td>
              <div class="actions-cell">
                @if($status !== 'approved')
                  <form
                    method="POST"
                    action="{{ route('accountant.approve', $p->id) }}"
                    onsubmit="return confirm('Approve payment from {{ addslashes($p->name) }} (₱{{ number_format($p->amount, 2) }})?')"
                  >
                    @csrf
                    <button type="submit" class="btn-approve">
                      <i class="bi bi-check-lg"></i> Approve
                    </button>
                  </form>
                @endif

                @if($status !== 'accountant_rejected')
                  <form
                    method="POST"
                    action="{{ route('accountant.reject', $p->id) }}"
                    onsubmit="
                      var r = prompt('Enter rejection remarks (optional):');
                      if (r === null) return false;
                      this.querySelector('input[name=remarks]').value = r;
                      return confirm('Reject payment from {{ addslashes($p->name) }} (₱{{ number_format($p->amount, 2) }})?');
                    "
                  >
                    @csrf
                    <input type="hidden" name="remarks" value="" />
                    <button type="submit" class="btn-reject">
                      <i class="bi bi-x-lg"></i> Reject
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>

        @empty
          <tr class="empty-row">
            <td colspan="7">
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
        @if(method_exists($payments, 'total') && $payments->total() > count($payments))
          of <strong>{{ $payments->total() }}</strong>
        @endif
        records
      </span>
      @if(method_exists($payments, 'links'))
        <div class="pagination-wrap">{{ $payments->links() }}</div>
      @endif
    </div>
  </div>


  {{-- ════════════════════════════════════════════════════
       ── APPROVED TRANSACTIONS SECTION ──
       ════════════════════════════════════════════════════ --}}

  <div class="section-divider">
    <div class="section-divider-line"></div>
    <div class="section-divider-label">
      <i class="bi bi-patch-check-fill"></i> Approved Transactions
    </div>
    <div class="section-divider-line"></div>
  </div>

  {{-- Total approved amount strip --}}
  <div class="approved-total-strip">
    <div class="approved-total-label">
      <i class="bi bi-wallet2"></i>
      Total Approved Amount
    </div>
    <div class="approved-total-amount">₱{{ number_format($approvedTotal, 2) }}</div>
  </div>

  {{-- Search toolbar for approved table --}}
  <div class="approved-toolbar">
    <div class="search-wrap">
      <i class="bi bi-search"></i>
      <input type="text" id="approved-search" placeholder="Search approved transactions…" oninput="filterApproved()"/>
    </div>
    <select class="filter-select" id="approved-filter-fund" onchange="filterApproved()">
      <option value="">All Funds</option>
      <option value="F01">Fund 01 — Regular</option>
      <option value="F03">Fund 03 — ARF</option>
      <option value="F07">Fund 07 — Trust</option>
      <option value="F02-LP">LP Split — Fund 02</option>
      <option value="F02-GOP">GOP Split — Fund 02</option>
    </select>
  </div>

  <div class="table-card">
    <div class="table-card-header-approved">
      <div class="table-card-title">
        <i class="bi bi-check2-all"></i> Approved Payment Records
      </div>
      <span class="approved-count-badge" id="approved-record-count">
        {{ $approvedPayments->count() }} record{{ $approvedPayments->count() !== 1 ? 's' : '' }}
      </span>
    </div>

    <table class="approvals-table approved-table" id="approved-table">
      <thead>
        <tr>
          <th>Payor</th>
          <th>Amount</th>
          <th>Fund</th>
          <th>O.P. Number</th>
          <th>Date Submitted</th>
          <th>Approved On</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="approved-body">
        @forelse($approvedPayments as $ap)
          @php
            $apNameParts = explode(' ', trim($ap->name));
            $apInitials  = strtoupper(substr($apNameParts[0], 0, 1)) . (isset($apNameParts[1]) ? strtoupper(substr($apNameParts[1], 0, 1)) : '');
          @endphp
          <tr
            data-search="{{ strtolower($ap->name . ' ' . ($ap->op_number ?? '')) }}"
            data-fund="{{ $ap->fund_type ?? '' }}"
          >
            <td>
              <div class="payor-cell">
                <div class="payor-avatar payor-avatar-approved">{{ $apInitials }}</div>
                <div>
                  <div class="payor-name">{{ $ap->name }}</div>
                  <div class="payor-contact">{{ $ap->email ?? ($ap->contact ?? '—') }}</div>
                </div>
              </div>
            </td>
            <td><span class="amount-cell">₱{{ number_format($ap->amount, 2) }}</span></td>
            <td><span class="fund-badge">{{ $ap->fund_type ?? '—' }}</span></td>
            <td><span class="op-number">{{ $ap->op_number ?? '—' }}</span></td>
            <td>
              <div class="date-main">{{ $ap->created_at->format('M d, Y') }}</div>
              <div class="date-time">{{ $ap->created_at->format('h:i A') }}</div>
            </td>
            <td>
              <div class="approved-on-main">{{ $ap->updated_at->format('M d, Y') }}</div>
              <div class="approved-on-time">{{ $ap->updated_at->format('h:i A') }}</div>
            </td>
            <td>
              <span class="approved-stamp">
                <i class="bi bi-check-circle-fill"></i> Approved
              </span>
            </td>
          </tr>

        @empty
          <tr class="empty-row">
            <td colspan="7">
              <div class="empty-icon"><i class="bi bi-check2-circle"></i></div>
              <div class="empty-text">No approved transactions yet.</div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="table-footer">
      <span class="table-footer-info" id="approved-footer-info">
        Showing <strong>{{ $approvedPayments->count() }}</strong> approved records
      </span>
    </div>
  </div>

</div>{{-- /page-body --}}

{{-- ── CLIENT-SIDE FILTERS ── --}}
<script>
  /* ── Review queue filter ── */
  function filterTable() {
    const q   = document.getElementById('tbl-search').value.toLowerCase();
    const sf  = document.getElementById('filter-status').value.toLowerCase();
    const ff  = document.getElementById('filter-fund').value.toLowerCase();
    const rows = document.querySelectorAll('#table-body tr[data-search]');
    let visible = 0;

    rows.forEach(row => {
      const show =
        (!q  || row.dataset.search.includes(q)) &&
        (!sf || row.dataset.status === sf)       &&
        (!ff || row.dataset.fund.toLowerCase() === ff);
      row.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    document.getElementById('record-count').textContent =
      visible + (visible === 1 ? ' record' : ' records');
    document.getElementById('footer-info').innerHTML =
      'Showing <strong>' + visible + '</strong> of <strong>' + rows.length + '</strong> records';
  }

  /* ── Approved table filter ── */
  function filterApproved() {
    const q   = document.getElementById('approved-search').value.toLowerCase();
    const ff  = document.getElementById('approved-filter-fund').value.toLowerCase();
    const rows = document.querySelectorAll('#approved-body tr[data-search]');
    let visible = 0;

    rows.forEach(row => {
      const show =
        (!q  || row.dataset.search.includes(q)) &&
        (!ff || row.dataset.fund.toLowerCase() === ff);
      row.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    document.getElementById('approved-record-count').textContent =
      visible + (visible === 1 ? ' record' : ' records');
    document.getElementById('approved-footer-info').innerHTML =
      'Showing <strong>' + visible + '</strong> approved records';
  }
</script>

</body>
</html>