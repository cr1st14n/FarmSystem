<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\factura;
use App\venta;
use App\detalleVenta;
use App\clientes;
use App\User;

use Carbon\Carbon;

use DB;
class AjaxVentasController extends Controller
{
    public function listRegisVentas ()
    {
        //return datatables()->of(DB::table('ventas'))->toJson();
        return datatables()->query(DB::table('ventas')
                                ->join('clientes','clientes.id','=','ventas.vent_IdCliente')
                                ->join('facturas','facturas.cod_venta','=','ventas.id')
                                ->select('ventas.*','clientes.vent_clienteNombre','facturas.fact_numFactura','facturas.fac_pago'))
                                ->toJson();

    }
    public function listVentaGeneralFechSimple($fecha)
    {
        $fecha = Carbon::createFromFormat('Y-m-d', $fecha); // 1975-05-21 22:00:00
        $fecha = $fecha->format('Y-m-d');
      return datatables()->eloquent(venta::whereDate('created_at',$fecha))->toJson();
    }
    public function listVentaGeneralFechRango($fecha1,$fecha2)
    {
        $fecha1 = Carbon::createFromFormat('Y-m-d', $fecha1); 
        $fecha1 = $fecha1->format('Y-m-d');
        $fecha2 = Carbon::createFromFormat('Y-m-d', $fecha2); 
        $fecha2 = $fecha2->format('Y-m-d');
      return datatables()->eloquent(venta::whereDate('created_at','>=',$fecha1)->whereDate('created_at','<=',$fecha2))->toJson();   
    }
}
