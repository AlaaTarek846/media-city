<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioRental extends Model
{
    use HasFactory,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    public function images()
    {
        return $this->morphMany(\App\Models\Image::class, 'imageable');
    }
}
