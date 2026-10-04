<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AboutPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'page_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'hero_eyebrow' => ['nullable', 'string', 'max:100'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
            'intro_eyebrow' => ['nullable', 'string', 'max:100'],
            'intro_heading' => ['required', 'string', 'max:500'],
            'intro_paragraph_1' => ['nullable', 'string', 'max:3000'],
            'intro_paragraph_2' => ['nullable', 'string', 'max:3000'],
            'image' => ['nullable', 'image', 'max:6144'],
            'remove_image' => ['boolean'],
            'responsibilities_eyebrow' => ['nullable', 'string', 'max:100'],
            'responsibilities_title' => ['nullable', 'string', 'max:255'],
            'responsibilities_description' => ['nullable', 'string', 'max:500'],
            'personnel_eyebrow' => ['nullable', 'string', 'max:100'],
            'personnel_title' => ['nullable', 'string', 'max:255'],
            'personnel_description' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['remove_image' => $this->boolean('remove_image')]);
    }
}
