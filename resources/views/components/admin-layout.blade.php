@props(['title' => 'ระบบหลังบ้าน'])

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | FMS Portal Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/js/app.js'])
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                <span>FMS</span>
                <div><strong>Portal Admin</strong><small>ระบบจัดการข้อมูลเว็บไซต์</small></div>
            </a>

            <nav class="admin-nav" aria-label="เมนูระบบหลังบ้าน">
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i><span>ภาพรวม</span></a>
                <a class="{{ request()->routeIs('admin.systems.*') ? 'active' : '' }}" href="{{ route('admin.systems.index') }}"><i class="bi bi-window-stack"></i><span>ระบบสารสนเทศ</span></a>
                <a class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}"><i class="bi bi-newspaper"></i><span>ข่าวและประกาศ</span></a>
                <a class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}"><i class="bi bi-calendar-event"></i><span>ปฏิทินกิจกรรม</span></a>
                <a class="{{ request()->routeIs('admin.documents.*') ? 'active' : '' }}" href="{{ route('admin.documents.index') }}"><i class="bi bi-folder2-open"></i><span>เอกสารดาวน์โหลด</span></a>
                <a class="{{ request()->routeIs('admin.seo.*') ? 'active' : '' }}" href="{{ route('admin.seo.edit') }}"><i class="bi bi-search-heart"></i><span>ตั้งค่า SEO</span></a>
                <div class="admin-nav-section {{ request()->routeIs('admin.about.*') ? 'is-open' : '' }}">
                    <span><i class="bi bi-building"></i>เกี่ยวกับหน่วยงาน</span>
                    <div class="admin-subnav">
                        <a class="{{ request()->routeIs('admin.about.edit', 'admin.about.update') ? 'active' : '' }}" href="{{ route('admin.about.edit') }}">เนื้อหาหน้า About</a>
                        <a class="{{ request()->routeIs('admin.about.responsibilities.*') ? 'active' : '' }}" href="{{ route('admin.about.responsibilities.index') }}">ภารกิจหลัก</a>
                        <a class="{{ request()->routeIs('admin.about.personnel.*') ? 'active' : '' }}" href="{{ route('admin.about.personnel.index') }}">บุคลากร</a>
                    </div>
                </div>
            </nav>

            <div class="admin-sidebar__footer">
                <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> เปิดหน้าเว็บไซต์</a>
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"><i class="bi bi-box-arrow-left"></i> ออกจากระบบ</button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <button class="admin-menu-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileMenu" aria-label="เปิดเมนู"><i class="bi bi-list"></i></button>
                <div><strong>{{ $title }}</strong><small>{{ now()->locale('th')->translatedFormat('l j F') }} {{ now()->year + 543 }}</small></div>
                <div class="admin-user"><span>{{ str(auth()->user()->name)->substr(0, 1)->upper() }}</span><div><strong>{{ auth()->user()->name }}</strong><small>ผู้ดูแลระบบ</small></div></div>
            </header>

            <main class="admin-content">
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2" role="status"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>

    <div class="offcanvas offcanvas-start admin-mobile-menu" tabindex="-1" id="adminMobileMenu" aria-labelledby="adminMobileMenuLabel">
        <div class="offcanvas-header"><h2 class="offcanvas-title fs-5" id="adminMobileMenuLabel">FMS Portal Admin</h2><button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button></div>
        <div class="offcanvas-body">
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> ภาพรวม</a>
                <a href="{{ route('admin.systems.index') }}"><i class="bi bi-window-stack"></i> ระบบสารสนเทศ</a>
                <a href="{{ route('admin.news.index') }}"><i class="bi bi-newspaper"></i> ข่าวและประกาศ</a>
                <a href="{{ route('admin.events.index') }}"><i class="bi bi-calendar-event"></i> ปฏิทินกิจกรรม</a>
                <a href="{{ route('admin.documents.index') }}"><i class="bi bi-folder2-open"></i> เอกสารดาวน์โหลด</a>
                <a href="{{ route('admin.seo.edit') }}"><i class="bi bi-search-heart"></i> ตั้งค่า SEO</a>
                <div class="admin-nav-section is-open">
                    <span><i class="bi bi-building"></i>เกี่ยวกับหน่วยงาน</span>
                    <div class="admin-subnav">
                        <a href="{{ route('admin.about.edit') }}">เนื้อหาหน้า About</a>
                        <a href="{{ route('admin.about.responsibilities.index') }}">ภารกิจหลัก</a>
                        <a href="{{ route('admin.about.personnel.index') }}">บุคลากร</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</body>
</html>
