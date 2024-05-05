<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('register');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required | min:3 | max:40 | string',
            'email' => 'required | regex:/(.*)@gmail\.com/ | string | unique:users',
            'pass' => 'required | min:6 | max:12 | string',
            'confpass' => 'required | min:6 | max:12 | string',
            'phone_num' => 'required | regex:/^08/'
        ]);

        if($request->pass != $request->confpass){
            return back()->withErrors('the password didn\'t match');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->pass),
            'phone_num' => $request->phone_num,
            'is_admin' => 0,
        ]);
        return redirect('/login')->with('success', 'User registered!');
    }
}
