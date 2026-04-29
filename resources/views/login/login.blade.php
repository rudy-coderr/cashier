<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Member Login</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />

  <style>
    :root {
      --clr-primary: #6a3de8;
      --clr-accent:  #4ade80;
      --clr-pink:    #d946a8;
      --clr-text:    #1a1a2e;
      --clr-muted:   #aaaaaa;
      --clr-border:  #e8e8e8;
      --clr-bg:      #fafafa;
    }

    * { box-sizing: border-box; }

    body {
      font-family: 'Nunito', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #0f172a;
      padding: 20px;
    }

    /* ── CARD ───────────────────────────────────────── */
    .login-card {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
      overflow: hidden;
      width: 100%;
      max-width: 700px;
      display: flex;
      min-height: 360px;
      animation: cardIn 0.55s cubic-bezier(.22,.68,0,1.2) both;
    }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(28px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0)    scale(1);    }
    }

    /* ── LEFT ILLUSTRATION ──────────────────────────── */
    .illus-panel {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      padding: 40px 20px;
      background: #f8fafc;
    }

    .avatar-circle {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      background: #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      z-index: 2;
    }

    .monitor-box {
      width: 82px;
      height: 62px;
      background: #334155;
      border-radius: 7px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .monitor-box::after {
      content: '';
      position: absolute;
      bottom: -13px;
      left: 50%;
      transform: translateX(-50%);
      width: 30px;
      height: 9px;
      background: #334155;
      border-radius: 0 0 5px 5px;
    }

    .monitor-box i {
      font-size: 1.7rem;
      color: #cbd5e1;
    }

    /* floating shapes */
    .shape {
      position: absolute;
      animation: floatShape 3s ease-in-out infinite alternate;
      opacity: 0.55;
    }

    @keyframes floatShape {
      from { transform: translateY(0); }
      to   { transform: translateY(-9px); }
    }

    .shape-circle {
      width: 13px; height: 13px;
      border-radius: 50%;
      border: 2px solid var(--clr-primary);
    }

    .shape-triangle {
      width: 0; height: 0;
      border-left: 7px solid transparent;
      border-right: 7px solid transparent;
      border-bottom: 13px solid var(--clr-accent);
    }

    .shape-play {
      width: 0; height: 0;
      border-top: 7px solid transparent;
      border-bottom: 7px solid transparent;
      border-left: 13px solid var(--clr-accent);
    }

    .s1 { top: 24%; left: 12%; animation-delay: 0s; }
    .s2 { bottom: 22%; left: 9%; animation-delay: .5s; }
    .s3 { top: 22%; right: 13%; animation-delay: .3s; }
    .s4 { bottom: 20%; right: 10%; animation-delay: .8s;
          border-color: var(--clr-pink); }

    /* ── DIVIDER ────────────────────────────────────── */
    .v-divider {
      width: 1px;
      background: var(--clr-border);
      margin: 28px 0;
    }

    /* ── RIGHT FORM ─────────────────────────────────── */
    .form-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px 38px;
    }

    .form-panel h2 {
      font-weight: 800;
      font-size: 1.35rem;
      color: var(--clr-text);
      margin-bottom: 22px;
      letter-spacing: -0.3px;
    }

    /* inputs */
    .input-wrap {
      position: relative;
      margin-bottom: 14px;
    }

    .input-wrap .ico {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--clr-muted);
      font-size: 0.95rem;
      pointer-events: none;
    }

    /* right-side eye toggle */
    .input-wrap .toggle-pw {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--clr-muted);
      font-size: 1rem;
      cursor: pointer;
      z-index: 3;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .input-wrap input {
      width: 100%;
      padding: 11px 14px 11px 38px;
      border: 1.5px solid var(--clr-border);
      border-radius: 8px;
      font-family: 'Nunito', sans-serif;
      font-size: 0.9rem;
      color: #555;
      background: var(--clr-bg);
      outline: none;
      transition: border-color .2s, box-shadow .2s, background .2s;
    }

    .input-wrap input::placeholder { color: var(--clr-muted); }

    .input-wrap input:focus {
      border-color: var(--clr-primary);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(106,61,232,.12);
    }

    /* login button */
    .btn-login {
      width: 100%;
      padding: 11px;
      background: var(--clr-accent);
      border: none;
      border-radius: 8px;
      color: #fff;
      font-family: 'Nunito', sans-serif;
      font-weight: 800;
      font-size: 0.9rem;
      letter-spacing: 1.8px;
      cursor: pointer;
      margin-top: 6px;
      transition: background .2s, transform .1s, box-shadow .2s;
      box-shadow: 0 4px 16px rgba(74,222,128,.38);
    }

    .btn-login:hover {
      background: #22c55e;
      transform: translateY(-1px);
      box-shadow: 0 7px 22px rgba(74,222,128,.48);
    }

    .btn-login:active { transform: translateY(0); }

    /* links */
    .link-forgot {
      display: block;
      text-align: center;
      font-size: 0.78rem;
      color: var(--clr-muted);
      margin-top: 10px;
      text-decoration: none;
      transition: color .2s;
    }

    .link-forgot:hover { color: var(--clr-primary); }

    /* ── RESPONSIVE ─────────────────────────────────── */
    @media (max-width: 520px) {
      .illus-panel,
      .v-divider { display: none; }

      .form-panel { padding: 36px 26px; }
    }
  </style>
</head>
<body>

  <div class="login-card">

    <!-- Left: Illustration -->
    <div class="illus-panel">
      <!-- Floating shapes -->
      <div class="shape shape-circle s1"></div>
      <div class="shape shape-triangle s2"></div>
      <div class="shape shape-play s3"></div>
      <div class="shape shape-circle s4"></div>

      <!-- Avatar -->
      <div class="avatar-circle">
        <div class="monitor-box">
          <i class="bi bi-person"></i>
        </div>
      </div>
    </div>

    <!-- Vertical Divider -->
    <div class="v-divider"></div>

    <!-- Right: Form -->
    <div class="form-panel">
      <h2>Member Login</h2>

      <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div class="input-wrap">
          <i class="bi bi-envelope ico"></i>
          <input name="email" type="email" placeholder="Email" autocomplete="email" />
        </div>

        <div class="input-wrap">
          <i class="bi bi-lock ico"></i>
          <input name="password" type="password" placeholder="Password" autocomplete="current-password" />
          <i class="bi bi-eye-slash toggle-pw" title="Show password" aria-hidden="true"></i>
        </div>

        <button type="submit" class="btn-login">LOGIN</button>

        <a href="#" class="link-forgot">Forgot Password?</a>

      </form>
    </div>

  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.querySelectorAll('.toggle-pw').forEach(function(btn){
      btn.addEventListener('click', function(){
        var wrapper = btn.closest('.input-wrap');
        if(!wrapper) return;
        var input = wrapper.querySelector('input');
        if(!input) return;
        if (input.type === 'password') {
          input.type = 'text';
          btn.classList.remove('bi-eye-slash');
          btn.classList.add('bi-eye');
          btn.setAttribute('title','Hide password');
        } else {
          input.type = 'password';
          btn.classList.remove('bi-eye');
          btn.classList.add('bi-eye-slash');
          btn.setAttribute('title','Show password');
        }
      });
    });

    document.addEventListener('DOMContentLoaded', function(){
      @if($errors->any())
        Swal.fire({
          icon: 'error',
          title: 'Login failed',
          text: {!! json_encode($errors->first()) !!}
        });
      @endif

      @if(session('success'))
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: {!! json_encode(session('success')) !!}
        });
      @endif
    });
  </script>
</body>
</html>