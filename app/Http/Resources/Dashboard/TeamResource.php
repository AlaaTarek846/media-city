<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TeamResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title"  => $this->current_translation?->title,
            "description" => $this->current_translation?->description,
            "image" => $this->image.'',
        ];
    }
}
