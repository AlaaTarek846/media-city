<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use HasFactory,SoftDeletes,SearchFilterTrait,TranslationsTrait;

    protected $guarded = ['id'];

    protected $table = "product_attributes";

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values', 'attribute_id', 'product_id')
                    ->withPivot('values')
                    ->withTimestamps();
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }

}
