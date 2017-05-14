<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\MenuItemRequest;
use App\Menu;
use App\MenuCategory;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        return view('manage-restaurant.menu.listing', [
            'restaurant' => Auth::user()->restaurant,
            'items' => $restaurant->menu()->with('categories')->orderBy('name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-restaurant.menu.manage', [
            'restaurant' => Auth::user()->restaurant,
            'categories' => MenuCategory::dropdownFormat(),
            'data' => new Menu
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuItemRequest $request)
    {
        $restaurant = Auth::user()->restaurant;
        
        $logoPath = $request->file('photo')->store("{$restaurant->id}/menu", 'public');

        $data = $request->only([
            'name',
            'price',
            'description',
            'preparation',
        ]);
        $data['photo'] = $logoPath;
        $data['available'] = (bool)$request->available;

        $menu = $restaurant->menu()->save(new Menu($data));
        $menu->categories()->sync($request->input('categories'));

        return redirect()->route('menu.index')->with('notification', "New product: \"{$menu->name}\" has been successfully added!");;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Menu::whereId($id)->exists()){
            abort(404);
        }

        return view('manage-restaurant.menu.manage', [
            'restaurant' => Auth::user()->restaurant,
            'categories' => MenuCategory::dropdownFormat(),
            'data' => Menu::find($id)
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
        if(!Menu::whereId($id)->exists()){
            abort(404);
        }
        
        $restaurant = Auth::user()->restaurant;

        if($request->hasFile('photo')){
            $logoPath = $request->file('photo')->store("{$restaurant->id}/menu", 'public');
        }

        $data = $request->only([
            'name',
            'price',
            'description',
            'preparation',
        ]);
        $data['available'] = (bool)$request->available;

        if(isset($logoPath)){
            $data['photo'] = $logoPath;
        }

        $menu = $restaurant->menu()->whereId($id)->first();
        $menu->update($data);
        $menu->categories()->sync($request->input('categories'));

        return redirect()->route('menu.edit', ['id' => $menu->id])->with('notification', "Product \"{$menu->name}\" has been successfully updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::destroy($id);
        return redirect()->intended(route('menu.index'));
    }
}
