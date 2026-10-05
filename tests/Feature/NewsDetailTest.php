<?php

use App\Models\NewsItem;

test('a published news item has an internal detail page', function () {
    $newsItem = NewsItem::published()->firstOrFail();

    $this->get(route('news.show', $newsItem))
        ->assertOk()
        ->assertSee($newsItem->title)
        ->assertSee($newsItem->description)
        ->assertSee($newsItem->image_url, false)
        ->assertSee('property="og:type" content="article"', false)
        ->assertSee('property="og:image" content="'.$newsItem->image_url.'"', false)
        ->assertSee(route('news.index'), false);
});

test('news cards link to their internal detail pages', function () {
    $newsItem = NewsItem::published()->firstOrFail();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee(route('news.show', $newsItem), false);

    $this->get(route('news.index'))
        ->assertOk()
        ->assertSee(route('news.show', $newsItem), false);
});

test('inactive and future news detail pages are not public', function () {
    $inactiveNews = NewsItem::query()->create([
        'title' => 'ข่าวที่ซ่อนจากเว็บไซต์',
        'published_at' => now()->subMinute(),
        'is_active' => false,
    ]);
    $futureNews = NewsItem::query()->create([
        'title' => 'ข่าวที่ยังไม่ถึงเวลาเผยแพร่',
        'published_at' => now()->addDay(),
        'is_active' => true,
    ]);

    $this->get(route('news.show', $inactiveNews))->assertNotFound();
    $this->get(route('news.show', $futureNews))->assertNotFound();
});

test('a news detail page can link to an external source', function () {
    $newsItem = NewsItem::query()->create([
        'title' => 'ข่าวที่มีแหล่งข้อมูลเพิ่มเติม',
        'description' => 'รายละเอียดข่าวสำหรับทดสอบ',
        'url' => 'https://example.com/news',
        'published_at' => now()->subMinute(),
        'is_active' => true,
    ]);

    $this->get(route('news.show', $newsItem))
        ->assertOk()
        ->assertSee('ดูข้อมูลเพิ่มเติม')
        ->assertSee('https://example.com/news', false);
});
