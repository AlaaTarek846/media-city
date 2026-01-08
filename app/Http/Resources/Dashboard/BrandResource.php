<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "can_delete" => $this->products_count == 0,
            "title"  => $this->current_translation?->title,
            "image" => $this->image.'',
            "status" => $this->status,
        ];
    }
}
