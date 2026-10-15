<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'heading' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['required', 'string', 'max:1000'],
            'phone' => ['required', 'string', 'max:50', 'regex:/^[0-9+\s().-]+$/'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'office_hours' => ['required', 'string', 'max:255'],
            'office_hours_note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
