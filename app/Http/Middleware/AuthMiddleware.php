<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        // Check if user is authenticated
        if (!auth('user')->check()) {
            return redirect()->route('web.login')->with('error', __('messages.Please login to access your dashboard'));
        }

        return $next($request);
    }
}
