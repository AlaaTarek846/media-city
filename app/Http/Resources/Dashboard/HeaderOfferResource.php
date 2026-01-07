<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HeaderOfferResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"           => $this->id,
            "description"  => $this->current_translation?->description,
            "status"       => $this->status,
            "created_at"   => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
