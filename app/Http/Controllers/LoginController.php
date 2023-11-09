<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;


class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

       $user = User::where('email', $credentials['email'])->first();
       if(!$user){
        return response()->json(['message'=>"Email not found"], 401);
       }

        if (Auth::attempt($credentials)) {
            if($user->user_type_id <= 2){
                $token = $request->user()->createToken('auth-token-worker');
                return response()->json([
                    'token' => $token->plainTextToken,
                    'message' => 'Success'
                  ], 200);
            }
            $token = $request->user()->createToken('auth-token');
            return response()->json([
                'token' => $token->plainTextToken,
                'message' => 'Success'
              ], 200);

        }else{
            return response()->json([
                'message' => 'You password or email is wrong!'
              ], 401);
        }

    }

    function signUp(Request $request){
        $repitedEmail = User::where('email', $request->email)->count();
        if ($repitedEmail > 0) {
            return response()->json([
                'message' => 'This email already exists!'
            ],409);
        }
        return response()->json(['data'=>User::create($request->all())],200);
    }
    function logout(Request $request){
       $token = PersonalAccessToken::where('tokenable_id',$request->id) ->whereNotNull('last_used_at')
       ->latest('last_used_at')
       ->first();;
       if ($token->delete()) {
           
        return response()->json(
            [
                'status' => 'success',
                'message' => 'User logged out successfully'
            ]);
       }
       return response()->json(
        [
            'status' => 'error',
            'message' => 'User already logged out'
        ]);

  }


  
}
