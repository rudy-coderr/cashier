<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Transaction — DAR Cashier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="icon" href="{{ asset('img/dar-logo.png') }}" />

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

    .header-back {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: .78rem;
      color: rgba(245,240,232,.45);
      text-decoration: none;
      transition: color .18s;
    }
    .header-back:hover { color: var(--cream); }

    /* ── OUTER WRAPPER ── */
    .outer-wrapper {
      display: flex;
      min-height: calc(100vh - 72px);
    }

    /* ── SIDEBAR ── */
    .sidebar {
      width: 270px;
      flex-shrink: 0;
      background: var(--green-deep);
      display: flex;
      flex-direction: column;
      border-right: 1px solid rgba(255,255,255,.07);
      position: sticky;
      top: 72px;
      height: calc(100vh - 72px);
      overflow-y: auto;
    }

    .sidebar::-webkit-scrollbar { width: 3px; }
    .sidebar::-webkit-scrollbar-track { background: transparent; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }

    .sidebar-inner { padding: 28px 0 40px; display: flex; flex-direction: column; flex: 1; }

    /* Step badge in sidebar */
    .sidebar-step-badge {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 0 22px;
      margin-bottom: 18px;
    }

    .sidebar-step-num {
      width: 22px; height: 22px;
      border-radius: 50%;
      background: var(--gold);
      color: var(--green-deep);
      font-size: .68rem;
      font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }

    .sidebar-step-label {
      font-size: .65rem;
      font-weight: 600;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: rgba(245,240,232,.45);
    }

    .sidebar-title {
      padding: 0 22px;
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--gold-light);
      margin-bottom: 6px;
      line-height: 1.3;
    }

    .sidebar-sub {
      padding: 0 22px;
      font-size: .72rem;
      color: rgba(245,240,232,.35);
      font-weight: 300;
      margin-bottom: 22px;
      line-height: 1.5;
    }

    .sidebar-divider {
      border: none;
      border-top: 1px solid rgba(255,255,255,.07);
      margin: 0 22px 20px;
    }

    /* Fund items */
    .fund-list { flex: 1; }

    .fund-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 22px;
      cursor: pointer;
      transition: background .15s;
      border-left: 3px solid transparent;
      position: relative;
    }

    .fund-item:hover { background: rgba(255,255,255,.04); }

    .fund-item.active {
      background: rgba(45,122,79,.18);
      border-left-color: var(--gold);
    }

    .fund-dot {
      width: 34px; height: 34px;
      border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
      font-size: .78rem;
      font-weight: 700;
      flex-shrink: 0;
      transition: background .15s, color .15s;
    }

    .fund-item:not(.active) .fund-dot {
      background: rgba(255,255,255,.07);
      color: rgba(245,240,232,.55);
    }

    .fund-item.active .fund-dot {
      background: var(--gold);
      color: var(--green-deep);
    }

    .fund-info { flex: 1; min-width: 0; }

    .fund-name {
      font-size: .82rem;
      font-weight: 600;
      color: rgba(245,240,232,.8);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      transition: color .15s;
    }

    .fund-item.active .fund-name { color: var(--cream); }

    .fund-tag {
      font-size: .65rem;
      color: rgba(245,240,232,.3);
      margin-top: 2px;
      font-weight: 300;
      letter-spacing: .3px;
    }

    .fund-item.active .fund-tag { color: rgba(245,240,232,.5); }

    .fund-check {
      font-size: .9rem;
      color: var(--gold);
      opacity: 0;
      transition: opacity .15s;
    }

    .fund-item.active .fund-check { opacity: 1; }

    /* Selected fund indicator in sidebar footer */
    .sidebar-footer {
      padding: 16px 22px;
      border-top: 1px solid rgba(255,255,255,.07);
      margin-top: auto;
    }

    .sidebar-footer-label {
      font-size: .6rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: rgba(245,240,232,.3);
      margin-bottom: 4px;
    }

    .sidebar-footer-value {
      font-size: .8rem;
      font-weight: 600;
      color: var(--gold-light);
      min-height: 18px;
    }

    .sidebar-proceed-btn {
      width: 100%;
      margin-top: 12px;
      padding: 10px 14px;
      background: var(--gold);
      border: none;
      border-radius: 8px;
      color: var(--green-deep);
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: .75rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: background .15s, transform .12s;
      opacity: .4;
      pointer-events: none;
    }

    .sidebar-proceed-btn.enabled {
      opacity: 1;
      pointer-events: all;
    }

    .sidebar-proceed-btn.enabled:hover {
      background: var(--gold-light);
      transform: translateY(-1px);
    }

    /* ── MAIN CONTENT ── */
    .main-content {
      flex: 1;
      padding: 0 32px 60px;
      min-width: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .main-inner {
      width: 100%;
      max-width: 640px;
      padding-top: 40px;
    }

    /* Fund gate overlay */
    .fund-gate {
      text-align: center;
      padding: 80px 20px;
    }

    .fund-gate-icon {
      font-size: 2.8rem;
      color: var(--border);
      margin-bottom: 14px;
    }

    .fund-gate-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--text-mid);
      margin-bottom: 8px;
    }

    .fund-gate-sub {
      font-size: .82rem;
      color: var(--muted);
      font-weight: 300;
      max-width: 320px;
      margin: 0 auto;
      line-height: 1.6;
    }

    /* Selected fund banner (shown above form) */
    /* Sticky fund banner wrapper — full width across main area */
    .fund-banner-sticky-wrap {
      display: none;
      position: sticky;
      top: 72px;
      z-index: 50;
      width: 100%;
      background: var(--green-deep);
      border-bottom: 1px solid rgba(255,255,255,.08);
      padding: 10px 32px;
    }

    .fund-banner-sticky-wrap.show { display: block; }

    .fund-banner {
      display: flex;
      align-items: center;
      gap: 12px;
      max-width: 640px;
      margin: 0 auto;
    }

    .fund-banner-icon {
      width: 36px; height: 36px;
      border-radius: 8px;
      background: var(--gold);
      display: flex; align-items: center; justify-content: center;
      font-size: .85rem;
      font-weight: 700;
      color: var(--green-deep);
      flex-shrink: 0;
    }

    .fund-banner-info { flex: 1; }

    .fund-banner-label {
      font-size: .6rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: rgba(245,240,232,.4);
      margin-bottom: 2px;
    }

    .fund-banner-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1rem;
      font-weight: 700;
      color: var(--gold-light);
    }

    .fund-banner-change {
      font-size: .72rem;
      color: rgba(245,240,232,.4);
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 4px;
      transition: color .15s;
      background: none;
      border: none;
      font-family: 'DM Sans', sans-serif;
    }

    .fund-banner-change:hover { color: var(--cream); }

    .page-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 4px;
    }

    .page-sub {
      font-size: .82rem;
      color: var(--muted);
      font-weight: 300;
      margin-bottom: 28px;
    }

    /* Step indicator */
    .step-indicator {
      display: flex;
      align-items: center;
      gap: 0;
      margin-bottom: 28px;
    }

    .step-ind-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .step-ind-num {
      width: 24px; height: 24px;
      border-radius: 50%;
      font-size: .7rem;
      font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      transition: background .2s, color .2s;
    }

    .step-ind-item.done .step-ind-num {
      background: var(--green-accent);
      color: #fff;
    }

    .step-ind-item.active .step-ind-num {
      background: var(--green-mid);
      color: #fff;
    }

    .step-ind-item.inactive .step-ind-num {
      background: var(--border);
      color: var(--muted);
    }

    .step-ind-text {
      font-size: .72rem;
      font-weight: 600;
      letter-spacing: .5px;
      text-transform: uppercase;
    }

    .step-ind-item.done .step-ind-text { color: var(--green-accent); }
    .step-ind-item.active .step-ind-text { color: var(--text-mid); }
    .step-ind-item.inactive .step-ind-text { color: var(--muted); }

    .step-ind-line {
      flex: 1;
      height: 1px;
      background: var(--border);
      margin: 0 12px;
      max-width: 40px;
    }

    /* ── SELECT CARD ── */
    .select-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 14px;
      padding: 28px;
    }

    .step-label {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 14px;
    }

    .step-num {
      width: 26px; height: 26px;
      border-radius: 50%;
      background: var(--green-mid);
      color: #fff;
      font-size: .72rem;
      font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }

    .step-text {
      font-size: .72rem;
      font-weight: 600;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--text-mid);
    }

    .select-wrap { position: relative; }

    .select-wrap select {
      width: 100%;
      padding: 13px 44px 13px 16px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: .95rem;
      color: var(--text-dark);
      background: #faf8f4;
      outline: none;
      appearance: none;
      -webkit-appearance: none;
      cursor: pointer;
      transition: border-color .2s, box-shadow .2s;
    }

    .select-wrap select:focus {
      border-color: var(--green-accent);
      box-shadow: 0 0 0 3px rgba(45,122,79,.1);
      background: #fff;
    }

    .select-wrap::after {
      content: '\F282';
      font-family: 'bootstrap-icons';
      position: absolute;
      right: 16px; top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      pointer-events: none;
      font-size: 1rem;
    }

    /* ── FORM CARD ── */
    .form-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
      margin-top: 20px;
      max-height: 0;
      opacity: 0;
      pointer-events: none;
      transition: max-height .5s cubic-bezier(.16,1,.3,1), opacity .35s ease;
    }

    .form-card.visible {
      max-height: 3000px;
      opacity: 1;
      pointer-events: all;
    }

    .form-header {
      padding: 18px 28px;
      background: linear-gradient(90deg, var(--green-mid), var(--green-deep));
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .form-header-seal {
      width: 46px; height: 46px;
      border-radius: 50%;
      background: rgba(255,255,255,.1);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem;
      flex-shrink: 0;
    }

    .form-header-info .org {
      font-size: .6rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: rgba(245,240,232,.4);
      font-weight: 300;
    }

    .form-header-info .txn-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--gold-light);
    }

    .required-note {
      padding: 9px 28px;
      font-size: .74rem;
      color: var(--red);
      background: #fff9f8;
      border-bottom: 1px solid #f5e0de;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    /* ── FORM BODY ── */
    .form-body { padding: 28px; }

    .section-heading {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--text-mid);
      margin-bottom: 20px;
    }

    .section-heading i { color: var(--green-accent); }

    .field { margin-bottom: 16px; }

    .field label {
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: .82rem;
      font-weight: 500;
      color: var(--text-mid);
      margin-bottom: 6px;
    }

    .req { color: var(--red); font-size: .85rem; line-height: 1; }

    .field input,
    .field select,
    .field textarea {
      width: 100%;
      padding: 10px 14px;
      border: 1.5px solid var(--border);
      border-radius: 8px;
      font-family: 'DM Sans', sans-serif;
      font-size: .9rem;
      color: var(--text-dark);
      background: #faf8f4;
      outline: none;
      transition: border-color .2s, box-shadow .2s, background .2s;
      appearance: none;
    }

    .field textarea { resize: vertical; min-height: 72px; }

    .field input:focus,
    .field select:focus,
    .field textarea:focus {
      border-color: var(--green-accent);
      box-shadow: 0 0 0 3px rgba(45,122,79,.1);
      background: #fff;
    }

    .field input::placeholder,
    .field textarea::placeholder { color: #b5c4ba; }

    .field-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .amount-wrap { position: relative; }
    .amount-wrap span {
      position: absolute;
      left: 12px; top: 50%;
      transform: translateY(-50%);
      font-size: .88rem;
      color: var(--muted);
      font-weight: 500;
      pointer-events: none;
    }
    .amount-wrap input { padding-left: 28px; }

    .sel-wrap { position: relative; }
    .sel-wrap::after {
      content: '\F282';
      font-family: 'bootstrap-icons';
      position: absolute;
      right: 13px; top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      pointer-events: none;
    }
    .sel-wrap select { padding-right: 36px; }

    .extra-fields { display: none; }
    .extra-fields.show { display: block; }

    .extra-divider {
      border: none;
      border-top: 1px solid var(--green-light);
      margin: 4px 0 16px;
    }

    .extra-label {
      font-size: .68rem;
      font-weight: 600;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--green-accent);
      margin-bottom: 14px;
    }

    .form-divider {
      border: none;
      border-top: 1px dashed var(--border);
      margin: 22px 0;
    }

    .terms-block {
      background: #faf8f4;
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 14px 16px;
      margin-bottom: 14px;
    }

    .terms-block label {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: .82rem;
      color: var(--text-mid);
      cursor: pointer;
      line-height: 1.55;
    }

    .terms-block input[type="checkbox"] {
      accent-color: var(--green-accent);
      width: 15px; height: 15px;
      flex-shrink: 0;
      margin-top: 2px;
      cursor: pointer;
    }

    .terms-block a { color: var(--green-accent); text-decoration: underline; }

    .review-note {
      font-size: .78rem;
      color: var(--red);
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .btn-submit {
      width: 100%;
      padding: 14px;
      background: var(--green-mid);
      border: none;
      border-radius: 9px;
      color: #fff;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      font-size: .9rem;
      letter-spacing: 2px;
      text-transform: uppercase;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: background .15s, transform .12s, box-shadow .15s;
      box-shadow: 0 5px 20px rgba(26,74,46,.3);
    }

    .btn-submit::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.1), transparent 55%);
      pointer-events: none;
    }

    .btn-submit:hover:not(:disabled) {
      background: var(--green-accent);
      transform: translateY(-2px);
      box-shadow: 0 9px 28px rgba(26,74,46,.38);
    }

    .btn-submit:active:not(:disabled) { transform: translateY(0); }

    .btn-submit:disabled {
      opacity: .45;
      cursor: not-allowed;
    }

    /* ── Sections shown/hidden ── */
    #section-gate   { display: block; }
    #section-form   { display: none; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }

      .sidebar {
        width: 100%;
        height: auto;
        position: static;
        flex-direction: row;
        overflow-x: auto;
        overflow-y: hidden;
        border-right: none;
        border-bottom: 1px solid rgba(255,255,255,.07);
      }

      .sidebar-inner {
        flex-direction: row;
        align-items: center;
        padding: 12px 16px;
        gap: 8px;
        width: max-content;
      }

      .sidebar-step-badge,
      .sidebar-title,
      .sidebar-sub,
      .sidebar-divider,
      .sidebar-footer { display: none; }

      .fund-list {
        display: flex;
        flex-direction: row;
        gap: 6px;
      }

      .fund-item {
        padding: 9px 14px;
        border-left: none;
        border-bottom: 2px solid transparent;
        border-radius: 8px;
        white-space: nowrap;
      }

      .fund-item.active {
        background: rgba(45,122,79,.2);
        border-bottom-color: var(--gold);
      }

      .fund-dot { width: 28px; height: 28px; font-size: .7rem; }
      .fund-check { font-size: .75rem; }

      .main-content { padding: 0 16px 48px; }
      .fund-banner-sticky-wrap { padding: 10px 16px; top: 0; }
    }

    @media (max-width: 560px) {
      .field-row { grid-template-columns: 1fr; }
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
    <div class="header-page">New Transaction</div>
    <a href="{{ url()->previous() }}" class="header-back">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </header>

  <div class="outer-wrapper">

    <!-- ══════════════ SIDEBAR ══════════════ -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-inner">

        <div class="sidebar-step-badge">
          <div class="sidebar-step-num">1</div>
          <div class="sidebar-step-label">Select Fund</div>
        </div>

        <div class="sidebar-title">Choose a Fund</div>
        <div class="sidebar-sub">Select the fund this transaction will be processed under before continuing.</div>

        <hr class="sidebar-divider">

        <div class="fund-list">

          <div class="fund-item" data-fund="fund1" data-label="Funds 1 RO1 — Regular" onclick="selectFund(this)">
            <div class="fund-dot">F1</div>
            <div class="fund-info">
              <div class="fund-name">Funds 1 RO1</div>
              <div class="fund-tag">Regular</div>
            </div>
            <i class="bi bi-check-circle-fill fund-check"></i>
          </div>

          <div class="fund-item" data-fund="fund2" data-label="Funds 2 — ARF" onclick="selectFund(this)">
            <div class="fund-dot">F2</div>
            <div class="fund-info">
              <div class="fund-name">Funds 2</div>
              <div class="fund-tag">ARF</div>
            </div>
            <i class="bi bi-check-circle-fill fund-check"></i>
          </div>

          <div class="fund-item" data-fund="fund3" data-label="Funds 3 — Split LPG" onclick="selectFund(this)">
            <div class="fund-dot">F3</div>
            <div class="fund-info">
              <div class="fund-name">Funds 3</div>
              <div class="fund-tag">Split LPG</div>
            </div>
            <i class="bi bi-check-circle-fill fund-check"></i>
          </div>

          <div class="fund-item" data-fund="fund4" data-label="Funds 4 — Split LP" onclick="selectFund(this)">
            <div class="fund-dot">F4</div>
            <div class="fund-info">
              <div class="fund-name">Funds 4</div>
              <div class="fund-tag">Split LP</div>
            </div>
            <i class="bi bi-check-circle-fill fund-check"></i>
          </div>

          <div class="fund-item" data-fund="fund5" data-label="Funds 5 — DAR" onclick="selectFund(this)">
            <div class="fund-dot">F5</div>
            <div class="fund-info">
              <div class="fund-name">Funds 5</div>
              <div class="fund-tag">DAR</div>
            </div>
            <i class="bi bi-check-circle-fill fund-check"></i>
          </div>

        </div><!-- /fund-list -->

        <div class="sidebar-footer">
          <div class="sidebar-footer-label">Selected Fund</div>
          <div class="sidebar-footer-value" id="sidebar-selected-label">—</div>
          <button class="sidebar-proceed-btn" id="sidebar-proceed-btn" onclick="proceedToForm()">
            <i class="bi bi-arrow-right"></i> Proceed
          </button>
        </div>

      </div><!-- /sidebar-inner -->
    </aside>

    <!-- ══════════════ MAIN ══════════════ -->
    <div style="flex:1; display:flex; flex-direction:column; min-width:0;">

      <!-- Sticky fund banner — full width, outside scroll area of form -->
      <div class="fund-banner-sticky-wrap" id="fund-banner-wrap">
        <div class="fund-banner" id="fund-banner">
          <div class="fund-banner-icon" id="fund-banner-dot">F1</div>
          <div class="fund-banner-info">
            <div class="fund-banner-label">Processing Under</div>
            <div class="fund-banner-name" id="fund-banner-name">—</div>
          </div>
          <button class="fund-banner-change" onclick="changeFund()">
            <i class="bi bi-pencil"></i> Change
          </button>
        </div>
      </div>

      <main class="main-content">
      <div class="main-inner">

      <!-- GATE: shown before fund is selected & confirmed -->
      <div id="section-gate">
        <div class="fund-gate">
          <div class="fund-gate-icon"><i class="bi bi-bank2"></i></div>
          <div class="fund-gate-title">Select a Fund First</div>
          <div class="fund-gate-sub">
            Choose the appropriate fund from the sidebar on the left, then click <strong>Proceed</strong> to begin processing a payment.
          </div>
        </div>
      </div>

      <!-- FORM: shown after fund confirmed -->
      <div id="section-form">

        <h1 class="page-title">Process a Payment</h1>
        <p class="page-sub">Select the type of transaction, then fill in the required details.</p>

        <!-- Step indicator -->
        <div class="step-indicator">
          <div class="step-ind-item done">
            <div class="step-ind-num"><i class="bi bi-check" style="font-size:.7rem;"></i></div>
            <div class="step-ind-text">Fund</div>
          </div>
          <div class="step-ind-line"></div>
          <div class="step-ind-item active">
            <div class="step-ind-num">2</div>
            <div class="step-ind-text">Transaction Type</div>
          </div>
          <div class="step-ind-line"></div>
          <div class="step-ind-item inactive">
            <div class="step-ind-num">3</div>
            <div class="step-ind-text">Payment Details</div>
          </div>
        </div>

        <!-- STEP 2: Select transaction type -->
        <div class="select-card">
          <div class="step-label">
            <div class="step-num">2</div>
            <div class="step-text">Select Transaction Type</div>
          </div>
          <div class="select-wrap">
            <select id="txn-select">
              <option value="" disabled selected>Please select transaction type</option>
              <option value="appeal_fee">Appeal Fee</option>
              <option value="bidding_documents">Bidding Documents</option>
              <option value="certification_photocopy">Certification and Photocopy Fees</option>
              <option value="filing_fee">Filing Fee and Inspection Cost</option>
              <option value="fund_transfer">Fund Transfer from DAR C.O.</option>
              <option value="income_unserviceable">Income from Sale of Unserviceable Property</option>
              <option value="luc_cash_bond">LUC Cash Bond</option>
              <option value="refund_overpayment">Refund of Overpayment</option>
              <option value="refund_lgu">Refund of Transfer from LGUs</option>
              <option value="settlement_disallowances">Settlement of Notice of Disallowances</option>
            </select>
          </div>
        </div>

        <!-- STEP 3: Form -->
        <div class="form-card" id="form-card">

          <div class="form-header">
            <div class="form-header-seal">🌾</div>
            <div class="form-header-info">
              <div class="org">Department of Agrarian Reform — Regional Office V</div>
              <div class="txn-name" id="form-txn-name">—</div>
            </div>
          </div>

          <div class="required-note">
            <i class="bi bi-asterisk"></i>
            Fields with * (asterisk) are required/mandatory.
          </div>

          <div class="form-body">
            <form method="POST" action="{{ route('dashboard.store') }}" id="payment-form">
              @csrf
              <input type="hidden" name="transaction_type" id="hidden-txn-type" />
              <input type="hidden" name="fund_type" id="hidden-fund-type" />

              <div class="section-heading">
                <i class="bi bi-card-checklist"></i> Payment Details
              </div>

              <div class="field">
                <label>Amount : <span class="req">*</span></label>
                <div class="amount-wrap">
                  <span>₱</span>
                  <input name="amount" type="number" min="0" step="0.01" placeholder="0.00" required />
                </div>
              </div>

              <div class="field">
                <label>Name : <span class="req">*</span></label>
                <input name="name" type="text" placeholder="Full name" required />
              </div>

              <div class="field">
                <label>Contact No. of Client : <span class="req">*</span></label>
                <input name="contact" type="tel" placeholder="e.g. 09123456789" required />
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
                <label>Order of Payment No. : <span class="req">*</span></label>
                <input name="op_number" type="text" placeholder="e.g. 982123" required />
              </div>

              <!-- TYPE-SPECIFIC EXTRA FIELDS -->

              <div class="extra-fields" id="extra-appeal_fee">
                <hr class="extra-divider">
                <div class="extra-label">Appeal Fee Details</div>
                <div class="field">
                  <label>Case Number : <span class="req">*</span></label>
                  <input name="case_number" type="text" placeholder="e.g. DARAB Case No. 001-2025" />
                </div>
                <div class="field">
                  <label>Nature of Appeal :</label>
                  <input name="nature_of_appeal" type="text" placeholder="Brief description of appeal" />
                </div>
              </div>

              <div class="extra-fields" id="extra-bidding_documents">
                <hr class="extra-divider">
                <div class="extra-label">Bidding Document Details</div>
                <div class="field">
                  <label>Project / Bid Name : <span class="req">*</span></label>
                  <input name="project_name" type="text" placeholder="Name of bidding project" />
                </div>
                <div class="field">
                  <label>Bid Reference No. : <span class="req">*</span></label>
                  <input name="bid_ref" type="text" placeholder="e.g. DARCO-BID-2025-001" />
                </div>
              </div>

              <div class="extra-fields" id="extra-certification_photocopy">
                <hr class="extra-divider">
                <div class="extra-label">Certification / Photocopy Details</div>
                <div class="field">
                  <label>Type of Certification : <span class="req">*</span></label>
                  <input name="cert_type" type="text" placeholder="e.g. Certificate of Coverage, CTC of documents" />
                </div>
                <div class="field">
                  <label>Number of Pages / Copies :</label>
                  <input name="num_pages" type="number" min="1" placeholder="e.g. 5" />
                </div>
              </div>

              <div class="extra-fields" id="extra-filing_fee">
                <hr class="extra-divider">
                <div class="extra-label">Filing / Inspection Details</div>
                <div class="field">
                  <label>Nature of Case / Application : <span class="req">*</span></label>
                  <input name="case_type" type="text" placeholder="e.g. Conversion Application, DARAB Complaint" />
                </div>
                <div class="field">
                  <label>Filing Reference No. : <span class="req">*</span></label>
                  <input name="filing_ref" type="text" placeholder="e.g. DARCO-2025-001" />
                </div>
              </div>

              <div class="extra-fields" id="extra-fund_transfer">
                <hr class="extra-divider">
                <div class="extra-label">Fund Transfer Details</div>
                <div class="field">
                  <label>Fund Source / Program : <span class="req">*</span></label>
                  <input name="fund_source" type="text" placeholder="e.g. APCP, ARCBP" />
                </div>
                <div class="field">
                  <label>Transfer Reference No. : <span class="req">*</span></label>
                  <input name="transfer_ref" type="text" placeholder="Reference number of the transfer" />
                </div>
              </div>

              <div class="extra-fields" id="extra-income_unserviceable">
                <hr class="extra-divider">
                <div class="extra-label">Unserviceable Property Details</div>
                <div class="field">
                  <label>Property Description : <span class="req">*</span></label>
                  <input name="property_desc" type="text" placeholder="Brief description of property sold" />
                </div>
                <div class="field">
                  <label>Inventory / Property No. :</label>
                  <input name="inventory_no" type="text" placeholder="Property inventory number" />
                </div>
              </div>

              <div class="extra-fields" id="extra-luc_cash_bond">
                <hr class="extra-divider">
                <div class="extra-label">LUC Cash Bond Details</div>
                <div class="field">
                  <label>LUC Folder : <span class="req">*</span></label>
                  <input name="luc_folder" type="text" placeholder="e.g. LUC" />
                </div>
                <div class="field">
                  <label>Assessment Form No. : <span class="req">*</span></label>
                  <input name="assessment_form" type="text" placeholder="e.g. 081823" />
                </div>
              </div>

              <div class="extra-fields" id="extra-refund_overpayment">
                <hr class="extra-divider">
                <div class="extra-label">Overpayment Refund Details</div>
                <div class="field">
                  <label>Original O.R. Number : <span class="req">*</span></label>
                  <input name="orig_or" type="text" placeholder="O.R. number of the original payment" />
                </div>
                <div class="field">
                  <label>Reason for Refund : <span class="req">*</span></label>
                  <input name="refund_reason" type="text" placeholder="Brief explanation" />
                </div>
              </div>

              <div class="extra-fields" id="extra-refund_lgu">
                <hr class="extra-divider">
                <div class="extra-label">LGU Transfer Refund Details</div>
                <div class="field">
                  <label>LGU Name : <span class="req">*</span></label>
                  <input name="lgu_name" type="text" placeholder="e.g. Municipality of Bula, Camarines Sur" />
                </div>
                <div class="field">
                  <label>Transfer Reference No. : <span class="req">*</span></label>
                  <input name="lgu_transfer_ref" type="text" placeholder="Reference number" />
                </div>
              </div>

              <div class="extra-fields" id="extra-settlement_disallowances">
                <hr class="extra-divider">
                <div class="extra-label">Notice of Disallowance Details</div>
                <div class="field">
                  <label>COA Notice No. : <span class="req">*</span></label>
                  <input name="coa_ref" type="text" placeholder="e.g. ND-2025-001" />
                </div>
                <div class="field">
                  <label>Period Covered : <span class="req">*</span></label>
                  <input name="disallowance_period" type="text" placeholder="e.g. January–June 2024" />
                </div>
              </div>

              <!-- Payment Mode -->
              <div class="field" style="margin-top: 4px;">
                <label>Payment Mode :</label>
                <div class="sel-wrap">
                  <select name="payment_mode">
                    <option value="cash">Cash</option>
                  </select>
                </div>
              </div>

              <hr class="form-divider">

              <div class="terms-block">
                <label>
                  <input type="checkbox" id="agree_terms" name="agree_terms" />
                  I certify that I am at least 18 years old and have read, understood and agreed to the
                  <a href="#" target="_blank">Terms and Conditions</a>.
                </label>
              </div>

              <p class="review-note">
                <i class="bi bi-exclamation-circle-fill"></i>
                Please review payment details above before clicking Continue.
              </p>

              <button type="submit" class="btn-submit" id="submit-btn" disabled>
                <i class="bi bi-arrow-right-circle me-2"></i> Continue
              </button>

            </form>
          </div>
        </div>

      </div><!-- /section-form -->

      </div><!-- /main-inner -->
      </main>
    </div><!-- /flex column wrapper -->
  </div><!-- /outer-wrapper -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>

    /* ── Fund selection ── */
    let selectedFund     = null;
    let selectedFundLabel = null;

    function selectFund(el) {
      document.querySelectorAll('.fund-item').forEach(f => f.classList.remove('active'));
      el.classList.add('active');
      selectedFund      = el.dataset.fund;
      selectedFundLabel = el.dataset.label;

      const dot  = el.querySelector('.fund-dot').textContent;
      document.getElementById('sidebar-selected-label').textContent = selectedFundLabel;

      const btn = document.getElementById('sidebar-proceed-btn');
      btn.classList.add('enabled');
    }

    function proceedToForm() {
      if (!selectedFund) return;

      document.getElementById('hidden-fund-type').value = selectedFund;

      const dot = document.querySelector('.fund-item.active .fund-dot').textContent;
      document.getElementById('fund-banner-dot').textContent  = dot;
      document.getElementById('fund-banner-name').textContent = selectedFundLabel;
      document.getElementById('fund-banner-wrap').classList.add('show');

      document.getElementById('section-gate').style.display = 'none';
      document.getElementById('section-form').style.display = 'block';

      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function changeFund() {
      document.getElementById('section-form').style.display = 'none';
      document.getElementById('section-gate').style.display = 'block';
      document.getElementById('fund-banner-wrap').classList.remove('show');

      document.getElementById('txn-select').value = '';
      document.getElementById('form-card').classList.remove('visible');
      document.querySelectorAll('.extra-fields').forEach(el => el.classList.remove('show'));
      document.getElementById('agree_terms').checked = false;
      document.getElementById('submit-btn').disabled = true;

      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /* ── Transaction type select ── */
    const txnSelect   = document.getElementById('txn-select');
    const formCard    = document.getElementById('form-card');
    const formTxnName = document.getElementById('form-txn-name');
    const hiddenType  = document.getElementById('hidden-txn-type');
    const agreeChk    = document.getElementById('agree_terms');
    const submitBtn   = document.getElementById('submit-btn');

    txnSelect.addEventListener('change', function () {
      const val   = this.value;
      const label = this.options[this.selectedIndex].text;

      hiddenType.value        = val;
      formTxnName.textContent = label;

      document.querySelectorAll('.extra-fields').forEach(el => el.classList.remove('show'));
      const target = document.getElementById('extra-' + val);
      if (target) target.classList.add('show');

      formCard.classList.add('visible');
      agreeChk.checked   = false;
      submitBtn.disabled = true;

      setTimeout(() => {
        formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 80);
    });

    agreeChk.addEventListener('change', function () {
      submitBtn.disabled = !this.checked;
    });

  </script>
</body>
</html>