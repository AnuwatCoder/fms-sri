<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['remember' => $this->boolean('remember')]);
    }

    public function authenticate(): void
    {
        if (! Auth::attempt($this->safe()->only(['email', 'password']), $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
            ]);
        }

        if (! $this->user()?->is_admin) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'บัญชีนี้ไม่มีสิทธิ์เข้าถึงระบบหลังบ้าน',
            ]);
        }
    }
}
