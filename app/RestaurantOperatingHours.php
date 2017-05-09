<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantOperatingHours extends Model
{
    protected $table = 'restaurant_operating_hours';
    
    protected $fillable = [
        'restaurant_id',
        'operating_day',
        'opening',
        'closing'
    ];
}
