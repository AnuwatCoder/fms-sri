<?php

namespace App\Livewire;

use App\Support\PortalContent;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class NewsDirectory extends Component
{
    #[Url(except: 'ทั้งหมด')]
    public string $category = 'ทั้งหมด';

    public function setCategory(string $category): void
    {
        if (in_array($category, ['ทั้งหมด', 'ประกาศ', 'ระบบสารสนเทศ', 'อบรม'], true)) {
            $this->category = $category;
        }
    }

    public function render(): View
    {
        $newsItems = collect(PortalContent::news())
            ->when($this->category !== 'ทั้งหมด', fn ($items) => $items->where('category', $this->category));

        return view('livewire.news-directory', ['newsItems' => $newsItems]);
    }
}
