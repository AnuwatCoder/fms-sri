<?php

use App\Models\NewsItem;
use App\Models\Personnel;
use App\Models\PortalDocument;
use App\Models\PortalEvent;
use App\Models\PortalSystem;

test('the global search page searches all published portal content types', function () {
    $term = 'ศูนย์ดิจิทัลเฉพาะกิจ';

    PortalSystem::query()->create([
        'name_th' => 'ระบบทดสอบการค้นหากลาง',
        'description' => $term,
        'is_active' => true,
    ]);
    NewsItem::query()->create([
        'title' => "ข่าว {$term}",
        'published_at' => now()->subMinute(),
        'is_active' => true,
    ]);
    PortalDocument::query()->create([
        'name' => "เอกสาร {$term}",
        'fiscal_year' => 2570,
        'version' => '2.1',
        'published_at' => now()->subMinute(),
        'is_active' => true,
    ]);
    PortalEvent::query()->create([
        'title' => 'กิจกรรมทดสอบการค้นหากลาง',
        'description' => $term,
        'starts_at' => now()->addDay(),
        'is_active' => true,
    ]);
    Personnel::query()->create([
        'name_th' => 'บุคลากรทดสอบการค้นหากลาง',
        'unit' => $term,
        'is_active' => true,
    ]);

    $this->get(route('search.index', ['q' => $term]))
        ->assertOk()
        ->assertSee('พบ 5 รายการ')
        ->assertSee('ระบบทดสอบการค้นหากลาง')
        ->assertSee("ข่าว {$term}")
        ->assertSee("เอกสาร {$term}")
        ->assertSee('กิจกรรมทดสอบการค้นหากลาง')
        ->assertSee('บุคลากรทดสอบการค้นหากลาง')
        ->assertSee('ปีงบประมาณ 2570')
        ->assertSee('เวอร์ชัน 2.1');
});

test('global search excludes inactive and future-dated content', function () {
    $term = 'ข้อมูลที่ยังไม่เผยแพร่';

    PortalSystem::query()->create([
        'name_th' => $term,
        'is_active' => false,
    ]);
    NewsItem::query()->create([
        'title' => "ข่าว{$term}",
        'published_at' => now()->addDay(),
        'is_active' => true,
    ]);
    PortalDocument::query()->create([
        'name' => "เอกสาร{$term}",
        'published_at' => now()->addDay(),
        'is_active' => true,
    ]);
    Personnel::query()->create([
        'name_th' => "บุคลากร{$term}",
        'is_active' => false,
    ]);

    $this->get(route('search.index', ['q' => $term]))
        ->assertOk()
        ->assertSee("ไม่พบผลลัพธ์สำหรับ “{$term}”")
        ->assertDontSee("ข่าว{$term}")
        ->assertDontSee("เอกสาร{$term}")
        ->assertDontSee("บุคลากร{$term}");
});

test('global search validates the query length', function () {
    $this->get(route('search.index', ['q' => str_repeat('a', 101)]))
        ->assertSessionHasErrors('q');
});
