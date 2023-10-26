<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\LoginController;

class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

   

    function getUser($id){
        return User::find($id);
    }

    function editUser(Request $request, $token, $id){
        $loginController = new LoginController;
        $createdToken = json_decode($loginController->login($request));
        if ($token == $createdToken->token) {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                  ], 404);
            }
            $user->update($request->all());
            return response()->json([$user,
                'message' => 'Success'
            ],200);
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
