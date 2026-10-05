<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\AboutResponsibility;
use App\Models\NewsItem;
use App\Models\Personnel;
use Illuminate\Contracts\View\View;

class PortalPageController extends Controller
{
    public function systems(): View
    {
        return view('portal.systems');
    }

    public function news(): View
    {
        return view('portal.news');
    }

    public function showNews(int $newsItem): View
    {
        return view('portal.news-show', [
            'newsItem' => NewsItem::published()->whereKey($newsItem)->firstOrFail(),
        ]);
    }

    public function documents(): View
    {
        return view('portal.documents');
    }

    public function about(): View
    {
        $personnel = Personnel::published()->get();

        return view('portal.about', [
            'aboutPage' => AboutPage::query()->firstOrFail(),
            'responsibilities' => AboutResponsibility::published()->get(),
            'personnelHead' => $personnel->firstWhere('is_head', true),
            'personnelMembers' => $personnel->where('is_head', false)->values(),
        ]);
    }

    public function contact(): View
    {
        return view('portal.contact');
    }
}
