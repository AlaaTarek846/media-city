<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{

    public function toArray($request)
    {
        $role = $this->roles()->first();
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            'status' => $this->status,
            'phone' => $this->phone,
            'image' => $this->image,
            'role_name' => $role?->id ?? null, // Return role ID for dropdown compatibility
            'role_name_text' => $role?->name ?? null, // Keep role name for display if needed
        ];
    }
}
