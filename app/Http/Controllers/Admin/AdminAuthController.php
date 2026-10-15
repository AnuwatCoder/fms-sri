<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Throwable;

class AdminAuthController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::user()?->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function redirect(): RedirectResponse
    {
        return Socialite::driver('authentik')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $authentikUser = Socialite::driver('authentik')->user();
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('admin.login')->withErrors([
                'authentik' => 'ไม่สามารถเข้าสู่ระบบด้วย PSU SSO ได้ กรุณาลองใหม่อีกครั้ง',
            ]);
        }

        $email = $authentikUser->getEmail();
        $administrator = is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL)
            ? User::query()
                ->whereRaw('LOWER(email) = ?', [Str::lower($email)])
                ->where('is_admin', true)
                ->first()
            : null;

        if (! $administrator) {
            return redirect()->route('admin.login')->withErrors([
                'authentik' => 'บัญชี PSU นี้ไม่มีสิทธิ์เข้าถึงระบบหลังบ้าน',
            ]);
        }

        Auth::login($administrator);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
