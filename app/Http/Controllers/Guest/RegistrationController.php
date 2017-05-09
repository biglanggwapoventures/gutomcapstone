<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class RegistrationController extends Controller
{
    public function doRegister(Request $request)
    {
        $rules = [
            'username' => 'required|max:30|unique:users',
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'contact_number' => 'required|max:20',
            'password' => 'required|min:4|confirmed',
            'role' => 'required|in:USER,OWNER',
        ];

        $this->validate($request, $rules);

        $data = $request->only(array_keys($rules));
        $data['password'] = Hash::make($data['password']);
        // $data['role'] = User::ROLE_USER;

        $user = User::create($data);

    Auth::login($user);

        if($data['role'] === User::ROLE_USER){
            return redirect('/')->with('notification', 'Thank you for registering! Enjoy browsing!');
        }

        return redirect('/my-restaurant')->with('notification', 'Thank you for registering! Start by creating your restaurant profile!');
    }

    public function showRegistrationForm()
    {
        return view('guest.registration-form');
    }
}
