<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family:Arial,sans-serif;background:#f3f4f6;margin:0;padding:30px;">
  <div style="max-width:480px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,0.08);">
    <div style="background:#1e4575;padding:28px 32px;">
      <h1 style="color:#fff;margin:0;font-size:20px;">ArkCrest Realty Corporation</h1>
    </div>
    <div style="padding:32px;">
      <p style="font-size:15px;color:#374151;">Hi <strong>{{ $userName }}</strong>,</p>
      @if($status === 'approved')
        <p style="font-size:15px;color:#374151;">Great news! Your account has been <strong style="color:#16a34a;">approved</strong> by the administrator.</p>
        <p style="font-size:14px;color:#6b7280;">You can now log in to the ArkCrest system using your registered email and password.</p>
        <div style="margin:24px 0;">
          <a href="{{ config('app.url') }}/login" style="background:#1e4575;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;">Log In Now</a>
        </div>
      @else
        <p style="font-size:15px;color:#374151;">We regret to inform you that your account registration has been <strong style="color:#dc2626;">rejected</strong>.</p>
        <p style="font-size:14px;color:#6b7280;">If you believe this is a mistake, please contact your administrator.</p>
      @endif
      <p style="font-size:13px;color:#9ca3af;margin-top:32px;border-top:1px solid #f3f4f6;padding-top:16px;">This is an automated message from ArkCrest Realty Corporation System.</p>
    </div>
  </div>
</body>
</html>
