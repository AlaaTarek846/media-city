<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "can_delete"  => $this->addresses_count == 0,
            "title"     => $this->current_translation?->title,
            "status" => $this->status,
            "shipping_price" => $this->shipping_price,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
