<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    //
    public function getCategories(){
        return response()->json(['data' => Categories::all()],200);
    }
}
