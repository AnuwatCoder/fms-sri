<div class="admin-page-heading"><div><a class="admin-back" href="{{ route('admin.documents.index') }}"><i class="bi bi-arrow-left"></i> กลับรายการ</a><h1>{{ $document->exists ? 'แก้ไขเอกสาร' : 'เพิ่มเอกสาร' }}</h1><p>อัปโหลดไฟล์หรือระบุลิงก์ดาวน์โหลดภายนอก</p></div></div>
<form method="post" action="{{ $action }}" enctype="multipart/form-data" class="admin-panel admin-edit-form" data-document-form data-file-presentations='@json($filePresentations)'>
    @csrf
    @if ($method !== 'post') @method($method) @endif
    @if ($errors->any())<div class="alert alert-danger"><strong>กรุณาตรวจสอบข้อมูล</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-form-section"><h2><span>1</span> ข้อมูลเอกสาร</h2><p>ชื่อ หมวดหมู่ และคำอธิบาย</p></div>
            <div class="row g-3">
                <div class="col-12"><label class="form-label" for="name">ชื่อเอกสาร <b>*</b></label><input class="form-control" id="name" name="name" value="{{ old('name', $document->name) }}" required></div>
                <div class="col-12"><label class="form-label" for="description">คำอธิบาย</label><textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $document->description) }}</textarea></div>
                <div class="col-md-6"><label class="form-label" for="category">หมวดหมู่ <b>*</b></label><select class="form-select" id="category" name="category" required><option value="" disabled @selected(! old('category', $document->category))>เลือกหมวดหมู่</option>@foreach ($categories as $value => $label)<option value="{{ $value }}" @selected(old('category', $document->category) === $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="col-md-3"><label class="form-label" for="fiscal_year">ปีงบประมาณ <span class="text-muted fw-normal">(ไม่บังคับ)</span></label><input class="form-control" id="fiscal_year" name="fiscal_year" type="number" min="2400" max="2800" value="{{ old('fiscal_year', $document->fiscal_year) }}" placeholder="เช่น 2570"><div class="form-text">เว้นว่างได้สำหรับเอกสารทั่วไป เช่น กฎหมาย คู่มือ และแบบฟอร์ม</div></div>
                <div class="col-md-3"><label class="form-label" for="version">เวอร์ชัน</label><input class="form-control" id="version" name="version" value="{{ old('version', $document->version) }}" maxlength="30" placeholder="เช่น 1.0"></div>
                <div class="col-12"><label class="form-label" for="url">ลิงก์ดาวน์โหลดภายนอก</label><input class="form-control" id="url" name="url" value="{{ old('url', $document->url) }}" placeholder="https://..."></div>
                <div class="col-12"><label class="form-label" for="file">อัปโหลดไฟล์</label><input class="form-control" id="file" name="file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.csv,.zip" data-document-file><div class="form-text">PDF, Office, CSV หรือ ZIP ไม่เกิน 20 MB ระบบจะกรอกประเภท ขนาด ไอคอน และสีให้อัตโนมัติ</div>@if ($document->file_path)<div class="admin-current-file"><i class="bi bi-paperclip"></i><span>ไฟล์ปัจจุบัน: {{ basename($document->file_path) }}</span><label><input name="remove_file" type="checkbox" value="1"> ลบไฟล์</label></div>@endif</div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-form-section"><h2><span>2</span> การแสดงผล</h2><p>รูปแบบไฟล์ ไอคอน และสถานะ</p></div>
            <div class="mb-3"><label class="form-label" for="file_type">ประเภทไฟล์</label><input class="form-control" id="file_type" name="file_type" value="{{ old('file_type', $document->file_type) }}" placeholder="PDF" data-document-file-type></div>
            <div class="mb-3"><label class="form-label" for="file_size">ขนาดไฟล์</label><input class="form-control" id="file_size" name="file_size" value="{{ old('file_size', $document->file_size) }}" placeholder="4.2 MB" data-document-file-size></div>
            <div class="mb-3"><label class="form-label" for="icon">Bootstrap Icon</label><input class="form-control" id="icon" name="icon" value="{{ old('icon', $document->icon ?: 'bi-file-earmark-text') }}" required data-document-icon></div>
            <div class="mb-3"><label class="form-label" for="color">สี</label><select class="form-select" id="color" name="color" data-document-color>@foreach (['red' => 'แดง', 'blue' => 'น้ำเงิน', 'pink' => 'ชมพู', 'purple' => 'ม่วง', 'green' => 'เขียว', 'orange' => 'ส้ม', 'teal' => 'เขียวน้ำทะเล'] as $value => $label)<option value="{{ $value }}" @selected(old('color', $document->color ?: 'blue') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div class="mb-3"><label class="form-label" for="published_at">วันที่เผยแพร่</label><input class="form-control" id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $document->published_at?->format('Y-m-d\TH:i')) }}" data-document-published-at @if (! $document->exists) data-default-now @endif></div>
            <div class="mb-3"><label class="form-label" for="sort_order">ลำดับ</label><input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $document->sort_order ?? 0) }}" required></div>
            <div class="form-check form-switch"><input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $document->exists ? $document->is_active : true))><label class="form-check-label" for="is_active">เผยแพร่</label></div>
        </div>
    </div>
    <div class="admin-form-actions"><a class="btn btn-light" href="{{ route('admin.documents.index') }}">ยกเลิก</a><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกข้อมูล</button></div>
</form>
