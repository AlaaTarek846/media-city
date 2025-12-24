<?php

namespace App\Models;
use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "contact_messages";
}
