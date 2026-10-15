<?php

use App\Enums\DocumentCategory;
use App\Models\AboutResponsibility;
use App\Models\ContactSetting;
use App\Models\NewsItem;
use App\Models\Personnel;
use App\Models\PortalDocument;
use App\Models\PortalEvent;
use App\Models\PortalSystem;
use App\Models\SeoSetting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

test('the database seeder provides representative portal content without duplicates', function () {
    expect(PortalSystem::query()->count())->toBe(8)
        ->and(PortalSystem::query()->where('access_type', 'external')->exists())->toBeTrue()
        ->and(PortalSystem::query()->where('access_type', 'vpn')->exists())->toBeTrue()
        ->and(NewsItem::query()->count())->toBe(5)
        ->and(PortalEvent::query()->count())->toBe(4)
        ->and(PortalEvent::query()->where('starts_at', '>', now())->count())->toBe(4)
        ->and(PortalDocument::query()->count())->toBe(7)
        ->and(PortalDocument::query()->whereNotNull('fiscal_year')->count())->toBe(3)
        ->and(PortalDocument::query()->whereNotNull('version')->count())->toBe(7)
        ->and(SeoSetting::query()->count())->toBe(1)
        ->and(ContactSetting::query()->count())->toBe(1)
        ->and(ContactSetting::query()->firstOrFail()->email)->toBe('fms@psu.ac.th')
        ->and(PortalDocument::query()->distinct()->pluck('category')->sort()->values()->all())
        ->toBe(collect(DocumentCategory::values())->sort()->values()->all())
        ->and(AboutResponsibility::query()->count())->toBe(4)
        ->and(Personnel::query()->count())->toBe(4)
        ->and(Personnel::query()->where('is_head', true)->count())->toBe(1)
        ->and(Personnel::query()->whereNotNull('responsibilities')->count())->toBe(4)
        ->and(Personnel::query()->whereNotNull('email')->count())->toBe(4)
        ->and(Personnel::query()->whereNotNull('phone')->count())->toBe(4)
        ->and(Personnel::query()->whereNotNull('photo_path')->count())->toBe(4);

    Personnel::query()->pluck('photo_path')->each(function (string $photoPath): void {
        expect(file_exists(public_path($photoPath)))->toBeTrue();
    });

    $head = Personnel::query()->where('is_head', true)->firstOrFail();
    expect($head->photo_url)->toBe(asset($head->photo_path));

    $this->seed(DatabaseSeeder::class);

    expect(PortalSystem::query()->count())->toBe(8)
        ->and(NewsItem::query()->count())->toBe(5)
        ->and(PortalEvent::query()->count())->toBe(4)
        ->and(PortalDocument::query()->count())->toBe(7)
        ->and(SeoSetting::query()->count())->toBe(1)
        ->and(ContactSetting::query()->count())->toBe(1)
        ->and(Personnel::query()->count())->toBe(4);
});

test('the database seeder provisions the configured authentik administrator idempotently', function () {
    config()->set('auth.administrator', [
        'name' => 'SSO Administrator',
        'email' => 'Admin.SSO@Example.test',
    ]);

    $this->seed(DatabaseSeeder::class);

    $administrator = User::query()->where('email', 'admin.sso@example.test')->firstOrFail();
    $password = $administrator->password;

    expect($administrator->name)->toBe('SSO Administrator')
        ->and($administrator->is_admin)->toBeTrue();

    $this->seed(DatabaseSeeder::class);

    expect(User::query()->where('email', 'admin.sso@example.test')->count())->toBe(1)
        ->and($administrator->fresh()->password)->toBe($password);
});
