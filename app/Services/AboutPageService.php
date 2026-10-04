<?php

namespace App\Services;

use App\Models\AboutPage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class AboutPageService
{
    public function __construct(private readonly PublicFileStorage $files) {}

    /** @param array<string, mixed> $attributes */
    public function update(AboutPage $aboutPage, array $attributes): AboutPage
    {
        /** @var UploadedFile|null $image */
        $image = Arr::pull($attributes, 'image');
        $removeImage = (bool) Arr::pull($attributes, 'remove_image', false);

        if ($image) {
            $imagePath = $this->files->store($image, 'portal/about');
            $this->files->delete($aboutPage->image_path, ['images/']);
            $attributes['image_path'] = $imagePath;
        } elseif ($removeImage) {
            $this->files->delete($aboutPage->image_path, ['images/']);
            $attributes['image_path'] = null;
        }

        $aboutPage->update($attributes);

        return $aboutPage;
    }
}
