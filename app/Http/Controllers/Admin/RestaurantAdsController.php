<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Advertisement AS Ad;

class RestaurantAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Ad::with('restaurant')->orderBy('id', 'DESC');
        if($request->has('status')){
            switch($request->status){
                case Ad::STATUS_APPROVED: 
                     $items->approved();
                     break;
                case Ad::STATUS_REJECTED:  
                    $items->rejected();
                    break;
                default:  
                    $items->pending();
                    break;
            }
        }else{
             $items->pending();
        }
        return view('admin.restaurant-ads.listing', [
            'items' => $items->get()
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
        if(!Ad::whereId($id)->exists()){
            abort(404);
        }

        return view('admin.restaurant-ads.manage', [
            'data' => Ad::with('restaurant')->whereId($id)->first()
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
        $ad = Ad::whereId($id);
        if(!$ad->exists()){
            abort(404);
        }
        
        $rules = [
            'title' => "required|unique:advertisements,title,{$id}",
            'description' => 'required|max:255',
            'status' => 'required|in:APPROVED,REJECTED',
        ];

        $this->validate($request, $rules);

        $ad->update($request->only(array_keys($rules)));;

        return redirect()->route('restaurant-ads.index', [
            'status' => $request->status
        ])->with('notification', 'Restaurant ad has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ad::destroy($id);
        return redirect()->route('restauran-ads.index')->with('notification', 'Restaurant ad has been successfully deleted');
    }
}
