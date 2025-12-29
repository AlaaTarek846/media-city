<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, TranslationsTrait, SearchFilterTrait, Notifiable;

    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'password',
    ];

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorite_products', 'user_id', 'product_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewLikes()
    {
        return $this->hasMany(ReviewLike::class);
    }

    /**
     * Get the person profile for this user (if user_type is 'person')
     */
    public function personProfile()
    {
        return $this->hasOne(PersonProfile::class);
    }

    /**
     * Get the company profile for this user (if user_type is 'company')
     */
    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    /**
     * Get the studio profile for this user (if user_type is 'studio')
     */
    public function studioProfile()
    {
        return $this->hasOne(StudioProfile::class);
    }

    /**
     * Send the password reset notification.
     * 
     * Override default notification to customize reset link URL
     * Uses custom notification to send reset link with proper route
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

}
