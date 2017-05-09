<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RestaurantOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role == 'USER'){
            return redirect('/')->with('notification', 'Only restaurant owners are allowed on that page');
        }
        if(Auth::user()->hasRestaurant()){
            return $next($request);
        }
        return redirect()->route('restaurant-not-found');
    }
}
