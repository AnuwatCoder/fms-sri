<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutPageRequest;
use App\Models\AboutPage;
use App\Services\AboutPageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function edit(): View
    {
        return view('admin.about.edit', [
            'aboutPage' => AboutPage::query()->firstOrFail(),
        ]);
    }

    public function update(AboutPageRequest $request, AboutPageService $service): RedirectResponse
    {
        $aboutPage = AboutPage::query()->firstOrFail();
        $service->update($aboutPage, $request->validated());

        return to_route('admin.about.edit')->with('success', 'บันทึกข้อมูลหน้าเกี่ยวกับหน่วยงานเรียบร้อยแล้ว');
    }
}
