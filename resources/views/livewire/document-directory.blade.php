<div>
    <div class="subpage-toolbar">
        <div><h2 id="documents-list-title">เอกสารทั้งหมด</h2><p>เลือกดาวน์โหลดเอกสารตามประเภทที่ต้องการ</p></div>
        <div class="filter-pills mb-0" aria-label="ประเภทเอกสาร">
            @foreach ($categories as $value)
                <button type="button" class="{{ $category === $value ? 'active' : '' }}" wire:click="setCategory('{{ $value }}')">{{ $value }}</button>
            @endforeach
        </div>
    </div>
    <div class="position-relative">
        <div class="livewire-loading" wire:loading.delay aria-live="polite"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> กำลังอัปเดต...</div>
        <div class="document-table" role="list">
            @forelse ($documents as $document)
                <article class="document-row" role="listitem" wire:key="document-{{ $document->id }}">
                    <span class="document-row__icon document-row__icon--{{ $document->color }}" aria-hidden="true"><i class="bi {{ $document->icon }}"></i></span>
                    <div class="document-row__content"><span class="document-row__category">{{ $document->category }}</span><h2>{{ $document->name }}</h2><p>{{ $document->description }}</p></div>
                    <div class="document-row__meta"><span>{{ $document->file_type }}</span><small>{{ $document->file_size }}</small><small>อัปเดต {{ $document->display_date }}</small></div>
                    <a class="document-row__download" href="{{ $document->download_url }}" aria-label="ดาวน์โหลด {{ $document->name }}"><i class="bi bi-download"></i><span>ดาวน์โหลด</span></a>
                </article>
            @empty
                <div class="empty-state border-0" role="status"><i class="bi bi-folder"></i><p class="mb-0">ยังไม่มีเอกสารในหมวดหมู่นี้</p></div>
            @endforelse
        </div>
    </div>
</div>
