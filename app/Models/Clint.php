<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Clint extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    public $guarded = [];

}
