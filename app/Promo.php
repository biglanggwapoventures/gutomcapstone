<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'description',
        'restaurant_id',
        'photo'
    ];

    public function getPhotoAttribute($value)
    {
        return asset("storage/{$value}");
    }
}
