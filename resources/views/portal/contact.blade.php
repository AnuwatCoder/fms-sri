<x-portal-layout title="ติดต่อเรา" description="ช่องทางติดต่อ งานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ คณะวิทยาการจัดการ">
    <main id="main-content">
        <x-page-hero title="ติดต่อเรา" eyebrow="CONTACT US" description="สอบถามข้อมูล ขอรับบริการ หรือแจ้งข้อเสนอแนะ ทีมงานพร้อมให้ความช่วยเหลือ" icon="bi-geo-alt-fill" />

        <section class="subpage-content" aria-labelledby="contact-title">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-lg-8 col-xl-7 mx-auto">
                        <div class="contact-panel h-100">
                            <p class="section-kicker">GET IN TOUCH</p><h2 id="contact-title">{{ $contactSetting->heading }}</h2>@if ($contactSetting->description)<p class="contact-panel__lead">{{ $contactSetting->description }}</p>@endif
                            <address>
                                <div class="contact-method"><span><i class="bi bi-geo-alt-fill"></i></span><div><strong>ที่อยู่</strong><p>{!! nl2br(e($contactSetting->address)) !!}</p></div></div>
                                <div class="contact-method"><span><i class="bi bi-telephone-fill"></i></span><div><strong>โทรศัพท์</strong><p><a href="tel:{{ $contactSetting->phone_uri }}">{{ $contactSetting->phone }}</a></p></div></div>
                                <div class="contact-method"><span><i class="bi bi-envelope-fill"></i></span><div><strong>อีเมล</strong><p><a href="mailto:{{ $contactSetting->email }}">{{ $contactSetting->email }}</a></p></div></div>
                                <div class="contact-method"><span><i class="bi bi-clock-fill"></i></span><div><strong>เวลาทำการ</strong><p>{{ $contactSetting->office_hours }}@if ($contactSetting->office_hours_note)<br><small>{{ $contactSetting->office_hours_note }}</small>@endif</p></div></div>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-portal-layout>
