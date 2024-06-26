<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // En app/Http/Middleware/AdminMiddleware.php

public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->rol === 'admin') {
        return $next($request);
    }

    abort(403, 'Acceso no autorizado');
}

// public function agregar(Request $request){
//     $guardar = new User();
//     $guardar->name = $request->name;
//     $guardar->email = $request->name . '@inventory.com';
//     $guardar->password = $request->password;

//     $guardar->save();
//     return back()->withStatus(__('Usuario creado correctamente.'));
// }

}
