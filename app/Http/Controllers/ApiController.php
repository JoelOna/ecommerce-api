<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function createUser (Request $request){
        return User::create($request->all());
    }

    function getUser($id){
        return User::find($id);
    }
}
