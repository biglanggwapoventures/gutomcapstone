<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;

class ProfileController extends Controller
{
    public function showForm()
    {
        return view('profile', [
            'user' => Auth::user()
        ]);
    }   

    public function doUpdate(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'password' => 'present|confirmed',
            'photo' => 'image|max:2048',
            'email' => "required|email|unique:users,email,{$user->id}",
            'contact_number' => 'required|max:20'
        ]);

        $user->fill($request->only(['email', 'contact_number']));

        if(strlen(trim($request->password))){
            $user->password = Hash::make($request->password);
        }
        
        if($request->hasFile('photo')){
            $user->display_photo = $request->file('photo')->store(
                "user/{$user->id}/display-photo", 'public'
            );
        }
        
        $user->save();

        return redirect('profile')->with('profile.update.status', true);
    }
}
