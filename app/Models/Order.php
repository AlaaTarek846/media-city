<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use App\Traits\SerialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes,SearchFilterTrait,TranslationsTrait,SerialTrait;

    protected $guarded = ['id'];

    protected $table = "orders";

    // protected $casts = [
    //     'is_order' => 'boolean',
    //     'discount' => 'double',
    //     'tax_percentage' => 'double',
    //     'tax' => 'double',
    //     'sub_total' => 'double',
    //     'total' => 'double',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function discountCoupon()
    {
        return $this->belongsTo(DiscountCoupon::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

     // Automatically set code attribute only on create
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = $order->createSerialNumber(self::class, 'OR-');
        });
    }

}
