<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{

    const STATUS_PENDING = 'PENDING';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_REJECTED = 'REJECTED';


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

    public function scopeOngoing($query)
    {
        return $query->whereRaw('CURDATE() BETWEEN start_date AND end_date');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', '=', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', '=', self::STATUS_REJECTED);
    }

    public function scopePending($query)
    {
        return $query->where('status', '=', self::STATUS_PENDING);
    }
}
