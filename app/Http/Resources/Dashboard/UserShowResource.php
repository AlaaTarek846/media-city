<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\UserAddressesResource;
use App\Http\Resources\Dashboard\OrderResource;
use App\Http\Resources\Dashboard\ProductResource;
use App\Http\Resources\Dashboard\ReviewResource;

class UserShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $profileData = [];
        
        // Get profile data based on user type
        if ($this->user_type === 'person' && $this->personProfile) {
            $profileData = [
                'id_card_front' => $this->personProfile->id_card_front,
                'id_card_back' => $this->personProfile->id_card_back,
            ];
        } elseif ($this->user_type === 'company' && $this->companyProfile) {
            $profileData = [
                'commercial_register_image' => $this->companyProfile->commercial_register_image,
                'tax_card_image' => $this->companyProfile->tax_card_image,
            ];
        } elseif ($this->user_type === 'studio' && $this->studioProfile) {
            $profileData = [
                'id_card_front' => $this->studioProfile->id_card_front,
                'id_card_back' => $this->studioProfile->id_card_back,
            ];
        }
        
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'mobile'          => $this->mobile,
            'whatsapp'        => $this->whatsapp,
            'user_type'       => $this->user_type,
            'how_did_you_hear_about_us' => $this->how_did_you_hear_about_us,
            'email'           => $this->email,
            'profile'         => $profileData,
            "addresses"        => UserAddressesResource::collection($this->addresses),
            "orders"           => OrderResource::collection($this->orders),
            "favorites"        => ProductResource::collection($this->favorites),
            "reviews"         => ReviewResource::collection($this->reviews),
            'status'           => $this->status,
            "created_at"       => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
