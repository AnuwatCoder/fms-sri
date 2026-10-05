<div>
    <div class="subpage-toolbar">
        <div><h2 id="news-list-title">ข่าวล่าสุด</h2><p>ข้อมูลข่าวสารและความเคลื่อนไหวที่ควรรู้</p></div>
        <div class="filter-pills mb-0" aria-label="ประเภทข่าว">
            @foreach ($categories as $value)
                <button type="button" class="{{ $category === $value ? 'active' : '' }}" wire:click="setCategory('{{ $value }}')">{{ $value }}</button>
            @endforeach
        </div>
    </div>
    <div class="position-relative">
        <div class="livewire-loading" wire:loading.delay aria-live="polite"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> กำลังอัปเดต...</div>
        <div class="row g-4">
            @forelse ($newsItems as $news)
                <div class="col-md-6 col-lg-4" wire:key="news-{{ $news->id }}">
                    <article class="news-list-card h-100 position-relative">
                        <div class="news-list-card__image"><img src="{{ $news->image_url }}" alt="" loading="lazy"><span>{{ $news->category }}</span></div>
                        <div class="news-list-card__body">
                            <time><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $news->display_date }}</time>
                            <h2>{{ $news->title }}</h2>
                            <p>{{ $news->description }}</p>
                            <a class="stretched-link" href="{{ route('news.show', $news) }}" aria-label="อ่านรายละเอียด: {{ $news->title }}">อ่านรายละเอียด <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12"><div class="empty-state" role="status"><i class="bi bi-newspaper"></i><p class="mb-0">ยังไม่มีข่าวในหมวดหมู่นี้</p></div></div>
            @endforelse
        </div>
    </div>
</div>
