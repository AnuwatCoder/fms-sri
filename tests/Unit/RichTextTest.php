<?php

use App\Support\RichText;

test('sanitized rich text is split into non-empty list items', function () {
    expect(RichText::toListItems('<strong>วิเคราะห์ข้อมูล</strong><br><br><em>พัฒนาระบบ</em><script>alert(1)</script>'))
        ->toBe([
            '<strong>วิเคราะห์ข้อมูล</strong>',
            '<em>พัฒนาระบบ</em>',
        ]);
});

test('empty rich text produces no list items', function (?string $value) {
    expect(RichText::toListItems($value))->toBe([]);
})->with([null, '', '   ']);
