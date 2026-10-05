<x-admin-layout title="ตั้งค่า SEO">
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">SEO &amp; SOCIAL SHARING</span><h1>ตั้งค่า SEO</h1><p>จัดการข้อมูลสำหรับ Search Engine และตัวอย่างเมื่อแชร์หน้าเว็บไซต์บนโซเชียลมีเดีย</p></div>
        <a class="btn btn-outline-primary" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> ดูหน้าเว็บไซต์</a>
    </div>

    <form method="post" action="{{ route('admin.seo.update') }}" enctype="multipart/form-data" class="admin-panel admin-edit-form">
        @csrf
        @method('put')
        @if ($errors->any())<div class="alert alert-danger"><strong>กรุณาตรวจสอบข้อมูล</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <div class="admin-form-section"><h2><span>1</span> ข้อมูลพื้นฐาน</h2><p>ชื่อและคำอธิบายหลักที่ใช้เมื่อหน้าใดไม่มีข้อมูล SEO เฉพาะ</p></div>
        <div class="row g-3">
            <div class="col-md-5"><label class="form-label" for="site_name">ชื่อเว็บไซต์ <b>*</b></label><input class="form-control" id="site_name" name="site_name" value="{{ old('site_name', $seoSetting->site_name) }}" maxlength="100" required></div>
            <div class="col-md-7"><label class="form-label" for="default_title">ชื่อเรื่องหลัก <b>*</b></label><input class="form-control" id="default_title" name="default_title" value="{{ old('default_title', $seoSetting->default_title) }}" maxlength="70" required><div class="form-text">แนะนำไม่เกิน 60–70 ตัวอักษร</div></div>
            <div class="col-12"><label class="form-label" for="default_description">คำอธิบายหลัก <b>*</b></label><textarea class="form-control" id="default_description" name="default_description" rows="3" maxlength="160" required>{{ old('default_description', $seoSetting->default_description) }}</textarea><div class="form-text">แนะนำ 120–160 ตัวอักษร</div></div>
            <div class="col-md-7"><label class="form-label" for="keywords">คำสำคัญ</label><input class="form-control" id="keywords" name="keywords" value="{{ old('keywords', $seoSetting->keywords) }}" maxlength="500" placeholder="คั่นแต่ละคำด้วยเครื่องหมายจุลภาค"></div>
            <div class="col-md-5"><label class="form-label" for="author">ผู้จัดทำเว็บไซต์</label><input class="form-control" id="author" name="author" value="{{ old('author', $seoSetting->author) }}" maxlength="255"></div>
        </div>

        <hr>
        <div class="admin-form-section"><h2><span>2</span> การแชร์บนโซเชียล</h2><p>ภาพเริ่มต้นสำหรับ Open Graph และ Twitter Card ควรมีอัตราส่วนประมาณ 1.91:1</p></div>
        <div class="row g-3 align-items-start">
            <div class="col-lg-8">
                <label class="form-label" for="og_image">ภาพตัวอย่างการแชร์</label><input class="form-control" id="og_image" name="og_image" type="file" accept="image/jpeg,image/png,image/webp"><div class="form-text">JPG, PNG หรือ WebP ไม่เกิน 6 MB แนะนำขนาด 1200 × 630 พิกเซล</div>
                @if ($seoSetting->og_image_path)<div class="form-check mt-2"><input class="form-check-input" id="remove_og_image" name="remove_og_image" type="checkbox" value="1"><label class="form-check-label" for="remove_og_image">ลบภาพปัจจุบันและกลับไปใช้โลโก้เริ่มต้น</label></div>@endif
                <div class="mt-3"><label class="form-label" for="twitter_site">บัญชี X/Twitter</label><input class="form-control" id="twitter_site" name="twitter_site" value="{{ old('twitter_site', $seoSetting->twitter_site) }}" maxlength="50" placeholder="@account"><div class="form-text">เว้นว่างได้หากไม่มีบัญชี</div></div>
            </div>
            <div class="col-lg-4"><img class="admin-image-preview seo-image-preview mb-0" src="{{ $seoSetting->og_image_url }}" alt="ภาพตัวอย่างการแชร์ปัจจุบัน"></div>
        </div>

        <hr>
        <div class="admin-form-section"><h2><span>3</span> Search Engine</h2><p>ควบคุมการจัดทำดัชนีและยืนยันเว็บไซต์กับ Google Search Console</p></div>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="google_site_verification">Google site verification</label><input class="form-control" id="google_site_verification" name="google_site_verification" value="{{ old('google_site_verification', $seoSetting->google_site_verification) }}" maxlength="255" placeholder="รหัส content จาก Google Search Console"></div>
            <div class="col-md-6 d-flex flex-column justify-content-center gap-2">
                <div class="form-check form-switch"><input class="form-check-input" id="robots_index" name="robots_index" type="checkbox" value="1" @checked(old('robots_index', $seoSetting->robots_index))><label class="form-check-label" for="robots_index">อนุญาตให้ Search Engine จัดทำดัชนีเว็บไซต์</label></div>
                <div class="form-check form-switch"><input class="form-check-input" id="robots_follow" name="robots_follow" type="checkbox" value="1" @checked(old('robots_follow', $seoSetting->robots_follow))><label class="form-check-label" for="robots_follow">อนุญาตให้ติดตามลิงก์ภายในเว็บไซต์</label></div>
            </div>
        </div>

        <div class="admin-form-actions"><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกการตั้งค่า SEO</button></div>
    </form>
</x-admin-layout>
