<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Category;

class OverviewController extends Controller
{
    public function showForm()
    {
        return view('manage-restaurant.overview', [
            'restaurant' => Auth::user()->restaurant,
            'categories' => Category::dropdownFormat(),
        ]);
    }

    public function doSave(Request $request)
    {
        $restaurant = Auth::user()->restaurant;
        $rules = [
            'name' => "required|unique:restaurants,name,{$restaurant->id}|max:50",
            'address' => 'required|max:255',
            'contact_number' => 'required|max:255',
            'description' => 'required|max:255',
            'policy' => 'required|max:255',
        ];
        
        $this->validate($request, $rules + [
            'categories' => 'required|array',
            'categories.*' => 'required|exists:categories,id',
        ]);

        $data = $request->only(array_keys($rules));

        $restaurant->update($data);
        $restaurant->categories()->sync($request->input('categories'));

        return redirect()->intended('/my-restaurant'); 

    }
}
