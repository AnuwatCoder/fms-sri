<?php

namespace App\Livewire;

use App\Enums\DocumentCategory;
use App\Models\PortalDocument;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class DocumentDirectory extends Component
{
    #[Url(except: 'ทั้งหมด')]
    public string $category = 'ทั้งหมด';

    #[Url(as: 'year', except: '')]
    public string $fiscalYear = '';

    public function setCategory(string $category): void
    {
        $categories = $this->categories()->prepend('ทั้งหมด')->all();

        if (in_array($category, $categories, true)) {
            $this->category = $category;

            if (! $this->categoryUsesFiscalYear()) {
                $this->fiscalYear = '';
            }
        }
    }

    public function updatedFiscalYear(string $fiscalYear): void
    {
        if ($fiscalYear !== '' && ! $this->fiscalYears()->contains((int) $fiscalYear)) {
            $this->fiscalYear = '';
        }
    }

    public function render(): View
    {
        $documents = PortalDocument::published()
            ->when($this->category !== 'ทั้งหมด', fn ($query) => $query->where('category', $this->category))
            ->when(
                $this->fiscalYear !== '' && $this->categoryUsesFiscalYear(),
                fn ($query) => $query->where('fiscal_year', (int) $this->fiscalYear)
            )
            ->get();

        return view('livewire.document-directory', [
            'documents' => $documents,
            'categories' => $this->categories()->prepend('ทั้งหมด'),
            'fiscalYears' => $this->fiscalYears(),
            'usesFiscalYear' => $this->categoryUsesFiscalYear(),
        ]);
    }

    /** @return Collection<int, string> */
    private function categories(): Collection
    {
        $categoryOrder = array_flip(DocumentCategory::values());

        return PortalDocument::published()
            ->reorder()
            ->whereNotNull('category')
            ->pluck('category')
            ->unique()
            ->sort(function (string $left, string $right) use ($categoryOrder): int {
                $leftOrder = $categoryOrder[$left] ?? PHP_INT_MAX;
                $rightOrder = $categoryOrder[$right] ?? PHP_INT_MAX;

                return $leftOrder === $rightOrder
                    ? strcmp($left, $right)
                    : $leftOrder <=> $rightOrder;
            })
            ->values();
    }

    /** @return Collection<int, int> */
    private function fiscalYears(): Collection
    {
        return PortalDocument::published()
            ->reorder()
            ->whereNotNull('fiscal_year')
            ->select('fiscal_year')
            ->distinct()
            ->orderByDesc('fiscal_year')
            ->pluck('fiscal_year');
    }

    private function categoryUsesFiscalYear(): bool
    {
        if ($this->category === 'ทั้งหมด') {
            return true;
        }

        return DocumentCategory::tryFrom($this->category)?->usesFiscalYear() ?? true;
    }
}
