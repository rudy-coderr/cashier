<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAR Cashier Transaction Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/dar-logo.png') }}" />

    <style>
        :root {
            --dar-red:    #c0392b;
            --dar-gold:   #e8b84b;
            --dar-green:  #1a6b3c;
            --dar-dark:   #0d1f15;
            --dar-mid:    #12291c;
            --dar-light:  #f0ede4;
            --dar-muted:  #a0b5a8;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Source Sans 3', sans-serif;
            min-height: 100vh;
            background: var(--dar-dark);
            color: var(--dar-light);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ── BACKGROUND ── */
        .bg-layer {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .bg-layer::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 110%, rgba(26, 107, 60, .45) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 85% -10%,  rgba(192, 57, 43, .22) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 50% 50%,  rgba(232, 184, 75, .06) 0%, transparent 70%);
        }

        /* subtle grid */
        .bg-layer::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(240,237,228,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(240,237,228,.025) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* ── LAYOUT ── */
        .page-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr auto;
        }

        /* ── TOP BAR ── */
        .top-bar {
            padding: 18px 40px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 1px solid rgba(240,237,228,.08);
            background: rgba(13,31,21,.6);
            backdrop-filter: blur(12px);
        }

        .gov-seal {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            flex-shrink: 0;
            display: block;
            box-shadow: 0 0 0 3px rgba(232,184,75,.25);
            animation: seal-pulse 3s ease-in-out infinite;
            object-fit: cover;
        }

        @keyframes seal-pulse {
            0%, 100% { box-shadow: 0 0 0 3px rgba(232,184,75,.25); }
            50%       { box-shadow: 0 0 0 7px rgba(232,184,75,.10); }
        }

        .gov-label {
            line-height: 1.25;
        }

        .gov-label .republic {
            font-size: .68rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--dar-muted);
            font-weight: 300;
        }

        .gov-label .agency {
            font-size: .92rem;
            font-weight: 600;
            color: var(--dar-light);
        }

        /* ── HERO ── */
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 24px;
            gap: 0;
        }

        .kicker {
            font-size: .72rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--dar-gold);
            font-weight: 600;
            margin-bottom: 22px;
            opacity: 0;
            animation: fade-up .6s .1s forwards;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.6rem, 6vw, 4.6rem);
            font-weight: 900;
            line-height: 1.08;
            color: var(--dar-light);
            max-width: 820px;
            opacity: 0;
            animation: fade-up .7s .25s forwards;
        }

        .hero-title .accent {
            color: var(--dar-gold);
            position: relative;
        }

        .hero-title .accent::after {
            content: '';
            position: absolute;
            left: 0; bottom: -4px;
            width: 100%; height: 3px;
            background: var(--dar-gold);
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: left;
            animation: underline-in .5s .9s forwards;
        }

        @keyframes underline-in {
            to { transform: scaleX(1); }
        }

        .divider-ornament {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 32px 0 28px;
            opacity: 0;
            animation: fade-up .6s .4s forwards;
        }

        .divider-ornament span {
            display: block;
            height: 1px;
            width: 80px;
            background: linear-gradient(90deg, transparent, rgba(232,184,75,.5));
        }

        .divider-ornament span:last-child {
            background: linear-gradient(90deg, rgba(232,184,75,.5), transparent);
        }

        .divider-ornament i {
            color: var(--dar-gold);
            font-size: 1rem;
        }

        .hero-sub {
            font-size: 1.08rem;
            color: var(--dar-muted);
            max-width: 520px;
            line-height: 1.7;
            font-weight: 300;
            opacity: 0;
            animation: fade-up .6s .5s forwards;
        }

        /* ── STAT PILLS ── */
        .stat-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 14px;
            margin: 44px 0 52px;
            opacity: 0;
            animation: fade-up .6s .65s forwards;
        }

        .stat-pill {
            padding: 10px 22px;
            border: 1px solid rgba(240,237,228,.12);
            border-radius: 100px;
            background: rgba(240,237,228,.04);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .5px;
            color: var(--dar-light);
            transition: border-color .2s, background .2s;
        }

        .stat-pill:hover {
            border-color: rgba(232,184,75,.4);
            background: rgba(232,184,75,.07);
        }

        .stat-pill i {
            color: var(--dar-gold);
            font-size: 1rem;
        }

        /* ── CTA BUTTON ── */
        .cta-wrap {
            opacity: 0;
            animation: fade-up .6s .8s forwards;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
        }

        .btn-access {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 48px;
            background: var(--dar-green);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-weight: 700;
            font-size: .95rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform .18s, box-shadow .18s;
            box-shadow: 0 6px 28px rgba(26, 107, 60, .5);
        }

        .btn-access::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.12), transparent 55%);
            pointer-events: none;
        }

        .btn-access::after {
            content: '';
            position: absolute;
            top: -50%; left: -60%;
            width: 40%; height: 200%;
            background: rgba(255,255,255,.15);
            transform: skewX(-20deg);
            transition: left .5s ease;
        }

        .btn-access:hover::after { left: 140%; }

        .btn-access:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 36px rgba(26, 107, 60, .65);
        }

        .btn-access:active { transform: translateY(0); }

        .access-note {
            font-size: .75rem;
            color: var(--dar-muted);
            letter-spacing: .5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .access-note i { font-size: .85rem; color: var(--dar-gold); }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid rgba(240,237,228,.07);
            padding: 20px 40px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: rgba(13,31,21,.5);
            backdrop-filter: blur(8px);
        }

        footer p {
            font-size: .72rem;
            color: var(--dar-muted);
            letter-spacing: .5px;
        }

        footer .footer-links {
            display: flex;
            gap: 20px;
        }

        footer .footer-links a {
            font-size: .72rem;
            color: var(--dar-muted);
            text-decoration: none;
            letter-spacing: .5px;
            transition: color .2s;
        }

        footer .footer-links a:hover { color: var(--dar-gold); }

        /* ── STRIPE ACCENT ── */
        .stripe-top {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--dar-green), var(--dar-gold), var(--dar-red));
            z-index: 100;
        }

        /* ── ANIMATIONS ── */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 600px) {
            .top-bar { padding: 14px 20px; }
            footer   { padding: 16px 20px; flex-direction: column; align-items: flex-start; }
            .hero    { padding: 48px 20px; }
            .btn-access { padding: 14px 36px; }
        }
    </style>
</head>
<body>

    <div class="stripe-top"></div>
    <div class="bg-layer"></div>

    <div class="page-wrapper">

        <!-- TOP BAR -->
        <header class="top-bar">
            <img src="{{ asset('img/dar-logo.png') }}" alt="DAR Logo" class="gov-seal" />
            <div class="gov-label">
                <div class="republic">Republic of the Philippines</div>
                <div class="agency">Department of Agrarian Reform</div>
            </div>
        </header>

        <!-- HERO -->
        <main class="hero">

            <p class="kicker">Official Government System</p>

            <h1 class="hero-title">
                Cashier <span class="accent">Transaction</span><br>Management System
            </h1>

            <div class="divider-ornament">
                <span></span>
                <i class="bi bi-coin"></i>
                <span></span>
            </div>

            <p class="hero-sub">
                Secure, efficient, and transparent cashier operations for the Department of Agrarian Reform. Authorized personnel only.
            </p>

            <div class="stat-row">
                <div class="stat-pill"><i class="bi bi-shield-lock-fill"></i> Secure Access</div>
                <div class="stat-pill"><i class="bi bi-receipt"></i> Transaction Records</div>
                <div class="stat-pill"><i class="bi bi-bar-chart-line-fill"></i> Financial Reports</div>
                <div class="stat-pill"><i class="bi bi-clock-history"></i> Audit Trails</div>
            </div>

            <div class="cta-wrap">
                <a href="{{ route('login') }}" class="btn-access">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Pay Now
                </a>
                <span class="access-note">
                    <i class="bi bi-lock-fill"></i>
                    Restricted to authorized DAR personnel
                </span>
            </div>

        </main>

        <!-- FOOTER -->
        <footer>
            <p>&copy; 2025 Department of Agrarian Reform — Republic of the Philippines</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Use</a>
                <a href="#">Help Desk</a>
            </div>
        </footer>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>