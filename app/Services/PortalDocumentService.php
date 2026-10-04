<?php

namespace App\Services;

use App\Models\PortalDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class PortalDocumentService
{
    public function __construct(private readonly PublicFileStorage $files) {}

    /** @param array<string, mixed> $attributes */
    public function save(PortalDocument $document, array $attributes): PortalDocument
    {
        /** @var UploadedFile|null $file */
        $file = Arr::pull($attributes, 'file');
        $removeFile = (bool) Arr::pull($attributes, 'remove_file', false);

        if ($file) {
            $filePath = $this->files->store($file, 'portal/documents');
            $this->files->delete($document->file_path);
            $attributes['file_path'] = $filePath;
            $attributes['file_type'] = strtoupper($file->getClientOriginalExtension());
            $attributes['file_size'] = $this->formatBytes($file->getSize());
        } elseif ($removeFile) {
            $this->files->delete($document->file_path);
            $attributes['file_path'] = null;
        }

        $document->fill($attributes)->save();

        return $document;
    }

    public function delete(PortalDocument $document): void
    {
        $this->files->delete($document->file_path);
        $document->delete();
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        return round($bytes / 1024, 1).' KB';
    }
}
