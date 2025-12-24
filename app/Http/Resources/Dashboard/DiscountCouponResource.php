<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountCouponResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "title"     => $this->current_translation?->title,
            "description" => $this->current_translation?->description,
            "code"      => $this->code,
            "type"      => __('messages.'.$this->type),
            "value"     => $this->value,
            "user_count"  => $this->user_count,
            "start_date" => $this->start_date,
            "expire_date"   => $this->expire_date,
            "greater_than" => $this->greater_than,
            "status" => $this->status,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
