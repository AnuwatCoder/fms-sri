<?php

namespace App\Models;

use App\Enums\SystemAccessType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_th', 'name_en', 'description', 'icon', 'color', 'url',
        'category', 'group_key', 'access_type', 'is_featured', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        return $query->when($term !== '', fn (Builder $query) => $query->where(
            fn (Builder $query) => $query
                ->where('name_th', 'like', "%{$term}%")
                ->orWhere('name_en', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('category', 'like', "%{$term}%"),
        ));
    }

    public function getAccessLabelAttribute(): string
    {
        return SystemAccessType::tryFrom($this->access_type)?->label()
            ?? SystemAccessType::External->label();
    }

    public function getAccessIconAttribute(): string
    {
        return SystemAccessType::tryFrom($this->access_type)?->icon()
            ?? SystemAccessType::External->icon();
    }
}
