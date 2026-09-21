<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun TERA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f4f8; color: #333; }
        .wrapper {
            max-width: 580px; margin: 40px auto; background: #ffffff;
            border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        }
        .header {
            background: #081e53ff;
            padding: 36px 40px 28px; text-align: center;
        }
        .header .brand { font-size: 32px; font-weight: 800; color: #ffffff; letter-spacing: 4px; }
        .header .brand-sub { font-size: 11px; color: rgba(255,255,255,0.75); letter-spacing: 2px; margin-top: 4px; text-transform: uppercase; }
        .body { padding: 40px 40px 32px; }
        .greeting { font-size: 20px; font-weight: 600; color: #1a3c5e; margin-bottom: 12px; }
        .desc { font-size: 14px; color: #555; line-height: 1.7; margin-bottom: 32px; }
        .otp-container {
            background: linear-gradient(135deg, #f0f7ff 0%, #e8f4fd 100%);
            border: 2px solid #081e53ff; border-radius: 12px;
            padding: 28px 20px; text-align: center; margin-bottom: 28px;
        }
        .otp-label { font-size: 12px; color: #081e53ff; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px; }
        .otp-code { font-size: 48px; font-weight: 800; color: #1a3c5e; letter-spacing: 12px; font-family: 'Courier New', monospace; }
        .otp-expiry { font-size: 12px; color: #e67e22; margin-top: 12px; font-weight: 500; }
        .warning-box {
            background: #fff8e1; border-left: 4px solid #f39c12;
            border-radius: 6px; padding: 14px 16px; margin-bottom: 24px;
            font-size: 13px; color: #7d5a00;
        }
        .divider { border: none; border-top: 1px solid #eee; margin: 24px 0; }
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 12px; color: #999; line-height: 1.6; }
        .footer .company { font-weight: 600; color: #1a3c5e; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="brand">TERA</div>
            <div class="brand-sub">Telecommunication Equipment Rental Application</div>
        </div>
        <div class="body">
            <div class="greeting">👋 Selamat Datang, {{ $nama }}!</div>
            <p class="desc">
                Terima kasih telah mendaftar di <strong>TERA System</strong>.
                Gunakan kode OTP berikut untuk memverifikasi email Anda dan mengaktifkan akun Anda.
            </p>
            <div class="otp-container">
                <div class="otp-label">Kode Verifikasi OTP</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expiry">⏱ Kode berlaku selama <strong>10 menit</strong></div>
            </div>
            <div class="warning-box">
                ⚠️ <strong>Jangan bagikan kode ini</strong> kepada siapapun.
                Jika Anda tidak mendaftar di TERA, abaikan email ini.
            </div>
            <hr class="divider">
            <p style="font-size: 13px; color: #777;">Email ini dikirim secara otomatis, mohon jangan membalas email ini.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} <span class="company">TERA System</span>. Seluruh hak dilindungi.<br>
            Telecommunication Equipment Rental Application</p>
        </div>
    </div>
</body>
</html>
