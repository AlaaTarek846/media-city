<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCategory extends Model
{
    use HasFactory,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "department_categories";

    public function products()
    {
        return $this->hasMany(Product::class, 'department_category_id');
    }
}
