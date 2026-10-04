<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortalEventRequest;
use App\Models\PortalEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalEventController extends Controller
{
    public function index(Request $request): View
    {
        $events = PortalEvent::query()
            ->search($request->string('q')->toString())
            ->orderByDesc('starts_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.create', ['event' => new PortalEvent]);
    }

    public function store(PortalEventRequest $request): RedirectResponse
    {
        PortalEvent::query()->create($request->validated());

        return to_route('admin.events.index')->with('success', 'เพิ่มกิจกรรมเรียบร้อยแล้ว');
    }

    public function edit(PortalEvent $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(PortalEventRequest $request, PortalEvent $event): RedirectResponse
    {
        $event->update($request->validated());

        return to_route('admin.events.index')->with('success', 'บันทึกกิจกรรมเรียบร้อยแล้ว');
    }

    public function destroy(PortalEvent $event): RedirectResponse
    {
        $event->delete();

        return to_route('admin.events.index')->with('success', 'ลบกิจกรรมเรียบร้อยแล้ว');
    }
}
