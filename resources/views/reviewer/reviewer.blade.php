<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reviewer — DAR Cashier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <style>
    /* ════════════════════════════════════════
       CSS VARIABLES & RESET
    ════════════════════════════════════════ */
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

    /* ════════════════════════════════════════
       TOP STRIPE & HEADER
    ════════════════════════════════════════ */
    .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

    .page-header {
      background: var(--green-deep); padding: 14px 28px;
      display: flex; align-items: center; gap: 14px;
      position: sticky; top: 0; z-index: 300;
      height: 62px;
    }
    .header-seal { width: 36px; height: 36px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .header-text .t1 { font-size: .56rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .83rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 28px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 700; color: var(--gold-light); }
    .reviewer-badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 4px 11px; border-radius: 20px;
      background: rgba(201,153,42,.18); border: 1px solid rgba(201,153,42,.35);
      color: var(--gold-light); font-size: .66rem; font-weight: 700;
      letter-spacing: 1.2px; text-transform: uppercase;
    }
    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }
    .btn-logout {
      background: none; border: none; color: var(--cream); font-size: .78rem;
      cursor: pointer; padding: 7px 13px; display: flex; align-items: center; gap: 6px;
      border-radius: 8px; font-family: 'DM Sans', sans-serif; font-weight: 500;
      letter-spacing: .4px; transition: background .15s; opacity: .75;
    }
    .btn-logout:hover { background: rgba(255,255,255,.1); opacity: 1; }

    /* ════════════════════════════════════════
       FULL-HEIGHT LAYOUT: SIDEBAR + MAIN
    ════════════════════════════════════════ */
    .app-layout {
      display: flex;
      min-height: calc(100vh - 66px); /* header height + stripe */
    }

    /* ── SIDEBAR ── */
    .app-sidebar {
      width: 260px;
      flex-shrink: 0;
      background: var(--green-deep);
      border-right: 1px solid rgba(255,255,255,.07);
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 66px;
      height: calc(100vh - 66px);
      overflow-y: auto;
      z-index: 200;
    }
    .app-sidebar::-webkit-scrollbar { width: 3px; }
    .app-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }

    .sidebar-inner { display: flex; flex-direction: column; height: 100%; padding: 20px 0 0; }

    /* Nav links */
    .sidebar-nav { display: flex; flex-direction: column; gap: 2px; padding: 0 10px; }
    .app-nav-link {
      display: flex; align-items: center; gap: 10px; padding: 10px 13px;
      color: rgba(245,240,232,.75); text-decoration: none; border-radius: 9px;
      font-size: .82rem; font-weight: 500; transition: background .15s, color .15s;
      border-left: 3px solid transparent;
    }
    .app-nav-link .nav-icon { width: 30px; text-align: center; color: var(--gold); font-size: .95rem; flex-shrink: 0; }
    .app-nav-link:hover { background: rgba(255,255,255,.04); color: var(--cream); }
    .app-nav-link.active { background: rgba(45,122,79,.15); border-left-color: var(--gold); color: var(--cream); font-weight: 600; }

    /* Fund panel inside sidebar */
    .fund-panel { padding: 10px 10px 0; }
    .fund-panel-title { font-size: .63rem; color: rgba(255,255,255,.45); font-weight: 700; letter-spacing: 1.8px; text-transform: uppercase; margin-bottom: 10px; padding-left: 4px; }

    .fund-list { display: flex; flex-direction: column; gap: 2px; }
    .fund-item {
      display: flex; align-items: center; gap: 10px; padding: 9px 12px;
      border-radius: 8px; cursor: pointer; border-left: 3px solid transparent;
      transition: background .15s;
    }
    .fund-item:hover { background: rgba(255,255,255,.04); }
    .fund-item.active { background: rgba(45,122,79,.18); border-left-color: var(--gold); }
    .fund-dot {
      width: 32px; height: 32px; border-radius: 8px;
      background: rgba(255,255,255,.07); color: rgba(245,240,232,.6);
      display: flex; align-items: center; justify-content: center;
      font-size: .66rem; font-weight: 700; flex-shrink: 0;
      transition: background .15s, color .15s;
    }
    .fund-item.active .fund-dot { background: var(--gold); color: var(--green-deep); }
    .fund-name { font-size: .78rem; font-weight: 600; color: rgba(245,240,232,.8); }
    .fund-item.active .fund-name { color: var(--cream); }
    .fund-check { margin-left: auto; color: var(--gold); font-size: .82rem; opacity: 0; transition: opacity .15s; }
    .fund-item.active .fund-check { opacity: 1; }

    /* Selected fund + proceed */
    .sidebar-proceed-wrap { padding: 14px 10px; border-top: 1px solid rgba(255,255,255,.07); margin-top: 12px; }
    .sidebar-proceed-label { font-size: .6rem; color: rgba(255,255,255,.35); text-transform: uppercase; letter-spacing: 1.4px; margin-bottom: 3px; }
    .sidebar-proceed-value { font-size: .78rem; font-weight: 700; color: var(--gold-light); margin-bottom: 9px; min-height: 16px; }
    .sidebar-proceed-btn {
      width: 100%; padding: 9px 14px; background: var(--gold); border: none; border-radius: 8px;
      color: var(--green-deep); font-family: 'DM Sans', sans-serif; font-weight: 700;
      font-size: .72rem; letter-spacing: 1.4px; text-transform: uppercase; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 6px;
      transition: background .15s, transform .12s; opacity: .35; pointer-events: none;
    }
    .sidebar-proceed-btn.enabled { opacity: 1; pointer-events: all; }
    .sidebar-proceed-btn.enabled:hover { background: var(--gold-light); transform: translateY(-1px); }

    /* Sidebar footer logout */
    .sidebar-footer { margin-top: auto; padding: 14px 10px; border-top: 1px solid rgba(255,255,255,.06); }
    .sidebar-footer .btn-logout {
      width: 100%; background: rgba(255,255,255,.05); color: rgba(245,240,232,.6);
      border-radius: 8px; padding: 9px 14px; border: 1px solid rgba(255,255,255,.08); opacity: 1;
      justify-content: center;
    }
    .sidebar-footer .btn-logout:hover { background: rgba(255,255,255,.1); color: var(--cream); }

    /* Mobile toggle */
    .sidebar-toggle { display: none; }

    /* ── MAIN AREA ── */
    .app-main { flex: 1; min-width: 0; display: flex; flex-direction: column; }

    /* ════════════════════════════════════════
       REVIEW TRANSACTIONS VIEW
    ════════════════════════════════════════ */
    .page-body { max-width: 1500px; margin: 0 auto; padding: 32px 28px 60px; width: 100%; }

    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.65rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

    .reviewer-notice {
      display: flex; align-items: flex-start; gap: 12px;
      padding: 13px 17px; border-radius: 11px; margin-bottom: 20px;
      background: #fdf3dc; border: 1px solid rgba(201,153,42,.3); color: #7a5a0a;
      font-size: .82rem; line-height: 1.5;
    }
    .reviewer-notice i { font-size: 1.05rem; margin-top: 2px; flex-shrink: 0; }
    .reviewer-notice strong { font-weight: 700; display: block; margin-bottom: 2px; }

    /* Stat cards */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 13px; margin-bottom: 22px; }
    .stat-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 15px 17px; display: flex; align-items: center; gap: 13px; }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.05rem; flex-shrink: 0; }
    .si-green { background: var(--green-light); color: var(--green-accent); }
    .si-gold  { background: #fdf3dc; color: var(--gold); }
    .si-amber { background: #fff7ed; color: #c2640a; }
    .stat-value { font-size: 1.3rem; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
    .stat-label { font-size: .68rem; color: var(--muted); font-weight: 400; margin-top: 2px; }

    /* Toolbar */
    .toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; }
    .search-wrap { position: relative; flex: 1; min-width: 200px; }
    .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .86rem; pointer-events: none; }
    .search-wrap input { width: 100%; padding: 9px 12px 9px 33px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .84rem; color: var(--text-dark); background: var(--surface); outline: none; transition: border-color .2s, box-shadow .2s; }
    .search-wrap input:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); }
    .filter-select { padding: 9px 32px 9px 12px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .81rem; color: var(--text-dark); background: var(--surface); outline: none; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238a9e90' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; cursor: pointer; transition: border-color .2s; }
    .filter-select:focus { border-color: var(--green-accent); }

    /* Table */
    .table-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; }
    .table-card-header { padding: 13px 20px; background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .table-card-title { font-family: 'Cormorant Garamond', serif; font-size: .98rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 9px; }
    .table-record-count { font-size: .67rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; background: rgba(201,153,42,.2); color: var(--gold-light); border: 1px solid rgba(201,153,42,.25); }

    .payments-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    .payments-table col.col-payor  { width: 16%; }
    .payments-table col.col-amount { width: 9%; }
    .payments-table col.col-txn    { width: 16%; }
    .payments-table col.col-fund   { width: 7%; }
    .payments-table col.col-op     { width: 12%; }
    .payments-table col.col-date   { width: 10%; }
    .payments-table col.col-status { width: 11%; }
    .payments-table col.col-act    { width: 19%; }
    .payments-table thead tr { background: #faf8f4; border-bottom: 1.5px solid var(--border); }
    .payments-table thead th { padding: 11px 13px; font-size: .67rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--text-mid); white-space: nowrap; overflow: hidden; }
    .payments-table thead th:first-child { padding-left: 18px; }
    .payments-table thead th:last-child  { padding-right: 18px; }
    .payments-table tbody tr { border-bottom: 1px solid var(--border); transition: background .13s; cursor: pointer; }
    .payments-table tbody tr:last-child { border-bottom: none; }
    .payments-table tbody tr:hover { background: #f9f7f2; }
    .payments-table tbody td { padding: 11px 13px; font-size: .83rem; color: var(--text-dark); vertical-align: middle; }
    .payments-table tbody td:first-child { padding-left: 18px; }
    .payments-table tbody td:last-child  { padding-right: 18px; }

    .payor-cell { display: flex; align-items: center; gap: 9px; }
    .payor-avatar { width: 30px; height: 30px; border-radius: 50%; background: var(--green-mid); color: #fff; font-size: .72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .payor-name { font-weight: 600; font-size: .84rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .payor-contact { font-size: .69rem; color: var(--muted); margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .amount-cell { font-weight: 700; font-size: .9rem; color: var(--green-mid); white-space: nowrap; }
    .txn-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 9px; border-radius: 20px; background: #f0f4f2; color: var(--text-mid); font-size: .7rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; }
    .fund-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; background: #fdf3dc; color: var(--gold); font-size: .66rem; font-weight: 700; white-space: nowrap; }
    .op-number { font-size: .76rem; color: var(--text-mid); font-weight: 500; word-break: break-all; }
    .date-cell .date-main { font-size: .8rem; font-weight: 500; }
    .date-cell .date-time { font-size: .68rem; color: var(--muted); margin-top: 2px; }
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: .67rem; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; white-space: nowrap; }
    .sb-approved { background: var(--green-light); color: var(--green-accent); }
    .sb-waiting  { background: #fdf3dc; color: #a0700a; }
    .sb-rejected { background: #fdf0ef; color: var(--red); }
    .sb-default  { background: #f0f4f2; color: var(--muted); }

    .actions-cell { display: flex; align-items: center; gap: 5px; flex-wrap: nowrap; }
    .actions-cell form { display: inline-flex; flex-shrink: 0; }
    .action-btn { width: 29px; height: 29px; border-radius: 7px; border: 1.5px solid var(--border); background: #faf8f4; color: var(--text-mid); display: inline-flex; align-items: center; justify-content: center; font-size: .83rem; cursor: pointer; transition: background .15s, border-color .15s, color .15s; text-decoration: none; flex-shrink: 0; }
    .action-btn:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }
    .btn-row-approve { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border: none; border-radius: 7px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .71rem; font-weight: 700; cursor: pointer; transition: background .15s; white-space: nowrap; flex-shrink: 0; }
    .btn-row-approve:hover { background: var(--green-mid); }
    .btn-row-reject  { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border: 1.5px solid #e8c5c5; border-radius: 7px; background: #fdf0ef; color: var(--red); font-family: 'DM Sans', sans-serif; font-size: .71rem; font-weight: 700; cursor: pointer; transition: background .15s; white-space: nowrap; flex-shrink: 0; }
    .btn-row-reject:hover { background: #fde0de; }
    .btn-row-modify  { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border: 1.5px solid #b8d0e8; border-radius: 7px; background: var(--blue-light); color: var(--blue); font-family: 'DM Sans', sans-serif; font-size: .71rem; font-weight: 700; cursor: pointer; transition: background .15s; white-space: nowrap; flex-shrink: 0; }
    .btn-row-modify:hover { background: #d0e4f5; }

    .empty-row td { padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 2.4rem; color: var(--border); margin-bottom: 12px; }
    .empty-text { font-size: .84rem; color: var(--muted); }

    .table-footer { padding: 12px 20px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .table-footer-info { font-size: .74rem; color: var(--muted); }
    .pagination-wrap { display: flex; align-items: center; gap: 6px; margin-left: auto; }
    .page-link, .page-number { padding: 6px 10px; border-radius: 8px; text-decoration: none; font-weight: 700; color: var(--green-accent); border: 1px solid transparent; background: transparent; }
    .page-link.disabled { opacity: .5; pointer-events: none; color: var(--muted); }
    .page-number { color: var(--text-dark); border: 1px solid transparent; }
    .page-number:hover { background: #f2faf5; border-color: var(--border); }
    .page-number.active { background: var(--gold); color: var(--green-deep); border-color: var(--gold); }

    /* Alert bars */
    .alert-bar { display: flex; align-items: center; gap: 10px; padding: 11px 17px; border-radius: 10px; margin-bottom: 18px; font-size: .83rem; font-weight: 500; }
    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }
    .alert-danger   { background: #fdf0ef; color: var(--red); border: 1px solid rgba(160,37,28,.2); }

    /* ════════════════════════════════════════
       NEW TRANSACTION — MAKER FORM STYLES
       (full port from maker.blade.php)
    ════════════════════════════════════════ */
    .new-txn-wrap {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* Sticky fund banner */
    .fund-banner-sticky-wrap {
      display: none; position: sticky; top: 66px; z-index: 150;
      width: 100%; background: var(--green-deep);
      border-bottom: 1px solid rgba(255,255,255,.08); padding: 9px 32px;
    }
    .fund-banner-sticky-wrap.show { display: block; }
    .fund-banner { display: flex; align-items: center; gap: 12px; max-width: 660px; margin: 0 auto; }
    .fund-banner-icon { width: 34px; height: 34px; border-radius: 8px; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: .78rem; font-weight: 700; color: var(--green-deep); flex-shrink: 0; }
    .fund-banner-info { flex: 1; }
    .fund-banner-label { font-size: .57rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.4); margin-bottom: 1px; }
    .fund-banner-name { font-family: 'Cormorant Garamond', serif; font-size: .95rem; font-weight: 700; color: var(--gold-light); }
    .fund-banner-change { font-size: .71rem; color: rgba(245,240,232,.4); cursor: pointer; display: flex; align-items: center; gap: 4px; transition: color .15s; background: none; border: none; font-family: 'DM Sans', sans-serif; }
    .fund-banner-change:hover { color: var(--cream); }

    /* Main content area for form */
    .maker-main { flex: 1; padding: 0 36px 60px; display: flex; flex-direction: column; align-items: center; }
    .maker-inner { width: 100%; max-width: 660px; padding-top: 34px; }

    /* Gate */
    .fund-gate { text-align: center; padding: 80px 20px; }
    .fund-gate-icon { font-size: 2.8rem; color: var(--border); margin-bottom: 14px; }
    .fund-gate-title { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-weight: 700; color: var(--text-mid); margin-bottom: 8px; }
    .fund-gate-sub { font-size: .82rem; color: var(--muted); font-weight: 300; max-width: 320px; margin: 0 auto; line-height: 1.6; }

    /* Page title / sub in form area */
    .maker-page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
    .maker-page-sub   { font-size: .82rem; color: var(--muted); font-weight: 300; margin-bottom: 24px; }

    /* Step indicator */
    .step-indicator { display: flex; align-items: center; margin-bottom: 22px; }
    .step-ind-item  { display: flex; align-items: center; gap: 8px; }
    .step-ind-num   { width: 24px; height: 24px; border-radius: 50%; font-size: .69rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .step-ind-item.done     .step-ind-num { background: var(--green-accent); color: #fff; }
    .step-ind-item.active   .step-ind-num { background: var(--green-mid); color: #fff; }
    .step-ind-item.inactive .step-ind-num { background: var(--border); color: var(--muted); }
    .step-ind-text { font-size: .69rem; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; }
    .step-ind-item.done     .step-ind-text { color: var(--green-accent); }
    .step-ind-item.active   .step-ind-text { color: var(--text-mid); }
    .step-ind-item.inactive .step-ind-text { color: var(--muted); }
    .step-ind-line { flex: 1; height: 1px; background: var(--border); margin: 0 10px; max-width: 36px; }

    /* Select card */
    .select-card  { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; padding: 24px; }
    .step-label   { display: flex; align-items: center; gap: 10px; margin-bottom: 13px; }
    .step-num     { width: 26px; height: 26px; border-radius: 50%; background: var(--green-mid); color: #fff; font-size: .7rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .step-text    { font-size: .7rem; font-weight: 600; letter-spacing: 1.4px; text-transform: uppercase; color: var(--text-mid); }
    .select-wrap  { position: relative; }
    .select-wrap select { width: 100%; padding: 12px 44px 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-family: 'DM Sans', sans-serif; font-size: .91rem; color: var(--text-dark); background: #faf8f4; outline: none; appearance: none; cursor: pointer; transition: border-color .2s, box-shadow .2s; }
    .select-wrap select:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); background: #fff; }
    .select-wrap::after { content: '\F282'; font-family: 'bootstrap-icons'; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; font-size: .95rem; }

    /* Form card */
    .form-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; margin-top: 18px; max-height: 0; opacity: 0; pointer-events: none; transition: max-height .5s cubic-bezier(.16,1,.3,1), opacity .35s ease; }
    .form-card.visible { max-height: 5000px; opacity: 1; pointer-events: all; }
    .form-header { padding: 16px 24px; background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); display: flex; align-items: center; gap: 12px; }
    .form-header-seal { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,.1); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
    .form-header-info .org      { font-size: .57rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.4); font-weight: 300; }
    .form-header-info .txn-name { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); }
    .required-note  { padding: 8px 24px; font-size: .72rem; color: var(--red); background: #fff9f8; border-bottom: 1px solid #f5e0de; display: flex; align-items: center; gap: 5px; }
    .form-body      { padding: 24px; }
    .section-heading { display: flex; align-items: center; gap: 8px; font-size: .67rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--text-mid); margin-bottom: 17px; }
    .section-heading i { color: var(--green-accent); }

    /* Fields */
    .field { margin-bottom: 14px; }
    .field label { display: flex; align-items: center; gap: 4px; font-size: .8rem; font-weight: 500; color: var(--text-mid); margin-bottom: 5px; }
    .req { color: var(--red); font-size: .83rem; line-height: 1; }
    .field input, .field select, .field textarea { width: 100%; padding: 9px 13px; border: 1.5px solid var(--border); border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: .87rem; color: var(--text-dark); background: #faf8f4; outline: none; transition: border-color .2s, box-shadow .2s, background .2s; appearance: none; }
    .field textarea { resize: vertical; min-height: 70px; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); background: #fff; }
    .field input::placeholder, .field textarea::placeholder { color: #b5c4ba; }
    .field.invalid input, .field.invalid select, .field.invalid textarea { border-color: var(--red); background: #fff6f6; }
    .field .error-msg { display: none; font-size: .74rem; color: var(--red); margin-top: 5px; }
    .field.invalid .error-msg { display: block; }
    .amount-wrap { position: relative; }
    .amount-wrap > span { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: .85rem; color: var(--muted); font-weight: 500; pointer-events: none; }
    .amount-wrap input { padding-left: 28px; }
    .sel-wrap { position: relative; }
    .sel-wrap::after { content: '\F282'; font-family: 'bootstrap-icons'; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .sel-wrap select { padding-right: 34px; }

    /* Extra fields per transaction type */
    .extra-fields { display: none; }
    .extra-fields.show { display: block; }
    .extra-divider { border: none; border-top: 1px solid var(--green-light); margin: 4px 0 13px; }
    .extra-label { font-size: .65rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--green-accent); margin-bottom: 12px; }

    /* Checkboxes */
    .check-group { display: flex; flex-direction: column; gap: 8px; }
    .check-item {
      display: flex; align-items: center; gap: 9px; font-size: .84rem; color: var(--text-mid);
      cursor: pointer; padding: 8px 12px 8px 44px; border: 1.5px solid var(--border);
      border-radius: 8px; background: #faf8f4; transition: border-color .2s, background .2s;
      position: relative;
    }
    .check-item:hover { border-color: var(--green-accent); background: #fff; }
    .check-item input[type="checkbox"] { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; opacity: 0; margin: 0; cursor: pointer; }
    .check-item::before { content: ''; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 6px; border: 2px solid var(--border); background: #faf8f4; }
    .check-item::after  { content: ''; position: absolute; left: 17px; top: 50%; transform: translateY(-56%) rotate(45deg); width: 6px; height: 10px; border: solid white; border-width: 0 2px 2px 0; opacity: 0; }
    .check-item.checked { border-color: var(--green-accent); background: var(--green-light); }
    .check-item.checked::before { background: var(--green-accent); border-color: var(--green-accent); }
    .check-item.checked::after  { opacity: 1; }

    .remit-check-group { display: flex; flex-direction: column; gap: 8px; }
    .remit-check-item {
      display: flex; align-items: flex-start; gap: 9px; font-size: .84rem; color: var(--text-mid);
      cursor: pointer; padding: 8px 12px 8px 44px; border: 1.5px solid var(--border);
      border-radius: 8px; background: #faf8f4; transition: border-color .2s, background .2s;
      position: relative;
    }
    .remit-check-item:hover { border-color: var(--green-accent); background: #fff; }
    .remit-check-item input[type="checkbox"] { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; opacity: 0; margin: 0; cursor: pointer; }
    .remit-check-item::before { content: ''; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 6px; border: 2px solid var(--border); background: #faf8f4; }
    .remit-check-item::after  { content: ''; position: absolute; left: 17px; top: 50%; transform: translateY(-56%) rotate(45deg); width: 6px; height: 10px; border: solid white; border-width: 0 2px 2px 0; opacity: 0; }
    .remit-check-item.checked { border-color: var(--green-accent); background: var(--green-light); }
    .remit-check-item.checked::before { background: var(--green-accent); border-color: var(--green-accent); }
    .remit-check-item.checked::after  { opacity: 1; }
    .remit-open-field { display: none; margin-top: 6px; }
    .remit-open-field.show { display: block; }

    .form-divider { border: none; border-top: 1px dashed var(--border); margin: 20px 0; }
    .terms-block { background: #faf8f4; border: 1px solid var(--border); border-radius: 8px; padding: 13px 15px; margin-bottom: 13px; }
    .terms-block label { display: flex; align-items: flex-start; gap: 10px; font-size: .81rem; color: var(--text-mid); cursor: pointer; line-height: 1.55; }
    .terms-block input[type="checkbox"] { accent-color: var(--green-accent); width: 15px; height: 15px; flex-shrink: 0; margin-top: 2px; cursor: pointer; }
    .terms-block a { color: var(--green-accent); text-decoration: underline; }
    .review-note { font-size: .76rem; color: var(--red); margin-bottom: 14px; display: flex; align-items: center; gap: 6px; }
    .btn-submit { width: 100%; padding: 13px; background: var(--green-mid); border: none; border-radius: 9px; color: #fff; font-family: 'DM Sans', sans-serif; font-weight: 600; font-size: .87rem; letter-spacing: 2px; text-transform: uppercase; cursor: pointer; position: relative; overflow: hidden; transition: background .15s, transform .12s, box-shadow .15s; box-shadow: 0 5px 20px rgba(26,74,46,.3); }
    .btn-submit:hover:not(:disabled) { background: var(--green-accent); transform: translateY(-2px); }
    .btn-submit:disabled { opacity: .45; cursor: not-allowed; }

    /* ════════════════════════════════════════
       DRAWER
    ════════════════════════════════════════ */
    .drawer-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 500; }
    .drawer-overlay.open { display: block; }
    .detail-drawer { position: fixed; top: 0; right: 0; width: 440px; max-width: 100vw; height: 100vh; background: var(--surface); box-shadow: -8px 0 40px rgba(0,0,0,.18); display: flex; flex-direction: column; transform: translateX(100%); transition: transform .28s cubic-bezier(.16,1,.3,1); z-index: 501; }
    .detail-drawer.open { transform: translateX(0); }
    .drawer-head { padding: 14px 17px; background: var(--green-deep); display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-shrink: 0; }
    .drawer-head-left { flex: 1; min-width: 0; }
    .drawer-head-title { font-family: 'Cormorant Garamond', serif; font-size: 1.02rem; font-weight: 700; color: var(--gold-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .drawer-head-sub { font-size: .57rem; letter-spacing: 1.4px; text-transform: uppercase; color: rgba(245,240,232,.35); margin-top: 2px; }
    .drawer-head-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
    .drawer-print-btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: var(--gold); border: none; border-radius: 7px; color: var(--green-deep); font-family: 'DM Sans', sans-serif; font-size: .69rem; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; cursor: pointer; transition: background .15s; }
    .drawer-print-btn:hover { background: var(--gold-light); }
    .drawer-close { width: 29px; height: 29px; border-radius: 7px; background: rgba(255,255,255,.08); border: none; color: rgba(245,240,232,.55); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: .92rem; transition: background .15s, color .15s; }
    .drawer-close:hover { background: rgba(255,255,255,.15); color: var(--cream); }
    .drawer-body { flex: 1; overflow-y: auto; padding: 20px; }
    .drawer-body::-webkit-scrollbar { width: 4px; }
    .drawer-body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    .drawer-section-title { font-size: .64rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); margin-bottom: 11px; display: flex; align-items: center; gap: 7px; }
    .drawer-section-title i { color: var(--green-accent); }
    .drawer-field { margin-bottom: 13px; }
    .drawer-field-label { font-size: .68rem; font-weight: 600; color: var(--muted); letter-spacing: .4px; text-transform: uppercase; margin-bottom: 3px; }
    .drawer-field-value { font-size: .87rem; color: var(--text-dark); font-weight: 500; line-height: 1.45; word-break: break-word; }
    .drawer-divider { border: none; border-top: 1px dashed var(--border); margin: 16px 0; }
    .drawer-actions { display: flex; align-items: center; gap: 8px; margin-bottom: 18px; flex-wrap: wrap; }
    .drawer-action-approve { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 14px; border: none; border-radius: 9px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .77rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .drawer-action-approve:hover { background: var(--green-mid); }
    .drawer-action-reject { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 14px; border: 1.5px solid #e8c5c5; border-radius: 9px; background: #fdf0ef; color: var(--red); font-family: 'DM Sans', sans-serif; font-size: .77rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .drawer-action-reject:hover { background: #fde0de; }
    .drawer-action-modify { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 14px; border: 1.5px solid #b8d0e8; border-radius: 9px; background: var(--blue-light); color: var(--blue); font-family: 'DM Sans', sans-serif; font-size: .77rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .drawer-action-modify:hover { background: #d0e4f5; }

    /* ════════════════════════════════════════
       MODIFY MODAL
    ════════════════════════════════════════ */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(14,42,26,.55); backdrop-filter: blur(3px); z-index: 999; align-items: center; justify-content: center; padding: 20px; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: var(--surface); border-radius: 16px; width: 100%; max-width: 680px; box-shadow: 0 20px 60px rgba(14,42,26,.22); overflow: hidden; animation: modalIn .2s ease; }
    @keyframes modalIn { from { opacity: 0; transform: translateY(16px) scale(.97); } to { opacity: 1; transform: none; } }
    .modal-header { background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); padding: 17px 22px; display: flex; align-items: center; justify-content: space-between; }
    .modal-title  { font-family: 'Cormorant Garamond', serif; font-size: 1.08rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 9px; }
    .modal-close  { background: none; border: none; color: rgba(245,240,232,.5); font-size: 1.15rem; cursor: pointer; transition: color .15s; display: flex; align-items: center; padding: 4px; border-radius: 6px; }
    .modal-close:hover { color: var(--cream); background: rgba(255,255,255,.08); }
    .modal-body   { padding: 22px; max-height: 70vh; overflow-y: auto; }
    .modal-reviewer-note { display: flex; align-items: flex-start; gap: 9px; padding: 10px 13px; border-radius: 8px; margin-bottom: 16px; background: var(--blue-light); color: var(--blue); border: 1px solid rgba(26,74,122,.2); font-size: .77rem; line-height: 1.5; }
    .modal-reviewer-note i { font-size: .88rem; margin-top: 1px; flex-shrink: 0; }
    .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .modal-field { display: flex; flex-direction: column; gap: 5px; }
    .modal-field.full { grid-column: 1 / -1; }
    .modal-field label { font-size: .67rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-mid); }
    .modal-field input, .modal-field select, .modal-field textarea { padding: 9px 12px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .87rem; color: var(--text-dark); background: var(--bg); outline: none; transition: border-color .2s, box-shadow .2s; }
    .modal-field textarea { resize: vertical; min-height: 68px; }
    .modal-field input:focus, .modal-field select:focus, .modal-field textarea:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); background: #fff; }
    .modal-field select { appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238a9e90' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 32px; background-color: var(--bg); }
    .field-remark-wrap textarea { border-color: #b8d0e8; background: var(--blue-light); }
    .field-remark-wrap textarea:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(26,74,122,.1); }
    .remark-label-tag { display: inline-flex; align-items: center; gap: 4px; font-size: .59rem; font-weight: 700; padding: 2px 7px; border-radius: 10px; background: var(--blue); color: #fff; letter-spacing: .6px; text-transform: uppercase; margin-top: -2px; }
    .modal-footer { padding: 15px 22px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }
    .btn-modal-cancel { padding: 9px 17px; border: 1.5px solid var(--border); border-radius: 9px; background: var(--surface); color: var(--text-mid); font-family: 'DM Sans', sans-serif; font-size: .81rem; font-weight: 600; cursor: pointer; transition: background .15s; }
    .btn-modal-cancel:hover { background: var(--bg); }
    .btn-modal-save { padding: 9px 19px; border: none; border-radius: 9px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .81rem; font-weight: 700; cursor: pointer; transition: background .15s; display: flex; align-items: center; gap: 6px; }
    .btn-modal-save:hover { background: var(--green-mid); }

    /* Mod-extra blocks inside modal */
    .mod-extra { display: none; }

    /* ════════════════════════════════════════
       RESPONSIVE
    ════════════════════════════════════════ */
    @media (max-width: 960px) {
      .app-sidebar { width: 220px; }
      .maker-main  { padding: 0 20px 48px; }
    }
    @media (max-width: 768px) {
      .app-layout { flex-direction: column; }
      .app-sidebar { width: 100%; height: auto; position: static; flex-direction: row; overflow-x: auto; border-right: none; border-bottom: 1px solid rgba(255,255,255,.07); }
      .sidebar-inner { flex-direction: row; padding: 0; }
      .sidebar-nav { flex-direction: row; padding: 10px 12px; gap: 6px; overflow-x: auto; }
      .fund-panel, .sidebar-proceed-wrap, .sidebar-footer { display: none; }
      .sidebar-toggle { display: inline-flex; }
      .page-body, .maker-main { padding: 18px 14px 48px; }
      .stat-row { grid-template-columns: repeat(2, 1fr); }
      .detail-drawer { width: 100vw; }
      .modal-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 520px) {
      .stat-row { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>

<div class="top-stripe"></div>

<!-- ══════════════ HEADER ══════════════ -->
<header class="page-header">
  <div class="header-seal">🌾</div>
  <div class="header-text">
    <div class="t1">Republic of the Philippines</div>
    <div class="t2">Department of Agrarian Reform</div>
  </div>
  <div class="header-sep"></div>
  <div class="header-page">Reviewer</div>
  <div class="reviewer-badge" style="margin-left:10px;">
    <i class="bi bi-shield-check"></i> Reviewer Access
  </div>
  <div class="header-actions">
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
      @csrf
      <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </form>
  </div>
</header>

<!-- ══════════════ APP LAYOUT ══════════════ -->
<div class="app-layout">

  <!-- ══ SIDEBAR ══ -->
  <aside class="app-sidebar" id="app-sidebar">
    <div class="sidebar-inner">

      <nav class="sidebar-nav">
        {{-- Review Transactions --}}
        <a href="{{ route('reviewer') }}"
           class="app-nav-link {{ request()->routeIs('reviewer') && !($openFunds ?? false) ? 'active' : '' }}">
          <span class="nav-icon"><i class="bi bi-journal-text"></i></span>
          <span class="nav-label">Review Transactions</span>
        </a>

        {{-- New Transaction toggle --}}
        <a href="{{ route('reviewer', ['open_funds' => 1]) }}"
           class="app-nav-link {{ ($openFunds ?? false) ? 'active' : '' }}">
          <span class="nav-icon"><i class="bi bi-plus-circle"></i></span>
          <span class="nav-label">New Transaction</span>
        </a>
      </nav>

      {{-- Fund selector (only when New Transaction is open) --}}
      @if($openFunds ?? false)
      <div class="fund-panel">
        <div class="fund-panel-title">Select a Fund</div>
        <div class="fund-list">
          <div class="fund-item" data-fund="F01" onclick="selectReviewerFund(this)">
            <div class="fund-dot">F01</div>
            <div class="fund-name">Fund 01 — REGULAR</div>
            <i class="bi bi-check-circle-fill fund-check"></i>
          </div>
        </div>

        <div class="sidebar-proceed-wrap">
          <div class="sidebar-proceed-label">Selected Fund</div>
          <div class="sidebar-proceed-value" id="reviewer-selected-label">—</div>
          <button class="sidebar-proceed-btn" id="reviewer-proceed" disabled>
            <i class="bi bi-arrow-right"></i> Proceed
          </button>
        </div>
      </div>
      @endif

      <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
      </div>

    </div>
  </aside>

  <!-- ══ MAIN AREA ══ -->
  <div class="app-main">

    @if(!($openFunds ?? false))
    {{-- ════════════════════════════════════════
         REVIEW TRANSACTIONS VIEW
    ════════════════════════════════════════ --}}
    <div class="page-body">

      @if(session('success'))
        <div class="alert-bar alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert-bar alert-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
      @endif

      <div style="margin-bottom:20px;">
        <div class="page-title">Review Payment Records</div>
        <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
      </div>

      <div class="reviewer-notice">
        <i class="bi bi-info-circle-fill"></i>
        <div>
          <strong>Reviewer Mode</strong>
          You may approve, reject, or modify any payment record submitted by the Maker. All actions are logged and traceable.
        </div>
      </div>

      <!-- STAT CARDS -->
      <div class="stat-row">
        <div class="stat-card">
          <div class="stat-icon si-green"><i class="bi bi-receipt"></i></div>
          <div><div id="stat-total-count" class="stat-value">{{ $payments->total() ?? count($payments) }}</div><div class="stat-label">Total Transactions</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon si-gold"><i class="bi bi-cash-coin"></i></div>
          <div><div id="stat-total-amount" class="stat-value">₱{{ number_format($payments->sum('amount'), 2) }}</div><div class="stat-label">Total Collected</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon si-amber"><i class="bi bi-hourglass-split"></i></div>
          <div><div id="stat-awaiting-count" class="stat-value">{{ $payments->whereIn('status', ['submitted','under_review','accountant_rejected','waiting'])->count() }}</div><div class="stat-label">Awaiting Review</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon si-green"><i class="bi bi-check-circle"></i></div>
          <div><div id="stat-approved-count" class="stat-value">{{ $payments->where('status', 'approved')->count() }}</div><div class="stat-label">Approved</div></div>
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
        </select>
      </div>

      <!-- TABLE -->
      <div class="table-card">
        <div class="table-card-header">
          <div class="table-card-title"><i class="bi bi-table"></i> Transactions Log</div>
          <span class="table-record-count" id="record-count">{{ count($payments) }} record{{ count($payments) !== 1 ? 's' : '' }}</span>
        </div>
        <table class="payments-table" id="payments-table">
          <colgroup>
            <col class="col-payor">
            <col class="col-amount">
            <col class="col-txn">
            <col class="col-fund">
            <col class="col-op">
            <col class="col-date">
            <col class="col-status">
            <col class="col-act">
          </colgroup>
          <thead>
            <tr>
              <th>Payor</th><th>Amount</th><th>Transaction Type</th><th>Fund</th>
              <th>O.P. Number</th><th>Date</th><th>Status</th><th>Actions</th>
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
                $txnNames  = [
                  'appeal_fee'=>'Appeal Fee','bidding_documents'=>'Bidding Documents','cash_bond'=>'Cash Bond',
                  'certification_copy_fee'=>'Certification, Copy Fee and Reproduction Cost','consignment'=>'Consignment',
                  'execution_judgment'=>'Execution of Judgment Involving Money','filing_fee'=>'Filing Fee and Inspection Cost',
                  'income_unserviceable'=>'Income from Sale of Unserviceable Property','legal_research'=>'Legal Research',
                  'performance_bond'=>'Performance Bond','refund_cash_advances'=>'Refund of Cash Advances',
                  'refund_overpayment'=>'Refund of Overpayment','settlement_disallowances'=>'Settlement of Notice of Disallowances',
                  'unwithheld_remittances'=>'Unwithheld Remittances',
                ];
                $rawTxn    = $p->transaction_type ?? '';
                $txnLabel  = $txnNames[$rawTxn] ?? ucwords(str_replace('_',' ', $rawTxn));
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
              <tr data-id="{{ $p->id }}"
                  data-search="{{ strtolower($p->name.' '.($p->op_number??'').' '.($p->transaction_type??'')) }}"
                  data-status="{{ $status }}"
                  data-fund="{{ $p->fund_type ?? '' }}"
                  onclick="openDrawer({{ $p->id }})">
                <td>
                  <div class="payor-cell">
                    <div class="payor-avatar">{{ $initials }}</div>
                    <div style="min-width:0;">
                      <div class="payor-name">{{ $p->name }}</div>
                      <div class="payor-contact">{{ $p->email ?? ($p->contact ?? '—') }}</div>
                    </div>
                  </div>
                </td>
                <td><span class="amount-cell">₱{{ number_format($p->amount, 2) }}</span></td>
                <td><span class="txn-badge"><i class="bi bi-tag" style="flex-shrink:0;"></i> {{ $txnLabel ?: '—' }}</span></td>
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
                    <i class="bi {{ $statusIcon }}"></i> {{ ucfirst($status) }}
                  </span>
                </td>
                <td onclick="event.stopPropagation()">
                  <div class="actions-cell">
                    <a href="#" class="action-btn" title="View" onclick="openDrawer({{ $p->id }});return false;"><i class="bi bi-eye"></i></a>
                    @if($status !== 'forwarded' && $status !== 'approved')
                      <form method="POST" action="{{ route('payments.forward', $p->id) }}"
                            onsubmit="return confirm('Forward payment from {{ addslashes($p->name) }} (₱{{ number_format($p->amount,2) }}) to Accountant?')">
                        @csrf
                        <button type="submit" class="btn-row-approve"><i class="bi bi-arrow-right-circle"></i> Forward</button>
                      </form>
                    @else
                      <button class="btn-row-approve" disabled style="opacity:.5;cursor:not-allowed;"><i class="bi bi-arrow-right-circle"></i> Forward</button>
                    @endif
                    @if($status === 'forwarded' || $status === 'approved')
                      <button class="btn-row-modify" disabled style="opacity:.5;cursor:not-allowed;"><i class="bi bi-pencil"></i> Modify</button>
                    @else
                      <button class="btn-row-modify" onclick="openModifyModal({
                          id:'{{ $p->id }}',name:'{{ addslashes($p->name) }}',email:'{{ addslashes($p->email ?? '') }}',
                          contact:'{{ addslashes($p->contact ?? '') }}',address:'{{ addslashes($p->address ?? '') }}',
                          amount:'{{ $p->amount }}',transaction_type:'{{ addslashes($rawTxn) }}',
                          fund_type:'{{ addslashes($p->fund_type ?? '') }}',op_number:'{{ addslashes($p->op_number ?? '') }}',
                          payment_mode:'{{ addslashes($p->payment_mode ?? '') }}',status:'{{ $status }}'
                        })"><i class="bi bi-pencil"></i> Modify</button>
                    @endif
                  </div>
                </td>
              </tr>

              <script>
                window.__drawers = window.__drawers || {};
                window.__drawers[{{ $p->id }}] = {
                  id: {{ $p->id }}, name: @json($p->name), email: @json($p->email ?? '—'),
                  contact: @json($p->contact ?? '—'), address: @json($p->address ?? '—'),
                  amount: @json('₱'.number_format($p->amount,2)), amountRaw: @json(number_format($p->amount,2)),
                  amountNum: @json((float)$p->amount), txn: @json($txnLabel ?: '—'), rawTxn: @json($rawTxn),
                  fund: @json($fundLabel), op: @json($p->op_number ?? '—'),
                  mode: @json(ucfirst(str_replace('_',' ',$p->payment_mode ?? 'cash'))),
                  rawMode: @json($p->payment_mode ?? 'cash'), status: @json(ucfirst($status)),
                  rawStatus: @json($status), statusCls: @json($statusCls), statusIcon: @json($statusIcon),
                  date: @json($p->created_at->format('F d, Y — h:i A')), meta: @json($p->meta ?? []),
                  dateShort: @json($p->created_at->format('m/d/Y')), details: @json($details),
                  forwardUrl: @json(route('payments.forward', $p->id)),
                  modifyData: {
                    id: {{ $p->id }}, name: @json($p->name), email: @json($p->email ?? ''),
                    contact: @json($p->contact ?? ''), address: @json($p->address ?? ''),
                    amount: @json($p->amount), transaction_type: @json($rawTxn),
                    fund_type: @json($p->fund_type ?? ''), op_number: @json($p->op_number ?? ''),
                    payment_mode: @json($p->payment_mode ?? 'cash'), status: @json($status),
                    meta: @json($p->meta ?? []),
                  }
                };
              </script>
            @empty
              <tr class="empty-row">
                <td colspan="8">
                  <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                  <div class="empty-text">No payment records found.</div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="table-footer">
          <div class="table-footer-info" id="footer-info">
            Showing <strong>{{ count($payments) }}</strong> records
          </div>
          @if(method_exists($payments, 'lastPage'))
            <div class="pagination-wrap">
              @if($payments->onFirstPage())
                <span class="page-link disabled">« Prev</span>
              @else
                <a class="page-link" href="{{ $payments->previousPageUrl() }}">« Prev</a>
              @endif
              @for($i = 1; $i <= $payments->lastPage(); $i++)
                @if($i == $payments->currentPage())
                  <span class="page-number active">{{ $i }}</span>
                @else
                  <a class="page-number" href="{{ $payments->url($i) }}">{{ $i }}</a>
                @endif
              @endfor
              @if($payments->hasMorePages())
                <a class="page-link" href="{{ $payments->nextPageUrl() }}">Next »</a>
              @else
                <span class="page-link disabled">Next »</span>
              @endif
            </div>
          @endif
        </div>
      </div>
    </div>{{-- /page-body --}}

    @else
    {{-- ════════════════════════════════════════
         NEW TRANSACTION VIEW (Maker form embedded)
    ════════════════════════════════════════ --}}
    <div class="new-txn-wrap">

      {{-- Sticky fund banner --}}
      <div class="fund-banner-sticky-wrap" id="fund-banner-wrap">
        <div class="fund-banner">
          <div class="fund-banner-icon" id="fund-banner-dot">—</div>
          <div class="fund-banner-info">
            <div class="fund-banner-label">Processing Under</div>
            <div class="fund-banner-name" id="fund-banner-name">—</div>
          </div>
          <button class="fund-banner-change" onclick="changeFund()"><i class="bi bi-pencil"></i> Change</button>
        </div>
      </div>

      <div class="maker-main">
        <div class="maker-inner">

          {{-- Gate --}}
          <div id="section-gate">
            <div class="fund-gate">
              <div class="fund-gate-icon"><i class="bi bi-bank2"></i></div>
              <div class="fund-gate-title">Select a Fund First</div>
              <div class="fund-gate-sub">Choose the appropriate fund from the sidebar on the left, then click <strong>Proceed</strong> to begin processing a payment.</div>
            </div>
          </div>

          {{-- Form --}}
          <div id="section-form" style="display:none;">
            <h1 class="maker-page-title">Process a Payment</h1>
            <p class="maker-page-sub">Select the transaction type, then fill in the required details.</p>

            <div class="step-indicator">
              <div class="step-ind-item done"><div class="step-ind-num"><i class="bi bi-check" style="font-size:.68rem;"></i></div><div class="step-ind-text">Fund</div></div>
              <div class="step-ind-line"></div>
              <div class="step-ind-item active"><div class="step-ind-num">2</div><div class="step-ind-text">Transaction Type</div></div>
              <div class="step-ind-line"></div>
              <div class="step-ind-item inactive"><div class="step-ind-num">3</div><div class="step-ind-text">Payment Details</div></div>
            </div>

            <div class="select-card">
              <div class="step-label"><div class="step-num">2</div><div class="step-text">Select Transaction Type</div></div>
              <div class="select-wrap">
                <select id="txn-select">
                  <option value="" disabled selected>Please select transaction type</option>
                  <option value="appeal_fee">Appeal Fee</option>
                  <option value="bidding_documents">Bidding Documents</option>
                  <option value="cash_bond">Cash Bond</option>
                  <option value="certification_copy_fee">Certification, Copy Fee and Reproduction Cost</option>
                  <option value="consignment">Consignment</option>
                  <option value="execution_judgment">Execution of Judgment Involving Money</option>
                  <option value="filing_fee">Filing Fee and Inspection Cost</option>
                  <option value="income_unserviceable">Income from Sale of Unserviceable Property</option>
                  <option value="legal_research">Legal Research</option>
                  <option value="performance_bond">Performance Bond</option>
                  <option value="refund_cash_advances">Refund of Cash Advances</option>
                  <option value="refund_overpayment">Refund of Overpayment</option>
                  <option value="settlement_disallowances">Settlement of Notice of Disallowances</option>
                  <option value="unwithheld_remittances">Unwithheld Remittances</option>
                </select>
              </div>
            </div>

            <!-- FORM CARD -->
            <div class="form-card" id="form-card">
              <div class="form-header">
                <div class="form-header-seal">🌾</div>
                <div class="form-header-info">
                  <div class="org">Department of Agrarian Reform — Regional Office V</div>
                  <div class="txn-name" id="form-txn-name">—</div>
                </div>
              </div>
              <div class="required-note"><i class="bi bi-asterisk"></i> Fields marked with * are required.</div>
              <div class="form-body">
                <form method="POST" action="{{ route('reviewer.payments.store') }}" id="payment-form" novalidate>
                  @csrf
                  <input type="hidden" name="transaction_type" id="hidden-txn-type" />
                  <input type="hidden" name="fund_type" id="hidden-fund-type" />

                  <div class="section-heading"><i class="bi bi-card-checklist"></i> Payment Details</div>

                  <div class="field">
                    <label>Amount : <span class="req">*</span></label>
                    <div class="amount-wrap"><span>₱</span><input name="amount" type="number" min="0" step="0.01" placeholder="0.00" required data-validate="numeric" /></div>
                  </div>
                  <div class="field">
                    <label>Name of Payor : <span class="req">*</span></label>
                    <input name="name" type="text" placeholder="Full name of payor" required />
                  </div>
                  <div class="field">
                    <label>Contact No. of Client : <span class="req">*</span></label>
                    <input name="contact" type="tel" placeholder="e.g. 09123456789" required data-validate="tel" />
                  </div>
                  <div class="field">
                    <label>Address : <span class="req">*</span></label>
                    <input name="address" type="text" placeholder="Barangay, Municipality, Province" required />
                  </div>
                  <div class="field">
                    <label>Email Address : <span class="req">*</span></label>
                    <input name="email" type="email" placeholder="example@gmail.com" required />
                  </div>
                  <div class="field">
                    <label>Order of Payment No. :</label>
                    <input name="op_number" type="text" placeholder="Auto-generated on save" readonly />
                    <small style="font-size:.7rem; color:var(--muted); margin-top:4px; display:block;">Format: FUND-YEAR-MONTH-SERIES (e.g. F01-2026-01-0001). Generated automatically; resets monthly & yearly.</small>
                  </div>

                  <!-- ══ EXTRA FIELDS PER TRANSACTION TYPE ══ -->
                  <div class="extra-fields" id="extra-appeal_fee">
                    <hr class="extra-divider"><div class="extra-label">Appeal Fee Details</div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="appeal_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-bidding_documents">
                    <hr class="extra-divider"><div class="extra-label">Bidding Document Details</div>
                    <div class="field"><label>Details of the Availed Bid : <span class="req">*</span></label><input name="bid_details" type="text" placeholder="e.g. Bid title, project name" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="bid_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-cash_bond">
                    <hr class="extra-divider"><div class="extra-label">Cash Bond Details</div>
                    <div class="field"><label>Total Area (hectares) : <span class="req">*</span></label><input name="area_hectares" type="number" step="0.0001" min="0" placeholder="e.g. 2.5000" data-validate="numeric" /></div>
                    <div class="field"><label>Zonal Value : <span class="req">*</span></label><div class="amount-wrap"><span>₱</span><input name="zonal_value" type="number" step="0.01" min="0" placeholder="0.00" data-validate="numeric" /></div></div>
                    <div class="field"><label>Location of Property / Landholding : <span class="req">*</span></label><input name="property_location" type="text" placeholder="e.g. Barangay, Municipality, Province" /></div>
                    <div class="field"><label>Assessment Form : <span class="req">*</span></label><input name="assessment_form" type="text" placeholder="Assessment form reference" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="cash_bond_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-certification_copy_fee">
                    <hr class="extra-divider"><div class="extra-label">Certification / Copy Fee Details</div>
                    <div class="field"><label>Letter Request : <span class="req">*</span></label><input name="letter_request" type="text" placeholder="Reference to the letter request" /></div>
                    <div class="field"><label>Type of Transaction Paid : <span class="req">*</span></label>
                      <div class="check-group">
                        <label class="check-item"><input type="checkbox" name="cert_type[]" value="certification" onchange="toggleCheckItem(this)"> Certification</label>
                        <label class="check-item"><input type="checkbox" name="cert_type[]" value="copy_fee" onchange="toggleCheckItem(this)"> Copy Fee</label>
                        <label class="check-item"><input type="checkbox" name="cert_type[]" value="reproduction_cost" onchange="toggleCheckItem(this)"> Reproduction Cost</label>
                      </div>
                    </div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="cert_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-consignment">
                    <hr class="extra-divider"><div class="extra-label">Consignment Details</div>
                    <div class="field"><label>Assessment Form No. : <span class="req">*</span></label><input name="consignment_assessment_form" type="text" placeholder="Assessment form number" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Case No. : <span class="req">*</span></label><input name="consignment_case_no" type="text" placeholder="e.g. DARAB Case No. 001-2025" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="consignment_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-execution_judgment">
                    <hr class="extra-divider"><div class="extra-label">Execution of Judgment Details</div>
                    <div class="field"><label>Assessment Form No. : <span class="req">*</span></label><input name="exec_assessment_form" type="text" placeholder="Assessment form number" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Type of Transaction Paid : <span class="req">*</span></label><input name="exec_txn_type_paid" type="text" placeholder="Brief description of transaction type" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="exec_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-filing_fee">
                    <hr class="extra-divider"><div class="extra-label">Filing Fee / Inspection Details</div>
                    <div class="field"><label>Assessment Form : <span class="req">*</span></label><input name="filing_assessment_form" type="text" placeholder="Assessment form reference" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="filing_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-income_unserviceable">
                    <hr class="extra-divider"><div class="extra-label">Unserviceable Property Details</div>
                    <div class="field"><label>RDC Resolution No. : <span class="req">*</span></label><input name="rdc_resolution_no" type="text" placeholder="e.g. RDC-2025-001" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="unserviceable_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-legal_research">
                    <hr class="extra-divider"><div class="extra-label">Legal Research Details</div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="legal_research_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-performance_bond">
                    <hr class="extra-divider"><div class="extra-label">Performance Bond Details</div>
                    <div class="field"><label>Total Area (hectares) : <span class="req">*</span></label><input name="pb_area_hectares" type="number" step="0.0001" min="0" placeholder="e.g. 2.5000" data-validate="numeric" /></div>
                    <div class="field"><label>Zonal Value : <span class="req">*</span></label><div class="amount-wrap"><span>₱</span><input name="pb_zonal_value" type="number" step="0.01" min="0" placeholder="0.00" data-validate="numeric" /></div></div>
                    <div class="field"><label>Location of Property / Landholding : <span class="req">*</span></label><input name="pb_property_location" type="text" placeholder="e.g. Barangay, Municipality, Province" /></div>
                    <div class="field"><label>Assessment Form : <span class="req">*</span></label><input name="pb_assessment_form" type="text" placeholder="Assessment form reference" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="pb_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-refund_cash_advances">
                    <hr class="extra-divider"><div class="extra-label">Refund of Cash Advances Details</div>
                    <div class="field"><label>Check / LDDAP-ADA Number : <span class="req">*</span></label><input name="check_lddap_ada" type="text" placeholder="Check or LDDAP-ADA number" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Date Cash Advance was Granted : <span class="req">*</span></label><input name="cash_advance_date" type="date" /></div>
                    <div class="field"><label>Division / Section of Payor : <span class="req">*</span></label><input name="division_section" type="text" placeholder="e.g. Finance Division" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="cash_advance_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-refund_overpayment">
                    <hr class="extra-divider"><div class="extra-label">Refund of Overpayment Details</div>
                    <div class="field"><label>Division / Section of Payor : <span class="req">*</span></label><input name="refund_division_section" type="text" placeholder="e.g. Finance Division" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="refund_op_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-settlement_disallowances">
                    <hr class="extra-divider"><div class="extra-label">Notice of Disallowance Details</div>
                    <div class="field"><label>Notice of Disallowances No. : <span class="req">*</span></label><input name="disallowance_no" type="text" placeholder="e.g. ND-2025-001" data-validate="alphanumeric" /></div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="disallowance_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>
                  <div class="extra-fields" id="extra-unwithheld_remittances">
                    <hr class="extra-divider"><div class="extra-label">Unwithheld Remittances Details</div>
                    <div class="field"><label>Type of Remittance : <span class="req">*</span></label>
                      <div class="remit-check-group">
                        <label class="remit-check-item"><input type="checkbox" name="remit_type[]" value="GSIS" onchange="toggleCheckItem(this)"> GSIS</label>
                        <label class="remit-check-item"><input type="checkbox" name="remit_type[]" value="PHIC" onchange="toggleCheckItem(this)"> PHIC — Philhealth</label>
                        <label class="remit-check-item"><input type="checkbox" name="remit_type[]" value="HDMF" onchange="toggleCheckItem(this)"> HDMF — Pag-IBIG</label>
                        <label class="remit-check-item"><input type="checkbox" name="remit_type[]" value="Other" id="remit-other-chk" onchange="toggleCheckItem(this); toggleRemitOther(this)"> Other Payables</label>
                      </div>
                      <div class="remit-open-field" id="remit-other-field">
                        <input name="remit_other_specify" type="text" placeholder="Please specify other payable…" style="margin-top:8px;" />
                      </div>
                    </div>
                    <div class="field"><label>Remarks / Comments :</label><textarea name="remit_remarks" placeholder="Enter any relevant remarks…" data-validate="text"></textarea></div>
                  </div>

                  <div class="field" style="margin-top:6px;">
                    <label>Payment Mode :</label>
                    <div class="sel-wrap"><select name="payment_mode"><option value="cash">Cash</option></select></div>
                  </div>

                  <hr class="form-divider">

                  <div class="terms-block">
                    <label>
                      <input type="checkbox" id="agree_terms" name="agree_terms" />
                      I certify that I am at least 18 years old and have read, understood and agreed to the
                      <a href="#" target="_blank">Terms and Conditions</a>.
                    </label>
                  </div>

                  <p class="review-note"><i class="bi bi-exclamation-circle-fill"></i> Please review payment details before clicking Continue.</p>

                  <button type="submit" class="btn-submit" id="submit-btn" disabled>
                    <i class="bi bi-arrow-right-circle"></i> Continue
                  </button>
                </form>
              </div>
            </div>{{-- /form-card --}}
          </div>{{-- /section-form --}}

        </div>{{-- /maker-inner --}}
      </div>{{-- /maker-main --}}
    </div>{{-- /new-txn-wrap --}}
    @endif

  </div>{{-- /app-main --}}
</div>{{-- /app-layout --}}

<!-- ══ DETAIL DRAWER ══ -->
<div class="drawer-overlay" id="drawer-overlay" onclick="closeDrawer()"></div>
<div class="detail-drawer" id="detail-drawer">
  <div class="drawer-head">
    <div class="drawer-head-left">
      <div class="drawer-head-title" id="drawer-payor-name">—</div>
      <div class="drawer-head-sub">Transaction Details · Reviewer View</div>
    </div>
    <div class="drawer-head-actions">
      <button class="drawer-print-btn" onclick="printOrderOfPayment()"><i class="bi bi-printer-fill"></i> Print O.P.</button>
      <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x-lg"></i></button>
    </div>
  </div>
  <div class="drawer-body" id="drawer-body"></div>
</div>

<!-- ══ MODIFY MODAL ══ -->
<div class="modal-overlay" id="modify-modal" onclick="handleModifyOverlayClick(event)">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-title"><i class="bi bi-pencil-square"></i> Modify Payment Record</div>
      <button type="button" class="modal-close" onclick="closeModifyModal()"><i class="bi bi-x-lg"></i></button>
    </div>
    <form method="POST" id="modify-form" action="">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="modal-reviewer-note">
          <i class="bi bi-shield-check"></i>
          You are modifying this record as a <strong>Reviewer</strong>. All field changes are permitted. Use the Remarks field to document the reason for modification.
        </div>
        <div class="modal-grid">
          <div class="modal-field full"><label>Payor Name</label><input type="text" id="mod-name" name="name" required placeholder="Full name of payor" /></div>
          <div class="modal-field"><label>Email</label><input type="email" id="mod-email" name="email" placeholder="email@example.com" /></div>
          <div class="modal-field"><label>Contact Number</label><input type="text" id="mod-contact" name="contact" placeholder="09XX XXX XXXX" /></div>
          <div class="modal-field full"><label>Address</label><textarea id="mod-address" name="address" placeholder="Office or home address"></textarea></div>
          <div class="modal-field"><label>Amount (₱)</label><input type="number" id="mod-amount" name="amount" step="0.01" min="0" required placeholder="0.00" /></div>
          <div class="modal-field"><label>O.P. Number</label><input type="text" id="mod-op" name="op_number" readonly style="background:#f0f0eb;color:var(--muted);cursor:not-allowed;" /></div>
          <div class="modal-field">
            <label>Transaction Type</label>
            <select id="mod-txn" name="transaction_type" onchange="onModifyTxnChange(this.value)">
              <option value="">— Select Type —</option>
              <option value="appeal_fee">Appeal Fee</option>
              <option value="bidding_documents">Bidding Documents</option>
              <option value="cash_bond">Cash Bond</option>
              <option value="certification_copy_fee">Certification, Copy Fee and Reproduction Cost</option>
              <option value="consignment">Consignment</option>
              <option value="execution_judgment">Execution of Judgment Involving Money</option>
              <option value="filing_fee">Filing Fee and Inspection Cost</option>
              <option value="income_unserviceable">Income from Sale of Unserviceable Property</option>
              <option value="legal_research">Legal Research</option>
              <option value="performance_bond">Performance Bond</option>
              <option value="refund_cash_advances">Refund of Cash Advances</option>
              <option value="refund_overpayment">Refund of Overpayment</option>
              <option value="settlement_disallowances">Settlement of Notice of Disallowances</option>
              <option value="unwithheld_remittances">Unwithheld Remittances</option>
            </select>
          </div>
          <div class="modal-field">
            <label>Fund Type</label>
            <select id="mod-fund" name="fund_type">
              <option value="">— Select Fund —</option>
              <option value="F01">Fund 01 — Regular</option>
            </select>
          </div>
          <div class="modal-field">
            <label>Payment Mode</label>
            <select id="mod-mode" name="payment_mode">
              <option value="cash">Cash</option>
              <option value="check">Check</option>
              <option value="online_transfer">Online Transfer</option>
              <option value="bank_deposit">Bank Deposit</option>
            </select>
          </div>
          <div class="modal-field">
            <label>Status</label>
            <select id="mod-status" name="status">
              <option value="waiting">Waiting</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
        </div>
        {{-- Reviewer Remarks --}}
        <div style="margin-top:16px;">
          <div class="modal-field full">
            <label style="display:flex;align-items:center;gap:6px;">
              Reviewer Remarks <span class="remark-label-tag"><i class="bi bi-shield-check"></i> Reviewer Only</span>
            </label>
            <div class="field-remark-wrap">
              <textarea id="mod-remarks" name="reviewer_remarks" placeholder="Document your reason for this modification…"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-modal-cancel" onclick="closeModifyModal()">Cancel</button>
        <button type="submit" class="btn-modal-save"><i class="bi bi-floppy"></i> Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- ══════════════ SCRIPTS ══════════════ -->
<script>
  /* ─── SIDEBAR: Fund Selection & Proceed ─── */
  function selectReviewerFund(el) {
    document.querySelectorAll('.fund-item').forEach(f => f.classList.remove('active'));
    el.classList.add('active');
    const label = el.querySelector('.fund-name').textContent;
    const labelEl = document.getElementById('reviewer-selected-label');
    if (labelEl) labelEl.textContent = label;
    const btn = document.getElementById('reviewer-proceed');
    if (btn) { btn.disabled = false; btn.classList.add('enabled'); btn.dataset.fund = el.dataset.fund; }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const proceedBtn = document.getElementById('reviewer-proceed');
    if (proceedBtn) {
      proceedBtn.addEventListener('click', function () {
        if (this.disabled) return;
        const fund = this.dataset.fund || '';
        window.location = '{{ route('reviewer') }}' + '?open_funds=1' + (fund ? '&fund=' + encodeURIComponent(fund) : '');
      });
    }

    /* Auto-select fund if URL has ?fund= */
    @if($openFunds ?? false)
    (function () {
      const params = new URLSearchParams(window.location.search);
      const f = params.get('fund');
      if (f) {
        const el = document.querySelector('.fund-item[data-fund="' + f + '"]');
        if (el) selectReviewerFund(el);

        /* Also initialize the sticky fund banner & form gate */
        const hf   = document.getElementById('hidden-fund-type'); if (hf)   hf.value = f;
        const dot  = document.getElementById('fund-banner-dot');  if (dot)  dot.textContent = f.split('-')[0] || f;
        const name = document.getElementById('fund-banner-name'); if (name) name.textContent = f;
        const wrap = document.getElementById('fund-banner-wrap'); if (wrap) wrap.classList.add('show');
        const gate = document.getElementById('section-gate');     if (gate) gate.style.display = 'none';
        const form = document.getElementById('section-form');     if (form) form.style.display = 'block';
      }
    })();
    @endif
  });

  /* ─── NEW TRANSACTION: Fund banner change ─── */
  function changeFund() {
    window.location = '{{ route('reviewer', ['open_funds' => 1]) }}';
  }

  /* ─── TRANSACTION TYPE SELECT ─── */
  document.addEventListener('DOMContentLoaded', function () {
    const txnSel = document.getElementById('txn-select');
    if (txnSel) {
      txnSel.addEventListener('change', function () {
        const val   = this.value;
        const label = this.options[this.selectedIndex].text;
        const hiddenTxn = document.getElementById('hidden-txn-type'); if (hiddenTxn) hiddenTxn.value = val;
        const nameEl    = document.getElementById('form-txn-name');   if (nameEl)   nameEl.textContent = label;
        document.querySelectorAll('.extra-fields').forEach(el => {
          el.classList.remove('show');
          el.querySelectorAll('input[required],textarea[required],select[required]').forEach(f => f.removeAttribute('required'));
        });
        const target = document.getElementById('extra-' + val);
        if (target) {
          target.classList.add('show');
          target.querySelectorAll('[data-orig-required="1"]').forEach(f => f.setAttribute('required', ''));
        }
        const card = document.getElementById('form-card'); if (card) card.classList.add('visible');
        const agree = document.getElementById('agree_terms'); if (agree) agree.checked = false;
        const submitBtn = document.getElementById('submit-btn'); if (submitBtn) submitBtn.disabled = true;
        setTimeout(() => { document.getElementById('form-card')?.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 80);
      });
    }
    const agree = document.getElementById('agree_terms');
    if (agree) agree.addEventListener('change', function () {
      const s = document.getElementById('submit-btn'); if (s) s.disabled = !this.checked;
    });
    document.querySelectorAll('.extra-fields [required]').forEach(f => f.setAttribute('data-orig-required', '1'));
  });

  function toggleCheckItem(el) { el.closest('.check-item, .remit-check-item')?.classList.toggle('checked', el.checked); }
  function toggleRemitOther(el) { document.getElementById('remit-other-field')?.classList.toggle('show', el.checked); }

  /* ─── TABLE FILTER ─── */
  function filterTable() {
    const q = document.getElementById('tbl-search')?.value.toLowerCase() || '';
    const s = document.getElementById('filter-status')?.value.toLowerCase() || '';
    const f = document.getElementById('filter-fund')?.value.toLowerCase() || '';
    const rows = document.querySelectorAll('#table-body tr[data-search]');
    let v = 0;
    rows.forEach(r => {
      const show = (!q || r.dataset.search.includes(q)) && (!s || r.dataset.status === s) && (!f || r.dataset.fund.toLowerCase() === f);
      r.style.display = show ? '' : 'none';
      if (show) v++;
    });
    const rc = document.getElementById('record-count'); if (rc) rc.textContent = v + (v === 1 ? ' record' : ' records');
    const fi = document.getElementById('footer-info'); if (fi) fi.innerHTML = 'Showing <strong>' + v + '</strong> of <strong>' + rows.length + '</strong> records';
  }

  /* ─── DRAWER ─── */
  let __active = null;
  function openDrawer(id) {
    const d = window.__drawers?.[id]; if (!d) return;
    __active = d;
    document.getElementById('drawer-payor-name').textContent = d.name;
    let h = `<div class="status-badge ${d.statusCls}" style="margin-bottom:16px;font-size:.74rem;padding:5px 13px;"><i class="bi ${d.statusIcon}"></i> ${d.status}</div>`;
    h += `<div class="drawer-actions">`;
    if (!['forwarded_to_accountant','approved'].includes(d.rawStatus)) {
      h += `<form method="POST" action="${d.forwardUrl}" onsubmit="return confirm('Forward payment from ${esc(d.name)} (${esc(d.amount)}) to Accountant?')" style="flex:1;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="drawer-action-approve" style="width:100%;"><i class="bi bi-arrow-right-circle"></i> Forward to Accountant</button>
      </form>`;
    }
    h += `<button type="button" class="drawer-action-modify" onclick="openModifyModal(window.__drawers[${id}].modifyData)"><i class="bi bi-pencil-fill"></i> Modify</button>`;
    h += `</div><hr class="drawer-divider">`;
    h += `<div class="drawer-section-title"><i class="bi bi-person-lines-fill"></i> Payor Information</div>`;
    h += df('Full Name', d.name) + df('Email', d.email) + df('Contact Number', d.contact) + df('Address', d.address);
    h += `<hr class="drawer-divider"><div class="drawer-section-title"><i class="bi bi-card-checklist"></i> Transaction Details</div>`;
    h += df('Transaction Type', d.txn) + df('Fund', d.fund) + df('Amount', d.amount) + df('O.P. No.', d.op) + df('Payment Mode', d.mode) + df('Date Processed', d.date);
    if (d.details && Object.keys(d.details).length) {
      h += `<hr class="drawer-divider"><div class="drawer-section-title"><i class="bi bi-info-circle"></i> Additional Information</div>`;
      for (const [k, v] of Object.entries(d.details)) h += df(k.replace(/_/g,' ').replace(/\b\w/g,c=>c.toUpperCase()), v);
    }
    document.getElementById('drawer-body').innerHTML = h;
    document.getElementById('drawer-overlay').classList.add('open');
    document.getElementById('detail-drawer').classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function df(label, value) { return `<div class="drawer-field"><div class="drawer-field-label">${label}</div><div class="drawer-field-value">${value||'—'}</div></div>`; }
  function closeDrawer() { document.getElementById('drawer-overlay').classList.remove('open'); document.getElementById('detail-drawer').classList.remove('open'); document.body.style.overflow = ''; }

  /* ─── MODIFY MODAL ─── */
  let __currentModifyId = null;
  function onModifyTxnChange(val) { document.querySelectorAll('.mod-extra').forEach(el => el.style.display = 'none'); const t = document.getElementById('mod-extra-' + val); if (t) t.style.display = 'block'; }
  function openModifyModal(data) {
    document.getElementById('modify-form').action = '/payments/' + encodeURIComponent(data.id);
    __currentModifyId = data.id;
    document.getElementById('mod-name').value    = data.name             || '';
    document.getElementById('mod-email').value   = data.email            || '';
    document.getElementById('mod-contact').value = data.contact          || '';
    document.getElementById('mod-address').value = data.address          || '';
    document.getElementById('mod-amount').value  = data.amount           || '';
    document.getElementById('mod-op').value      = data.op_number        || '';
    document.getElementById('mod-txn').value     = data.transaction_type || '';
    document.getElementById('mod-fund').value    = data.fund_type        || '';
    document.getElementById('mod-mode').value    = data.payment_mode     || 'cash';
    document.getElementById('mod-status').value  = data.status           || 'waiting';
    document.getElementById('mod-remarks').value = '';
    onModifyTxnChange(data.transaction_type || '');
    document.getElementById('modify-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeModifyModal() { document.getElementById('modify-modal').classList.remove('open'); document.body.style.overflow = ''; }
  function handleModifyOverlayClick(e) { if (e.target === document.getElementById('modify-modal')) closeModifyModal(); }
  document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeDrawer(); closeModifyModal(); } });

  function esc(s) { return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

  /* ─── AMOUNT IN WORDS ─── */
  function amountInWords(amount) {
    const ones=['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'];
    const tens=['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
    function say(n){if(n===0)return '';if(n<20)return ones[n]+' ';if(n<100)return tens[Math.floor(n/10)]+(n%10?'-'+ones[n%10]:'')+' ';if(n<1000)return ones[Math.floor(n/100)]+' Hundred '+say(n%100);if(n<1000000)return say(Math.floor(n/1000))+'Thousand '+say(n%1000);if(n<1000000000)return say(Math.floor(n/1000000))+'Million '+say(n%1000000);return say(Math.floor(n/1000000000))+'Billion '+say(n%1000000000);}
    const total=Math.round(amount*100);const pesos=Math.floor(total/100);const centavos=total%100;let words='';
    if(pesos===0&&centavos===0)return 'Zero Pesos Only';
    if(pesos>0)words+=say(pesos).trim()+(pesos===1?' Peso':' Pesos');
    if(centavos>0)words+=' and '+say(centavos).trim()+(centavos===1?' Centavo':' Centavos');else words+=' Only';
    return words;
  }

  /* ─── PRINT ORDER OF PAYMENT ─── */
  function printOrderOfPayment() {
    const d = __active; if (!d) return;
    const st = (d.rawStatus || d.status || '').toLowerCase();
    if (st !== 'approved') { alert('Only approved transactions can generate an Order of Payment.'); return; }
    const purposeParts = [d.txn];
    if (d.details) for (const [k,v] of Object.entries(d.details)) { if (['Contact','Email','Payment Mode','Address'].includes(k)) continue; purposeParts.push(/remark/i.test(k)?v:k+': '+v); }
    const purpose  = esc(purposeParts.join('  |  '));
    const amtWords = esc(amountInWords(d.amountNum||parseFloat((d.amountRaw||'0').replace(/,/g,''))||0));
    function opBlock(){return `<div class="op-wrap"><div class="appendix">Appendix 28</div><div class="meta-grid"><div class="meta-line"><span class="meta-label">Entity Name&nbsp;:</span><span class="uline">Department of Agrarian Reform Regional Office 5</span></div><div class="meta-line"><span class="meta-label">Serial No.&nbsp;:</span><span class="uline">${esc(d.op)}</span></div><div class="meta-line"><span class="meta-label">Fund Cluster&nbsp;:</span><span class="uline">${esc(d.fund)}</span></div><div class="meta-line"><span class="meta-label">Date&nbsp;:</span><span class="uline">${esc(d.dateShort)}</span></div></div><div class="op-title">ORDER OF PAYMENT</div><p>The Collecting Officer<br>Cash/Treasury Unit</p><p>Please issue Official Receipt in favor of <span class="inline-uline">${esc(d.name)}</span> <span class="field-label-small">(Name of Payor)</span></p><p><span class="inline-uline addr-line">${esc(d.address)}</span> <span class="field-label-small">(Address/Office of Payor)</span></p><div class="amount-row">in the amount of <span class="amt-field"><span class="auto-shrink">${amtWords}</span></span> <span>(P</span><span class="peso-box">${esc(d.amountRaw)}</span><span>)</span></div><div class="for-payment">for payment of</div><div class="purpose-field">${purpose}</div><div class="purpose-label">(Purpose)</div><br><div class="bill-row">per Bill No. <span class="bill-field"></span>&nbsp;&nbsp;dated <span class="date-field"></span>.</div><div class="bank-intro">Please deposit the collections under Bank Account/s:</div><table class="bank-table"><thead><tr><th class="col-no">No.</th><th class="col-name">Name of Bank</th><th class="col-amt">Amount</th></tr></thead><tbody><tr><td class="col-no">&nbsp;</td><td class="col-name">&nbsp;</td><td class="col-amt">P</td></tr><tr><td class="col-no">&nbsp;</td><td class="col-name">&nbsp;</td><td class="col-amt">&nbsp;</td></tr></tbody></table><div class="sig-section"><div class="sig-block"><span class="sig-name-underline">&nbsp;</span><div class="sig-role-label">Division/Unit/Authorized Official</div></div></div></div>`;}
    const html=`<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Order of Payment</title><style>@page{size:A4 landscape;margin:10mm 12mm}*{box-sizing:border-box;margin:0;padding:0}body{font-family:'Times New Roman',Times,serif;font-size:10pt;color:#000;background:#fff;line-height:1.35}.page-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 10mm;width:100%;height:100%}.op-wrap{padding:0;border-right:1px dashed #bbb;padding-right:8mm}.op-wrap:last-child{border-right:none;padding-right:0;padding-left:8mm}.appendix{text-align:right;font-size:8pt;font-style:italic;margin-bottom:3mm}.meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:2mm 6mm;margin-bottom:2mm}.meta-line{display:flex;align-items:flex-end;gap:4pt;font-size:9.5pt}.meta-label{white-space:nowrap}.uline{border-bottom:1px solid #000;padding:0 2pt 1pt;flex:1;font-size:9.5pt}.op-title{text-align:center;font-size:13pt;font-weight:bold;letter-spacing:1.5pt;margin:4mm 0 5mm}p{margin-bottom:3.5mm;font-size:10pt}.inline-uline{display:inline-block;border-bottom:1px solid #000;min-width:140pt;padding:0 3pt 1pt;vertical-align:bottom}.addr-line{min-width:200pt}.field-label-small{display:block;text-align:center;font-size:7.5pt}.amount-row{display:flex;align-items:flex-end;gap:4pt;margin-bottom:3mm;font-size:10pt}.amount-row .amt-field{flex:1;border-bottom:1px solid #000;padding:0 3pt 1pt;font-style:italic;overflow:hidden}.amount-row .peso-box{border-bottom:1px solid #000;padding:0 3pt 1pt;min-width:60pt}.auto-shrink{display:inline-block;max-width:100%;font-size:clamp(7pt,9.5pt,10pt);white-space:nowrap}.for-payment{margin-bottom:1.5mm;font-size:10pt}.purpose-field{border-bottom:1px solid #000;padding:2pt 3pt;font-size:clamp(7.5pt,10pt,10pt);min-height:17pt;width:100%;margin-bottom:1pt;word-break:break-word}.purpose-label{text-align:center;font-size:7.5pt}.bill-row{display:flex;align-items:flex-end;gap:4pt;margin-bottom:4mm;font-size:10pt}.bill-field,.date-field{border-bottom:1px solid #000;min-width:55pt;padding:0 3pt 1pt;display:inline-block}.bill-field{min-width:70pt}.bank-intro{font-size:10pt;margin-bottom:2mm}.bank-table{width:100%;border-collapse:collapse}.bank-table th{font-weight:normal;text-decoration:underline;padding:2pt 3pt;font-size:10pt;text-align:left}.bank-table td{height:16pt;border-bottom:1px solid #000;padding:1pt 3pt;font-size:10pt}.bank-table .col-no{width:12%}.bank-table .col-name{width:55%}.bank-table .col-amt{width:33%}.sig-section{margin-top:8mm;display:flex;justify-content:flex-end}.sig-block{text-align:center}.sig-name-underline{display:block;border-bottom:2px solid #000;min-width:160pt;padding:0 4pt 2pt;min-height:18pt}.sig-role-label{font-size:8pt;text-align:center;margin-top:2pt}@media print{body{-webkit-print-color-adjust:exact;print-color-adjust:exact}}</style></head><body><div class="page-grid">${opBlock()}${opBlock()}</div><script>window.onload=function(){window.print();window.onafterprint=function(){window.close();};};<\/script></body></html>`;
    const win = window.open('', '_blank', 'width=1100,height=800,scrollbars=yes');
    win.document.write(html); win.document.close();
  }

  /* ─── LIVE STATUS POLLING ─── */
  (function pollPayments() {
    async function refresh() {
      try {
        const res = await fetch('{{ route('payments.json') }}', { cache: 'no-store' });
        if (!res.ok) return;
        const list = await res.json();
        const byId = {};
        list.forEach(p => byId[p.id] = p);
        document.querySelectorAll('#table-body tr[data-id]').forEach(tr => {
          const id = tr.getAttribute('data-id');
          const d = byId[id]; if (!d) return;
          const sb = tr.querySelector('.status-badge'); if (!sb) return;
          const st = (d.status || 'waiting').toLowerCase();
          let cls = 'sb-default', icon = 'bi-circle';
          if (st === 'approved')                                              { cls = 'sb-approved'; icon = 'bi-check-circle-fill'; }
          else if (['rejected','accountant_rejected'].includes(st))          { cls = 'sb-rejected'; icon = 'bi-x-circle-fill'; }
          else if (['waiting','submitted','under_review','forwarded'].includes(st)) { cls = 'sb-waiting'; icon = 'bi-hourglass-split'; }
          sb.className = 'status-badge ' + cls;
          sb.innerHTML = `<i class="bi ${icon}"></i> ` + (st.charAt(0).toUpperCase() + st.slice(1));
        });
        const total    = list.length;
        const sum      = list.reduce((s, it) => s + (parseFloat(it.amount || 0) || 0), 0);
        const awaiting = list.filter(it => ['submitted','under_review','accountant_rejected','waiting'].includes(it.status || 'waiting')).length;
        const approved = list.filter(it => (it.status || '') === 'approved').length;
        const elTotal  = document.getElementById('stat-total-count');   if (elTotal)  elTotal.textContent  = total;
        const elAmt    = document.getElementById('stat-total-amount');  if (elAmt)    elAmt.textContent    = '₱' + sum.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const elAwait  = document.getElementById('stat-awaiting-count'); if (elAwait)  elAwait.textContent = awaiting;
        const elApp    = document.getElementById('stat-approved-count'); if (elApp)    elApp.textContent   = approved;
        const rc       = document.getElementById('record-count'); if (rc) rc.textContent = total + ' record' + (total !== 1 ? 's' : '');
      } catch (e) { /* ignore */ }
    }
    refresh();
    setInterval(refresh, 8000);
  })();
</script>

</body>
</html>