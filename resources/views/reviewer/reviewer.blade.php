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
    .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

    /* HEADER */
    .page-header { background: var(--green-deep); padding: 16px 32px; display: flex; align-items: center; gap: 14px; position: sticky; top: 0; z-index: 100; }
    .header-seal { width: 38px; height: 38px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }

    /* REVIEWER BADGE in header */
    .reviewer-badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 5px 12px; border-radius: 20px;
      background: rgba(201,153,42,.18); border: 1px solid rgba(201,153,42,.35);
      color: var(--gold-light); font-size: .68rem; font-weight: 700;
      letter-spacing: 1.2px; text-transform: uppercase;
    }
    .reviewer-badge i { font-size: .8rem; }

    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }
    .btn-logout {
      background: none; border: none; color: var(--cream); font-size: .78rem;
      cursor: pointer; padding: 8px 14px; display: flex; align-items: center; gap: 6px;
      border-radius: 8px; font-family: 'DM Sans', sans-serif; font-weight: 500;
      letter-spacing: .4px; transition: background .15s; opacity: .75;
    }
    .btn-logout:hover { background: rgba(255,255,255,.1); opacity: 1; }
    .btn-logout i { font-size: .88rem; }

    /* PAGE BODY — widened to use full screen */
    .page-body { max-width: 1600px; margin: 0 auto; padding: 36px 32px 60px; }
    .page-title-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

    /* REVIEWER NOTICE BANNER */
    .reviewer-notice {
      display: flex; align-items: flex-start; gap: 12px;
      padding: 14px 18px; border-radius: 12px; margin-bottom: 22px;
      background: #fdf3dc; border: 1px solid rgba(201,153,42,.3); color: #7a5a0a;
      font-size: .83rem; line-height: 1.5;
    }
    .reviewer-notice i { font-size: 1.1rem; margin-top: 1px; flex-shrink: 0; }
    .reviewer-notice strong { font-weight: 700; display: block; margin-bottom: 2px; }

    /* STAT CARDS */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
    .stat-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .si-green { background: var(--green-light); color: var(--green-accent); }
    .si-gold  { background: #fdf3dc; color: var(--gold); }
    .si-amber { background: #fff7ed; color: #c2640a; }
    .si-red   { background: #fdf0ef; color: var(--red); }
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

    /* TABLE — fixed layout with defined column widths, no cutoff */
    .payments-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    .payments-table thead tr { background: #faf8f4; border-bottom: 1.5px solid var(--border); }
    .payments-table thead th { padding: 11px 14px; font-size: .68rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--text-mid); white-space: nowrap; overflow: hidden; }
    .payments-table thead th:first-child { padding-left: 20px; }
    .payments-table thead th:last-child  { padding-right: 20px; }

    /* Column width distribution — 9 columns totaling 100% */
    .payments-table col.col-id     { width: 4%; }
.payments-table col.col-payor  { width: 15%; }
.payments-table col.col-amount { width: 8%; }
.payments-table col.col-txn    { width: 15%; }
.payments-table col.col-fund   { width: 6%; }
.payments-table col.col-op     { width: 11%; }
.payments-table col.col-date   { width: 9%; }
.payments-table col.col-status { width: 12%; }
.payments-table col.col-act    { width: 20%; }

    .payments-table tbody tr { border-bottom: 1px solid var(--border); transition: background .13s; cursor: pointer; }
    .payments-table tbody tr:last-child { border-bottom: none; }
    .payments-table tbody tr:hover { background: #f9f7f2; }
    .payments-table tbody td { padding: 12px 14px; font-size: .84rem; color: var(--text-dark); vertical-align: middle; }
    .payments-table tbody td:first-child { padding-left: 20px; }
    .payments-table tbody td:last-child  { padding-right: 20px; }

    .row-id { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; background: var(--green-light); color: var(--green-accent); font-size: .72rem; font-weight: 700; }
    .payor-cell { display: flex; align-items: center; gap: 9px; }
    .payor-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--green-mid); color: #fff; font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .payor-name { font-weight: 600; font-size: .86rem; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .payor-contact { font-size: .71rem; color: var(--muted); margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .amount-cell { font-weight: 700; font-size: .91rem; color: var(--green-mid); white-space: nowrap; }
    .txn-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 9px; border-radius: 20px; background: #f0f4f2; color: var(--text-mid); font-size: .71rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; }
    .fund-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; background: #fdf3dc; color: var(--gold); font-size: .67rem; font-weight: 700; white-space: nowrap; }
    .op-number { font-size: .77rem; color: var(--text-mid); font-weight: 500; word-break: break-all; }
    .date-cell .date-main { font-size: .81rem; color: var(--text-dark); font-weight: 500; }
    .date-cell .date-time { font-size: .69rem; color: var(--muted); margin-top: 2px; }
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; white-space: nowrap; }
    .sb-approved { background: var(--green-light); color: var(--green-accent); }
    .sb-waiting  { background: #fdf3dc; color: #a0700a; }
    .sb-rejected { background: #fdf0ef; color: var(--red); }
    .sb-default  { background: #f0f4f2; color: var(--muted); }

    /* ROW ACTION BUTTONS — all on one line, no wrapping */
    .actions-cell { display: flex; align-items: center; gap: 5px; flex-wrap: nowrap; white-space: nowrap; }
    .actions-cell form { display: inline-flex; flex-shrink: 0; }
    .action-btn { width: 30px; height: 30px; border-radius: 7px; border: 1.5px solid var(--border); background: #faf8f4; color: var(--text-mid); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; cursor: pointer; transition: background .15s, border-color .15s, color .15s; text-decoration: none; flex-shrink: 0; }
    .action-btn:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }
    .btn-row-approve { display: inline-flex; align-items: center; gap: 4px; padding: 5px 11px; border: none; border-radius: 7px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s; white-space: nowrap; flex-shrink: 0; }
    .btn-row-approve:hover { background: var(--green-mid); }
    .btn-row-reject  { display: inline-flex; align-items: center; gap: 4px; padding: 5px 11px; border: 1.5px solid #e8c5c5; border-radius: 7px; background: #fdf0ef; color: var(--red); font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s; white-space: nowrap; flex-shrink: 0; }
    .btn-row-reject:hover { background: #fde0de; border-color: #f0a8a8; }
    .btn-row-modify  { display: inline-flex; align-items: center; gap: 4px; padding: 5px 11px; border: 1.5px solid #b8d0e8; border-radius: 7px; background: var(--blue-light); color: var(--blue); font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s; white-space: nowrap; flex-shrink: 0; }
    .btn-row-modify:hover { background: #d0e4f5; border-color: #8ab4d8; }

    .empty-row td { padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 2.4rem; color: var(--border); margin-bottom: 12px; }
    .empty-text { font-size: .85rem; color: var(--muted); }
    .table-footer { padding: 12px 22px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .table-footer-info { font-size: .75rem; color: var(--muted); }
    .table-footer-info strong { color: var(--text-mid); }
    .pagination-wrap { display: flex; align-items: center; gap: 4px; }

    /* Pagination styles */
    .pagination-wrap { display:flex; align-items:center; gap:8px; margin-left:auto; }
    .page-link, .page-number { padding:6px 10px; border-radius:8px; text-decoration:none; font-weight:700; color:var(--green-accent); border:1px solid transparent; background:transparent; }
    .page-link.disabled { opacity:0.5; pointer-events:none; color:var(--muted); }
    .page-number { color:var(--text-dark); border:1px solid transparent; }
    .page-number:hover { background:#f2faf5; border-color:var(--border); }
    .page-number.active { background:var(--gold); color:var(--green-deep); border-color:var(--gold); }
    

    /* DRAWER */
    .drawer-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 500; }
    .drawer-overlay.open { display: block; }
    .detail-drawer { position: fixed; top: 0; right: 0; width: 440px; max-width: 100vw; height: 100vh; background: var(--surface); box-shadow: -8px 0 40px rgba(0,0,0,.18); display: flex; flex-direction: column; transform: translateX(100%); transition: transform .28s cubic-bezier(.16,1,.3,1); z-index: 501; }
    .detail-drawer.open { transform: translateX(0); }
    .drawer-head { padding: 15px 18px; background: var(--green-deep); display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-shrink: 0; }
    .drawer-head-left { flex: 1; min-width: 0; }
    .drawer-head-title { font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; font-weight: 700; color: var(--gold-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .drawer-head-sub { font-size: .58rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.35); margin-top: 2px; }
    .drawer-head-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
    .drawer-print-btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 13px; background: var(--gold); border: none; border-radius: 7px; color: var(--green-deep); font-family: 'DM Sans', sans-serif; font-size: .7rem; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; cursor: pointer; transition: background .15s, transform .12s; white-space: nowrap; }
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

    /* Drawer quick-action buttons */
    .drawer-actions { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
    .drawer-action-approve { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 14px; border: none; border-radius: 9px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .drawer-action-approve:hover { background: var(--green-mid); }
    .drawer-action-reject { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 14px; border: 1.5px solid #e8c5c5; border-radius: 9px; background: #fdf0ef; color: var(--red); font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .drawer-action-reject:hover { background: #fde0de; }
    .drawer-action-modify { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 14px; border: 1.5px solid #b8d0e8; border-radius: 9px; background: var(--blue-light); color: var(--blue); font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .drawer-action-modify:hover { background: #d0e4f5; }

    .alert-bar { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: .84rem; font-weight: 500; }
    .alert-success { background: var(--green-light); color: var(--green-accent); border: 1px solid rgba(45,122,79,.2); }
    .alert-danger   { background: #fdf0ef; color: var(--red); border: 1px solid rgba(160,37,28,.2); }

    /* ── MODIFY MODAL ── */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(14,42,26,.55); backdrop-filter: blur(3px); z-index: 999; align-items: center; justify-content: center; padding: 20px; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: var(--surface); border-radius: 16px; width: 100%; max-width: 640px; box-shadow: 0 20px 60px rgba(14,42,26,.22), 0 4px 16px rgba(0,0,0,.1); overflow: hidden; animation: modalIn .2s ease; }
    @keyframes modalIn { from { opacity: 0; transform: translateY(16px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .modal-header { background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; }
    .modal-title  { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 9px; }
    .modal-close  { background: none; border: none; color: rgba(245,240,232,.5); font-size: 1.2rem; cursor: pointer; transition: color .15s; display: flex; align-items: center; padding: 4px; border-radius: 6px; }
    .modal-close:hover { color: var(--cream); background: rgba(255,255,255,.08); }
    .modal-body   { padding: 24px; max-height: 70vh; overflow-y: auto; }

    /* Reviewer note inside modal */
    .modal-reviewer-note { display: flex; align-items: flex-start; gap: 9px; padding: 10px 14px; border-radius: 8px; margin-bottom: 18px; background: var(--blue-light); color: var(--blue); border: 1px solid rgba(26,74,122,.2); font-size: .78rem; line-height: 1.5; }
    .modal-reviewer-note i { font-size: .9rem; margin-top: 1px; flex-shrink: 0; }

    .modal-grid   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .modal-field  { display: flex; flex-direction: column; gap: 5px; }
    .modal-field.full { grid-column: 1 / -1; }
    .modal-field label { font-size: .68rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-mid); }
    .modal-field input, .modal-field select, .modal-field textarea { padding: 9px 12px; border: 1.5px solid var(--border); border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .88rem; color: var(--text-dark); background: var(--bg); outline: none; transition: border-color .2s, box-shadow .2s; }
    .modal-field textarea { resize: vertical; min-height: 70px; }
    .modal-field input:focus, .modal-field select:focus, .modal-field textarea:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); background: #fff; }
    .modal-field select { appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238a9e90' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 32px; background-color: var(--bg); }

    /* Remark field highlight */
    .field-remark-wrap { position: relative; }
    .field-remark-wrap textarea { border-color: #b8d0e8; background: var(--blue-light); }
    .field-remark-wrap textarea:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(26,74,122,.1); }
    .remark-label-tag { display: inline-flex; align-items: center; gap: 4px; font-size: .6rem; font-weight: 700; padding: 2px 7px; border-radius: 10px; background: var(--blue); color: #fff; letter-spacing: .6px; text-transform: uppercase; margin-top: -2px; }

    .modal-footer { padding: 16px 24px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }
    .btn-modal-cancel { padding: 9px 18px; border: 1.5px solid var(--border); border-radius: 9px; background: var(--surface); color: var(--text-mid); font-family: 'DM Sans', sans-serif; font-size: .82rem; font-weight: 600; cursor: pointer; transition: background .15s; }
    .btn-modal-cancel:hover { background: var(--bg); }
    .btn-modal-save   { padding: 9px 20px; border: none; border-radius: 9px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .82rem; font-weight: 700; cursor: pointer; transition: background .15s; display: flex; align-items: center; gap: 6px; }
    .btn-modal-save:hover { background: var(--green-mid); }

    @media (max-width: 1100px) {
      .page-body { padding: 28px 20px 48px; }
    }
    @media (max-width: 900px) {
      .stat-row { grid-template-columns: repeat(2,1fr); }
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
      .modal-grid { grid-template-columns: 1fr; }
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
  <div class="header-page">Reviewer</div>
  <div class="reviewer-badge" style="margin-left: 10px;">
    <i class="bi bi-shield-check"></i> Reviewer Access
  </div>
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

  <div class="page-title-row">
    <div>
      <div class="page-title">Review Payment Records</div>
      <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
    </div>
  </div>

  <!-- REVIEWER NOTICE -->
  <div class="reviewer-notice">
    <i class="bi bi-info-circle-fill"></i>
    <div>
      <strong>Reviewer Mode</strong>
      You are logged in as a Reviewer. You may approve, reject, or modify any payment record submitted by the Maker. All actions are logged and traceable. New payment entries can only be created by the Maker.
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
        <div id="stat-awaiting-count" class="stat-value">{{ $payments->whereIn('status', ['submitted','under_review','accountant_rejected','waiting'])->count() }}</div>
        <div class="stat-label">Awaiting Review</div>
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
          <th>Payor</th>
          <th>Amount</th>
          <th>Transaction Type</th>
          <th>Fund</th>
          <th>O.P. Number</th>
          <th>Date</th>
          <th>Status</th>
          <th>Actions</th>
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

            {{-- ── ACTIONS CELL ── --}}
            <td onclick="event.stopPropagation()">
              <div class="actions-cell">

                {{-- View drawer --}}
                <a href="#" class="action-btn" title="View details"
                   onclick="openDrawer({{ $p->id }});return false;">
                  <i class="bi bi-eye"></i>
                </a>

                {{-- Forward to Accountant (Reviewer action) --}}
                @if($status !== 'forwarded' && $status !== 'approved')
                  <form method="POST" action="{{ route('payments.forward', $p->id) }}"
                        onsubmit="return confirm('Forward payment from {{ addslashes($p->name) }} (₱{{ number_format($p->amount,2) }}) to Accountant?')">
                    @csrf
                    <button type="submit" class="btn-row-approve">
                      <i class="bi bi-arrow-right-circle"></i> Forward
                    </button>
                  </form>
                @else
                  <button type="button" class="btn-row-approve" disabled style="opacity:.6;cursor:not-allowed;">
                    <i class="bi bi-arrow-right-circle"></i> Forward
                  </button>
                @endif

                {{-- Modify --}}
                @if($status === 'forwarded' || $status === 'approved')
                  <button type="button" class="btn-row-modify" disabled style="opacity:.6;cursor:not-allowed;">
                    <i class="bi bi-pencil"></i> Modify
                  </button>
                @else
                  <button type="button" class="btn-row-modify"
                    onclick="openModifyModal({
                      id:               {{ $p->id }},
                      name:             '{{ addslashes($p->name) }}',
                      email:            '{{ addslashes($p->email ?? '') }}',
                      contact:          '{{ addslashes($p->contact ?? '') }}',
                      address:          '{{ addslashes($p->address ?? '') }}',
                      amount:           '{{ $p->amount }}',
                      transaction_type: '{{ addslashes($rawTxn) }}',
                      fund_type:        '{{ addslashes($p->fund_type ?? '') }}',
                      op_number:        '{{ addslashes($p->op_number ?? '') }}',
                      payment_mode:     '{{ addslashes($p->payment_mode ?? '') }}',
                      status:           '{{ $status }}'
                    })">
                    <i class="bi bi-pencil"></i> Modify
                  </button>
                @endif

              </div>
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
              rawTxn:     @json($rawTxn),
              fund:       @json($fundLabel),
              op:         @json($p->op_number ?? '—'),
              mode:       @json(ucfirst(str_replace('_',' ',$p->payment_mode ?? 'cash'))),
              rawMode:    @json($p->payment_mode ?? 'cash'),
              status:     @json(ucfirst($status)),
              rawStatus:  @json($status),
              statusCls:  @json($statusCls),
              statusIcon: @json($statusIcon),
              date:       @json($p->created_at->format('F d, Y — h:i A')),
              meta:       @json($p->meta ?? []),
              dateShort:  @json($p->created_at->format('m/d/Y')),
              details:    @json($details),
              forwardUrl: @json(route('payments.forward', $p->id)),
              modifyData: {
                id:               {{ $p->id }},
                name:             @json($p->name),
                email:            @json($p->email ?? ''),
                contact:          @json($p->contact ?? ''),
                address:          @json($p->address ?? ''),
                amount:           @json($p->amount),
                transaction_type: @json($rawTxn),
                fund_type:        @json($p->fund_type ?? ''),
                op_number:        @json($p->op_number ?? ''),
                payment_mode:     @json($p->payment_mode ?? 'cash'),
                status:           @json($status),
                meta:             @json($p->meta ?? []),  
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
        @if(method_exists($payments, 'lastPage'))
          <div class="pagination-wrap" aria-label="Pagination">
            @if($payments->onFirstPage())
              <span class="page-link disabled">« Previous</span>
            @else
              <a class="page-link" href="{{ $payments->previousPageUrl() }}">« Previous</a>
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

</div><!-- /page-body -->

<!-- DETAIL DRAWER -->
<div class="drawer-overlay" id="drawer-overlay" onclick="closeDrawer()"></div>
<div class="detail-drawer" id="detail-drawer">
  <div class="drawer-head">
    <div class="drawer-head-left">
      <div class="drawer-head-title" id="drawer-payor-name">—</div>
      <div class="drawer-head-sub">Transaction Details · Reviewer View</div>
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

<!-- ── MODIFY MODAL ── -->
<div class="modal-overlay" id="modify-modal" onclick="handleModifyOverlayClick(event)">
  <div class="modal-box" style="max-width:700px;">
    <div class="modal-header">
      <div class="modal-title">
        <i class="bi bi-pencil-square"></i> Modify Payment Record
      </div>
      <button type="button" class="modal-close" onclick="closeModifyModal()">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>

    <form method="POST" id="modify-form" action="">
      @csrf
      @method('PUT')

      <div class="modal-body">

        <div class="modal-reviewer-note">
          <i class="bi bi-shield-check"></i>
          You are modifying this record as a <strong>Reviewer</strong>. All field changes are permitted. Use the Remarks field to document the reason for any modification.
        </div>

        {{-- ── COMMON FIELDS ── --}}
        <div class="modal-grid">

          <div class="modal-field full">
            <label for="mod-name">Payor Name</label>
            <input type="text" id="mod-name" name="name" required placeholder="Full name of payor" />
          </div>

          <div class="modal-field">
            <label for="mod-email">Email</label>
            <input type="email" id="mod-email" name="email" placeholder="email@example.com" />
          </div>

          <div class="modal-field">
            <label for="mod-contact">Contact Number</label>
            <input type="text" id="mod-contact" name="contact" placeholder="e.g. 09XX XXX XXXX" />
          </div>

          <div class="modal-field full">
            <label for="mod-address">Address</label>
            <textarea id="mod-address" name="address" placeholder="Office or home address"></textarea>
          </div>

          <div class="modal-field">
            <label for="mod-amount">Amount (₱)</label>
            <input type="number" id="mod-amount" name="amount" step="0.01" min="0" required placeholder="0.00" />
          </div>

          <div class="modal-field">
            <label for="mod-op">O.P. Number</label>
            <input type="text" id="mod-op" name="op_number" readonly
  style="background:#f0f0eb;color:var(--muted);cursor:not-allowed;" />
          </div>

          <div class="modal-field">
            <label for="mod-txn">Transaction Type</label>
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
            <label for="mod-fund">Fund Type</label>
            <select id="mod-fund" name="fund_type" onchange="updateModOpNumber()">
              <option value="">— Select Fund —</option>
              <option value="F01">Fund 01 — Regular</option>
              <option value="F03">Fund 03 — ARF</option>
              <option value="F07">Fund 07 — Trust</option>
              <option value="F02-LP">LP Split — Fund 02</option>
              <option value="F02-GOP">GOP Split — Fund 02</option>
            </select>
          </div>

          <div class="modal-field">
            <label for="mod-mode">Payment Mode</label>
            <select id="mod-mode" name="payment_mode">
              <option value="cash">Cash</option>
              <option value="check">Check</option>
              <option value="online_transfer">Online Transfer</option>
              <option value="bank_deposit">Bank Deposit</option>
            </select>
          </div>

          <div class="modal-field">
            <label for="mod-status">Status</label>
            <select id="mod-status" name="status">
              <option value="waiting">Waiting</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>

        </div>{{-- /modal-grid --}}

        {{-- ── TRANSACTION-TYPE EXTRA FIELDS ── --}}

        {{-- 1. Appeal Fee --}}
        <div class="mod-extra" id="mod-extra-appeal_fee" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Appeal Fee Details</div>
          <div class="modal-field full">
            <label>Remarks / Comments</label>
            <textarea name="appeal_remarks" id="mod-appeal_remarks" placeholder="Enter any relevant remarks…"></textarea>
          </div>
        </div>

        {{-- 2. Bidding Documents --}}
        <div class="mod-extra" id="mod-extra-bidding_documents" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Bidding Document Details</div>
          <div class="modal-grid">
            <div class="modal-field full">
              <label>Details of the Availed Bid</label>
              <input type="text" name="bid_details" id="mod-bid_details" placeholder="e.g. Bid title, project name" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="bid_remarks" id="mod-bid_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 3. Cash Bond --}}
        <div class="mod-extra" id="mod-extra-cash_bond" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Cash Bond Details</div>
          <div class="modal-grid">
            <div class="modal-field">
              <label>Total Area (hectares)</label>
              <input type="number" step="0.0001" min="0" name="area_hectares" id="mod-area_hectares" placeholder="e.g. 2.5000" />
            </div>
            <div class="modal-field">
              <label>Zonal Value (₱)</label>
              <input type="number" step="0.01" min="0" name="zonal_value" id="mod-zonal_value" placeholder="0.00" />
            </div>
            <div class="modal-field full">
              <label>Location of Property / Landholding</label>
              <input type="text" name="property_location" id="mod-property_location" placeholder="Barangay, Municipality, Province" />
            </div>
            <div class="modal-field full">
              <label>Assessment Form</label>
              <input type="text" name="assessment_form" id="mod-assessment_form" placeholder="Assessment form reference" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="cash_bond_remarks" id="mod-cash_bond_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 4. Certification, Copy Fee --}}
        <div class="mod-extra" id="mod-extra-certification_copy_fee" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Certification / Copy Fee Details</div>
          <div class="modal-grid">
            <div class="modal-field full">
              <label>Letter Request</label>
              <input type="text" name="letter_request" id="mod-letter_request" placeholder="Reference to the letter request" />
            </div>
            <div class="modal-field full">
              <label>Type of Transaction Paid</label>
              <div style="display:flex;flex-direction:column;gap:7px;">
                <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-mid);">
                  <input type="checkbox" name="cert_type[]" id="mod-cert_certification" value="certification"> Certification
                </label>
                <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-mid);">
                  <input type="checkbox" name="cert_type[]" id="mod-cert_copy_fee" value="copy_fee"> Copy Fee
                </label>
                <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-mid);">
                  <input type="checkbox" name="cert_type[]" id="mod-cert_reproduction_cost" value="reproduction_cost"> Reproduction Cost
                </label>
              </div>
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="cert_remarks" id="mod-cert_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 5. Consignment --}}
        <div class="mod-extra" id="mod-extra-consignment" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Consignment Details</div>
          <div class="modal-grid">
            <div class="modal-field">
              <label>Assessment Form No.</label>
              <input type="text" name="consignment_assessment_form" id="mod-consignment_assessment_form" placeholder="Assessment form number" />
            </div>
            <div class="modal-field">
              <label>Case No.</label>
              <input type="text" name="consignment_case_no" id="mod-consignment_case_no" placeholder="e.g. DARAB Case No. 001-2025" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="consignment_remarks" id="mod-consignment_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 6. Execution of Judgment --}}
        <div class="mod-extra" id="mod-extra-execution_judgment" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Execution of Judgment Details</div>
          <div class="modal-grid">
            <div class="modal-field">
              <label>Assessment Form No.</label>
              <input type="text" name="exec_assessment_form" id="mod-exec_assessment_form" placeholder="Assessment form number" />
            </div>
            <div class="modal-field">
              <label>Type of Transaction Paid</label>
              <input type="text" name="exec_txn_type_paid" id="mod-exec_txn_type_paid" placeholder="Brief description" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="exec_remarks" id="mod-exec_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 7. Filing Fee --}}
        <div class="mod-extra" id="mod-extra-filing_fee" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Filing Fee / Inspection Details</div>
          <div class="modal-grid">
            <div class="modal-field full">
              <label>Assessment Form</label>
              <input type="text" name="filing_assessment_form" id="mod-filing_assessment_form" placeholder="Assessment form reference" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="filing_remarks" id="mod-filing_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 8. Income Unserviceable --}}
        <div class="mod-extra" id="mod-extra-income_unserviceable" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Unserviceable Property Details</div>
          <div class="modal-grid">
            <div class="modal-field full">
              <label>RDC Resolution No.</label>
              <input type="text" name="rdc_resolution_no" id="mod-rdc_resolution_no" placeholder="e.g. RDC-2025-001" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="unserviceable_remarks" id="mod-unserviceable_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 9. Legal Research --}}
        <div class="mod-extra" id="mod-extra-legal_research" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Legal Research Details</div>
          <div class="modal-field full">
            <label>Remarks / Comments</label>
            <textarea name="legal_research_remarks" id="mod-legal_research_remarks" placeholder="Enter any relevant remarks…"></textarea>
          </div>
        </div>

        {{-- 10. Performance Bond --}}
        <div class="mod-extra" id="mod-extra-performance_bond" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Performance Bond Details</div>
          <div class="modal-grid">
            <div class="modal-field">
              <label>Total Area (hectares)</label>
              <input type="number" step="0.0001" min="0" name="pb_area_hectares" id="mod-pb_area_hectares" placeholder="e.g. 2.5000" />
            </div>
            <div class="modal-field">
              <label>Zonal Value (₱)</label>
              <input type="number" step="0.01" min="0" name="pb_zonal_value" id="mod-pb_zonal_value" placeholder="0.00" />
            </div>
            <div class="modal-field full">
              <label>Location of Property / Landholding</label>
              <input type="text" name="pb_property_location" id="mod-pb_property_location" placeholder="Barangay, Municipality, Province" />
            </div>
            <div class="modal-field full">
              <label>Assessment Form</label>
              <input type="text" name="pb_assessment_form" id="mod-pb_assessment_form" placeholder="Assessment form reference" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="pb_remarks" id="mod-pb_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 11. Refund of Cash Advances --}}
        <div class="mod-extra" id="mod-extra-refund_cash_advances" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Refund of Cash Advances Details</div>
          <div class="modal-grid">
            <div class="modal-field">
              <label>Check / LDDAP-ADA Number</label>
              <input type="text" name="check_lddap_ada" id="mod-check_lddap_ada" placeholder="Check or LDDAP-ADA number" />
            </div>
            <div class="modal-field">
              <label>Date Cash Advance was Granted</label>
              <input type="date" name="cash_advance_date" id="mod-cash_advance_date" />
            </div>
            <div class="modal-field full">
              <label>Division / Section of Payor</label>
              <input type="text" name="division_section" id="mod-division_section" placeholder="e.g. Finance Division" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="cash_advance_remarks" id="mod-cash_advance_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 12. Refund of Overpayment --}}
        <div class="mod-extra" id="mod-extra-refund_overpayment" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Refund of Overpayment Details</div>
          <div class="modal-grid">
            <div class="modal-field full">
              <label>Division / Section of Payor</label>
              <input type="text" name="refund_division_section" id="mod-refund_division_section" placeholder="e.g. Finance Division" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="refund_op_remarks" id="mod-refund_op_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 13. Settlement of Disallowances --}}
        <div class="mod-extra" id="mod-extra-settlement_disallowances" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Notice of Disallowance Details</div>
          <div class="modal-grid">
            <div class="modal-field full">
              <label>Notice of Disallowances No.</label>
              <input type="text" name="disallowance_no" id="mod-disallowance_no" placeholder="e.g. ND-2025-001" />
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="disallowance_remarks" id="mod-disallowance_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- 14. Unwithheld Remittances --}}
        <div class="mod-extra" id="mod-extra-unwithheld_remittances" style="display:none;">
          <hr style="border:none;border-top:1px solid var(--border);margin:18px 0 14px;">
          <div style="font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--green-accent);margin-bottom:12px;">Unwithheld Remittances Details</div>
          <div class="modal-grid">
            <div class="modal-field full">
              <label>Type of Remittance</label>
              <div style="display:flex;flex-direction:column;gap:7px;">
                <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-mid);">
                  <input type="checkbox" name="remit_type[]" id="mod-remit_gsis" value="GSIS"> GSIS
                </label>
                <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-mid);">
                  <input type="checkbox" name="remit_type[]" id="mod-remit_phic" value="PHIC"> PHIC — Philhealth
                </label>
                <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-mid);">
                  <input type="checkbox" name="remit_type[]" id="mod-remit_hdmf" value="HDMF"> HDMF — Pag-IBIG
                </label>
                <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-mid);">
                  <input type="checkbox" name="remit_type[]" id="mod-remit_other" value="Other" onchange="document.getElementById('mod-remit-other-wrap').style.display=this.checked?'block':'none'"> Other Payables
                </label>
                <div id="mod-remit-other-wrap" style="display:none;margin-top:4px;">
                  <input type="text" name="remit_other_specify" id="mod-remit_other_specify" placeholder="Please specify other payable…" />
                </div>
              </div>
            </div>
            <div class="modal-field full">
              <label>Remarks / Comments</label>
              <textarea name="remit_remarks" id="mod-remit_remarks" placeholder="Enter any relevant remarks…"></textarea>
            </div>
          </div>
        </div>

        {{-- ── REVIEWER REMARKS (always shown at bottom) ── --}}
        <div style="margin-top:18px;">
          <div class="modal-field full">
            <label style="display:flex;align-items:center;gap:6px;">
              Reviewer Remarks
              <span class="remark-label-tag"><i class="bi bi-shield-check"></i> Reviewer Only</span>
            </label>
            <div class="field-remark-wrap">
              <textarea id="mod-remarks" name="reviewer_remarks" placeholder="Document your reason for this modification…"></textarea>
            </div>
          </div>
        </div>

      </div>{{-- /modal-body --}}

      <div class="modal-footer">
        <button type="button" class="btn-modal-cancel" onclick="closeModifyModal()">Cancel</button>
        <button type="submit" class="btn-modal-save">
          <i class="bi bi-floppy"></i> Save Changes
        </button>
      </div>
    </form>
  </div>
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

    h += `<div class="status-badge ${d.statusCls}" style="margin-bottom:16px;font-size:.75rem;padding:6px 14px;"><i class="bi ${d.statusIcon}"></i> ${d.status}</div>`;

    h += `<div class="drawer-actions">`;
    // Reviewer: provide forward action to Accountant and modify
    if (!['forwarded_to_accountant','approved'].includes(d.rawStatus)) {
      h += `<form method="POST" action="${d.forwardUrl}" onsubmit="return confirm('Forward payment from ${esc(d.name)} (${esc(d.amount)}) to Accountant?')" style="flex:1;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="drawer-action-approve" style="width:100%;">
          <i class="bi bi-arrow-right-circle"></i> Forward to Accountant
        </button>
      </form>`;
    }
    h += `<button type="button" class="drawer-action-modify" onclick="openModifyModal(window.__drawers[${id}].modifyData)">
      <i class="bi bi-pencil-fill"></i> Modify
    </button>`;
    h += `</div>`;

    h += `<hr class="drawer-divider">`;
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

  /* ── Modify Modal ── */
  const MOD_META_FIELDS = {
    appeal_fee:               ['appeal_remarks'],
    bidding_documents:        ['bid_details','bid_remarks'],
    cash_bond:                ['area_hectares','zonal_value','property_location','assessment_form','cash_bond_remarks'],
    certification_copy_fee:   ['letter_request','cert_remarks'],
    consignment:              ['consignment_assessment_form','consignment_case_no','consignment_remarks'],
    execution_judgment:       ['exec_assessment_form','exec_txn_type_paid','exec_remarks'],
    filing_fee:               ['filing_assessment_form','filing_remarks'],
    income_unserviceable:     ['rdc_resolution_no','unserviceable_remarks'],
    legal_research:           ['legal_research_remarks'],
    performance_bond:         ['pb_area_hectares','pb_zonal_value','pb_property_location','pb_assessment_form','pb_remarks'],
    refund_cash_advances:     ['check_lddap_ada','cash_advance_date','division_section','cash_advance_remarks'],
    refund_overpayment:       ['refund_division_section','refund_op_remarks'],
    settlement_disallowances: ['disallowance_no','disallowance_remarks'],
    unwithheld_remittances:   ['remit_other_specify','remit_remarks'],
  };

  let __currentModifyId = null;

  const FUND_PREFIX_MAP = {
    'F01':     'F01',
    'F03':     'F03-ARF',
    'F07':     'F07-TRUST',
    'F02-LP':  'F02-LP',
    'F02-GOP': 'F02-GOP',
  };

  function onModifyTxnChange(val) {
    document.querySelectorAll('.mod-extra').forEach(el => el.style.display = 'none');
    const target = document.getElementById('mod-extra-' + val);
    if (target) target.style.display = 'block';
  }

  function updateModOpNumber() {
    const fundVal = document.getElementById('mod-fund').value;
    if (!fundVal) return;

    fetch(`/payments/next-op?fund=${encodeURIComponent(fundVal)}&exclude=${__currentModifyId || ''}`)
      .then(r => r.ok ? r.json() : Promise.reject())
      .then(data => {
        document.getElementById('mod-op').value = data.op_number;
      })
      .catch(() => {
        const prefix = FUND_PREFIX_MAP[fundVal] || fundVal;
        const now    = new Date();
        const year   = now.getFullYear();
        const month  = String(now.getMonth() + 1).padStart(2, '0');
        document.getElementById('mod-op').value = `${prefix}-${year}-${month}-????`;
      });
  }

  function openModifyModal(data) {
    // Set form action using a relative path to avoid host/domain mismatches
    document.getElementById('modify-form').action = '/payments/' + encodeURIComponent(data.id);
    __currentModifyId = data.id;
    

    // Common fields
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

    // Show the correct extra section, hide all others
    onModifyTxnChange(data.transaction_type || '');

    // Populate meta fields
    const meta   = data.meta || {};
    const txn    = data.transaction_type || '';
    const fields = MOD_META_FIELDS[txn] || [];

    fields.forEach(key => {
      const el = document.getElementById('mod-' + key);
      if (el) el.value = (meta[key] !== undefined && meta[key] !== null) ? meta[key] : '';
    });

    // cert_type checkboxes
    if (txn === 'certification_copy_fee') {
      const saved = Array.isArray(meta.cert_type) ? meta.cert_type : [];
      ['certification', 'copy_fee', 'reproduction_cost'].forEach(v => {
        const cb = document.getElementById('mod-cert_' + v);
        if (cb) cb.checked = saved.includes(v);
      });
    }

    // remit_type checkboxes
    if (txn === 'unwithheld_remittances') {
      const saved = Array.isArray(meta.remit_type) ? meta.remit_type : [];
      ['GSIS','PHIC','HDMF','Other'].forEach(v => {
        const cb = document.getElementById('mod-remit_' + v.toLowerCase());
        if (cb) cb.checked = saved.includes(v);
      });
      const otherWrap = document.getElementById('mod-remit-other-wrap');
      if (otherWrap) otherWrap.style.display = saved.includes('Other') ? 'block' : 'none';
      const otherSpec = document.getElementById('mod-remit_other_specify');
      if (otherSpec) otherSpec.value = meta.remit_other_specify || '';
    }

    document.getElementById('modify-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeModifyModal() {
    document.getElementById('modify-modal').classList.remove('open');
    document.body.style.overflow = '';
  }

  function handleModifyOverlayClick(e) {
    if (e.target === document.getElementById('modify-modal')) closeModifyModal();
  }

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeDrawer(); closeModifyModal(); }
  });

  function esc(s) {
    if (!s) return '';
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

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
    const total    = Math.round(amount * 100);
    const pesos    = Math.floor(total / 100);
    const centavos = total % 100;
    let words = '';
    if (pesos === 0 && centavos === 0) return 'Zero Pesos Only';
    if (pesos > 0) words += say(pesos).trim() + (pesos === 1 ? ' Peso' : ' Pesos');
    if (centavos > 0) words += ' and ' + say(centavos).trim() + (centavos === 1 ? ' Centavo' : ' Centavos');
    else words += ' Only';
    return words;
  }

  /* ════════════════════════════════════════════════════
     PRINT ORDER OF PAYMENT
  ════════════════════════════════════════════════════ */
  function printOrderOfPayment() {
    const d = __active;
    if (!d) return;
    // Only approved transactions can print OP
    const st = (d.rawStatus || d.status || '').toLowerCase();
    if (st !== 'approved') {
      alert('Only approved transactions can generate an Order of Payment.');
      return;
    }
    const abbrevMap = {
      'txn':'Transaction','exec':'Execution','asmt':'Assessment','amt':'Amount',
      'no':'Number','num':'Number','ref':'Reference','dept':'Department',
      'div':'Division','sec':'Section','acct':'Account','pymnt':'Payment',
      'pymt':'Payment','pmt':'Payment','rec':'Record','yr':'Year','mo':'Month',
      'lddap':'LDDAP','ada':'ADA','ors':'ORS','bur':'Bureau','rpt':'Report','adv':'Advance',
    };
    function expandLabel(raw) {
      return raw.replace(/_/g,' ').replace(/([a-z])([A-Z])/g,'$1 $2').split(/\s+/).map(w => {
        const low = w.toLowerCase();
        return abbrevMap[low] ? abbrevMap[low] : w.charAt(0).toUpperCase()+w.slice(1).toLowerCase();
      }).join(' ');
    }
    const purposeParts = [d.txn];
    if (d.details) {
      for (const [k, v] of Object.entries(d.details)) {
        if (['Contact','Email','Payment Mode','Address'].includes(k)) continue;
        const isRemark = /remark/i.test(k);
        purposeParts.push(isRemark ? v : expandLabel(k) + ': ' + v);
      }
    }
    const purpose    = esc(purposeParts.join('  |  '));
    const amtWords   = esc(amountInWords(d.amountNum || parseFloat(d.amountRaw.replace(/,/g,'')) || 0));
    const entityName = 'Department of Agrarian Reform Regional Office 5';

    function opBlock() {
      return `
      <div class="op-wrap">
        <div class="appendix">Appendix 28</div>
        <div class="meta-grid">
          <div class="meta-line"><span class="meta-label">Entity Name&nbsp;:</span><span class="uline">${esc(entityName)}</span></div>
          <div class="meta-line"><span class="meta-label">Serial No.&nbsp;:</span><span class="uline">${esc(d.op)}</span></div>
          <div class="meta-line"><span class="meta-label">Fund Cluster&nbsp;:</span><span class="uline">${esc(d.fund)}</span></div>
          <div class="meta-line"><span class="meta-label">Date&nbsp;:</span><span class="uline">${esc(d.dateShort)}</span></div>
        </div>
        <div class="op-title">ORDER OF PAYMENT</div>
        <p>The Collecting Officer<br>Cash/Treasury Unit</p>
        <p>Please issue Official Receipt in favor of
          <span class="inline-uline">${esc(d.name)}</span>
          <span class="field-label-small">(Name of Payor)</span>
        </p>
        <p>
          <span class="inline-uline addr-line">${esc(d.address)}</span>
          <span class="field-label-small">(Address/Office of Payor)</span>
        </p>
        <div class="amount-row">
          in the amount of
          <span class="amt-field"><span class="auto-shrink">${amtWords}</span></span>
          <span>(P</span>
          <span class="peso-box">${esc(d.amountRaw)}</span>
          <span>)</span>
        </div>
        <div class="for-payment">for payment of</div>
        <div class="purpose-field">${purpose}</div>
        <div class="purpose-label">(Purpose)</div>
        <br>
        <div class="bill-row">
          per Bill No. <span class="bill-field"></span>
          &nbsp;&nbsp;dated <span class="date-field"></span>.
        </div>
        <div class="bank-intro">Please deposit the collections under Bank Account/s:</div>
        <table class="bank-table">
          <thead><tr><th class="col-no">No.</th><th class="col-name">Name of Bank</th><th class="col-amt">Amount</th></tr></thead>
          <tbody>
            <tr><td class="col-no">&nbsp;</td><td class="col-name">&nbsp;</td><td class="col-amt">P</td></tr>
            <tr><td class="col-no">&nbsp;</td><td class="col-name">&nbsp;</td><td class="col-amt">&nbsp;</td></tr>
          </tbody>
        </table>
        <div class="sig-section">
          <div class="sig-block">
            <span class="sig-name-underline">&nbsp;</span>
            <div class="sig-role-label">Division/Unit/Authorized Official</div>
          </div>
        </div>
      </div>`;
    }

    const html = `<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order of Payment — ${esc(d.name)}</title>
<style>
  @page { size: A4 landscape; margin: 10mm 12mm; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Times New Roman', Times, serif; font-size: 10pt; color: #000; background: #fff; line-height: 1.35; }
  .page-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 10mm; width: 100%; height: 100%; }
  .op-wrap { padding: 0; border-right: 1px dashed #bbb; padding-right: 8mm; }
  .op-wrap:last-child { border-right: none; padding-right: 0; padding-left: 8mm; }
  .appendix { text-align: right; font-size: 8pt; font-style: italic; margin-bottom: 3mm; }
  .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2mm 6mm; margin-bottom: 2mm; }
  .meta-line { display: flex; align-items: flex-end; gap: 4pt; font-size: 9.5pt; }
  .meta-label { white-space: nowrap; }
  .uline { border-bottom: 1px solid #000; padding: 0 2pt 1pt; flex: 1; font-size: 9.5pt; }
  .op-title { text-align: center; font-size: 13pt; font-weight: bold; letter-spacing: 1.5pt; margin: 4mm 0 5mm; }
  p { margin-bottom: 3.5mm; font-size: 10pt; }
  .inline-uline { display: inline-block; border-bottom: 1px solid #000; min-width: 140pt; padding: 0 3pt 1pt; vertical-align: bottom; font-size: clamp(7.5pt,10pt,10pt); }
  .addr-line { min-width: 200pt; }
  .field-label-small { display: block; text-align: center; font-size: 7.5pt; }
  .amount-row { display: flex; align-items: flex-end; gap: 4pt; margin-bottom: 3mm; font-size: 10pt; }
  .amount-row .amt-field { flex: 1; border-bottom: 1px solid #000; padding: 0 3pt 1pt; font-style: italic; overflow: hidden; }
  .amount-row .peso-box { border-bottom: 1px solid #000; padding: 0 3pt 1pt; min-width: 60pt; }
  .auto-shrink { display: inline-block; max-width: 100%; font-size: clamp(7pt,9.5pt,10pt); white-space: nowrap; }
  .for-payment { margin-bottom: 1.5mm; font-size: 10pt; }
  .purpose-field { border-bottom: 1px solid #000; padding: 2pt 3pt; font-size: clamp(7.5pt,10pt,10pt); min-height: 17pt; width: 100%; margin-bottom: 1pt; word-break: break-word; }
  .purpose-label { text-align: center; font-size: 7.5pt; }
  .bill-row { display: flex; align-items: flex-end; gap: 4pt; margin-bottom: 4mm; font-size: 10pt; }
  .bill-field { border-bottom: 1px solid #000; min-width: 70pt; padding: 0 3pt 1pt; display: inline-block; }
  .date-field { border-bottom: 1px solid #000; min-width: 55pt; padding: 0 3pt 1pt; display: inline-block; }
  .bank-intro { font-size: 10pt; margin-bottom: 2mm; }
  .bank-table { width: 100%; border-collapse: collapse; }
  .bank-table th { font-weight: normal; text-decoration: underline; padding: 2pt 3pt; font-size: 10pt; text-align: left; }
  .bank-table td { height: 16pt; border-bottom: 1px solid #000; padding: 1pt 3pt; font-size: 10pt; }
  .bank-table .col-no { width: 12%; }
  .bank-table .col-name { width: 55%; }
  .bank-table .col-amt { width: 33%; }
  .sig-section { margin-top: 8mm; display: flex; justify-content: flex-end; align-items: flex-end; gap: 8pt; }
  .sig-block { text-align: center; }
  .sig-name-underline { display: block; border-bottom: 2px solid #000; min-width: 160pt; padding: 0 4pt 2pt; font-size: 10pt; font-weight: bold; text-align: center; min-height: 18pt; }
  .sig-role-label { font-size: 8pt; text-align: center; margin-top: 2pt; }
  @media print { body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } }
</style>
</head>
<body>
<div class="page-grid">${opBlock()}${opBlock()}</div>
<script>window.onload=function(){window.print();window.onafterprint=function(){window.close();};};<\/script>
</body>
</html>`;

    const win = window.open('', '_blank', 'width=1100,height=800,scrollbars=yes');
    win.document.write(html);
    win.document.close();
  }
</script>

<script>
  // Poll server for payment status updates every 8 seconds
  (function pollPayments(){
    async function refresh(){
      try{
        const res = await fetch('{{ route('payments.json') }}', {cache:'no-store'});
        if (!res.ok) return;
        const list = await res.json();
        const byId = {};
        list.forEach(p => byId[p.id] = p);
        document.querySelectorAll('#table-body tr[data-id]').forEach(tr => {
          const id = tr.getAttribute('data-id');
          const d = byId[id];
          if (!d) return;
          const sb = tr.querySelector('.status-badge');
          if (sb) {
            let cls = 'sb-default', icon = 'bi-circle';
            const st = (d.status||'waiting').toLowerCase();
                  if (st === 'approved') { cls = 'sb-approved'; icon = 'bi-check-circle-fill'; }
                  else if (st === 'accountant_rejected' || st === 'rejected') { cls = 'sb-rejected'; icon = 'bi-x-circle-fill'; }
                  else if (['waiting','submitted','under_review','forwarded_to_accountant'].includes(st)) { cls = 'sb-waiting'; icon = 'bi-hourglass-split'; }
            sb.className = 'status-badge ' + cls;
            sb.innerHTML = '<i class="bi '+icon+'"></i> ' + (st.charAt(0).toUpperCase()+st.slice(1));
          }
        });
        const total = list.length;
        const sum = list.reduce((s,it)=> s + (parseFloat(it.amount||0)||0), 0);
        const awaiting = list.filter(it=> ['submitted','under_review','accountant_rejected','waiting'].includes((it.status||'waiting')) ).length;
        const approved = list.filter(it=> (it.status||'') === 'approved').length;
        const elTotal = document.getElementById('stat-total-count');  if (elTotal) elTotal.textContent = total;
        const elAmt   = document.getElementById('stat-total-amount'); if (elAmt)   elAmt.textContent = '₱' + sum.toLocaleString('en-PH',{minimumFractionDigits:2,maximumFractionDigits:2});
        const elAwait = document.getElementById('stat-awaiting-count'); if (elAwait) elAwait.textContent = awaiting;
        const elApp   = document.getElementById('stat-approved-count'); if (elApp)   elApp.textContent = approved;
        const rc = document.getElementById('record-count');
        if (rc) rc.textContent = total + ' record' + (total !== 1 ? 's' : '');
      }catch(e){ /* ignore */ }
    }
    refresh();
    setInterval(refresh, 8000);
  })();
</script>

</body>
</html>