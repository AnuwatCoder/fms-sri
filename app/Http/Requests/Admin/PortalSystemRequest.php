<?php

namespace App\Http\Requests\Admin;

use App\Enums\SystemAccessType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PortalSystemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'name_th' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'icon' => ['required', 'string', 'max:80'],
            'color' => ['required', 'in:blue,green,purple,pink,cyan,orange,violet,teal'],
            'url' => ['nullable', 'string', 'max:2048'],
            'category' => ['nullable', 'string', 'max:100'],
            'group_key' => ['required', 'in:plan,revenue,data,service'],
            'access_type' => ['required', Rule::enum(SystemAccessType::class)],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
