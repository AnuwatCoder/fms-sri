<x-admin-layout title="เอกสารดาวน์โหลด">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">DOCUMENTS & DOWNLOADS</span><h1>เอกสารดาวน์โหลด</h1><p>จัดการคู่มือ แบบฟอร์ม ไฟล์แนบ และลิงก์ดาวน์โหลด</p></div>
        <a class="btn btn-primary" href="{{ route('admin.documents.create') }}"><i class="bi bi-plus-lg"></i> เพิ่มเอกสาร</a>
    </div>
    <div class="admin-panel">
        <div class="admin-list-toolbar"><form method="get" class="admin-search"><i class="bi bi-search"></i><input name="q" value="{{ request('q') }}" placeholder="ค้นหาชื่อเอกสาร..."><button type="submit">ค้นหา</button></form><span>ทั้งหมด {{ $documents->total() }} รายการ</span></div>
        <div class="table-responsive">
            <table class="table admin-table align-middle mb-0">
                <thead><tr><th>เอกสาร</th><th>ประเภท</th><th>ขนาด</th><th>สถานะ</th><th class="text-end">จัดการ</th></tr></thead>
                <tbody>
                    @forelse ($documents as $document)
                        <tr>
                            <td><div class="admin-item-title"><span class="admin-item-icon admin-item-icon--{{ $document->color }}"><i class="bi {{ $document->icon }}"></i></span><div><strong>{{ $document->name }}</strong><small>{{ $document->category ?: '-' }}@if ($document->fiscal_year) · ปีงบประมาณ {{ $document->fiscal_year }}@endif @if ($document->version) · เวอร์ชัน {{ $document->version }}@endif · อัปเดต {{ $document->display_date }}</small></div></div></td>
                            <td>{{ $document->file_type ?: '-' }}</td><td>{{ $document->file_size ?: '-' }}</td><td><span class="admin-status {{ $document->is_active ? 'is-active' : '' }}">{{ $document->is_active ? 'เผยแพร่' : 'ซ่อน' }}</span></td>
                            <td class="text-end"><div class="admin-actions"><a href="{{ route('admin.documents.edit', $document) }}" aria-label="แก้ไข"><i class="bi bi-pencil"></i></a><form method="post" action="{{ route('admin.documents.destroy', $document) }}" onsubmit="return confirm('ยืนยันการลบเอกสารนี้?')">@csrf @method('delete')<button type="submit" aria-label="ลบ"><i class="bi bi-trash3"></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="admin-empty"><i class="bi bi-folder2-open"></i><span>ยังไม่มีเอกสาร</span></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($documents->hasPages())<div class="admin-pagination">{{ $documents->links() }}</div>@endif
    </div>
</x-admin-layout>
