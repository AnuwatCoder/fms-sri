<x-admin-layout title="ระบบสารสนเทศ">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">INFORMATION SYSTEMS</span><h1>ระบบสารสนเทศ</h1><p>จัดการการ์ดระบบ ลิงก์ หมวดหมู่ และลำดับการแสดงผล</p></div>
        <a class="btn btn-primary" href="{{ route('admin.systems.create') }}"><i class="bi bi-plus-lg"></i> เพิ่มระบบ</a>
    </div>
    <div class="admin-panel">
        <div class="admin-list-toolbar">
            <form method="get" class="admin-search"><i class="bi bi-search"></i><input name="q" value="{{ request('q') }}" placeholder="ค้นหาชื่อระบบ..."><button type="submit">ค้นหา</button></form>
            <span>ทั้งหมด {{ $systems->total() }} รายการ</span>
        </div>
        <div class="table-responsive">
            <table class="table admin-table align-middle mb-0">
                <thead><tr><th style="width:72px">ลำดับ</th><th>ระบบ</th><th>หมวดหมู่</th><th>การเข้าถึง</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead>
                <tbody>
                    @forelse ($systems as $system)
                        <tr>
                            <td><span class="admin-order">{{ $system->sort_order }}</span></td>
                            <td><div class="admin-item-title"><span class="admin-item-icon admin-item-icon--{{ $system->color }}"><i class="bi {{ $system->icon }}"></i></span><div><strong>{{ $system->name_th }}</strong><small>{{ $system->name_en }}</small></div></div></td>
                            <td><span class="admin-category">{{ $system->category ?: '-' }}</span></td>
                            <td><span class="admin-access admin-access--{{ $system->access_type }}"><i class="bi {{ $system->access_icon }}"></i>{{ $system->access_label }}</span></td>
                            <td><span class="admin-status {{ $system->is_active ? 'is-active' : '' }}">{{ $system->is_active ? 'เผยแพร่' : 'ซ่อน' }}</span></td>
                            <td class="text-end"><div class="admin-actions"><a href="{{ route('admin.systems.edit', $system) }}" aria-label="แก้ไข"><i class="bi bi-pencil"></i></a><form method="post" action="{{ route('admin.systems.destroy', $system) }}" onsubmit="return confirm('ยืนยันการลบระบบนี้?')">@csrf @method('delete')<button type="submit" aria-label="ลบ"><i class="bi bi-trash3"></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="admin-empty"><i class="bi bi-window-stack"></i><span>ยังไม่มีข้อมูลระบบสารสนเทศ</span></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($systems->hasPages())<div class="admin-pagination">{{ $systems->links() }}</div>@endif
    </div>
</x-admin-layout>
