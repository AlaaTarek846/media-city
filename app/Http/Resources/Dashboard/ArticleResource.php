<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"          => $this->id,
            "title"       => $this->current_translation?->title,
            "description" => $this->current_translation?->description,
            "slug"        => $this->current_translation?->slug,
            "keywords"    => $this->current_translation?->keywords ?? [],
            "image"       => $this->image.'',
            "status"       => $this->status,
            "created_at"  => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
            "category"     => $this->category?->id,
            "tags"        => $this->tags->pluck('id')->toArray(),
        ];
    }
}
