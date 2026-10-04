<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\AboutResponsibility;
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

    public function documents(): View
    {
        return view('portal.documents');
    }

    public function about(): View
    {
        return view('portal.about', [
            'aboutPage' => AboutPage::query()->firstOrFail(),
            'responsibilities' => AboutResponsibility::published()->get(),
            'personnel' => Personnel::published()->get(),
        ]);
    }

    public function contact(): View
    {
        return view('portal.contact');
    }
}
