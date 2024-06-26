<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // public function guardar_categoria(Request $request){
    //     $category = new Category;
    //     $category->categoria_producto = $request->categoria_producto;
    //     $category->save();
    //     return back()->withStatus(__('Categoria creada correctamente.'));
    // }


public function guardar_categoria(Request $request)
{
    $category = new Category;
    $category->categoria_producto = $request->categoria_producto;
    $category->save();

    return response()->json(['mensaje' => 'Categoría creada correctamente']);
}


}
