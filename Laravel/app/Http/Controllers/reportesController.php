<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\User;
use App\articulos;
use App\stock;
use App\provedores;
use App\fechvencimiento;
use App\clientes;
use App\venta;
use App\detalleVenta;

use Carbon\Carbon;


class reportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('log')->except(['index','privacy']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articulo1 = articulos::count('id');
        $articulo2 = stock::where('sto_cantidad','>=',1)->count('cod_art');
        $articulo3 = stock::where('sto_cantidad','=',0)->count('cod_art');
        return view('reportes.indexReportes')
                    ->with("articulo1",$articulo1)
                    ->with("articulo2",$articulo2)
                    ->with("articulo3",$articulo3);


    }

    public function impArtReports()
    {
        $fecha = Carbon::now()->format('d-m-Y');
        $articulo1 = articulos::count('id');
        $articulo2 = stock::where('sto_cantidad','>=',1)->count('cod_art');
        $articulo3 = stock::where('sto_cantidad','=',0)->count('cod_art');
        return view('reportes.ArtiReporte1')->with("fecha",$fecha)
                                            ->with("articulo1",$articulo1)
                                            ->with("articulo2",$articulo2)
                                            ->with("articulo3",$articulo3);
    }

// generar reportes de ventas
    public function indexReportVentas()
    {
        $dateActual = Carbon::now()->format('Y-m-d');
        $usuarios = User::select('usu_ci','usu_nombre','usu_appaterno','usu_apmaterno')->get();
        return view('reportes.indexReportesVentas')->with("usuarios",$usuarios)->with("dateActual",$dateActual);
    }
    public function generarReporteventas(Request $request)
    {   

        $fechaActual = Carbon::now()->format('d-m-Y');
        $CostoTotal =0 ;
        $cantidad= 0;
        ///return $request;
        if ($request->input("tipofecha")==1) {
            # code...
            if ($request->input("fecha0") == null ) {
                \Session::flash('flash_danger','Error de fechas en formulario');
                return redirect()->back();
            }
        }
        if ($request->input("tipofecha")==2) {
            # code...
            if ($request->input("fecha1") == null ) {
                \Session::flash('flash_danger','Error de fechas en formulario');
                return redirect()->back();
            }
            if ($request->input("fecha2") == null ) {
                \Session::flash('flash_danger','Error de fechas en formulario');
                return redirect()->back();
            }
            
        }
        
        if ($request->input("tipoVenta") == "general") {
            if ($request->input("selectUsuario") == "todos") {
                if ($request->input("tipofecha") == 1) {
                    //cosulta venta general todos los usuarios tipo fecha 1       

                    $ventas = venta::join('users','ventas.ca_cod_usu','=','users.usu_ci')
                                    ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                    ->join('facturas','facturas.cod_venta','=','ventas.id')
                                    ->select('ventas.*','clientes.vent_clienteNit','clientes.vent_clienteNombre','facturas.fact_numFactura')
                                    ->whereDate('ventas.ca_fecha',($request->input('fecha0')))
                                    ->get();
                    foreach ($ventas as $venta) {
                        $CostoTotal = $CostoTotal + ($venta->vent_efectivoTotal);
                        $cantidad = $cantidad + 1;
                    }


                    //return $ventas;
                    return view('reportes.ventasReporte1')->with("ventas",$ventas)
                                                          ->with("tabla","venta")
                                                          ->with("fechaActual",$fechaActual)
                                                          ->with("fecha0",(Carbon::createFromFormat('Y-m-d',($request->input("fecha0")))->format('d-m-Y')))
                                                          ->with("CostoTotal",$CostoTotal)                                    
                                                          ->with("cantidad",$cantidad);                                    
                }elseif ($request->input("tipofecha")==2) {
                    //consulta venta general todos lo usuarios ripo fecha 2
                    $ventas = venta::join('users','ventas.ca_cod_usu','=','users.usu_ci')
                                    ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                    ->join('facturas','facturas.cod_venta','=','ventas.id')
                                    ->select('ventas.*','clientes.vent_clienteNit','clientes.vent_clienteNombre','facturas.fact_numFactura')
                                    ->whereDate('ventas.ca_fecha','>=',($request->input('fecha1')))
                                    ->whereDate('ventas.ca_fecha','<=',($request->input('fecha2')))
                                    ->get();
                    //return $ventas;
                    foreach ($ventas as $venta) {
                        $CostoTotal = $CostoTotal + ($venta->vent_efectivoTotal);
                        $cantidad = $cantidad + 1;
                    }
                    $fechaI = Carbon::createFromFormat('Y-m-d',($request->input("fecha1")))->format('d-m-Y');
                    $fechaF = Carbon::createFromFormat('Y-m-d',($request->input("fecha2")))->format('d-m-Y');

                    $fechaIF= "$fechaI a $fechaF";
                    //return $ventas;
                    return view('reportes.ventasReporte1')->with("ventas",$ventas)
                                                          ->with("tabla","venta")                                      
                                                          ->with("fechaActual",$fechaActual)
                                                          ->with("fecha0",$fechaIF)
                                                          ->with("CostoTotal",$CostoTotal)                                    
                                                          ->with("cantidad",$cantidad); 
                }                
            }else {
                if ($request->input("tipofecha") == 1) {
                    //conslta venta general usuario unico con tipo de fecha1
                     $ventas = venta::join('users','ventas.ca_cod_usu','=','users.usu_ci')
                                    ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                    ->join('facturas','facturas.cod_venta','=','ventas.id')
                                    ->select('ventas.*','clientes.vent_clienteNit','clientes.vent_clienteNombre','facturas.fact_numFactura')
                                    ->whereDate('ventas.ca_fecha',($request->input('fecha0')))
                                    ->where('ventas.ca_cod_usu',($request->input('selectUsuario')))
                                    ->get();
                    
                    foreach ($ventas as $venta) {
                        $CostoTotal = $CostoTotal + ($venta->vent_efectivoTotal);
                        $cantidad = $cantidad + 1;
                    }


                    //return $ventas;
                    $pFecha = (Carbon::createFromFormat('Y-m-d',($request->input("fecha0")))->format('d-m-Y'));
                    $usuario= $request->input("selectUsuario");
                    $pFecha = "$pFecha del usuario $usuario" ;
                    return view('reportes.ventasReporte1')->with("ventas",$ventas)
                                                            ->with("tabla","venta")
                                                          ->with("fechaActual",$fechaActual)
                                                          ->with("fecha0",$pFecha)
                                                          ->with("CostoTotal",$CostoTotal)                                    
                                                          ->with("cantidad",$cantidad); 
                }elseif ($request->input("tipofecha")==2) {
                    //consulta venta general usurio unico tipo fecha 2
                     $ventas = venta::join('users','ventas.ca_cod_usu','=','users.usu_ci')
                                    ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                    ->join('facturas','facturas.cod_venta','=','ventas.id')
                                    ->select('ventas.*','clientes.vent_clienteNit','clientes.vent_clienteNombre','facturas.fact_numFactura')
                                    ->whereDate('ventas.ca_fecha','>=',($request->input('fecha1')))
                                    ->whereDate('ventas.ca_fecha','<=',($request->input('fecha2')))
                                    ->where('ventas.ca_cod_usu',($request->input('selectUsuario')))
                                    ->get();

                    foreach ($ventas as $venta) {
                        $CostoTotal = $CostoTotal + ($venta->vent_efectivoTotal);
                        $cantidad = $cantidad + 1;
                    }
                    $fechaI = Carbon::createFromFormat('Y-m-d',($request->input("fecha1")))->format('d-m-Y');
                    $fechaF = Carbon::createFromFormat('Y-m-d',($request->input("fecha2")))->format('d-m-Y');
                    $usuariodatos= auth::user()->usu_ci;
                    $fechaIF= "$fechaI  a  $fechaF del Usuario $usuariodatos";
                    //return $ventas;
                    return view('reportes.ventasReporte1')->with("ventas",$ventas)
                                                            ->with("tabla","venta")
                                                          ->with("fechaActual",$fechaActual)
                                                          ->with("fecha0",$fechaIF)
                                                          ->with("CostoTotal",$CostoTotal)                                    
                                                          ->with("cantidad",$cantidad); 
                }  
            }
            # code...
        }elseif ($request->input("tipoVenta")=="detalleArticulo") {
            if ($request->input("selectUsuario") == "todos") {
                if ($request->input("tipofecha") == 1) {
                    //cosulta para detalle venta articulo todos los usuarios tipo fecha 1   
                    $ventas = venta::join('users','ventas.ca_cod_usu','=','users.usu_ci')
                                    ->join('detalle_ventas','detalle_ventas.cod_venta','=','ventas.id')
                                    ->join('articulos','articulos.id','=','detalle_ventas.cod_art')
                                    ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                    ->join('facturas','facturas.cod_venta','=','ventas.id')
                                    ->select('detalle_ventas.*','articulos.art_nombreGenerico','articulos.art_nombreComercial','clientes.vent_clienteNit','clientes.vent_clienteNombre','facturas.fact_numFactura','users.usu_ci')
                                    ->whereDate('ventas.ca_fecha',($request->input('fecha0')))
                                    ->get();
                    //return $ventas;
                    foreach ($ventas as $venta) {
                        $CostoTotal = $CostoTotal + ($venta->dv_efectivo);
                        $cantidad = $cantidad + 1;
                    }
                    return view('reportes.ventasReporte1')->with("ventas",$ventas)
                                                            ->with("tabla","articulo")
                                                          ->with("fechaActual",$fechaActual)
                                                          ->with("fecha0",(Carbon::createFromFormat('Y-m-d',($request->input("fecha0")))->format('d-m-Y')))
                                                          ->with("CostoTotal",$CostoTotal)                                    
                                                          ->with("cantidad",$cantidad);         
                }elseif ($request->input("tipofecha")==2) {
                    //consulta para detalle venta articuylo todos lo usuarios ripo fecha 2
                    $ventas = venta::join('users','ventas.ca_cod_usu','=','users.usu_ci')
                                    ->join('detalle_ventas','detalle_ventas.cod_venta','=','ventas.id')
                                    ->join('articulos','articulos.id','=','detalle_ventas.cod_art')
                                    ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                    ->join('facturas','facturas.cod_venta','=','ventas.id')
                                    ->select('detalle_ventas.*','articulos.art_nombreGenerico','articulos.art_nombreComercial','clientes.vent_clienteNit','clientes.vent_clienteNombre','facturas.fact_numFactura','users.usu_ci')
                                    ->whereDate('ventas.ca_fecha','>=',($request->input('fecha1')))
                                    ->whereDate('ventas.ca_fecha','<=',($request->input('fecha2')))
                                    ->get();
                    //return $ventas;
                    foreach ($ventas as $venta) {
                        $CostoTotal = $CostoTotal + ($venta->dv_efectivo);
                        $cantidad = $cantidad + 1;
                    }
                    $fechaI = Carbon::createFromFormat('Y-m-d',($request->input("fecha1")))->format('d-m-Y');
                    $fechaF = Carbon::createFromFormat('Y-m-d',($request->input("fecha2")))->format('d-m-Y');
                    $usuariodatos= "";
                    $fechaIF= "$fechaI  a  $fechaF ";
                    return view('reportes.ventasReporte1')->with("ventas",$ventas)
                                                            ->with("tabla","articulo")
                                                          ->with("fechaActual",$fechaActual)
                                                          ->with("fecha0",$fechaIF)
                                                          ->with("CostoTotal",$CostoTotal)                                    
                                                          ->with("cantidad",$cantidad); 
                }                
            }else {
                if ($request->input("tipofecha") == 1) {
                    //conslta por detalle articulo ususrio unico con tipo de fecha1
                    $ventas = venta::join('users','ventas.ca_cod_usu','=','users.usu_ci')
                                    ->join('detalle_ventas','detalle_ventas.cod_venta','=','ventas.id')
                                    ->join('articulos','articulos.id','=','detalle_ventas.cod_art')
                                    ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                    ->join('facturas','facturas.cod_venta','=','ventas.id')
                                    ->select('detalle_ventas.*','articulos.art_nombreGenerico','articulos.art_nombreComercial','clientes.vent_clienteNit','clientes.vent_clienteNombre','facturas.fact_numFactura','users.usu_ci')
                                    ->whereDate('ventas.ca_fecha',($request->input('fecha0')))
                                    ->where('ventas.ca_cod_usu',($request->input('selectUsuario')))
                                    ->get();
                    foreach ($ventas as $venta) {
                        $CostoTotal = $CostoTotal + ($venta->dv_efectivo);
                        $cantidad = $cantidad + 1;
                    }
                    //return $ventas;
                    #$fechaI = Carbon::createFromFormat('Y-m-d',($request->input("fecha1")))->format('d-m-Y');
                    #$fechaF = Carbon::createFromFormat('Y-m-d',($request->input("fecha2")))->format('d-m-Y');
                    $fechaIn = Carbon::createFromFormat('Y-m-d',($request->input("fecha0")))->format('d-m-Y');
                    $usuariodatos= $request->input("selectUsuario");
                    $fechaIF= "$fechaIn del usuario $usuariodatos ";
                    return view('reportes.ventasReporte1')->with("ventas",$ventas)
                                                            ->with("tabla","articulo")
                                                          ->with("fechaActual",$fechaActual)
                                                          ->with("fecha0",$fechaIF)
                                                          ->with("CostoTotal",$CostoTotal)                                    
                                                          ->with("cantidad",$cantidad);
                }elseif ($request->input("tipofecha")==2) {
                    //consulta pata detalle venta articulo usurio unico tipo fecha 2
                    $ventas = venta::join('users','ventas.ca_cod_usu','=','users.usu_ci')
                                    ->join('detalle_ventas','detalle_ventas.cod_venta','=','ventas.id')
                                    ->join('articulos','articulos.id','=','detalle_ventas.cod_art')
                                    ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                    ->join('facturas','facturas.cod_venta','=','ventas.id')
                                    ->select('detalle_ventas.*','articulos.art_nombreGenerico','articulos.art_nombreComercial','clientes.vent_clienteNit','clientes.vent_clienteNombre','facturas.fact_numFactura','users.usu_ci')
                                    ->whereDate('ventas.ca_fecha','>=',($request->input('fecha1')))
                                    ->whereDate('ventas.ca_fecha','<=',($request->input('fecha2')))
                                    ->where('users.usu_ci',($request->input('selectUsuario')))
                                    ->get();
                    //return $ventas;
                    foreach ($ventas as $venta) {
                        $CostoTotal = $CostoTotal + ($venta->dv_efectivo);
                        $cantidad = $cantidad + 1;
                    }
                    $fechaI = Carbon::createFromFormat('Y-m-d',($request->input("fecha1")))->format('d-m-Y');
                    $fechaF = Carbon::createFromFormat('Y-m-d',($request->input("fecha2")))->format('d-m-Y');
                    $usuariodatos= $request->input("selectUsuario");
                    $fechaIF= "$fechaI  a  $fechaF del Usuario: $usuariodatos";
                    return view('reportes.ventasReporte1')->with("ventas",$ventas)
                                                            ->with("tabla","articulo")
                                                          ->with("fechaActual",$fechaActual)
                                                          ->with("fecha0",$fechaIF)
                                                          ->with("CostoTotal",$CostoTotal)                                    
                                                          ->with("cantidad",$cantidad);
                }           
            }
        }



        return $request;
    }
}    