<?php

use App\Models\SeoSetting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('public pages render favicon and managed seo tags', function () {
    $seoSetting = SeoSetting::query()->firstOrFail();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('<title>'.$seoSetting->default_title.'</title>', false)
        ->assertSee('rel="icon" type="image/png" href="'.asset('images/favicon.png').'"', false)
        ->assertSee('name="description" content="'.$seoSetting->default_description.'"', false)
        ->assertSee('name="robots" content="index, follow"', false)
        ->assertSee('rel="canonical" href="'.route('home').'"', false)
        ->assertSee('property="og:title"', false)
        ->assertSee('property="og:image"', false)
        ->assertSee('name="twitter:card" content="summary_large_image"', false)
        ->assertSee('type="application/ld+json"', false);

    expect(public_path('images/favicon.png'))->toBeFile();
});

test('seo administration requires an administrator', function () {
    $this->get(route('admin.seo.edit'))->assertRedirect(route('admin.login'));

    $this->actingAs(User::factory()->create(['is_admin' => false]))
        ->get(route('admin.seo.edit'))
        ->assertForbidden();
});

test('an administrator can manage seo tags and the social sharing image', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)->put(route('admin.seo.update'), seoPayload([
        'site_name' => 'เว็บไซต์ทดสอบ SEO',
        'default_title' => 'หัวข้อหลักสำหรับทดสอบ SEO',
        'default_description' => 'คำอธิบายเว็บไซต์สำหรับทดสอบการแสดงผลบน Search Engine',
        'twitter_site' => '@fmstest',
        'google_site_verification' => 'verification-code',
        'robots_index' => '1',
        'robots_follow' => null,
        'og_image' => UploadedFile::fake()->image('social-preview.jpg', 1200, 630),
    ]))->assertRedirect(route('admin.seo.edit'));

    $seoSetting = SeoSetting::query()->firstOrFail();
    $firstImagePath = $seoSetting->og_image_path;

    expect($seoSetting->site_name)->toBe('เว็บไซต์ทดสอบ SEO')
        ->and($seoSetting->robots_index)->toBeTrue()
        ->and($seoSetting->robots_follow)->toBeFalse();
    Storage::disk('public')->assertExists($firstImagePath);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('<title>หัวข้อหลักสำหรับทดสอบ SEO</title>', false)
        ->assertSee('name="robots" content="index, nofollow"', false)
        ->assertSee('name="google-site-verification" content="verification-code"', false)
        ->assertSee('name="twitter:site" content="@fmstest"', false)
        ->assertSee(Storage::disk('public')->url($firstImagePath), false);

    $this->actingAs($admin)->put(route('admin.seo.update'), seoPayload([
        'og_image' => UploadedFile::fake()->image('replacement.png', 1200, 630),
    ]))->assertRedirect(route('admin.seo.edit'));

    $replacementImagePath = $seoSetting->fresh()->og_image_path;
    expect($replacementImagePath)->not->toBe($firstImagePath);
    Storage::disk('public')->assertMissing($firstImagePath);
    Storage::disk('public')->assertExists($replacementImagePath);

    $this->actingAs($admin)->put(route('admin.seo.update'), seoPayload([
        'remove_og_image' => '1',
    ]))->assertRedirect(route('admin.seo.edit'));

    expect($seoSetting->fresh()->og_image_path)->toBeNull();
    Storage::disk('public')->assertMissing($replacementImagePath);
});

test('seo settings validate recommended metadata limits', function () {
    $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->put(route('admin.seo.update'), seoPayload([
            'default_title' => str_repeat('a', 71),
            'default_description' => str_repeat('b', 161),
            'twitter_site' => 'invalid account',
        ]))
        ->assertSessionHasErrors(['default_title', 'default_description', 'twitter_site']);
});

/** @param array<string, mixed> $overrides */
function seoPayload(array $overrides = []): array
{
    return array_replace([
        'site_name' => 'FMS Portal',
        'default_title' => 'งานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ',
        'default_description' => 'ศูนย์รวมข้อมูลและบริการของงานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ',
        'keywords' => 'ยุทธศาสตร์, ระบบสารสนเทศ',
        'author' => 'คณะวิทยาการจัดการ',
        'twitter_site' => null,
        'google_site_verification' => null,
        'robots_index' => '1',
        'robots_follow' => '1',
    ], $overrides);
}
