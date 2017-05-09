<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\AdvertisementRequest;
use App\Advertisement;

class AdvertisementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage-restaurant.advertisements.listing', [
            'restaurant' => Auth::user()->restaurant,
            'items' => Advertisement::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-restaurant.advertisements.manage', [
            'restaurant' => Auth::user()->restaurant,
            'data' => new Advertisement
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementRequest $request)
    {
        $restaurant = Auth::user()->restaurant;
        
        $logoPath = $request->file('photo')->store("{$restaurant->id}/advertisements", 'public');

        $data = $request->only([
            'title',
            'start_date',
            'end_date',
            'description',
        ]);
        $data['photo'] = $logoPath;

        $promo = $restaurant->advertisements()->save(new Advertisement($data));

        return redirect()->intended(route('advertisements.index'));
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
        if(!Advertisement::whereId($id)->exists()){
            abort(404);
        }

        return view('manage-restaurant.advertisements.manage', [
            'restaurant' => Auth::user()->restaurant,
            'data' => Advertisement::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertisementRequest $request, $id)
    {
        if(!Advertisement::whereId($id)->exists()){
            abort(404);
        }

        $restaurant = Auth::user()->restaurant;
        
        if($request->hasFile('photo')){
            $logoPath = $request->file('photo')->store("{$restaurant->id}/advertisements", 'public');
        }

        $data = $request->only([
            'title',
            'start_date',
            'end_date',
            'description',
        ]);

        if(isset($logoPath)){
            $data['photo'] = $logoPath;
        }

        Advertisement::whereId($id)->update($data);

        return redirect()->intended(route('advertisements.edit', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Advertisement::destroy($id);
        return redirect()->intended(route('promos.index'));
    }
}
