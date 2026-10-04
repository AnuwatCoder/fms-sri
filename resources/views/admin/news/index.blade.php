<x-admin-layout title="ข่าวและประกาศ">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">NEWS & ANNOUNCEMENTS</span><h1>ข่าวและประกาศ</h1><p>จัดการเนื้อหาข่าว ภาพประกอบ หมวดหมู่ และวันเผยแพร่</p></div>
        <a class="btn btn-primary" href="{{ route('admin.news.create') }}"><i class="bi bi-plus-lg"></i> เพิ่มข่าว</a>
    </div>
    <div class="admin-panel">
        <div class="admin-list-toolbar"><form method="get" class="admin-search"><i class="bi bi-search"></i><input name="q" value="{{ request('q') }}" placeholder="ค้นหาหัวข้อข่าว..."><button type="submit">ค้นหา</button></form><span>ทั้งหมด {{ $newsItems->total() }} รายการ</span></div>
        <div class="table-responsive">
            <table class="table admin-table align-middle mb-0">
                <thead><tr><th>ข่าว/ประกาศ</th><th>หมวดหมู่</th><th>วันที่เผยแพร่</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead>
                <tbody>
                    @forelse ($newsItems as $news)
                        <tr>
                            <td><div class="admin-item-title"><img class="admin-thumb" src="{{ $news->image_url }}" alt=""><div><strong>{{ $news->title }}</strong><small>{{ str($news->description)->limit(70) }}</small></div></div></td>
                            <td><span class="admin-category">{{ $news->category ?: '-' }}</span></td><td>{{ $news->display_date }}</td><td><span class="admin-status {{ $news->is_active ? 'is-active' : '' }}">{{ $news->is_active ? 'เผยแพร่' : 'ฉบับร่าง' }}</span></td>
                            <td class="text-end"><div class="admin-actions"><a href="{{ route('admin.news.edit', $news) }}" aria-label="แก้ไข"><i class="bi bi-pencil"></i></a><form method="post" action="{{ route('admin.news.destroy', $news) }}" onsubmit="return confirm('ยืนยันการลบข่าวนี้?')">@csrf @method('delete')<button type="submit" aria-label="ลบ"><i class="bi bi-trash3"></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="admin-empty"><i class="bi bi-newspaper"></i><span>ยังไม่มีข่าวหรือประกาศ</span></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($newsItems->hasPages())<div class="admin-pagination">{{ $newsItems->links() }}</div>@endif
    </div>
</x-admin-layout>
