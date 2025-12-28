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
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ShopByInstagram;
use App\Models\Team;
use App\Models\Vision;
use App\Models\Cart;
use App\Models\DiscountCoupon;
use App\Models\ProductAttributeValue;
use App\Models\ReturnPolicy;
use App\Models\Setting;
use App\Models\ShippingInformation;
use Illuminate\Http\Request;

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
//        $user = auth('user')->user();
//        $favorites = $user->favorites()->with(['variants', 'translation'])->get();
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
        $product = Product::with(['translation','variants', 'features.translation', 'images', 'attributes.attribute.translation', 'category.translation', 'brand.translation','reviews.user'])->findOrFail($id);
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
        $aboutUs = AboutUs::first();
        $vision = Vision::first();
        $brands = Brand::whereStatus(1)->latest()->get();
        $teams = Team::latest()->get();

        return view('website.about-us',compact('aboutUs','teams','vision','brands'));
    }

     public function shop(Request $request){
        $categories = Category::whereStatus(1)
            ->withCount('products')
            ->latest()
            ->get();
        $maxPrice = ProductVariant::max('price');
        $minPrice = ProductVariant::min('price');
        $attributes = [];

        $attributeValues = ProductAttributeValue::with('attribute')->get();

        foreach ($attributeValues as $value) {
            $attrName = $value->attribute->current_translation?->title ?? '';
            $attrId = $value->attribute->id;

            // Split options by comma and trim spaces
            $optionsArray = array_map('trim', explode(',', $value->options));

            // Find if attribute already exists in $attributes
            $found = false;
            foreach ($attributes as &$attribute) {
                if ($attribute['name'] === $attrName) {
                    // Merge and deduplicate options
                    $attribute['options'] = array_unique(array_merge($attribute['options'], $optionsArray));
                    $found = true;
                    break;
                }
            }
            unset($attribute);

            // If not found, add new attribute
            if (!$found) {
                $attributes[] = [
                    'id' => $attrId,
                    'name' => $attrName,
                    'options' => $optionsArray,
                ];
            }
        }

        $brands = Brand::whereStatus(1)->withCount('products')->latest()->get();

        $products = Product::whereStatus(1)
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->when($request->categories, function ($query) use ($request) {
                $query->whereIn('category_id', $request->categories);
            })
            ->when($request->min_price && $request->max_price, function ($query) use ($request) {
                $query->whereHas('variants', function ($q) use ($request) {
                    $q->whereBetween('price', [$request->min_price, $request->max_price]);
                });
            })
            ->when($request->attribute, function ($query) use ($request) {
                $query->whereHas('variants', function ($q) use ($request) {
                    foreach ($request->attribute as $attrId => $value) {
                        $q->where('attribute_values', 'LIKE', '%' . $value . '%')
                        ->orWhere('attribute_values', 'LIKE', '%' . strrev($value) . '%');
                    }
                });
            })->when($request->brands, function ($query) use ($request) {
                $query->whereIn('brand_id', $request->brands);
            })
            ->with(['variants', 'translation'])
            ->latest()->paginate(9);
            // return $products;
            $productData = $products->getCollection();

        return view('website.shop',compact('categories','maxPrice','minPrice','attributes','brands','products','productData'));
    }

     public function blog(){
        $news = News::latest()->paginate(20);
        return view('website.blog',compact('news'));
    }

    public function blogDetails($slug){

        return view('website.blog-details');
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
        return view('website.user-dashboard');
    }



}
