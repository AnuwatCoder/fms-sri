<?php

test('the portal home page renders its main sections', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSee('งานแผนยุทธศาสตร์ บริหารรายได้')
        ->assertSee('ระบบสารสนเทศของหน่วยงาน')
        ->assertSee('ระบบแผนยุทธศาสตร์')
        ->assertSee('ข่าวสารและประกาศ')
        ->assertSee('ปฏิทินกิจกรรม')
        ->assertSee('เอกสาร/ดาวน์โหลด');
});

test('the home route is named', function () {
    expect(route('home'))->toBe(url('/'));
});

test('the portal layout includes the page loading progress bar', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('data-page-progress', false)
        ->assertSee('role="progressbar"', false);
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

test('the about page displays division personnel', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('บุคลากรของหน่วยงาน')
        ->assertSee('Anuwat Pattanachian')
        ->assertSee('Computer Technical Officer');
});
