<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SeoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name', 'default_title', 'default_description', 'keywords', 'author',
        'og_image_path', 'twitter_site', 'google_site_verification',
        'robots_index', 'robots_follow',
    ];

    protected function casts(): array
    {
        return [
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
        ];
    }

    public function getOgImageUrlAttribute(): string
    {
        if (! $this->og_image_path) {
            return asset('images/psu-fms-logo-th.png');
        }

        return str_starts_with($this->og_image_path, 'images/')
            ? asset($this->og_image_path)
            : Storage::disk('public')->url($this->og_image_path);
    }

    public function getRobotsContentAttribute(): string
    {
        return implode(', ', [
            $this->robots_index ? 'index' : 'noindex',
            $this->robots_follow ? 'follow' : 'nofollow',
        ]);
    }
}
