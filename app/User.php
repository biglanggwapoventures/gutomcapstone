<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const ROLE_USER = 'USER';
    const ROLE_RESTAURANT_OWNER = 'OWNER';
    const ROLE_ADMIN = 'ADMIN';
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 
        'lastname', 
        'username',
        'password', 
        'email', 
        'contact_number',
        'role', 
        'display_photo', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fullname()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function hasRestaurant()
    {
        return $this->restaurant()->exists();
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isOwner()
    {
        return $this->role === self::ROLE_RESTAURANT_OWNER;
    }

    public function restaurant()
    {
        return $this->hasOne('App\Restaurant', 'created_by');
    }

    public function cart()
    {
        return $this->hasMany('App\Cart', 'user_id');
    }

    public function cartContents($restaurantId)
    {
        // return collect();
        return \App\Cart::with(['item' => function ($query) {
            $query->select('id', 'name', 'photo', 'price', 'description');
        }])
            ->select(\DB::raw('id, SUM(quantity) AS quantity, menu_id'))
            ->orderBy('created_at', 'DESC')
            ->whereUserId($this->id)
            ->groupBy('menu_id')
            ->whereHas('item', function ($query) USE ($restaurantId) {
                $query->whereRestaurantId($restaurantId);
            })->get();
            
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'user_id');
    }

    public function getOrdersNotificationCount($all = false)
    {
        $count = $this->orders()
            ->responded()
            ->unreadByUser();

        if($all){
            return $count->count('id');
        }

        $result = $count->select(\DB::raw('COUNT(id) AS id, order_status'))
            ->groupBy('order_status')
            ->get();
        
        return $result->pluck('id', 'order_status');
    }

    public function displayPhoto()
    {
        $path = $this->display_photo ? "storage/{$this->display_photo}" : 'images/generic-photo.png';
        return asset($path);
    }

    public function hasReviewed($restaurantId)
    {
        return \DB::table('reviews')
            ->where([
                ['user_id', '=', $this->id],
                ['restaurant_id', '=', $restaurantId ]
            ])
            ->exists();
    }

    public function isRestaurantOwner()
    {
        return $this->role === 'OWNER';
    }

    public function roleDescription()
    {
        return $this->role === self::ROLE_USER ? 'Regular User' : 'Restaurant Owner';
    }

    public function owns(Restaurant $restaurant)
    {
        return $restaurant->created_by == $this->id;
    }
}
