<?php

namespace App\Services;

use App\Models\NewsItem;
use App\Models\Personnel;
use App\Models\PortalDocument;
use App\Models\PortalEvent;
use App\Models\PortalSystem;
use Illuminate\Database\Eloquent\Collection;

class GlobalSearchService
{
    private const RESULT_LIMIT = 8;

    /**
     * @return array{
     *     systems: Collection<int, PortalSystem>,
     *     news: Collection<int, NewsItem>,
     *     documents: Collection<int, PortalDocument>,
     *     events: Collection<int, PortalEvent>,
     *     personnel: Collection<int, Personnel>
     * }
     */
    public function search(string $term): array
    {
        if ($term === '') {
            return [
                'systems' => new Collection,
                'news' => new Collection,
                'documents' => new Collection,
                'events' => new Collection,
                'personnel' => new Collection,
            ];
        }

        return [
            'systems' => PortalSystem::published()->search($term)->limit(self::RESULT_LIMIT)->get(),
            'news' => NewsItem::published()->search($term)->limit(self::RESULT_LIMIT)->get(),
            'documents' => PortalDocument::published()->search($term)->limit(self::RESULT_LIMIT)->get(),
            'events' => PortalEvent::published()->search($term)->limit(self::RESULT_LIMIT)->get(),
            'personnel' => Personnel::published()->search($term)->limit(self::RESULT_LIMIT)->get(),
        ];
    }
}
