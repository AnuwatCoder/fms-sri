<?php

namespace App\Http\Controllers;

use App\Support\PortalContent;
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
        return view('portal.about', ['personnel' => PortalContent::personnel()]);
    }

    public function contact(): View
    {
        return view('portal.contact');
    }
}
