<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //

   

    public function register(Request $request)
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
    }

    public function login(Request $request){


    	if(!Auth::attempt($request->only('email','password')))
    	 {
               return response([

                  'message' => 'Invalid credentials!'
                
                ], Response::HTTP_UNAUTHORIZED);
    	 }
             $user = Auth::user();
             $token = $user->createToken('token')->plainTextToken;
             $cookie = cookie('jwt', $token, 60 * 24); // 1 day

             // return response and send to backend using cookie
              return response([
                      'message' => $token
                       ])->withCookie($cookie);

    }//login

     public function user(){

    	return Auth::user();
    }
}//mail class
