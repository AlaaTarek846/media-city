<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory,TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "about_us";

    /**
     * Get the first image URL (large image)
     */
    public function getImage1Attribute($value): string
    {
        if (!$value) {
            return '';
        }
        // إذا كان المسار يحتوي على http، أرجعه كما هو
        if (str_starts_with($value, 'http')) {
            return $value;
        }
        // إذا كان المسار يبدأ بـ /، أضف asset له
        if (str_starts_with($value, '/')) {
            return asset($value);
        }
        // وإلا أضف upload/general/
        return asset('upload/general/'.$value);
    }

    /**
     * Get the second image URL (small image)
     */
    public function getImage2Attribute($value): string
    {
        if (!$value) {
            return '';
        }
        // إذا كان المسار يحتوي على http، أرجعه كما هو
        if (str_starts_with($value, 'http')) {
            return $value;
        }
        // إذا كان المسار يبدأ بـ /، أضف asset له
        if (str_starts_with($value, '/')) {
            return asset($value);
        }
        // وإلا أضف upload/general/
        return asset('upload/general/'.$value);
    }

    /**
     * Relationship: AboutUs has many Features
     */
    public function features()
    {
        return $this->hasMany(AboutUsFeature::class, 'about_us_id');
    }

    /**
     * Relationship: AboutUs has many Statistics
     */
    public function statistics()
    {
        return $this->hasMany(AboutUsStatistic::class, 'about_us_id');
    }
}
