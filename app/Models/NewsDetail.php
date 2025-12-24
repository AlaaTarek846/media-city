<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsDetail extends Model
{
    use HasFactory , TranslationsTrait,SearchFilterTrait;

    protected $table = 'news_details';

    protected $guarded = ['id'];
    
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
