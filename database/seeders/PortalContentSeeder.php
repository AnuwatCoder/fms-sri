<?php

namespace Database\Seeders;

use App\Models\NewsItem;
use App\Models\PortalDocument;
use App\Models\PortalEvent;
use App\Models\PortalSystem;
use Database\Seeders\Data\PortalContentData;
use Illuminate\Database\Seeder;

class PortalContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSystems();
        $this->seedNews();
        $this->seedEvents();
        $this->seedDocuments();
    }

    private function seedSystems(): void
    {
        foreach (PortalContentData::applications() as $index => $item) {
            PortalSystem::query()->updateOrCreate(
                ['name_th' => $item['name_th']],
                $item + ['sort_order' => $index + 1],
            );
        }
    }

    private function seedNews(): void
    {
        foreach (PortalContentData::news() as $index => $item) {
            $publishedAt = now()->startOfDay()->subDays($item['published_days_ago'])->setTime(8, 0);
            unset($item['published_days_ago']);

            NewsItem::query()->updateOrCreate(
                ['title' => $item['title']],
                $item + ['published_at' => $publishedAt, 'sort_order' => $index + 1],
            );
        }
    }

    private function seedEvents(): void
    {
        foreach (PortalContentData::events() as $index => $item) {
            $eventDate = now()->startOfDay()->addDays($item['starts_days_from_now']);
            $startsAt = $eventDate->copy()->setTimeFromTimeString($item['start_time']);
            $endsAt = $item['end_time']
                ? $eventDate->copy()->setTimeFromTimeString($item['end_time'])
                : null;

            unset($item['starts_days_from_now'], $item['start_time'], $item['end_time']);

            PortalEvent::query()->updateOrCreate(
                ['title' => $item['title']],
                $item + ['starts_at' => $startsAt, 'ends_at' => $endsAt, 'sort_order' => $index + 1],
            );
        }
    }

    private function seedDocuments(): void
    {
        foreach (PortalContentData::documents() as $index => $item) {
            $publishedAt = now()->startOfDay()->subDays($item['published_days_ago'])->setTime(8, 0);
            unset($item['published_days_ago']);

            PortalDocument::query()->updateOrCreate(
                ['name' => $item['name']],
                $item + ['published_at' => $publishedAt, 'sort_order' => $index + 1],
            );
        }
    }
}
