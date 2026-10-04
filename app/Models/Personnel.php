<?php

namespace App\Models;

use App\Support\RichText;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Personnel extends Model
{
    use HasFactory;

    protected $table = 'personnel';

    protected $fillable = [
        'name_th', 'name_en', 'position_th', 'position_en', 'unit', 'responsibilities', 'initials',
        'photo_path', 'color', 'is_head', 'email', 'phone', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_head' => 'boolean', 'is_active' => 'boolean', 'sort_order' => 'integer'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderByDesc('is_head')->orderBy('sort_order')->orderBy('id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo_path) {
            return null;
        }

        return str_starts_with($this->photo_path, 'images/')
            ? asset($this->photo_path)
            : Storage::disk('public')->url($this->photo_path);
    }

    public function getResponsibilitiesHtmlAttribute(): ?string
    {
        return RichText::sanitize($this->responsibilities);
    }

    public function getResponsibilitiesTextAttribute(): string
    {
        return RichText::toPlainText($this->responsibilities);
    }
}
