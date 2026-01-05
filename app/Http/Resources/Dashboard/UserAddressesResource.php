<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressesResource extends JsonResource
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
            'title'            => $this->title,
            'address'            => $this->address,
            'lat'            => $this->lat,
            'lng'            => $this->lng,
            'area'      => $this->area?->current_translation?->title,
            'is_primary'           => $this->is_primary,
        ];
    }
}
