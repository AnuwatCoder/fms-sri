<?php

use App\Livewire\ApplicationDirectory;
use App\Livewire\ContactForm;
use App\Livewire\DocumentDirectory;
use App\Livewire\NewsDirectory;
use App\Support\PortalContent;
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
    $news = PortalContent::news();

    Livewire::test(NewsDirectory::class)
        ->call('setCategory', 'อบรม')
        ->assertSee($news[2]['title'])
        ->assertDontSee($news[0]['title']);
});

test('documents can be filtered by category', function () {
    $documents = PortalContent::documents();

    Livewire::test(DocumentDirectory::class)
        ->call('setCategory', 'แบบฟอร์ม')
        ->assertSee($documents[1]['name'])
        ->assertDontSee($documents[0]['name']);
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
