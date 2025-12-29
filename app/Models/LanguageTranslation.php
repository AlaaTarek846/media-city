<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LanguageTranslation extends Model
{
    use HasFactory,Sluggable;

    protected $table = 'sys_language_translations';

    /**
     * The attributes that are mass assignable.
    */
    protected $fillable = ['model_id' , 'model_type', 'locale','title','slug','description','keywords'];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'keywords' => 'array',
    ];

    /**
     * Example
     *  $translations = [
     *      'ar' => [
     *          'title'      => 'arabic title' ,
     *          'description' => 'arabic description' ,
     *      ]
     *  ];
     *  $model->setTranslations($translations);
    */

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
