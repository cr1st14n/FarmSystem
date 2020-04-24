<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {   
        if (Auth::guard($guard)->check()) {
        $usu_modulo = Auth::user()->usu_modulo;
            switch ($usu_modulo) {
                case 'administracion':
                    # code...
                        return redirect()->route('home-administracion');
                    break;
                case 'operador':
                    # code...
                    break;
                case 'visitante':
                    # code...
                    break;
                default:
                    # code...
                    break;
            }

            return redirect('/Adm/home');
        }

        return $next($request);
    }
}
