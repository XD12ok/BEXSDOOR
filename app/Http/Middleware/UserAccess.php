<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->role === $role) {
            return $next($request);
        }

        // Redirect berdasarkan role user
        if (auth()->user()->role === 'admin') {
            return redirect('/Admin/AdminMenu');
        } elseif (auth()->user()->role === 'user') {
            return redirect('/home');
        }

        // Kalau role-nya tidak dikenal
        return abort(403, 'Unauthorized.');
    }
}
