<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ReportsController extends Controller
{

    private $restaurant = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->restaurant = Auth::user()->restaurant;
            return $next($request);
        });
    }

    public function orderStatus()
    {
        $restaurant = $this->restaurant;
        return view('manage-restaurant.reports.order-status', [
            'restaurant' =>  $restaurant,
            'nav' => 'order-status',
            'data' =>  $restaurant->getOrdetStatusReport()
        ]);
    }

    public function topSellers()
    {
        $restaurant = $this->restaurant;
        return view('manage-restaurant.reports.top-sellers', [
            'restaurant' =>  $restaurant,
            'nav' => 'order-status',
            'data' =>  $restaurant->getTopSellersReport()
        ]);
    }

    public function dailySales()
    {
        $restaurant = $this->restaurant;
        return view('manage-restaurant.reports.daily-sales', [
            'restaurant' => $restaurant,
            'nav' => 'order-status',
            'data' =>  $restaurant->getDailySalesReport()
        ]);
    }
}
