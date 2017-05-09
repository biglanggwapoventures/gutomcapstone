<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'price',
        'description',
        'preparation',
        'photo'
    ];

    protected $appends = ['category_ids'];


    public function getPhotoAttribute($value)
    {
        return asset("storage/{$value}");
    }

    public function categories()
    {
        return $this->belongsToMany('App\MenuCategory', 'menu_categories_map', 'menu_id', 'menu_category_id')->withTimestamps();
    }

    public function categoriesFlatArray()
    {
        return $this->categories->pluck('name')->toArray();
    }

    public function getCategoryIdsAttribute()
    {
        $result = \DB::table('menu_categories_map')
            ->select('menu_category_id')
            ->whereMenuId($this->id)
            ->orderBy('menu_category_id')
            ->get();

        return $result->count() ? $result->pluck('menu_category_id')->toArray() : [];
    }

    public function orders()
    {
        return $this->hasMany('App\Cart');
    }
    
    public function formattedPrice()
    {
        return number_format($this->price, 2);
    }       

    public function descriptionExcerpt()
    {
        $excerpt = substr($this->description, 0, 50);
        return $excerpt === $this->description ? $excerpt : "{$excerpt}...";
    }
    
}
