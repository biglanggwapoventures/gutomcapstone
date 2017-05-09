<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'restaurant_id',
        'rating',
        'feedback',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
     public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

}
