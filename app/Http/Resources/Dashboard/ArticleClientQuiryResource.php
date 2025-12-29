<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleClientQuiryResource extends JsonResource
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
            'email'      => $this->email,
            'comment'      => $this->comment,
            'article'      => new ArticleResource($this->article),
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
