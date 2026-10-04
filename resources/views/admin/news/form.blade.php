<div class="admin-page-heading"><div><a class="admin-back" href="{{ route('admin.news.index') }}"><i class="bi bi-arrow-left"></i> กลับรายการ</a><h1>{{ $newsItem->exists ? 'แก้ไขข่าว/ประกาศ' : 'เพิ่มข่าว/ประกาศ' }}</h1><p>จัดการเนื้อหา ภาพประกอบ และกำหนดเวลาเผยแพร่</p></div></div>
<form method="post" action="{{ $action }}" enctype="multipart/form-data" class="admin-panel admin-edit-form">
    @csrf
    @if ($method !== 'post') @method($method) @endif
    @if ($errors->any())<div class="alert alert-danger"><strong>กรุณาตรวจสอบข้อมูล</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-form-section"><h2><span>1</span> เนื้อหาข่าว</h2><p>หัวข้อและรายละเอียดที่จะแสดงบนเว็บไซต์</p></div>
            <div class="row g-3">
                <div class="col-12"><label class="form-label" for="title">หัวข้อข่าว <b>*</b></label><input class="form-control" id="title" name="title" value="{{ old('title', $newsItem->title) }}" required></div>
                <div class="col-12"><label class="form-label" for="description">รายละเอียด</label><textarea class="form-control" id="description" name="description" rows="8">{{ old('description', $newsItem->description) }}</textarea></div>
                <div class="col-md-6"><label class="form-label" for="category">หมวดหมู่</label><input class="form-control" id="category" name="category" value="{{ old('category', $newsItem->category) }}" list="news-categories"><datalist id="news-categories"><option value="ประกาศ"><option value="ระบบสารสนเทศ"><option value="อบรม"></datalist></div>
                <div class="col-md-6"><label class="form-label" for="url">ลิงก์อ่านเพิ่มเติม</label><input class="form-control" id="url" name="url" value="{{ old('url', $newsItem->url) }}" placeholder="https://..."></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-form-section"><h2><span>2</span> การเผยแพร่</h2><p>ภาพ วันที่ และสถานะ</p></div>
            @if ($newsItem->image_path)<img class="admin-image-preview" src="{{ $newsItem->image_url }}" alt="ภาพข่าวปัจจุบัน">@endif
            <label class="form-label" for="image">ภาพประกอบ</label><input class="form-control" id="image" name="image" type="file" accept="image/*"><div class="form-text">JPG, PNG หรือ WebP ไม่เกิน 4 MB</div>
            @if ($newsItem->image_path)<div class="form-check mt-2"><input class="form-check-input" id="remove_image" name="remove_image" type="checkbox" value="1"><label class="form-check-label" for="remove_image">ลบภาพปัจจุบัน</label></div>@endif
            <div class="mt-3"><label class="form-label" for="published_at">วันที่เผยแพร่</label><input class="form-control" id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $newsItem->published_at?->format('Y-m-d\TH:i')) }}"></div>
            <div class="mt-3"><label class="form-label" for="sort_order">ลำดับ</label><input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $newsItem->sort_order ?? 0) }}" required></div>
            <div class="form-check form-switch mt-3"><input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $newsItem->exists ? $newsItem->is_active : true))><label class="form-check-label" for="is_active">เผยแพร่บนเว็บไซต์</label></div>
        </div>
    </div>
    <div class="admin-form-actions"><a class="btn btn-light" href="{{ route('admin.news.index') }}">ยกเลิก</a><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกข้อมูล</button></div>
</form>
