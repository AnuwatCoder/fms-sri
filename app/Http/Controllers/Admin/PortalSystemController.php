<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortalSystemRequest;
use App\Models\PortalSystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalSystemController extends Controller
{
    public function index(Request $request): View
    {
        $systems = PortalSystem::query()
            ->search($request->string('q')->toString())
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.systems.index', compact('systems'));
    }

    public function create(): View
    {
        return view('admin.systems.create', ['system' => new PortalSystem]);
    }

    public function store(PortalSystemRequest $request): RedirectResponse
    {
        PortalSystem::query()->create($request->validated());

        return to_route('admin.systems.index')->with('success', 'เพิ่มระบบสารสนเทศเรียบร้อยแล้ว');
    }

    public function edit(PortalSystem $system): View
    {
        return view('admin.systems.edit', compact('system'));
    }

    public function update(PortalSystemRequest $request, PortalSystem $system): RedirectResponse
    {
        $system->update($request->validated());

        return to_route('admin.systems.index')->with('success', 'บันทึกข้อมูลระบบเรียบร้อยแล้ว');
    }

    public function destroy(PortalSystem $system): RedirectResponse
    {
        $system->delete();

        return to_route('admin.systems.index')->with('success', 'ลบระบบสารสนเทศเรียบร้อยแล้ว');
    }
}
