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

    protected $table = "contact_us";
}
