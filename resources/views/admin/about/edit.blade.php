<x-admin-layout title="เนื้อหาหน้า About">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">ABOUT PAGE</span><h1>เนื้อหาหน้าเกี่ยวกับหน่วยงาน</h1><p>จัดการข้อความส่วนหัว เนื้อหาแนะนำ และหัวข้อของแต่ละส่วน</p></div>
        <a class="btn btn-outline-primary" href="{{ route('about') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> ดูหน้าเว็บไซต์</a>
    </div>

    <form method="post" action="{{ route('admin.about.update') }}" enctype="multipart/form-data" class="admin-panel admin-edit-form">
        @csrf
        @method('put')
        @if ($errors->any())<div class="alert alert-danger"><strong>กรุณาตรวจสอบข้อมูล</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <div class="admin-form-section"><h2><span>1</span> ส่วนหัวของหน้า</h2><p>ชื่อหน้า ข้อความแนะนำ และข้อมูลสำหรับ Search Engine</p></div>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="page_title">ชื่อหน้า <b>*</b></label><input class="form-control" id="page_title" name="page_title" value="{{ old('page_title', $aboutPage->page_title) }}" required></div>
            <div class="col-md-6"><label class="form-label" for="hero_eyebrow">ข้อความภาษาอังกฤษ</label><input class="form-control" id="hero_eyebrow" name="hero_eyebrow" value="{{ old('hero_eyebrow', $aboutPage->hero_eyebrow) }}"></div>
            <div class="col-12"><label class="form-label" for="hero_description">คำอธิบายส่วนหัว</label><textarea class="form-control" id="hero_description" name="hero_description" rows="2">{{ old('hero_description', $aboutPage->hero_description) }}</textarea></div>
            <div class="col-12"><label class="form-label" for="meta_description">Meta description</label><textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $aboutPage->meta_description) }}</textarea></div>
        </div>

        <hr>
        <div class="admin-form-section"><h2><span>2</span> แนะนำหน่วยงาน</h2><p>เนื้อหาหลักและภาพประกอบ</p></div>
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label" for="intro_eyebrow">ข้อความกำกับ</label><input class="form-control" id="intro_eyebrow" name="intro_eyebrow" value="{{ old('intro_eyebrow', $aboutPage->intro_eyebrow) }}"></div>
            <div class="col-md-8"><label class="form-label" for="intro_heading">หัวข้อ <b>*</b></label><textarea class="form-control" id="intro_heading" name="intro_heading" rows="2" required>{{ old('intro_heading', $aboutPage->intro_heading) }}</textarea><div class="form-text">ขึ้นบรรทัดใหม่ได้ตามต้องการ</div></div>
            <div class="col-md-6"><label class="form-label" for="intro_paragraph_1">เนื้อหาย่อหน้าที่ 1</label><textarea class="form-control" id="intro_paragraph_1" name="intro_paragraph_1" rows="6">{{ old('intro_paragraph_1', $aboutPage->intro_paragraph_1) }}</textarea></div>
            <div class="col-md-6"><label class="form-label" for="intro_paragraph_2">เนื้อหาย่อหน้าที่ 2</label><textarea class="form-control" id="intro_paragraph_2" name="intro_paragraph_2" rows="6">{{ old('intro_paragraph_2', $aboutPage->intro_paragraph_2) }}</textarea></div>
            <div class="col-md-8"><label class="form-label" for="image">ภาพประกอบ</label><input class="form-control" id="image" name="image" type="file" accept="image/*"><div class="form-text">JPG, PNG หรือ WebP ไม่เกิน 6 MB</div>@if ($aboutPage->image_path)<div class="form-check mt-2"><input class="form-check-input" id="remove_image" name="remove_image" type="checkbox" value="1"><label class="form-check-label" for="remove_image">ลบภาพปัจจุบัน</label></div>@endif</div>
            <div class="col-md-4">@if ($aboutPage->image_path)<img class="admin-image-preview mb-0" src="{{ $aboutPage->image_url }}" alt="ภาพหน้าเกี่ยวกับหน่วยงาน">@endif</div>
        </div>

        <hr>
        <div class="admin-form-section"><h2><span>3</span> หัวข้อรายการ</h2><p>ข้อความนำของส่วนภารกิจและบุคลากร</p></div>
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label" for="responsibilities_eyebrow">ข้อความกำกับภารกิจ</label><input class="form-control" id="responsibilities_eyebrow" name="responsibilities_eyebrow" value="{{ old('responsibilities_eyebrow', $aboutPage->responsibilities_eyebrow) }}"></div>
            <div class="col-md-4"><label class="form-label" for="responsibilities_title">หัวข้อภารกิจ</label><input class="form-control" id="responsibilities_title" name="responsibilities_title" value="{{ old('responsibilities_title', $aboutPage->responsibilities_title) }}"></div>
            <div class="col-md-4"><label class="form-label" for="responsibilities_description">คำอธิบายภารกิจ</label><input class="form-control" id="responsibilities_description" name="responsibilities_description" value="{{ old('responsibilities_description', $aboutPage->responsibilities_description) }}"></div>
            <div class="col-md-4"><label class="form-label" for="personnel_eyebrow">ข้อความกำกับบุคลากร</label><input class="form-control" id="personnel_eyebrow" name="personnel_eyebrow" value="{{ old('personnel_eyebrow', $aboutPage->personnel_eyebrow) }}"></div>
            <div class="col-md-4"><label class="form-label" for="personnel_title">หัวข้อบุคลากร</label><input class="form-control" id="personnel_title" name="personnel_title" value="{{ old('personnel_title', $aboutPage->personnel_title) }}"></div>
            <div class="col-md-4"><label class="form-label" for="personnel_description">คำอธิบายบุคลากร</label><input class="form-control" id="personnel_description" name="personnel_description" value="{{ old('personnel_description', $aboutPage->personnel_description) }}"></div>
        </div>
        <div class="admin-form-actions"><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกเนื้อหาหน้า About</button></div>
    </form>
</x-admin-layout>
