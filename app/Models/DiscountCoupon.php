<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCoupon extends Model
{
    use HasFactory,SoftDeletes,SearchFilterTrait,TranslationsTrait;

    protected $guarded = ['id'];

    protected $table = "discount_coupons";

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
