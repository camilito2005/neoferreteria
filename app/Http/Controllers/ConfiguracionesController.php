<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\daf;
class ConfiguracionesController extends Controller
{
    public function yo()
    {
        return view('yo');
    }
    public function agregarUsuario(Request $request){
        $guardar = new User();
        $guardar->name = $request->name;
        $guardar->email = $request->email . '@inventory.com';
        $guardar->password = $request->password;
        $guardar->rol = 'admin';
        $guardar->identificador = $request->identificador;
        $guardar->save();
        $daf = new daf();
        $daf->daf = 0;
        $daf->dafVenta = 0;
        $daf->dafTotal = 0;
        $daf->id_dd = $guardar->id;
        $daf->id = $guardar->id;
        $daf->iden_dd = $request->identificador;
        $daf->save();
/*

        $empleado = new Usuarios_empleado();
        $empleado->nombre_admin = $request->nombre_admin;
        $empleado->nombre_empleado = $request->name;
        $empleado->identificador_admin = $request->identificador_admin;
        $empleado->estado = 'activo';
        $empleado->save(); */
        return back()->withStatus(__('Usuario creado correctamente.'));
    }

    public function getDateTime()
    {
        return response()->json(['datetime' => now()]);
    }
}
