<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accountant — Approved Records</title>
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

    .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

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
    .header-seal { width: 38px; height: 38px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }
    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }
    .btn-logout {
      display: flex; align-items: center; gap: 6px; padding: 8px 16px;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      border: 1px solid rgba(201,153,42,.35); border-radius: 8px; color: var(--green-deep);
      font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: .75rem; letter-spacing: .5px;
      cursor: pointer; transition: all .18s ease; box-shadow: 0 2px 6px rgba(0,0,0,.08);
    }
    .btn-logout:hover { background: linear-gradient(135deg, #d6a73b, #f0cf7b); transform: translateY(-1px); }

    .outer-wrapper { display: flex; min-height: calc(100vh - 72px); }

    .sidebar {
      width: 260px; flex-shrink: 0; background: var(--green-deep);
      border-right: 1px solid rgba(255,255,255,.07);
      position: sticky; top: 72px; height: calc(100vh - 72px);
      display: flex; flex-direction: column;
    }
    .sidebar-inner { flex: 1; overflow-y: auto; padding: 24px 0 0; }
    .sidebar-inner::-webkit-scrollbar { width: 3px; }
    .sidebar-inner::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }
    .sidebar-profile { padding: 0 22px 20px; display: flex; align-items: center; gap: 11px; }
    .profile-avatar {
      width: 40px; height: 40px; border-radius: 50%;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      display: flex; align-items: center; justify-content: center;
      font-size: .85rem; font-weight: 700; color: var(--green-deep); flex-shrink: 0;
    }
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
    .nav-badge { margin-left: auto; background: #c2640a; color: #fff; font-size: .6rem; font-weight: 700; padding: 2px 7px; border-radius: 20px; }
    .sidebar-footer { padding: 14px 22px; border-top: 1px solid rgba(255,255,255,.07); flex-shrink: 0; }
    .sidebar-footer-label { font-size: .6rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.3); margin-bottom: 4px; }
    .sidebar-footer-value { font-size: .73rem; color: rgba(245,240,232,.5); font-weight: 300; }

    .main-content { flex: 1; min-width: 0; }
    .page-body { max-width: 1100px; margin: 0 auto; padding: 36px 28px 60px; }

    .page-title-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

    .alert-bar { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: .84rem; font-weight: 500; }
    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }
    .alert-danger   { background: #fdf0ef; color: var(--red); border: 1px solid rgba(160,37,28,.2); }

    /* ── SUMMARY STRIP ── */
    .approved-total-strip {
      display: flex; align-items: center; justify-content: space-between;
      background: var(--green-light); border: 1px solid rgba(45,122,79,.2);
      border-radius: 10px; padding: 14px 22px; margin-bottom: 20px;
      flex-wrap: wrap; gap: 10px;
    }
    .approved-total-label { font-size: .82rem; color: var(--green-mid); font-weight: 500; display: flex; align-items: center; gap: 8px; }
    .approved-total-amount { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 700; color: var(--green-deep); }

    .toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
    .search-wrap { position: relative; flex: 1; min-width: 200px; }
    .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .88rem; pointer-events: none; }
    .search-wrap input { width: 100%; padding: 9px 12px 9px 34px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .85rem; color: var(--text-dark); background: var(--surface); outline: none; transition: border-color .2s, box-shadow .2s; }
    .search-wrap input:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); }
    .filter-select { padding: 9px 32px 9px 12px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .82rem; color: var(--text-dark); background: var(--surface); outline: none; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238a9e90' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; cursor: pointer; transition: border-color .2s; }
    .filter-select:focus { border-color: var(--green-accent); }

    .table-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; }
    .table-card-header-approved { padding: 14px 22px; background: linear-gradient(90deg, #0f3d2a, #1a5c3a); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .table-card-title { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 9px; }
    .approved-count-badge { font-size: .68rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; background: rgba(45,122,79,.35); color: #a3e4bc; border: 1px solid rgba(45,122,79,.4); }

    .approvals-table { width: 100%; border-collapse: collapse; }
    .approvals-table thead tr { background: #faf8f4; border-bottom: 1.5px solid var(--border); }
    .approvals-table thead th { padding: 11px 16px; font-size: .68rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--text-mid); white-space: nowrap; }
    .approvals-table thead th:first-child { padding-left: 22px; }
    .approvals-table thead th:last-child  { padding-right: 22px; }
    .approvals-table tbody tr { border-bottom: 1px solid var(--border); transition: background .13s; }
    .approvals-table tbody tr:last-child { border-bottom: none; }
    .approvals-table tbody tr:hover { background: #f2faf5; }
    .approvals-table tbody td { padding: 13px 16px; font-size: .85rem; color: var(--text-dark); vertical-align: middle; }
    .approvals-table tbody td:first-child { padding-left: 22px; }
    .approvals-table tbody td:last-child  { padding-right: 22px; }

    .payor-cell { display: flex; align-items: center; gap: 10px; }
    .payor-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--green-accent); color: #fff; font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .payor-name { font-weight: 600; font-size: .87rem; color: var(--text-dark); }
    .payor-contact { font-size: .72rem; color: var(--muted); margin-top: 1px; }
    .amount-cell { font-weight: 700; font-size: .92rem; color: var(--green-mid); }
    .fund-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; background: #fdf3dc; color: var(--gold); font-size: .68rem; font-weight: 700; white-space: nowrap; }
    .op-number { font-size: .78rem; color: var(--text-mid); font-weight: 500; }
    .date-main { font-size: .82rem; color: var(--text-dark); font-weight: 500; }
    .date-time  { font-size: .7rem; color: var(--muted); margin-top: 2px; }
    .approved-on-main { font-size: .82rem; color: var(--green-accent); font-weight: 600; }
    .approved-on-time { font-size: .7rem; color: var(--muted); margin-top: 2px; }
    .approved-stamp { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; background: var(--green-light); color: var(--green-accent); font-size: .72rem; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; border: 1px solid rgba(45,122,79,.2); }

    .table-footer { padding: 12px 22px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .table-footer-info { font-size: .75rem; color: var(--muted); }
    .table-footer-info strong { color: var(--text-mid); }

    /* Pagination styles */
    .pagination-wrap { display:flex; align-items:center; gap:8px; margin-left:auto; }
    .page-link, .page-number { padding:6px 10px; border-radius:8px; text-decoration:none; font-weight:700; color:var(--green-accent); border:1px solid transparent; background:transparent; }
    .page-link.disabled { opacity:0.5; pointer-events:none; color:var(--muted); }
    .page-number { color:var(--text-dark); border:1px solid transparent; }
    .page-number:hover { background:#f2faf5; border-color:var(--border); }
    .page-number.active { background:var(--gold); color:var(--green-deep); border-color:var(--gold); }
    .page-summary { font-size:.85rem; color:var(--muted); margin-left:12px; }

    .empty-row td { padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 2.4rem; color: var(--border); margin-bottom: 12px; }
    .empty-text { font-size: .85rem; color: var(--muted); }

    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }
      .sidebar { width: 100%; height: auto; position: static; }
      .sidebar-profile, .sidebar-divider, .nav-section-label, .sidebar-footer { display: none; }
      .sidebar-inner { display: flex; overflow-x: auto; padding: 8px 0; }
      .nav-item { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
      .nav-item.active { border-bottom-color: var(--gold); }
      .page-body { padding: 20px 16px 48px; }
    }
    @media (max-width: 640px) {
      .approvals-table thead { display: none; }
      .approvals-table tbody td { display: block; padding: 6px 16px; }
      .approvals-table tbody td:first-child { padding-top: 14px; }
      .approvals-table tbody td:last-child  { padding-bottom: 14px; }
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
  <div class="header-page">Approved Records</div>
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

  <aside class="sidebar">
    <div class="sidebar-inner">
      <div class="sidebar-profile">
        <div class="profile-avatar">AC</div>
        <div>
          <div class="profile-name">{{ auth()->user()->name ?? 'Accountant' }}</div>
          <div class="profile-role">Accountant</div>
        </div>
      </div>
      <hr class="sidebar-divider">

      <div class="nav-section-label" style="margin-top:16px;">Transactions</div>
      <a class="nav-item" href="{{ route('accountant.approval') }}">
        <div class="nav-icon"><i class="bi bi-hourglass-split"></i></div>
        <span class="nav-label">For Review</span>
      </a>
      <a class="nav-item active" href="{{ route('accountant.approved') }}">
        <div class="nav-icon"><i class="bi bi-check2-circle"></i></div>
        <span class="nav-label">Approved Records</span>
      </a>

      <div class="nav-section-label" style="margin-top:16px;">Account</div>
      <a class="{{ request()->routeIs('accountant.profile') ? 'nav-item active' : 'nav-item' }}" href="{{ route('accountant.profile') }}">
        <div class="nav-icon"><i class="bi bi-person-badge"></i></div>
        <span class="nav-label">My Profile</span>
      </a>
    </div>
    <div class="sidebar-footer">
      <div class="sidebar-footer-label">System</div>
      <div class="sidebar-footer-value">DAR Cashier — Regional Office V</div>
    </div>
  </aside>

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

      @php
        $approvedPayments = $approvedPayments ?? \App\Models\Payment::where('status', 'approved')->orderByDesc('updated_at')->get();
        $approvedTotal    = $approvedPayments->sum('amount');
      @endphp

      <div class="page-title-row">
        <div>
          <div class="page-title">Approved Transactions</div>
          <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
        </div>
      </div>

      <div class="approved-total-strip">
        <div class="approved-total-label">
          <i class="bi bi-wallet2"></i> Total Approved Amount
        </div>
        <div class="approved-total-amount">₱{{ number_format($approvedTotal, 2) }}</div>
      </div>

      <div class="toolbar">
        <div class="search-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="approved-search" placeholder="Search approved transactions…" oninput="filterApproved()"/>
        </div>
        <select class="filter-select" id="approved-filter-fund" onchange="filterApproved()">
          <option value="">All Funds</option>
          <option value="F01">Fund 01 — Regular</option>
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

        <table class="approvals-table" id="approved-table">
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
                    <div class="payor-avatar">{{ $apInitials }}</div>
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

          @if(method_exists($approvedPayments, 'lastPage'))
            <div class="pagination-wrap" aria-label="Pagination">
              @if($approvedPayments->onFirstPage())
                <span class="page-link disabled">« Previous</span>
              @else
                <a class="page-link" href="{{ $approvedPayments->previousPageUrl() }}">« Previous</a>
              @endif

              @for($i = 1; $i <= $approvedPayments->lastPage(); $i++)
                @if($i == $approvedPayments->currentPage())
                  <span class="page-number active">{{ $i }}</span>
                @else
                  <a class="page-number" href="{{ $approvedPayments->url($i) }}">{{ $i }}</a>
                @endif
              @endfor

              @if($approvedPayments->hasMorePages())
                <a class="page-link" href="{{ $approvedPayments->nextPageUrl() }}">Next »</a>
              @else
                <span class="page-link disabled">Next »</span>
              @endif

              <div class="page-summary">Showing {{ $approvedPayments->firstItem() }} to {{ $approvedPayments->lastItem() }} of {{ $approvedPayments->total() }} results</div>
            </div>
          @endif
        </div>
      </div>

    </div>
  </main>
</div>

<script>
  function filterApproved() {
    const q    = document.getElementById('approved-search').value.toLowerCase();
    const ff   = document.getElementById('approved-filter-fund').value.toLowerCase();
    const rows = document.querySelectorAll('#approved-body tr[data-search]');
    let visible = 0;
    rows.forEach(row => {
      const show =
        (!q  || row.dataset.search.includes(q)) &&
        (!ff || row.dataset.fund.toLowerCase() === ff);
      row.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    document.getElementById('approved-record-count').textContent = visible + (visible === 1 ? ' record' : ' records');
    document.getElementById('approved-footer-info').innerHTML = 'Showing <strong>' + visible + '</strong> approved records';
  }
</script>

</body>
</html>