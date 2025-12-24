<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory,SoftDeletes,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "products";

    protected $appends = ['is_favorite', 'rate', 'review_count'];

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function features()
    {
        return $this->hasOne(ProductFeature::class, 'product_id');
    }

    public function images()
    {
        return $this->morphMany(ProductImage::class, 'imageable');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id');
    }

    public function getIsFavoriteAttribute(): int
    {
        if (!auth('user')->check()) {
            return 0;
        }
        $favorite = $this->favoriteProducts()->where('user_id', auth('user')->user()->id)->first();
        return $favorite ? 1 : 0;
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(User::class, 'favorite_products');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getRateAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0.0;
    }

    //count reviews
    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }

}
