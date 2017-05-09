<?php

namespace App\Http\Controllers\MyRestaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Blog AS BlogPost;
use Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        return view('manage-restaurant.blog.listing', [
            'restaurant' => $restaurant,
            'items' => $restaurant->posts()->orderBy('created_at', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-restaurant.blog.manage', [
            'restaurant' => Auth::user()->restaurant,
            'data' =>  new BlogPost
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostRequest $request)
    {
        $restaurant = Auth::user()->restaurant;

        $data = $request->only([
            'title',
            'body',
        ]);

        $data['published'] = $request->has('published') && (bool)$request->published;
        $data['photo'] = $request->file('photo')->store("{$restaurant->id}/blog", 'public');


        $post = $restaurant->posts()->save(
            new BlogPost($data)
        );

        return redirect()->intended(route('blog.index'));

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
        if(!BlogPost::whereId($id)->exists()){
            abort(404);
        }

        return view('manage-restaurant.blog.manage', [
            'restaurant' => Auth::user()->restaurant,
            'data' => BlogPost::find($id)
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
        if(!BlogPost::whereId($id)->exists()){
            abort(404);
        }

        $restaurant = Auth::user()->restaurant;

        $data = $request->only([
            'title',
            'body',
        ]);

        $data['published'] = $request->has('published') && (bool)$request->published;
        if($request->hasFile('photo')){
            $data['photo'] = $request->file('photo')->store("{$restaurant->id}/blog", 'public');
        }

        BlogPost::whereId($id)->update($data);

        return redirect()->intended(route('blog.edit', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlogPost::destroy($id);
        return redirect()->intended(route('blog.index'));
    }
}
