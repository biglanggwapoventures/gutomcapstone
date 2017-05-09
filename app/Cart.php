<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity'
    ];

    public function item()
    {
        return $this->belongsTo('App\Menu', 'menu_id', 'id');
    }
    
}
