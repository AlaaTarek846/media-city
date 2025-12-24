<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class News extends Model
{
    use HasFactory , TranslationsTrait,SearchFilterTrait;

    protected $table = 'news';

    protected $guarded = ['id'];

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

    public function details()
    {
        return $this->hasOne(NewsDetail::class);
    }
    public function getSlugAttribute()
    {
        return Str::slug($this->current_translation?->title);
    }
}
