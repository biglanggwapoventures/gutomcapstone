<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantDetailsRequest;
use App\Restaurant;

class RegisterController extends Controller
{
    public function __invoke(RestaurantDetailsRequest $request)
    {
        $data = $request->only([
            'name',
            'address',
            'contact_number',
            'description',
        ]);
        $data['created_by'] = $request->user()->id;
        $restaurant = Restaurant::create($data);
        
        $logoPath = $request->file('logo')->store("{$restaurant->id}/logo", 'public');
        $restaurant->logo = $logoPath;
        $restaurant->save();

        $restaurant->categories()->sync($request->input('categories'));

        return redirect()->intended('/my-restaurant'); 
    }
}
