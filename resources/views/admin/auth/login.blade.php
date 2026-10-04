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
        <div class="admin-login-heading"><span><i class="bi bi-shield-lock-fill"></i></span><h1>เข้าสู่ระบบหลังบ้าน</h1><p>กรอกบัญชีผู้ดูแลระบบเพื่อดำเนินการต่อ</p></div>

        <form method="post" action="{{ route('admin.login.store') }}" class="admin-form">
            @csrf
            <div>
                <label class="form-label" for="email">อีเมล</label>
                <div class="input-group"><span class="input-group-text"><i class="bi bi-envelope"></i></span><input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" autofocus required></div>
                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label" for="password">รหัสผ่าน</label>
                <div class="input-group"><span class="input-group-text"><i class="bi bi-key"></i></span><input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" autocomplete="current-password" required></div>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="form-check"><input class="form-check-input" id="remember" name="remember" type="checkbox" value="1"><label class="form-check-label" for="remember">จดจำการเข้าสู่ระบบ</label></div>
            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ</button>
        </form>
        <a class="admin-login-back" href="{{ route('home') }}"><i class="bi bi-arrow-left"></i> กลับหน้าเว็บไซต์</a>
    </main>
</body>
</html>
