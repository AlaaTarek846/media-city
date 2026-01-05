<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'mobile'          => $this->mobile,
            'whatsapp'        => $this->whatsapp,
            'user_type'       => $this->user_type,
            'how_did_you_hear_about_us' => $this->how_did_you_hear_about_us,
            'email'           => $this->email ,
            'status'           => $this->status,
            "created_at"       => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
