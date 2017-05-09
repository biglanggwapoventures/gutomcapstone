<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Photo;
use Auth;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        return view('manage-restaurant.photos', [
            'restaurant' => Auth::user()->restaurant,
            'items' => $restaurant->photos()->orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'photos' => 'array',
            'photos.*' => 'image|max:2048'
        ]);

        $restaurant = Auth::user()->restaurant;

        $photos = [];
        if($request->hasFile('photos')) {
            foreach($request->file('photos') AS $photo){
                if(!$photo->isValid()) continue;
                $photos[] = new Photo([
                    'filename' => $photo->store("{$restaurant->id}/photos", 'public')
                ]);
            }
        }

        if($count = count($photos)){
            $restaurant->photos()->saveMany($photos);
            return redirect()->route('photos.index')->with('notification', "{$count} photos has been successfully uploaded!");
        }

        return redirect()->route('photos.index');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Photo::destroy($id);
        return redirect()->route('photos.index')->with('notification', 'Photo successfully deleted!');
    }
}
