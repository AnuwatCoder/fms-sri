<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutResponsibilityRequest;
use App\Models\AboutResponsibility;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutResponsibilityController extends Controller
{
    public function index(): View
    {
        return view('admin.about.responsibilities.index', [
            'responsibilities' => AboutResponsibility::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.about.responsibilities.create', ['responsibility' => new AboutResponsibility]);
    }

    public function store(AboutResponsibilityRequest $request): RedirectResponse
    {
        AboutResponsibility::query()->create($request->validated());

        return to_route('admin.about.responsibilities.index')->with('success', 'เพิ่มภารกิจเรียบร้อยแล้ว');
    }

    public function edit(AboutResponsibility $responsibility): View
    {
        return view('admin.about.responsibilities.edit', compact('responsibility'));
    }

    public function update(AboutResponsibilityRequest $request, AboutResponsibility $responsibility): RedirectResponse
    {
        $responsibility->update($request->validated());

        return to_route('admin.about.responsibilities.index')->with('success', 'บันทึกภารกิจเรียบร้อยแล้ว');
    }

    public function destroy(AboutResponsibility $responsibility): RedirectResponse
    {
        $responsibility->delete();

        return to_route('admin.about.responsibilities.index')->with('success', 'ลบภารกิจเรียบร้อยแล้ว');
    }
}
