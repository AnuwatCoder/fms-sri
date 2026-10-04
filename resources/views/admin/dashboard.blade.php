<x-admin-layout title="ภาพรวมระบบ">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">DASHBOARD</span><h1>ยินดีต้อนรับ, {{ auth()->user()->name }}</h1><p>จัดการข้อมูลที่แสดงบน FMS Portal ได้จากที่นี่</p></div>
    </div>

    <div class="row g-3 admin-stat-grid">
        @foreach ([
            ['systems', 'ระบบสารสนเทศ', 'bi-window-stack', 'blue', 'admin.systems.index'],
            ['news', 'ข่าวและประกาศ', 'bi-newspaper', 'purple', 'admin.news.index'],
            ['events', 'กิจกรรม', 'bi-calendar-event', 'orange', 'admin.events.index'],
            ['documents', 'เอกสาร', 'bi-folder2-open', 'green', 'admin.documents.index'],
            ['personnel', 'บุคลากร', 'bi-people-fill', 'blue', 'admin.about.edit'],
        ] as [$key, $label, $icon, $color, $route])
            <div class="col-sm-6 col-xl-3">
                <a class="admin-stat-card admin-stat-card--{{ $color }}" href="{{ route($route) }}"><span><i class="bi {{ $icon }}"></i></span><div><strong>{{ $counts[$key] }}</strong><small>{{ $label }}</small></div><i class="bi bi-arrow-up-right"></i></a>
            </div>
        @endforeach
    </div>

    <div class="admin-panel mt-4">
        <div class="admin-panel__heading"><div><h2>อัปเดตข่าวล่าสุด</h2><p>รายการที่แก้ไขล่าสุดในระบบ</p></div><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.news.index') }}">ดูทั้งหมด</a></div>
        <div class="table-responsive">
            <table class="table admin-table align-middle mb-0">
                <thead><tr><th>หัวข้อ</th><th>หมวดหมู่</th><th>สถานะ</th><th>แก้ไขล่าสุด</th></tr></thead>
                <tbody>
                    @forelse ($recentNews as $news)
                        <tr><td><a href="{{ route('admin.news.edit', $news) }}">{{ $news->title }}</a></td><td>{{ $news->category ?: '-' }}</td><td><span class="admin-status {{ $news->is_active ? 'is-active' : '' }}">{{ $news->is_active ? 'เผยแพร่' : 'ฉบับร่าง' }}</span></td><td>{{ $news->updated_at->diffForHumans() }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-secondary py-5">ยังไม่มีข้อมูลข่าว</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
