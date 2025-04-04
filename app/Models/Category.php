<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Category extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    public $guarded = [];

    public function products()
{
    return $this->hasMany(Product::class);
}
}
