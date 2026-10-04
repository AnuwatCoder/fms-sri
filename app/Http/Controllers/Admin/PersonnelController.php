<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PersonnelRequest;
use App\Models\Personnel;
use App\Services\PersonnelService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonnelController extends Controller
{
    public function index(): View
    {
        return view('admin.about.personnel.index', [
            'personnel' => Personnel::query()->orderByDesc('is_head')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.about.personnel.create', ['person' => new Personnel]);
    }

    public function store(PersonnelRequest $request, PersonnelService $service): RedirectResponse
    {
        $service->save(new Personnel, $request->validated());

        return to_route('admin.about.personnel.index')->with('success', 'เพิ่มบุคลากรเรียบร้อยแล้ว');
    }

    public function edit(Personnel $person): View
    {
        return view('admin.about.personnel.edit', compact('person'));
    }

    public function update(PersonnelRequest $request, Personnel $person, PersonnelService $service): RedirectResponse
    {
        $service->save($person, $request->validated());

        return to_route('admin.about.personnel.index')->with('success', 'บันทึกข้อมูลบุคลากรเรียบร้อยแล้ว');
    }

    public function destroy(Personnel $person, PersonnelService $service): RedirectResponse
    {
        $service->delete($person);

        return to_route('admin.about.personnel.index')->with('success', 'ลบบุคลากรเรียบร้อยแล้ว');
    }
}
