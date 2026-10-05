<?php

use App\Support\DocumentFilePresentation;

test('document presentation is inferred from its extension', function (string $extension, array $expected) {
    expect(DocumentFilePresentation::forExtension($extension))->toBe($expected);
})->with([
    'PDF' => ['pdf', ['file_type' => 'PDF', 'icon' => 'bi-file-earmark-pdf', 'color' => 'red']],
    'Word' => ['docx', ['file_type' => 'DOCX', 'icon' => 'bi-file-earmark-word', 'color' => 'blue']],
    'Excel' => ['xlsx', ['file_type' => 'XLSX', 'icon' => 'bi-file-earmark-excel', 'color' => 'green']],
    'PowerPoint' => ['pptx', ['file_type' => 'PPTX', 'icon' => 'bi-file-earmark-slides', 'color' => 'orange']],
    'ZIP' => ['zip', ['file_type' => 'ZIP', 'icon' => 'bi-file-earmark-zip', 'color' => 'purple']],
]);

test('document file sizes are formatted for display', function (int $bytes, string $expected) {
    expect(DocumentFilePresentation::formatBytes($bytes))->toBe($expected);
})->with([
    'kilobytes' => [102400, '100 KB'],
    'megabytes' => [4404019, '4.2 MB'],
]);
