<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotFoundController extends Controller
{
    public function __invoke()
    {
        return view('restaurant-not-found', [
            'categories' => \App\Category::all()->pluck('name', 'id')
        ]);
    }
}
