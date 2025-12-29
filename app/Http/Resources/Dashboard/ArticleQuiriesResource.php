<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleQuiriesResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"     => $this->name,
            "comment"     => $this->comment,
            "email"     => $this->email,
            "article"     => $this->article->title,
            "created_at" => $this->created_at->format("Y-m-d H:i"),
        ];
    }
}
