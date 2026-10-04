<?php

use App\Models\AboutResponsibility;
use App\Models\NewsItem;
use App\Models\Personnel;
use App\Models\PortalDocument;
use App\Models\PortalEvent;
use App\Models\PortalSystem;
use Database\Seeders\DatabaseSeeder;

test('the database seeder provides representative portal content without duplicates', function () {
    expect(PortalSystem::query()->count())->toBe(8)
        ->and(PortalSystem::query()->where('access_type', 'external')->exists())->toBeTrue()
        ->and(PortalSystem::query()->where('access_type', 'vpn')->exists())->toBeTrue()
        ->and(NewsItem::query()->count())->toBe(5)
        ->and(PortalEvent::query()->count())->toBe(4)
        ->and(PortalEvent::query()->where('starts_at', '>', now())->count())->toBe(4)
        ->and(PortalDocument::query()->count())->toBe(6)
        ->and(AboutResponsibility::query()->count())->toBe(4)
        ->and(Personnel::query()->count())->toBe(4)
        ->and(Personnel::query()->where('is_head', true)->count())->toBe(1)
        ->and(Personnel::query()->whereNotNull('responsibilities')->count())->toBe(4)
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
        ->and(PortalDocument::query()->count())->toBe(6)
        ->and(Personnel::query()->count())->toBe(4);
});
