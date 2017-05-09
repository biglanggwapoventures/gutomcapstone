<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    const TYPE_DINE_IN = 'DINE_IN';
    const TYPE_PICK_UP = 'PICK_UP';

    const STATUS_PENDING = 'PENDING';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_CANCELLED = 'CANCELLED';
    
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'order_type',
        'payment_type',
        'name',
        'contact_number',
        'order_date',
        'order_time',
        'guest_count',
        'cook_time',
    ];
    
    protected $total = null;


    public function items()
    {
        return $this->hasMany('App\OrderLine', 'order_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function customer() 
    {
        return $this->belongsTo('App\User', 'user_id');
    } 

    public function scopePending($query)
    {
        return $query->where('order_status', '=', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('order_status', '=', self::STATUS_APPROVED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('order_status', '=', self::STATUS_CANCELLED);
    }

    public function scopeResponded($query)
    {
        return $query->whereIn('order_status', [
            self::STATUS_CANCELLED,
            self::STATUS_APPROVED
        ]);
    }

    public function scopeUnreadByUser($query)
    {
        return $query->where('seen_by_user', '=', 0);
    }

    public function getTotal($formatted = false)
    {
        if($this->total === null){
            $this->total = $this->items->sum(function ($item) {
                return ($item['price'] * $item['quantity']);
            });
        }
        return $formatted ? number_format($this->total, 2) : $this->total;
    }

    public function isPending() : bool
    {
        return $this->order_status === self::STATUS_PENDING;
    }

    public function isApproved() : bool
    {
        return $this->order_status === self::STATUS_APPROVED;
    }

    public function isCancelled() : bool
    {
        return $this->order_status === self::STATUS_CANCELLED;
    }

    public function isDineIn() : bool
    {
        return $this->order_type === self::TYPE_DINE_IN;
    }

    public function getReadableType()
    {
        return $this->order_type === self::TYPE_PICK_UP ? 'PICK UP' : 'DINE IN';
    }

    public function scopeMarkAsRead($query)
    {
        return $query->update([
                'seen_by_user' => 1
            ]);
    }
    
}
