<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\ClientTypeEnum;
class FrequentlyAskedQuestion extends Model
{
    use HasFactory  ,SoftDeletes, TranslationsTrait,SearchFilterTrait;

    protected $table = 'frequently_asked_questions';

    protected $guarded = ['id'];
}
