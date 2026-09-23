<div class="contact-form-card">
    <div class="mb-4"><p class="section-kicker">SEND A MESSAGE</p><h2>ส่งข้อความถึงเรา</h2><p>กรอกข้อมูลด้านล่าง ทีมงานจะตรวจสอบและติดต่อกลับโดยเร็วที่สุด</p></div>

    @if ($sent)
        <div class="alert alert-success contact-success" role="status">
            <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
            <div><strong>ส่งข้อความเรียบร้อยแล้ว</strong><p class="mb-0">ขอบคุณที่ติดต่อเรา ทีมงานจะติดต่อกลับโดยเร็วที่สุด</p></div>
        </div>
    @endif

    <form wire:submit="submit" novalidate>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="contactName">ชื่อ-นามสกุล</label>
                <input class="form-control @error('name') is-invalid @enderror" id="contactName" type="text" wire:model.blur="name">
                @error('name') <div class="invalid-feedback">กรุณากรอกชื่อ-นามสกุล</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="contactEmail">อีเมล</label>
                <input class="form-control @error('email') is-invalid @enderror" id="contactEmail" type="email" wire:model.blur="email">
                @error('email') <div class="invalid-feedback">กรุณากรอกอีเมลที่ถูกต้อง</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label" for="contactSubject">หัวข้อ</label>
                <input class="form-control @error('subject') is-invalid @enderror" id="contactSubject" type="text" wire:model.blur="subject">
                @error('subject') <div class="invalid-feedback">กรุณากรอกหัวข้อ</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label" for="contactMessage">ข้อความ</label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="contactMessage" rows="6" wire:model.blur="message"></textarea>
                @error('message') <div class="invalid-feedback">กรุณากรอกข้อความ</div> @enderror
            </div>
            <div class="col-12">
                <button class="btn contact-submit" type="submit" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">ส่งข้อความ <i class="bi bi-send-fill"></i></span>
                    <span wire:loading wire:target="submit"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> กำลังส่ง...</span>
                </button>
            </div>
        </div>
    </form>
</div>
