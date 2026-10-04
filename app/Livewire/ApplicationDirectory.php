<?php

namespace App\Livewire;

use App\Models\PortalSystem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

class ApplicationDirectory extends Component
{
    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: 'all')]
    public string $category = 'all';

    public bool $compact = false;

    /** @var array<int, int> */
    public array $favorites = [];

    public function mount(bool $compact = false): void
    {
        $this->compact = $compact;
        $this->favorites = session()->get(
            'portal_favorites',
            PortalSystem::published()->where('is_featured', true)->pluck('id')->all(),
        );
    }

    public function setCategory(string $category): void
    {
        if (in_array($category, ['all', 'plan', 'revenue', 'data', 'service'], true)) {
            $this->category = $category;
        }
    }

    public function toggleFavorite(int $applicationId): void
    {
        if (! PortalSystem::published()->whereKey($applicationId)->exists()) {
            return;
        }

        if (in_array($applicationId, $this->favorites, true)) {
            $this->favorites = array_values(array_diff($this->favorites, [$applicationId]));
        } else {
            $this->favorites[] = $applicationId;
            sort($this->favorites);
        }

        session()->put('portal_favorites', $this->favorites);
    }

    public function render(): View
    {
        $applications = PortalSystem::published()->get()
            ->when($this->category !== 'all', fn ($items) => $items->where('group_key', $this->category))
            ->when($this->search !== '', function ($items) {
                $query = Str::lower(trim($this->search));

                return $items->filter(function (PortalSystem $application) use ($query): bool {
                    $searchable = Str::lower(implode(' ', [
                        $application->name_th,
                        $application->name_en,
                        $application->description,
                        $application->category,
                        $application->access_label,
                    ]));

                    return Str::contains($searchable, $query);
                });
            })
            ->map(function (PortalSystem $application): PortalSystem {
                $application->setAttribute('favorite', in_array($application->id, $this->favorites, true));

                return $application;
            });

        return view('livewire.application-directory', [
            'applications' => $applications,
            'totalApplications' => PortalSystem::published()->count(),
        ]);
    }
}
