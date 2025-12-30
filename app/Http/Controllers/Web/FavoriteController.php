<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\FavoriteRequest;
use App\Models\FavoriteProduct;
use Illuminate\Http\Request;

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
}

