<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name' => $this->name,
            'phone'    => $this->phone,
            'email'      => $this->email,
            'subject'      => $this->subject,
            'message'      => $this->message,
            'is_read'      => $this->is_read ?? false,
            'read_at'      => $this->read_at ? Carbon::createFromFormat('Y-m-d H:i:s', $this->read_at)->format('Y-m-d  (H:i)') : null,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
