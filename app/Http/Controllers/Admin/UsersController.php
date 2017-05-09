<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('firstname');
        if(in_array($request->account_type, [User::ROLE_USER, User::ROLE_RESTAURANT_OWNER])){
            $users->where('role', '=', $request->account_type);
        }
        if(strlen(trim($request->name_keyword))){
            $keyword = addslashes($request->name_keyword);
            $users->whereRaw("CONCAT(firstname, ' ', lastname) LIKE '%{$keyword}%'");
        }
        return view('admin.users.listing', [
            'items' => $users->paginate(10)
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
        $data = User::findOrFail($id);
        
        return view('admin.users.manage', [
            'data' => $data
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
        $user = User::findOrFail($id);

        $this->validate($request, [
            'password' => 'present|confirmed',
            'role' => 'required|in:USER,OWNER',
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
            'username' => "required|unique:users,username,{$user->id}",
            'email' => "required|email|unique:users,email,{$user->id}",
            'contact_number' => 'required|max:20'
        ]);

        $user->fill($request->only(['email', 'contact_number', 'role', 'username', 'firstname', 'lastname']));

        if(strlen(trim($request->password))){
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('users.index')->with('notification', 'User has been updated successfully!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index')->with('notification', 'User has been successfully deleted');
    }
}
