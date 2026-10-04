<?php

namespace App\Livewire;

use App\Models\NewsItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class NewsDirectory extends Component
{
    #[Url(except: 'ทั้งหมด')]
    public string $category = 'ทั้งหมด';

    public function setCategory(string $category): void
    {
        $categories = $this->categories()->prepend('ทั้งหมด')->all();

        if (in_array($category, $categories, true)) {
            $this->category = $category;
        }
    }

    public function render(): View
    {
        $newsItems = NewsItem::published()
            ->when($this->category !== 'ทั้งหมด', fn ($query) => $query->where('category', $this->category))
            ->get();

        return view('livewire.news-directory', [
            'newsItems' => $newsItems,
            'categories' => $this->categories()->prepend('ทั้งหมด'),
        ]);
    }

    /** @return Collection<int, string> */
    private function categories(): Collection
    {
        return NewsItem::published()
            ->reorder()
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }
}
