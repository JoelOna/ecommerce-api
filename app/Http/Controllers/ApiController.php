<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\LoginController;
use Laravel\Sanctum\PersonalAccessToken;

class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

   function compareTokens(Request $request , $id){
    $tokenHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $tokenHeader);
        $accessToken = PersonalAccessToken::where('tokenable_id',$id)->first();
        return hash_equals($accessToken->token, hash('sha256', $token));
   }

   /* USER */

    function getUser($id){
        return User::find($id);
    }

    function editUser(Request $request, $id){
        if ($this->compareTokens($request, $id)) {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                  ], 404);
            }
            $user->update($request->all());
            return response()->json(['user'=> $user,
                'message' => 'Success'
            ],200);
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    function deleteUser(Request $request, $id){
        if ($this->compareTokens($request, $id)) {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                        ],404);
            }
            $user->delete();
            return response()->json([
                'message' => 'Deleted Successfully!'
            ],200);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ],401);
    }

    /** PRODUCTS  **/
}
