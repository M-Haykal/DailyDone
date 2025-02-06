<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            if (str_contains($user->email, '@admin')) {
                return redirect('/admin/dashboard');
            } elseif (str_contains($user->email, '@gmail')) {
                return redirect('/user/dashboard');
            }
        }

        return $next($request);
    }
}
