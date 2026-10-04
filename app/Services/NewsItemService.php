<?php

namespace App\Services;

use App\Models\NewsItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class NewsItemService
{
    public function __construct(private readonly PublicFileStorage $files) {}

    /** @param array<string, mixed> $attributes */
    public function save(NewsItem $newsItem, array $attributes): NewsItem
    {
        /** @var UploadedFile|null $image */
        $image = Arr::pull($attributes, 'image');
        $removeImage = (bool) Arr::pull($attributes, 'remove_image', false);

        if ($image) {
            $imagePath = $this->files->store($image, 'portal/news');
            $this->files->delete($newsItem->image_path, ['images/']);
            $attributes['image_path'] = $imagePath;
        } elseif ($removeImage) {
            $this->files->delete($newsItem->image_path, ['images/']);
            $attributes['image_path'] = null;
        }

        $newsItem->fill($attributes)->save();

        return $newsItem;
    }

    public function delete(NewsItem $newsItem): void
    {
        $this->files->delete($newsItem->image_path, ['images/']);
        $newsItem->delete();
    }
}
