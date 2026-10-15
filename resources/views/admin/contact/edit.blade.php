<x-admin-layout title="ช่องทางการติดต่อ">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">CONTACT INFORMATION</span><h1>ช่องทางการติดต่อหน่วยงาน</h1><p>จัดการข้อมูลที่อยู่ โทรศัพท์ อีเมล และเวลาทำการที่แสดงบนเว็บไซต์</p></div>
        <a class="btn btn-outline-primary" href="{{ route('contact') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> ดูหน้าติดต่อเรา</a>
    </div>

    <form method="post" action="{{ route('admin.contact.update') }}" class="admin-panel admin-edit-form">
        @csrf
        @method('put')
        @if ($errors->any())<div class="alert alert-danger"><strong>กรุณาตรวจสอบข้อมูล</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <div class="admin-form-section"><h2><span>1</span> ข้อความแนะนำ</h2><p>หัวข้อและข้อความเกริ่นนำในส่วนช่องทางการติดต่อ</p></div>
        <div class="row g-3">
            <div class="col-12"><label class="form-label" for="heading">หัวข้อ <b>*</b></label><input class="form-control" id="heading" name="heading" value="{{ old('heading', $contactSetting->heading) }}" maxlength="255" required></div>
            <div class="col-12"><label class="form-label" for="description">คำอธิบาย</label><textarea class="form-control" id="description" name="description" rows="3" maxlength="1000">{{ old('description', $contactSetting->description) }}</textarea></div>
        </div>

        <hr>
        <div class="admin-form-section"><h2><span>2</span> ข้อมูลติดต่อ</h2><p>ข้อมูลที่ผู้ใช้สามารถใช้ติดต่อหน่วยงานได้โดยตรง</p></div>
        <div class="row g-3">
            <div class="col-12"><label class="form-label" for="address">ที่อยู่ <b>*</b></label><textarea class="form-control" id="address" name="address" rows="4" maxlength="1000" required>{{ old('address', $contactSetting->address) }}</textarea><div class="form-text">ขึ้นบรรทัดใหม่ได้ตามรูปแบบที่ต้องการแสดงบนหน้าเว็บไซต์</div></div>
            <div class="col-md-6"><label class="form-label" for="phone">โทรศัพท์ <b>*</b></label><input class="form-control" id="phone" name="phone" type="tel" value="{{ old('phone', $contactSetting->phone) }}" maxlength="50" required></div>
            <div class="col-md-6"><label class="form-label" for="email">อีเมล <b>*</b></label><input class="form-control" id="email" name="email" type="email" value="{{ old('email', $contactSetting->email) }}" maxlength="255" required></div>
        </div>

        <hr>
        <div class="admin-form-section"><h2><span>3</span> เวลาทำการ</h2><p>ระบุวัน เวลา และหมายเหตุเกี่ยวกับวันหยุดของหน่วยงาน</p></div>
        <div class="row g-3">
            <div class="col-12"><label class="form-label" for="office_hours">วันและเวลาทำการ <b>*</b></label><input class="form-control" id="office_hours" name="office_hours" value="{{ old('office_hours', $contactSetting->office_hours) }}" maxlength="255" required></div>
            <div class="col-12"><label class="form-label" for="office_hours_note">หมายเหตุ</label><input class="form-control" id="office_hours_note" name="office_hours_note" value="{{ old('office_hours_note', $contactSetting->office_hours_note) }}" maxlength="500"></div>
        </div>

        <div class="admin-form-actions"><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกช่องทางการติดต่อ</button></div>
    </form>
</x-admin-layout>
