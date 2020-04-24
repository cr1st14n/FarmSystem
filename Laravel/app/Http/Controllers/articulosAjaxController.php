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


class articulosAjaxController extends Controller
{
    public function buscarArticulo($valor)
    {   
         return  articulos::join('stocks','stocks.cod_art','=','articulos.id')
                         ->join('provedores','provedores.id','=','art_proveedor')
                         ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')
                         ->where('prov_nombre','like','%'.$valor.'%')
                         ->orWhere('art_nombreGenerico','like','%'.$valor.'%')
                         ->orWhere('art_nombreComercial','like','%'.$valor.'%')
                         ->orWhere('art_composicion','like','%'.$valor.'%')
                         ->orWhere('art_laboratorio','like','%'.$valor.'%')
                         ->latest('actualizacion')
                         ->get();
    }
    public function showArticulo($id)
    {
              return  articulos::join('stocks','stocks.cod_art','=','articulos.id')
                         ->join('provedores','provedores.id','=','art_proveedor')
                         ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')
                         ->where('articulos.id',$id)
                         ->first();   
    }
    public function ListAjax()
    {
         
        return datatables()->eloquent(articulos::join('stocks','stocks.cod_art','=','articulos.id')
                                                ->join('provedores','provedores.id','=','art_proveedor')
                                                ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre'))
                                                ->toJson();
    }   
}
