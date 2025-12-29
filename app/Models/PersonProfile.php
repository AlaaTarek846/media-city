<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * PersonProfile Model
 *
 * Stores additional profile information for Person type users
 * Each Person user has one PersonProfile record
 */
class PersonProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the user that owns this person profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIdCardFrontAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

    public function getIdCardBackAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }
}
