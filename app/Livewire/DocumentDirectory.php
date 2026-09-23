<?php

namespace App\Livewire;

use App\Support\PortalContent;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class DocumentDirectory extends Component
{
    #[Url(except: 'ทั้งหมด')]
    public string $category = 'ทั้งหมด';

    public function setCategory(string $category): void
    {
        if (in_array($category, ['ทั้งหมด', 'คู่มือ', 'แบบฟอร์ม', 'แนวปฏิบัติ', 'นโยบาย'], true)) {
            $this->category = $category;
        }
    }

    public function render(): View
    {
        $documents = collect(PortalContent::documents())
            ->when($this->category !== 'ทั้งหมด', fn ($items) => $items->where('category', $this->category));

        return view('livewire.document-directory', ['documents' => $documents]);
    }
}
