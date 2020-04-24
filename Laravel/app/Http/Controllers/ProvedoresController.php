<?php

namespace App\Http\Controllers;

use App\provedores;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProvedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('proveedor.homeProveedor');
        return provedores::get();
        $listProvedor = provedores::get();
        $resulLisArt = provedores::count("id");
        if ($resulLisArt != 0) {
            $resulLisArt = 1;
        } else {
            $resulLisArt = 0;
        }
        //return "$resulLisArt  $listProvedor";
        return view('proveedor.homeProveedor')->with("listProvedor", $listProvedor)->with("resulLisArt", $resulLisArt);
    }
    public function list()
    {
        return provedores::get();
        $listProvedor = provedores::get();
        $resulLisArt = provedores::count("id");
        if ($resulLisArt != 0) {
            $resulLisArt = 1;
        } else {
            $resulLisArt = 0;
        }
        //return "$resulLisArt  $listProvedor";
        return view('proveedor.homeProveedor')->with("listProvedor", $listProvedor)->with("resulLisArt", $resulLisArt);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $prov = new provedores;
        $prov->prov_nombre = $request->input("nombre");
        $prov->prov_direccion = $request->input("direccion");
        $prov->prov_telf = $request->input("telf");
        $prov->prov_empresa = $request->input("empresa");
        $prov->ca_cod_usu = Auth::user()->usu_ci;
        $prov->ca_tipo = "create";
        $prov->ca_fecha = Carbon::now();
        $res = $prov->save();
        if ($res) {
            # code...
            \Session::flash('flash_info', 'Provedor redistrado exitosamente');
            return redirect()->action('ProvedoresController@index');
        } else {
            \Session::flash('flash_danger', 'Error en el registro vuela a intentarlo');
            return redirect()->action('ProvedoresController@index');
        }
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
     * @param  \App\provedores  $provedores
     * @return \Illuminate\Http\Response
     */
    public function show(provedores $provedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\provedores  $provedores
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return provedores::where('id', $request->input('id'))->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\provedores  $provedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $res = provedores::where('id', $request->input('id'))
            ->update([
                'prov_nombre' => $request->input('prov_nombre'),
                'prov_direccion' => $request->input('prov_direccion'),
                'prov_telf' => $request->input('prov_telf'),
                'prov_empresa' => $request->input('prov_empresa')
            ]);
        if ($res) {
            return 'success';
        } else {
            return 'fail';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\provedores  $provedores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $resul = provedores::where('id', $request->input('id'))->delete();
        if ($resul) {
            return 'success';
            \Session::flash('flash_info', 'Proveedor eliminado exitosamente');
            return redirect()->action('ProvedoresController@index');
        } else {
            return 'fail';
            \Session::flash('flash_danger', 'Error vuelba a intentarlo ');
            return redirect()->action('ProvedoresController@index');
        }
    }
}
