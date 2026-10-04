<?php

namespace App\Models;

use App\Support\ThaiDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PortalDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category', 'file_type', 'file_size',
        'file_path', 'url', 'icon', 'color', 'published_at',
        'is_active', 'sort_order',
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
        return $query->where('is_active', true)->orderBy('sort_order')->orderByDesc('published_at');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        return $query->when($term !== '', fn (Builder $query) => $query->where('name', 'like', "%{$term}%"));
    }

    public function getDisplayDateAttribute(): string
    {
        return $this->published_at ? ThaiDate::date($this->published_at) : '-';
    }

    public function getDownloadUrlAttribute(): string
    {
        return $this->file_path ? Storage::disk('public')->url($this->file_path) : ($this->url ?: '#');
    }
}
