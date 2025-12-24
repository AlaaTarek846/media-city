<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory,SoftDeletes,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "reviews";

    protected $appends = ['likes_count', 'is_liked_by_user'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewLikes()
    {
        return $this->hasMany(ReviewLike::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->reviewLikes()->count();
    }

    // getIsLikedByUserAttribute
    public function getIsLikedByUserAttribute()
    {
        if (!auth('user')->check()) {
            return 0;
        }
        return $this->reviewLikes()->where('user_id', auth('user')->id())->exists();
    }

}
