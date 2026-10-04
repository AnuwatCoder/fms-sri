<div class="admin-page-heading">
    <div><a class="admin-back" href="{{ route('admin.systems.index') }}"><i class="bi bi-arrow-left"></i> กลับรายการ</a><h1>{{ $system->exists ? 'แก้ไขระบบสารสนเทศ' : 'เพิ่มระบบสารสนเทศ' }}</h1><p>ข้อมูลนี้จะแสดงเป็นการ์ดระบบบนหน้า Portal</p></div>
</div>
<form method="post" action="{{ $action }}" class="admin-panel admin-edit-form">
    @csrf
    @if ($method !== 'post') @method($method) @endif
    @if ($errors->any())<div class="alert alert-danger"><strong>กรุณาตรวจสอบข้อมูล</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="admin-form-section"><h2><span>1</span> ข้อมูลระบบ</h2><p>ชื่อและรายละเอียดที่ผู้ใช้งานจะเห็น</p></div>
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="name_th">ชื่อระบบ (ภาษาไทย) <b>*</b></label><input class="form-control" id="name_th" name="name_th" value="{{ old('name_th', $system->name_th) }}" required></div>
        <div class="col-md-6"><label class="form-label" for="name_en">ชื่อระบบ (ภาษาอังกฤษ)</label><input class="form-control" id="name_en" name="name_en" value="{{ old('name_en', $system->name_en) }}"></div>
        <div class="col-12"><label class="form-label" for="description">คำอธิบาย</label><textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $system->description) }}</textarea></div>
        <div class="col-12"><label class="form-label" for="url">ลิงก์เข้าใช้งาน</label><input class="form-control" id="url" name="url" type="text" value="{{ old('url', $system->url) }}" placeholder="https://..."></div>
        <div class="col-md-6"><label class="form-label" for="category">ชื่อหมวดหมู่</label><input class="form-control" id="category" name="category" value="{{ old('category', $system->category) }}" placeholder="เช่น บริการ IT"></div>
        <div class="col-md-6"><label class="form-label" for="access_type">การเข้าถึงระบบ <b>*</b></label><select class="form-select" id="access_type" name="access_type" required>@foreach (App\Enums\SystemAccessType::options() as $value => $label)<option value="{{ $value }}" @selected(old('access_type', $system->access_type ?: 'external') === $value)>{{ $label }}</option>@endforeach</select><div class="form-text">“ภายใน VPN” สำหรับระบบที่ต้องเชื่อมต่อเครือข่ายองค์กรก่อนใช้งาน</div></div>
    </div>
    <hr>
    <div class="admin-form-section"><h2><span>2</span> รูปแบบและการแสดงผล</h2><p>กำหนดไอคอน สี กลุ่ม และลำดับ</p></div>
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label" for="icon">Bootstrap Icon <b>*</b></label><input class="form-control" id="icon" name="icon" value="{{ old('icon', $system->icon ?: 'bi-grid-fill') }}" required><div class="form-text">ตัวอย่าง: bi-grid-fill, bi-coin</div></div>
        <div class="col-md-4"><label class="form-label" for="color">สีการ์ด <b>*</b></label><select class="form-select" id="color" name="color" required>@foreach (['blue' => 'น้ำเงิน', 'green' => 'เขียว', 'purple' => 'ม่วง', 'pink' => 'ชมพู', 'cyan' => 'ฟ้า', 'orange' => 'ส้ม', 'violet' => 'ม่วงเข้ม', 'teal' => 'เขียวน้ำทะเล'] as $value => $label)<option value="{{ $value }}" @selected(old('color', $system->color ?: 'blue') === $value)>{{ $label }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label" for="group_key">กลุ่มระบบ <b>*</b></label><select class="form-select" id="group_key" name="group_key" required>@foreach (['plan' => 'แผนและโครงการ', 'revenue' => 'บริหารรายได้', 'data' => 'ข้อมูลและรายงาน', 'service' => 'บริการและบุคลากร'] as $value => $label)<option value="{{ $value }}" @selected(old('group_key', $system->group_key ?: 'service') === $value)>{{ $label }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label" for="sort_order">ลำดับการแสดงผล <b>*</b></label><input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $system->sort_order ?? 0) }}" required></div>
        <div class="col-md-8 d-flex align-items-end gap-4 pb-2"><div class="form-check form-switch"><input class="form-check-input" id="is_featured" name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $system->is_featured))><label class="form-check-label" for="is_featured">แนะนำเป็นรายการโปรด</label></div><div class="form-check form-switch"><input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $system->exists ? $system->is_active : true))><label class="form-check-label" for="is_active">เผยแพร่</label></div></div>
    </div>
    <div class="admin-form-actions"><a class="btn btn-light" href="{{ route('admin.systems.index') }}">ยกเลิก</a><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกข้อมูล</button></div>
</form>
