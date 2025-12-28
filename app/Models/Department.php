<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "departments";

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'department_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'department_categories', 'department_id', 'category_id');
    }
}
