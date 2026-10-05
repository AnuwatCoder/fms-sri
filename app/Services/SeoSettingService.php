<?php

namespace App\Services;

use App\Models\SeoSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class SeoSettingService
{
    public function __construct(private readonly PublicFileStorage $files) {}

    /** @param array<string, mixed> $attributes */
    public function update(SeoSetting $seoSetting, array $attributes): SeoSetting
    {
        /** @var UploadedFile|null $ogImage */
        $ogImage = Arr::pull($attributes, 'og_image');
        $removeOgImage = (bool) Arr::pull($attributes, 'remove_og_image', false);

        if ($ogImage) {
            $imagePath = $this->files->store($ogImage, 'portal/seo');
            $this->files->delete($seoSetting->og_image_path, ['images/']);
            $attributes['og_image_path'] = $imagePath;
        } elseif ($removeOgImage) {
            $this->files->delete($seoSetting->og_image_path, ['images/']);
            $attributes['og_image_path'] = null;
        }

        $seoSetting->fill($attributes)->save();

        return $seoSetting;
    }
}
