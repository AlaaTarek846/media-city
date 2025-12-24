<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReviewResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "product"  => $this->product?->current_translation?->title,
            "review" => $this->review,
            "rating" => $this->rating,
            "likes_count" => $this->likes_count,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
