<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\LoginController;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, HasApiTokens;

    /* USER */

    function getUser($user_name)
    {
        if (auth()->user()->tokenCan('auth-token')) {
            if ($user_name) {
                $user = User::where('user_name', $user_name)->get();
                if ($user) {
                    return $user;
                } else {
                    return response()->json(['error' => 'Usuer not found'], 404);
                }
            } else {
                return response()->json(['error' => 'User name is required'], 400);
            }
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    function editUser(Request $request)
    {
        if (auth()->user()->tokenCan('auth-token')) {
            $user = User::find($request->id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }
            $user->update($request->all());
            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);

    }

    function deleteUser(Request $request)
    {
        if (auth()->user()->tokenCan('auth-token')) {
            $user = User::find($request->id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }
            $user->delete();
            return response()->json([
                'message' => 'Deleted Successfully!',
                'data' => $user
            ], 200);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    /** PRODUCTS  **/
}
