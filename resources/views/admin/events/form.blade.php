<div class="admin-page-heading"><div><a class="admin-back" href="{{ route('admin.events.index') }}"><i class="bi bi-arrow-left"></i> กลับรายการ</a><h1>{{ $event->exists ? 'แก้ไขกิจกรรม' : 'เพิ่มกิจกรรม' }}</h1><p>ระบุวัน เวลา สถานที่ และข้อมูลกิจกรรม</p></div></div>
<form method="post" action="{{ $action }}" class="admin-panel admin-edit-form">
    @csrf
    @if ($method !== 'post') @method($method) @endif
    @if ($errors->any())<div class="alert alert-danger"><strong>กรุณาตรวจสอบข้อมูล</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="admin-form-section"><h2><span>1</span> รายละเอียดกิจกรรม</h2><p>ข้อมูลหลักที่แสดงในปฏิทินหน้าเว็บไซต์</p></div>
    <div class="row g-3">
        <div class="col-12"><label class="form-label" for="title">ชื่อกิจกรรม <b>*</b></label><input class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required></div>
        <div class="col-12"><label class="form-label" for="description">รายละเอียด</label><textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $event->description) }}</textarea></div>
        <div class="col-md-6"><label class="form-label" for="starts_at">เริ่มกิจกรรม <b>*</b></label><input class="form-control" id="starts_at" name="starts_at" type="datetime-local" value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}" required></div>
        <div class="col-md-6"><label class="form-label" for="ends_at">สิ้นสุดกิจกรรม</label><input class="form-control" id="ends_at" name="ends_at" type="datetime-local" value="{{ old('ends_at', $event->ends_at?->format('Y-m-d\TH:i')) }}"></div>
        <div class="col-md-6"><label class="form-label" for="place">สถานที่</label><input class="form-control" id="place" name="place" value="{{ old('place', $event->place) }}" placeholder="เช่น ห้องประชุม 1 หรือ Zoom"></div>
        <div class="col-md-6"><label class="form-label" for="url">ลิงก์รายละเอียด/ลงทะเบียน</label><input class="form-control" id="url" name="url" value="{{ old('url', $event->url) }}" placeholder="https://..."></div>
        <div class="col-md-4"><label class="form-label" for="color">สี <b>*</b></label><select class="form-select" id="color" name="color">@foreach (['blue' => 'น้ำเงิน', 'green' => 'เขียว', 'pink' => 'ชมพู', 'purple' => 'ม่วง', 'orange' => 'ส้ม', 'teal' => 'เขียวน้ำทะเล'] as $value => $label)<option value="{{ $value }}" @selected(old('color', $event->color ?: 'blue') === $value)>{{ $label }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label" for="sort_order">ลำดับ</label><input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $event->sort_order ?? 0) }}" required></div>
        <div class="col-md-4 d-flex align-items-end pb-2"><div class="form-check form-switch"><input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $event->exists ? $event->is_active : true))><label class="form-check-label" for="is_active">เผยแพร่</label></div></div>
    </div>
    <div class="admin-form-actions"><a class="btn btn-light" href="{{ route('admin.events.index') }}">ยกเลิก</a><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกข้อมูล</button></div>
</form>
