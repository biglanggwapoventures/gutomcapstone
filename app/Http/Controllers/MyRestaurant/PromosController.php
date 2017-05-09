<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\PromoRequest;
use App\Promo;

class PromosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        return view('manage-restaurant.promos.listing', [
            'restaurant' =>  $restaurant,
            'items' =>  $restaurant->promos()->orderBy('start_date')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-restaurant.promos.manage', [
            'restaurant' => Auth::user()->restaurant,
            'data' => new Promo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromoRequest $request)
    {
        $restaurant = Auth::user()->restaurant;
        
        $logoPath = $request->file('photo')->store("{$restaurant->id}/promos", 'public');

        $data = $request->only([
            'title',
            'start_date',
            'end_date',
            'description',
        ]);
        $data['photo'] = $logoPath;

        $promo = $restaurant->promos()->save(new Promo($data));

        return redirect()->intended(route('promos.index'));
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
        if(!Promo::whereId($id)->exists()){
            abort(404);
        }

        return view('manage-restaurant.promos.manage', [
            'restaurant' => Auth::user()->restaurant,
            'data' => Promo::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PromoRequest $request, $id)
    {
        if(!Promo::whereId($id)->exists()){
            abort(404);
        }

        $restaurant = Auth::user()->restaurant;
        
        if($request->hasFile('photo')){
            $logoPath = $request->file('photo')->store("{$restaurant->id}/promos", 'public');
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

        Promo::whereId($id)->update($data);

        return redirect()->intended(route('promos.edit', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Promo::destroy($id);
        return redirect()->intended(route('promos.index'));
    }
}
