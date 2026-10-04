<?php

namespace App\Http\Requests\Admin;

use App\Support\RichText;
use Illuminate\Foundation\Http\FormRequest;

class PersonnelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'name_th' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'position_th' => ['nullable', 'string', 'max:255'],
            'position_en' => ['nullable', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:255'],
            'responsibilities' => ['nullable', 'string', 'max:5000'],
            'initials' => ['nullable', 'string', 'max:10'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_photo' => ['boolean'],
            'color' => ['required', 'in:navy,blue,green,purple,pink,teal,orange'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_head' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'responsibilities' => RichText::sanitize($this->input('responsibilities')),
            'remove_photo' => $this->boolean('remove_photo'),
            'is_head' => $this->boolean('is_head'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
