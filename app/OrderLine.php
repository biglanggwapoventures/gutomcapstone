<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $fillable = [
        'order_id',
        'menu_id',
        'available',
        'quantity',
        'price'
    ];

    protected $casts = [
        'available' => 'boolean'
    ];

    public function details()
    {
        return $this->belongsTo('App\Menu', 'menu_id');
    }
    
    public function getAmount($formatted = false)
    {
        $amount = $this->quantity * $this->price;
        return $formatted ? number_format($amount, 2) : $amount;
    }

    public function formattedPrice()
    {
        return number_format($this->price, 2);
    }
}
