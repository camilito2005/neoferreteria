<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuarios_empleado;
use App\Models\Producto;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $usuarios = User::all();
        //$relaa = $usuarios->identificador;
        //$usuarios1 = User::join('usuarios_empleados', 'users.identificador', '=', 'usuarios_empleados.identificador_admin')
        //->where('users.identificador','=','usuarios_empleados.identificador_admin')
        //->get();
/*         $usuarioActualId = auth()->id();

        $usuarios1 = Usuarios_empleado::whereHas('user', function ($query) use ($usuarioActualId) {
            $query->where('id', '!=', $usuarioActualId);
        })->with('user:id,email')->get();

        return view('administrador.users.index', ['users' => $model->paginate(15)], compact('usuarios1'));
 */    
$usuarioActualId = auth()->user()->identificador;

$usuarios1 = User::where('identificador', $usuarioActualId)->get();

return view('administrador.users.index', ['users' => $model->paginate(15)], compact('usuarios1'));

}
}
