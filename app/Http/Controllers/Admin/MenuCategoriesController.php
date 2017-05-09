<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MenuCategory;
use App\Http\Requests\MenuCategoryRequest;

class MenuCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.menu-categories.listing', [
            'items' => MenuCategory::select('id', 'name', 'description')->orderBy('name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menu-categories.manage', [
            'data' => new MenuCategory
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuCategoryRequest $request)
    {
        MenuCategory::create($request->only([
            'name',
            'description'
        ]));

        return redirect()->intended(route('menu-categories.index'));
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
        if(!MenuCategory::whereId($id)->exists()){
            abort(404);
        }

        return view('admin.menu-categories.manage', [
            'data' => MenuCategory::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuCategoryRequest $request, $id)
    {
        if(!MenuCategory::whereId($id)->exists()){
            abort(404);
        }

        MenuCategory::whereId($id)->update($request->only([
            'name',
            'description'
        ]));

        return redirect()->intended(route('menu-categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MenuCategory::destroy($id);
        return redirect()->intended(route('menu-categories.index'));
    }
}
