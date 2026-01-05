<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Requests\Website\CouponRequest;
use App\Http\Requests\Website\OrderRequest;
use App\Http\Resources\Website\FavoriteResource;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function checkCoupon(CouponRequest $request)
    {
        $data = $request->validated();

        $coupon = DiscountCoupon::where('code', $data['code'])->first();

        if (!$coupon) {
            return responseJson('', __('messages.Invalid coupon code'), 400);
        }

        $user = auth('user')->user();
        $cartItem = $this->cartItems($user->carts);

        $totalAmount = $cartItem['totalSum'];

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

        return responseJson([
            'discount_amount' => $discountAmount,
            'new_total'       => $totalAmount - $discountAmount ,
            'coupon'          => $coupon
        ], __('messages.Coupon applied successfully'), 200);
    }

    public function cartItems($items)
    {
        $totalSum = 0;
        foreach ($items as $item){
            // Use cart item price (already includes discount if applicable)
            $itemPrice = $item->price;
            
            // Determine if this is a rent item
            $isRent = !is_null($item->start_date) && !is_null($item->count_day);
            
            if ($isRent) {
                // For rent: price × count_day
                $totalItem = $itemPrice * $item->count_day;
            } else {
                // For buy: price × quantity
                $totalItem = $itemPrice * $item->quantity;
            }

            $totalSum+=$totalItem;

        }

        return  $array = [
            'totalSum'    =>round($totalSum, 2),

        ];


    }




}

