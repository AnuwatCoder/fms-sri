<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_title', 'meta_description', 'hero_eyebrow', 'hero_description',
        'intro_eyebrow', 'intro_heading', 'intro_paragraph_1', 'intro_paragraph_2',
        'image_path', 'responsibilities_eyebrow', 'responsibilities_title',
        'responsibilities_description', 'personnel_eyebrow', 'personnel_title',
        'personnel_description',
    ];

    public function getImageUrlAttribute(): string
    {
        if (! $this->image_path) {
            return asset('images/portal/hero-campus.webp');
        }

        return str_starts_with($this->image_path, 'images/')
            ? asset($this->image_path)
            : Storage::disk('public')->url($this->image_path);
    }
}
