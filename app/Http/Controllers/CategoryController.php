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

    public function addCategory(Request $request){
        $validated = $request->validate([
            'cat_name'=>'required'
        ]);
        if ($validated) {
           return response()->json(['data'=>Categories::create($request->all())],200);
        }
        return response()->json(['error'=>'El nombre de la categoria es requerido'],422);
    }

    public function editCategory(Request $request){
        $id = $request->query('id');
        $cat_name = $request->query('cat_name');

        $category = Categories::find($id);
        if ($category) {
            $category->cat_name = $cat_name;
            $category->save();
            return response()->json(['data'=> $category],200);
        }
        return response()->json(['error'=>'Categoria no encontrada'],422);
    }

    public function deleteCategory(Request $request){
        $id = $request->query('id');

        $category = Categories::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['data'=>$category],200);
        }
        return response()->json(['error'=>'Categoria no encontrada'],422);
    }
}
