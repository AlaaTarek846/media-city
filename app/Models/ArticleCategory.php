<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use HasFactory,SoftDeletes,SearchFilterTrait,TranslationsTrait;

    protected $guarded = ['id'];

    protected $table = "article_categories";


    public function articles(){
        return $this->hasMany(Article::class,'category_id');
    }


}
