<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\RestaurantOperatingHours AS OpHours;

class OperatingHoursController extends Controller
{
    public function showForm()
    {
        return view('manage-restaurant.operating-hours', [
            'restaurant' => Auth::user()->restaurant
        ]);
    }

    public function doSave(Request $request)
    {
        $restaurant = Auth::user()->restaurant;
        $rules = [];
        $messages = [];

        for($x = 1; $x <= 7; $x++){
            $rules["days.$x.opening"] = "required_with:days.$x.closing|date_format:\"g:i A\"";
            $rules["days.$x.closing"] = "required_with:days.$x.opening|date_format:\"g:i A\"";
        }

        $this->validate($request, $rules);

        $hours = [];
        for($x = 1; $x <= 7; $x++){
            $hours[] = new OpHours([
                'operating_day' => $x,
                'opening' => $request->input("days.$x.opening") ? date_create_from_format('g:i A', $request->input("days.$x.opening"))->format('H:i') : null,
                'closing' => $request->input("days.$x.closing") ? date_create_from_format('g:i A', $request->input("days.$x.closing"))->format('H:i') : null,
            ]);
        }
        $restaurant->operatingHours()->delete();
        $restaurant->operatingHours()->saveMany($hours);

        return redirect()->intended('/my-restaurant/operating-hours');

    }
}
