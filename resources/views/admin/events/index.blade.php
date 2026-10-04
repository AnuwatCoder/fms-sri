<x-admin-layout title="ปฏิทินกิจกรรม">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">ACTIVITY CALENDAR</span><h1>ปฏิทินกิจกรรม</h1><p>จัดการวัน เวลา สถานที่ และรายละเอียดกิจกรรม</p></div>
        <a class="btn btn-primary" href="{{ route('admin.events.create') }}"><i class="bi bi-plus-lg"></i> เพิ่มกิจกรรม</a>
    </div>
    <div class="admin-panel">
        <div class="admin-list-toolbar"><form method="get" class="admin-search"><i class="bi bi-search"></i><input name="q" value="{{ request('q') }}" placeholder="ค้นหากิจกรรม..."><button type="submit">ค้นหา</button></form><span>ทั้งหมด {{ $events->total() }} รายการ</span></div>
        <div class="table-responsive">
            <table class="table admin-table align-middle mb-0">
                <thead><tr><th>กิจกรรม</th><th>วันและเวลา</th><th>สถานที่</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead>
                <tbody>
                    @forelse ($events as $event)
                        <tr>
                            <td><div class="admin-item-title"><span class="admin-date-box"><strong>{{ $event->display_day }}</strong><small>{{ $event->display_month }}</small></span><div><strong>{{ $event->title }}</strong><small>{{ str($event->description)->limit(70) }}</small></div></div></td>
                            <td>{{ $event->display_time }}</td><td>{{ $event->place ?: '-' }}</td><td><span class="admin-status {{ $event->is_active ? 'is-active' : '' }}">{{ $event->is_active ? 'เผยแพร่' : 'ซ่อน' }}</span></td>
                            <td class="text-end"><div class="admin-actions"><a href="{{ route('admin.events.edit', $event) }}" aria-label="แก้ไข"><i class="bi bi-pencil"></i></a><form method="post" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('ยืนยันการลบกิจกรรมนี้?')">@csrf @method('delete')<button type="submit" aria-label="ลบ"><i class="bi bi-trash3"></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="admin-empty"><i class="bi bi-calendar-event"></i><span>ยังไม่มีกิจกรรม</span></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($events->hasPages())<div class="admin-pagination">{{ $events->links() }}</div>@endif
    </div>
</x-admin-layout>
