<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * StudioProfile Model
 *
 * Stores additional profile information for Studio type users
 * Each Studio user has one StudioProfile record
 */
class StudioProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the user that owns this studio profile
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
