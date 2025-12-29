<?php

namespace App\Models;
use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory,SearchFilterTrait,TranslationsTrait;

    protected $guarded = ['id'];

    public function getAddressAttribute($value)
    {
        return app()->getLocale() === 'ar' ? $this->address_ar : $this->address_en;
    }

    protected $table = "contact_us";
}
