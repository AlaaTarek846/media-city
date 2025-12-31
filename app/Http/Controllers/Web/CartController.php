<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CartRequest;
use App\Http\Resources\Web\CartResource;
use App\Models\Cart;
use App\Models\Product;
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
}

