<x-portal-layout title="ค้นหา" description="ค้นหาระบบ ข่าวสาร เอกสาร กิจกรรม และบุคลากรภายในเว็บไซต์">
    <main id="main-content">
        <x-page-hero title="ค้นหาทั้งเว็บไซต์" eyebrow="SITE SEARCH" description="ค้นหาระบบ ข่าวสาร เอกสาร กิจกรรม และบุคลากรได้จากจุดเดียว" icon="bi-search" />

        <section class="subpage-content" aria-labelledby="search-results-title">
            <div class="container-fluid">
                <form class="portal-search global-search-form" role="search" action="{{ route('search.index') }}" method="get">
                    <label class="visually-hidden" for="globalSearch">คำค้นหา</label>
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <input id="globalSearch" name="q" type="search" value="{{ $query }}" placeholder="พิมพ์ชื่อระบบ ข่าว เอกสาร กิจกรรม หรือบุคลากร..." autocomplete="off" autofocus data-global-search>
                    <button type="submit" aria-label="ค้นหา"><i class="bi bi-search" aria-hidden="true"></i></button>
                </form>

                @if ($query === '')
                    <div class="search-empty-state" role="status">
                        <i class="bi bi-search" aria-hidden="true"></i>
                        <h2 id="search-results-title">เริ่มต้นค้นหาข้อมูล</h2>
                        <p>กรอกคำที่ต้องการค้นหาจากข้อมูลที่เผยแพร่บนเว็บไซต์</p>
                    </div>
                @elseif ($resultCount === 0)
                    <div class="search-empty-state" role="status">
                        <i class="bi bi-search-heart" aria-hidden="true"></i>
                        <h2 id="search-results-title">ไม่พบผลลัพธ์สำหรับ “{{ $query }}”</h2>
                        <p>ลองใช้คำค้นหาที่สั้นลง หรือตรวจสอบการสะกดอีกครั้ง</p>
                    </div>
                @else
                    <div class="search-summary">
                        <div><p class="section-kicker">SEARCH RESULTS</p><h2 id="search-results-title">ผลการค้นหา “{{ $query }}”</h2></div>
                        <span>พบ {{ $resultCount }} รายการ</span>
                    </div>

                    <div class="search-sections">
                        @if ($results['systems']->isNotEmpty())
                            <section class="search-section" aria-labelledby="search-systems-title">
                                <h3 id="search-systems-title"><i class="bi bi-grid-fill"></i> ระบบสารสนเทศ <span>{{ $results['systems']->count() }}</span></h3>
                                <div class="search-result-list">
                                    @foreach ($results['systems'] as $system)
                                        <a class="search-result" href="{{ $system->url && $system->url !== '#' ? $system->url : route('systems.index', ['q' => $query]) }}">
                                            <span class="search-result__icon search-result__icon--{{ $system->color }}"><i class="bi {{ $system->icon }}"></i></span>
                                            <span class="search-result__content"><strong>{{ $system->name_th }}</strong><small>{{ $system->name_en }}@if ($system->category) · {{ $system->category }}@endif</small><span>{{ $system->description }}</span></span>
                                            <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        @if ($results['news']->isNotEmpty())
                            <section class="search-section" aria-labelledby="search-news-title">
                                <h3 id="search-news-title"><i class="bi bi-newspaper"></i> ข่าวสารและประกาศ <span>{{ $results['news']->count() }}</span></h3>
                                <div class="search-result-list">
                                    @foreach ($results['news'] as $news)
                                        <a class="search-result" href="{{ route('news.show', $news) }}">
                                            <span class="search-result__icon"><i class="bi bi-megaphone-fill"></i></span>
                                            <span class="search-result__content"><strong>{{ $news->title }}</strong><small>{{ $news->category }} · {{ $news->display_date }}</small><span>{{ $news->description }}</span></span>
                                            <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        @if ($results['documents']->isNotEmpty())
                            <section class="search-section" aria-labelledby="search-documents-title">
                                <h3 id="search-documents-title"><i class="bi bi-file-earmark-text-fill"></i> เอกสาร/ดาวน์โหลด <span>{{ $results['documents']->count() }}</span></h3>
                                <div class="search-result-list">
                                    @foreach ($results['documents'] as $document)
                                        <a class="search-result" href="{{ $document->download_url }}">
                                            <span class="search-result__icon search-result__icon--{{ $document->color }}"><i class="bi {{ $document->icon }}"></i></span>
                                            <span class="search-result__content"><strong>{{ $document->name }}</strong><small>{{ $document->category }}@if ($document->fiscal_year) · ปีงบประมาณ {{ $document->fiscal_year }}@endif @if ($document->version) · เวอร์ชัน {{ $document->version }}@endif</small><span>{{ $document->description }}</span></span>
                                            <i class="bi bi-download" aria-hidden="true"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        @if ($results['events']->isNotEmpty())
                            <section class="search-section" aria-labelledby="search-events-title">
                                <h3 id="search-events-title"><i class="bi bi-calendar-event-fill"></i> กิจกรรม <span>{{ $results['events']->count() }}</span></h3>
                                <div class="search-result-list">
                                    @foreach ($results['events'] as $event)
                                        <a class="search-result" href="{{ $event->url && $event->url !== '#' ? $event->url : route('home').'#events' }}">
                                            <span class="search-result__icon"><i class="bi bi-calendar3"></i></span>
                                            <span class="search-result__content"><strong>{{ $event->title }}</strong><small>{{ $event->display_day }} {{ $event->display_month }} · {{ $event->display_time }}@if ($event->place) · {{ $event->place }}@endif</small><span>{{ $event->description }}</span></span>
                                            <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        @if ($results['personnel']->isNotEmpty())
                            <section class="search-section" aria-labelledby="search-personnel-title">
                                <h3 id="search-personnel-title"><i class="bi bi-people-fill"></i> บุคลากร <span>{{ $results['personnel']->count() }}</span></h3>
                                <div class="search-result-list">
                                    @foreach ($results['personnel'] as $person)
                                        <a class="search-result" href="{{ route('about').'#personnel-title' }}">
                                            <span class="search-result__icon"><i class="bi bi-person-fill"></i></span>
                                            <span class="search-result__content"><strong>{{ $person->name_th }}</strong><small>{{ $person->position_th }}@if ($person->unit) · {{ $person->unit }}@endif</small><span>{{ $person->responsibilities_text }}</span></span>
                                            <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </main>
</x-portal-layout>
