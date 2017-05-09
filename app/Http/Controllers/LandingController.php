<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use App\Advertisement AS Ad;

class LandingController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = $request->only(['q', 'v']);
        $restaurants = Restaurant::with([
            'categories', 
            'menu.categories',
        ])
        ->approved()
        ->select([
            'restaurants.id', 
            'restaurants.name', 
            'restaurants.logo', 
            'restaurants.created_by', 
            'restaurants.address', 
            'restaurants.description', 
            'restaurants.contact_number',
            \DB::raw('AVG(r.rating) AS average_rating')
        ])
        ->leftJoin('reviews AS r', 'r.restaurant_id', '=', 'restaurants.id')
        ->groupBy('restaurants.id');

        $ads = Ad::approved()->ongoing()->with(['restaurant' => function($q){
            $q->select('id', 'name');
        }])->limit(5)->inRandomOrder()->get();

        if(trim($q['v'])){
            switch($q['q']){
                case 'restaurant-type':
                    $restaurants->whereHas('categories', function($query) USE ($q){
                        $query->where('name', 'like', "%{$q['v']}%");
                    });
                    break;
                case 'restaurant-name':
                    $restaurants->where('name', 'like', "%{$q['v']}%");
                    break;
                case 'food': 
                    $restaurants->whereHas('menu', function($query) USE ($q){
                        $query->where('name', 'like', "%{$q['v']}%");
                    });
                    break;
                case 'location': 
                    $restaurants->where('address', 'like', "%{$q['v']}%");
                    break;
                default:

                    $restaurants->where('name', 'like', "%{$q['v']}%")
                    ->orWhereHas('categories', function($query) USE ($q){
                        $query->where('name', 'like', "%{$q['v']}%");
                    })
                    ->orWhereHas('menu', function($query) USE ($q){
                        $query->where('name', 'like', "%{$q['v']}%");
                    })
                    ->orWhere('address', 'like', "%{$q['v']}%");

                    break;
            }
        }
        return view('welcome', [
            'results' => $restaurants->get(),
            'ads' => $ads
        ]);
    }
}
