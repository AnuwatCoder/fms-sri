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
                    <div class="personnel-chart">
                        @if ($personnelHead)
                            <div class="personnel-head">
                                <x-personnel-card :person="$personnelHead" featured />
                            </div>
                        @endif

                        @if ($personnelMembers->isNotEmpty())
                            <div class="row g-4 justify-content-center personnel-members">
                                @foreach ($personnelMembers as $person)
                                    <div class="col-sm-6 col-lg-3">
                                        <x-personnel-card :person="$person" class="h-100" />
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </section>
    </main>
</x-portal-layout>
