<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class DepartmentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"               => $this->id,
            "title"            => $this->current_translation?->title,
            "image"            => $this->image.'',
            "status"           => $this->status,
            "categories_count" => $this->categories_count ?? 0,
            "slug"             => $this->slug,

        ];
    }
}
