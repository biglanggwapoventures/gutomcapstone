<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Blog extends Model
{
    protected $fillable = [
        'restaurant_id',
        'title',
        'body',
        'published',
        'photo'
    ];

    public function getPhotoAttribute($value)
    {
        return asset("storage/{$value}");
    }

    
}
