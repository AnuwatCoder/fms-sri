<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SeoSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:100'],
            'default_title' => ['required', 'string', 'max:70'],
            'default_description' => ['required', 'string', 'max:160'],
            'keywords' => ['nullable', 'string', 'max:500'],
            'author' => ['nullable', 'string', 'max:255'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'remove_og_image' => ['boolean'],
            'twitter_site' => ['nullable', 'string', 'max:50', 'regex:/^@[A-Za-z0-9_]{1,15}$/'],
            'google_site_verification' => ['nullable', 'string', 'max:255'],
            'robots_index' => ['boolean'],
            'robots_follow' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'remove_og_image' => $this->boolean('remove_og_image'),
            'robots_index' => $this->boolean('robots_index'),
            'robots_follow' => $this->boolean('robots_follow'),
        ]);
    }
}
