<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ContactUsRequest;
use App\Http\Requests\Website\CouponRequest;
use App\Http\Requests\Website\ProceedToCheckoutRequest;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\ContactUs;
use App\Models\News;
use App\Models\Article;
use App\Models\ArticleSlugRedirect;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ShopByInstagram;
use App\Models\Team;
use App\Models\Cart;
use App\Models\DiscountCoupon;
use App\Models\ProductAttributeValue;
use App\Models\Address;
use App\Models\Area;
use App\Models\ReturnPolicy;
use App\Models\Setting;
use App\Models\ShippingInformation;
use App\Models\Department;
use App\Http\Requests\Website\AddAddressRequest;
use App\Http\Requests\Website\ChangePasswordRequest;
use App\Http\Requests\Website\UpdateProfileRequest;
use App\Models\PersonProfile;
use App\Models\CompanyProfile;
use App\Models\StudioProfile;
use App\Models\TermsCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{

    public function index(Request $request)
    {
        $banners  =  Banner::latest()->get();
        $categories = Category::whereStatus(1)
            ->withCount('products')
            ->latest()
            ->get();
        $brands = Brand::whereStatus(1)->latest()->get();
        $shopInstagram = ShopByInstagram::all();

        $newArrivals = Product::whereStatus(1)
            ->with(['variants', 'translation'])
            ->latest()
            ->take(8)
            ->get();
        $bestSellers = Product::whereStatus(1)->with(['variants', 'translation'])
            ->latest()
            ->take(8)
            ->get();

        $trending = Product::whereStatus(1)->with(['variants', 'translation'])
            ->latest()
            ->take(8)
            ->get();

        $offers = Product::whereStatus(1)->with(['variants', 'translation'])
            ->latest()
            ->take(8)
            ->get();

        $justForYouProducts = Product::whereStatus(1)
            ->whereHas('variants', function ($query) {
            $query->where('discount_percentage', '>', 0);
            })
            ->with(['variants' => function ($query) {
                $query->where('discount_percentage', '>', 0)->orderByDesc('discount_percentage')->limit(1);
            }])
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('website.home',compact('banners','brands','categories','shopInstagram','newArrivals','bestSellers','trending','offers','justForYouProducts'));
    }

    public function category()
    {
        $categories = Category::whereStatus(1)
            ->withCount('products')
            ->latest()
            ->get();
        return view('website.category', compact('categories'));
    }

    public function showProduct($id)
    {
        return response()->json([
            'status' => true,
            'message' => __('messages.Product details fetched successfully'),
            'data' => Product::with(['translation','variants', 'features', 'images', 'attributes.attribute.translation', 'category.translation', 'brand'])
                ->findOrFail($id)
        ]);
    }
    public function addCart(Request $request)
    {
        $user = auth('user')->user();
        $product = ProductVariant::findOrFail($request->variant_id);

        if ($product->status != 1) {
            return responseJson('', __('messages.Product is not available'), 404);
        }

        if ($request->quantity > $product->quantity) {
            return responseJson('', __('messages.Quantity exceeds available stock'), 400);
        }

        $cartItem = $user->carts()->where('product_variant_id', $request->variant_id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $user->carts()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'product_variant_id' => $request->variant_id,
                'price' => $product->price,
            ]);
        }

        if ($cartItem && $cartItem->quantity <= 0) {
            $cartItem->delete();
        }

        return responseJson('', __('messages.Product added to cart successfully'), 200);
    }

    public function removeItemFromCart($id)
    {
        $user = auth('user')->user();
        $cartItem = $user->carts()->findOrFail($id);
        $cartItem->delete();
        return redirect()->back()->with('success', __('messages.Item removed from cart successfully'));
    }

    public function addFavorite($id)
    {
        $user = auth('user')->user();

        if (!$user->favorites()->where('product_id', $id)->first()) {
            $user->favorites()->attach($id);
            return responseJson('', __('messages.Product added to favorites successfully'), 200);
        } else {
            $user->favorites()->detach($id);
            return responseJson('', __('messages.Product removed from favorites successfully'), 200);
        }
    }

    public function shippingDetails()
    {
        return view('website.shipping-details');
    }

    public function wishlist()
    {
        return view('website.wishlist');
    }

    public function shoppingCart()
    {
//        $user = auth('user')->user();
//        $cartItems = $user->carts()->with(['productVariant', 'productVariant.product','productVariant.product.translation'])->get();
        return view('website.shopping-cart');
    }

    public function checkout()
    {
//        $user = auth('user')->user();
//        $cartItems = $user->carts()->with(['productVariant', 'productVariant.product','productVariant.product.translation'])->get();
        return view('website.checkout');
    }

    public function proceedToCheckout(ProceedToCheckoutRequest $request)
    {
        $data = $request->validated();

        foreach ($data['cart'] as $index => $item) {
            $cartItem = Cart::findOrFail($item['id']);

            if ($item['quantity'] > $cartItem->productVariant->quantity) {
                $errors['products.' . $index . '.quantity'][] = trans('messages.There_is_no_quantity_available_in_stock');
                return responseJson(['errors' => $errors], __('messages.Invalid coupon code'), 422);
            }
        }

        foreach ($data['cart'] as $item) {
            $cartItem = Cart::findOrFail($item['id']);
            $cartItem->update(['quantity' => $item['quantity']]);
        }

        return responseJson('', __('messages.The shopping cart has been successfully reviewed and is being transferred to payment'), 200);
    }

    public function checkCoupon(CouponRequest $request)
    {
        $data = $request->validated();

        $coupon = DiscountCoupon::where('code', $data['code'])->first();

        if (!$coupon) {
            return responseJson('', __('messages.Invalid coupon code'), 400);
        }

        $user = auth('user')->user();
        $cartItems = $user->carts;

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        if ($totalAmount < $coupon->greater_than) {
            return responseJson('', __('messages.Minimum amount not met for coupon'), 400);
        }
        if ($coupon->start_date > now()){
            return responseJson('', __('messages.This coupon has not started yet'), 400);
        }

        if ($coupon->expire_date < now() || $coupon->status == 0 || $coupon->user_count <= $coupon->orders()->count()) {
            return responseJson('', __('messages.This coupon has expired'), 400);
        }
        if ($coupon->type == 'fixed') {
            $discountAmount = $coupon->value;
        } else {
            if ($coupon->value < 0 || $coupon->value > 100) {
                return responseJson('', __('messages.Invalid discount percentage'), 400);
            }
            $discountAmount = ($totalAmount * $coupon->value) / 100;
        }

        $shippingCost = Setting::first()->shipping_price;
        $tax_percentage = Setting::first()->tax_percentage;
        $tax = ($totalAmount * $tax_percentage) / 100;
        $totalAmount += $shippingCost;


        return responseJson([
            'discount_amount' => $discountAmount,
            'new_total' => $totalAmount - $discountAmount + $tax,
            'coupon' => $coupon
        ], __('messages.Coupon applied successfully'), 200);
    }

    public function checkoutThankyou(Request $request)
    {
        $order = auth('user')->user()->orders()->where('order_number', $request->order_number)->firstOrFail();
        $products = Product::whereStatus(1)
            ->with(['variants', 'translation'])
            ->inRandomOrder()
            ->take(8)
            ->get();
        return view('website.checkout-thankyou', compact('order', 'products'));
    }

    public function productDetail($id)
    {
        $product = Product::
        with(['translation','variants', 'features.translation', 'images', 'attributes.attribute.translation', 'category.translation', 'brand.translation','reviews.user'])
        ->whereHas('translations',function ($q) use($id){
            $q->where('slug',$id);
        })->firstOrFail();
        $products = Product::whereStatus(1)->where('category_id', $product->category_id)->where('id', '!=', $product->id)
            ->with(['variants', 'translation'])
            ->inRandomOrder()
            ->take(8)
            ->get();
        $return_policy = ReturnPolicy::with(['translation'])->first();
        $shipping_information = ShippingInformation::with(['translation'])->first();

        // Get percentage of rating in Product
        $totalReviews = $product->reviews()->count();

        // Calculate percentage for each rating (1-5)
        $rating_percentage = [];
        for ($rate = 1; $rate <= 5; $rate++) {
            $count = $product->reviews()->where('rating', $rate)->count();
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 2) : 0;
            $rating_percentage[] = [
            'rate' => $rate,
            'percentage' => $percentage
            ];
        }

        return view('website.product-detail', compact('product', 'products', 'return_policy', 'shipping_information', 'rating_percentage'));
    }

    public function rentDetail($id)
    {
        return view('website.rent-detail');
    }

    public function aboutUs(Request $request)
    {
        // جلب بيانات About Us مع العلاقات والترجمات
        // التأكد من جلب الترجمة الحالية بناءً على locale المحدد
        $aboutUs = AboutUs::with([
            'translation', // ترجمة AboutUs الرئيسية للـ locale الحالي
            'translations', // جميع الترجمات (fallback)
            'features' => function($query) {
                $query->with(['translation', 'translations']); // ترجمة كل feature + جميع الترجمات
            },
            'statistics' => function($query) {
                $query->with(['translation', 'translations']); // ترجمة كل statistic + جميع الترجمات
            }
        ])->first();

        // جلب بيانات إضافية (إذا كانت مطلوبة في الصفحة)
        $brands = Brand::whereStatus(1)->with('translation')->latest()->get();
        $teams = Team::with('translation')->latest()->get();

        return view('website.about-us', compact('aboutUs', 'teams', 'brands'));
    }

    public function termsCondition(Request $request)
    {
        // جلب بيانات Terms & Conditions مع الترجمة الحالية
        $termsCondition = TermsCondition::with(['translation', 'translations'])->first();

        return view('website.terms-condition', compact('termsCondition'));
    }

     /**
      * Display shop page with products filtered by department and/or category slugs
      *
      * Supports SEO-friendly URLs: /shop/{department-slug}/{category-slug}
      * Also supports legacy query parameters for backward compatibility
      *
      * @param Request $request
      * @param string|null $department Department slug from route
      * @param string|null $category Category slug from route
      * @return \Illuminate\View\View
      */
     public function shop(Request $request, $department = null, $category = null){
        // Get department and category IDs from slugs if provided
        // Slug is generated from title using Str::slug()
        $departmentId = null;

        if ($department) {
            // Find department by comparing slug of translation title with provided slug
            $departments = Department::with('translations')->get();
            foreach ($departments as $dept) {
                if (strtolower($dept->slug) === strtolower($department)) {
                    $departmentId = $dept->id;
                    break;
                }
            }
        }

        // Get all categories for sidebar (filtered by department if provided)
        $categoriesQuery = Category::whereStatus(1)->withCount(['products' => function($q) use ($departmentId) {
            $q->where('department_id', $departmentId);
        }]);

        if ($departmentId) {
            $categoriesQuery->whereHas('departments', function($q) use ($departmentId) {
                $q->where('departments.id', $departmentId);
            });
        }

        $categories = $categoriesQuery->latest()->get();

        $brands = Brand::whereStatus(1)->latest()->get();

        return view('website.shop', compact(
            'categories',
            'brands'
        ));
    }

    /**
     * Get product data for quick view modal
     *
     * @param int $id Product ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductForModal($id)
    {
        $product = Product::where('products.status', 1)
            ->with([
                'translation',
                'translations',
                'variants',
                'images',
                'category.translation',
                'category.translations',
                'brand.translation',
                'brand.translations',
                'department.translation',
                'department.translations',
                'features.translation',
                'features.translations'
            ])
            ->findOrFail($id);

        $translation = $product->translation ?? $product->translations->first();
        $variant = $product->variants->first();
        $category = $product->category;
        $brand = $product->brand;
        $department = $product->department;
        $feature = $product->features;

        // Format product images for slider
        $images = $product->images->map(function($image) {
            return [
                'id' => $image->id,
                'url' => $image->image,
                'alt' => $image->alt ?? ''
            ];
        });

        // If no images, use main product image
        if ($images->isEmpty()) {
            $images->push([
                'id' => 0,
                'url' => $product->image,
                'alt' => $translation->title ?? ''
            ]);
        }

        // Calculate rating
        $reviews = $product->reviews;
        $rating = $reviews->avg('rating') ?? 0;
        $reviewCount = $reviews->count();

        return responseJson([
            'id' => $product->id,
            'title' => $translation->title ?? '',
            'description' => $translation->description ?? '',
            'slug' => $translation->slug,
            'condition' => $product->condition,
            'images' => $images,
            'price' => $variant->price ?? 0,
            'discount_price' => $variant->discount_price ?? null,
            'discount_percentage' => $variant->discount_percentage ?? 0,
            'price_before_discount' => $variant->price_before_discount ?? 0,
            'sku' => $variant->sku ?? '',
            'quantity' => $variant->quantity ?? 0,
            'category' => [
                'id' => $category->id ?? null,
                'name' => $category->translation->title ?? ($category->translations->first()->title ?? ''),
            ],
            'brand' => [
                'id' => $brand->id ?? null,
                'name' => $brand->translation->title ?? ($brand->translations->first()->title ?? ''),
            ],
            'department' => [
                'id' => $department->id ?? null,
                'name' => $department->translation->title ?? ($department->translations->first()->title ?? ''),
            ],
            'feature' => $feature ? [
                'title' => $feature->translation->title ?? ($feature->translations->first()->title ?? ''),
                'description' => $feature->translation->description ?? ($feature->translations->first()->description ?? ''),
            ] : null,
            'rating' => round($rating, 1),
            'review_count' => $reviewCount,
            'detail_url' => route('productDetail', $translation->slug),
        ], 'Product data fetched successfully', 200);
    }

    /**
     * Get shop products via AJAX with filters
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShopProducts(Request $request)
    {
        $departmentId = null;
        $categoryId = null;

        // Get department from slug
        if ($request->department) {
            $departments = Department::with('translations')->get();
            foreach ($departments as $dept) {
                if (strtolower($dept->slug) === strtolower($request->department)) {
                    $departmentId = $dept->id;
                    break;
                }
            }
        }

        // Get category from slug
        if ($request->category) {
            $categories = Category::whereStatus(1)->with('translations')->get();
            foreach ($categories as $cat) {
                if (strtolower($cat->slug) === strtolower($request->category)) {
                    $categoryId = $cat->id;
                    break;
                }
            }
        }

        // Build products query
        // Use products.status explicitly to avoid ambiguity when joining with other tables
        $productsQuery = Product::where('products.status', 1)
            ->with(['variants', 'translation', 'department', 'category', 'brand']);

        // Filter by department
        if ($departmentId) {
            $productsQuery->where('department_id', $departmentId);
        } elseif ($request->department_id) {
            $productsQuery->where('department_id', $request->department_id);
        }

        // Filter by category
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        } elseif ($request->category_id) {
            $productsQuery->where('category_id', $request->category_id);
        }

        // Filter by multiple categories
        if ($request->categories && is_array($request->categories)) {
            $productsQuery->whereIn('category_id', $request->categories);
        }

        // Filter by condition (new, used, rent)
        if ($request->condition) {
            $productsQuery->where('condition', $request->condition);
        }

        // Filter by brands
        if ($request->brands && is_array($request->brands)) {
            $productsQuery->whereIn('brand_id', $request->brands);
        }

        // Search filter
        if ($request->search) {
            $search = $request->search;
            $productsQuery->whereHas('translations', function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }


        // Attribute filter
        if ($request->attribute && is_array($request->attribute)) {
            $productsQuery->whereHas('variants', function ($q) use ($request) {
                    foreach ($request->attribute as $attrId => $value) {
                        $q->where('attribute_values', 'LIKE', '%' . $value . '%')
                        ->orWhere('attribute_values', 'LIKE', '%' . strrev($value) . '%');
                    }
                });
        }

        // Sort by
        $sortBy = $request->sort_by ?? 'latest';
        $locale = app()->getLocale();

        switch ($sortBy) {
            case 'price_low':
                // Sort by minimum variant price
                $productsQuery->select('products.*')
                    ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->selectRaw('MIN(product_variants.price) as variant_min_price')
                    ->groupBy('products.id')
                    ->orderBy('variant_min_price', 'asc');
                break;
            case 'price_high':
                // Sort by maximum variant price
                $productsQuery->select('products.*')
                    ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->selectRaw('MAX(product_variants.price) as variant_max_price')
                    ->groupBy('products.id')
                    ->orderBy('variant_max_price', 'desc');
                break;
            case 'name_asc':
                // Sort by translation title
                $productsQuery->select('products.*')
                    ->leftJoin('sys_language_translations', function($join) use ($locale) {
                        $join->on('products.id', '=', 'sys_language_translations.model_id')
                             ->where('sys_language_translations.model_type', '=', 'App\\Models\\Product')
                             ->where('sys_language_translations.locale', '=', $locale);
                    })
                    ->groupBy('products.id', 'sys_language_translations.title')
                    ->orderBy('sys_language_translations.title', 'asc');
                break;
            case 'name_desc':
                // Sort by translation title desc
                $productsQuery->select('products.*')
                    ->leftJoin('sys_language_translations', function($join) use ($locale) {
                        $join->on('products.id', '=', 'sys_language_translations.model_id')
                             ->where('sys_language_translations.model_type', '=', 'App\\Models\\Product')
                             ->where('sys_language_translations.locale', '=', $locale);
                    })
                    ->groupBy('products.id', 'sys_language_translations.title')
                    ->orderBy('sys_language_translations.title', 'desc');
                break;
            default:
                $productsQuery->latest();
        }

        $perPage = $request->per_page ?? 12;
        $products = $productsQuery->paginate($perPage);

        // Format products data
        $formattedProducts = $products->getCollection()->map(function($product) {
            $translation = $product->translation ?? $product->translations->first();
            $department = $product->department;
            $category = $product->category;
            $brand = $product->brand;
            $variant = $product->variants->first();

            return [
                'id' => $product->id,
                'title' => $translation->title ?? '',
                'description' => $translation->description ?? '',
                'image' => $product->image,
                'slug' => $translation->slug,
                'condition' => $product->condition, // new, used, rent
                'department' => [
                    'id' => $department->id ?? null,
                    'name' => $department->translation->title ?? ($department->translations->first()->title ?? ''),
                    'slug' => $department->slug ?? '',
                ],
                'category' => [
                    'id' => $category->id ?? null,
                    'name' => $category->translation->title ?? ($category->translations->first()->title ?? ''),
                    'slug' => $category->slug ?? '',
                ],
                'brand' => $brand ? [
                    'id' => $brand->id,
                    'name' => $brand->translation->title ?? ($brand->translations->first()->title ?? ''),
                ] : null,
                'price' => $variant->price ?? 0,
                'discount_price' => $variant->discount_price ?? null,
                'discount_percentage' => $variant->discount_percentage ?? 0,
                'is_favorite' => $product->is_favorite,
                'rate' => $product->rate,
                'review_count' => $product->review_count,
            ];
        });

        return responseJson([
            'products' => $formattedProducts,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
        ], 'Products fetched successfully', 200);
    }

    /**
     * Display blog listing page with paginated articles
     *
     * جلب المقالات المنشورة مع الترجمات والعلاقات وعرضها بصفحة المدونة
     */
    public function blog(){
        // Get published articles only, ordered by latest, with translations and category
        $articles = Article::where('status', 1)
            ->with(['translation', 'category.translation'])
            ->latest()
            ->paginate(4);

        return view('website.blog', compact('articles'));
    }

    /**
     * Display single article details page by slug
     *
     * عرض تفاصيل المقال بناءً على slug مع دعم إعادة التوجيه للـ slugs القديمة
     */
    public function blogDetails($slug){
        $locale = app()->getLocale();

        // First, check if there's a redirect for this slug
        $redirect = ArticleSlugRedirect::where('old_slug', $slug)
            ->where('locale', $locale)
            ->first();

        if ($redirect) {
            // Redirect to new slug with 301 (permanent redirect for SEO)
            return redirect()->route('blog-details', $redirect->new_slug, 301);
        }

        // Find article by slug in current locale
        $article = Article::where('status', 1)
            ->whereHas('translations', function($query) use ($slug, $locale) {
                $query->where('slug', $slug)->where('locale', $locale);
            })
            ->with(['translation', 'category.translation', 'tags'])
            ->firstOrFail();

        // Get related articles (same category, excluding current article)
        $relatedArticles = Article::where('status', 1)
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with(['translation', 'category.translation'])
            ->latest()
            ->take(3)
            ->get();

        return view('website.blog-details', compact('article', 'relatedArticles'));
    }

    public function accountAddresses(){
        return view('website.account-addresses');
    }

    public function contact(){
        $contactUs = ContactUs::first();
        return view('website.contact',compact('contactUs'));
    }

    public function contactUsForm(ContactUsRequest $request){
        ContactMessage::create($request->validated());
        return responseJson('',__('messages.Thanks for contacting us, we will get back to you soon'),200);
    }

    public function bestSeller()
    {
        return view('website.best-seller');
    }
   public function renting()
    {
        return view('website.renting');
    }

    public function userDashboard()
    {
        $user = auth('user')->user();
        // Load user with all profile relationships
        $user->load('personProfile', 'companyProfile', 'studioProfile');
        $areas = Area::whereStatus(1)->latest()->get();
        return view('website.user-dashboard', compact('user', 'areas'));
    }

    /**
     * Get user addresses via API
     *
     * Returns all addresses for the authenticated user
     */
    public function getUserAddresses()
    {
        $user = auth('user')->user();
        $addresses = $user->addresses()->with('area')->latest()->get();
        return responseJson($addresses, __('messages.Addresses fetched successfully'), 200);
    }

    /**
     * Add a new address for the authenticated user
     *
     * Validates address data and saves it with user_id
     * Supports Google Maps lat/lng coordinates
     */
    public function addAddress(AddAddressRequest $request)
    {
        try {
            $user = auth('user')->user();

            // If this is set as primary, unset other primary addresses
            if ($request->boolean('is_primary')) {
                $user->addresses()->update(['is_primary' => false]);
            }

            // Create address with user_id
            $address = $user->addresses()->create([
                'name' => $request->name,
                'title' => $request->title,
                'address' => $request->address,
                'area_id' => $request->area_id,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'is_primary' => $request->boolean('is_primary', false),
            ]);

            return responseJson($address, __('messages.Address added successfully'), 200);
        } catch (\Exception $e) {
            return responseJson(null, __('messages.An error occurred while adding the address'), 500);
        }
    }

    /**
     * Update an existing address
     *
     * Validates and updates address data
     */
    public function editAddress(AddAddressRequest $request, $id)
    {
        try {
            $user = auth('user')->user();
            $address = $user->addresses()->findOrFail($id);

            // If this is set as primary, unset other primary addresses
            if ($request->boolean('is_primary')) {
                $user->addresses()->where('id', '!=', $id)->update(['is_primary' => false]);
            }

            $address->update([
                'name' => $request->name,
                'title' => $request->title,
                'address' => $request->address,
                'area_id' => $request->area_id,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'is_primary' => $request->boolean('is_primary', false),
            ]);

            return responseJson($address, __('messages.Address updated successfully'), 200);
        } catch (\Exception $e) {
            return responseJson(null, __('messages.An error occurred while updating the address'), 500);
        }
    }

    /**
     * Delete an address
     *
     * Soft deletes the address (uses softDeletes)
     */
    public function removeAddress($id)
    {
        try {
            $user = auth('user')->user();
            $address = $user->addresses()->findOrFail($id);
            $address->delete();

            return responseJson(null, __('messages.Address removed successfully'), 200);
        } catch (\Exception $e) {
            return responseJson(null, __('messages.An error occurred while removing the address'), 500);
        }
    }

    /**
     * Change user password
     *
     * Validates current password and updates to new password
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $user = auth('user')->user();

            // Update password
            $user->password = Hash::make($request->password);
            $user->save();

            return responseJson($user, __('messages.Password changed successfully'), 200);
        } catch (\Exception $e) {
            return responseJson(null, __('messages.An error occurred while changing password'), 500);
        }
    }

    /**
     * Update user profile
     *
     * Updates user basic information and profile-specific data based on user_type
     * Handles file uploads for documents
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = auth('user')->user();
            $userType = $user->user_type;

            // Update user basic information
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->whatsapp = $request->whatsapp;
            $user->link = $request->link;
            $user->save();

            // Initialize profile data array
            $profileData = [];

            // Handle file uploads and profile data based on user type
            switch ($userType) {
                case 'person':
                    $profile = $user->personProfile;
                    if (!$profile) {
                        $profile = PersonProfile::create(['user_id' => $user->id]);
                    }

                    // Handle ID card front upload
                    if ($request->hasFile('id_card_front')) {
                        // Delete old file if exists
                        if ($profile->id_card_front) {
                            unlink_image_by_path($profile->id_card_front);
                        }
                        $profileData['id_card_front'] = store_single_image($request->file('id_card_front'), 'person_profiles/');
                    }

                    // Handle ID card back upload
                    if ($request->hasFile('id_card_back')) {
                        // Delete old file if exists
                        if ($profile->id_card_back) {
                            unlink_image_by_path($profile->id_card_back);
                        }
                        $profileData['id_card_back'] = store_single_image($request->file('id_card_back'), 'person_profiles/');
                    }

                    // Update profile if there's data to update
                    if (!empty($profileData)) {
                        $profile->update($profileData);
                    }
                    break;

                case 'company':
                    $profile = $user->companyProfile;
                    if (!$profile) {
                        $profile = CompanyProfile::create(['user_id' => $user->id]);
                    }

                    // Handle commercial register upload
                    if ($request->hasFile('commercial_register_image')) {
                        // Delete old file if exists
                        if ($profile->commercial_register_image) {
                            unlink_image_by_path($profile->commercial_register_image);
                        }
                        $profileData['commercial_register_image'] = store_single_image($request->file('commercial_register_image'), 'company_profiles/');
                    }

                    // Handle tax card upload
                    if ($request->hasFile('tax_card_image')) {
                        // Delete old file if exists
                        if ($profile->tax_card_image) {
                            unlink_image_by_path($profile->tax_card_image);
                        }
                        $profileData['tax_card_image'] = store_single_image($request->file('tax_card_image'), 'company_profiles/');
                    }

                    // Update profile if there's data to update
                    if (!empty($profileData)) {
                        $profile->update($profileData);
                    }
                    break;

                case 'studio':
                    $profile = $user->studioProfile;
                    if (!$profile) {
                        $profile = StudioProfile::create(['user_id' => $user->id]);
                    }

                    // Handle ID card front upload
                    if ($request->hasFile('id_card_front')) {
                        // Delete old file if exists
                        if ($profile->id_card_front) {
                            unlink_image_by_path($profile->id_card_front);
                        }
                        $profileData['id_card_front'] = store_single_image($request->file('id_card_front'), 'studio_profiles/');
                    }

                    // Handle ID card back upload
                    if ($request->hasFile('id_card_back')) {
                        // Delete old file if exists
                        if ($profile->id_card_back) {
                            unlink_image_by_path($profile->id_card_back);
                        }
                        $profileData['id_card_back'] = store_single_image($request->file('id_card_back'), 'studio_profiles/');
                    }

                    // Update profile if there's data to update
                    if (!empty($profileData)) {
                        $profile->update($profileData);
                    }
                    break;
            }

            DB::commit();

            // Reload user with relationships
            $user->load('personProfile', 'companyProfile', 'studioProfile');

            // Prepare response data with formatted URLs
            $responseData = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'whatsapp' => $user->whatsapp,
                    'link' => $user->link,
                    'user_type' => $user->user_type,
                    'status' => $user->status,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ],
                'profile' => null,
            ];

            // Add profile data based on user type with full image URLs
            switch ($userType) {
                case 'person':
                    if ($user->personProfile) {
                        $responseData['profile'] = [
                            'id' => $user->personProfile->id,
                            'id_card_front' => $user->personProfile->id_card_front ? asset('upload/general/' . $user->personProfile->id_card_front) : null,
                            'id_card_back' => $user->personProfile->id_card_back ? asset('upload/general/' . $user->personProfile->id_card_back) : null,
                            'created_at' => $user->personProfile->created_at,
                            'updated_at' => $user->personProfile->updated_at,
                        ];
                    }
                    break;

                case 'company':
                    if ($user->companyProfile) {
                        $responseData['profile'] = [
                            'id' => $user->companyProfile->id,
                            'commercial_register_image' => $user->companyProfile->commercial_register_image ? asset('upload/general/' . $user->companyProfile->commercial_register_image) : null,
                            'tax_card_image' => $user->companyProfile->tax_card_image ? asset('upload/general/' . $user->companyProfile->tax_card_image) : null,
                            'created_at' => $user->companyProfile->created_at,
                            'updated_at' => $user->companyProfile->updated_at,
                        ];
                    }
                    break;

                case 'studio':
                    if ($user->studioProfile) {
                        $responseData['profile'] = [
                            'id' => $user->studioProfile->id,
                            'id_card_front' => $user->studioProfile->id_card_front ? asset('upload/general/' . $user->studioProfile->id_card_front) : null,
                            'id_card_back' => $user->studioProfile->id_card_back ? asset('upload/general/' . $user->studioProfile->id_card_back) : null,
                            'created_at' => $user->studioProfile->created_at,
                            'updated_at' => $user->studioProfile->updated_at,
                        ];
                    }
                    break;
            }

            return responseJson($responseData, __('messages.Profile updated successfully'), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(null, __('messages.An error occurred while updating profile') . ': ' . $e->getMessage(), 500);
        }
    }

}
