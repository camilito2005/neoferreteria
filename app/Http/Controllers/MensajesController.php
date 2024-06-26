<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;

class MensajesController extends Controller
{
    public function mensajes(Request $request)
    {
        $mensaje = new Mensaje();
        $mensaje->mensaje = $request->mensaje;
        $mensaje->de_id = $request->de_id;
        $mensaje->de_nombre = $request->de_nombre;
        $mensaje->para_id = $request->para_id;
        $mensaje->para_nombre = $request->para_nombre;
        $mensaje->save();
return back()->withStatus('bien');
    }
}
