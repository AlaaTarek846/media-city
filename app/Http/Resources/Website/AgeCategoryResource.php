<?php

namespace App\Http\Resources\Website;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AgeCategoryResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "title"       => $this->current_translation?->title,
            "description" => $this->current_translation?->description,
            "status" => $this->status,
            "abbreviation" => $this->abbreviation,
            "type"=> [
                "name" => $this->type->name,
                "value" => $this->type->value,
                "label" => $this->type->label(),
            ],
        ];
    }
}
