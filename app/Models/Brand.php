<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'code', 'banner_title', 'banner_description', 'display_on_home',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'brand_categories') ;
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'imageable_id') ;
    }

}
