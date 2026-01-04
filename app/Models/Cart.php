<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory,SoftDeletes,SearchFilterTrait,TranslationsTrait;

    protected $guarded = ['id'];

    protected $table = "carts";

    /**
     * The attributes that are mass assignable.
     * Added rent fields: note, start_date, count_day
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
        'note',
        'start_date',
        'count_day',
    ];

    /**
     * Cast dates for proper handling
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }


}
