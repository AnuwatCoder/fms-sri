<x-portal-layout :title="$aboutPage->page_title" :description="$aboutPage->meta_description">
    <main id="main-content">
        <x-page-hero :title="$aboutPage->page_title" :eyebrow="$aboutPage->hero_eyebrow" :description="$aboutPage->hero_description" icon="bi-building" />

        <section class="subpage-content" aria-labelledby="about-title">
            <div class="container-fluid">
                <div class="row g-5 align-items-center about-intro">
                    <div class="col-lg-6">
                        <p class="section-kicker">{{ $aboutPage->intro_eyebrow }}</p>
                        <h2 id="about-title">{!! nl2br(e($aboutPage->intro_heading)) !!}</h2>
                        @if ($aboutPage->intro_paragraph_1)<p>{{ $aboutPage->intro_paragraph_1 }}</p>@endif
                        @if ($aboutPage->intro_paragraph_2)<p>{{ $aboutPage->intro_paragraph_2 }}</p>@endif
                    </div>
                    <div class="col-lg-6">
                        <div class="about-visual" style="--about-image: url('{{ $aboutPage->image_url }}')" role="img" aria-label="อาคารมหาวิทยาลัยและแนวคิดการบริหารด้วยข้อมูล"><span><i class="bi bi-bar-chart-line-fill"></i><strong>Data-driven</strong><small>บริหารด้วยข้อมูล</small></span><span><i class="bi bi-lightbulb-fill"></i><strong>Innovation</strong><small>สร้างสรรค์นวัตกรรม</small></span><span><i class="bi bi-people-fill"></i><strong>Service</strong><small>บริการด้วยความเข้าใจ</small></span></div>
                    </div>
                </div>

                <div class="responsibility-section">
                    <div class="text-center section-intro"><p class="section-kicker">{{ $aboutPage->responsibilities_eyebrow }}</p><h2>{{ $aboutPage->responsibilities_title }}</h2><p>{{ $aboutPage->responsibilities_description }}</p></div>
                    <div class="row g-4">
                        @foreach ($responsibilities as $responsibility)
                            <div class="col-md-6 col-xl-3"><article class="responsibility-card h-100"><span><i class="bi {{ $responsibility->icon }}"></i></span><h3>{{ $responsibility->title }}</h3><p>{{ $responsibility->description }}</p></article></div>
                        @endforeach
                    </div>
                </div>

                <section class="personnel-section" aria-labelledby="personnel-title">
                    <div class="text-center section-intro">
                        <p class="section-kicker">{{ $aboutPage->personnel_eyebrow }}</p>
                        <h2 id="personnel-title">{{ $aboutPage->personnel_title }}</h2>
                        <p>{{ $aboutPage->personnel_description }}</p>
                    </div>
                    <div class="row g-4">
                        @foreach ($personnel as $person)
                            <div class="col-sm-6 col-xl-3">
                                <article class="person-card person-card--{{ $person->color }} h-100">
                                    <div class="person-card__avatar" aria-hidden="true">@if ($person->photo_url)<img src="{{ $person->photo_url }}" alt="">@else<span>{{ $person->initials }}</span>@endif</div>
                                    <div class="person-card__body">
                                        <span class="person-card__unit">{{ $person->unit }}</span>
                                        @if ($person->is_head)<span class="person-card__head"><i class="bi bi-star-fill"></i> หัวหน้าหน่วยงาน</span>@endif
                                        <h3>{{ $person->name_th }}</h3>
                                        <p class="person-card__name-en">{{ $person->name_en }}</p>
                                        <p class="person-card__position">{{ $person->position_th }}<small>{{ $person->position_en }}</small></p>
                                        @if ($person->responsibilities)
                                            <div class="person-card__responsibilities"><strong><i class="bi bi-list-check"></i> ภาระงานที่รับผิดชอบ</strong><p>{!! $person->responsibilities_html !!}</p></div>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>
    </main>
</x-portal-layout>
