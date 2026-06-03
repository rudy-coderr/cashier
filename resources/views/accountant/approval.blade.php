<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Accountant — For Review</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="icon" href="{{ asset('img/dar_logo_square.jpg') }}" />
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
      width: 38px; height: 38px; border-radius: 50%;
      overflow: hidden; flex-shrink: 0;
      background: transparent;
      display: flex; align-items: center; justify-content: center;
    }
    .header-seal img {
      width: 38px; height: 38px;
      object-fit: cover; border-radius: 50%; display: block;
    }

    .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }

    .header-actions { margin-left: auto; display: flex; align-items: center; gap: 8px; position: relative; }

    .notif-btn {
      position: relative; display: flex; align-items: center; justify-content: center;
      width: 44px; height: 44px; border-radius: 10px;
      background: rgba(255,255,255,.07); border: none;
      color: rgba(245,240,232,.55); cursor: pointer;
      transition: background .15s, color .15s; flex-shrink: 0;
    }
    .notif-btn:hover { background: rgba(255,255,255,.14); color: var(--cream); }
    .notif-btn i { font-size: 1.25rem; }
    .notif-badge {
      position: absolute; top: 6px; right: 6px;
      min-width: 18px; height: 18px; padding: 0 6px; border-radius: 12px;
      background: var(--red); color: #fff; font-size: .72rem; font-weight: 700;
      line-height: 18px; text-align: center; display: none; box-shadow: 0 1px 0 rgba(0,0,0,.08);
    }
    .notif-badge.show { display: inline-block; }

    .notif-dropdown {
      display: none; position: absolute; top: calc(100% + 10px); right: 0;
      width: 300px; background: var(--surface); border-radius: 12px;
      border: 1px solid var(--border); box-shadow: 0 8px 32px rgba(0,0,0,.18);
      z-index: 400; overflow: hidden;
    }
    .notif-dropdown.open { display: block; animation: dropIn .18s cubic-bezier(.16,1,.3,1); }
    @keyframes dropIn { from { opacity:0; transform: translateY(-6px); } to { opacity:1; transform:none; } }
    .notif-drop-head { padding: 12px 16px; background: var(--green-deep); display: flex; align-items: center; justify-content: space-between; }
    .notif-drop-title { font-size: .78rem; font-weight: 600; color: var(--gold-light); letter-spacing: .5px; }
    .notif-drop-mark { font-size: .68rem; color: rgba(245,240,232,.45); cursor: pointer; background: none; border: none; font-family: 'DM Sans', sans-serif; transition: color .15s; }
    .notif-drop-mark:hover { color: var(--cream); }
    .notif-list { max-height: 260px; overflow-y: auto; }
    .notif-list::-webkit-scrollbar { width: 3px; }
    .notif-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    .notif-item { display: flex; align-items: flex-start; gap: 10px; padding: 11px 16px; border-bottom: 1px solid var(--border); transition: background .12s; cursor: pointer; }
    .notif-item:last-child { border-bottom: none; }
    .notif-item.unread { background: #f5fbf7; }
    .notif-item:hover { background: #f0f7f3; }
    .notif-item-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; margin-top: 1px; }
    .ni-green { background: var(--green-light); color: var(--green-accent); }
    .ni-gold  { background: #fdf3dc; color: var(--gold); }
    .ni-red   { background: #fdf0ef; color: var(--red); }
    .notif-item-body { flex: 1; min-width: 0; }
    .notif-item-text { font-size: .78rem; color: var(--text-dark); line-height: 1.4; }
    .notif-item-time { font-size: .67rem; color: var(--muted); margin-top: 3px; }
    .notif-unread-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green-accent); flex-shrink: 0; margin-top: 6px; }
    .notif-empty { padding: 30px 16px; text-align: center; }
    .notif-empty i { font-size: 1.6rem; color: var(--border); display: block; margin-bottom: 8px; }
    .notif-empty p { font-size: .78rem; color: var(--muted); }
    .notif-drop-foot { padding: 9px 16px; border-top: 1px solid var(--border); text-align: center; }
    .notif-drop-foot a { font-size: .72rem; color: var(--green-accent); text-decoration: none; font-weight: 600; }
    .notif-drop-foot a:hover { text-decoration: underline; }

    .btn-logout {
      display: flex; align-items: center; gap: 6px; padding: 8px 16px;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      border: 1px solid rgba(201,153,42,.35); border-radius: 8px; color: var(--green-deep);
      font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: .75rem; letter-spacing: .5px;
      cursor: pointer; transition: all .18s ease; box-shadow: 0 2px 6px rgba(0,0,0,.08);
    }
    .btn-logout:hover { background: linear-gradient(135deg, #d6a73b, #f0cf7b); transform: translateY(-1px); }

    /* ── LAYOUT ── */
    .outer-wrapper { display: flex; min-height: calc(100vh - 72px); }

    /* ── SIDEBAR ── */
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
    .sidebar-footer { padding: 14px 22px; border-top: 1px solid rgba(255,255,255,.07); flex-shrink: 0; }
    .sidebar-footer-label { font-size: .6rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.3); margin-bottom: 4px; }
    .sidebar-footer-value { font-size: .73rem; color: rgba(245,240,232,.5); font-weight: 300; }

    /* ── MAIN ── */
    .main-content { flex: 1; min-width: 0; }

    /* FIX 1: Remove max-width constraint so table uses full available space */
    .page-body { width: 100%; padding: 36px 36px 60px; }

    /* ── PAGE TITLE ── */
    .page-title-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

    /* ── ALERTS ── */
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
    /* FIX 2: overflow-x: auto so table can scroll horizontally if needed, never clip */
    .table-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; }
    .table-card-scroll { overflow-x: auto; }
    .table-card-header { padding: 14px 22px; background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .table-card-title { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); display: flex; align-items: center; gap: 9px; }
    .table-record-count { font-size: .68rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; background: rgba(201,153,42,.2); color: var(--gold-light); border: 1px solid rgba(201,153,42,.25); }

    /* ── TABLE ── */
    .approvals-table { width: 100%; border-collapse: collapse; min-width: 860px; }
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

    /* ── CELL STYLES ── */
    .payor-cell { display: flex; align-items: center; gap: 10px; }
    .payor-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--green-mid); color: #fff; font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .payor-name { font-weight: 600; font-size: .87rem; color: var(--text-dark); }
    .payor-contact { font-size: .72rem; color: var(--muted); margin-top: 1px; }
    .amount-cell { font-weight: 700; font-size: .92rem; color: var(--green-mid); }
    .fund-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; background: #fdf3dc; color: var(--gold); font-size: .68rem; font-weight: 700; white-space: nowrap; }
    .op-number { font-size: .78rem; color: var(--text-mid); font-weight: 500; }
    .date-main { font-size: .82rem; color: var(--text-dark); font-weight: 500; }
    .date-time  { font-size: .7rem; color: var(--muted); margin-top: 2px; }

    /* ── STATUS BADGES ── */
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; white-space: nowrap; }
    .sb-approved { background: var(--green-light); color: var(--green-accent); }
    .sb-waiting  { background: #fdf3dc; color: #a0700a; }
    .sb-rejected { background: #fdf0ef; color: var(--red); }

    /* ── ACTION BUTTONS ── */
    /* FIX 3: actions cell never wraps, always shows both buttons */
    .actions-cell { display: flex; align-items: center; gap: 6px; flex-wrap: nowrap; }
    .btn-approve { display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; border: none; border-radius: 7px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s; white-space: nowrap; }
    .btn-approve:hover { background: var(--green-mid); }
    .btn-reject  { display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; border: 1.5px solid #e8c5c5; border-radius: 7px; background: #fdf0ef; color: var(--red); font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s, border-color .15s; white-space: nowrap; }
    .btn-reject:hover { background: #fde0de; border-color: #f0a8a8; }

    /* ── TABLE FOOTER / PAGINATION ── */
    .table-footer { padding: 12px 22px; background: #faf8f4; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .table-footer-info { font-size: .75rem; color: var(--muted); }
    .table-footer-info strong { color: var(--text-mid); }
    .pagination-wrap { display: flex; align-items: center; gap: 8px; margin-left: auto; }
    .page-link, .page-number { padding: 6px 10px; border-radius: 8px; text-decoration: none; font-weight: 700; color: var(--green-accent); border: 1px solid transparent; background: transparent; }
    .page-link.disabled { opacity: .5; pointer-events: none; color: var(--muted); }
    .page-number { color: var(--text-dark); border: 1px solid transparent; }
    .page-number:hover { background: #f2faf5; border-color: var(--border); }
    .page-number.active { background: var(--gold); color: var(--green-deep); border-color: var(--gold); }
    .page-summary { font-size: .85rem; color: var(--muted); margin-left: 12px; }

    /* ── EMPTY STATE ── */
    .empty-row td { padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 2.4rem; color: var(--border); margin-bottom: 12px; }
    .empty-text { font-size: .85rem; color: var(--muted); }

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
      .notif-dropdown { right: -60px; width: 280px; }
    }
    @media (max-width: 640px) {
      .stat-row { grid-template-columns: 1fr 1fr; }
    }
    .header-user-wrap { position: relative; }
.header-user { display: flex; align-items: center; gap: 10px; padding: 6px 12px 6px 8px; background: rgba(245,240,232,.07); border: 1px solid rgba(245,240,232,.12); border-radius: 10px; cursor: pointer; transition: background .15s, border-color .15s; user-select: none; }
.header-user:hover { background: rgba(245,240,232,.13); border-color: rgba(245,240,232,.22); }
.header-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-light)); display: flex; align-items: center; justify-content: center; font-size: .72rem; font-weight: 700; color: var(--green-deep); overflow: hidden; flex-shrink: 0; border: 2px solid rgba(201,153,42,.35); }
.header-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
.header-user-name { font-size: .76rem; font-weight: 600; color: var(--cream); line-height: 1.2; }
.header-user-role { font-size: .6rem; color: rgba(245,240,232,.4); letter-spacing: .8px; text-transform: uppercase; }
.header-user-caret { font-size: .65rem; color: rgba(245,240,232,.4); margin-left: 2px; transition: transform .2s; }
.header-user-wrap.open .header-user-caret { transform: rotate(180deg); }
.header-dropdown { position: absolute; top: calc(100% + 8px); right: 0; min-width: 200px; background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; box-shadow: 0 8px 28px rgba(14,42,26,.18); overflow: hidden; opacity: 0; pointer-events: none; transform: translateY(-6px); transition: opacity .18s ease, transform .18s ease; z-index: 300; }
.header-user-wrap.open .header-dropdown { opacity: 1; pointer-events: all; transform: translateY(0); }
.dropdown-header { padding: 14px 16px 10px; border-bottom: 1px solid var(--border); }
.dropdown-header-name { font-size: .84rem; font-weight: 700; color: var(--text-dark); }
.dropdown-header-email { font-size: .72rem; color: var(--muted); margin-top: 2px; }
.dropdown-item { display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: .81rem; font-weight: 600; color: var(--text-mid); text-decoration: none; cursor: pointer; transition: background .13s; border: none; background: none; width: 100%; text-align: left; font-family: 'DM Sans', sans-serif; }
.dropdown-item:hover { background: var(--bg); }
.dropdown-item i { font-size: 1rem; flex-shrink: 0; }
.dropdown-item.danger { color: var(--red); }
.dropdown-item.danger:hover { background: #fdf0ef; }
.dropdown-divider { border: none; border-top: 1px solid var(--border); margin: 4px 0; }

    /* ── DRAWER ── */
    .drawer-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 500; }
    .drawer-overlay.open { display: block; }
    .detail-drawer { position: fixed; top: 0; right: 0; width: 440px; max-width: 100vw; height: 100vh; background: var(--surface); box-shadow: -8px 0 40px rgba(0,0,0,.18); display: flex; flex-direction: column; transform: translateX(100%); transition: transform .28s cubic-bezier(.16,1,.3,1); z-index: 501; }
    .detail-drawer.open { transform: translateX(0); }
    .drawer-head { padding: 16px 22px; background: var(--green-deep); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
    .drawer-head-title { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700; color: var(--gold-light); }
    .drawer-close-btn { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,.07); border: none; color: rgba(245,240,232,.5); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1rem; transition: background .15s, color .15s; }
    .drawer-close-btn:hover { background: rgba(255,255,255,.14); color: var(--cream); }
    .drawer-body { flex: 1; overflow-y: auto; padding: 20px 22px; }
    .drawer-body::-webkit-scrollbar { width: 3px; }
    .drawer-body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    .drawer-actions { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
    .drawer-action-approve { display: inline-flex; align-items: center; gap: 5px; padding: 8px 16px; border: none; border-radius: 8px; background: var(--green-accent); color: #fff; font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .drawer-action-approve:hover { background: var(--green-mid); }
    .drawer-action-modify { display: inline-flex; align-items: center; gap: 5px; padding: 8px 16px; border: 1.5px solid var(--border); border-radius: 8px; background: #f5fbf7; color: var(--green-accent); font-family: 'DM Sans', sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .15s; }
    .drawer-action-modify:hover { background: var(--green-light); }
    .drawer-divider { border: none; border-top: 1px solid var(--border); margin: 16px 0; }
    .drawer-section-title { font-size: .76rem; font-weight: 700; color: var(--green-accent); letter-spacing: 1px; text-transform: uppercase; display: flex; align-items: center; gap: 8px; margin-bottom: 12px; margin-top: 8px; }
    .drawer-section-title i { font-size: .9rem; }
    .drawer-field { margin-bottom: 12px; }
    .drawer-field-label { font-size: .68rem; color: var(--muted); font-weight: 700; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 4px; }
    .drawer-field-value { font-size: .84rem; color: var(--text-dark); font-weight: 500; line-height: 1.5; }
    .action-btn { width: 29px; height: 29px; border-radius: 7px; border: 1.5px solid var(--border); background: #faf8f4; color: var(--text-mid); display: inline-flex; align-items: center; justify-content: center; font-size: .83rem; cursor: pointer; transition: background .15s, border-color .15s, color .15s; text-decoration: none; flex-shrink: 0; }
    .action-btn:hover { background: var(--green-light); border-color: var(--green-accent); color: var(--green-accent); }
    @media (max-width: 768px) { .detail-drawer { width: 100vw; } }

  </style>
</head>
<body>

@php
  $authUser    = auth()->user();
  $displayName = trim(($authUser->first_name ?? '') . ' ' . ($authUser->last_name ?? '')) ?: ($authUser->name ?? 'Administrator');
  $sidebarInitials = strtoupper(substr($displayName, 0, 2));
@endphp

<div class="top-stripe"></div>

<header class="page-header">
  <div class="header-seal">
    <img src="{{ asset('img/dar_logo_square.jpg') }}" alt="DAR logo" />
  </div>
  <div class="header-text">
    <div class="t1">Republic of the Philippines</div>
    <div class="t2">Department of Agrarian Reform</div>
  </div>
  <div class="header-sep"></div>
  <div class="header-page">For Review</div>
<div class="header-actions">

    <!-- Notification -->
    <div class="notif-wrapper">
        <button 
            class="notif-btn" 
            id="notif-btn"
            onclick="toggleNotifDropdown(event)"
            title="Notifications"
        >
            <i class="bi bi-bell"></i>
            <span class="notif-badge" id="notif-badge">3</span>
        </button>

        <!-- Notification Dropdown -->
        <div class="notif-dropdown" id="notif-dropdown">

            <div class="notif-drop-head">
                <span class="notif-drop-title">Notifications</span>

                <button 
                    class="notif-drop-mark"
                    onclick="markAllRead()"
                >
                    Mark all as read
                </button>
            </div>

            <div class="notif-list" id="notif-list">

                <div class="notif-item unread">
                    New appointment request received
                </div>

                <div class="notif-item unread">
                    Payment has been confirmed
                </div>

                <div class="notif-item">
                    System backup completed
                </div>

            </div>

            <div class="notif-drop-foot">
              <a href="{{ route('accountant.notifications.page') }}">View all notifications</a>
            </div>

        </div>
    </div>

    <!-- User -->
    <div class="header-user-wrap" id="headerUserWrap">

        <!-- Trigger chip -->
        <div class="header-user" onclick="toggleHeaderDropdown()">

            <div class="header-avatar">
                @if(!empty($authUser->profile_picture) && \Illuminate\Support\Facades\Storage::disk('public')->exists($authUser->profile_picture))
                    <img src="{{ asset('storage/' . $authUser->profile_picture) }}" alt="{{ $displayName }}">
                @else
                    {{ $sidebarInitials }}
                @endif
            </div>

            <div>
                <div class="header-user-name">{{ $displayName }}</div>

                <div class="header-user-role">
                    {{ ucfirst($authUser->position ?? $authUser->role ?? 'Admin') }}
                </div>
            </div>

            <i class="bi bi-chevron-down header-user-caret"></i>
        </div>

        <!-- Dropdown -->
        <div class="header-dropdown">

            <div class="dropdown-header">
                <div class="dropdown-header-name">{{ $displayName }}</div>

                <div class="dropdown-header-email">
                    {{ $authUser->email ?? '' }}
                </div>
            </div>

            <a class="dropdown-item" href="{{ route('accountant.profile') }}">
                <i class="bi bi-person-circle"></i>
                My Profile
            </a>

            <div class="dropdown-divider"></div>

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf

                <button type="submit" class="dropdown-item danger">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>

        </div>
    </div>

</div>


</header>

<div class="outer-wrapper">

  <aside class="sidebar">
    <div class="sidebar-inner">
      <div class="sidebar-profile">
        <div class="profile-avatar">{{ strtoupper(substr($displayName ?? 'AC', 0, 2)) }}</div>
        <div>
          <div class="profile-name">{{ $displayName ?? 'Accountant User' }}</div>
          <div class="profile-role">Accountant</div>
        </div>
      </div>
      <hr class="sidebar-divider">

      <div class="nav-section-label" style="margin-top:16px;">Transactions</div>
      <a class="nav-item active" href="{{ route('accountant.approval') }}">
        <div class="nav-icon"><i class="bi bi-hourglass-split"></i></div>
        <span class="nav-label">For Review</span>
      </a>
      <a class="nav-item" href="{{ route('accountant.approved') }}">
        <div class="nav-icon"><i class="bi bi-check2-circle"></i></div>
        <span class="nav-label">Approved Records</span>
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

      <div class="page-title-row">
        <div>
          <div class="page-title">Accountant — Approval Queue</div>
          <div class="page-sub">Department of Agrarian Reform — Regional Office V</div>
        </div>
      </div>

      @php
        $displayName = trim((auth()->user()->first_name ?? '') . ' ' . (auth()->user()->last_name ?? '')) ?: (auth()->user()->name ?? 'Accountant');
        $total    = $total ?? ($payments->total() ?? count($payments));
        $waiting  = $waiting ?? $payments->whereIn('status', ['forwarded', 'accountant_rejected'])->count();
        $approved = $approved ?? \App\Models\Payment::where('status', 'approved')->count();
        $rejected = $rejected ?? 0;
      @endphp

      <!-- STAT CARDS -->
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

      <!-- TOOLBAR -->
      <form id="filter-form" class="toolbar" method="GET" action="{{ route('accountant.approval') }}">
        <div class="search-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="tbl-search" name="search" value="{{ request('search','') }}" placeholder="Search by payor name or O.P. number…" onkeydown="if(event.key==='Enter'){this.form.submit();}"/>
        </div>
        <select class="filter-select" id="filter-status" name="status" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
          <option value="forwarded" {{ request('status')=='forwarded' ? 'selected' : '' }}>Waiting</option>
          <option value="accountant_rejected" {{ request('status')=='accountant_rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <select class="filter-select" id="filter-fund" name="fund" onchange="this.form.submit()">
          <option value="">All Funds</option>
          @foreach(($funds ?? []) as $f)
            <option value="{{ $f }}" {{ request('fund') == $f ? 'selected' : '' }}>{{ $f }}</option>
          @endforeach
        </select>
      </form>

      <!-- TABLE -->
      <div class="table-card">
        <div class="table-card-header">
          <div class="table-card-title">
            <i class="bi bi-clipboard2-check"></i> Transactions for Review
          </div>
          <span class="table-record-count" id="record-count">{{ $total ?? ($payments->total() ?? count($payments)) }} record{{ ($total ?? ($payments->total() ?? count($payments))) !== 1 ? 's' : '' }}</span>
        </div>

        <div class="table-card-scroll">
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
                    'approved'            => 'sb-approved',
                    'forwarded'           => 'sb-waiting',
                    'under_review'        => 'sb-waiting',
                    'submitted'           => 'sb-waiting',
                    'accountant_rejected' => 'sb-rejected',
                    'rejected'            => 'sb-rejected',
                  ];
                  $statusCls  = $statusMap[$status] ?? 'sb-waiting';
                  $statusIcon = match($status) {
                    'approved'                        => 'bi-check-circle-fill',
                    'accountant_rejected', 'rejected' => 'bi-x-circle-fill',
                    default                           => 'bi-hourglass-split',
                  };
                  $nameParts = explode(' ', trim($p->name));
                  $initials  = strtoupper(substr($nameParts[0], 0, 1)) . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '');
                  
                  // Drawer data
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
                      <a href="#" class="action-btn" title="View" onclick="openDrawer({{ $p->id }});return false;"><i class="bi bi-eye"></i></a>
                      @if($status !== 'approved')
                        <form method="POST" action="{{ route('accountant.approve', $p->id) }}"
                          onsubmit="return confirm('Approve payment from {{ addslashes($p->name) }} (₱{{ number_format($p->amount, 2) }})?')">
                          @csrf
                          <button type="submit" class="btn-approve"><i class="bi bi-check-lg"></i> Approve</button>
                        </form>
                      @endif
                      @if($status !== 'accountant_rejected')
                        <form method="POST" action="{{ route('accountant.reject', $p->id) }}"
                          onsubmit="var r=prompt('Enter rejection remarks (optional):');if(r===null)return false;this.querySelector('input[name=remarks]').value=r;return confirm('Reject payment from {{ addslashes($p->name) }} (₱{{ number_format($p->amount, 2) }})?')">
                          @csrf
                          <input type="hidden" name="remarks" value=""/>
                          <button type="submit" class="btn-reject"><i class="bi bi-x-lg"></i> Reject</button>
                        </form>
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
                  dateShort: @json($p->created_at->format('m/d/Y')), details: @json($details)
                };
              </script>
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
        </div>

        <div class="table-footer">
          <span class="table-footer-info" id="footer-info">
            Showing <strong>{{ $payments->count() }}</strong>
            of <strong>{{ $total ?? ($payments->total() ?? count($payments)) }}</strong> records
          </span>

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

              <div class="page-summary">Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} results</div>
            </div>
          @endif
        </div>
      </div>

    </div>
  </main>
</div>

<script>

  const headerWrap = document.getElementById('headerUserWrap');

  function toggleHeaderDropdown() {
    headerWrap.classList.toggle('open');
  }

  document.addEventListener('click', function(e) {
    if (!headerWrap.contains(e.target)) {
      headerWrap.classList.remove('open');
    }
  });

  /* ── NOTIFICATIONS ── */
  const NOTIF_DATA = {!! json_encode($notif_data ?? []) !!};
  let notifOpen = false;

  function timeAgo(iso) {
    try {
      if (!iso) return '';
      const then = new Date(iso);
      const now = new Date();
      const s = Math.floor((now - then) / 1000);
      if (s < 5) return 'just now';
      if (s < 60) return s + ' seconds ago';
      const m = Math.floor(s/60);
      if (m < 60) return m + (m===1 ? ' minute ago' : ' minutes ago');
      const h = Math.floor(m/60);
      if (h < 24) return h + (h===1 ? ' hour ago' : ' hours ago');
      const d = Math.floor(h/24);
      return d + (d===1 ? ' day ago' : ' days ago');
    } catch(e) { return '' }
  }

  function renderNotifList() {
    const list = document.getElementById('notif-list');
    const unreadCount = NOTIF_DATA.filter(n => n.unread).length;
    const badge = document.getElementById('notif-badge');
    if (unreadCount > 0) {
      badge.classList.add('show');
      badge.textContent = unreadCount > 99 ? '99+' : String(unreadCount);
      badge.setAttribute('title', unreadCount + ' unread notifications');
    } else {
      badge.classList.remove('show');
      badge.textContent = '';
      badge.removeAttribute('title');
    }
    if (NOTIF_DATA.length === 0) {
      list.innerHTML = '<div class="notif-empty"><i class="bi bi-bell-slash"></i><p>No notifications yet.</p></div>';
      return;
    }
    list.innerHTML = NOTIF_DATA.map(n => {
      const t = n.ts ? timeAgo(n.ts) : (n.time || '');
      return `<div class="notif-item${n.unread ? ' unread' : ''}" onclick="readNotif('${n.id}')">
        <div class="notif-item-icon ${n.cls}"><i class="bi ${n.icon}"></i></div>
        <div class="notif-item-body">
          <div class="notif-item-text">${n.text}</div>
          <div class="notif-item-time">${t}</div>
        </div>
        ${n.unread ? '<div class="notif-unread-dot"></div>' : ''}
      </div>`;
    }).join('');
  }

  function readNotif(id) {
    fetch('{{ url('/accountant/notifications') }}/' + id + '/read', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      credentials: 'same-origin'
    }).then(r => { if (!r.ok) throw new Error('network'); return r.json(); }).then(data => {
      const n = NOTIF_DATA.find(x => x.id === id);
      if (n) n.unread = false;
      renderNotifList();
    }).catch(err => { console.warn('Failed to mark notif read', err); const n = NOTIF_DATA.find(x => x.id === id); if (n) n.unread = false; renderNotifList(); });
  }

  function markAllRead() {
    fetch('{{ route('accountant.notifications.mark_all') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      credentials: 'same-origin'
    }).then(r => { if (!r.ok) throw new Error('network'); return r.json(); }).then(json => {
      if (json && json.ok) {
        NOTIF_DATA.forEach(n => n.unread = false);
        renderNotifList();
      }
    }).catch(err => { console.warn('Failed to mark all read', err); NOTIF_DATA.forEach(n => n.unread = false); renderNotifList(); });
  }

  function toggleNotifDropdown(e) {
    e.stopPropagation();
    const dropdown = document.getElementById('notif-dropdown');
    notifOpen = !notifOpen;
    if (notifOpen) { dropdown.classList.add('open'); renderNotifList(); }
    else dropdown.classList.remove('open');
  }

  document.addEventListener('click', function(e) {
    const btn = document.getElementById('notif-btn');
    const dropdown = document.getElementById('notif-dropdown');
    if (notifOpen && !btn.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.remove('open');
      notifOpen = false;
    }
  });

  window.addEventListener('load', function() {
    const unreadCount = NOTIF_DATA.filter(n => n.unread).length;
    const badge = document.getElementById('notif-badge');
    if (unreadCount > 0) {
      badge.classList.add('show');
      badge.textContent = unreadCount > 99 ? '99+' : String(unreadCount);
      badge.setAttribute('title', unreadCount + ' unread notifications');
    } else {
      badge.classList.remove('show');
      badge.textContent = '';
    }
  });

  /* ── TABLE FILTER ── */
  function filterTable() {
    const form = document.getElementById('filter-form'); if (form) form.submit();
  }

  /* ─── ESCAPE KEY TO CLOSE DRAWER ─── */
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  (function(){
    try {
      const logoutForms = document.querySelectorAll('form[action="{{ route('logout') }}"]');
      logoutForms.forEach(f => f.addEventListener('submit', function(ev){
        ev.preventDefault();
        Swal.fire({
          title: 'Log out?',
          text: 'Are you sure you want to log out?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, log out',
          cancelButtonText: 'Cancel'
        }).then(result => { if (result.isConfirmed) f.submit(); });
      }));
    } catch (e) {}
  })();
</script>

<!-- ══ DETAIL DRAWER ══ -->
<div class="drawer-overlay" id="drawer-overlay" onclick="closeDrawer()"></div>
<div class="detail-drawer" id="detail-drawer">
  <div class="drawer-head">
    <div>
      <div class="drawer-head-title" id="drawer-payor-name">Payment Details</div>
    </div>
    <button type="button" class="drawer-close-btn" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
  </div>
  <div class="drawer-body" id="drawer-body"></div>
</div>

<script>
  /* ─── DRAWER ─── */
  let __active = null;
  function openDrawer(id) {
    const d = window.__drawers?.[id]; if (!d) return;
    __active = d;
    document.getElementById('drawer-payor-name').textContent = d.name;
    let h = `<div class="status-badge ${d.statusCls}" style="margin-bottom:16px;font-size:.74rem;padding:5px 13px;"><i class="bi ${d.statusIcon}"></i> ${d.status}</div>`;
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
</script>

</body>
</html>
