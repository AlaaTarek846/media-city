<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CompanyProfile Model
 *
 * Stores additional profile information for Company type users
 * Each Company user has one CompanyProfile record
 */
class CompanyProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the user that owns this company profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCommercialRegisterImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

    public function getTaxCardImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }
}
