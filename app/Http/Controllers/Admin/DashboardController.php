<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use App\Models\Personnel;
use App\Models\PortalDocument;
use App\Models\PortalEvent;
use App\Models\PortalSystem;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'systems' => PortalSystem::query()->count(),
                'news' => NewsItem::query()->count(),
                'events' => PortalEvent::query()->count(),
                'documents' => PortalDocument::query()->count(),
                'personnel' => Personnel::query()->count(),
            ],
            'recentNews' => NewsItem::query()->latest('updated_at')->limit(5)->get(),
        ]);
    }
}
