<?php

namespace App\Http\Resources\Website;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "title"       => $this->current_translation?->title,
            "description" => $this->current_translation?->description,
            "is_disabled" => $this->is_disabled,
        ];
    }
}
