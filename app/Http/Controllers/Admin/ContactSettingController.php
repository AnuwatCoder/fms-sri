<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactSettingRequest;
use App\Models\ContactSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.contact.edit', [
            'contactSetting' => ContactSetting::query()->firstOrFail(),
        ]);
    }

    public function update(ContactSettingRequest $request): RedirectResponse
    {
        ContactSetting::query()->firstOrFail()->update($request->validated());

        return to_route('admin.contact.edit')
            ->with('success', 'บันทึกช่องทางการติดต่อเรียบร้อยแล้ว');
    }
}
