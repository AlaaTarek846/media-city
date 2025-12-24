<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "testimonials";

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }
}
