<?php

namespace App\Livewire;

use App\Support\PortalContent;
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
        $this->favorites = session()->get('portal_favorites', [0, 1, 5]);
    }

    public function setCategory(string $category): void
    {
        if (in_array($category, ['all', 'plan', 'revenue', 'data', 'service'], true)) {
            $this->category = $category;
        }
    }

    public function toggleFavorite(int $applicationKey): void
    {
        if (! array_key_exists($applicationKey, PortalContent::applications())) {
            return;
        }

        if (in_array($applicationKey, $this->favorites, true)) {
            $this->favorites = array_values(array_diff($this->favorites, [$applicationKey]));
        } else {
            $this->favorites[] = $applicationKey;
            sort($this->favorites);
        }

        session()->put('portal_favorites', $this->favorites);
    }

    public function render(): View
    {
        $applications = collect(PortalContent::applications())
            ->when($this->category !== 'all', fn ($items) => $items->where('group', $this->category))
            ->when($this->search !== '', function ($items) {
                $query = Str::lower(trim($this->search));

                return $items->filter(function (array $application) use ($query): bool {
                    $searchable = Str::lower(implode(' ', [
                        $application['name_th'],
                        $application['name_en'],
                        $application['description'],
                        $application['category'],
                    ]));

                    return Str::contains($searchable, $query);
                });
            })
            ->map(function (array $application, int $key): array {
                $application['favorite'] = in_array($key, $this->favorites, true);

                return $application;
            });

        return view('livewire.application-directory', [
            'applications' => $applications,
            'totalApplications' => count(PortalContent::applications()),
        ]);
    }
}
