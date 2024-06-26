<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Category;
use App\Models\Proveedor;


use Illuminate\Http\Request;
use Illuminate\Support\Str;

class paginacontrolador extends Controller
{
    public function inicio(){
        $card = Producto::all();
        return view("software.inicio.inicio-slider", compact("card"));
    }
    public function agregar(){
        $proveedores = Proveedor::all();
        $categorias = Category::all();
        $lon = 10;
        $token = Str::random($lon);
        return view("software.producto.agregar", compact('categorias', 'proveedores', 'token'));
    }

    public function token(){
        $lon = 10;
        $token = Str::random($lon);
        return response()->json(['referencia' => $token]);
    }

    public function login(){
        return view("software.auth.login");
    }
    public function registro(Request $request){
        $usuario = new paginacontrolador();
        return view("software.login.registro");
    }
    public function inicioajax(Request $request){
        return view("hola");
    }
    public function principal(){
        return view("software.inicio.inicio-slider");
    }
     public function graficas(){
        return view('software.graficas.graficas');
     }
     public function cuenta(){
        return view("software.cuenta.empleado");
     }
}
