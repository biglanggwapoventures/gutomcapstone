<?php

namespace App\Http\Middleware;

use Closure;

class ApprovedRestaurant
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

        $restaurant = \App\Restaurant::whereId($request->route('id'));

        if(!$restaurant->exists()){
            abort(404);
        }

        $restaurant = $restaurant->first();

        if(\Auth::check()){

            $user = \Auth::user();

            if($user->isAdmin() || $user->owns($restaurant)){
                return $next($request);
            }
            
        }
        

        return $restaurant->isApproved() ? $next($request) : redirect('/');
    }
}
