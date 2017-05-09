<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use DB;


class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'description',
        'logo',
        'policy',
        'created_by',
        'approved_at'
    ];
    
    protected $appends = [
        'category_ids',
        'status'
    ];

    public function owner()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'restaurant_categories', 'restaurant_id', 'category_id')->withTimestamps();
    }

    public function operatingHours()
    {
        return $this->hasMany('App\RestaurantOperatingHours', 'restaurant_id');
    }

    public function menu()
    {
        return $this->hasMany('App\Menu', 'restaurant_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Blog', 'restaurant_id');
    }

    public function promos()
    {
        return $this->hasMany('App\Promo', 'restaurant_id');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function advertisements()
    {
        return $this->hasMany('App\Advertisement', 'restaurant_id');
    }

    public function getLogoAttribute($value)
    {
        return asset("storage/{$value}");
    }


    public function getCategoryIdsAttribute()
    {
        $result = \DB::table('restaurant_categories')
            ->select('category_id')
            ->whereRestaurantId($this->id)
            ->orderBy('category_id')
            ->get();

        return $result->count() ? $result->pluck('category_id')->toArray() : [];
    }

    

    public function opening($day)
    {
        if($this->operatingHours()->exists()){
            return $this->operatingHours->where('operating_day', $day)->first()->opening;
        }
        return null;
    }

    public function closing($day)
    {
        if($this->operatingHours()->exists()){
            return $this->operatingHours->where('operating_day', $day)->first()->closing;
        }
        return null;
    }

    public function categoriesFlatArray()
    {
        return $this->categories->pluck('name')->toArray();
    }


    public function cuisinesFlatArray()
    {
        return $this->menu->pluck('categories')->map(function ($item) {
            return $item->pluck('name');
        })->flatten()->unique()->toArray();
    }

    public function cuisines()
    {
        return \DB::table('menu_categories_map AS mcm')
            ->select('mc.name', 'mc.id')
            ->join('menus AS m', 'm.id', '=', 'mcm.menu_id')
            ->join('menu_categories AS mc', 'mc.id', '=', 'mcm.menu_category_id')
            ->where('m.restaurant_id', '=', $this->id)
            ->get()
            ->pluck('name', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'restaurant_id');
    }

    public function getPendingOrdersCount()
    {
        return $this->orders()->pending()->count('id');
    }

    public function getAverageRating()
    {
        return $this->reviews()->avg('rating');
    }


    public function getOrdetStatusReport()
    {
        $all = [];

        $allOrders = $this->orders()->count();

        $allResult = $this->orders()->select(DB::raw('COUNT(id) AS num, order_status'))
                ->groupBy('order_status')
                ->get()
                ->pluck('num', 'order_status');
        
        $all['Pending'] = array_get($allResult, Order::STATUS_PENDING, 0);
        $all['Approved'] = array_get($allResult, Order::STATUS_APPROVED, 0);
        $all['Rejected'] = array_get($allResult, Order::STATUS_CANCELLED, 0);


        return [
            'summary' => $allOrders,
            'details' =>  $all
        ];
    }

    public function getTopSellersReport()
    {
        $result = DB::table('orders')
            ->select(DB::raw('SUM(order_lines.quantity) AS quantity, menus.name'))
            ->where('orders.restaurant_id', $this->id)
            ->join('order_lines', 'order_lines.order_id', '=', 'orders.id')
            ->join('menus', 'menus.id', '=', 'order_lines.menu_id')
            ->groupBy('menus.id')
            ->orderBy('quantity', 'DESC')
            ->get()
            ->pluck('quantity', 'name')
            ->toArray();

        $total = array_sum(array_values($result));

        return [
            'summary' => $total,
            'details' => $result
        ];
    }



 
    public function getDailySalesReport()
    {
        $morning = ['08:00:00', '11:59:00'];
        $afternoon = ['12:00:00', '17:59:00'];
        $evening = ['18:00:00', '23:59:00'];
        

        $data = DB::table('orders')
            ->select(DB::raw("SUM(CASE WHEN order_time BETWEEN '{$morning[0]}' AND '{$morning[1]}' THEN 1 ELSE 0 END) AS morning_count"))
            ->addSelect(DB::raw("SUM(CASE WHEN order_time BETWEEN '{$afternoon[0]}' AND '{$afternoon[1]}' THEN 1 ELSE 0 END) AS afternoon_count"))
            ->addSelect(DB::raw("SUM(CASE WHEN order_time BETWEEN '{$evening[0]}' AND '{$evening[1]}' THEN 1 ELSE 0 END) AS evening_count"))
            ->where('orders.order_status', Order::STATUS_APPROVED)
            ->where('orders.restaurant_id', $this->id)
            ->first();

        $result['Morning'] = $data->morning_count ?: 0;
        $result['Afternoon'] = $data->afternoon_count ?: 0;
        $result['Evening'] = $data->evening_count ?: 0;
        
        $total = array_sum(array_values($result));

        // dd($result);
        return [
            'summary' => $total,
            'details' => $result
        ];  

        

    }


    public function isApproved()
    {
        return (bool)$this->approved_at;
    }

    public function getStatusAttribute()
    {
        return $this->isApproved() ? 'a' : 'p';
    }
   

   public function scopeApproved($query)
   {
       return $query->whereNotNull('approved_at');
   }

}

