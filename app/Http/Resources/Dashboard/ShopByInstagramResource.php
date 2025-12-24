<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ShopByInstagramResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "image" => $this->image.'',
            "link_path" => $this->link,
        ];
    }
}
