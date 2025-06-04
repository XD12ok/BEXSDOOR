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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->role === $role) {
            return $next($request);
        }

        // Redirect berdasarkan role
        if (auth()->user()->role === 'admin') {
            return redirect('/Admin/AdminMenu');
        } elseif (auth()->user()->role === 'user') {
            return redirect('/home');
        }

        return abort(403, 'Unauthorized.');
    }
}
