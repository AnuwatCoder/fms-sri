<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->is_admin, 403, 'บัญชีนี้ไม่มีสิทธิ์เข้าถึงระบบหลังบ้าน');

        return $next($request);
    }
}
