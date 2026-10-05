<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortalSearchRequest;
use App\Services\GlobalSearchService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function __invoke(PortalSearchRequest $request, GlobalSearchService $search): View
    {
        $query = trim((string) $request->validated('q', ''));
        $results = $search->search($query);
        $resultCount = collect($results)->sum(fn (Collection $items): int => $items->count());

        return view('portal.search', compact('query', 'results', 'resultCount'));
    }
}
