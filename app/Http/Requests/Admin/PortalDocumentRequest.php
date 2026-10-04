<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PortalDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'category' => ['nullable', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,csv,zip', 'max:20480'],
            'remove_file' => ['boolean'],
            'url' => ['nullable', 'string', 'max:2048'],
            'file_type' => ['nullable', 'string', 'max:20'],
            'file_size' => ['nullable', 'string', 'max:30'],
            'icon' => ['required', 'string', 'max:80'],
            'color' => ['required', 'in:red,blue,pink,purple,green,orange,teal'],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'remove_file' => $this->boolean('remove_file'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
