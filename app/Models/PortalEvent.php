<?php

namespace App\Models;

use App\Support\ThaiDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'starts_at', 'ends_at', 'place', 'url',
        'color', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('starts_at')->orderBy('sort_order');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        return $query->when($term !== '', fn (Builder $query) => $query->where('title', 'like', "%{$term}%"));
    }

    public function getDisplayDayAttribute(): string
    {
        return $this->starts_at->format('j');
    }

    public function getDisplayMonthAttribute(): string
    {
        return ThaiDate::shortMonth($this->starts_at);
    }

    public function getDisplayTimeAttribute(): string
    {
        $start = $this->starts_at->format('H:i');
        $end = $this->ends_at?->format('H:i');

        return $end ? "{$start} - {$end} น." : "{$start} น.";
    }
}
