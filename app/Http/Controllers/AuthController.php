<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Register User
    public function register(Request $request){
        //Validate fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        //creat user
        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password'])
        ]);

        //return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }

    //Login user
    public function login(Request $request){
        //Validate fields
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // attempt login
        if (!Auth::attempt($attrs)) {
            return response([
                'message' => 'invalid credentials.'
            ],403);
        }

        //return user & token in response
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);
    }

    //logout user
    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout success.'
        ], 200);
    }

    //get user details
    public function user(){
        return response([
            'user' => auth()->user()
        ], 200);
    }

    // update user
    public  function update(){
        $attrs = $request->validate([
            'name' => 'required|string'
        ]);

        $image = $this->saveImage($request->$image, 'profiles');

        auth()->user()->update([
            'name' => $attrs['name'],
            'image' => $image
        ]);

        return response([
            'message' => 'User updated',
            'user' => auth()->user()
        ], 200);
    }
}
