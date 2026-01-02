<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CartRequest;
use App\Http\Resources\Web\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the cart items for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = auth('user')->user();
        return responseJson(
            CartResource::collection($user->carts()->get()),
            __('messages.Product favorites'),
            200
        );
    }

    /**
     * Store products in the cart.
     *
     * @param CartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CartRequest $request)
    {
        $user = auth('user')->user();
        $data = $request->validated();

        foreach ($data['products'] as $productData) {
            $productId = $productData['product_id'];
            $quantity = $productData['quantity'] ?? 1;

            // Get product to get its price
            $product = Product::find($productId);
            if (!$product) {
                continue; // Skip if product doesn't exist
            }

            // Get the first variant price (or default price)
            $price = $product->variants()->first()?->price ?? 0;

            // Check if cart item already exists
            $existingCartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($existingCartItem) {
                // Update existing cart item quantity
                $existingCartItem->update([
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            } else {
                // Create new cart item
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }
        }

        return responseJson(
            null,
            __('messages.Products added to cart successfully'),
            200
        );
    }

    /**
     * Remove a product from the cart.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = auth('user')->user();
        
        $cartItem = $user->carts()->find($id);

        if (!$cartItem) {
            return responseJson(
                null,
                __('messages.Cart item not found'),
                404
            );
        }

        $cartItem->delete();

        return responseJson(
            null,
            __('messages.Product removed from cart successfully'),
            200
        );
    }

    /**
     * Add a single product to cart
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addSingleProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $user = auth('user')->user();
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $quantity = $request->quantity ?? 1;

        // Get product variant or first variant
        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
        } else {
            $variant = Product::findOrFail($productId)->variants()->first();
            if (!$variant) {
                return responseJson(
                    null,
                    __('messages.Product variant not found'),
                    404
                );
            }
        }

        if ($variant->status != 1 || $variant->product->status != 1) {
            return responseJson(
                null,
                __('messages.Product is not available'),
                404
            );
        }

        if ($quantity > $variant->quantity) {
            return responseJson(
                null,
                __('messages.Quantity exceeds available stock'),
                400
            );
        }

        // Check if cart item already exists
        $cartItem = $user->carts()
            ->where('product_id', $productId)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $variant->quantity) {
                return responseJson(
                    null,
                    __('messages.Quantity exceeds available stock'),
                    400
                );
            }
            $cartItem->increment('quantity', $quantity);
            $cartItem->update(['price' => $variant->price]);
        } else {
            // Create new cart item
            $user->carts()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'product_variant_id' => $variant->id,
                'price' => $variant->price,
            ]);
        }

        return responseJson(
            null,
            __('messages.Product added to cart successfully'),
            200
        );
    }

    /**
     * Sync cart from localStorage after login
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncCart(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.variant_id' => 'nullable|exists:product_variants,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        $user = auth('user')->user();
        $products = $request->products;
        $added = 0;
        $skipped = 0;

        foreach ($products as $productData) {
            $productId = $productData['product_id'];
            $variantId = $productData['variant_id'] ?? null;
            $quantity = $productData['quantity'] ?? 1;

            // Get product variant
            if ($variantId) {
                $variant = ProductVariant::find($variantId);
            } else {
                $variant = Product::find($productId)?->variants()->first();
            }

            if (!$variant || $variant->status != 1 || $variant->product->status != 1) {
                $skipped++;
                continue;
            }

            // Check if cart item already exists
            $cartItem = $user->carts()
                ->where('product_id', $productId)
                ->where('product_variant_id', $variant->id)
                ->first();

            if ($cartItem) {
                // Update quantity if needed
                $newQuantity = max($cartItem->quantity, $quantity);
                if ($newQuantity <= $variant->quantity) {
                    $cartItem->update([
                        'quantity' => $newQuantity,
                        'price' => $variant->price
                    ]);
                    $added++;
                } else {
                    $skipped++;
                }
            } else {
                // Create new cart item
                if ($quantity <= $variant->quantity) {
                    $user->carts()->create([
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'product_variant_id' => $variant->id,
                        'price' => $variant->price,
                    ]);
                    $added++;
                } else {
                    $skipped++;
                }
            }
        }

        return responseJson(
            [
                'added' => $added,
                'skipped' => $skipped
            ],
            __('messages.Cart synced successfully'),
            200
        );
    }

    /**
     * Get cart items with full product details
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCartItems()
    {
        $user = auth('user')->user();
        
        $cartItems = $user->carts()
            ->with([
                'product.translation',
                'product.images',
                'productVariant'
            ])
            ->get();

        $formattedItems = $cartItems->map(function($item) {
            $translation = $item->product->translation ?? $item->product->translations->first();
            $variant = $item->productVariant;
            $category = $item->product->category;
            
            // Use discount price if available, otherwise use regular price
            $price = $item->price;
            $discountPrice = null;
            $discountPercentage = 0;
            $priceBeforeDiscount = $price;
            
            if ($variant && $variant->discount_price && $variant->discount_percentage > 0) {
                $discountPrice = $variant->discount_price;
                $discountPercentage = $variant->discount_percentage;
                $priceBeforeDiscount = $variant->price_before_discount ?? $variant->price;
                $price = $discountPrice; // Use discount price
            }
            
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->product_variant_id,
                'title' => $translation->title ?? '',
                'slug' => $translation->slug ?? '',
                'image' => $item->product->image,
                'quantity' => $item->quantity,
                'price' => $price,
                'discount_price' => $discountPrice,
                'discount_percentage' => $discountPercentage,
                'price_before_discount' => $priceBeforeDiscount,
                'total' => $price * $item->quantity,
                'unit' => $variant->unit ?? '',
                'category' => $category->translation->title ?? ($category->translations->first()->title ?? ''),
            ];
        });

        $total = $formattedItems->sum('total');
        $itemsCount = $formattedItems->sum('quantity');

        return responseJson(
            [
                'items' => $formattedItems,
                'total' => $total,
                'items_count' => $itemsCount
            ],
            __('messages.Cart items fetched successfully'),
            200
        );
    }

    /**
     * Update cart item quantity
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $user = auth('user')->user();
        $cartItem = $user->carts()->findOrFail($id);
        $quantity = $request->quantity;

        // If quantity is 0, delete the item
        if ($quantity <= 0) {
            $cartItem->delete();
            return responseJson(
                null,
                __('messages.Product removed from cart successfully'),
                200
            );
        }

        // Check if quantity exceeds available stock
        if ($cartItem->productVariant && $quantity > $cartItem->productVariant->quantity) {
            return responseJson(
                null,
                __('messages.Quantity exceeds available stock'),
                400
            );
        }

        // Update quantity
        $cartItem->update(['quantity' => $quantity]);

        return responseJson(
            [
                'id' => $cartItem->id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'total' => $cartItem->price * $cartItem->quantity
            ],
            __('messages.Cart updated successfully'),
            200
        );
    }
}

