<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Created — {{ config('app.name') }}</title>
  <!--[if mso]>
  <noscript>
    <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
  </noscript>
  <![endif]-->
  <style>
    /* ── Reset ── */
    *, *::before, *::after { box-sizing: border-box; }
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
    body { margin: 0; padding: 0; width: 100% !important; min-width: 100%; }

    /* ── Tokens ── */
    :root {
      --green-deep:   #0e2a1a;
      --green-mid:    #1a4a2e;
      --green-accent: #2d7a4f;
      --green-light:  #e8f4ee;
      --gold:         #c9992a;
      --gold-light:   #e8c46a;
      --cream:        #f5f0e8;
      --bg:           #f4f1eb;
      --border:       #e2ddd5;
      --text-dark:    #0e2a1a;
      --text-mid:     #3d5045;
      --muted:        #8a9e90;
      --red:          #a0251c;
    }

    /* ── Wrapper ── */
    .email-bg {
      background-color: #f4f1eb;
      font-family: 'Georgia', serif;
      padding: 40px 16px 60px;
      min-height: 100vh;
    }

    .email-container {
      max-width: 580px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 14px;
      overflow: hidden;
      border: 1.5px solid #e2ddd5;
      box-shadow: 0 8px 32px rgba(14,42,26,.10), 0 2px 8px rgba(14,42,26,.06);
    }

    /* ── Top Stripe ── */
    .top-stripe {
      height: 4px;
      background: linear-gradient(90deg, #2d7a4f, #c9992a, #a0251c);
    }

    /* ── Header ── */
    .email-header {
      background: linear-gradient(135deg, #0e2a1a 0%, #1a4a2e 100%);
      padding: 28px 36px 24px;
      text-align: center;
      position: relative;
    }

    .email-header::after {
      content: '';
      display: block;
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(201,153,42,.5), transparent);
    }

    .header-seal {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 52px;
      height: 52px;
      background: linear-gradient(135deg, #c9992a, #e8c46a);
      border-radius: 50%;
      font-size: 1.5rem;
      margin-bottom: 12px;
      box-shadow: 0 2px 12px rgba(201,153,42,.35);
    }

    .header-agency {
      font-size: .6rem;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(245,240,232,.35);
      font-family: 'Georgia', serif;
      font-weight: normal;
      margin-bottom: 4px;
    }

    .header-title {
      font-family: 'Georgia', serif;
      font-size: 1.25rem;
      font-weight: bold;
      color: #e8c46a;
      letter-spacing: .5px;
      margin-bottom: 0;
    }

    .header-sub {
      font-family: 'Georgia', serif;
      font-size: .72rem;
      color: rgba(245,240,232,.45);
      margin-top: 4px;
      letter-spacing: 1px;
    }

    /* ── Body ── */
    .email-body {
      padding: 32px 36px 28px;
    }

    .greeting {
      font-family: 'Georgia', serif;
      font-size: 1.05rem;
      font-weight: bold;
      color: #0e2a1a;
      margin-bottom: 12px;
    }

    .body-text {
      font-family: Georgia, serif;
      font-size: .875rem;
      line-height: 1.75;
      color: #3d5045;
      margin-bottom: 24px;
    }

    /* ── Credentials Box ── */
    .credentials-box {
      background: #f5f0e8;
      border: 1.5px solid #e2ddd5;
      border-left: 4px solid #c9992a;
      border-radius: 10px;
      padding: 20px 22px;
      margin-bottom: 24px;
    }

    .credentials-label {
      font-size: .6rem;
      letter-spacing: 2.5px;
      text-transform: uppercase;
      color: #8a9e90;
      font-family: Georgia, serif;
      margin-bottom: 14px;
      font-weight: bold;
    }

    .cred-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      padding: 10px 0;
      border-bottom: 1px solid #e2ddd5;
    }

    .cred-row:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .cred-row:first-of-type {
      padding-top: 0;
    }

    .cred-icon {
      width: 28px;
      height: 28px;
      background: #e8f4ee;
      border-radius: 7px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: .85rem;
    }

    .cred-key {
      font-size: .7rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #8a9e90;
      font-family: Georgia, serif;
      margin-bottom: 2px;
    }

    .cred-value {
      font-family: 'Courier New', monospace;
      font-size: .85rem;
      font-weight: bold;
      color: #0e2a1a;
      word-break: break-all;
    }

    /* ── CTA Button ── */
    .cta-wrap {
      text-align: center;
      margin-bottom: 24px;
    }

    .cta-btn {
      display: inline-block;
      padding: 13px 32px;
      background: linear-gradient(135deg, #2d7a4f, #1a4a2e);
      color: #f5f0e8 !important;
      text-decoration: none !important;
      border-radius: 8px;
      font-family: Georgia, serif;
      font-size: .85rem;
      font-weight: bold;
      letter-spacing: .5px;
      box-shadow: 0 4px 14px rgba(14,42,26,.22);
    }

    /* ── Security Notice ── */
    .security-notice {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      background: #fff7ed;
      border: 1.5px solid rgba(194,100,10,.18);
      border-radius: 8px;
      padding: 13px 16px;
      margin-bottom: 24px;
    }

    .security-icon {
      font-size: 1rem;
      flex-shrink: 0;
      margin-top: 1px;
    }

    .security-text {
      font-family: Georgia, serif;
      font-size: .8rem;
      color: #7a4008;
      line-height: 1.6;
    }

    /* ── Divider ── */
    .email-divider {
      border: none;
      border-top: 1px dashed #e2ddd5;
      margin: 24px 0;
    }

    /* ── Signature ── */
    .signature {
      font-family: Georgia, serif;
      font-size: .83rem;
      color: #3d5045;
      line-height: 1.7;
    }

    .signature-name {
      font-size: .8rem;
      font-weight: bold;
      color: #0e2a1a;
      margin-top: 4px;
    }

    .signature-role {
      font-size: .7rem;
      color: #8a9e90;
      letter-spacing: .5px;
    }

    /* ── Footer ── */
    .email-footer {
      background: #0e2a1a;
      padding: 18px 36px;
      text-align: center;
    }

    .footer-text {
      font-family: Georgia, serif;
      font-size: .68rem;
      color: rgba(245,240,232,.35);
      line-height: 1.7;
      letter-spacing: .3px;
    }

    .footer-text a {
      color: rgba(232,196,106,.55);
      text-decoration: none;
    }

    .footer-divider-dot {
      display: inline-block;
      margin: 0 6px;
      opacity: .4;
    }

    @media only screen and (max-width: 480px) {
      .email-body { padding: 24px 20px 20px; }
      .email-header { padding: 22px 20px 18px; }
      .email-footer { padding: 16px 20px; }
      .credentials-box { padding: 16px; }
    }
  </style>
</head>
<body>
  <div class="email-bg">
    <div class="email-container">

      <!-- Top Stripe -->
      <div class="top-stripe"></div>

      <!-- Header -->
      <div class="email-header">
        <div class="header-seal">🌾</div>
        <div class="header-agency">Republic of the Philippines</div>
        <div class="header-title">Department of Agrarian Reform</div>
        <div class="header-sub">Regional Office V — DAR Cashier System</div>
      </div>

      <!-- Body -->
      <div class="email-body">

        <div class="greeting">Dear {{ $user->first_name ?? $user->name ?? 'User' }},</div>

        <p class="body-text">
          An account has been created for you on <strong>{{ config('app.name') }}</strong>.
          Please find your login credentials below. Keep these details confidential and do not share them with anyone.
        </p>

        <!-- Credentials Box -->
        <div class="credentials-box">
          <div class="credentials-label">Your Login Credentials</div>

          <div class="cred-row">
            <div class="cred-icon">✉️</div>
            <div>
              <div class="cred-key">Email Address</div>
              <div class="cred-value">{{ $user->email }}</div>
            </div>
          </div>

          @if(!empty($user->username))
          <div class="cred-row">
            <div class="cred-icon">👤</div>
            <div>
              <div class="cred-key">Username</div>
              <div class="cred-value">{{ $user->username }}</div>
            </div>
          </div>
          @endif

          <div class="cred-row">
            <div class="cred-icon">🔑</div>
            <div>
              <div class="cred-key">Temporary Password</div>
              <div class="cred-value">{{ $password }}</div>
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="cta-wrap">
          <a href="{{ config('app.url') }}/login" class="cta-btn">
            🔐 &nbsp; Login to Your Account
          </a>
        </div>

        <!-- Security Notice -->
        <div class="security-notice">
          <div class="security-icon">⚠️</div>
          <div class="security-text">
            For your security, please <strong>change your password immediately</strong> after your first login.
            Do not share your credentials with anyone, including DAR staff.
          </div>
        </div>

        <hr class="email-divider">

        <!-- Signature -->
        <div class="signature">
          <div>Regards,</div>
          <div class="signature-name">{{ config('app.name') }} Team</div>
          <div class="signature-role">Department of Agrarian Reform — Regional Office V</div>
        </div>

      </div><!-- /.email-body -->

      <!-- Footer -->
      <div class="email-footer">
        <div class="footer-text">
          This is an automated message. Please do not reply to this email.
          <span class="footer-divider-dot">·</span>
          <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
        </div>
        <div class="footer-text" style="margin-top:6px; opacity:.6;">
          © {{ date('Y') }} Department of Agrarian Reform — Republic of the Philippines
        </div>
      </div>

    </div><!-- /.email-container -->
  </div><!-- /.email-bg -->
</body>
</html>