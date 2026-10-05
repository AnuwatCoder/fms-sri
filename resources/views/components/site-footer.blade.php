<footer class="site-footer">
    <div class="container-fluid">
        <div class="row align-items-start gy-4">
            <div class="col-md-6 col-xl-3"><a class="footer-brand" href="{{ route('home') }}" aria-label="หน้าหลัก คณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์"><img src="{{ asset('images/psu-fms-logo-th.png') }}" width="3616" height="800" alt="" loading="lazy"></a></div>
            <div class="col-md-6 col-xl-3 footer-division"><strong>งานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ</strong><small>Strategic Work, Revenue Management and Information Innovation Division</small></div>
            <div class="col-md-6 col-xl-3 footer-contact">
                <strong>ช่องทางการติดต่อ</strong>
                <address>
                    <a href="tel:+6674287900"><i class="bi bi-telephone-fill" aria-hidden="true"></i><span>0 7428 7900</span></a>
                    <a href="mailto:fms@psu.ac.th"><i class="bi bi-envelope-fill" aria-hidden="true"></i><span>fms@psu.ac.th</span></a>
                    <a href="{{ route('contact') }}" wire:navigate><i class="bi bi-geo-alt-fill" aria-hidden="true"></i><span>ที่อยู่และเวลาทำการ</span></a>
                </address>
            </div>
            <div class="col-md-6 col-xl-3 footer-message"><p>“ร่วมสร้างคุณค่า เพื่อการพัฒนาอย่างยั่งยืน”</p><small>Creating Value for a Sustainable Future</small><i class="bi bi-leaf-fill" aria-hidden="true"></i><a class="footer-admin-link" href="{{ auth()->user()?->is_admin ? route('admin.dashboard') : route('admin.login') }}"><i class="bi bi-shield-lock" aria-hidden="true"></i> {{ auth()->user()?->is_admin ? 'ไปยังระบบหลังบ้าน' : 'เข้าสู่ระบบผู้ดูแล' }}</a></div>
        </div>
    </div>
</footer>
