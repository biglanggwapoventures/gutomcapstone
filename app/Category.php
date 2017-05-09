<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public static function dropdownFormat()
    {
        return self::all()->pluck('name', 'id')->toArray();
    }
}
