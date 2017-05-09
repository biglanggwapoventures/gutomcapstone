<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
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
