<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Http\Middleware\AdminMiddleware;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('software.inicio.principal');
    }
    public function index_uno()
    {
        return view('software.inicio.inicio-slider');
    }
//     public function inicioAdmin()
// {
//     $productos = Producto::all();
//     $dagra = Producto::orderByDesc('precio')->limit(12)->get();

//     $datosh = $dagra->pluck('precio')->toArray(); // Obtener solo los precios

//     return view('administrador.dashboard', compact('productos', 'datosh'));
// }
public function inicioAdmin()
{
    $productos = Producto::all();
    $dagra = Producto::orderByDesc('precio')->limit(12)->get();
    $datosl = $dagra->pluck('nombre')->toArray();
    $datosh = $dagra->pluck('precio')->toArray(); // Obtener solo los precios

    return view('administrador.dashboard', compact('productos', 'datosh', 'datosl'));
}
}
