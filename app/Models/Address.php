<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory,SoftDeletes,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "addresses";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the area that owns this address
     * 
     * Relationship: Address belongs to Area
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

}
