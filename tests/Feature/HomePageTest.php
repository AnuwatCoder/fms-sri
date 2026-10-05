<?php

use App\Models\NewsItem;

test('the portal home page renders its main sections', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSee('งานยุทธศาสตร์ บริหารรายได้')
        ->assertSee('ระบบสารสนเทศของหน่วยงาน')
        ->assertSee('ระบบแผนยุทธศาสตร์')
        ->assertSee('ข่าวสารและประกาศ')
        ->assertSee('ปฏิทินกิจกรรม')
        ->assertSee('เอกสาร/ดาวน์โหลด');
});

test('the home route is named', function () {
    expect(route('home'))->toBe(url('/'));
});

test('the home page identifies when no news is available', function () {
    NewsItem::query()->delete();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('ยังไม่มีข่าวสารและประกาศในขณะนี้')
        ->assertSee('role="status"', false);
});

test('the portal layout includes the page loading progress bar', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('data-page-progress', false)
        ->assertSee('role="progressbar"', false);
});

test('the portal header and footer use the faculty logo', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee(asset('images/psu-fms-logo-th.png'), false)
        ->assertSee('class="brand-logo"', false)
        ->assertSee('class="footer-brand"', false);

    expect(public_path('images/psu-fms-logo-th.png'))->toBeFile();
});

test('the footer provides direct contact channels', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('ช่องทางการติดต่อ')
        ->assertSee('href="tel:+6674287900"', false)
        ->assertSee('href="mailto:fms@psu.ac.th"', false)
        ->assertSee(route('contact'), false);
});

test('portal subpages render successfully', function (string $route, string $heading) {
    $this->get(route($route))
        ->assertOk()
        ->assertSee($heading)
        ->assertSee('คณะวิทยาการจัดการ');
})->with([
    'systems' => ['systems.index', 'ระบบสารสนเทศ'],
    'news' => ['news.index', 'ข่าวสารและประกาศ'],
    'documents' => ['documents.index', 'เอกสาร/ดาวน์โหลด'],
    'about' => ['about', 'เกี่ยวกับหน่วยงาน'],
    'contact' => ['contact', 'ติดต่อเรา'],
]);

test('the primary navigation links to real portal routes', function () {
    $this->get(route('home'))
        ->assertSee(route('systems.index'))
        ->assertSee(route('news.index'))
        ->assertSee(route('documents.index'))
        ->assertSee(route('about'))
        ->assertSee(route('contact'));
});

test('the header and home search form use the global search page', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee(route('search.index'), false)
        ->assertSee('ค้นหาข้อมูลทั้งเว็บไซต์...');

    $this->get(route('search.index'))
        ->assertOk()
        ->assertSee('ค้นหาทั้งเว็บไซต์')
        ->assertSee('เริ่มต้นค้นหาข้อมูล');
});

test('strategic information shortcuts open their matching document categories', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee(route('documents.index', ['category' => 'แผนและยุทธศาสตร์']), false)
        ->assertSee(route('documents.index', ['category' => 'งบประมาณ']), false)
        ->assertSee(route('documents.index', ['category' => 'ตัวชี้วัดและผลการดำเนินงาน']), false);
});

test('the administration entry is in the footer instead of the site header', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('เข้าสู่ระบบผู้ดูแล')
        ->assertSee(route('admin.login'))
        ->assertDontSee('bi-bell-fill', false)
        ->assertDontSee('profile-menu', false);
});

test('the contact page shows direct contact channels without a message form', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('ช่องทางติดต่อหน่วยงาน')
        ->assertSee('fms@psu.ac.th')
        ->assertDontSee('ส่งข้อความถึงเรา')
        ->assertDontSee('<form', false);
});

test('the about page displays division personnel', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('บุคลากรของหน่วยงาน')
        ->assertSee('personnel-head', false)
        ->assertSee('personnel-members', false)
        ->assertSee('col-sm-6 col-lg-3', false)
        ->assertSee('ภาระงานที่รับผิดชอบ')
        ->assertSee('data-bs-toggle="collapse"', false)
        ->assertSee('aria-expanded="false"', false)
        ->assertSee('person-card__toggle-collapsed', false)
        ->assertSeeInOrder(['ดร.กมลชนก ศรีสุข', 'นางสาวพิมพ์พิศา วัฒนกุล'])
        ->assertSee('Anuwat Pattanachian')
        ->assertSee('Computer Technical Officer');
});
