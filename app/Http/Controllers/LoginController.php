<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('token');
            return response()->json([
                'token' => $token->plainTextToken,
                'message' => 'Success'
              ], 200);

        }else{
            return response()->json([
                'message' => 'Unauthorized'
              ], 401);
        }

    }

    function signUp(Request $request){
        $repitedEmail = User::where('email', $request->email);
        if ($repitedEmail) {
            return response()->json([
                'message' => 'This email already exists!'
            ],409);
        }
        return response()->json([User::create($request->all())],200);
    }

  
}