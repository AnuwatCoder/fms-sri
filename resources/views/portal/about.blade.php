<x-portal-layout title="เกี่ยวกับหน่วยงาน" description="ข้อมูล ภารกิจ และขอบเขตการดำเนินงานของงานแผนยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ">
    <main id="main-content">
        <x-page-hero title="เกี่ยวกับหน่วยงาน" eyebrow="ABOUT OUR DIVISION" description="ร่วมขับเคลื่อนคณะวิทยาการจัดการด้วยยุทธศาสตร์ ข้อมูล และนวัตกรรมที่สร้างคุณค่า" icon="bi-building" />

        <section class="subpage-content" aria-labelledby="about-title">
            <div class="container-xl">
                <div class="row g-5 align-items-center about-intro">
                    <div class="col-lg-6">
                        <p class="section-kicker">WHO WE ARE</p>
                        <h2 id="about-title">เชื่อมโยงแผนงาน ข้อมูล และเทคโนโลยี<br>สู่การบริหารที่มีประสิทธิภาพ</h2>
                        <p>งานแผนยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ เป็นหน่วยงานสนับสนุนภารกิจของคณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์ รับผิดชอบการวางแผนยุทธศาสตร์ การบริหารข้อมูลและรายได้ ตลอดจนการพัฒนาระบบสารสนเทศสำหรับองค์กร</p>
                        <p>เรามุ่งสร้างกระบวนการทำงานที่โปร่งใส เชื่อมโยง และใช้ข้อมูลประกอบการตัดสินใจ เพื่อให้ทุกส่วนงานสามารถขับเคลื่อนไปสู่เป้าหมายเดียวกันได้อย่างยั่งยืน</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-visual" role="img" aria-label="อาคารมหาวิทยาลัยและแนวคิดการบริหารด้วยข้อมูล"><span><i class="bi bi-bar-chart-line-fill"></i><strong>Data-driven</strong><small>บริหารด้วยข้อมูล</small></span><span><i class="bi bi-lightbulb-fill"></i><strong>Innovation</strong><small>สร้างสรรค์นวัตกรรม</small></span><span><i class="bi bi-people-fill"></i><strong>Service</strong><small>บริการด้วยความเข้าใจ</small></span></div>
                    </div>
                </div>

                <div class="responsibility-section">
                    <div class="text-center section-intro"><p class="section-kicker">OUR RESPONSIBILITIES</p><h2>ภารกิจหลักของหน่วยงาน</h2><p>สนับสนุนการดำเนินงานของคณะใน 4 มิติสำคัญ</p></div>
                    <div class="row g-4">
                        @foreach ([
                            ['bi-bullseye', 'วางแผนยุทธศาสตร์', 'จัดทำแผน ติดตามตัวชี้วัด และประเมินผลการดำเนินงานขององค์กร'],
                            ['bi-coin', 'บริหารรายได้', 'สนับสนุนการบริหารโครงการ รายได้ และการจัดสรรทรัพยากร'],
                            ['bi-database-fill', 'บริหารข้อมูล', 'พัฒนาฐานข้อมูลกลางและสารสนเทศสำหรับการตัดสินใจ'],
                            ['bi-display', 'นวัตกรรมสารสนเทศ', 'พัฒนาระบบดิจิทัลและให้บริการเทคโนโลยีแก่บุคลากร'],
                        ] as [$icon, $title, $description])
                            <div class="col-md-6 col-xl-3"><article class="responsibility-card h-100"><span><i class="bi {{ $icon }}"></i></span><h3>{{ $title }}</h3><p>{{ $description }}</p></article></div>
                        @endforeach
                    </div>
                </div>

                <section class="personnel-section" aria-labelledby="personnel-title">
                    <div class="text-center section-intro">
                        <p class="section-kicker">OUR PEOPLE</p>
                        <h2 id="personnel-title">บุคลากรของหน่วยงาน</h2>
                        <p>ทีมงานผู้สนับสนุนและขับเคลื่อนภารกิจของหน่วยงานในทุกมิติ</p>
                    </div>
                    <div class="row g-4">
                        @foreach ($personnel as $person)
                            <div class="col-sm-6 col-xl-3">
                                <article class="person-card person-card--{{ $person['color'] }} h-100">
                                    <div class="person-card__avatar" aria-hidden="true"><span>{{ $person['initials'] }}</span></div>
                                    <div class="person-card__body">
                                        <span class="person-card__unit">{{ $person['unit'] }}</span>
                                        <h3>{{ $person['name_th'] }}</h3>
                                        <p class="person-card__name-en">{{ $person['name_en'] }}</p>
                                        <p class="person-card__position">{{ $person['position_th'] }}<small>{{ $person['position_en'] }}</small></p>
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
