<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verify One-Time Code — DAR Cashier Transaction Management System</title>

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
    .otp-card {
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
      line-height: 1.6;
    }

    /* ── OTP DIGIT BOXES ── */
    .otp-group {
      display: flex;
      gap: 8px;
      margin-bottom: 20px;
      justify-content: flex-start;
    }

    .otp-digit {
      width: 48px;
      height: 54px;
      flex: 0 0 48px;
      text-align: center;
      font-family: 'DM Sans', sans-serif;
      font-size: 1.4rem;
      font-weight: 600;
      color: var(--text-dark);
      border: 1.5px solid var(--border);
      border-radius: 8px;
      background: var(--input-bg);
      outline: none;
      transition: border-color .2s, box-shadow .2s, background .2s;
      caret-color: var(--green-accent);
      padding: 0;
    }

    .otp-digit::placeholder { color: #c8d5cc; font-size: 1rem; }

    .otp-digit:focus {
      border-color: var(--green-accent);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(45,122,79,.12);
    }

    .otp-digit.filled {
      border-color: var(--green-accent);
      background: rgba(45,122,79,.04);
    }

    /* hidden real input */
    .otp-hidden {
      position: absolute;
      opacity: 0;
      pointer-events: none;
      width: 1px;
      height: 1px;
    }

    /* ── TIMER ── */
    .timer-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 22px;
      flex-wrap: wrap;
      gap: 8px;
    }

    .timer-badge {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: .78rem;
      color: var(--text-mid);
      font-weight: 400;
    }

    .timer-badge i { font-size: .9rem; color: var(--gold); }

    #countdown {
      font-weight: 600;
      color: var(--green-accent);
      transition: color .3s;
    }

    #countdown.expiring { color: var(--red); }

    .link-resend {
      font-size: .78rem;
      color: var(--muted);
      text-decoration: none;
      transition: color .2s;
      cursor: pointer;
      background: none;
      border: none;
      padding: 0;
      font-family: 'DM Sans', sans-serif;
    }

    .link-resend:hover:not(:disabled) { color: var(--green-accent); }

    .link-resend:disabled {
      opacity: .45;
      cursor: not-allowed;
    }

    /* ── SUBMIT BUTTON ── */
    .btn-verify {
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

    .btn-verify::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.1), transparent 55%);
      pointer-events: none;
    }

    .btn-verify:hover:not(:disabled) {
      background: var(--green-accent);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(26,74,46,.4);
    }

    .btn-verify:active { transform: translateY(0); }

    .btn-verify:disabled {
      opacity: .55;
      cursor: not-allowed;
      transform: none;
    }

    /* ── CANCEL LINK ── */
    .cancel-row {
      text-align: center;
      margin-top: 16px;
    }

    .link-cancel {
      font-size: .78rem;
      color: var(--muted);
      text-decoration: none;
      transition: color .2s;
    }

    .link-cancel:hover { color: var(--red); }

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
      .otp-card { max-width: 100%; }
      .otp-digit { width: 40px; flex: 0 0 40px; height: 48px; font-size: 1.2rem; }
    }
  </style>
</head>
<body>

  <div class="stripe"></div>

  <div class="otp-card">

    <!-- LEFT: Visual -->
    <div class="panel-visual">
      <div>
        <div class="visual-seal">
          <img src="{{ asset('img/dar-logo.png') }}" alt="DAR logo">
        </div>
        <div class="visual-copy">
          <p class="visual-eyebrow">DAR — Official System</p>
          <h2 class="visual-title">Two-Factor<br><em>Verification</em></h2>
          <div class="visual-rule"></div>
          <p class="visual-desc">A one-time code has been sent to your registered email address.</p>
        </div>
      </div>

      <div class="visual-badges">
        <div class="v-badge"><i class="bi bi-shield-lock-fill"></i> Code expires in 5 minutes</div>
        <div class="v-badge"><i class="bi bi-envelope-check-fill"></i> Sent to your DAR email</div>
        <div class="v-badge"><i class="bi bi-person-check-fill"></i> Authorized personnel only</div>
      </div>

      <span class="watermark">Department of Agrarian Reform</span>
    </div>

    <!-- RIGHT: Form -->
    <div class="panel-form">
      <h1 class="form-heading">Enter Code</h1>
      <p class="form-sub">We sent a 6-digit code to your email.<br>Enter it below to continue.</p>

      <form method="POST" action="{{ route('auth.otp.verify') }}" id="otp-form">
        @csrf

        <!-- Hidden real input for form submission -->
        <input type="text" name="otp" id="otp-real" class="otp-hidden" maxlength="6" required autocomplete="one-time-code" />

        <!-- Visual digit boxes -->
        <div class="otp-group" id="otp-group" aria-label="One-time code digits">
          <input class="otp-digit" type="text" inputmode="numeric" maxlength="1" placeholder="·" aria-label="Digit 1" />
          <input class="otp-digit" type="text" inputmode="numeric" maxlength="1" placeholder="·" aria-label="Digit 2" />
          <input class="otp-digit" type="text" inputmode="numeric" maxlength="1" placeholder="·" aria-label="Digit 3" />
          <input class="otp-digit" type="text" inputmode="numeric" maxlength="1" placeholder="·" aria-label="Digit 4" />
          <input class="otp-digit" type="text" inputmode="numeric" maxlength="1" placeholder="·" aria-label="Digit 5" />
          <input class="otp-digit" type="text" inputmode="numeric" maxlength="1" placeholder="·" aria-label="Digit 6" />
        </div>

        @error('otp')
          <p style="font-size:.75rem;color:var(--red);margin-bottom:14px;display:flex;align-items:center;gap:5px;">
            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
          </p>
        @enderror

        <div class="timer-row">
          <span class="timer-badge">
            <i class="bi bi-clock-history"></i>
            Code expires in <span id="countdown">5:00</span>
          </span>
          <button type="button" class="link-resend" id="resend-btn" disabled>
            Resend code
          </button>
        </div>

        <button type="submit" class="btn-verify" id="submit-btn" disabled>
          <i class="bi bi-check-circle me-1"></i> Verify Code
        </button>

        <p class="secure-note">
          <i class="bi bi-lock-fill"></i>
          This code is single-use and time-limited
        </p>

      </form>

      <div class="cancel-row">
        <a href="{{ route('login') }}" class="link-cancel">
          <i class="bi bi-arrow-left me-1"></i>Back to Sign In
        </a>
      </div>
    </div>

  </div>

  <p class="page-footer">&copy; {{ date('Y') }} Department of Agrarian Reform — Republic of the Philippines</p>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    /* ── OTP DIGIT LOGIC ── */
    const digits   = document.querySelectorAll('.otp-digit');
    const realInput = document.getElementById('otp-real');
    const submitBtn = document.getElementById('submit-btn');

    function syncReal() {
      const val = [...digits].map(d => d.value).join('');
      realInput.value = val;
      submitBtn.disabled = val.length < 6;
      digits.forEach((d, i) => {
        d.classList.toggle('filled', d.value !== '');
      });
    }

    digits.forEach((digit, idx) => {
      digit.addEventListener('input', (e) => {
        const v = e.target.value.replace(/\D/g, '');
        digit.value = v.slice(-1);
        if (v && idx < digits.length - 1) digits[idx + 1].focus();
        syncReal();
      });

      digit.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace') {
          if (!digit.value && idx > 0) {
            digits[idx - 1].value = '';
            digits[idx - 1].focus();
          } else {
            digit.value = '';
          }
          syncReal();
          e.preventDefault();
        }
        if (e.key === 'ArrowLeft' && idx > 0) digits[idx - 1].focus();
        if (e.key === 'ArrowRight' && idx < digits.length - 1) digits[idx + 1].focus();
      });

      digit.addEventListener('paste', (e) => {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        pasted.slice(0, 6).split('').forEach((ch, i) => {
          if (digits[i]) digits[i].value = ch;
        });
        const next = Math.min(pasted.length, digits.length - 1);
        digits[next].focus();
        syncReal();
      });

      digit.addEventListener('focus', () => digit.select());
    });

    /* ── COUNTDOWN TIMER ── */
    const countdownEl = document.getElementById('countdown');
    const resendBtn   = document.getElementById('resend-btn');
    let totalSeconds  = 5 * 60;

    function formatTime(s) {
      const m = Math.floor(s / 60);
      const sec = s % 60;
      return `${m}:${sec.toString().padStart(2, '0')}`;
    }

    const timer = setInterval(() => {
      totalSeconds--;
      countdownEl.textContent = formatTime(totalSeconds);
      if (totalSeconds <= 60) countdownEl.classList.add('expiring');
      if (totalSeconds <= 0) {
        clearInterval(timer);
        countdownEl.textContent = 'Expired';
        countdownEl.style.color = 'var(--red)';
        resendBtn.disabled = false;
      }
    }, 1000);

    resendBtn.addEventListener('click', () => {
      Swal.fire({
        icon: 'info',
        title: 'Code Resent',
        text: 'A new one-time code has been sent to your email.',
        confirmButtonColor: '#1a4a2e'
      });
      totalSeconds = 5 * 60;
      countdownEl.textContent = formatTime(totalSeconds);
      countdownEl.classList.remove('expiring');
      countdownEl.style.color = '';
      resendBtn.disabled = true;
      digits.forEach(d => { d.value = ''; d.classList.remove('filled'); });
      syncReal();
      digits[0].focus();
    });

    /* ── BLADE ALERTS ── */
    document.addEventListener('DOMContentLoaded', function () {
      @if ($errors->any())
        Swal.fire({
          icon: 'error',
          title: 'Verification Failed',
          text: {!! json_encode($errors->first()) !!},
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

      digits[0].focus();
    });
  </script>
</body>
</html>