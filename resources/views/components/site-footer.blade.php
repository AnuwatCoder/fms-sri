<footer class="site-footer">
    <div class="container-fluid">
        <div class="row align-items-center gy-4">
            <div class="col-lg-4"><div class="footer-brand"><span class="brand-mark brand-mark--footer" aria-hidden="true">PSU</span><span><strong>คณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์</strong><small>Faculty of Management Sciences, Prince of Songkla University</small></span></div></div>
            <div class="col-lg-5 footer-division"><strong>งานแผนยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ</strong><small>Strategic Work, Revenue Management and Information Innovation Division</small></div>
            <div class="col-lg-3 footer-message"><p>“ร่วมสร้างคุณค่า เพื่อการพัฒนาอย่างยั่งยืน”</p><small>Creating Value for a Sustainable Future</small><i class="bi bi-leaf-fill" aria-hidden="true"></i><a class="footer-admin-link" href="{{ auth()->user()?->is_admin ? route('admin.dashboard') : route('admin.login') }}"><i class="bi bi-shield-lock" aria-hidden="true"></i> {{ auth()->user()?->is_admin ? 'ไปยังระบบหลังบ้าน' : 'เข้าสู่ระบบผู้ดูแล' }}</a></div>
        </div>
    </div>
</footer>
