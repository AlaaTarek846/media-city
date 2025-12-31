<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAndCartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        // Check if user is authenticated
        if (auth('user')->check()) {
            $user = auth('user')->user();
            if($user->carts()->count() > 0) {
                return $next($request);
            }
            return redirect()->route('web.home')->with('error', __('messages.Please login to access your dashboard'));
        }

        return redirect()->route('web.login')->with('error', __('messages.Please login to access your dashboard'));
    }
}
