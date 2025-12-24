<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'product'      => $this->product?->current_translation?->title,
            'product_image'      => $this->product?->image,
            'category'      => $this->product?->category?->current_translation?->title,
            'brand'      => $this->product?->brand?->current_translation?->title,
            "variant"            => $this->productVariant?->attribute_values,
            "sku"            => $this->productVariant?->sku,
            "discount"            => $this->discount,
            "quantity"            => $this->quantity,
            "price"            => $this->price,
            "total"            => $this->total,
        ];
    }
}
