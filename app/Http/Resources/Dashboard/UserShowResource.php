<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'            => $this->phone,
            'email'           => $this->email ,
            "addresses"        => UserAddressesResource::collection($this->addresses),
            "orders"           => OrderResource::collection($this->orders),
            "favorites"        => ProductResource::collection($this->favorites),
            "reviews"         => ReviewResource::collection($this->reviews),
            'status'           => $this->status,
            "created_at"       => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
