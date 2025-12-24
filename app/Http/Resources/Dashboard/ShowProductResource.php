<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "translations"       => $this->translations,
            "category_id"       => $this->category_id,
            "brand_id"       => $this->brand_id,
            "type" => $this->type,
            "image" => $this->image.'',
            "status" => $this->status,
            "features"       => $this->features ? $this->features->translations : [],
            "groupImages" => $this->images->map(function ($image) {
                return $image->image;
            }),
            "variants" => $this->variants,
            "attributes" => $this->attributes,
        ];
    }
}
