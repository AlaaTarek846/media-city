<?php

use App\Http\Controllers\Dashboard\AboutUsController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AreaController;
use App\Http\Controllers\Dashboard\AuthDashboardController;
use App\Http\Controllers\Dashboard\BackupController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\Dashboard\ContactUsController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\DashboardStatisticsController;
use App\Http\Controllers\Dashboard\DiscountCouponController;
use App\Http\Controllers\Dashboard\FrequentlyAskedQuestionController;
use App\Http\Controllers\Dashboard\HistoryController;
use App\Http\Controllers\Dashboard\JoinUsController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\MissionController;
use App\Http\Controllers\Dashboard\NewsController;
use App\Http\Controllers\Dashboard\NewsletterController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SendNotificationController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\TestimonialController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProductAttributeController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ReturnPolicyController;
use App\Http\Controllers\Dashboard\ShippingInformationController;
use App\Http\Controllers\Dashboard\ShopByInstagramController;
use App\Http\Controllers\Dashboard\TeamController;
use App\Http\Controllers\Dashboard\VisionController;
use App\Http\Controllers\Web\HomePageController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Middleware\ChangeLang;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:admin_api');


Route::group(['prefix' => 'web', 'middleware' => [ChangeLang::class,StartSession::class,EncryptCookies::class]], function () {

    Route::get('categories-of-participation',[RegisterController::class,'getCategoriesOfParticipation']);
    Route::get('areas',[RegisterController::class,'getAreas']);
    Route::get('countries',[RegisterController::class,'getCountries']);
    Route::get('how-you-know-about-us',[RegisterController::class,'howDidYouKnowAboutUs']);
    Route::post('register',[RegisterController::class,'register'])->middleware(['guest:user']);
    Route::post('complete-register',[RegisterController::class,'completeRegister'])->middleware(['auth:user']);
    Route::post('contact-us',[HomePageController::class,'contactUsForm']);
    Route::post('login',[RegisterController::class,'loginForm'])->middleware(['guest:user','throttle:login']);
     Route::get('/show-product/{id}', [HomePageController::class, 'showProduct']);
     Route::post('/add-favorite/{id}', [HomePageController::class, 'addFavorite'])->middleware('auth:user');
     Route::post('/proceed-to-checkout', [HomePageController::class, 'proceedToCheckout'])->middleware('auth:user');
     Route::post('/check-coupon', [HomePageController::class, 'checkCoupon'])->middleware('auth:user');
     Route::get('/user-addresses', [HomePageController::class, 'getUserAddresses'])->middleware('auth:user');
     Route::post('/add-address', [HomePageController::class, 'addAddress'])->middleware('auth:user');
     Route::put('/edit-address/{id}', [HomePageController::class, 'editAddress'])->middleware('auth:user');
     Route::delete('/remove-address/{id}', [HomePageController::class, 'removeAddress'])->middleware('auth:user');
     Route::delete('/remove-item-from-shopping-cart/{id}', [HomePageController::class, 'removeItemFromShoppingCart'])->middleware('auth:user');
     Route::post('/make-order', [HomePageController::class, 'makeOrder'])->middleware('auth:user');
     Route::post('/add-review', [HomePageController::class, 'addReview'])->middleware('auth:user');
     Route::post('/toggle-review-like/{id}', [HomePageController::class, 'toggleReviewLike'])->middleware('auth:user');
     Route::post('/updateProfile', [HomePageController::class, 'updateProfile'])->middleware('auth:user');

     Route::post('/add-cart', [HomePageController::class, 'addCart'])->middleware('auth:user');
    // Route::get('terms',[WebPagesController::class,'terms']);
    // Route::get('privacy',[WebPagesController::class,'privacy']);
});

Route::group(['prefix' => 'dashboard', 'middleware' => [ChangeLang::class]], function () {

    // start Dashboard auth
    Route::group(['prefix' => 'auth'], function () {

        Route::post('login',[AuthDashboardController::class, 'login']);

        Route::post('checkToken', [AuthDashboardController::class,'authorizeUser']);

    });

    Route::get('get-language', [SettingController::class,'getLanguage']);

    // areas
    Route::get('areas/dropdown',[AreaController::class,'dropdown']);

    Route::group(['middleware' => 'auth:admin_api'], function () {

        Route::apiResource('banners', BannerController::class);

        // country
        Route::get('countries/dropdown',[CountryController::class,'dropdown']);
        Route::apiResource('countries', CountryController::class);

        // ProductAttribute
        Route::get('product-attributes-dropdown',[ProductAttributeController::class,'dropdown']);
        Route::apiResource('product-attributes', ProductAttributeController::class);

        Route::post('logout', [AuthDashboardController::class,'logout']);

        Route::resource('roles', RoleController::class);

        Route::resource('admins', AdminController::class);
        Route::get('all_roles', [AdminController::class,'all_roles']);

        Route::apiResource('settings', SettingController::class);
        Route::apiResource('return-policy', ReturnPolicyController::class);
        Route::apiResource('shipping-information', ShippingInformationController::class);

        // backup
        Route::apiResource('backup', BackupController::class);

        // areas
        Route::apiResource('areas', AreaController::class);

        // discount coupons
        Route::apiResource('discount-coupon', DiscountCouponController::class);

        //statistics
        Route::get('statistics',[DashboardStatisticsController::class,'index']);
        Route::get('get-total-revenue-per-months',[DashboardStatisticsController::class,'getTotalRevenuePerMonths']);
        Route::get('get-total-revenue-for-each-year-per-months',[DashboardStatisticsController::class,'getTotalRevenueForEachYearPerMonths']);

        Route::apiResource('frequently-asked-questions', FrequentlyAskedQuestionController::class);

        // Category
        Route::get('categories-dropdown',[CategoryController::class,'dropdown']);
        Route::apiResource('category', CategoryController::class);

        // JoinUs
        Route::apiResource('join-us', JoinUsController::class);

        // JoinUs
        Route::apiResource('shop-by-instagram', ShopByInstagramController::class);

        // testimonial
        Route::apiResource('testimonial', TestimonialController::class);

        // brand
         Route::get('brands-dropdown',[BrandController::class,'dropdown']);
        Route::apiResource('brand', BrandController::class);

        // product
        Route::apiResource('products', ProductController::class);

        // news
        Route::apiResource('news', NewsController::class);

        // contact-us
        Route::apiResource('contact-us', ContactUsController::class);

        // contact-message
        Route::apiResource('contact-message', ContactMessageController::class);

        // newsletter
        Route::apiResource('newsletter', NewsletterController::class);

        // about-us
        Route::apiResource('about-us', AboutUsController::class);

        // vision
        Route::apiResource('vision', VisionController::class);

        // team
        Route::apiResource('team', TeamController::class);

        // Language resource
        Route::resource('language', LanguageController::class);

        // user
        Route::resource('user', UserController::class);

        // order
        Route::resource('order', OrderController::class);
        Route::get('orderStatus',[OrderController::class,'orderStatus']);

        Route::controller(NotificationController::class)->group(function () {
            Route::get('getAllNot', 'getAllNot');
            Route::get('getNotNotRead', 'getNotNotRead');
            Route::post('clearItem/{id}', 'clearItem');
            Route::post('getNotNotRead', 'clearAll');
        });

        Route::put('update-admin-profile', [ProfileController::class,'updateAdminProfile']);

        Route::post('send-notification', [SendNotificationController::class, 'sendNotification']);

    });

});

