<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\FavoriteRequest;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the favorite products for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = auth('user')->user();
        return responseJson(
            $user->favorites()->with(['translation', 'variant'])->get(),
            __('messages.Product favorites'),
            200
        );
    }

    /**
     * Toggle favorite products (add or remove).
     *
     * @param FavoriteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FavoriteRequest $request)
    {
        $user = auth('user')->user();
        $productIds = $request->validated()['product_ids'];

        foreach ($productIds as $productId) {
            // التحقق من وجود المنتج في المفضلة
            $isFavorite = $user->favorites()->where('product_id', $productId)->exists();

            if ($isFavorite) {
                // إذا كان موجوداً، يتم حذفه (detach)
                $user->favorites()->detach($productId);
            } else {
                // إذا لم يكن موجوداً، يتم إضافته (attach)
                $user->favorites()->attach($productId);
            }
        }

        return responseJson(
            null,
            __('messages.Favorite list changed successfully'),
            200
        );
    }

    /**
     * Remove a product from favorites.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = auth('user')->user();

        // البحث في جدول FavoriteProduct باستخدام user_id و product_id
        $favoriteProduct = FavoriteProduct::where('user_id', $user->id)
            ->where('product_id', $id)
            ->first();

        if ($favoriteProduct) {
            // حذف المنتج من المفضلة
            $user->favorites()->detach($id);
        }

        return responseJson(
            null,
            __('messages.Item removed from cart successfully'),
            200
        );
    }

    /**
     * Add product to wishlist (for authenticated users)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = auth('user')->user();
        $productId = $request->product_id;

        // Check if product already exists in favorites
        $isFavorite = $user->favorites()->where('product_id', $productId)->exists();

        if ($isFavorite) {
            return responseJson(
                ['status' => 'already_exists'],
                __('messages.Product already in wishlist'),
                200
            );
        }

        // Add product to favorites
        try {
            $user->favorites()->attach($productId);
            
            return responseJson(
                ['status' => 'added'],
                __('messages.Product added to wishlist successfully'),
                200
            );
        } catch (\Exception $e) {
            // Handle unique constraint violation
            if (str_contains($e->getMessage(), 'unique_user_product_favorite')) {
                return responseJson(
                    ['status' => 'already_exists'],
                    __('messages.Product already in wishlist'),
                    200
                );
            }
            
            return responseJson(
                ['status' => 'error'],
                __('messages.Error adding product to wishlist'),
                500
            );
        }
    }

    /**
     * Sync wishlist from localStorage after login
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncWishlist(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'required|exists:products,id'
        ]);

        $user = auth('user')->user();
        $productIds = $request->product_ids;
        $added = 0;
        $skipped = 0;

        foreach ($productIds as $productId) {
            // Check if product already exists
            $isFavorite = $user->favorites()->where('product_id', $productId)->exists();
            
            if (!$isFavorite) {
                try {
                    $user->favorites()->attach($productId);
                    $added++;
                } catch (\Exception $e) {
                    // Skip if duplicate (shouldn't happen but just in case)
                    $skipped++;
                }
            } else {
                $skipped++;
            }
        }

        return responseJson(
            [
                'added' => $added,
                'skipped' => $skipped
            ],
            __('messages.Wishlist synced successfully'),
            200
        );
    }

    /**
     * Check if product is in wishlist
     * 
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkWishlist($productId)
    {
        $user = auth('user')->user();
        $isFavorite = $user->favorites()->where('product_id', $productId)->exists();

        return responseJson(
            ['is_favorite' => $isFavorite],
            'Success',
            200
        );
    }
}

