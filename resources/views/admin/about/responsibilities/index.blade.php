<x-admin-layout title="ภารกิจหลัก">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">ABOUT / RESPONSIBILITIES</span><h1>ภารกิจหลักของหน่วยงาน</h1><p>จัดลำดับและเลือกภารกิจที่ต้องการเผยแพร่บนหน้า About</p></div>
        <a class="btn btn-primary" href="{{ route('admin.about.responsibilities.create') }}"><i class="bi bi-plus-lg"></i> เพิ่มภารกิจ</a>
    </div>
    <div class="admin-panel">
        <div class="table-responsive"><table class="table admin-table align-middle mb-0"><thead><tr><th style="width:72px">ลำดับ</th><th>ภารกิจ</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead><tbody>
            @forelse ($responsibilities as $responsibility)
                <tr><td><span class="admin-order">{{ $responsibility->sort_order }}</span></td><td><div class="admin-item-title"><span class="admin-item-icon"><i class="bi {{ $responsibility->icon }}"></i></span><div><strong>{{ $responsibility->title }}</strong><small>{{ $responsibility->description }}</small></div></div></td><td><span class="admin-status {{ $responsibility->is_active ? 'is-active' : '' }}">{{ $responsibility->is_active ? 'เผยแพร่' : 'ซ่อน' }}</span></td><td class="text-end"><div class="admin-actions"><a href="{{ route('admin.about.responsibilities.edit', $responsibility) }}" aria-label="แก้ไข"><i class="bi bi-pencil"></i></a><form method="post" action="{{ route('admin.about.responsibilities.destroy', $responsibility) }}" onsubmit="return confirm('ยืนยันการลบภารกิจนี้?')">@csrf @method('delete')<button type="submit" aria-label="ลบ"><i class="bi bi-trash3"></i></button></form></div></td></tr>
            @empty<tr><td colspan="4" class="admin-empty"><i class="bi bi-list-check"></i><span>ยังไม่มีข้อมูลภารกิจ</span></td></tr>@endforelse
        </tbody></table></div>
    </div>
</x-admin-layout>
