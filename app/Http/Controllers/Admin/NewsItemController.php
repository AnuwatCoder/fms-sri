<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsItemRequest;
use App\Models\NewsItem;
use App\Services\NewsItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsItemController extends Controller
{
    public function index(Request $request): View
    {
        $newsItems = NewsItem::query()
            ->search($request->string('q')->toString())
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.news.index', compact('newsItems'));
    }

    public function create(): View
    {
        return view('admin.news.create', ['newsItem' => new NewsItem]);
    }

    public function store(NewsItemRequest $request, NewsItemService $service): RedirectResponse
    {
        $service->save(new NewsItem, $request->validated());

        return to_route('admin.news.index')->with('success', 'เพิ่มข่าว/ประกาศเรียบร้อยแล้ว');
    }

    public function edit(NewsItem $newsItem): View
    {
        return view('admin.news.edit', compact('newsItem'));
    }

    public function update(NewsItemRequest $request, NewsItem $newsItem, NewsItemService $service): RedirectResponse
    {
        $service->save($newsItem, $request->validated());

        return to_route('admin.news.index')->with('success', 'บันทึกข่าว/ประกาศเรียบร้อยแล้ว');
    }

    public function destroy(NewsItem $newsItem, NewsItemService $service): RedirectResponse
    {
        $service->delete($newsItem);

        return to_route('admin.news.index')->with('success', 'ลบข่าว/ประกาศเรียบร้อยแล้ว');
    }
}
