<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "title"       => $this->current_translation?->title,
            "category" => $this->category?->current_translation?->title,
            "brand" => $this->brand?->current_translation?->title,
            "type" => $this->type,
            "price" => $this->variants->first()?->price,
            "quantity" => $this->variants->sum('quantity'),
            "image" => $this->image.'',
            "status" => $this->status,
        ];
    }
}
