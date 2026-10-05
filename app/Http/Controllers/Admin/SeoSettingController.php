<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeoSettingRequest;
use App\Models\SeoSetting;
use App\Services\SeoSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeoSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.seo.edit', [
            'seoSetting' => SeoSetting::query()->firstOrFail(),
        ]);
    }

    public function update(SeoSettingRequest $request, SeoSettingService $service): RedirectResponse
    {
        $service->update(SeoSetting::query()->firstOrFail(), $request->validated());

        return to_route('admin.seo.edit')->with('success', 'บันทึกการตั้งค่า SEO เรียบร้อยแล้ว');
    }
}
