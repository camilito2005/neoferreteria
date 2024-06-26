<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Producto as ModelsProducto;

class PageController extends Controller
{
    /**
     * Display icons page
     *
     * @return \Illuminate\View\View
     */
    public function icons()
    {
        $productos = ModelsProducto::all();
        return view('administrador.pages.icons', compact('productos'));
    }

    /**
     * Display maps page
     *
     * @return \Illuminate\View\View
     */
    public function maps()
    {
        return view('administrador.pages.maps');
    }

    /**
     * Display tables page
     *
     * @return \Illuminate\View\View
     */
    public function tables()
    {
        return view('administrador.pages.tables');
    }

    /**
     * Display notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        $productos = ModelsProducto::all();
        return view('administrador.pages.notifications', compact('productos'));
    }

    /**
     * Display rtl page
     *
     * @return \Illuminate\View\View
     */
    public function rtl()
    {
        $productos = ModelsProducto::all();
        return view('administrador.pages.rtl', compact('productos'));
    }

    /**
     * Display typography page
     *
     * @return \Illuminate\View\View
     */
    public function typography()
    {
        return view('administrador.pages.typography');
    }

    /**
     * Display upgrade page
     *
     * @return \Illuminate\View\View
     */
    public function upgrade()
    {
        return view('administrador.pages.upgrade');
    }
    public function usuarios()
    {
        $usuarios = User::all();
        return view('administrador.pages.usuarios', compact('usuarios'));
    }
}
