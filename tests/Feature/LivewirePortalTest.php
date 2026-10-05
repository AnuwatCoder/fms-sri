<?php

use App\Enums\DocumentCategory;
use App\Livewire\ApplicationDirectory;
use App\Livewire\DocumentDirectory;
use App\Livewire\NewsDirectory;
use App\Models\NewsItem;
use App\Models\PortalDocument;
use Livewire\Livewire;

test('applications can be searched and filtered without reloading the page', function () {
    Livewire::test(ApplicationDirectory::class)
        ->assertSeeInOrder(['ทั้งหมด', 'ภายนอก', 'ภายใน (VPN)'])
        ->set('search', 'Revenue')
        ->assertSee('Revenue Management')
        ->assertDontSee('Strategic Planning System')
        ->set('search', '')
        ->call('setAccessType', 'vpn')
        ->assertSee('Revenue Management')
        ->assertSee('HR Management')
        ->assertDontSee('IT Service Request');
});

test('application favorites are stored in the session', function () {
    $this->withSession(['portal_favorites' => [0]]);

    Livewire::test(ApplicationDirectory::class)
        ->call('toggleFavorite', 2)
        ->assertSet('favorites', [0, 2])
        ->assertSessionHas('portal_favorites', [0, 2]);
});

test('news can be filtered by category', function () {
    $trainingNews = NewsItem::query()->where('category', 'อบรม')->firstOrFail();
    $otherNews = NewsItem::query()->where('category', '!=', 'อบรม')->firstOrFail();

    Livewire::test(NewsDirectory::class)
        ->call('setCategory', 'อบรม')
        ->assertSee($trainingNews->title)
        ->assertDontSee($otherNews->title);
});

test('documents can be filtered by category', function () {
    $form = PortalDocument::query()->where('category', 'แบบฟอร์ม')->firstOrFail();
    $otherDocument = PortalDocument::query()->where('category', '!=', 'แบบฟอร์ม')->firstOrFail();

    Livewire::test(DocumentDirectory::class)
        ->call('setCategory', 'แบบฟอร์ม')
        ->assertSee($form->name)
        ->assertDontSee($otherDocument->name);
});

test('documents can be filtered by fiscal year', function () {
    $currentDocument = PortalDocument::query()->firstOrFail();
    $previousDocument = PortalDocument::query()->whereKeyNot($currentDocument->getKey())->firstOrFail();
    $currentDocument->update(['fiscal_year' => 2570]);
    $previousDocument->update(['fiscal_year' => 2569]);

    Livewire::test(DocumentDirectory::class)
        ->set('fiscalYear', '2570')
        ->assertSee($currentDocument->name)
        ->assertDontSee($previousDocument->name);
});

test('general document categories do not require a fiscal year filter', function () {
    $manual = PortalDocument::query()
        ->where('category', DocumentCategory::Manual->value)
        ->firstOrFail();

    Livewire::test(DocumentDirectory::class)
        ->set('fiscalYear', '2570')
        ->call('setCategory', DocumentCategory::Manual->value)
        ->assertSet('fiscalYear', '')
        ->assertSee($manual->name)
        ->assertDontSee('fiscalYearFilter');
});

test('document categories follow the portal information architecture', function () {
    Livewire::test(DocumentDirectory::class)
        ->assertSeeInOrder([
            DocumentCategory::StrategicPlan->value,
            DocumentCategory::Budget->value,
            DocumentCategory::Performance->value,
            DocumentCategory::Legal->value,
            DocumentCategory::Manual->value,
            DocumentCategory::Form->value,
        ]);
});
