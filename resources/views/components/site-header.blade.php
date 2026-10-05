<header class="site-header sticky-top">
    <nav class="navbar navbar-expand-xl bg-white" aria-label="เมนูหลัก">
        <div class="container-fluid">
            <a class="navbar-brand brand-lockup" href="{{ route('home') }}" aria-label="หน้าหลัก คณะวิทยาการจัดการ" wire:navigate>
                <img class="brand-logo" src="{{ asset('images/psu-fms-logo-th.png') }}" width="3616" height="800" alt="">
            </a>

            <div class="navbar-actions d-flex align-items-center gap-1 order-xl-3">
                <a class="header-icon d-none d-sm-inline-flex" href="{{ route('search.index') }}" aria-label="ค้นหาทั้งเว็บไซต์" wire:navigate><i class="bi bi-search" aria-hidden="true"></i></a>
                <button class="navbar-toggler ms-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavigation" aria-controls="mobileNavigation" aria-label="เปิดเมนู"><span class="navbar-toggler-icon"></span></button>
            </div>

            <div class="collapse navbar-collapse justify-content-center d-none d-xl-flex">
                <ul class="navbar-nav gap-1">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" @if(request()->routeIs('home')) aria-current="page" @endif href="{{ route('home') }}" wire:navigate><i class="bi bi-house-fill"></i> หน้าหลัก</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('systems.*') ? 'active' : '' }}" @if(request()->routeIs('systems.*')) aria-current="page" @endif href="{{ route('systems.index') }}" wire:navigate><i class="bi bi-grid-fill"></i> ระบบสารสนเทศ</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" @if(request()->routeIs('news.*')) aria-current="page" @endif href="{{ route('news.index') }}" wire:navigate><i class="bi bi-newspaper"></i> ข่าวสาร</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}" @if(request()->routeIs('documents.*')) aria-current="page" @endif href="{{ route('documents.index') }}" wire:navigate><i class="bi bi-file-earmark-text-fill"></i> เอกสาร/ดาวน์โหลด</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" @if(request()->routeIs('about')) aria-current="page" @endif href="{{ route('about') }}" wire:navigate><i class="bi bi-building"></i> เกี่ยวกับหน่วยงาน</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" @if(request()->routeIs('contact')) aria-current="page" @endif href="{{ route('contact') }}" wire:navigate><i class="bi bi-geo-alt-fill"></i> ติดต่อเรา</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileNavigation" aria-labelledby="mobileNavigationLabel">
    <div class="offcanvas-header border-bottom">
        <div><h2 class="offcanvas-title fs-5" id="mobileNavigationLabel">FMS Portal</h2><small class="text-secondary">คณะวิทยาการจัดการ</small></div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="ปิดเมนู"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="mobile-nav" aria-label="เมนูมือถือ">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" data-bs-dismiss="offcanvas" wire:navigate><i class="bi bi-house-fill"></i> หน้าหลัก</a>
            <a class="{{ request()->routeIs('systems.*') ? 'active' : '' }}" href="{{ route('systems.index') }}" data-bs-dismiss="offcanvas" wire:navigate><i class="bi bi-grid-fill"></i> ระบบสารสนเทศ</a>
            <a class="{{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}" data-bs-dismiss="offcanvas" wire:navigate><i class="bi bi-newspaper"></i> ข่าวสาร</a>
            <a class="{{ request()->routeIs('documents.*') ? 'active' : '' }}" href="{{ route('documents.index') }}" data-bs-dismiss="offcanvas" wire:navigate><i class="bi bi-file-earmark-text-fill"></i> เอกสาร/ดาวน์โหลด</a>
            <a class="{{ request()->routeIs('search.*') ? 'active' : '' }}" href="{{ route('search.index') }}" data-bs-dismiss="offcanvas" wire:navigate><i class="bi bi-search"></i> ค้นหาทั้งเว็บไซต์</a>
            <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}" data-bs-dismiss="offcanvas" wire:navigate><i class="bi bi-building"></i> เกี่ยวกับหน่วยงาน</a>
            <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}" data-bs-dismiss="offcanvas" wire:navigate><i class="bi bi-geo-alt-fill"></i> ติดต่อเรา</a>
        </nav>
    </div>
</div>
