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

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        return $query->when($term !== '', fn (Builder $query) => $query->where(
            fn (Builder $query) => $query
                ->where('name_th', 'like', "%{$term}%")
                ->orWhere('name_en', 'like', "%{$term}%")
                ->orWhere('position_th', 'like', "%{$term}%")
                ->orWhere('position_en', 'like', "%{$term}%")
                ->orWhere('unit', 'like', "%{$term}%")
                ->orWhere('responsibilities', 'like', "%{$term}%"),
        ));
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

    /** @return array<int, string> */
    public function getResponsibilityItemsAttribute(): array
    {
        return RichText::toListItems($this->responsibilities);
    }

    public function getPhoneUrlAttribute(): ?string
    {
        if (! $this->phone) {
            return null;
        }

        $number = preg_replace('/[^\d+]/', '', $this->phone) ?? '';

        return $number !== '' ? 'tel:'.$number : null;
    }
}
