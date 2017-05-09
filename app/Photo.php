<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'filename',
        'restaurant_id'
    ];

    protected $appends = ['full_path'];

    public function getFullPathAttribute()
    {
        return asset("storage/{$this->filename}");
    }

    
}
