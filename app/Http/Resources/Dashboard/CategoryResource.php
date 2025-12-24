<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CategoryResource extends JsonResource
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
