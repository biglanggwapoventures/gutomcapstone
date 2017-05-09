<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Restaurant;

class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Restaurant::with('owner');

        if ($request->status === 'a'){
            $items->whereNotNull('approved_at');
        }else if ($request->status === 'p') {
            $items->whereNull('approved_at');
        }

        if (strlen(trim($request->name_keyword))) {
            $items->where('name', 'like', "%{$request->name_keyword}%");
        }

        return view('admin.restaurants.listing', [
            'items' => $items->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Restaurant::findOrFail($id);

        return view('admin.restaurants.manage', [
            'data' => $data,
            'categories' => \App\Category::all()->pluck('name', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $rules = [
            'name' => "required|unique:restaurants,name,{$restaurant->id}|max:50",
            'address' => 'required|max:255',
            'contact_number' => 'required|max:255',
            'description' => 'required|max:255',
        ];
        
        $this->validate($request, $rules + [
            'categories' => 'required|array',
            'categories.*' => 'required|exists:categories,id',
            'status' => 'required|in:a,p'
        ]);

        $data = $request->only(array_keys($rules));
        $data['approved_at'] = $request->input('status') === 'a' ? date_create(null)->format('Y-m-d H:i:s') : null;

        $restaurant->update($data);
        $restaurant->categories()->sync($request->input('categories'));

        return redirect()->route('restaurants.index')->with('notification', 'Restaurant has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Restaurant::destroy($id);
        return redirect()->route('restaurants.index')->with('notification', 'Restaurant has been successfully deleted');
    }
}
