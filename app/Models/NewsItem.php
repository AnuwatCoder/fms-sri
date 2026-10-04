<?php

namespace App\Models;

use App\Support\ThaiDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NewsItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'category', 'image_path', 'url',
        'published_at', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(fn (Builder $query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->orderByDesc('published_at')
            ->orderBy('sort_order');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        return $query->when($term !== '', fn (Builder $query) => $query->where('title', 'like', "%{$term}%"));
    }

    public function getDisplayDateAttribute(): string
    {
        return $this->published_at ? ThaiDate::date($this->published_at) : '-';
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image_path) {
            return asset('images/portal/news-strategy.webp');
        }

        return str_starts_with($this->image_path, 'images/')
            ? asset($this->image_path)
            : Storage::disk('public')->url($this->image_path);
    }
}
