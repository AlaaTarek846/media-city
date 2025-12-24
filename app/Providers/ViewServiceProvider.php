<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (auth('user')->check()) {
                $user = auth('user')->user();
                $carts = $user->carts ?? [];
                $favorite_count = method_exists($user, 'favorites') ? $user->favorites()->count() : 0;
                
            } else {
                $carts = session()->get('carts', []);
                $favorite_count = 0;
            }
            $view->with('carts', $carts);
            $view->with('favorite_count', $favorite_count);
            $view->with('setting', Setting::with('translation')->first());
        });
    }
}
