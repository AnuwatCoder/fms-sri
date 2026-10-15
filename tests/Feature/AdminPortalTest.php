<?php

use App\Models\AboutPage;
use App\Models\AboutResponsibility;
use App\Models\ContactSetting;
use App\Models\NewsItem;
use App\Models\Personnel;
use App\Models\PortalDocument;
use App\Models\PortalEvent;
use App\Models\PortalSystem;
use App\Models\User;
use Database\Seeders\AboutContentSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use SocialiteProviders\Authentik\Provider as AuthentikProvider;

function adminUser(): User
{
    return User::factory()->create(['is_admin' => true]);
}

test('guests cannot access the administration area', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.login'));
});

test('non admin users cannot access the administration area', function () {
    $this->actingAs(User::factory()->create(['is_admin' => false]))
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('the authentik socialite provider is registered', function () {
    expect(Socialite::driver('authentik'))->toBeInstanceOf(AuthentikProvider::class);
});

test('the legacy authentik callback URL remains available', function () {
    expect(route('admin.login.callback'))->toBe(url('/auth/authentik/callback'))
        ->and(route('admin.login.callback.legacy'))->toBe(url('/auth/callback'));
});

test('the administration login redirects to authentik', function () {
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('redirect')
        ->once()
        ->andReturn(redirect()->away('https://psusso.example.test/application/o/authorize/'));
    Socialite::shouldReceive('driver')
        ->once()
        ->with('authentik')
        ->andReturn($provider);

    $this->get(route('admin.login.redirect'))
        ->assertRedirect('https://psusso.example.test/application/o/authorize/');
});

test('an administrator can authenticate through authentik', function () {
    $admin = User::factory()->create([
        'is_admin' => true,
    ]);
    $authentikUser = (new SocialiteUser)->map([
        'id' => 'authentik-user-id',
        'name' => $admin->name,
        'email' => strtoupper($admin->email),
    ]);
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('user')->once()->andReturn($authentikUser);
    Socialite::shouldReceive('driver')
        ->once()
        ->with('authentik')
        ->andReturn($provider);

    $this->get(route('admin.login.callback'))
        ->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($admin);

    $this->post(route('admin.logout'))
        ->assertRedirect(route('admin.login'));

    $this->assertGuest();
});

test('authentik users without administrator access are rejected', function () {
    $user = User::factory()->create([
        'is_admin' => false,
    ]);
    $authentikUser = (new SocialiteUser)->map([
        'id' => 'non-admin-authentik-user-id',
        'name' => $user->name,
        'email' => $user->email,
    ]);
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('user')->once()->andReturn($authentikUser);
    Socialite::shouldReceive('driver')
        ->once()
        ->with('authentik')
        ->andReturn($provider);

    $this->get(route('admin.login.callback'))
        ->assertRedirect(route('admin.login'))
        ->assertSessionHasErrors('authentik');

    $this->assertGuest();
});

test('an authentik callback failure returns to the login screen', function () {
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('user')
        ->once()
        ->andThrow(new RuntimeException('OAuth callback failed'));
    Socialite::shouldReceive('driver')
        ->once()
        ->with('authentik')
        ->andReturn($provider);

    $this->get(route('admin.login.callback'))
        ->assertRedirect(route('admin.login'))
        ->assertSessionHasErrors('authentik');

    $this->assertGuest();
});

test('the login and all administration screens render successfully', function () {
    $this->get(route('admin.login'))
        ->assertOk()
        ->assertSee('เข้าสู่ระบบหลังบ้าน')
        ->assertSee('เข้าสู่ระบบด้วย PSU SSO')
        ->assertSee(route('admin.login.redirect'), false)
        ->assertDontSee('type="password"', false);

    $admin = adminUser();
    $system = PortalSystem::query()->firstOrFail();
    $news = NewsItem::query()->firstOrFail();
    $event = PortalEvent::query()->firstOrFail();
    $document = PortalDocument::query()->firstOrFail();
    $responsibility = AboutResponsibility::query()->firstOrFail();
    $person = Personnel::query()->firstOrFail();

    $pages = [
        route('admin.dashboard') => 'ภาพรวมระบบ',
        route('admin.systems.index') => 'ระบบสารสนเทศ',
        route('admin.systems.create') => 'เพิ่มระบบสารสนเทศ',
        route('admin.systems.edit', $system) => 'แก้ไขระบบสารสนเทศ',
        route('admin.news.index') => 'ข่าวและประกาศ',
        route('admin.news.create') => 'เพิ่มข่าว/ประกาศ',
        route('admin.news.edit', $news) => 'แก้ไขข่าว/ประกาศ',
        route('admin.events.index') => 'ปฏิทินกิจกรรม',
        route('admin.events.create') => 'เพิ่มกิจกรรม',
        route('admin.events.edit', $event) => 'แก้ไขกิจกรรม',
        route('admin.documents.index') => 'เอกสารดาวน์โหลด',
        route('admin.documents.create') => 'เพิ่มเอกสาร',
        route('admin.documents.edit', $document) => 'แก้ไขเอกสาร',
        route('admin.contact.edit') => 'ช่องทางการติดต่อหน่วยงาน',
        route('admin.seo.edit') => 'ตั้งค่า SEO',
        route('admin.about.edit') => 'เกี่ยวกับหน่วยงาน',
        route('admin.about.responsibilities.index') => 'ภารกิจหลักของหน่วยงาน',
        route('admin.about.responsibilities.create') => 'เพิ่มภารกิจ',
        route('admin.about.responsibilities.edit', $responsibility) => 'แก้ไขภารกิจ',
        route('admin.about.personnel.index') => 'บุคลากรของหน่วยงาน',
        route('admin.about.personnel.create') => 'เพิ่มบุคลากร',
        route('admin.about.personnel.edit', $person) => 'แก้ไขบุคลากร',
    ];

    foreach ($pages as $url => $heading) {
        $this->actingAs($admin)->get($url)->assertOk()->assertSee($heading);
    }
});

test('only administrators can manage contact settings', function () {
    $this->get(route('admin.contact.edit'))
        ->assertRedirect(route('admin.login'));

    $this->actingAs(User::factory()->create(['is_admin' => false]))
        ->get(route('admin.contact.edit'))
        ->assertForbidden();
});

test('an administrator can update the contact channels shown on the portal', function () {
    $payload = [
        'heading' => 'ติดต่อทีมงานของเรา',
        'description' => 'พร้อมให้บริการและประสานงานในวันทำการ',
        'address' => "อาคารบริหาร ชั้น 2\nมหาวิทยาลัยสงขลานครินทร์",
        'phone' => '0 7428 7999',
        'email' => 'contact@example.test',
        'office_hours' => 'จันทร์ - ศุกร์ เวลา 09:00 - 16:00 น.',
        'office_hours_note' => 'หยุดวันหยุดนักขัตฤกษ์',
    ];

    $this->actingAs(adminUser())
        ->put(route('admin.contact.update'), $payload)
        ->assertRedirect(route('admin.contact.edit'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('contact_settings', $payload);

    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('ติดต่อทีมงานของเรา')
        ->assertSee('อาคารบริหาร ชั้น 2<br />', false)
        ->assertSee('href="tel:+6674287999"', false)
        ->assertSee('href="mailto:contact@example.test"', false)
        ->assertSee('หยุดวันหยุดนักขัตฤกษ์');
});

test('contact settings require valid contact details', function () {
    $contactSetting = ContactSetting::query()->firstOrFail();

    $this->actingAs(adminUser())
        ->put(route('admin.contact.update'), [
            'heading' => '',
            'description' => $contactSetting->description,
            'address' => '',
            'phone' => 'หมายเลขไม่ถูกต้อง',
            'email' => 'invalid-email',
            'office_hours' => '',
            'office_hours_note' => $contactSetting->office_hours_note,
        ])
        ->assertSessionHasErrors(['heading', 'address', 'phone', 'email', 'office_hours']);

    expect($contactSetting->fresh()->phone)->toBe('0 7428 7900');
});

test('an administrator can create update and delete a portal system', function () {
    $this->actingAs(adminUser())
        ->post(route('admin.systems.store'), [
            'name_th' => 'ระบบทดสอบ',
            'name_en' => 'Test System',
            'description' => 'รายละเอียดระบบทดสอบ',
            'icon' => 'bi-grid-fill',
            'color' => 'blue',
            'url' => 'https://example.com',
            'category' => 'ทดสอบ',
            'group_key' => 'service',
            'access_type' => 'external',
            'sort_order' => 99,
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.systems.index'));

    $system = PortalSystem::query()->where('name_th', 'ระบบทดสอบ')->firstOrFail();

    $this->actingAs(adminUser())
        ->put(route('admin.systems.update', $system), [
            'name_th' => 'ระบบทดสอบฉบับแก้ไข',
            'name_en' => 'Updated Test System',
            'icon' => 'bi-display',
            'color' => 'green',
            'group_key' => 'data',
            'access_type' => 'vpn',
            'sort_order' => 1,
            'is_featured' => '1',
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.systems.index'));

    expect($system->fresh())
        ->name_th->toBe('ระบบทดสอบฉบับแก้ไข')
        ->access_type->toBe('vpn')
        ->access_label->toBe('ภายใน (VPN)')
        ->is_featured->toBeTrue();

    $this->actingAs(adminUser())
        ->delete(route('admin.systems.destroy', $system))
        ->assertRedirect(route('admin.systems.index'));

    $this->assertDatabaseMissing('portal_systems', ['id' => $system->id]);
});

test('an administrator can manage news events and uploaded documents', function () {
    Storage::fake('public');
    $admin = adminUser();

    $this->actingAs($admin)->post(route('admin.news.store'), [
        'title' => 'ข่าวทดสอบระบบหลังบ้าน',
        'description' => 'รายละเอียดข่าว',
        'category' => 'ประกาศ',
        'published_at' => now()->subMinute()->format('Y-m-d H:i:s'),
        'sort_order' => 1,
        'is_active' => '1',
        'image' => UploadedFile::fake()->image('news.jpg'),
    ])->assertRedirect(route('admin.news.index'));

    $news = NewsItem::query()->where('title', 'ข่าวทดสอบระบบหลังบ้าน')->firstOrFail();
    Storage::disk('public')->assertExists($news->image_path);

    $this->actingAs($admin)->post(route('admin.events.store'), [
        'title' => 'กิจกรรมทดสอบ',
        'starts_at' => now()->addDay()->format('Y-m-d H:i:s'),
        'ends_at' => now()->addDay()->addHour()->format('Y-m-d H:i:s'),
        'color' => 'blue',
        'sort_order' => 1,
        'is_active' => '1',
    ])->assertRedirect(route('admin.events.index'));

    expect(PortalEvent::query()->where('title', 'กิจกรรมทดสอบ')->exists())->toBeTrue();

    $this->actingAs($admin)->post(route('admin.documents.store'), [
        'name' => 'เอกสารทดสอบ',
        'category' => 'คู่มือ',
        'version' => '2.1',
        'icon' => 'bi-file-earmark-pdf',
        'color' => 'red',
        'published_at' => now()->format('Y-m-d H:i:s'),
        'sort_order' => 1,
        'is_active' => '1',
        'file' => UploadedFile::fake()->create('guide.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('admin.documents.index'));

    $document = PortalDocument::query()->where('name', 'เอกสารทดสอบ')->firstOrFail();
    expect($document->file_type)->toBe('PDF')
        ->and($document->file_size)->toBe('100 KB')
        ->and($document->fiscal_year)->toBeNull()
        ->and($document->version)->toBe('2.1')
        ->and($document->icon)->toBe('bi-file-earmark-pdf')
        ->and($document->color)->toBe('red');
    Storage::disk('public')->assertExists($document->file_path);
});

test('the document create form initializes automatic file metadata and publication date', function () {
    $this->actingAs(adminUser())
        ->get(route('admin.documents.create'))
        ->assertOk()
        ->assertSee('data-document-form', false)
        ->assertSee('data-default-now', false)
        ->assertSee('ปีงบประมาณ <span class="text-muted fw-normal">(ไม่บังคับ)</span>', false)
        ->assertSee('ระบบจะกรอกประเภท ขนาด ไอคอน และสีให้อัตโนมัติ');
});

test('an administrator must select a supported document category', function () {
    $this->actingAs(adminUser())->post(route('admin.documents.store'), [
        'name' => 'เอกสารหมวดที่ไม่รองรับ',
        'category' => 'หมวดอื่น',
        'icon' => 'bi-file-earmark-text',
        'color' => 'blue',
        'sort_order' => 1,
        'is_active' => '1',
    ])->assertSessionHasErrors('category');

    $this->assertDatabaseMissing('portal_documents', [
        'name' => 'เอกสารหมวดที่ไม่รองรับ',
    ]);
});

test('document fiscal year and version are validated', function () {
    $this->actingAs(adminUser())->post(route('admin.documents.store'), [
        'name' => 'เอกสาร metadata ไม่ถูกต้อง',
        'category' => 'คู่มือ',
        'fiscal_year' => 2300,
        'version' => str_repeat('x', 31),
        'icon' => 'bi-file-earmark-text',
        'color' => 'blue',
        'sort_order' => 1,
        'is_active' => '1',
    ])->assertSessionHasErrors(['fiscal_year', 'version']);

    $this->assertDatabaseMissing('portal_documents', [
        'name' => 'เอกสาร metadata ไม่ถูกต้อง',
    ]);
});

test('uploaded news images can be replaced and are deleted with their record', function () {
    Storage::fake('public');
    $admin = adminUser();

    $this->actingAs($admin)->post(route('admin.news.store'), [
        'title' => 'ข่าวสำหรับทดสอบไฟล์',
        'image' => UploadedFile::fake()->image('first.jpg'),
        'sort_order' => 1,
        'is_active' => '1',
    ])->assertRedirect(route('admin.news.index'));

    $news = NewsItem::query()->where('title', 'ข่าวสำหรับทดสอบไฟล์')->firstOrFail();
    $originalImage = $news->image_path;
    Storage::disk('public')->assertExists($originalImage);

    $this->actingAs($admin)->put(route('admin.news.update', $news), [
        'title' => $news->title,
        'image' => UploadedFile::fake()->image('replacement.jpg'),
        'sort_order' => 1,
        'is_active' => '1',
    ])->assertRedirect(route('admin.news.index'));

    $replacementImage = $news->fresh()->image_path;
    expect($replacementImage)->not->toBe($originalImage);
    Storage::disk('public')->assertMissing($originalImage);
    Storage::disk('public')->assertExists($replacementImage);

    $this->actingAs($admin)->delete(route('admin.news.destroy', $news))
        ->assertRedirect(route('admin.news.index'));

    Storage::disk('public')->assertMissing($replacementImage);
    $this->assertDatabaseMissing('news_items', ['id' => $news->id]);
});

test('published records from the administration area appear on the portal', function () {
    PortalSystem::query()->create([
        'name_th' => 'ระบบใหม่จากหลังบ้าน',
        'icon' => 'bi-grid-fill',
        'color' => 'blue',
        'group_key' => 'service',
        'access_type' => 'vpn',
        'is_active' => true,
        'sort_order' => 999,
    ]);

    $this->get(route('systems.index'))
        ->assertOk()
        ->assertSee('ระบบใหม่จากหลังบ้าน')
        ->assertSee('ภายใน (VPN)');
});

test('an administrator can manage the about page responsibilities and personnel', function () {
    Storage::fake('public');
    $admin = adminUser();

    $this->actingAs($admin)->put(route('admin.about.update'), [
        'page_title' => 'รู้จักหน่วยงานของเรา',
        'meta_description' => 'ข้อมูลเกี่ยวกับหน่วยงานฉบับปรับปรุง',
        'hero_eyebrow' => 'ABOUT US',
        'hero_description' => 'คำอธิบายส่วนหัวฉบับใหม่',
        'intro_eyebrow' => 'OUR STORY',
        'intro_heading' => 'หัวข้อแนะนำหน่วยงานฉบับใหม่',
        'intro_paragraph_1' => 'เนื้อหาแนะนำหน่วยงานสำหรับการทดสอบ',
        'responsibilities_title' => 'ภารกิจของเรา',
        'personnel_title' => 'ทีมงานของเรา',
        'image' => UploadedFile::fake()->image('about.jpg'),
    ])->assertRedirect(route('admin.about.edit'));

    $aboutPage = AboutPage::query()->firstOrFail();
    expect($aboutPage->page_title)->toBe('รู้จักหน่วยงานของเรา');
    Storage::disk('public')->assertExists($aboutPage->image_path);

    $this->seed(AboutContentSeeder::class);
    expect($aboutPage->fresh()->page_title)->toBe('รู้จักหน่วยงานของเรา');

    $this->actingAs($admin)->post(route('admin.about.responsibilities.store'), [
        'title' => 'ภารกิจทดสอบ',
        'description' => 'รายละเอียดภารกิจทดสอบ',
        'icon' => 'bi-stars',
        'sort_order' => 99,
        'is_active' => '1',
    ])->assertRedirect(route('admin.about.responsibilities.index'));

    $this->actingAs($admin)->post(route('admin.about.personnel.store'), [
        'name_th' => 'บุคลากรทดสอบ',
        'name_en' => 'Test Person',
        'position_th' => 'ตำแหน่งทดสอบ',
        'unit' => 'หน่วยงานทดสอบ',
        'responsibilities' => '<strong onclick="alert(1)">วิเคราะห์ข้อมูล</strong><br><em>พัฒนาระบบสารสนเทศ</em><br><u>ดูแลเว็บไซต์</u><script>alert("x")</script>',
        'initials' => 'TP',
        'color' => 'blue',
        'email' => 'person@example.test',
        'phone' => '0 1234 5678',
        'sort_order' => 99,
        'is_head' => '1',
        'is_active' => '1',
        'photo' => UploadedFile::fake()->image('person.jpg'),
    ])->assertRedirect(route('admin.about.personnel.index'));

    $person = Personnel::query()->where('name_th', 'บุคลากรทดสอบ')->firstOrFail();
    Storage::disk('public')->assertExists($person->photo_path);
    expect($person->is_head)->toBeTrue()
        ->and($person->responsibilities)->toContain('พัฒนาระบบสารสนเทศ')
        ->and($person->responsibilities)->toContain('<strong>วิเคราะห์ข้อมูล</strong>')
        ->and($person->responsibilities)->toContain('<em>พัฒนาระบบสารสนเทศ</em>')
        ->and($person->responsibilities)->toContain('<u>ดูแลเว็บไซต์</u>')
        ->and($person->responsibilities)->not->toContain('onclick', '<script', 'alert')
        ->and(Personnel::query()->where('id', '!=', $person->id)->where('is_head', true)->exists())->toBeFalse()
        ->and(Personnel::published()->first()->is($person))->toBeTrue();

    $photoPath = $person->photo_path;
    $this->actingAs($admin)->put(route('admin.about.personnel.update', $person), [
        'name_th' => $person->name_th,
        'name_en' => $person->name_en,
        'position_th' => $person->position_th,
        'unit' => $person->unit,
        'responsibilities' => $person->responsibilities,
        'initials' => $person->initials,
        'color' => $person->color,
        'sort_order' => $person->sort_order,
        'remove_photo' => '1',
        'is_head' => '1',
        'is_active' => '1',
    ])->assertRedirect(route('admin.about.personnel.index'));

    expect($person->fresh()->photo_path)->toBeNull()
        ->and(Personnel::published()->first()->is($person))->toBeTrue();
    Storage::disk('public')->assertMissing($photoPath);

    $this->get(route('about'))
        ->assertOk()
        ->assertSee('รู้จักหน่วยงานของเรา')
        ->assertSee('ภารกิจทดสอบ')
        ->assertSee('พัฒนาระบบสารสนเทศ')
        ->assertSee('<strong>วิเคราะห์ข้อมูล</strong>', false)
        ->assertSee('<em>พัฒนาระบบสารสนเทศ</em>', false)
        ->assertSee('<u>ดูแลเว็บไซต์</u>', false)
        ->assertDontSee('onclick', false)
        ->assertDontSee('alert("x")', false)
        ->assertSee('mailto:person@example.test', false)
        ->assertSee('tel:012345678', false)
        ->assertSee('<ul>', false)
        ->assertSeeInOrder(['<strong>วิเคราะห์ข้อมูล</strong>', '<em>พัฒนาระบบสารสนเทศ</em>', '<u>ดูแลเว็บไซต์</u>'], false)
        ->assertSeeInOrder(['บุคลากรทดสอบ', 'ดร.กมลชนก ศรีสุข']);
});
