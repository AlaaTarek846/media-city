<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Department;
use App\Models\Category;
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
     *
     * Share common data with all views including:
     * - User carts and favorites count
     * - Site settings
     * - Departments with their categories for header menu
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $view->with('setting', Setting::with('translation')->first());
            // Share Departments with Categories for header menu
            // Using eager loading to prevent N+1 queries
            $departments = Department::where('status', 1) // Only active departments
                ->with([
                    'categories' => function($query) {
                        $query->where('status', 1); // Only active categories
                    },
                    'translation' // Current locale translation for department
                ])
                ->whereHas('categories', function($query) {
                    $query->where('status', 1); // Only departments that have active categories
                })
                ->latest()
                ->get();

            $view->with('headerDepartments', $departments);
        });
    }
}
