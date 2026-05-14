<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password — {{ config('app.name') }}</title>
  <!--[if mso]>
  <noscript>
    <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
  </noscript>
  <![endif]-->
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
    body { margin: 0; padding: 0; width: 100% !important; background-color: #f4f1eb; font-family: Georgia, serif; }

    .email-bg { background-color: #f4f1eb; padding: 40px 16px 60px; }
    .email-container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 14px; overflow: hidden; border: 1.5px solid #e2ddd5; box-shadow: 0 8px 32px rgba(14,42,26,.10); }
    .top-stripe { height: 4px; background: linear-gradient(90deg, #2d7a4f, #c9992a, #a0251c); }
    .email-header { background: linear-gradient(135deg, #0e2a1a 0%, #1a4a2e 100%); padding: 28px 36px 24px; text-align: center; position: relative; }
    .email-header::after { content: ''; display: block; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, rgba(201,153,42,.5), transparent); }
    .header-seal { display: inline-flex; align-items: center; justify-content: center; width: 52px; height: 52px; background: linear-gradient(135deg, #c9992a, #e8c46a); border-radius: 50%; font-size: 1.5rem; margin-bottom: 12px; box-shadow: 0 2px 12px rgba(201,153,42,.35); }
    .header-agency { font-size: .6rem; letter-spacing: 3px; text-transform: uppercase; color: rgba(245,240,232,.35); margin-bottom: 4px; }
    .header-title { font-size: 1.25rem; font-weight: bold; color: #e8c46a; letter-spacing: .5px; }
    .header-sub { font-size: .72rem; color: rgba(245,240,232,.45); margin-top: 4px; letter-spacing: 1px; }
    .email-body { padding: 32px 36px 28px; }
    .greeting { font-size: 1.05rem; font-weight: bold; color: #0e2a1a; margin-bottom: 12px; }
    .body-text { font-size: .875rem; line-height: 1.75; color: #3d5045; margin-bottom: 20px; }
    .cta-wrap { text-align: center; margin: 28px 0; }
    .cta-btn { display: inline-block; padding: 13px 32px; background: linear-gradient(135deg, #2d7a4f, #1a4a2e); color: #f5f0e8 !important; text-decoration: none !important; border-radius: 8px; font-family: Georgia, serif; font-size: .875rem; font-weight: bold; letter-spacing: .5px; box-shadow: 0 4px 14px rgba(14,42,26,.22); }
    .info-box { background: #f5f0e8; border: 1.5px solid #e2ddd5; border-left: 4px solid #c9992a; border-radius: 0 8px 8px 0; padding: 13px 16px; margin-bottom: 16px; font-size: .82rem; color: #3d5045; line-height: 1.65; }
    .email-divider { border: none; border-top: 1px dashed #e2ddd5; margin: 24px 0; }
    .signature { font-size: .83rem; color: #3d5045; line-height: 1.7; }
    .signature-name { font-size: .8rem; font-weight: bold; color: #0e2a1a; margin-top: 4px; }
    .signature-role { font-size: .7rem; color: #8a9e90; letter-spacing: .5px; }
    .link-box { background: #f5f0e8; border: 1.5px solid #e2ddd5; border-radius: 8px; padding: 14px 16px; margin-top: 20px; }
    .link-label { font-size: .6rem; letter-spacing: 2px; text-transform: uppercase; color: #8a9e90; font-weight: bold; margin-bottom: 7px; }
    .link-url { font-family: 'Courier New', monospace; font-size: .75rem; color: #2d7a4f; word-break: break-all; line-height: 1.6; }
    .email-footer { background: #0e2a1a; padding: 18px 36px; text-align: center; }
    .footer-text { font-size: .68rem; color: rgba(245,240,232,.35); line-height: 1.7; letter-spacing: .3px; }
    .footer-text a { color: rgba(232,196,106,.55); text-decoration: none; }

    @media only screen and (max-width: 480px) {
      .email-body { padding: 24px 20px 20px; }
      .email-header { padding: 22px 20px 18px; }
      .email-footer { padding: 16px 20px; }
    }
  </style>
</head>
<body>
  <div class="email-bg">
    <div class="email-container">

      <div class="top-stripe"></div>

      <div class="email-header">
        <div class="header-seal">🌾</div>
        <div class="header-agency">Republic of the Philippines</div>
        <div class="header-title">Department of Agrarian Reform</div>
        <div class="header-sub">Regional Office V — DAR Cashier System</div>
      </div>

      <div class="email-body">

        <div class="greeting">Hello!</div>

        <p class="body-text">
          You are receiving this email because we received a password reset request for your account.
        </p>

        <div class="cta-wrap">
          <a href="{{ $url }}" class="cta-btn">🔐 &nbsp; Reset Password</a>
        </div>

        <div class="info-box">
          ⏱ This password reset link will expire in <strong>60 minutes</strong>.
        </div>

        <p class="body-text" style="margin-bottom: 0;">
          If you did not request a password reset, no further action is required.
        </p>

        <hr class="email-divider">

        <div class="signature">
          <div>Regards,</div>
          <div class="signature-name">{{ config('app.name') }} Team</div>
          <div class="signature-role">Department of Agrarian Reform — Regional Office V</div>
        </div>

        <div class="link-box">
          <div class="link-label">Having trouble with the button? Copy this link</div>
          <div class="link-url">{{ $url }}?email={{ urlencode($user->email) }}</div>
        </div>

      </div>

      <div class="email-footer">
        <div class="footer-text">
          This is an automated message. Please do not reply to this email.
          &nbsp;·&nbsp;
          <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
        </div>
        <div class="footer-text" style="margin-top: 6px; opacity: .6;">
          © {{ date('Y') }} Department of Agrarian Reform — Republic of the Philippines
        </div>
      </div>

    </div>
  </div>
</body>
</html>