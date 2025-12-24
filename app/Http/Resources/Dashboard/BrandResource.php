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
            "title"  => $this->current_translation?->title,
            "image" => $this->image.'',
            "status" => $this->status,
        ];
    }
}
