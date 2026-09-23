<x-portal-layout title="หน้าหลัก">
    <main id="main-content">
        <section class="hero" id="about" aria-labelledby="hero-title">
            <div class="container-xl position-relative hero__content">
                <div class="row align-items-center g-5">
                    <div class="col-lg-8">
                        <p class="hero__eyebrow">STRATEGIC WORK, REVENUE MANAGEMENT AND INFORMATION INNOVATION DIVISION</p>
                        <h1 id="hero-title">งานแผนยุทธศาสตร์ บริหารรายได้<br class="d-none d-md-block"> และนวัตกรรมสารสนเทศ</h1>
                        <span class="hero__rule" aria-hidden="true"></span>
                        <p class="hero__lead">ขับเคลื่อนองค์กรด้วยข้อมูล นวัตกรรม และการบริหารเชิงยุทธศาสตร์</p>
                        <p class="hero__lead-en">Driving the organization with data, innovation, and strategic management</p>
                        <div class="mission-list" aria-label="พันธกิจ">
                            <div class="mission-item"><span><i class="bi bi-bullseye"></i></span><p><strong>วางแผนยุทธศาสตร์</strong><small>Strategic Planning</small></p></div>
                            <div class="mission-item"><span><i class="bi bi-coin"></i></span><p><strong>บริหารรายได้</strong><small>Revenue Management</small></p></div>
                            <div class="mission-item"><span><i class="bi bi-display"></i></span><p><strong>พัฒนาระบบสารสนเทศ</strong><small>Information Innovation</small></p></div>
                            <div class="mission-item"><span><i class="bi bi-people-fill"></i></span><p><strong>สนับสนุนการปฏิบัติงาน</strong><small>Service &amp; Support</small></p></div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block">
                        <blockquote class="hero-quote mb-0"><p>“ข้อมูลที่ชัดเจน<br>นำไปสู่การตัดสินใจที่ดีกว่า<br>เพื่ออนาคตที่ยั่งยืน”</p><footer>Better Data<br>for a Smarter Tomorrow</footer></blockquote>
                    </div>
                </div>
            </div>
        </section>

        <section class="quick-nav bg-white" aria-label="เมนูทางลัด">
            <div class="container-xl">
                <div class="row g-3 align-items-center">
                    <div class="col-xl-8">
                        <nav class="quick-links" aria-label="บริการที่ใช้บ่อย">
                            <a href="{{ route('systems.index') }}"><i class="bi bi-grid-fill"></i><span>ระบบสารสนเทศทั้งหมด</span></a>
                            <a href="{{ route('documents.index') }}"><i class="bi bi-journal-bookmark-fill"></i><span>คู่มือการใช้งาน</span></a>
                            <a href="{{ route('documents.index') }}"><i class="bi bi-file-earmark-text-fill"></i><span>แบบฟอร์ม</span></a>
                            <a href="{{ route('systems.index') }}"><i class="bi bi-headset"></i><span>ขอรับบริการ</span></a>
                            <a href="{{ route('contact') }}"><i class="bi bi-envelope"></i><span>ติดต่อเรา</span></a>
                        </nav>
                    </div>
                    <div class="col-xl-4">
                        <form class="portal-search" role="search" action="{{ route('systems.index') }}" method="get">
                            <label class="visually-hidden" for="portalSearch">ค้นหาระบบหรือบริการ</label>
                            <i class="bi bi-search" aria-hidden="true"></i>
                            <input id="portalSearch" name="q" type="search" placeholder="ค้นหาระบบหรือบริการ..." autocomplete="off">
                            <button type="submit" aria-label="ค้นหา"><i class="bi bi-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="portal-content">
            <div class="container-xl">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-9">
                        <section class="content-section" id="systems" aria-labelledby="systems-title">
                            <div class="section-heading">
                                <div><div class="d-flex align-items-center gap-3"><span class="section-heading__icon"><i class="bi bi-display"></i></span><h2 id="systems-title">ระบบสารสนเทศของหน่วยงาน</h2></div><p>ระบบสารสนเทศเพื่อการปฏิบัติงานภายในหน่วยงาน</p></div>
                                <a href="{{ route('systems.index') }}">ดูทั้งหมด <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <livewire:application-directory compact />
                        </section>

                        <section class="content-section" id="news" aria-labelledby="news-title">
                            <div class="section-heading">
                                <div class="d-flex align-items-center gap-3"><span class="section-heading__icon"><i class="bi bi-megaphone-fill"></i></span><h2 id="news-title">ข่าวสารและประกาศ</h2></div>
                                <a href="{{ route('news.index') }}">ดูทั้งหมด <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="row g-3">
                                @foreach ($newsItems as $news)
                                    <div class="col-md-4">
                                        <article class="news-card h-100">
                                            <img src="{{ asset($news['image']) }}" alt="" loading="lazy">
                                            <div class="news-card__body"><time>{{ $news['date'] }}</time><h3>{{ $news['title'] }}</h3><p>{{ $news['description'] }}</p><a href="{{ $news['url'] }}" aria-label="อ่านเพิ่มเติม: {{ $news['title'] }}">อ่านเพิ่มเติม <i class="bi bi-arrow-right"></i></a></div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>

                    <aside class="col-lg-3 portal-sidebar" aria-label="ข้อมูลสำหรับผู้ใช้">
                        <section class="sidebar-card profile-card" id="profile" aria-labelledby="profile-name">
                            <div class="d-flex align-items-center gap-3">
                                <span class="avatar" aria-hidden="true">AP</span>
                                <div class="min-w-0 flex-grow-1"><h2 id="profile-name">{{ auth()->user()?->name ?? 'Anuwat Pattanachian' }}</h2><p>Computer Technical Officer</p><small>งานแผนยุทธศาสตร์ฯ</small></div>
                                <i class="bi bi-chevron-right text-primary" aria-hidden="true"></i>
                            </div>
                            <div class="profile-stats"><div><i class="bi bi-grid-fill"></i><strong>8</strong><span>ระบบที่ใช้งาน</span></div><div><i class="bi bi-star-fill"></i><strong data-favorite-count>3</strong><span>รายการโปรด</span></div><div><i class="bi bi-clock"></i><strong>12</strong><span>ใช้งานล่าสุด</span></div></div>
                        </section>

                        <section class="sidebar-card" aria-labelledby="calendar-title">
                            <div class="sidebar-heading"><h2 id="calendar-title"><i class="bi bi-calendar-event-fill"></i> ปฏิทินกิจกรรม</h2><a href="{{ route('news.index') }}">ดูทั้งหมด <i class="bi bi-arrow-right"></i></a></div>
                            <div class="event-list" id="calendar">
                                @foreach ($events as $event)
                                    <article class="event-item event-item--{{ $event['color'] }}"><time datetime="{{ $event['date'] }}"><strong>{{ $event['day'] }}</strong><span>{{ $event['month'] }}</span></time><div><h3>{{ $event['title'] }}</h3><p>{{ $event['time'] }} <span>•</span> {{ $event['place'] }}</p></div></article>
                                @endforeach
                            </div>
                        </section>

                        <section class="sidebar-card" id="documents" aria-labelledby="documents-title">
                            <div class="sidebar-heading"><h2 id="documents-title"><i class="bi bi-folder-fill"></i> เอกสาร/ดาวน์โหลด</h2><a href="{{ route('documents.index') }}">ดูทั้งหมด <i class="bi bi-arrow-right"></i></a></div>
                            <div class="document-list">
                                @foreach ($documents as $document)
                                    <a href="{{ $document['url'] }}" class="document-item"><i class="bi {{ $document['icon'] }} text-{{ $document['color'] }}" aria-hidden="true"></i><span>{{ $document['name'] }} <small>({{ $document['type'] }})</small></span></a>
                                @endforeach
                            </div>
                        </section>
                    </aside>
                </div>
            </div>
        </div>
    </main>
</x-portal-layout>
