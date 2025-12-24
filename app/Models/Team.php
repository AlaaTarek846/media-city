<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory,SoftDeletes,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "teams";

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

}
