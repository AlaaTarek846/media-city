<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Department;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Product;
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
            $view->with('contactUs', ContactUs::first());
            
            // Get 4 products with discounts for deal-box modal
            $dealProducts = Product::where('status', 1)
                ->whereHas('variants', function($query) {
                    $query->where('discount_percentage', '>', 0)
                          ->where('status', 1);
                })
                ->with([
                    'translation',
                    'variants' => function($query) {
                        $query->where('discount_percentage', '>', 0)
                              ->where('status', 1)
                              ->orderBy('discount_percentage', 'desc')
                              ->limit(1);
                    }
                ])
                ->limit(4)
                ->get();
            
            $view->with('dealProducts', $dealProducts);
            
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
