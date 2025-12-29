<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUsStatistic extends Model
{
    use HasFactory, TranslationsTrait, SearchFilterTrait, SoftDeletes;

    protected $guarded = ['id'];

    protected $table = "about_us_statistics";

    /**
     * Get the icon URL
     */
    public function getIconAttribute($value): string
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
        return asset('upload/general/' . $value);
    }

    /**
     * Relationship: Statistic belongs to AboutUs
     */
    public function aboutUs()
    {
        return $this->belongsTo(AboutUs::class, 'about_us_id');
    }
}

