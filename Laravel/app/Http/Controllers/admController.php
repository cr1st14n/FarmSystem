<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\articulos;
use App\stock;
use App\provedores;
use App\fechvencimiento;
use App\clientes;
use App\venta;
use App\detalleVenta;

class admController extends Controller
{
    public function fechavencimiento($id)
    {
    	return fechvencimiento::where('cod_art',$id)->get();
    }

    public function articuloDatos($id)
    {
    	return articulos::where('id',$id)->first();
    }
    public function articuloStock($id)
    {
        return articulos::where('articulos.id',$id)->join('stocks','stocks.cod_art','=','articulos.id')->select('articulos.*','stocks.sto_cantidad')->first();
    }

    public function clienteDatos($dni)
    {
    	return clientes::where('vent_clienteNit',$dni)->first();
    }
    public function detalleVenta($id)
    {
        return detalleVenta::where('cod_venta',$id)
                                ->join('articulos as A','A.id','=','detalle_ventas.cod_art')
                                ->select('detalle_ventas.*','A.art_nombreGenerico','A.art_nombreComercial')
                                ->get();
    }
    public function listClientes()
    {
        return clientes::where('ca_estado','!=',0)->get();
    }
    public function ListAjax()
    {
        return datatables()->eloquent(articulos::query())->make(true);
    }
}
