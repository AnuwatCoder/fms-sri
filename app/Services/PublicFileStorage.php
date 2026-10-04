<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PublicFileStorage
{
    public function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    /** @param array<int, string> $protectedPrefixes */
    public function delete(?string $path, array $protectedPrefixes = []): void
    {
        if (! $path) {
            return;
        }

        foreach ($protectedPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return;
            }
        }

        Storage::disk('public')->delete($path);
    }
}
