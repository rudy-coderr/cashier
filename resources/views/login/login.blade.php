<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In — DAR Cashier Transaction Management System</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <style>
    :root {
      --green-deep:    #0e2a1a;
      --green-mid:     #1a4a2e;
      --green-accent:  #2d7a4f;
      --gold:          #c9992a;
      --gold-light:    #e8c46a;
      --red:           #a0251c;
      --cream:         #f5f0e8;
      --muted:         #8a9e90;
      --border:        #e2ddd5;
      --input-bg:      #faf8f4;
      --text-dark:     #0e2a1a;
      --text-mid:      #3d5045;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: var(--green-deep);
      padding: 24px;
      position: relative;
      overflow-x: hidden;
    }

    /* ── BACKGROUND ── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background:
        radial-gradient(ellipse 70% 55% at 10% 100%, rgba(45,122,79,.35) 0%, transparent 55%),
        radial-gradient(ellipse 50% 40% at 92%  0%,  rgba(160,37,28,.18) 0%, transparent 50%),
        radial-gradient(ellipse 40% 35% at 50% 50%,  rgba(201,153,42,.07) 0%, transparent 60%);
      pointer-events: none;
      z-index: 0;
    }

    body::after {
      content: '';
      position: fixed;
      inset: 0;
      background-image: radial-gradient(rgba(245,240,232,.05) 1px, transparent 1px);
      background-size: 28px 28px;
      pointer-events: none;
      z-index: 0;
    }

    /* ── STRIPE ── */
    .stripe {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red));
      z-index: 100;
    }

    /* ── CARD ── */
    .login-card {
      <!-- Favicon -->
      <link rel="icon" href="{{ asset('img/dar-logo.png') }}" />
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 720px;
      display: flex;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 32px 80px rgba(0,0,0,.5);
      border: 1px solid rgba(245,240,232,.1);
      animation: card-in .7s cubic-bezier(.16,1,.3,1) both;
    }

    @keyframes card-in {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── LEFT PANEL ── */
    .panel-visual {
      flex: 1;
      background: linear-gradient(150deg, var(--green-mid) 0%, var(--green-deep) 100%);
      padding: 48px 36px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    /* decorative rings */
    .panel-visual::before {
      content: '';
      position: absolute;
      right: -70px; bottom: -70px;
      width: 300px; height: 300px;
      border: 1.5px solid rgba(201,153,42,.15);
      border-radius: 50%;
      pointer-events: none;
    }

    .panel-visual::after {
      content: '';
      position: absolute;
      right: -30px; bottom: -30px;
      width: 190px; height: 190px;
      border: 1.5px solid rgba(201,153,42,.1);
      border-radius: 50%;
      pointer-events: none;
    }

    .visual-seal {
      width: 52px; height: 52px;
      border-radius: 50%;
      overflow: hidden;
      display: block;
      box-shadow: 0 0 0 4px rgba(201,153,42,.25);
      animation: pulse-seal 3s ease-in-out infinite;
      background: transparent;
    }

    .visual-seal img {
      width: 100%;
      height: 100%;
      display: block;
      object-fit: cover;
    }

    @keyframes pulse-seal {
      0%,100% { box-shadow: 0 0 0 4px rgba(201,153,42,.25); }
      50%      { box-shadow: 0 0 0 8px rgba(201,153,42,.1); }
    }

    .visual-copy {
      margin-top: 28px;
    }

    .visual-eyebrow {
      font-size: .6rem;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--gold-light);
      opacity: .7;
      font-weight: 500;
    }

    .visual-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.7rem, 2.8vw, 2.4rem);
      font-weight: 700;
      line-height: 1.1;
      color: var(--cream);
      margin-top: 10px;
    }

    .visual-title em {
      font-style: normal;
      color: var(--gold-light);
    }

    .visual-rule {
      width: 36px; height: 2px;
      background: var(--gold);
      border-radius: 2px;
      margin: 18px 0;
    }

    .visual-desc {
      font-size: .82rem;
      color: var(--muted);
      line-height: 1.7;
      font-weight: 300;
      max-width: 220px;
    }

    .visual-badges {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .v-badge {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: .78rem;
      color: rgba(245,240,232,.55);
      font-weight: 400;
    }

    .v-badge i {
      color: var(--gold-light);
      font-size: .9rem;
      width: 16px;
      text-align: center;
    }

    .watermark {
      position: absolute;
      bottom: 16px; right: 14px;
      font-size: .52rem;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: rgba(245,240,232,.1);
      font-weight: 600;
      writing-mode: vertical-rl;
    }

    /* ── RIGHT FORM PANEL ── */
    .panel-form {
      flex: 1;
      background: #ffffff;
      padding: 48px 42px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-heading {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--text-dark);
      letter-spacing: -.3px;
      margin-bottom: 4px;
    }

    .form-sub {
      font-size: .8rem;
      color: #7a9080;
      margin-bottom: 28px;
      font-weight: 300;
    }

    /* inputs */
    .field {
      position: relative;
      margin-bottom: 14px;
    }

    .field label {
      display: block;
      font-size: .72rem;
      font-weight: 600;
      letter-spacing: .8px;
      text-transform: uppercase;
      color: var(--text-mid);
      margin-bottom: 6px;
    }

    .field .ico {
      position: absolute;
      left: 14px;
      bottom: 12px;
      color: var(--muted);
      font-size: .9rem;
      pointer-events: none;
    }

    .field .toggle-pw {
      position: absolute;
      right: 13px;
      bottom: 11px;
      color: var(--muted);
      font-size: 1rem;
      cursor: pointer;
    }

    .field input {
      width: 100%;
      padding: 11px 40px 11px 38px;
      border: 1.5px solid var(--border);
      border-radius: 8px;
      font-family: 'DM Sans', sans-serif;
      font-size: .88rem;
      color: var(--text-dark);
      background: var(--input-bg);
      outline: none;
      transition: border-color .2s, box-shadow .2s, background .2s;
    }

    .field input::placeholder { color: #b5c4ba; }

    .field input:focus {
      border-color: var(--green-accent);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(45,122,79,.12);
    }

    /* remember row */
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
      gap: 7px;
      font-size: .78rem;
      color: var(--text-mid);
      cursor: pointer;
      user-select: none;
    }

    .remember-label input[type="checkbox"] {
      accent-color: var(--green-accent);
      width: 14px; height: 14px;
      cursor: pointer;
    }

    .link-forgot {
      font-size: .78rem;
      color: var(--muted);
      text-decoration: none;
      transition: color .2s;
    }

    .link-forgot:hover { color: var(--green-accent); }

    /* submit button */
    .btn-signin {
      width: 100%;
      padding: 13px;
      background: var(--green-mid);
      border: none;
      border-radius: 8px;
      color: #fff;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      font-size: .88rem;
      letter-spacing: 2px;
      text-transform: uppercase;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform .15s, background .15s, box-shadow .15s;
      box-shadow: 0 6px 20px rgba(26,74,46,.3);
    }

    .btn-signin::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.1), transparent 55%);
      pointer-events: none;
    }

    .btn-signin:hover {
      background: var(--green-accent);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(26,74,46,.4);
    }

    .btn-signin:active { transform: translateY(0); }

    .secure-note {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      font-size: .7rem;
      color: #b0c0b5;
      margin-top: 14px;
      letter-spacing: .3px;
    }

    .secure-note i { color: var(--gold); font-size: .8rem; }

    /* ── FOOTER ── */
    .page-footer {
      position: relative;
      z-index: 1;
      margin-top: 20px;
      text-align: center;
      font-size: .66rem;
      color: rgba(245,240,232,.22);
      letter-spacing: .6px;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 560px) {
      .panel-visual { display: none; }
      .panel-form { padding: 40px 28px; }
      .login-card { max-width: 100%; }
    }
  </style>
</head>
<body>

  <div class="stripe"></div>

  <div class="login-card">

    <!-- LEFT: Visual -->
    <div class="panel-visual">
      <div>
        <div class="visual-seal"><img src="{{ asset('img/dar-logo.png') }}" alt="DAR logo"></div>
        <div class="visual-copy">
          <p class="visual-eyebrow">DAR — Official System</p>
          <h2 class="visual-title">Cashier<br><em>Transaction</em><br>Management</h2>
          <div class="visual-rule"></div>
          <p class="visual-desc">Secure access portal for authorized Department of Agrarian Reform personnel.</p>
        </div>
      </div>

      <div class="visual-badges">
        <div class="v-badge"><i class="bi bi-shield-lock-fill"></i> End-to-end secured session</div>
        <div class="v-badge"><i class="bi bi-clock-history"></i> Full audit trail on all actions</div>
        <div class="v-badge"><i class="bi bi-person-check-fill"></i> Authorized personnel only</div>
      </div>

      <span class="watermark">Department of Agrarian Reform</span>
    </div>

    <!-- RIGHT: Form -->
    <div class="panel-form">
      <h1 class="form-heading">Sign In</h1>
      <p class="form-sub">Enter your credentials to access the system.</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
          <label for="email">Email Address</label>
          <i class="bi bi-envelope ico"></i>
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

        <div class="field">
          <label for="password">Password</label>
          <i class="bi bi-lock ico"></i>
          <input
            id="password"
            name="password"
            type="password"
            placeholder="••••••••"
            autocomplete="current-password"
            required
          />
          <i class="bi bi-eye-slash toggle-pw" title="Show password"></i>
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
          <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
        </button>

        <p class="secure-note">
          <i class="bi bi-lock-fill"></i>
          Restricted to authorized DAR personnel only
        </p>

      </form>
    </div>

  </div>

  <p class="page-footer">&copy; {{ date('Y') }} Department of Agrarian Reform — Republic of the Philippines</p>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Password toggle
    document.querySelectorAll('.toggle-pw').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var input = btn.closest('.field').querySelector('input');
        if (!input) return;
        if (input.type === 'password') {
          input.type = 'text';
          btn.classList.replace('bi-eye-slash', 'bi-eye');
          btn.title = 'Hide password';
        } else {
          input.type = 'password';
          btn.classList.replace('bi-eye', 'bi-eye-slash');
          btn.title = 'Show password';
        }
      });
    });

    // Blade-driven alerts
    document.addEventListener('DOMContentLoaded', function() {
      @if ($errors->any())
        Swal.fire({
          icon: 'error',
          title: 'Sign In Failed',
          text: {!! json_encode($errors->first()) !!},
          confirmButtonColor: '#1a4a2e'
        });
      @endif

      @if (session('success'))
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: {!! json_encode(session('success')) !!},
          confirmButtonColor: '#1a4a2e'
        });
      @endif

      @if (session('status'))
        Swal.fire({
          icon: 'info',
          title: 'Notice',
          text: {!! json_encode(session('status')) !!},
          confirmButtonColor: '#1a4a2e'
        });
      @endif
    });
  </script>
</body>
</html>