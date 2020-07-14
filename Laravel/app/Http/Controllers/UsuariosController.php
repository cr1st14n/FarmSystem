<?php

namespace App\Http\Controllers;

use App\User;
use App\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;




class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

        if (!\Session::has('mov')) \Session::put('editModal', 0);
    }

    public function index()
    {
        \Session::put('editModal', 0);
        $editModal = \Session::get('editModal');

        $listUser =  usuarios::where('ca_estado', 1)->get();
        $countUser = usuarios::where('ca_estado', 1)->count('id');

        return view('users.homeUsers')
            ->with("editModal", $editModal)
            ->with("listUser", $listUser)
            ->with("countUser", $countUser);
    }
    public function listAllUser()
    {
        return usuarios::where('ca_estado', 1)->get();
    }
    public function create(Request $request)
    {
        $var = $request;
        $user = new usuarios;
        $user->usu_nombre = $request->input("nombre");
        $user->usu_appaterno = $request->input("AP");
        $user->usu_apmaterno = $request->input("AM");
        $user->usu_ci = $request->input("ci");
        $user->usu_acceso = $request->input("acceso");
        $user->ca_estado = 1;
        $user->usu_cargo = $request->input("cargo");
        $user->password = bcrypt(12345);
        $user->save();

        return redirect()->action('UsuariosController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function show(usuarios $usuarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return usuarios::where('id', $request->input('id'))->first();
        // \Session::put('editModal',1);
        // $editModal = \Session::get('editModal');

        // $usuario = usuarios::where('id',$id)->first();

        // $listUser =  usuarios::where('ca_estado',1)->get();
        // $countUser = usuarios::where('ca_estado',1)->count('id');

        // return view('users.homeUsers')
        //         ->with("listUser",$listUser)
        //         ->with("countUser",$countUser)
        //         ->with("editModal",$editModal)
        //         ->with("usuario",$usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, usuarios $usuarios)
    {
        $id = $request->input("id");
        $ci = $request->input("ci");
        $ver = usuarios::where('id', $id)->value('usu_ci');
        if ($ci == $ver) {
            $update = usuarios::where('id', $id)
                ->update([
                    'usu_nombre' => $request->input("nombre"),
                    'usu_appaterno' => $request->input("AP"),
                    'usu_apmaterno' => $request->input("AM"),
                    'usu_cargo' => $request->input("cargo")
                ]);
        } else {
            $validacion = validator::make($request->all(), [
                'usu_ci' => 'required|unique:users',
            ]);
            if ($validacion->fails()) {
                // return redirect()->back()->withInput()->withErrors($validacion);
                return "error1";
            }
            $update = usuarios::where('id', $id)
                ->update([
                    'usu_nombre' => $request->input("nombre"),
                    'usu_appaterno' => $request->input("AP"),
                    'usu_apmaterno' => $request->input("AM"),
                    'usu_ci' => $request->input("usu_ci"),
                    'usu_cargo' => $request->input("cargo")
                ]);
        }
        if ($update) {
            // \Session::flash('flash_success','Datos actualizados correctamente');
            // return redirect()->action('UsuariosController@index');
            return "success";
        } else {
            // \Session::flash('flash_danger','Error en actulizacion, vuela a interntarlo');
            // return redirect()->action('UsuariosController@index');
            return "fail";
        }



        return "asdfs";
    }

    public function update2(Request $request, usuarios $usuarios)
    {
        $id = Auth::user()->id;
        $ciActual = Auth::user()->usu_ci;
        $ciNew = $request->input("usu_ci");
        if ($ciActual == $ciNew) {
            $update = usuarios::where('id', $id)
                ->update([
                    'usu_nombre' => $request->input("nombre"),
                    'usu_appaterno' => $request->input("apaterno"),
                    'usu_apmaterno' => $request->input("aMaterno"),
                    'email' => $request->input("email"),
                    'usu_zona' => $request->input("zona"),
                    'usu_domicilio' => $request->input("domicilio")
                ]);
        } else {
            $validacion = validator::make($request->all(), [
                'usu_ci' => 'required|unique:users',
            ]);
            if ($validacion->fails()) {
                \Session::flash('flash_danger', 'Error CI ya registrada');
                return redirect()->back()->withInput()->withErrors($validacion);
            }
            $update = usuarios::where('id', $id)
                ->update([
                    'usu_ci' => $request->input("usu_ci"),
                    'usu_nombre' => $request->input("nombre"),
                    'usu_appaterno' => $request->input("apaterno"),
                    'usu_apmaterno' => $request->input("aMaterno"),
                    'email' => $request->input("email"),
                    'usu_zona' => $request->input("zona"),
                    'usu_domicilio' => $request->input("domicilio")
                ]);
        }
        if ($update) {
            \Session::flash('flash_success', 'Datos actualizados correctamente');
            return redirect()->action('UsuariosController@perfil');
        } else {
            \Session::flash('flash_danger', 'Error en actulizacion, vuela a interntarlo');
            return redirect()->action('UsuariosController@perfil');
        }



        return "Error! contactese con el ING SISTEMAS ";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $resul = usuarios::where('id', $request->input('id'))->update(['ca_estado' => 0,'usu_ci'=>null]);
        if ($resul) {
            return 'success';
            // \Session::flash('flash_success', 'Se elimino al usuario');
            // return redirect()->action('UsuariosController@index');
        }
        return 'fail';
        // \Session::flash('flash_danger', 'Se elimino al usuario');
        // return redirect()->action('UsuariosController@index');
    }

    public function acceso($id)
    {
        $acceso = usuarios::where('id', $id)->value('usu_acceso');
        if ($acceso == 1) {
            $res = usuarios::where('id', $id)->update(['usu_acceso' => 0]);
        } else {
            $res = usuarios::where('id', $id)->update(['usu_acceso' => 1]);
        }
        if ($res) {
            \Session::flash('flash_info', 'Acceso al sistema actualizado');
        } else {
            \Session::flash('flash_danger', 'Error vuelva a intentarlo');
        }
        return redirect()->action('UsuariosController@index');
    }

    public function perfil()
    {
        return view('users.perfilUser');
    }
    public function resetKey(Request $request)
    {
        $id = Auth::user()->usu_ci;
        $key = bcrypt($request->input("key"));
        $res = usuarios::where('usu_ci', $id)->update(['password' => $key]);
        if ($res) {
            \Session::flash('flash_success', 'Contraseña Actualizada');
        } else {
            \Session::flash('flash_danger', 'Error vuelva a intentarlo');
        }
        return redirect()->action('UsuariosController@perfil');
    }
    public function resetPasword($ci)
    {
        #return $ci;
        $res = usuarios::where('usu_ci', $ci)->update(['password' => (bcrypt("12345"))]);
        if ($res) {
            \Session::flash('flash_success', 'Contraseña reseteada');
            return redirect()->action('UsuariosController@index');
        } else {
            $res = usuarios::where('usu_ci', $ci)->update(['password' => (bcrypt("12345"))]);
            if ($res) {
                \Session::flash('flash_success', 'Contraseña reseteada');
                return redirect()->action('UsuariosController@index');
            } else {
                \Session::flash('flash_danger', 'Proceso fallifo Vuelva a intentarlo');
                return redirect()->action('UsuariosController@index');
            }
        }
    }
    public function resetKey1(Request $request)
    {
        $res=usuarios::where('id',$request->input('idUsu'))->update(['password'=>bcrypt('12345')]);
        return $res;
    }
}
