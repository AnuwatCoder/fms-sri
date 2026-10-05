<?php

namespace App\Support;

final class DocumentFilePresentation
{
    /** @var array<string, array{icon: string, color: string}> */
    private const PRESETS = [
        'pdf' => ['icon' => 'bi-file-earmark-pdf', 'color' => 'red'],
        'doc' => ['icon' => 'bi-file-earmark-word', 'color' => 'blue'],
        'docx' => ['icon' => 'bi-file-earmark-word', 'color' => 'blue'],
        'xls' => ['icon' => 'bi-file-earmark-excel', 'color' => 'green'],
        'xlsx' => ['icon' => 'bi-file-earmark-excel', 'color' => 'green'],
        'csv' => ['icon' => 'bi-file-earmark-spreadsheet', 'color' => 'green'],
        'ppt' => ['icon' => 'bi-file-earmark-slides', 'color' => 'orange'],
        'pptx' => ['icon' => 'bi-file-earmark-slides', 'color' => 'orange'],
        'zip' => ['icon' => 'bi-file-earmark-zip', 'color' => 'purple'],
    ];

    /** @return array{file_type: string, icon: string, color: string} */
    public static function forExtension(string $extension): array
    {
        $extension = strtolower(ltrim($extension, '.'));
        $preset = self::PRESETS[$extension] ?? [
            'icon' => 'bi-file-earmark-text',
            'color' => 'blue',
        ];

        return ['file_type' => strtoupper($extension)] + $preset;
    }

    /** @return array<string, array{file_type: string, icon: string, color: string}> */
    public static function presets(): array
    {
        return collect(array_keys(self::PRESETS))
            ->mapWithKeys(fn (string $extension): array => [$extension => self::forExtension($extension)])
            ->all();
    }

    public static function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        return round($bytes / 1024, 1).' KB';
    }
}
