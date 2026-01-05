<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CartRequest;
use App\Http\Requests\Web\OrderRequest;
use App\Http\Resources\Web\CartResource;
use App\Models\Address;
use App\Models\Cart;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth('user')->user();
        return responseJson(OrderResource::collection($user->favorites()->get()), __('messages.Product favorites '), 200);
    }

    public function store(OrderRequest  $request)
    {
        $discountItem = 0;
        $data         = $request->validated();

        $user = auth('user')->user();
        $discountCoupon = $this->discountCoupon($data['coupon_discount']??null);

        $address = Address::with('area')->where('user_id', $user->id)->find($data['address_id']);
        $order = Order::create([
            'user_id'            => $user->id,
            'address_id'         => $data['address_id'],
            'order_status_id'    => 1,
            'discount_coupon_id' => $discountCoupon ?  $discountCoupon->id     : null,
            'coupon'             => $discountCoupon ? $data['coupon_discount'] : null,
            'discount'           => $discountCoupon ? $discountCoupon->value   : 0,
        ]);
        $orderItem =  $this->orderItem($user->carts,$order);
        if ($discountCoupon)
        {
            if ($discountCoupon->type == "fixed"){
                $discountItem = $discountCoupon->value ?? 0;
            }else{
                $discountItem = $orderItem['totalSum'] *  (float) ($discountCoupon->value ?? 0) / 100;
            }
        }
        $finalPrice            = $orderItem['totalSum'] - $discountItem;
        $order->update([
            'coupon_discount' => $discountItem,
            'shipping_price'  => $address->area->shipping_price,
            'sub_total'       =>  $orderItem['totalSum'],
            "total"           =>  $finalPrice + $address->area->shipping_price,
        ]);

        //update quantity in product
        foreach ($user->carts as $cartItem) {
            // Only decrement quantity for buy items (rent items don't affect stock)
            if (is_null($cartItem->start_date) && is_null($cartItem->count_day)) {
                $cartItem->productVariant->decrement('quantity', $cartItem->quantity);
            }
        }

        // Clear the user's cart
        $user->carts()->delete();

        // Load relationships for notification
        $order->load(['user', 'orderStatus.translations']);

        // Broadcast order notification
        event(new \App\Events\OrderNotification($order));

        return responseJson($order, __('messages.Favorite list changed successfully'), 200);

    }

    public function discountCoupon($coupon)
    {
        $now = now('Africa/Cairo');
        return  $discountCoupon = DiscountCoupon::whereCode($coupon)
            ->whereStatus(1)
            ->where('start_date', '<=', $now)
            ->where('expire_date', '>=', $now)
            ->first();

    }

    public function orderItem($items,$order)
    {

        $totalSum = 0;
        foreach ($items as $item){
            $totalItem =0;
            $product = Product::find($item->product_id);
            $variant = $item->productVariant;
            
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

            $orderItem = OrderItem::create([
                'order_id'           => $order->id,
                'product_id'         => $product->id,
                'product_variant_id' => $variant->id,
                'quantity'           => $item->quantity,
                'price'              => $itemPrice,
                'discount'           => $variant->discount_percentage ?? 0,
                'total'              => round($totalItem, 2),
                'count_day'          => $item->count_day ?? 0,
                'start_date'         => $item->start_date ?? null,
                'note'               => $item->note ?? null,

            ]);
            $totalSum+=$orderItem->total;

        }

        return  $array = [
            'totalSum' =>round($totalSum, 2),
        ];


    }



    public function updateStatus(Request $request,$id){
        $order = Order::find($id);
        if ($request->order_status_id == 5){
            foreach ($order->orderItems as $cartItem) {
                $cartItem->productVariant->increment('quantity', $cartItem->quantity);
            }
        }

        $order->update([
            'order_status_id' => $request->order_status_id,
        ]);

        return responseJson([],'Updated Successfully',200);
    }
}

