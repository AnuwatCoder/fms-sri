<x-admin-layout title="บุคลากร">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">ABOUT / PERSONNEL</span><h1>บุคลากรของหน่วยงาน</h1><p>ผู้ที่กำหนดเป็นหัวหน้าหน่วยงานจะอยู่บนสุดโดยอัตโนมัติ</p></div>
        <a class="btn btn-primary" href="{{ route('admin.about.personnel.create') }}"><i class="bi bi-plus-lg"></i> เพิ่มบุคลากร</a>
    </div>
    <div class="admin-panel">
        <div class="table-responsive"><table class="table admin-table align-middle mb-0"><thead><tr><th style="width:72px">ลำดับ</th><th>บุคลากร</th><th>หน่วยงาน/หน้าที่</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead><tbody>
            @forelse ($personnel as $person)
                <tr><td><span class="admin-order">{{ $person->sort_order }}</span></td><td><div class="admin-item-title">@if ($person->photo_url)<img class="admin-person-thumb" src="{{ $person->photo_url }}" alt="">@else<span class="admin-person-initials">{{ $person->initials }}</span>@endif<div><strong>{{ $person->name_th }} @if ($person->is_head)<span class="admin-head-badge"><i class="bi bi-star-fill"></i> หัวหน้าหน่วยงาน</span>@endif</strong><small>{{ $person->name_en }}</small></div></div></td><td><div class="admin-item-title"><div><strong>{{ $person->position_th ?: '-' }}</strong><small>{{ $person->unit }}@if ($person->responsibilities) · {{ str($person->responsibilities_text)->limit(70) }}@endif</small></div></div></td><td><span class="admin-status {{ $person->is_active ? 'is-active' : '' }}">{{ $person->is_active ? 'เผยแพร่' : 'ซ่อน' }}</span></td><td class="text-end"><div class="admin-actions"><a href="{{ route('admin.about.personnel.edit', $person) }}" aria-label="แก้ไข"><i class="bi bi-pencil"></i></a><form method="post" action="{{ route('admin.about.personnel.destroy', $person) }}" onsubmit="return confirm('ยืนยันการลบบุคลากรนี้?')">@csrf @method('delete')<button type="submit" aria-label="ลบ"><i class="bi bi-trash3"></i></button></form></div></td></tr>
            @empty<tr><td colspan="5" class="admin-empty"><i class="bi bi-people"></i><span>ยังไม่มีข้อมูลบุคลากร</span></td></tr>@endforelse
        </tbody></table></div>
    </div>
</x-admin-layout>
