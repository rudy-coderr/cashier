<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Transaction — DAR Cashier</title>
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
    .page-header {
      background: var(--green-deep); padding: 16px 32px;
      display: flex; align-items: center; gap: 14px;
      position: sticky; top: 0; z-index: 200;
    }
    .header-seal { width: 38px; height: 38px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
    .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
    .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
    .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }
    .header-back { margin-left: auto; display: flex; align-items: center; gap: 6px; font-size: .78rem; color: rgba(245,240,232,.45); text-decoration: none; transition: color .18s; }
    .header-back:hover { color: var(--cream); }

    /* ── LAYOUT ── */
    .outer-wrapper { display: flex; min-height: calc(100vh - 72px); }

    /* ── SIDEBAR ── */
    .sidebar {
      width: 280px; flex-shrink: 0;
      background: var(--green-deep);
      border-right: 1px solid rgba(255,255,255,.07);
      position: sticky; top: 72px;
      height: calc(100vh - 72px);
      display: flex; flex-direction: column;
      overflow: hidden;
    }

    .sidebar-scroll { flex: 1; overflow-y: auto; padding: 24px 0 0; }
    .sidebar-scroll::-webkit-scrollbar { width: 3px; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }

    .sidebar-step-badge { display: flex; align-items: center; gap: 9px; padding: 0 22px; margin-bottom: 14px; }
    .sidebar-step-num { width: 22px; height: 22px; border-radius: 50%; background: var(--gold); color: var(--green-deep); font-size: .68rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .sidebar-step-label { font-size: .65rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: rgba(245,240,232,.45); }
    .sidebar-title { padding: 0 22px; font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); margin-bottom: 4px; }
    .sidebar-sub { padding: 0 22px; font-size: .71rem; color: rgba(245,240,232,.35); font-weight: 300; margin-bottom: 18px; line-height: 1.5; }
    .sidebar-divider { border: none; border-top: 1px solid rgba(255,255,255,.07); margin: 0 22px 16px; }

    /* Fund items */
    .fund-item { display: flex; align-items: center; gap: 11px; padding: 10px 22px; cursor: pointer; transition: background .15s; border-left: 3px solid transparent; }
    .fund-item:hover { background: rgba(255,255,255,.04); }
    .fund-item.active { background: rgba(45,122,79,.18); border-left-color: var(--gold); }
    .fund-dot { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .68rem; font-weight: 700; flex-shrink: 0; transition: background .15s, color .15s; }
    .fund-item:not(.active) .fund-dot { background: rgba(255,255,255,.07); color: rgba(245,240,232,.55); }
    .fund-item.active .fund-dot { background: var(--gold); color: var(--green-deep); }
    .fund-info { flex: 1; min-width: 0; }
    .fund-name { font-size: .79rem; font-weight: 600; color: rgba(245,240,232,.8); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .fund-item.active .fund-name { color: var(--cream); }
    .fund-check { font-size: .85rem; color: var(--gold); opacity: 0; transition: opacity .15s; flex-shrink: 0; }
    .fund-item.active .fund-check { opacity: 1; }

    /* Sidebar footer */
    .sidebar-footer { padding: 14px 22px; border-top: 1px solid rgba(255,255,255,.07); flex-shrink: 0; }
    .sidebar-footer-label { font-size: .6rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.3); margin-bottom: 3px; }
    .sidebar-footer-value { font-size: .78rem; font-weight: 600; color: var(--gold-light); min-height: 16px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sidebar-proceed-btn { width: 100%; margin-top: 10px; padding: 9px 14px; background: var(--gold); border: none; border-radius: 8px; color: var(--green-deep); font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: .73rem; letter-spacing: 1.5px; text-transform: uppercase; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: background .15s, transform .12s; opacity: .35; pointer-events: none; }
    .sidebar-proceed-btn.enabled { opacity: 1; pointer-events: all; }
    .sidebar-proceed-btn.enabled:hover { background: var(--gold-light); transform: translateY(-1px); }

    /* Sidebar history */
    .sidebar-history-wrap { flex-shrink: 0; border-top: 1px solid rgba(255,255,255,.07); }
    .sidebar-view-all-btn { display: flex; align-items: center; justify-content: center; gap: 6px; margin: 8px 22px 14px; padding: 8px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: .71rem; font-weight: 600; color: rgba(245,240,232,.45); cursor: pointer; transition: background .15s, color .15s; }
    .sidebar-view-all-btn:hover { background: rgba(255,255,255,.08); color: var(--cream); }

    /* ── STICKY FUND BANNER ── */
    .fund-banner-sticky-wrap { display: none; position: sticky; top: 72px; z-index: 150; width: 100%; background: var(--green-deep); border-bottom: 1px solid rgba(255,255,255,.08); padding: 9px 32px; }
    .fund-banner-sticky-wrap.show { display: block; }
    .fund-banner { display: flex; align-items: center; gap: 12px; max-width: 640px; margin: 0 auto; }
    .fund-banner-icon { width: 34px; height: 34px; border-radius: 8px; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: .78rem; font-weight: 700; color: var(--green-deep); flex-shrink: 0; }
    .fund-banner-info { flex: 1; }
    .fund-banner-label { font-size: .58rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.4); margin-bottom: 1px; }
    .fund-banner-name { font-family: 'Cormorant Garamond', serif; font-size: .95rem; font-weight: 700; color: var(--gold-light); }
    .fund-banner-change { font-size: .72rem; color: rgba(245,240,232,.4); cursor: pointer; display: flex; align-items: center; gap: 4px; transition: color .15s; background: none; border: none; font-family: 'DM Sans', sans-serif; }
    .fund-banner-change:hover { color: var(--cream); }

    /* ── MAIN ── */
    .main-content { flex: 1; padding: 0 32px 60px; min-width: 0; display: flex; flex-direction: column; align-items: center; }
    .main-inner { width: 100%; max-width: 640px; padding-top: 36px; }

    /* Gate */
    .fund-gate { text-align: center; padding: 80px 20px; }
    .fund-gate-icon { font-size: 2.8rem; color: var(--border); margin-bottom: 14px; }
    .fund-gate-title { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-weight: 700; color: var(--text-mid); margin-bottom: 8px; }
    .fund-gate-sub { font-size: .82rem; color: var(--muted); font-weight: 300; max-width: 320px; margin: 0 auto; line-height: 1.6; }

    /* Page title */
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
    .page-sub { font-size: .82rem; color: var(--muted); font-weight: 300; margin-bottom: 24px; }

    /* Step indicator */
    .step-indicator { display: flex; align-items: center; margin-bottom: 24px; }
    .step-ind-item { display: flex; align-items: center; gap: 8px; }
    .step-ind-num { width: 24px; height: 24px; border-radius: 50%; font-size: .7rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .step-ind-item.done .step-ind-num { background: var(--green-accent); color: #fff; }
    .step-ind-item.active .step-ind-num { background: var(--green-mid); color: #fff; }
    .step-ind-item.inactive .step-ind-num { background: var(--border); color: var(--muted); }
    .step-ind-text { font-size: .7rem; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; }
    .step-ind-item.done .step-ind-text { color: var(--green-accent); }
    .step-ind-item.active .step-ind-text { color: var(--text-mid); }
    .step-ind-item.inactive .step-ind-text { color: var(--muted); }
    .step-ind-line { flex: 1; height: 1px; background: var(--border); margin: 0 10px; max-width: 36px; }

    /* Select card */
    .select-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; padding: 26px; }
    .step-label { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
    .step-num { width: 26px; height: 26px; border-radius: 50%; background: var(--green-mid); color: #fff; font-size: .72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .step-text { font-size: .72rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--text-mid); }
    .select-wrap { position: relative; }
    .select-wrap select { width: 100%; padding: 13px 44px 13px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-family: 'DM Sans', sans-serif; font-size: .93rem; color: var(--text-dark); background: #faf8f4; outline: none; appearance: none; cursor: pointer; transition: border-color .2s, box-shadow .2s; }
    .select-wrap select:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); background: #fff; }
    .select-wrap::after { content: '\F282'; font-family: 'bootstrap-icons'; position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; font-size: 1rem; }

    /* Form card */
    .form-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; margin-top: 18px; max-height: 0; opacity: 0; pointer-events: none; transition: max-height .5s cubic-bezier(.16,1,.3,1), opacity .35s ease; }
    .form-card.visible { max-height: 4000px; opacity: 1; pointer-events: all; }
    .form-header { padding: 16px 26px; background: linear-gradient(90deg, var(--green-mid), var(--green-deep)); display: flex; align-items: center; gap: 12px; }
    .form-header-seal { width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,.1); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .form-header-info .org { font-size: .58rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.4); font-weight: 300; }
    .form-header-info .txn-name { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-weight: 700; color: var(--gold-light); }
    .required-note { padding: 8px 26px; font-size: .73rem; color: var(--red); background: #fff9f8; border-bottom: 1px solid #f5e0de; display: flex; align-items: center; gap: 5px; }
    .form-body { padding: 26px; }
    .section-heading { display: flex; align-items: center; gap: 8px; font-size: .68rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--text-mid); margin-bottom: 18px; }
    .section-heading i { color: var(--green-accent); }

    /* Fields */
    .field { margin-bottom: 15px; }
    .field label { display: flex; align-items: center; gap: 4px; font-size: .81rem; font-weight: 500; color: var(--text-mid); margin-bottom: 5px; }
    .req { color: var(--red); font-size: .85rem; line-height: 1; }
    .field input, .field select, .field textarea { width: 100%; padding: 9px 13px; border: 1.5px solid var(--border); border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: .88rem; color: var(--text-dark); background: #faf8f4; outline: none; transition: border-color .2s, box-shadow .2s, background .2s; appearance: none; }
    .field textarea { resize: vertical; min-height: 70px; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.1); background: #fff; }
    .field input::placeholder, .field textarea::placeholder { color: #b5c4ba; }
    .field.invalid input, .field.invalid select, .field.invalid textarea { border-color: var(--red); box-shadow: none; background: #fff6f6; }
    .field .error-msg { display: none; font-size: .75rem; color: var(--red); margin-top: 6px; }
    .field.invalid .error-msg { display: block; }
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 13px; }
    .amount-wrap { position: relative; }
    .amount-wrap span { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: .86rem; color: var(--muted); font-weight: 500; pointer-events: none; }
    .amount-wrap input { padding-left: 28px; }
    .sel-wrap { position: relative; }
    .sel-wrap::after { content: '\F282'; font-family: 'bootstrap-icons'; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .sel-wrap select { padding-right: 34px; }

    /* Extra fields */
    .extra-fields { display: none; }
    .extra-fields.show { display: block; }
    .extra-divider { border: none; border-top: 1px solid var(--green-light); margin: 4px 0 14px; }
    .extra-label { font-size: .66rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--green-accent); margin-bottom: 13px; }

    /* Checkboxes */
    .check-group { display: flex; flex-direction: column; gap: 8px; }
    .check-item { display: flex; align-items: center; gap: 9px; font-size: .85rem; color: var(--text-mid); cursor: pointer; padding: 8px 12px; border: 1.5px solid var(--border); border-radius: 8px; background: #faf8f4; transition: border-color .2s, background .2s; position: relative; padding-left: 44px; }
    .check-item:hover { border-color: var(--green-accent); background: #fff; }
    .check-item input[type="checkbox"] { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; opacity: 0; margin: 0; cursor: pointer; }
    .check-item::before { content: ''; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 6px; border: 2px solid var(--border); background: #faf8f4; }
    .check-item::after { content: ''; position: absolute; left: 17px; top: 50%; transform: translateY(-56%) rotate(45deg); width: 6px; height: 10px; border: solid white; border-width: 0 2px 2px 0; opacity: 0; }
    .check-item.checked { border-color: var(--green-accent); background: var(--green-light); }
    .check-item.checked::before { background: var(--green-accent); border-color: var(--green-accent); }
    .check-item.checked::after { opacity: 1; }

    /* Remittance checkboxes */
    .remit-check-group { display: flex; flex-direction: column; gap: 8px; }
    .remit-check-item { display: flex; align-items: flex-start; gap: 9px; font-size: .85rem; color: var(--text-mid); cursor: pointer; padding: 8px 12px; border: 1.5px solid var(--border); border-radius: 8px; background: #faf8f4; transition: border-color .2s, background .2s; position: relative; padding-left: 44px; }
    .remit-check-item:hover { border-color: var(--green-accent); background: #fff; }
    .remit-check-item input[type="checkbox"] { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; opacity: 0; margin: 0; cursor: pointer; }
    .remit-check-item::before { content: ''; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 6px; border: 2px solid var(--border); background: #faf8f4; }
    .remit-check-item::after { content: ''; position: absolute; left: 17px; top: 50%; transform: translateY(-56%) rotate(45deg); width: 6px; height: 10px; border: solid white; border-width: 0 2px 2px 0; opacity: 0; }
    .remit-check-item.checked { border-color: var(--green-accent); background: var(--green-light); }
    .remit-check-item.checked::before { background: var(--green-accent); border-color: var(--green-accent); }
    .remit-check-item.checked::after { opacity: 1; }
    .remit-open-field { display: none; margin-top: 6px; }
    .remit-open-field.show { display: block; }

    .form-divider { border: none; border-top: 1px dashed var(--border); margin: 20px 0; }
    .terms-block { background: #faf8f4; border: 1px solid var(--border); border-radius: 8px; padding: 13px 15px; margin-bottom: 13px; }
    .terms-block label { display: flex; align-items: flex-start; gap: 10px; font-size: .81rem; color: var(--text-mid); cursor: pointer; line-height: 1.55; }
    .terms-block input[type="checkbox"] { accent-color: var(--green-accent); width: 15px; height: 15px; flex-shrink: 0; margin-top: 2px; cursor: pointer; }
    .terms-block a { color: var(--green-accent); text-decoration: underline; }
    .review-note { font-size: .77rem; color: var(--red); margin-bottom: 14px; display: flex; align-items: center; gap: 6px; }
    .btn-submit { width: 100%; padding: 13px; background: var(--green-mid); border: none; border-radius: 9px; color: #fff; font-family: 'DM Sans', sans-serif; font-weight: 600; font-size: .88rem; letter-spacing: 2px; text-transform: uppercase; cursor: pointer; position: relative; overflow: hidden; transition: background .15s, transform .12s, box-shadow .15s; box-shadow: 0 5px 20px rgba(26,74,46,.3); }
    .btn-submit::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,.1), transparent 55%); pointer-events: none; }
    .btn-submit:hover:not(:disabled) { background: var(--green-accent); transform: translateY(-2px); box-shadow: 0 9px 28px rgba(26,74,46,.38); }
    .btn-submit:disabled { opacity: .45; cursor: not-allowed; }

    #section-gate { display: block; }
    #section-form { display: none; }

    /* ── TRANSACTIONS MODAL ── */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 1000; align-items: center; justify-content: center; padding: 20px; }
    .modal-overlay.open { display: flex; }
    .txn-modal { background: var(--surface); border-radius: 16px; width: 100%; max-width: 700px; max-height: 88vh; display: flex; flex-direction: column; overflow: hidden; animation: modalIn .22s cubic-bezier(.16,1,.3,1); }
    @keyframes modalIn { from { opacity: 0; transform: translateY(16px) scale(.97); } to { opacity: 1; transform: none; } }

    .modal-head { padding: 16px 22px; background: var(--green-deep); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
    .modal-head-left { display: flex; align-items: center; gap: 12px; }
    .modal-head-icon { width: 36px; height: 36px; border-radius: 9px; background: rgba(201,153,42,.2); display: flex; align-items: center; justify-content: center; font-size: .95rem; color: var(--gold-light); flex-shrink: 0; }
    .modal-head-title { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700; color: var(--gold-light); }
    .modal-head-sub { font-size: .6rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.3); }
    .modal-close-btn { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,.07); border: none; color: rgba(245,240,232,.5); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1rem; transition: background .15s, color .15s; }
    .modal-close-btn:hover { background: rgba(255,255,255,.14); color: var(--cream); }

    .modal-tabs { display: flex; padding: 12px 22px 0; border-bottom: 1px solid var(--border); background: #faf8f4; flex-shrink: 0; gap: 2px; overflow-x: auto; }
    .modal-tab { padding: 7px 14px 9px; font-size: .73rem; font-weight: 600; color: var(--muted); cursor: pointer; border-bottom: 2px solid transparent; transition: color .15s, border-color .15s; display: flex; align-items: center; gap: 6px; white-space: nowrap; background: none; border-top: none; border-left: none; border-right: none; font-family: 'DM Sans', sans-serif; }
    .modal-tab:hover { color: var(--text-mid); }
    .modal-tab.active { color: var(--green-mid); border-bottom-color: var(--green-accent); }
    .modal-tab-count { font-size: .6rem; padding: 1px 6px; border-radius: 20px; font-weight: 700; }
    .tab-all .modal-tab-count { background: #e8e4dc; color: var(--text-mid); }
    .tab-approved .modal-tab-count { background: var(--green-light); color: var(--green-accent); }
    .tab-waiting .modal-tab-count { background: #fdf3dc; color: #a0700a; }
    .tab-rejected .modal-tab-count { background: #fdf0ef; color: var(--red); }

    .modal-search-bar { padding: 12px 22px; background: #faf8f4; border-bottom: 1px solid var(--border); flex-shrink: 0; }
    .modal-search-inner { position: relative; }
    .modal-search-inner i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .85rem; pointer-events: none; }
    .modal-search-inner input { width: 100%; padding: 8px 12px 8px 32px; border: 1.5px solid var(--border); border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: .85rem; color: var(--text-dark); background: #fff; outline: none; transition: border-color .2s, box-shadow .2s; }
    .modal-search-inner input:focus { border-color: var(--green-accent); box-shadow: 0 0 0 3px rgba(45,122,79,.09); }

    .modal-list { overflow-y: auto; flex: 1; }
    .modal-list::-webkit-scrollbar { width: 4px; }
    .modal-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .modal-txn-row { display: flex; align-items: center; gap: 14px; padding: 13px 22px; border-bottom: 1px solid var(--border); transition: background .12s; cursor: pointer; }
    .modal-txn-row:last-child { border-bottom: none; }
    .modal-txn-row:hover { background: #f9f7f2; }
    .modal-txn-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: .9rem; flex-shrink: 0; }
    .mi-green { background: var(--green-light); color: var(--green-accent); }
    .mi-gold  { background: #fdf3dc; color: var(--gold); }
    .mi-blue  { background: #eef3fc; color: #2a5fa0; }
    .mi-red   { background: #fdf0ef; color: var(--red); }
    .modal-txn-main { flex: 1; min-width: 0; }
    .modal-txn-name { font-size: .87rem; font-weight: 600; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .modal-txn-type { font-size: .73rem; color: var(--muted); margin-top: 2px; }
    .modal-txn-meta { font-size: .67rem; color: #b5c4ba; margin-top: 4px; display: flex; align-items: center; gap: 8px; }
    .modal-txn-right { display: flex; flex-direction: column; align-items: flex-end; gap: 5px; flex-shrink: 0; }
    .modal-txn-amount { font-size: .9rem; font-weight: 700; color: var(--green-mid); }
    .modal-status-badge { display: inline-flex; align-items: center; gap: 4px; font-size: .65rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; letter-spacing: .4px; text-transform: uppercase; }
    .ms-approved { background: var(--green-light); color: var(--green-accent); }
    .ms-waiting  { background: #fdf3dc; color: #a0700a; }
    .ms-rejected { background: #fdf0ef; color: var(--red); }
    .modal-txn-or { font-size: .67rem; color: var(--muted); }

    .modal-empty { padding: 50px 20px; text-align: center; }
    .modal-empty i { font-size: 2.2rem; color: var(--border); display: block; margin-bottom: 12px; }
    .modal-empty p { font-size: .82rem; color: var(--muted); }

    /* ── PAGINATION FOOTER ── */
    .modal-foot {
      padding: 10px 22px; background: #faf8f4; border-top: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      flex-shrink: 0; gap: 12px; flex-wrap: wrap;
    }
    .modal-foot-info { font-size: .72rem; color: var(--muted); white-space: nowrap; }
    .modal-foot-info strong { color: var(--text-mid); }
    .modal-foot-right { display: flex; align-items: center; gap: 10px; }
    .pg-per-page { display: flex; align-items: center; gap: 6px; font-size: .72rem; color: var(--muted); }
    .pg-per-page select { padding: 4px 6px; border: 1.5px solid var(--border); border-radius: 6px; font-family: 'DM Sans', sans-serif; font-size: .72rem; color: var(--text-mid); background: var(--surface); outline: none; cursor: pointer; }
    .pg-per-page select:focus { border-color: var(--green-accent); }
    .pagination { display: flex; align-items: center; gap: 4px; }
    .pg-btn {
      min-width: 30px; height: 30px; padding: 0 8px; border-radius: 7px;
      border: 1.5px solid var(--border); background: var(--surface); color: var(--text-mid);
      font-family: 'DM Sans', sans-serif; font-size: .73rem; font-weight: 600;
      cursor: pointer; display: flex; align-items: center; justify-content: center;
      transition: background .12s, border-color .12s, color .12s;
    }
    .pg-btn:hover:not(:disabled) { background: var(--green-light); border-color: var(--green-accent); color: var(--green-mid); }
    .pg-btn:disabled { opacity: .35; cursor: not-allowed; }
    .pg-btn.active { background: var(--green-mid); border-color: var(--green-mid); color: #fff; }
    .pg-ellipsis { font-size: .78rem; color: var(--muted); padding: 0 2px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
      .outer-wrapper { flex-direction: column; }
      .sidebar { width: 100%; height: auto; position: static; flex-direction: row; overflow-x: auto; border-right: none; border-bottom: 1px solid rgba(255,255,255,.07); }
      .sidebar-scroll { overflow: visible; padding: 10px 0; }
      .sidebar-step-badge, .sidebar-title, .sidebar-sub, .sidebar-divider, .sidebar-footer, .sidebar-history-wrap { display: none; }
      .fund-item { padding: 8px 13px; border-left: none; border-bottom: 2px solid transparent; border-radius: 8px; white-space: nowrap; }
      .fund-item.active { border-bottom-color: var(--gold); }
      .fund-dot { width: 28px; height: 28px; font-size: .65rem; }
      .main-content { padding: 0 16px 48px; }
      .fund-banner-sticky-wrap { padding: 9px 16px; top: 0; }
      .modal-foot { flex-direction: column; align-items: flex-start; gap: 8px; }
      .modal-foot-right { width: 100%; justify-content: space-between; }
    }
    @media (max-width: 560px) {
      .field-row { grid-template-columns: 1fr; }
      .pg-per-page { display: none; }
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
  <form method="POST" action="{{ route('logout') }}" class="header-back">
    @csrf
    <button type="submit" style="background:none;border:none;color:inherit;font-size:inherit;cursor:pointer;padding:0;display:flex;align-items:center;gap:6px;">
      <i class="bi bi-box-arrow-right"></i> Logout
    </button>
  </form>
</header>

<div class="outer-wrapper">

  <!-- ══════════════ SIDEBAR ══════════════ -->
  <aside class="sidebar">

    <div class="sidebar-scroll">
      <div class="sidebar-step-badge">
        <div class="sidebar-step-num">1</div>
        <div class="sidebar-step-label">Select Fund</div>
      </div>
      <div class="sidebar-title">Choose a Fund</div>
      <div class="sidebar-sub">Select the fund this transaction will be processed under before continuing.</div>
      <hr class="sidebar-divider">

      <div class="fund-list">
        <div class="fund-item" data-fund="F01" data-name="Fund 01 - REGULAR" data-label="Regular Fund" onclick="selectFund(this)">
          <div class="fund-dot">F01</div>
          <div class="fund-info"><div class="fund-name">Fund 01 — REGULAR</div></div>
          <i class="bi bi-check-circle-fill fund-check"></i>
        </div>
        <div class="fund-item" data-fund="F03" data-name="Fund 03 - ARF" data-label="Agrarian Reform Fund" onclick="selectFund(this)">
          <div class="fund-dot">F03</div>
          <div class="fund-info"><div class="fund-name">Fund 03 — ARF</div></div>
          <i class="bi bi-check-circle-fill fund-check"></i>
        </div>
        <div class="fund-item" data-fund="F07" data-name="Fund 07 - TRUST" data-label="Trust Fund" onclick="selectFund(this)">
          <div class="fund-dot">F07</div>
          <div class="fund-info"><div class="fund-name">Fund 07 — TRUST</div></div>
          <i class="bi bi-check-circle-fill fund-check"></i>
        </div>
        <div class="fund-item" data-fund="F02-LP" data-name="LP SPLIT - FUND 02" data-label="Loan Proceeds" onclick="selectFund(this)">
          <div class="fund-dot">F02</div>
          <div class="fund-info"><div class="fund-name">LP SPLIT — FUND 02</div></div>
          <i class="bi bi-check-circle-fill fund-check"></i>
        </div>
        <div class="fund-item" data-fund="F02-GOP" data-name="GOP SPLIT - FUND 02" data-label="Government of The Philippines" onclick="selectFund(this)">
          <div class="fund-dot">F02</div>
          <div class="fund-info"><div class="fund-name">GOP SPLIT — FUND 02</div></div>
          <i class="bi bi-check-circle-fill fund-check"></i>
        </div>
      </div>
    </div>

    <!-- Proceed button -->
    <div class="sidebar-footer">
      <div class="sidebar-footer-label">Selected Fund</div>
      <div class="sidebar-footer-value" id="sidebar-selected-label">—</div>
      <button class="sidebar-proceed-btn" id="sidebar-proceed-btn" onclick="proceedToForm()">
        <i class="bi bi-arrow-right"></i> Proceed
      </button>
    </div>

    <div class="sidebar-history-wrap">
      <button class="sidebar-view-all-btn" onclick="openModal()">
        <i class="bi bi-list-ul"></i> View All Transactions
      </button>
    </div>

  </aside>

  <!-- ══════════════ MAIN ══════════════ -->
  <div style="flex:1; display:flex; flex-direction:column; min-width:0;">

    <div class="fund-banner-sticky-wrap" id="fund-banner-wrap">
      <div class="fund-banner">
        <div class="fund-banner-icon" id="fund-banner-dot">—</div>
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

      <!-- GATE -->
      <div id="section-gate">
        <div class="fund-gate">
          <div class="fund-gate-icon"><i class="bi bi-bank2"></i></div>
          <div class="fund-gate-title">Select a Fund First</div>
          <div class="fund-gate-sub">Choose the appropriate fund from the sidebar on the left, then click <strong>Proceed</strong> to begin processing a payment.</div>
        </div>
      </div>

      <!-- FORM -->
      <div id="section-form">
        <h1 class="page-title">Process a Payment</h1>
        <p class="page-sub">Select the type of transaction, then fill in the required details.</p>

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

        <!-- ════ FORM CARD ════ -->
        <div class="form-card" id="form-card">
          <div class="form-header">
            <div class="form-header-seal">🌾</div>
            <div class="form-header-info">
              <div class="org">Department of Agrarian Reform — Regional Office V</div>
              <div class="txn-name" id="form-txn-name">—</div>
            </div>
          </div>
          <div class="required-note"><i class="bi bi-asterisk"></i> Fields with * are required/mandatory.</div>

          <div class="form-body">
            <form method="POST" action="{{ route('dashboard.store') }}" id="payment-form" novalidate>
              @csrf
              <input type="hidden" name="transaction_type" id="hidden-txn-type" />
              <input type="hidden" name="fund_type" id="hidden-fund-type" />

              <div class="section-heading"><i class="bi bi-card-checklist"></i> Payment Details</div>

              <!-- COMMON FIELDS -->
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
                <small style="font-size:.71rem; color:var(--muted); margin-top:4px; display:block;">Format: year-month-number series (e.g. F01-2026-01-0001). Generated automatically on save; resets monthly &amp; yearly.</small>
              </div>

              <!-- ══ EXTRA FIELDS PER TRANSACTION TYPE ══ -->

              <!-- 1. APPEAL FEE -->
              <div class="extra-fields" id="extra-appeal_fee">
                <hr class="extra-divider">
                <div class="extra-label">Appeal Fee Details</div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="appeal_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 2. BIDDING DOCUMENTS -->
              <div class="extra-fields" id="extra-bidding_documents">
                <hr class="extra-divider">
                <div class="extra-label">Bidding Document Details</div>
                <div class="field">
                  <label>Details of the Availed Bid : <span class="req">*</span></label>
                  <input name="bid_details" type="text" placeholder="e.g. Bid title, project name" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="bid_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 3. CASH BOND -->
              <div class="extra-fields" id="extra-cash_bond">
                <hr class="extra-divider">
                <div class="extra-label">Cash Bond Details</div>
                <div class="field">
                  <label>Total Area Applied for Conversion (in hectares) : <span class="req">*</span></label>
                  <input name="area_hectares" type="number" step="0.0001" min="0" placeholder="e.g. 2.5000" data-validate="numeric" />
                </div>
                <div class="field">
                  <label>Zonal Value : <span class="req">*</span></label>
                  <div class="amount-wrap"><span>₱</span><input name="zonal_value" type="number" step="0.01" min="0" placeholder="0.00" data-validate="numeric" /></div>
                </div>
                <div class="field">
                  <label>Location of Property / Landholding : <span class="req">*</span></label>
                  <input name="property_location" type="text" placeholder="e.g. Barangay, Municipality, Province" />
                </div>
                <div class="field">
                  <label>Assessment Form : <span class="req">*</span></label>
                  <input name="assessment_form" type="text" placeholder="Assessment form reference" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="cash_bond_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 4. CERTIFICATION, COPY FEE AND REPRODUCTION COST -->
              <div class="extra-fields" id="extra-certification_copy_fee">
                <hr class="extra-divider">
                <div class="extra-label">Certification / Copy Fee Details</div>
                <div class="field">
                  <label>Letter Request : <span class="req">*</span></label>
                  <input name="letter_request" type="text" placeholder="Reference to the letter request" />
                </div>
                <div class="field">
                  <label>Type of Transaction Paid : <span class="req">*</span></label>
                  <div class="check-group" id="cert-type-checks">
                    <label class="check-item"><input type="checkbox" name="cert_type[]" value="certification" onchange="toggleCheckItem(this)"> Certification</label>
                    <label class="check-item"><input type="checkbox" name="cert_type[]" value="copy_fee" onchange="toggleCheckItem(this)"> Copy Fee</label>
                    <label class="check-item"><input type="checkbox" name="cert_type[]" value="reproduction_cost" onchange="toggleCheckItem(this)"> Reproduction Cost</label>
                  </div>
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="cert_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 5. CONSIGNMENT -->
              <div class="extra-fields" id="extra-consignment">
                <hr class="extra-divider">
                <div class="extra-label">Consignment Details</div>
                <div class="field">
                  <label>Assessment Form No. : <span class="req">*</span></label>
                  <input name="consignment_assessment_form" type="text" placeholder="Assessment form number" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Case No. : <span class="req">*</span></label>
                  <input name="consignment_case_no" type="text" placeholder="e.g. DARAB Case No. 001-2025" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="consignment_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 6. EXECUTION OF JUDGMENT INVOLVING MONEY -->
              <div class="extra-fields" id="extra-execution_judgment">
                <hr class="extra-divider">
                <div class="extra-label">Execution of Judgment Details</div>
                <div class="field">
                  <label>Assessment Form No. : <span class="req">*</span></label>
                  <input name="exec_assessment_form" type="text" placeholder="Assessment form number" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Type of Transaction Paid : <span class="req">*</span></label>
                  <input name="exec_txn_type_paid" type="text" placeholder="Brief description of transaction type" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="exec_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 7. FILING FEE AND INSPECTION COST -->
              <div class="extra-fields" id="extra-filing_fee">
                <hr class="extra-divider">
                <div class="extra-label">Filing Fee / Inspection Details</div>
                <div class="field">
                  <label>Assessment Form : <span class="req">*</span></label>
                  <input name="filing_assessment_form" type="text" placeholder="Assessment form reference" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="filing_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 8. INCOME FROM SALE OF UNSERVICEABLE PROPERTY -->
              <div class="extra-fields" id="extra-income_unserviceable">
                <hr class="extra-divider">
                <div class="extra-label">Unserviceable Property Details</div>
                <div class="field">
                  <label>RDC Resolution No. : <span class="req">*</span></label>
                  <input name="rdc_resolution_no" type="text" placeholder="e.g. RDC-2025-001" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="unserviceable_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 9. LEGAL RESEARCH -->
              <div class="extra-fields" id="extra-legal_research">
                <hr class="extra-divider">
                <div class="extra-label">Legal Research Details</div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="legal_research_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 10. PERFORMANCE BOND -->
              <div class="extra-fields" id="extra-performance_bond">
                <hr class="extra-divider">
                <div class="extra-label">Performance Bond Details</div>
                <div class="field">
                  <label>Total Area Applied for Conversion (in hectares) : <span class="req">*</span></label>
                  <input name="pb_area_hectares" type="number" step="0.0001" min="0" placeholder="e.g. 2.5000" data-validate="numeric" />
                </div>
                <div class="field">
                  <label>Zonal Value : <span class="req">*</span></label>
                  <div class="amount-wrap"><span>₱</span><input name="pb_zonal_value" type="number" step="0.01" min="0" placeholder="0.00" data-validate="numeric" /></div>
                </div>
                <div class="field">
                  <label>Location of Property / Landholding : <span class="req">*</span></label>
                  <input name="pb_property_location" type="text" placeholder="e.g. Barangay, Municipality, Province" />
                </div>
                <div class="field">
                  <label>Assessment Form : <span class="req">*</span></label>
                  <input name="pb_assessment_form" type="text" placeholder="Assessment form reference" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="pb_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 11. REFUND OF CASH ADVANCES -->
              <div class="extra-fields" id="extra-refund_cash_advances">
                <hr class="extra-divider">
                <div class="extra-label">Refund of Cash Advances Details</div>
                <div class="field">
                  <label>Check / LDDAP-ADA Number : <span class="req">*</span></label>
                  <input name="check_lddap_ada" type="text" placeholder="Check or LDDAP-ADA number" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Date Cash Advance was Granted : <span class="req">*</span></label>
                  <input name="cash_advance_date" type="date" />
                </div>
                <div class="field">
                  <label>Division / Section of Payor : <span class="req">*</span></label>
                  <input name="division_section" type="text" placeholder="e.g. Finance Division" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="cash_advance_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 12. REFUND OF OVERPAYMENT -->
              <div class="extra-fields" id="extra-refund_overpayment">
                <hr class="extra-divider">
                <div class="extra-label">Refund of Overpayment Details</div>
                <div class="field">
                  <label>Division / Section of Payor : <span class="req">*</span></label>
                  <input name="refund_division_section" type="text" placeholder="e.g. Finance Division" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="refund_op_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 13. SETTLEMENT OF NOTICE OF DISALLOWANCES -->
              <div class="extra-fields" id="extra-settlement_disallowances">
                <hr class="extra-divider">
                <div class="extra-label">Notice of Disallowance Details</div>
                <div class="field">
                  <label>Notice of Disallowances No. : <span class="req">*</span></label>
                  <input name="disallowance_no" type="text" placeholder="e.g. ND-2025-001" data-validate="alphanumeric" />
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="disallowance_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- 14. UNWITHHELD REMITTANCES -->
              <div class="extra-fields" id="extra-unwithheld_remittances">
                <hr class="extra-divider">
                <div class="extra-label">Unwithheld Remittances Details</div>
                <div class="field">
                  <label>Type of Remittance : <span class="req">*</span></label>
                  <div class="remit-check-group">
                    <label class="remit-check-item" id="remit-gsis-wrap">
                      <input type="checkbox" name="remit_type[]" value="GSIS" onchange="toggleCheckItem(this)"> GSIS
                    </label>
                    <label class="remit-check-item" id="remit-phic-wrap">
                      <input type="checkbox" name="remit_type[]" value="PHIC" onchange="toggleCheckItem(this)"> PHIC — Philhealth
                    </label>
                    <label class="remit-check-item" id="remit-hdmf-wrap">
                      <input type="checkbox" name="remit_type[]" value="HDMF" onchange="toggleCheckItem(this)"> HDMF — Pag-IBIG
                    </label>
                    <label class="remit-check-item" id="remit-other-wrap">
                      <input type="checkbox" name="remit_type[]" value="Other" id="remit-other-chk" onchange="toggleCheckItem(this); toggleRemitOther(this)"> Other Payables
                    </label>
                  </div>
                  <div class="remit-open-field" id="remit-other-field">
                    <input name="remit_other_specify" type="text" placeholder="Please specify other payable…" style="margin-top:8px;" />
                  </div>
                </div>
                <div class="field">
                  <label>Open-ended Field <small style="color:var(--muted); font-weight:300;">(remarks, comments, and others)</small> :</label>
                  <textarea name="remit_remarks" placeholder="Enter any relevant remarks, comments, or additional information…" data-validate="text"></textarea>
                </div>
              </div>

              <!-- Payment Mode -->
              <div class="field" style="margin-top:6px;">
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

              <p class="review-note"><i class="bi bi-exclamation-circle-fill"></i> Please review payment details above before clicking Continue.</p>

              <button type="submit" class="btn-submit" id="submit-btn" disabled>
                <i class="bi bi-arrow-right-circle me-2"></i> Continue
              </button>

            </form>
          </div>
        </div><!-- /form-card -->

      </div><!-- /section-form -->
    </div><!-- /main-inner -->
    </main>
  </div>
</div><!-- /outer-wrapper -->

<!-- ════════════ TRANSACTIONS MODAL ════════════ -->
<div class="modal-overlay" id="txn-modal-overlay" onclick="closeModalOutside(event)">
  <div class="txn-modal">

    <div class="modal-head">
      <div class="modal-head-left">
        <div class="modal-head-icon"><i class="bi bi-list-check"></i></div>
        <div>
          <div class="modal-head-title">Transactions List</div>
          <div class="modal-head-sub">Approval Status Overview</div>
        </div>
      </div>
      <button class="modal-close-btn" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
    </div>

    <div class="modal-tabs">
      <button class="modal-tab tab-all active" onclick="setModalFilter('all', this)">
        All <span class="modal-tab-count" id="count-all">0</span>
      </button>
      <button class="modal-tab tab-approved" onclick="setModalFilter('approved', this)">
        <i class="bi bi-check-circle" style="color:var(--green-accent);"></i> Approved <span class="modal-tab-count" id="count-approved">0</span>
      </button>
      <button class="modal-tab tab-waiting" onclick="setModalFilter('waiting', this)">
        <i class="bi bi-hourglass-split" style="color:#a0700a;"></i> Waiting <span class="modal-tab-count" id="count-waiting">0</span>
      </button>
      <button class="modal-tab tab-rejected" onclick="setModalFilter('rejected', this)">
        <i class="bi bi-x-circle" style="color:var(--red);"></i> Rejected <span class="modal-tab-count" id="count-rejected">0</span>
      </button>
    </div>

    <div class="modal-search-bar">
      <div class="modal-search-inner">
        <i class="bi bi-search"></i>
        <input type="text" id="modal-search-input" placeholder="Search by name, type, or O.R. no…" oninput="onModalSearch()" />
      </div>
    </div>

    <div class="modal-list" id="modal-list"></div>

    <!-- ── PAGINATION FOOTER ── -->
    <div class="modal-foot">
      <span class="modal-foot-info" id="modal-foot-info">—</span>
      <div class="modal-foot-right">
        <div class="pg-per-page">
          Rows:
          <select id="per-page-sel" onchange="onPerPageChange()">
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="25">25</option>
          </select>
        </div>
        <div class="pagination" id="pagination-controls"></div>
      </div>
    </div>

  </div>
</div>

<script>
  /* ════════════════════════════════════════
     FUND SELECTION
  ════════════════════════════════════════ */
  let selectedFund = null;

  function selectFund(el) {
    document.querySelectorAll('.fund-item').forEach(f => f.classList.remove('active'));
    el.classList.add('active');
    selectedFund = {
      code:  el.dataset.fund,
      name:  el.dataset.name,
      label: el.dataset.label,
      dot:   el.querySelector('.fund-dot').textContent
    };
    document.getElementById('sidebar-selected-label').textContent = selectedFund.name;
    document.getElementById('sidebar-proceed-btn').classList.add('enabled');
  }

  function proceedToForm() {
    if (!selectedFund) return;
    document.getElementById('hidden-fund-type').value = selectedFund.code;
    document.getElementById('fund-banner-dot').textContent = selectedFund.dot;
    document.getElementById('fund-banner-name').textContent = selectedFund.name + ' — ' + selectedFund.label;
    document.getElementById('fund-banner-wrap').classList.add('show');
    document.getElementById('section-gate').style.display = 'none';
    document.getElementById('section-form').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function changeFund() {
    selectedFund = null;
    document.querySelectorAll('.fund-item').forEach(f => f.classList.remove('active'));
    document.getElementById('sidebar-selected-label').textContent = '—';
    document.getElementById('sidebar-proceed-btn').classList.remove('enabled');
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

  /* ════════════════════════════════════════
     TRANSACTION TYPE SELECT
  ════════════════════════════════════════ */
  document.getElementById('txn-select').addEventListener('change', function () {
    const val   = this.value;
    const label = this.options[this.selectedIndex].text;
    document.getElementById('hidden-txn-type').value = val;
    document.getElementById('form-txn-name').textContent = label;

    document.querySelectorAll('.extra-fields').forEach(el => {
      el.classList.remove('show');
      el.querySelectorAll('input[required],textarea[required],select[required]').forEach(f => f.removeAttribute('required'));
    });

    const target = document.getElementById('extra-' + val);
    if (target) {
      target.classList.add('show');
      target.querySelectorAll('[data-orig-required="1"]').forEach(f => f.setAttribute('required', ''));
    }

    document.getElementById('form-card').classList.add('visible');
    document.getElementById('agree_terms').checked = false;
    document.getElementById('submit-btn').disabled = true;
    setTimeout(() => {
      document.getElementById('form-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 80);
  });

  document.getElementById('agree_terms').addEventListener('change', function () {
    document.getElementById('submit-btn').disabled = !this.checked;
  });

  /* ════════════════════════════════════════
     CHECKBOX STYLING
  ════════════════════════════════════════ */
  function toggleCheckItem(el) {
    el.closest('.check-item, .remit-check-item').classList.toggle('checked', el.checked);
  }

  function toggleRemitOther(el) {
    document.getElementById('remit-other-field').classList.toggle('show', el.checked);
  }

  // Preserve original required state
  document.querySelectorAll('.extra-fields [required]').forEach(f => f.setAttribute('data-orig-required', '1'));

  /* ════════════════════════════════════════
     MODAL — STATE
  ════════════════════════════════════════ */
  let _allTransactions = [];  // raw data from server (or demo)
  let _modalFilter     = 'all';
  let _modalQuery      = '';
  let _modalPage       = 1;
  let _modalPerPage    = 5;

  /* ── Demo data (used when /payments.json is unavailable) ── */
  const DEMO_DATA = [
    { name:'Juan Dela Cruz',    transaction_type:'Filing Fee and Inspection Cost',                  status:'approved', created_at:'8:14 AM',  op_number:'F01-2026-01-0001', fund_type:'Fund 01', amount:'1,500.00' },
    { name:'Maria Santos',      transaction_type:'Certification, Copy Fee and Reproduction Cost',   status:'waiting',  created_at:'9:02 AM',  op_number:'F01-2026-01-0002', fund_type:'Fund 03', amount:'250.00' },
    { name:'Pedro Reyes',       transaction_type:'Cash Bond',                                       status:'approved', created_at:'9:45 AM',  op_number:'F01-2026-01-0003', fund_type:'Fund 01', amount:'5,000.00' },
    { name:'Ana Garcia',        transaction_type:'Appeal Fee',                                      status:'waiting',  created_at:'10:18 AM', op_number:'F01-2026-01-0004', fund_type:'Fund 07', amount:'3,200.00' },
    { name:'Roberto Luna',      transaction_type:'Refund of Overpayment',                           status:'approved', created_at:'11:00 AM', op_number:'F01-2026-01-0005', fund_type:'Fund 01', amount:'800.00' },
    { name:'Liza Reyes',        transaction_type:'Legal Research',                                  status:'approved', created_at:'11:22 AM', op_number:'F01-2026-01-0006', fund_type:'Fund 01', amount:'150.00' },
    { name:'Carlo Mendoza',     transaction_type:'Performance Bond',                                status:'waiting',  created_at:'11:45 AM', op_number:'F01-2026-01-0007', fund_type:'Fund 03', amount:'12,000.00' },
    { name:'Sofia Torres',      transaction_type:'Settlement of Notice of Disallowances',           status:'approved', created_at:'1:05 PM',  op_number:'F01-2026-01-0008', fund_type:'Fund 07', amount:'4,400.00' },
    { name:'Renato Flores',     transaction_type:'Consignment',                                     status:'waiting',  created_at:'1:30 PM',  op_number:'F01-2026-01-0009', fund_type:'Fund 01', amount:'900.00' },
    { name:'Grace Villanueva',  transaction_type:'Bidding Documents',                               status:'approved', created_at:'2:00 PM',  op_number:'F01-2026-01-0010', fund_type:'Fund 01', amount:'500.00' },
    { name:'Marco Bautista',    transaction_type:'Unwithheld Remittances',                          status:'approved', created_at:'2:30 PM',  op_number:'F01-2026-01-0011', fund_type:'Fund 03', amount:'2,100.00' },
    { name:'Hazel Dela Torre',  transaction_type:'Income from Sale of Unserviceable Property',      status:'rejected', created_at:'3:00 PM',  op_number:'F01-2026-01-0012', fund_type:'Fund 01', amount:'7,800.00' },
  ];

  /* ── Helpers ── */
  function escapeHtml(s) {
    return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }
  function capitalize(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; }

  function iconForType(type) {
    type = (type || '').toLowerCase();
    if (type.includes('cash bond') || type.includes('cash'))          return { icon:'bi-cash-stack',            cls:'mi-blue' };
    if (type.includes('appeal'))                                       return { icon:'bi-gavel',                  cls:'mi-red' };
    if (type.includes('bidding'))                                      return { icon:'bi-file-ruled',             cls:'mi-green' };
    if (type.includes('certification') || type.includes('copy'))       return { icon:'bi-file-earmark-check',    cls:'mi-gold' };
    if (type.includes('consignment'))                                  return { icon:'bi-box-seam',               cls:'mi-blue' };
    if (type.includes('execution') || type.includes('judgment'))       return { icon:'bi-balance-scale',         cls:'mi-red' };
    if (type.includes('filing'))                                       return { icon:'bi-file-earmark-text',     cls:'mi-green' };
    if (type.includes('unserviceable') || type.includes('income'))     return { icon:'bi-tag',                   cls:'mi-gold' };
    if (type.includes('legal'))                                        return { icon:'bi-book',                  cls:'mi-green' };
    if (type.includes('performance'))                                  return { icon:'bi-shield-check',          cls:'mi-blue' };
    if (type.includes('refund') || type.includes('overpayment'))       return { icon:'bi-arrow-counterclockwise',cls:'mi-blue' };
    if (type.includes('advance'))                                      return { icon:'bi-wallet2',               cls:'mi-gold' };
    if (type.includes('disallowance') || type.includes('settlement'))  return { icon:'bi-receipt',              cls:'mi-gold' };
    if (type.includes('remittance'))                                   return { icon:'bi-send',                  cls:'mi-gold' };
    return { icon:'bi-file-earmark', cls:'mi-green' };
  }

  /* ── Filtered dataset ── */
  function getFiltered() {
    return _allTransactions.filter(t => {
      const matchF = _modalFilter === 'all' || t.status === _modalFilter;
      const matchQ = !_modalQuery || (
        (t.name || '') + ' ' + (t.transaction_type || '') + ' ' + (t.op_number || '')
      ).toLowerCase().includes(_modalQuery);
      return matchF && matchQ;
    });
  }

  /* ── Render list + pagination ── */
  function renderModal() {
    const data  = getFiltered();
    const total = data.length;
    const totalPages = Math.max(1, Math.ceil(total / _modalPerPage));
    if (_modalPage > totalPages) _modalPage = totalPages;

    const start = (_modalPage - 1) * _modalPerPage;
    const slice = data.slice(start, start + _modalPerPage);

    /* List */
    const list = document.getElementById('modal-list');
    if (slice.length === 0) {
      list.innerHTML = '<div class="modal-empty"><i class="bi bi-inbox"></i><p>No transactions match your filter.</p></div>';
    } else {
      list.innerHTML = slice.map(p => {
        const status   = p.status || 'waiting';
        const badgeCls = status === 'approved' ? 'ms-approved' : status === 'rejected' ? 'ms-rejected' : 'ms-waiting';
        const badgeIco = status === 'approved' ? 'bi-check-circle-fill' : status === 'rejected' ? 'bi-x-circle-fill' : 'bi-hourglass-split';
        const { icon, cls } = iconForType(p.transaction_type);
        const amount   = p.amount ? '₱' + p.amount : '₱0.00';
        const nameSafe = escapeHtml(p.name || '—');
        const typeSafe = escapeHtml(p.transaction_type || '—');
        const timeSafe = escapeHtml(p.created_at || '');
        const opSafe   = escapeHtml(p.op_number || '—');
        const fundSafe = escapeHtml(p.fund_type || '—');

        return `<div class="modal-txn-row">
          <div class="modal-txn-icon ${cls}"><i class="bi ${icon}"></i></div>
          <div class="modal-txn-main">
            <div class="modal-txn-name">${nameSafe}</div>
            <div class="modal-txn-type">${typeSafe}</div>
            <div class="modal-txn-meta"><i class="bi bi-clock"></i> ${timeSafe} &nbsp;·&nbsp; <i class="bi bi-hash"></i> ${opSafe} &nbsp;·&nbsp; ${fundSafe}</div>
          </div>
          <div class="modal-txn-right">
            <div class="modal-txn-amount">${escapeHtml(amount)}</div>
            <span class="modal-status-badge ${badgeCls}"><i class="bi ${badgeIco}"></i> ${capitalize(status)}</span>
            <div class="modal-txn-or">O.R. #${opSafe}</div>
          </div>
        </div>`;
      }).join('');
    }

    /* Footer info */
    const from = total === 0 ? 0 : start + 1;
    const to   = Math.min(start + _modalPerPage, total);
    document.getElementById('modal-foot-info').innerHTML =
      total === 0
        ? 'No results'
        : `Showing <strong>${from}–${to}</strong> of <strong>${total}</strong> transactions`;

    /* Pagination */
    renderPaginationControls(totalPages);

    /* Tab counts */
    updateTabCounts();
  }

  /* ── Pagination button builder ── */
  function pagerRange(current, total) {
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    const pages = [];
    if (current <= 4) {
      for (let i = 1; i <= 5; i++) pages.push(i);
      pages.push('…');
      pages.push(total);
    } else if (current >= total - 3) {
      pages.push(1);
      pages.push('…');
      for (let i = total - 4; i <= total; i++) pages.push(i);
    } else {
      pages.push(1);
      pages.push('…');
      pages.push(current - 1);
      pages.push(current);
      pages.push(current + 1);
      pages.push('…');
      pages.push(total);
    }
    return pages;
  }

  function renderPaginationControls(totalPages) {
    const pg = document.getElementById('pagination-controls');
    let html = '';

    /* Prev button */
    html += `<button class="pg-btn" onclick="goModalPage(${_modalPage - 1})" ${_modalPage <= 1 ? 'disabled' : ''} aria-label="Previous page">
               <i class="bi bi-chevron-left" style="font-size:.7rem;"></i>
             </button>`;

    /* Page number buttons */
    pagerRange(_modalPage, totalPages).forEach(p => {
      if (p === '…') {
        html += `<span class="pg-ellipsis">…</span>`;
      } else {
        html += `<button class="pg-btn${p === _modalPage ? ' active' : ''}" onclick="goModalPage(${p})" aria-label="Page ${p}">${p}</button>`;
      }
    });

    /* Next button */
    html += `<button class="pg-btn" onclick="goModalPage(${_modalPage + 1})" ${_modalPage >= totalPages ? 'disabled' : ''} aria-label="Next page">
               <i class="bi bi-chevron-right" style="font-size:.7rem;"></i>
             </button>`;

    pg.innerHTML = html;
  }

  function goModalPage(p) {
    const total = Math.ceil(getFiltered().length / _modalPerPage);
    if (p < 1 || p > total) return;
    _modalPage = p;
    renderModal();
  }

  function updateTabCounts() {
    const counts = { all: 0, approved: 0, waiting: 0, rejected: 0 };
    _allTransactions.forEach(t => {
      counts.all++;
      if (counts[t.status] !== undefined) counts[t.status]++;
    });
    document.getElementById('count-all').textContent      = counts.all;
    document.getElementById('count-approved').textContent = counts.approved;
    document.getElementById('count-waiting').textContent  = counts.waiting;
    document.getElementById('count-rejected').textContent = counts.rejected;
  }

  /* ── Modal controls ── */
  function setModalFilter(status, btn) {
    _modalFilter = status;
    _modalPage   = 1;
    document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    renderModal();
  }

  function onModalSearch() {
    _modalQuery = document.getElementById('modal-search-input').value.toLowerCase().trim();
    _modalPage  = 1;
    renderModal();
  }

  function onPerPageChange() {
    _modalPerPage = parseInt(document.getElementById('per-page-sel').value);
    _modalPage    = 1;
    renderModal();
  }

  function openModal() {
    document.getElementById('txn-modal-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';

    // Reset state
    _modalFilter = 'all';
    _modalQuery  = '';
    _modalPage   = 1;
    document.getElementById('modal-search-input').value = '';
    document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
    document.querySelector('.modal-tab.tab-all').classList.add('active');

    // Show loading
    document.getElementById('modal-list').innerHTML =
      '<div class="modal-empty"><i class="bi bi-hourglass-split" style="animation:spin 1s linear infinite;"></i><p>Loading transactions…</p></div>';
    document.getElementById('pagination-controls').innerHTML = '';
    document.getElementById('modal-foot-info').textContent = '—';

    // Fetch from server; fall back to demo data
    fetch('/payments.json')
      .then(r => r.ok ? r.json() : Promise.reject(r))
      .then(payments => {
        _allTransactions = Array.isArray(payments) ? payments : [];
        renderModal();
      })
      .catch(() => {
        _allTransactions = DEMO_DATA;
        renderModal();
      });
  }

  function closeModal() {
    document.getElementById('txn-modal-overlay').classList.remove('open');
    document.body.style.overflow = '';
  }

  function closeModalOutside(e) {
    if (e.target === document.getElementById('txn-modal-overlay')) closeModal();
  }

  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

  /* ════════════════════════════════════════
     CLIENT-SIDE VALIDATION
  ════════════════════════════════════════ */
  const __validators = {
    numeric:     v => /^\d+(?:\.\d+)?$/.test(String(v).trim()),
    alphanumeric:v => /^[A-Za-z0-9\-\_\s]+$/.test(String(v).trim()),
    tel:         v => /^[0-9+\-\s()]+$/.test(String(v).trim())
  };

  function validateField(input) {
    const rule  = input.dataset.validate;
    const field = input.closest('.field');
    if (!rule) return true;
    const val = String(input.value || '').trim();
    let ok = true;
    if (input.required && val === '') ok = false;
    else if (val !== '') {
      const fn = __validators[rule];
      if (fn) ok = fn(val);
    }
    if (!ok) {
      field.classList.add('invalid');
      let em = field.querySelector('.error-msg');
      if (!em) { em = document.createElement('div'); em.className = 'error-msg'; field.appendChild(em); }
      em.textContent =
        rule === 'numeric'      ? 'This field requires a numeric value.' :
        rule === 'alphanumeric' ? 'Only letters, numbers, spaces, dash and underscore are allowed.' :
        rule === 'tel'          ? 'Please enter a valid contact number.' : 'Invalid value.';
    } else {
      field.classList.remove('invalid');
      const em = field.querySelector('.error-msg'); if (em) em.remove();
    }
    return ok;
  }

  document.querySelectorAll('[data-validate]').forEach(inp => {
    inp.addEventListener('input', () => validateField(inp));
    inp.addEventListener('blur',  () => validateField(inp));
  });

  const paymentForm = document.getElementById('payment-form');
  if (paymentForm) {
    paymentForm.addEventListener('submit', function (e) {
      let firstInvalid = null;
      this.querySelectorAll('[data-validate]').forEach(i => {
        const extra = i.closest('.extra-fields');
        if (extra && !extra.classList.contains('show')) return;
        if (!validateField(i) && !firstInvalid) firstInvalid = i;
      });
      if (firstInvalid) { e.preventDefault(); firstInvalid.focus(); }
    });
  }

  /* spin animation for loading icon */
  /* ─────────────────────────────────────────────────────
     Form draft persistence (save & restore using localStorage)
     This preserves user input when they accidentally navigate away.
  ───────────────────────────────────────────────────── */
  (function(){
    const DRAFT_KEY = 'maker_form_draft_v1';

    function saveDraft() {
      const obj = {};
      obj.selectedFund = selectedFund || null;
      obj.txnSelect = document.getElementById('txn-select')?.value || '';
      obj.agree_terms = !!document.getElementById('agree_terms')?.checked;

      const form = document.getElementById('payment-form');
      if (form) {
        Array.from(form.elements).forEach(el => {
          if (!el.name) return;
          const name = el.name;
          // don't persist framework-hidden fields (CSRF token, method, etc.)
          if (name.startsWith('_')) return;
          if (el.type === 'checkbox') {
            if (name.endsWith('[]')) {
              const base = name.replace(/\[\]$/, '');
              obj[base] = obj[base] || [];
              if (el.checked) obj[base].push(el.value);
            } else {
              obj[name] = el.checked;
            }
          } else if (el.type === 'radio') {
            if (el.checked) obj[name] = el.value;
          } else {
            obj[name] = el.value;
          }
        });
      }
      try { localStorage.setItem(DRAFT_KEY, JSON.stringify(obj)); } catch (e) { /* ignore */ }
    }

    function restoreDraft() {
      let raw = null;
      try { raw = localStorage.getItem(DRAFT_KEY); } catch (e) { return; }
      if (!raw) return;
      let obj;
      try { obj = JSON.parse(raw); } catch (e) { return; }

      if (obj.selectedFund) {
        const fund = obj.selectedFund;
        const el = document.querySelector(`.fund-item[data-fund="${fund.code}"]`);
        if (el) selectFund(el);
      }

      if (obj.txnSelect) {
        const sel = document.getElementById('txn-select');
        if (sel) {
          sel.value = obj.txnSelect;
          sel.dispatchEvent(new Event('change'));
        }
      }

      const form = document.getElementById('payment-form');
      if (form) {
        Array.from(form.elements).forEach(el => {
          if (!el.name) return;
          const name = el.name;
          // skip restoring framework-hidden fields (CSRF token, method, etc.)
          if (name.startsWith('_')) return;
          if (el.type === 'checkbox') {
            if (obj[name] !== undefined) {
              el.checked = !!obj[name];
            } else if (obj[name.replace(/\[\]$/,'')] && Array.isArray(obj[name.replace(/\[\]$/,'')])) {
              const arr = obj[name.replace(/\[\]$/,'')];
              el.checked = arr.includes(el.value);
            }
            el.dispatchEvent(new Event('change'));
          } else if (el.type === 'radio') {
            if (obj[name] && obj[name] === el.value) el.checked = true;
          } else {
            if (obj[name] !== undefined) el.value = obj[name];
          }
        });
      }

      if (obj.agree_terms) {
        const ag = document.getElementById('agree_terms');
        if (ag) { ag.checked = true; document.getElementById('submit-btn').disabled = !ag.checked; }
      }
    }

    window.addEventListener('load', restoreDraft);
    document.addEventListener('input', function(e){
      if (!e.target) return; if (!e.target.closest) return;
      if (e.target.closest('#payment-form')) saveDraft();
    }, true);
    document.addEventListener('change', function(e){ if (e.target && e.target.closest && e.target.closest('#payment-form')) saveDraft(); }, true);
    window.addEventListener('beforeunload', saveDraft);
    document.getElementById('payment-form')?.addEventListener('submit', function(){ try{ localStorage.removeItem(DRAFT_KEY); }catch(e){} });
  })();

  const spinStyle = document.createElement('style');
  spinStyle.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
  document.head.appendChild(spinStyle);
</script>
  @if(session('success'))
  <script>try{ localStorage.removeItem('maker_form_draft_v1'); }catch(e){} </script>
  @endif
</body>
</html>