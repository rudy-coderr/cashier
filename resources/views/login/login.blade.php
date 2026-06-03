<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In — DAR Cashier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="icon" href="{{ asset('img/dar_logo_square.jpg') }}" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --green-deep:   #14532d;
      --green-dark:   #0f1f15;
      --green-mid:    #15803d;
      --green-accent: #16a34a;
      --green-light:  #f0fdf4;
      --gold:         #d97706;
      --gold-soft:    #fef3c7;
      --slate-50:     #f8fafc;
      --slate-100:    #f1f5f9;
      --slate-200:    #e2e8f0;
      --slate-400:    #94a3b8;
      --slate-500:    #64748b;
      --slate-700:    #334155;
      --slate-900:    #0f172a;
      --red:          #dc2626;
      --blue:         #1d4ed8;
      --violet:       #7c3aed;
    }

    html, body {
      height: 100%;
      font-family: 'JetBrains Mono', monospace;
      background: var(--slate-100);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    /* ── TOP STRIPE ── */
    .stripe {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--green-accent) 0%, var(--gold) 50%, var(--red) 100%);
      z-index: 100;
    }

    /* ── CARD ── */
    .card {
      width: 100%;
      max-width: 780px;
      display: flex;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--slate-200);
      box-shadow: 0 4px 6px -1px rgba(0,0,0,.07), 0 20px 60px -12px rgba(0,0,0,.12);
      animation: slide-up .5s cubic-bezier(.16,1,.3,1) both;
    }

    @keyframes slide-up {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── LEFT PANEL ── */
    .panel-left {
      width: 300px;
      flex-shrink: 0;
      background: linear-gradient(160deg, var(--green-deep) 0%, var(--green-dark) 100%);
      padding: 36px 30px;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow: hidden;
    }

    /* Subtle grid texture */
    .panel-left::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
      background-size: 24px 24px;
      pointer-events: none;
    }

    /* Glow orb */
    .panel-left::after {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 200px; height: 200px;
      background: radial-gradient(circle, rgba(22,163,74,.2) 0%, transparent 70%);
      pointer-events: none;
    }

    /* ── Brand ── */
    .brand {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 28px;
    }

    .brand-logo {
      width: 36px;
      height: 36px;
      border-radius: 9px;
      background: rgba(255,255,255,.95);
      border: 1px solid rgba(255,255,255,.4);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      flex-shrink: 0;
      padding: 3px;
    }

    .brand-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .brand-text {
      padding-top: 2px;
    }

    .brand-text .t1 {
      font-size: 9px;
      font-weight: 600;
      color: rgba(255,255,255,.5);
      letter-spacing: .12em;
      text-transform: uppercase;
      line-height: 1;
      margin-bottom: 3px;
    }

    .brand-text .t2 {
      font-size: 10.5px;
      font-weight: 700;
      color: rgba(255,255,255,.9);
      line-height: 1.2;
      letter-spacing: -.01em;
    }

    /* Online badge */
    .online-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 8px;
      border-radius: 99px;
      background: rgba(255,255,255,.1);
      border: 1px solid rgba(255,255,255,.15);
      font-size: 8.5px;
      color: rgba(255,255,255,.6);
      letter-spacing: .05em;
      position: relative;
      z-index: 1;
      width: fit-content;
      margin-bottom: 32px;
    }

    .online-dot {
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: #4ade80;
      box-shadow: 0 0 5px #4ade80;
      flex-shrink: 0;
    }

    /* ── System title ── */
    .sys-title {
      position: relative;
      z-index: 1;
      flex: 1;
    }

    .sys-eyebrow {
      font-size: 8px;
      font-weight: 600;
      letter-spacing: .18em;
      text-transform: uppercase;
      color: rgba(217,119,6,.8);
      margin-bottom: 10px;
    }

    .sys-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 700;
      line-height: 1.05;
      color: #fff;
      margin-bottom: 6px;
    }

    .sys-name em {
      font-style: normal;
      color: #86efac;
    }

    .sys-divider {
      width: 28px;
      height: 2px;
      background: var(--gold);
      border-radius: 2px;
      margin: 14px 0;
      opacity: .7;
    }

    .sys-desc {
      font-size: 10px;
      color: rgba(255,255,255,.4);
      line-height: 1.7;
      font-weight: 400;
      max-width: 210px;
    }


    /* ── RIGHT PANEL ── */
    .panel-right {
      flex: 1;
      background: #fff;
      padding: 44px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-eyebrow {
      font-size: 9px;
      font-weight: 600;
      letter-spacing: .15em;
      text-transform: uppercase;
      color: var(--green-accent);
      margin-bottom: 8px;
    }

    .form-heading {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--slate-900);
      line-height: 1;
      letter-spacing: -.02em;
      margin-bottom: 5px;
    }

    .form-sub {
      font-size: 10.5px;
      color: var(--slate-400);
      margin-bottom: 28px;
      font-weight: 400;
      letter-spacing: .01em;
    }

    /* ── Fields ── */
    .field {
      margin-bottom: 14px;
      position: relative;
    }

    .field label {
      display: block;
      font-size: 9px;
      font-weight: 700;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: var(--slate-500);
      margin-bottom: 6px;
    }

    .field-wrap {
      position: relative;
    }

    .field-ico {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--slate-400);
      font-size: .85rem;
      pointer-events: none;
    }

    .toggle-pw {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--slate-400);
      font-size: .9rem;
      cursor: pointer;
      background: none;
      border: none;
      padding: 0;
      line-height: 1;
    }

    .field input {
      width: 100%;
      padding: 10px 38px 10px 36px;
      border: 1.5px solid var(--slate-200);
      border-radius: 8px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      color: var(--slate-900);
      background: var(--slate-50);
      outline: none;
      transition: border-color .15s, box-shadow .15s, background .15s;
      letter-spacing: .01em;
    }

    .field input::placeholder { color: var(--slate-400); }

    .field input:focus {
      border-color: var(--green-accent);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(22,163,74,.1);
    }

    /* ── Options row ── */
    .row-options {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 8px;
    }

    .remember-label {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 10px;
      color: var(--slate-500);
      cursor: pointer;
      user-select: none;
    }

    .remember-label input[type="checkbox"] {
      accent-color: var(--green-accent);
      width: 13px; height: 13px;
      cursor: pointer;
    }

    .link-forgot {
      font-size: 10px;
      color: var(--slate-400);
      text-decoration: none;
      transition: color .15s;
      letter-spacing: .01em;
    }

    .link-forgot:hover { color: var(--green-accent); }

    /* ── Submit ── */
    .btn-signin {
      width: 100%;
      padding: 11px;
      background: var(--green-deep);
      border: none;
      border-radius: 8px;
      color: #fff;
      font-family: 'JetBrains Mono', monospace;
      font-weight: 700;
      font-size: 10.5px;
      letter-spacing: .12em;
      text-transform: uppercase;
      cursor: pointer;
      transition: background .15s, transform .12s, box-shadow .15s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      box-shadow: 0 2px 8px rgba(20,83,45,.25), 0 1px 2px rgba(0,0,0,.08);
    }

    .btn-signin:hover {
      background: var(--green-mid);
      transform: translateY(-1px);
      box-shadow: 0 4px 16px rgba(20,83,45,.35);
    }

    .btn-signin:active { transform: translateY(0); }

    .secure-note {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      font-size: 9px;
      color: var(--slate-400);
      margin-top: 14px;
      letter-spacing: .05em;
    }

    .secure-note i { color: var(--gold); font-size: .75rem; }

    /* ── Footer ── */
    .page-footer {
      position: fixed;
      bottom: 16px;
      left: 0; right: 0;
      text-align: center;
      font-size: 9px;
      color: var(--slate-400);
      letter-spacing: .08em;
    }

    /* ── Responsive ── */
    @media (max-width: 580px) {
      .panel-left { display: none; }
      .panel-right { padding: 36px 28px; }
    }
  </style>
</head>
<body>

  <div class="stripe"></div>

  <div class="card">

    <!-- LEFT -->
    <div class="panel-left">

      <div class="brand">
        <div class="brand-logo">
          <img src="{{ asset('img/dar_logo_square.jpg') }}" alt="DAR Logo" />
        </div>
        <div class="brand-text">
          <div class="t1">Republic of the Philippines</div>
          <div class="t2">Department of Agrarian Reform<br>Regional Office V</div>
        </div>
      </div>

      <div class="online-badge">
        <span class="online-dot"></span>
        System Online
      </div>

      <div class="sys-title">
<div class="sys-name">Cashier<br><em>Transaction</em><br>Management</div>
        <div class="sys-divider"></div>
        <div class="sys-desc">Secure access portal for authorized Department of Agrarian Reform personnel.</div>
      </div>


    </div>

    <!-- RIGHT -->
    <div class="panel-right">

      <div class="form-eyebrow">Sign In</div>
      <h1 class="form-heading">Welcome back.</h1>
      <p class="form-sub">Enter your credentials to access the system.</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
          <label for="email">Email Address</label>
          <div class="field-wrap">
            <i class="bi bi-envelope field-ico"></i>
            <input
              id="email"
              name="email"
              type="email"
              placeholder="you@dar.gov.ph"
              autocomplete="email"
              value="{{ old('email') }}"
              required
            />
          </div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="field-wrap">
            <i class="bi bi-lock field-ico"></i>
            <input
              id="password"
              name="password"
              type="password"
              placeholder="••••••••"
              autocomplete="current-password"
              required
            />
            <button type="button" class="toggle-pw" title="Show password">
              <i class="bi bi-eye-slash"></i>
            </button>
          </div>
        </div>

        <div class="row-options">
          <label class="remember-label">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            Remember me
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="link-forgot">Forgot password?</a>
          @endif
        </div>

        <button type="submit" class="btn-signin">
          <i class="bi bi-box-arrow-in-right"></i>
          Sign In
        </button>

        <p class="secure-note">
          <i class="bi bi-lock-fill"></i>
          Restricted to authorized DAR personnel only
        </p>

      </form>

    </div>

  </div>

  <p class="page-footer">&copy; {{ date('Y') }} Department of Agrarian Reform — Republic of the Philippines</p>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Password toggle
    document.querySelectorAll('.toggle-pw').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var input = btn.closest('.field-wrap').querySelector('input');
        var ico = btn.querySelector('i');
        if (!input) return;
        if (input.type === 'password') {
          input.type = 'text';
          ico.classList.replace('bi-eye-slash', 'bi-eye');
          btn.title = 'Hide password';
        } else {
          input.type = 'password';
          ico.classList.replace('bi-eye', 'bi-eye-slash');
          btn.title = 'Show password';
        }
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      @if ($errors->any())
        Swal.fire({
          icon: 'error',
          title: 'Sign In Failed',
          text: {!! json_encode($errors->first()) !!},
          confirmButtonColor: '#14532d'
        });
      @endif

      @if (session('success'))
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: {!! json_encode(session('success')) !!},
          confirmButtonColor: '#14532d'
        });
      @endif

      @if (session('status'))
        Swal.fire({
          icon: 'info',
          title: 'Notice',
          text: {!! json_encode(session('status')) !!},
          confirmButtonColor: '#14532d'
        });
      @endif
    });
  </script>
</body>
</html>
