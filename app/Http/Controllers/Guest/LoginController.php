<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('guest.login-form');
    }
    public function doLogin(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $this->validate($request, $rules);

        $credentials = $request->only(array_keys($rules));

        if(Auth::attempt($credentials)){
            if(Auth::user()->isAdmin()){
                return redirect('/admin');
            }elseif(Auth::user()->role === 'OWNER'){
                 return redirect()->route('food-orders.index')->with('notification', 'Welcome, '.Auth::user()->fullname().'!');
            }
            return redirect('/')->with('notification', 'Welcome, '.Auth::user()->fullname().'!');;
        }

        return redirect()
            ->intended('/login')
            ->withInput()
            ->with('loginError', true);

    }
}
