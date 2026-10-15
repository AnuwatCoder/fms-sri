<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เข้าสู่ระบบหลังบ้าน | FMS Portal</title>
    @vite(['resources/js/app.js'])
</head>
<body class="admin-login-body">
    <main class="admin-login-card">
        <div class="admin-login-brand"><span>FMS</span><div><strong>Portal Admin</strong><small>ระบบจัดการข้อมูลเว็บไซต์</small></div></div>
        <div class="admin-login-heading"><span><i class="bi bi-shield-lock-fill"></i></span><h1>เข้าสู่ระบบหลังบ้าน</h1><p>ยืนยันตัวตนด้วยบัญชี PSU เพื่อดำเนินการต่อ</p></div>

        @error('authentik')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror

        <a class="btn btn-primary w-100" href="{{ route('admin.login.redirect') }}">
            <i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบด้วย PSU SSO
        </a>
        <a class="admin-login-back" href="{{ route('home') }}"><i class="bi bi-arrow-left"></i> กลับหน้าเว็บไซต์</a>
    </main>
</body>
</html>
