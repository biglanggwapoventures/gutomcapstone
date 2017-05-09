<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Cart;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(CartRequest $request)
    {
        $previous = Auth::user()->cart()->whereMenuId($request->menu_id);
        if($previous->exists()){
            $previous->increment('quantity', $request->quantity);
            return response()->json([
                'result' => true
            ]);
        }

        $newItem = new Cart($request->only(['menu_id','quantity']));
        if(Auth::user()->cart()->save($newItem)){
            return response()->json([
                'result' => true
            ]);
        }
        return response()->json([
            'result' => false,
            'error' => 'An unknown error has occured. Please try again later'
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CartRequest $request, $id)
    {
        Cart::whereId($id)
            ->update([
                'quantity' => $request->quantity
            ]);
        
        return response()->json([
            'result' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartRequest $request, $id)
    {
        Cart::destroy($id);
        return response()->json([
            'result' => true
        ]);
    }
}
