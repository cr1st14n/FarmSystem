<?php

namespace App\Http\Controllers;

use App\clientes;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SebastianBergmann\Environment\Console;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clieMez = clientes::whereMonth('created_at',Carbon::now()->format('m'))->count('id');
        $clieAño = clientes::whereYear('created_at',Carbon::now()->format('Y'))->count('id');
        $clieTotal = clientes::count('id');

        return view('clientes.homeClientes')
                ->with("clieMez",$clieMez)->with("clieAño",$clieAño)->with("clieTotal",$clieTotal);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cliente = new clientes;
        $cliente->vent_clienteNombre=$request->input("Nombre");
        $cliente->vent_clienteNit=$request->input("dni");
        $resp=$cliente->save();
        /*\Session::flash('flash_success','Cliente registrado.');
        return redirect()->action('ClientesController@index');*/
        if ($resp){
            return "exito";
        }else{
            return "fallo";
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
     * @param  \App\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show($nit)
    {
        $cliente = clientes::where('vent_clienteNit',$nit)->select('id','vent_clienteNombre')->first();
        return $cliente;
    }
    public function showVerificar($nit)
    {
        $cliente = clientes::where('vent_clienteNit',$nit)->value('id');
        if ($cliente == null){
            $cliente = 0;
        }else{
            $cliente = 1;
        }
        return $cliente;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return clientes::where('id',$request->input('id'))->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return 'hola';
        return clientes::where('id',$request->input('id_cliente_update'))
        ->update(['vent_clienteNombre'=>$request->input('Nombre_clie_up'),'vent_clienteNit'=>$request->input('dni_clie_up')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (Auth::user()->usu_cargo== 'Administrador'  ) {
            return clientes::where('id',$request->input('id'))
            ->update([ 
                'ca_estado'=>'0',
                ]);
        } else {
            return 'unauthorized';
        }
        
    }
}
