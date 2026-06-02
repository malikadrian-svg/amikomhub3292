<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * Hanya izinkan user dengan role 'admin' untuk melanjutkan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, kembalikan ke halaman login admin
        return redirect()->route('admin.login')
            ->withErrors(['email' => 'Anda tidak memiliki hak akses sebagai Admin.']);
    }
}
