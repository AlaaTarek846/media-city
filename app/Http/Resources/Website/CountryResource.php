<?php

namespace App\Http\Resources\Website;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "title"       => $this->current_translation?->title,

        ];
    }
}
