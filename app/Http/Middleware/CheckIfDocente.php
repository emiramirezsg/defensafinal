<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfDocente
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y si es un docente
        if (Auth::check() && Auth::user()->is_docente) {
            return $next($request);
        }

        // Redirige al usuario a la página principal o a una página de error
        return redirect('/')->with('error', 'Acceso denegado. Solo docentes pueden acceder a esta página.');
    }
}
