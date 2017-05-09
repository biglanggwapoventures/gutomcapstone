<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Restaurant;

class ViewRestaurantController extends Controller
{


    public function overview($id)
    {
        return view('restaurant.overview', [
            'restaurant' => Restaurant::with(['operatingHours', 'categories'])->whereId($id)->first(),
            'nav' => 'overview'
        ]);
    }

    public function blog($id)
    {
        return view('restaurant.blog', [
            'restaurant' => Restaurant::with('posts')->whereId($id)->first(),
            'nav' => 'blog'
        ]);
    }

    public function menu($id, Request $request)
    {
        $categoryId = $request->category;
        $restaurant = Restaurant::with(['menu' => function($q) USE ($categoryId){
            if($categoryId){
                $q->whereHas('categories', function($q) USE ($categoryId){
                    $q->where('menu_category_id', $categoryId);
                });
            }
        }])->whereId($id)->first();
        return view('restaurant.menu', [
            'restaurant' => $restaurant,
            'categories' => $restaurant->cuisines(),
            'nav' => 'menu',
        ]);
    }

    public function cart($id)
    {
        return view('restaurant.cart', [
            'restaurant' => Restaurant::whereId($id)->first(),
            'cart' => Auth::user()->cartContents($id),
            'nav' => 'cart'
        ]);
    }

    public function ads($id)
    {
        return view('restaurant.ads', [
            'restaurant' => Restaurant::with(['advertisements' => function($q){
                $q->approved()->orderBy('id', 'DESC');
            }])->whereId($id)->first(),
            'nav' => 'ads'
        ]);
    }

    public function promos($id)
    {
        return view('restaurant.promos', [
            'restaurant' => Restaurant::with(['promos' => function($q){
                $q->orderBy('start_date');
            }])->whereId($id)->first(),
            'nav' => 'promos'
        ]);
    }

    public function photos($id)
    {
        return view('restaurant.photos', [
            'restaurant' => Restaurant::with(['photos' => function($q){
                $q->orderBy('id', 'DESC');
            }])->whereId($id)->first(),
            'nav' => 'photos'
        ]);
    }

    public function reviews($id)
    {
        $restaurant =  Restaurant::with([
            'reviews' => function($q){
                $q->with('user')->orderBy('id', 'DESC');
            }
        ])->whereId($id)->first();

        if( Auth::check() ){
            $userReview = $restaurant->reviews()->whereUserId(Auth::id())->first();
        }else{
            $userReview = null;
        }

        return view('restaurant.reviews', [
            'restaurant' => $restaurant,
            'nav' => 'reviews',
            'review' => $userReview,
        ]);
    }

    public function saveReview($id, Request $request)
    {
        $rules = [
            'feedback' => 'present',
            'rating' => 'required|in:1,2,3,4,5',
        ];

        $this->validate($request, $rules);

        $input = $request->only(array_keys($rules));
        $input += [
            'user_id' => Auth::id(),
            'restaurant_id' => $id
        ];

        $rating = \App\Review::create($input);
        return redirect()->route('restaurant.reviews', ['id' => $id])->with('notification', 'Your review has been successfully posted!');
    }
}
