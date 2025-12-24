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
            'title'            => $this->title,
            'address'            => $this->address,
            'building_number'           => $this->building_number ,
            'floor_number'           => $this->floor_number ,
            'apartment_number'           => $this->apartment_number ,
            'distinctive_mark'           => $this->distinctive_mark ,
            'country'      => $this->country?->current_translation?->title,
            'area'      => $this->area?->current_translation?->title,
            'is_primary'           => $this->is_primary,
        ];
    }
}
