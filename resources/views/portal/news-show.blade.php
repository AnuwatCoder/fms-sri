<x-portal-layout :title="$newsItem->title" :description="Str::limit($newsItem->description ?: $newsItem->title, 160)" :image="$newsItem->image_url" type="article">
    <main id="main-content">
        <x-page-hero title="รายละเอียดข่าว" eyebrow="NEWS DETAIL" :description="$newsItem->title" icon="bi-newspaper" />

        <section class="subpage-content">
            <div class="container-fluid">
                <div class="news-detail-shell">
                    <a class="news-detail-back" href="{{ route('news.index') }}" wire:navigate><i class="bi bi-arrow-left" aria-hidden="true"></i> กลับหน้าข่าวสารทั้งหมด</a>

                    <article class="news-detail">
                        <figure class="news-detail__image">
                            <img src="{{ $newsItem->image_url }}" alt="ภาพประกอบข่าว {{ $newsItem->title }}">
                        </figure>
                        <div class="news-detail__body">
                            <div class="news-detail__meta">
                                @if ($newsItem->category)<span><i class="bi bi-tag-fill" aria-hidden="true"></i> {{ $newsItem->category }}</span>@endif
                                <time datetime="{{ $newsItem->published_at?->toDateString() }}"><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $newsItem->display_date }}</time>
                            </div>
                            <h1>{{ $newsItem->title }}</h1>
                            @if ($newsItem->description)
                                <div class="news-detail__content">{!! nl2br(e($newsItem->description)) !!}</div>
                            @else
                                <p class="news-detail__empty">ยังไม่มีรายละเอียดเพิ่มเติมสำหรับข่าวนี้</p>
                            @endif

                            @if ($newsItem->url && $newsItem->url !== '#')
                                <a class="btn btn-primary news-detail__source" href="{{ $newsItem->url }}" target="_blank" rel="noopener noreferrer">ดูข้อมูลเพิ่มเติม <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
                            @endif
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>
</x-portal-layout>
