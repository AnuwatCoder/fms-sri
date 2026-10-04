<?php

use App\Livewire\ApplicationDirectory;
use App\Livewire\ContactForm;
use App\Livewire\DocumentDirectory;
use App\Livewire\NewsDirectory;
use App\Models\NewsItem;
use App\Models\PortalDocument;
use Livewire\Livewire;

test('applications can be searched and filtered without reloading the page', function () {
    Livewire::test(ApplicationDirectory::class)
        ->set('search', 'Revenue')
        ->assertSee('Revenue Management')
        ->assertDontSee('Strategic Planning System')
        ->set('search', '')
        ->call('setCategory', 'service')
        ->assertSee('IT Service Request')
        ->assertSee('HR Management')
        ->assertDontSee('Revenue Management');
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

test('contact form validates and confirms a successful submission', function () {
    Livewire::test(ContactForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'subject', 'message'])
        ->set('name', 'Anuwat Pattanachian')
        ->set('email', 'anuwat@example.com')
        ->set('subject', 'ขอข้อมูลเพิ่มเติม')
        ->set('message', 'กรุณาติดต่อกลับเพื่อให้ข้อมูลเพิ่มเติมเกี่ยวกับระบบ')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('sent', true)
        ->assertSet('name', '')
        ->assertSee('ส่งข้อความเรียบร้อยแล้ว');
});
