<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'user_id'            => $this->user_id,
            'user_name'            => $this->user?->name,
            'user_phone'            => $this->user?->phone,
            'user_email'            => $this->user?->email,
            'user_status'            => $this->user?->status,
            'order_number'            => $this->order_number,
            'order_status'      => $this->orderStatus?->current_translation?->title,
            "applied_coupon"            => $this->discountCoupon?->current_translation?->title,
            "discount"            => $this->discount,
            "coupon_discount"            => $this->coupon_discount,
            "tax_percentage"            => $this->tax_percentage,
            "tax"            => $this->tax,
            "shipping_price"            => $this->shipping_price,
            "sub_total"            => $this->sub_total,
            "total"            => $this->total,
            "items"            => OrderItemResource::collection($this->orderItems),
            'order_status_id'   => $this->order_status_id,
            'created_at'       => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
