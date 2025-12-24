<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class BannerResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title"       => $this->current_translation?->title,
            "description" => $this->current_translation?->description,
            "image" => $this->image.'',
        ];
    }
}
