<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpleadoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // En app/Http/Middleware/AdminMiddleware.php

public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->rol === 'empleado') {
        return $next($request);
    }
    
    
    abort(403, 'Acceso no autorizado');
}

}