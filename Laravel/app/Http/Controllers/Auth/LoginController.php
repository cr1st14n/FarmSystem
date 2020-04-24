<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\usuarios;

use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm ()
    {
        return view('auth.loginFarm');
    }

    public function login(request $request)
    {
        $credenciales = $this->validate(request(),[
            'usu_ci' => 'required|string',
            'password' => 'required|string'
        ]);
        $usu_ci = $request->input("usu_ci");
        $password = $request->input("password");
        $acceso = usuarios::where('usu_ci',$usu_ci)->value('usu_acceso');
        
    //verificar ingreso
        if ($acceso == 1) {
            if (Auth::attempt(['usu_ci' => $usu_ci, 'password' => $password ])) {
                // The user is active, not suspended, and exists.
                return redirect()->route('home-administracion');  
                
            }
            \Session::flash('flash_login','Datos incorrectos');
            return back()->withErrors(['usu_ci' => trans('auth.failed'),'password' => trans('auth.failed')])->withInput(request(['usu_ci','password']));
        }else{
            \Session::flash('flash_login','Cuenta Bloqueada');
             return back()->withErrors(['usu_ci' => trans('auth.failed'),'password' => trans('auth.failed')])->withInput(request(['usu_ci','password']));
        }
        
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
