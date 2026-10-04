<div class="admin-page-heading"><div><a class="admin-back" href="{{ route('admin.about.personnel.index') }}"><i class="bi bi-arrow-left"></i> กลับรายการบุคลากร</a><h1>{{ $person->exists ? 'แก้ไขบุคลากร' : 'เพิ่มบุคลากร' }}</h1><p>ข้อมูลนี้จะแสดงในส่วนบุคลากรของหน่วยงาน</p></div></div>
<form method="post" action="{{ $action }}" enctype="multipart/form-data" class="admin-panel admin-edit-form">
    @csrf @if ($method !== 'post') @method($method) @endif
    @if ($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row g-4">
        <div class="col-lg-8"><div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="name_th">ชื่อ-นามสกุล (ไทย) <b>*</b></label><input class="form-control" id="name_th" name="name_th" value="{{ old('name_th', $person->name_th) }}" required></div>
            <div class="col-md-6"><label class="form-label" for="name_en">ชื่อ-นามสกุล (อังกฤษ)</label><input class="form-control" id="name_en" name="name_en" value="{{ old('name_en', $person->name_en) }}"></div>
            <div class="col-md-6"><label class="form-label" for="position_th">ตำแหน่ง (ไทย)</label><input class="form-control" id="position_th" name="position_th" value="{{ old('position_th', $person->position_th) }}"></div>
            <div class="col-md-6"><label class="form-label" for="position_en">ตำแหน่ง (อังกฤษ)</label><input class="form-control" id="position_en" name="position_en" value="{{ old('position_en', $person->position_en) }}"></div>
            <div class="col-12"><label class="form-label" for="unit">หน่วยงาน/หน้าที่รับผิดชอบ</label><input class="form-control" id="unit" name="unit" value="{{ old('unit', $person->unit) }}"></div>
            @php($responsibilities = \App\Support\RichText::sanitize(old('responsibilities', $person->responsibilities)))
            <div class="col-12">
                <label class="form-label" id="responsibilities-label" for="responsibilities_editor">ภาระงานที่รับผิดชอบ</label>
                <div class="admin-rich-text" data-rich-text>
                    <div class="admin-rich-text__toolbar" role="toolbar" aria-label="จัดรูปแบบภาระงาน">
                        <button type="button" data-rich-command="bold" aria-label="ตัวหนา" title="ตัวหนา"><i class="bi bi-type-bold" aria-hidden="true"></i></button>
                        <button type="button" data-rich-command="italic" aria-label="ตัวเอียง" title="ตัวเอียง"><i class="bi bi-type-italic" aria-hidden="true"></i></button>
                        <button type="button" data-rich-command="underline" aria-label="ขีดเส้นใต้" title="ขีดเส้นใต้"><i class="bi bi-type-underline" aria-hidden="true"></i></button>
                    </div>
                    <div class="admin-rich-text__editor" id="responsibilities_editor" contenteditable="true" role="textbox" aria-labelledby="responsibilities-label" aria-multiline="true" data-placeholder="ระบุภาระงานแต่ละรายการแยกบรรทัด" data-rich-editor>{!! $responsibilities !!}</div>
                    <textarea id="responsibilities" name="responsibilities" maxlength="5000" data-rich-input hidden>{{ $responsibilities }}</textarea>
                </div>
                <div class="form-text">เลือกข้อความแล้วกดตัวหนา ตัวเอียง หรือขีดเส้นใต้ และสามารถขึ้นบรรทัดใหม่เพื่อแยกรายการได้</div>
            </div>
            <div class="col-md-6"><label class="form-label" for="email">อีเมล</label><input class="form-control" id="email" name="email" type="email" value="{{ old('email', $person->email) }}"></div>
            <div class="col-md-6"><label class="form-label" for="phone">โทรศัพท์</label><input class="form-control" id="phone" name="phone" value="{{ old('phone', $person->phone) }}"></div>
        </div></div>
        <div class="col-lg-4">
            @if ($person->photo_url)<img class="admin-person-preview" src="{{ $person->photo_url }}" alt="รูปบุคลากรปัจจุบัน">@endif
            <div class="mb-3"><label class="form-label" for="photo">รูปบุคลากร</label><input class="form-control" id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp"><div class="form-text">รองรับ JPG, PNG และ WebP ขนาดไม่เกิน 4 MB</div>@if ($person->photo_path)<div class="form-check mt-2"><input class="form-check-input" id="remove_photo" name="remove_photo" type="checkbox" value="1"><label class="form-check-label" for="remove_photo">ลบรูปปัจจุบัน</label></div>@endif</div>
            <div class="mb-3"><label class="form-label" for="initials">อักษรย่อ</label><input class="form-control" id="initials" name="initials" maxlength="10" value="{{ old('initials', $person->initials) }}" placeholder="เช่น AP"></div>
            <div class="mb-3"><label class="form-label" for="color">สี</label><select class="form-select" id="color" name="color">@foreach (['navy' => 'กรมท่า', 'blue' => 'น้ำเงิน', 'green' => 'เขียว', 'purple' => 'ม่วง', 'pink' => 'ชมพู', 'teal' => 'เขียวน้ำทะเล', 'orange' => 'ส้ม'] as $value => $label)<option value="{{ $value }}" @selected(old('color', $person->color ?: 'blue') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div class="mb-3"><label class="form-label" for="sort_order">ลำดับ</label><input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $person->sort_order ?? 0) }}" required></div>
            <div class="form-check form-switch mb-2"><input class="form-check-input" id="is_head" name="is_head" type="checkbox" value="1" @checked(old('is_head', $person->is_head))><label class="form-check-label" for="is_head">หัวหน้าหน่วยงาน</label><div class="form-text">เมื่อเลือก บุคลากรคนนี้จะอยู่บนสุดและแทนที่หัวหน้าคนเดิม</div></div>
            <div class="form-check form-switch"><input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $person->exists ? $person->is_active : true))><label class="form-check-label" for="is_active">เผยแพร่</label></div>
        </div>
    </div>
    <div class="admin-form-actions"><a class="btn btn-light" href="{{ route('admin.about.personnel.index') }}">ยกเลิก</a><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกข้อมูล</button></div>
</form>
