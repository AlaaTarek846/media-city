<?php

use App\Http\Controllers\Dashboard\AboutUsController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AreaController;
use App\Http\Controllers\Dashboard\ArticleCategoryController;
use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\AuthDashboardController;
use App\Http\Controllers\Dashboard\BackupController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\Dashboard\ContactUsController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\DashboardStatisticsController;
use App\Http\Controllers\Dashboard\DepartmentController;
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
use App\Http\Controllers\Web\CouponController;
use App\Http\Controllers\Web\OrderController as WebOrderController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SendNotificationController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\TestimonialController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProductAttributeController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ReturnPolicyController;
use App\Http\Controllers\Dashboard\TermsConditionController;
use App\Http\Controllers\Dashboard\ShippingInformationController;
use App\Http\Controllers\Dashboard\ShopByInstagramController;
use App\Http\Controllers\Dashboard\TeamController;
use App\Http\Controllers\Dashboard\VisionController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\FavoriteController;
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

    // Password Reset Routes
    Route::post('password/email',[RegisterController::class,'sendResetLinkEmail'])->middleware(['guest:user']);
    Route::get('password/reset',[RegisterController::class,'showResetForm'])->middleware(['guest:user'])->name('password.reset');
    Route::post('password/reset',[RegisterController::class,'reset'])->middleware(['guest:user']);

     Route::get('/show-product/{id}', [HomePageController::class, 'showProduct']);
     Route::get('/product-modal/{id}', [HomePageController::class, 'getProductForModal']); // AJAX endpoint for quick view modal
     Route::get('/shop-products', [HomePageController::class, 'getShopProducts']); // AJAX endpoint for shop filtering
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
     Route::post('/change-password', [HomePageController::class, 'changePassword'])->middleware('auth:user');

    // new
    Route::get('/get-favorites', [FavoriteController::class, 'index'])->middleware('auth:user');
    Route::post('/add-favorites', [FavoriteController::class, 'store'])->middleware('auth:user');
    Route::delete('/delete-favorite/{id}', [FavoriteController::class, 'destroy'])->middleware('auth:user');

    // Wishlist routes
    Route::post('/wishlist/add', [FavoriteController::class, 'addToWishlist'])->middleware('auth:user');
    Route::post('/wishlist/sync', [FavoriteController::class, 'syncWishlist'])->middleware('auth:user');
    Route::get('/wishlist/check/{productId}', [FavoriteController::class, 'checkWishlist'])->middleware('auth:user');
    Route::get('/wishlist/products', [FavoriteController::class, 'getWishlistProducts'])->middleware('auth:user');
    Route::post('/wishlist/products-by-ids', [FavoriteController::class, 'getProductsByIds']);

    Route::post('/add-order', [WebOrderController::class, 'store'])->middleware('auth:user');
    Route::post('/order/update-status/{id}', [WebOrderController::class, 'updateStatus'])->middleware('auth:user');
    Route::get('/order-details/{id}', [WebOrderController::class, 'orderDetails'])->middleware('auth:user');
    Route::post('/check-coupon-order', [CouponController::class, 'checkCoupon'])->middleware('auth:user');

    Route::get('/get-carts', [CartController::class, 'index'])->middleware('auth:user');
    Route::post('/add-carts', [CartController::class, 'store'])->middleware('auth:user');
    Route::post('/cart/add-single', [CartController::class, 'addSingleProduct'])->middleware('auth:user');
    Route::post('/cart/sync', [CartController::class, 'syncCart'])->middleware('auth:user');
    Route::get('/cart/items', [CartController::class, 'getCartItems'])->middleware('auth:user');
    Route::put('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity'])->middleware('auth:user');
    Route::delete('/delete-cart/{id}', [CartController::class, 'destroy'])->middleware('auth:user');    // Route::get('terms',[WebPagesController::class,'terms']);
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
        Route::apiResource('terms-condition', TermsConditionController::class);
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
        Route::get('get-peak-periods',[DashboardStatisticsController::class,'getPeakPeriods']);

        Route::apiResource('frequently-asked-questions', FrequentlyAskedQuestionController::class);

        // Category
        Route::get('categories-dropdown',[CategoryController::class,'dropdown']);
        Route::apiResource('category', CategoryController::class);

        // Department
        Route::get('departments-dropdown',[DepartmentController::class,'dropdown']);
        Route::apiResource('departments', DepartmentController::class);

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
        Route::post('contact-message/{id}/read', [ContactMessageController::class, 'markAsRead']);

        // newsletter
        Route::apiResource('newsletter', NewsletterController::class);

        // about-us
        Route::apiResource('about-us', AboutUsController::class);

        Route::apiResource('sliders', SliderController::class);

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
        Route::post('order/{id}/read',[OrderController::class,'markAsRead']);
        Route::get('order/unread-count',[OrderController::class,'getUnreadCount']);

        Route::controller(NotificationController::class)->group(function () {
            Route::get('getAllNot', 'getAllNot');
            Route::get('getNotNotRead', 'getNotNotRead');
            Route::post('clearItem/{id}', 'clearItem');
            Route::post('getNotNotRead', 'clearAll');

            // Contact Messages Notifications
            Route::get('notifications', 'getContactMessages');
            Route::post('notifications/{id}/read', 'markAsRead');
            Route::get('notifications/unread-count', 'getUnreadCount');
        });

        // Pusher Test Routes
        Route::post('test-pusher', [\App\Http\Controllers\Dashboard\PusherTestController::class, 'testPusher']);
        Route::post('test-pusher-private', [\App\Http\Controllers\Dashboard\PusherTestController::class, 'testPrivateChannel'])->middleware('auth:admin_api');

        // Contact Message Test Routes
        Route::post('test-contact-message', [\App\Http\Controllers\Dashboard\TestContactMessageController::class, 'testContactMessage'])->middleware('auth:admin_api');
        Route::get('test-notification-flow', [\App\Http\Controllers\Dashboard\TestNotificationController::class, 'testCompleteFlow'])->middleware('auth:admin_api');
        Route::get('test-all-messages', [\App\Http\Controllers\Dashboard\TestNotificationController::class, 'getAllMessages'])->middleware('auth:admin_api');
        Route::post('test-event-dispatch', [\App\Http\Controllers\Dashboard\TestNotificationController::class, 'testEventDispatch'])->middleware('auth:admin_api');

        Route::put('update-admin-profile', [ProfileController::class,'updateAdminProfile']);

        Route::post('send-notification', [SendNotificationController::class, 'sendNotification']);

        // article
        Route::get('articles/categories',[ArticleCategoryController::class,'dropdown']);
        Route::apiResource('articleCategory', ArticleCategoryController::class);
//        Route::get('articlesQueries', [ArticleController::class, 'articlesQueries']);
        Route::apiResource('articles', ArticleController::class);
        Route::get('articles/tags', [ArticleController::class, 'getTags']);
        Route::post('articles/tags', [ArticleController::class, 'createTag']);
        Route::get('articles/search', [ArticleController::class, 'search']);

    });

});

