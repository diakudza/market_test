<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\App;

class Image extends Model
{
    protected $fillable = ['imageable_id', 'imageable_type', 'filename', 'path', 'disk', 'alt', 'title', 'scope'];

    use HasFactory;

    public function url()
    {
        $query = $this->select('path', 'filename', 'imageable_type')->first();
        return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $query->path . $query->filename;
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'imageable_id');
    }

    public function scopeImage($query, $scope)
    {
        return $query->where('scope', 'LIKE', '%' . $scope . '%');
    }


}
