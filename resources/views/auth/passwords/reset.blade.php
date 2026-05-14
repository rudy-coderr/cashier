<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password — DAR Cashier Transaction Management System</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <style>
    :root {
      --green-deep:   #0e2a1a;
      --green-mid:    #1a4a2e;
      --green-accent: #2d7a4f;
      --gold:         #c9992a;
      --gold-light:   #e8c46a;
      --red:          #a0251c;
      --cream:        #f5f0e8;
      --muted:        #8a9e90;
      --border:       #e2ddd5;
      --input-bg:     #faf8f4;
      --text-dark:    #0e2a1a;
      --text-mid:     #3d5045;
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

    .stripe {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red));
      z-index: 100;
    }

    .login-card {
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
    }

    .visual-seal img { width: 100%; height: 100%; display: block; object-fit: cover; }

    @keyframes pulse-seal {
      0%,100% { box-shadow: 0 0 0 4px rgba(201,153,42,.25); }
      50%      { box-shadow: 0 0 0 8px rgba(201,153,42,.1); }
    }

    .visual-copy { margin-top: 28px; }

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

    .visual-title em { font-style: normal; color: var(--gold-light); }

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

    .visual-badges { display: flex; flex-direction: column; gap: 10px; }

    .v-badge {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: .78rem;
      color: rgba(245,240,232,.55);
      font-weight: 400;
    }

    .v-badge i { color: var(--gold-light); font-size: .9rem; width: 16px; text-align: center; }

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

    .panel-form {
      flex: 1;
      background: #ffffff;
      padding: 48px 42px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .reset-icon-wrap {
      width: 52px; height: 52px;
      border-radius: 12px;
      background: rgba(45,122,79,.08);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 18px;
      border: 1px solid rgba(45,122,79,.15);
    }

    .reset-icon-wrap i { font-size: 1.4rem; color: var(--green-accent); }

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
      margin-bottom: 24px;
      font-weight: 300;
      line-height: 1.6;
    }

    .field { position: relative; margin-bottom: 14px; }

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

    /* password strength */
    .strength-bar {
      display: flex;
      gap: 4px;
      margin-top: 6px;
    }

    .strength-bar span {
      flex: 1;
      height: 3px;
      border-radius: 2px;
      background: var(--border);
      transition: background .3s;
    }

    .strength-label {
      font-size: .68rem;
      color: var(--muted);
      margin-top: 4px;
      min-height: 14px;
      transition: color .3s;
    }

    .btn-submit {
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
      margin-top: 6px;
      margin-bottom: 16px;
    }

    .btn-submit::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.1), transparent 55%);
      pointer-events: none;
    }

    .btn-submit:hover {
      background: var(--green-accent);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(26,74,46,.4);
    }

    .btn-submit:active { transform: translateY(0); }

    .back-link {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      font-size: .78rem;
      color: var(--muted);
      text-decoration: none;
      transition: color .2s;
      margin-top: 4px;
    }

    .back-link:hover { color: var(--green-accent); }
    .back-link i { font-size: .85rem; }

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

    .page-footer {
      position: relative;
      z-index: 1;
      margin-top: 20px;
      text-align: center;
      font-size: .66rem;
      color: rgba(245,240,232,.22);
      letter-spacing: .6px;
    }

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

      <div class="reset-icon-wrap">
        <i class="bi bi-shield-lock-fill"></i>
      </div>

      <h1 class="form-heading">Reset Password</h1>
      <p class="form-sub">Choose a strong new password for your account.</p>

      @if ($errors->any())
        <div style="
          background: rgba(160,37,28,.07);
          border: 1px solid rgba(160,37,28,.2);
          border-radius: 8px;
          padding: 10px 14px;
          font-size: .82rem;
          color: #7a1c16;
          margin-bottom: 18px;
          display: flex;
          align-items: center;
          gap: 8px;
        ">
          <i class="bi bi-exclamation-circle-fill" style="color: #a0251c; font-size: .9rem; flex-shrink:0;"></i>
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field">
          <label for="email">Email Address</label>
          <i class="bi bi-envelope ico"></i>
          <input
            id="email"
            name="email"
            type="email"
            placeholder="you@dar.gov.ph"
            autocomplete="email"
            value="{{ old('email', $email ?? '') }}"
            required
            readonly
          />
        </div>

        <div class="field">
          <label for="password">New Password</label>
          <i class="bi bi-lock ico"></i>
          <input
            id="password"
              name="password"
              type="password"
              placeholder="••••••••"
              autocomplete="new-password"
              required
              autofocus
          />
          <i class="bi bi-eye-slash toggle-pw" title="Show password"></i>
          <div class="strength-bar">
            <span id="s1"></span><span id="s2"></span><span id="s3"></span><span id="s4"></span>
          </div>
          <p class="strength-label" id="strength-label"></p>
        </div>

        <div class="field">
          <label for="password_confirmation">Confirm Password</label>
          <i class="bi bi-lock-fill ico"></i>
          <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            placeholder="••••••••"
            autocomplete="new-password"
            required
          />
          <i class="bi bi-eye-slash toggle-pw" title="Show password"></i>
        </div>

        <button type="submit" class="btn-submit">
          <i class="bi bi-check-circle me-1"></i> Reset Password
        </button>

        <a href="{{ route('login') }}" class="back-link">
          <i class="bi bi-arrow-left"></i> Back to Sign In
        </a>

        <p class="secure-note">
          <i class="bi bi-lock-fill"></i>
          Restricted to authorized DAR personnel only
        </p>

      </form>
    </div>

  </div>

  <p class="page-footer">&copy; {{ date('Y') }} Department of Agrarian Reform — Republic of the Philippines</p>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Password toggle
    document.querySelectorAll('.toggle-pw').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var input = btn.closest('.field').querySelector('input[type="password"], input[type="text"]');
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

    // Password strength meter
    var pwInput = document.getElementById('password');
    var bars    = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
    var label   = document.getElementById('strength-label');
    var colors  = ['#a0251c', '#c9992a', '#2d7a4f', '#1a4a2e'];
    var levels  = ['Weak', 'Fair', 'Good', 'Strong'];

    pwInput.addEventListener('input', function() {
      var v = pwInput.value;
      var score = 0;
      if (v.length >= 8)              score++;
      if (/[A-Z]/.test(v))            score++;
      if (/[0-9]/.test(v))            score++;
      if (/[^A-Za-z0-9]/.test(v))     score++;

      bars.forEach(function(b, i) {
        b.style.background = i < score ? colors[score - 1] : 'var(--border)';
      });

      label.textContent  = v.length ? levels[score - 1] || '' : '';
      label.style.color  = v.length ? colors[score - 1] : 'var(--muted)';
    });

    // Blade-driven alerts
    document.addEventListener('DOMContentLoaded', function() {
      @if ($errors->any())
        Swal.fire({
          icon: 'error',
          title: 'Reset Failed',
          text: {!! json_encode($errors->first()) !!},
          confirmButtonColor: '#1a4a2e'
        });
      @endif

      @if (session('status'))
        Swal.fire({
          icon: 'success',
          title: 'Password Reset',
          text: {!! json_encode(session('status')) !!},
          confirmButtonColor: '#1a4a2e'
        });
      @endif
    });
  </script>
</body>
</html>