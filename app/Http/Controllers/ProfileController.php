<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\Producto;
use App\Models\Usuarios_empleado;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('administrador.profile.edit');
    }
    public function loginn(){
        return view('administrador.auth.login_inicio');
    }
    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Perfil actualizado correctamente.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Contraseña actualizada correctamente.'));
    }
    public function agregarUsuario(Request $request){
        $guardar = new User();
        $guardar->name = $request->name;
        $guardar->email = $request->name_correo . '@inventory.com';
        $guardar->password = $request->password;
        $guardar->rol = 'empleado';
        $guardar->identificador = $request->identificador_admin;

        $guardar->save();
        $empleado = new Usuarios_empleado();
        $empleado->nombre_admin = $request->nombre_admin;
        $empleado->nombre_empleado = $request->name;
        $empleado->identificador_admin = $request->identificador_admin;
        $empleado->estado = 'activo';
        $empleado->save();
        return back()->withStatus(__('Usuario creado correctamente.'));
    }

    public function agregarruta(){
        return view('administrador.profile.crearusuario');

    }
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function eliminar($id){
      $user = User::find($id)->delete();
        return back()->withStatus('Usuario eliminado correctamente.');
    }

    //  public function cambiar_rol (Request $request, User $user){
    //     request()->validate(User::$rules);
    //     $user->update($request->all());
    //     return back()->withPasswordStatus('success', 'Producto eliminado correctamente.');
    //  }
     public function cambiarRol(Request $request, User $user, $nuevoRol)
{
    $user->update(['rol' => $nuevoRol]);
    return back()->withStatus('Rol cambiado exitosamente.');
}

}
