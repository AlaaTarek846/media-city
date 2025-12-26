

<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Web\HomePageController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Middleware\ChangeLangForWeb;
use Illuminate\Support\Facades\Route;

Route::get('change-language/{locale}', [LanguageController::class, 'changeLanguage'])->name('change.language');

// Dashboard admin
Route::group(['middleware' => [ChangeLangForWeb::class]], function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('{any}', function ($any) {
            return view('welcome');
        })->where('any', '^(?!api\/).*$');

    });
    Route::get('/login', [RegisterController::class, 'login'])->middleware('guest:user');
    Route::get('/register', [RegisterController::class, 'index'])->middleware('guest:user');
    Route::post('/logout', [RegisterController::class, 'logout'])->middleware('auth:user')->name('web.logout');
    Route::get('/forgot', [RegisterController::class, 'forgot']);

    Route::get('/profile', [RegisterController::class, 'profile'])->middleware('auth:user')->name('web.profile');
    Route::get('/account-orders', [HomePageController::class, 'accountOrders'])->middleware('auth:user');
    Route::get('/account-wishlist', [HomePageController::class, 'accountWishlist'])->middleware('auth:user');
    Route::get('/account-addresses', [HomePageController::class, 'accountAddresses'])->middleware('auth:user');

    Route::get('/', [HomePageController::class, 'index'])->name('web.home');
    Route::post('/newsletter', [HomePageController::class, 'newsletter'])->name('web.newsletter');
    Route::get('/show-product/{id}', [HomePageController::class, 'showProduct']);
    Route::delete('/cart-destroy/{id}', [HomePageController::class, 'removeItemFromCart'])->name('cart.destroy');

    Route::get('/blogs', [HomePageController::class, 'blog'])->name('blog');
    Route::get('/blog-details/{slug}', [HomePageController::class, 'blogDetails'])->name('blog-details');

    Route::get('/best-seller', [HomePageController::class, 'bestSeller'])->name('best-seller');

    Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');
    Route::get('/about-us', [HomePageController::class, 'aboutUs'])->name('about-us');
    Route::get('/shopping-cart', [HomePageController::class, 'shoppingCart'])->middleware('auth:user');
    Route::get('/checkout', [HomePageController::class, 'checkout'])->middleware('auth:user');
//    Route::get('/wishlist', [HomePageController::class, 'wishlist'])->middleware('auth:user');
    Route::get('/wishlist', [HomePageController::class, 'wishlist'])->name('wishlist');
    Route::get('/checkout-thankyou', [HomePageController::class, 'checkoutThankyou'])->middleware('auth:user');
    Route::get('/product-detail/{id}', [HomePageController::class, 'productDetail'])->name('productDetail');
    Route::get('/shop', [HomePageController::class, 'shop'])->name('shop');
    Route::get('/renting', [HomePageController::class, 'renting'])->name('renting');

    Route::get('/category', [HomePageController::class, 'category']);

    Route::get('/shipping-details', [HomePageController::class, 'shippingDetails']);

    Route::get('{any}', [HomePageController::class, 'index'])->where('any', '^(?!api\/).*$');

});



// <?php

// use Illuminate\Support\Facades\Route;

// // Dashboard admin

// Route::domain(env('DOMAIN'))->group(function () {

//     Route::get('/', function () {
//         return view('welcome');
//     });

//     Route::get('{any}', function ($any) {
//         return view('welcome');
//     })->where('any', '^(?!api\/).*$');

// });


