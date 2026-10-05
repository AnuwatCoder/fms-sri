<?php

namespace App\Services;

use App\Models\PortalDocument;
use App\Support\DocumentFilePresentation;
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
            $attributes = array_replace(
                $attributes,
                DocumentFilePresentation::forExtension($file->getClientOriginalExtension()),
                [
                    'file_path' => $filePath,
                    'file_size' => DocumentFilePresentation::formatBytes($file->getSize()),
                ],
            );
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
}
