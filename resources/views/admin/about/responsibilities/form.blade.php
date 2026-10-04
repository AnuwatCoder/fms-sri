<div class="admin-page-heading"><div><a class="admin-back" href="{{ route('admin.about.responsibilities.index') }}"><i class="bi bi-arrow-left"></i> กลับรายการภารกิจ</a><h1>{{ $responsibility->exists ? 'แก้ไขภารกิจ' : 'เพิ่มภารกิจ' }}</h1><p>ข้อมูลนี้จะแสดงในส่วนภารกิจหลักของหน่วยงาน</p></div></div>
<form method="post" action="{{ $action }}" class="admin-panel admin-edit-form">
    @csrf @if ($method !== 'post') @method($method) @endif
    @if ($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row g-3">
        <div class="col-md-8"><label class="form-label" for="title">ชื่อภารกิจ <b>*</b></label><input class="form-control" id="title" name="title" value="{{ old('title', $responsibility->title) }}" required></div>
        <div class="col-md-4"><label class="form-label" for="icon">Bootstrap Icon <b>*</b></label><input class="form-control" id="icon" name="icon" value="{{ old('icon', $responsibility->icon ?: 'bi-check-circle-fill') }}" required></div>
        <div class="col-12"><label class="form-label" for="description">รายละเอียด</label><textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $responsibility->description) }}</textarea></div>
        <div class="col-md-4"><label class="form-label" for="sort_order">ลำดับ <b>*</b></label><input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $responsibility->sort_order ?? 0) }}" required></div>
        <div class="col-md-8 d-flex align-items-end pb-2"><div class="form-check form-switch"><input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $responsibility->exists ? $responsibility->is_active : true))><label class="form-check-label" for="is_active">เผยแพร่</label></div></div>
    </div>
    <div class="admin-form-actions"><a class="btn btn-light" href="{{ route('admin.about.responsibilities.index') }}">ยกเลิก</a><button class="btn btn-primary" type="submit"><i class="bi bi-check-lg"></i> บันทึกข้อมูล</button></div>
</form>
