<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','slug'
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_categories') ;
    }
}
