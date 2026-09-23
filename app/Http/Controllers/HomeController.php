<?php

namespace App\Http\Controllers;

use App\Support\PortalContent;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome', [
            'newsItems' => PortalContent::news(),
            'events' => PortalContent::events(),
            'documents' => PortalContent::documents(),
        ]);
    }
}
