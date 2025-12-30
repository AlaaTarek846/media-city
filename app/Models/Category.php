<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory,SoftDeletes,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "categories";

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_categories', 'category_id', 'department_id');
    }
    public function getSlugAttribute()
    {
        return Str::slug($this->current_translation?->title);
    }

}
