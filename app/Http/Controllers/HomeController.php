<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use App\Models\PortalDocument;
use App\Models\PortalEvent;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome', [
            'newsItems' => NewsItem::published()->limit(3)->get(),
            'events' => PortalEvent::published()->limit(3)->get(),
            'documents' => PortalDocument::published()->limit(4)->get(),
        ]);
    }
}
