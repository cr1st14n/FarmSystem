<?php

namespace App\Http\Controllers;

use App\venta;
use App\detalleVenta;
use App\clientes;
use App\stock;
use App\articulos;
use App\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\factura;
use DB;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(!\Session::has('mov')) \Session::put('carrito',array());
        if(!\Session::has('mov')) \Session::put('carritoFalla',array());
        if(!\Session::has('mov')) \Session::put('tipo_doc');
        if(!\Session::has('mov')) \Session::put('cod_doc');
        if(!\Session::has('mov')) \Session::put('modal-1');
        if(!\Session::has('cliente')) \Session::put('cliente');
        if(!\Session::has('dni')) \Session::put('dni');
        if(!\Session::has('numFactura')) \Session::put('numFactura');
    }
    public function index()
    {
        $listArt = articulos::join('stocks as s','s.cod_art','=','articulos.id')
            ->select('articulos.art_nombreGenerico',
                    'articulos.art_nombreComercial',
                    'articulos.id as idart',
                    'articulos.art_costoVenta',
                    's.sto_cantidad')->get();
        $carrito = \Session::get('carrito');
        $cont = "0";
        $costoTotal=0;
        foreach ($carrito as $art ) { $cont = $cont + 1; $costoTotal = $costoTotal + ($art->costo); } 
        $lista=\Session::get('carritoFalla');
        return view('venta.homeVentas')->with("listArt",$listArt)
                                        ->with("carrito",$carrito)
                                        ->with("costoTotal",$costoTotal)
                                        ->with("listas",$lista)
                                        ->with("cont",$cont);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(venta $venta)
    {
        //
    }
    public function edit(venta $venta)
    {
        //
    }
    public function update(Request $request, venta $venta)
    {
        //
    }
    public function destroy(venta $venta)
    {
        //
    }
    /**funcion para verificar existencia de articulo dentro el
    carrito de compra */
    public function verArtCompra ($id)
    {
        $carrito = \Session::get('carrito');
        $cont = "0";
        foreach ($carrito as $art ) {
            if (($art->id) == $id) {
                $cont = "1";
                return $cont;
            }
         } 
    }
    public function agregarAlCarrito(Request $request)
    {
        //capturar el id y la cantidad del articulo    
        $art = $request->input("producto");
        $cantidad = $request->input("cantidad");

        // verificar existencia del articulo en el carrito de compra
        $ver = $this->verArtCompra($art);
        if ($ver == "1") {
            \Session::flash('flash_warning','Articulo ya agregado al carrito');
            return redirect()->action('VentaController@index')->withInput();
        }



        $articulo = articulos::where('id',$art)
                    ->select('id',
                            'art_nombreGenerico',
                            'art_nombreComercial',
                            'art_laboratorio',
                            'art_costoVenta')->first();
        $precio = $articulo->art_costoVenta;
        $costo = $cantidad * $precio;
        $articulo->cantidad = $cantidad;
        $articulo->costo = $costo;

        
        $carrito = \Session::get('carrito');
        $carrito[$articulo->id] = $articulo;
        \Session::put('carrito',$carrito);
        
        $carrito = \Session::get('carrito');
        $costoTotal=0;
         foreach ($carrito as $art) {
            $costoTotal = $costoTotal + ($art->costo);
        }
        return redirect()->action('VentaController@index');
    }
    public function eliminarDelCarrito($id)
    {
        $art = articulos::where('id',$id)->first();
        $carrito = \Session::get('carrito');
        unset($carrito[$art->id]);
        \Session::put('carrito',$carrito);
        return redirect()->action('VentaController@index')->withInput();
        
    }
    public function resetCarrito()
    {
        \Session::forget('cliente');
        \Session::forget('dni');
        \Session::forget('carrito');
        $car=\Session::get('carrito');

        return "se borra el carrito";
//        \Session::flash('flash_info','Se reinicio la venta');
//        return 1;
        /*return redirect()->action('VentaController@index');*/
    }
    public function genFactura()
    {
        return view('venta.factura');
    }
     public function printFactura()
    {
        $date = Carbon::now()->format('m-d-Y');
        $time = Carbon::now()->format('h:m a');
        $carrito = \Session::get('carrito');
        $cliente = \Session::get('cliente');
        $dni = \Session::get('dni');
        $numFactura = \Session::get('numFactura');
        $cantidadProductos = "0";
        $costoTotal = "0";
        foreach ($carrito as $art) {
            $cantidadProductos = $cantidadProductos + 1;
            $costoTotal = $costoTotal + ($art->costo);
        }
        $qr="fecha:$date,hora:$time,cliente:$cliente,dni:$dni,#fatura:$numFactura,cantidad:$cantidadProductos,Coto total:$costoTotal";
        return view('venta.modeloFactura')
                    ->with('cantidadProductos',$cantidadProductos)
                    ->with('costoTotal',$costoTotal)
                    ->with('date',$date)
                    ->with('time',$time)
                    ->with('cliente',$cliente)
                    ->with('dni',$dni)
                    ->with('numFactura',$numFactura)
                    ->with('carrito',$carrito) 
                    ->with('qr',$qr);
    }
    public function cerrarVenta(Request $request)
    {
        #return $request;
        $carrito = \Session::get('carrito');
        if ($carrito == null) {
                \Session::flash('flash_warning','Agregue productos a la venta');
               return redirect()->back();
           }   
//comprobar las existencias en stock 
        $carritoError=array();
        foreach ($carrito as $art ) {
            $id=$art->id;
            $cantidad= $art->cantidad;
            $stockArt = stock::where('cod_art',$id)->value('sto_cantidad');
                if ($cantidad > $stockArt) {
                    array_push($carritoError, $id);
                }
        }
        if ($carritoError) {
            $lista = articulos::join('stocks as s','s.cod_art','=','articulos.id')
                ->select('articulos.art_nombreGenerico',
                        'articulos.art_nombreComercial',
                        'articulos.id as idart',
                        'articulos.art_costoVenta',
                        's.sto_cantidad')->whereIn('articulos.id',$carritoError)->get();
            $listArt = articulos::join('stocks as s','s.cod_art','=','articulos.id')
                ->select('articulos.art_nombreGenerico',
                        'articulos.art_nombreComercial',
                        'articulos.id as idart',
                        'articulos.art_costoVenta',
                        's.sto_cantidad')->get();
            $cont = "0";
            $costoTotal=0;
            foreach ($carrito as $art ) { $cont = $cont + 1; $costoTotal = $costoTotal + ($art->costo); } 
            return view('venta.homeVentas')
            ->with("listArt",$listArt)
            ->with("carrito",$carrito)
            ->with("costoTotal",$costoTotal)
            ->with("listas",$lista)
            ->with("cont",$cont);
            return redirect()->back()->with("lista",$lista);
        }
//ejecucion de resta del stock de los articulos en carrito
        $artVendido = array();
        $artFalla = array();
        foreach ($carrito as $carrito ) {
            $id = $carrito->id;
            $cantidad = $carrito->cantidad;
            $stockArt = stock::where('cod_art',$id)->value('sto_cantidad');
            if ($cantidad <= $stockArt) {
                $resto = $stockArt - $cantidad;
                $res = stock::where('cod_art',$id)->update(['sto_cantidad'=>$resto]);

                if ($res) {array_push($artVendido, $id);
                }else{ array_push($artFalla, $id);
                    $C = \Session::get('carrito');
                    unset($C[$id]);
                    \Session::put('carrito',$C);
                }
            }
        }
//actualizar carrito de compra
        if ($artFalla) {
            $artNoVendidos = articulos::join('stocks as s','s.cod_art','=','articulos.id')
                ->select('articulos.art_nombreGenerico',
                        'articulos.art_nombreComercial',
                        'articulos.id as idart',
                        'articulos.art_costoVenta',
                        's.sto_cantidad')->whereIn('articulos.id',$carritoFalla)->get();
            $contArtNoVendidos = count($artFalla);
            \Session::put('carritoFalla',$artFalla);
            \Session::flash('flash_warning',"$contArtNoVendidos productos no agregados a la compra");
        }


//guardar datos de venta t generar la factura
        $a = $request->input("nombre_cliente");
        $b = $request->input("dni");
        if ($a == null) {
            $a = "Nulo";
        }
        if ($b == null) {
            $b = "Nulo";
            $idcliente = 12;
        }else{
            $idcliente = clientes::where('vent_clienteNit',$b)->value('id');
                if ($idcliente == null) {
                    $i = new clientes();
                    $i->vent_clienteNombre=$a;
                    $i->vent_clienteNit=$b;
                    $i->ca_cod_usu=Auth::user()->usu_ci;
                    $i->ca_tipo="create";
                    $i->ca_fecha=Carbon::now();
                    $i->save();
                    $idcliente = $i->id;
                }
        }
        $venta = \Session::get('carrito');
        $cantTipoArticulos = 0;
        $cantTotalArticulos = 0;
        $costototalArticulos = 0;
        foreach ($venta as $art ) { $cantTipoArticulos = $cantTipoArticulos + 1; $costototalArticulos = $costototalArticulos + ($art->costo);
                                    $cantTotalArticulos = $cantTotalArticulos + $art->cantidad; }
        $v = new venta();
        $v->vent_canTipoArticulos = $cantTipoArticulos;
        $v->vent_canArticulosTotal = $cantTotalArticulos;
        $v->vent_efectivoTotal = $costototalArticulos;
        $v->vent_IdCliente =$idcliente;
        $v->ca_cod_usu=Auth::user()->usu_ci;
        $v->ca_tipo="create";
        $v->ca_fecha=Carbon::now();
        $v->save();
        $idventa = $v->id;
        foreach ($venta as $art ) {
            $dv = new detalleVenta();
            $dv->cod_venta=$idventa;
            $dv->cod_art=$art->id;
            $dv->dv_cantidad=$art->cantidad;
            $dv->dv_efectivo=$art->costo;
            $dv->save();
        }
        $factura = factura::max('fact_numFactura');
        $fac = new factura();
        $fac->fact_numFactura=$factura+1;
        $fac->cod_venta=$idventa;
        $fac->fact_estado=1;
        $fac->fac_pago=$request->input("tipoPago");
        $fac->ca_cod_usu=Auth::user()->usu_ci;;
        $fac->ca_tipo="created";
        $fac->ca_fecha=Carbon::now();;
        $fac->ca_estado=1;
        $fac->save();


        \Session::put('numFactura',$fac->fact_numFactura);
        \Session::put('cliente',$a);
        \Session::put('dni',$b);
        \Session::flash('imprimir_factura');
        return redirect()->action('VentaController@index');
    }
    public function registrarCompra($valor)
    {
        $valor = "noda jeje";
        return $valor;
    }
//-----CRUD PARA EL REGUISTRO DE VENTAS
    public function indexRegisVenta()
    {
        $listaVentas=venta::get();
        return view('venta.registroVentas')->with("listaVentas",$listaVentas);
    }
 //------Crud para V2 de ventas
    public function indexV2()
    {
        $fecha=Carbon::now()->format('Y-m-d');
        $usuarios = usuarios::select('usu_nombre','usu_appaterno','usu_apmaterno','usu_ci')->get();
        $articulos = articulos::get();
        return view('venta.homeVentaV2')->with("fecha",$fecha)->with("usuarios",$usuarios)->with("articulos",$articulos);
    }
    public function datoVentaArt($id)
    {
        $datoArt = articulos::join('stocks','stocks.cod_art','=','articulos.id')
                    ->join('provedores','provedores.id','=','articulos.art_proveedor')
                    ->where('articulos.id',$id)
                    ->select('articulos.art_costoProveedor',
                        'articulos.art_costoVenta',
                        'articulos.art_nombreGenerico',
                        'provedores.prov_nombre',
                        'art_nombreComercial',
                        'art_accionTerapeutica',
                        'art_laboratorio',
                        'art_composicion',
                        'art_laboratorio',
                        'art_proveedor',
                        'art_descripcion',
                        'stocks.sto_cantidad')->first();
        return $datoArt;
    }
    public function agregarAlCarritoV2(Request $request)
    {
        //capturar el id y la cantidad del articulo
        $art = $request->input("producto");
        $cantidad = $request->input("cantidad");
        $descuento = $request->input("descuento");

        // verificar existencia del articulo en el carrito de compra
        $ver = $this->verArtCompra($art);
        if ($ver == "1") {
            /*\Session::flash('flash_warning','Articulo ya agregado al carrito');
            return redirect()->action('VentaController@index')->withInput();*/
            return "ya agregado";
        }
        $articulo = articulos::where('id',$art)
            ->select('id',
                'art_nombreGenerico',
                'art_nombreComercial',
                'art_laboratorio',
                'art_costoVenta')->first();
        $precio = $articulo->art_costoVenta;
        $costoSD=$cantidad * $precio;
        $costo = $costoSD-(($costoSD*$descuento)/100);
        $articulo->descuento= $descuento;
        $articulo->cantidad = $cantidad;
        $articulo->costo = $costo;
        $articulo->costoSD=$costoSD;

        $carrito = \Session::get('carrito');
        $carrito[$articulo->id] = $articulo;
        \Session::put('carrito',$carrito);

        $carrito = \Session::get('carrito');
        $costoTotal=0;
        foreach ($carrito as $art) {
            $costoTotal = $costoTotal + ($art->costo);
        }
        return $carrito;
        //return redirect()->action('VentaController@index');
    }
    public function carritoVentaLista(){
        $cont = 0;
        $costo= 0;
        $unidades= 0;
        $carrito = \Session::get('carrito');
        foreach ($carrito as $car){$cont += 1; $costo += $car->costo; $unidades += $car->cantidad;}
        if ($cont == 0){
            return "carrito_vacio";
        }else{
            return  view('venta.listaCarrito')
                        ->with('carrito',$carrito)
                        ->with("cont",$cont)
                        ->with("unidades",$unidades)
                        ->with("costo",$costo);
        }
    }
    public function eliminarDelCarritoV2($id)
    {
        $art = articulos::where('id',$id)->first();
        $carrito = \Session::get('carrito');
        unset($carrito[$art->id]);
        \Session::put('carrito',$carrito);
        return 1;
        /*return redirect()->action('VentaController@index')->withInput();*/

    }
    public function cerrarVentaV2(Request $request)
    {
        $car = 1; $car2=2;
        return ("$car , $ca2");
        $carrito = \Session::get('carrito');
        if ($carrito == null) {
            \Session::flash('flash_warning','Agregue productos a la venta');
            return redirect()->back();
        }
//comprobar las existencias en stock
        $carritoError=array();
        foreach ($carrito as $art ) {
            $id=$art->id;
            $cantidad= $art->cantidad;
            $stockArt = stock::where('cod_art',$id)->value('sto_cantidad');
            if ($cantidad > $stockArt) {
                array_push($carritoError, $id);
            }
        }
        if ($carritoError) {
            $lista = articulos::join('stocks as s','s.cod_art','=','articulos.id')
                ->select('articulos.art_nombreGenerico',
                    'articulos.art_nombreComercial',
                    'articulos.id as idart',
                    'articulos.art_costoVenta',
                    's.sto_cantidad')->whereIn('articulos.id',$carritoError)->get();
            $listArt = articulos::join('stocks as s','s.cod_art','=','articulos.id')
                ->select('articulos.art_nombreGenerico',
                    'articulos.art_nombreComercial',
                    'articulos.id as idart',
                    'articulos.art_costoVenta',
                    's.sto_cantidad')->get();
            $cont = "0";
            $costoTotal=0;
            foreach ($carrito as $art ) { $cont = $cont + 1; $costoTotal = $costoTotal + ($art->costo); }
            return view('venta.homeVentas')
                ->with("listArt",$listArt)
                ->with("carrito",$carrito)
                ->with("costoTotal",$costoTotal)
                ->with("listas",$lista)
                ->with("cont",$cont);
            return redirect()->back()->with("lista",$lista);
        }
//ejecucion de resta del stock de los articulos en carrito
        $artVendido = array();
        $artFalla = array();
        foreach ($carrito as $carrito ) {
            $id = $carrito->id;
            $cantidad = $carrito->cantidad;
            $stockArt = stock::where('cod_art',$id)->value('sto_cantidad');
            if ($cantidad <= $stockArt) {
                $resto = $stockArt - $cantidad;
                $res = stock::where('cod_art',$id)->update(['sto_cantidad'=>$resto]);

                if ($res) {array_push($artVendido, $id);
                }else{ array_push($artFalla, $id);
                    $C = \Session::get('carrito');
                    unset($C[$id]);
                    \Session::put('carrito',$C);
                }
            }
        }
//actualizar carrito de compra
        if ($artFalla) {
            $artNoVendidos = articulos::join('stocks as s','s.cod_art','=','articulos.id')
                ->select('articulos.art_nombreGenerico',
                    'articulos.art_nombreComercial',
                    'articulos.id as idart',
                    'articulos.art_costoVenta',
                    's.sto_cantidad')->whereIn('articulos.id',$carritoFalla)->get();
            $contArtNoVendidos = count($artFalla);
            \Session::put('carritoFalla',$artFalla);
            \Session::flash('flash_warning',"$contArtNoVendidos productos no agregados a la compra");
        }


//guardar datos de venta t generar la factura
        $a = $request->input("nombre_cliente");
        $b = $request->input("dni");
        if ($a == null) {
            $a = "Nulo";
        }
        if ($b == null) {
            $b = "Nulo";
            $idcliente = 12;
        }else{
            $idcliente = clientes::where('vent_clienteNit',$b)->value('id');
            if ($idcliente == null) {
                $i = new clientes();
                $i->vent_clienteNombre=$a;
                $i->vent_clienteNit=$b;
                $i->ca_cod_usu=Auth::user()->usu_ci;
                $i->ca_tipo="create";
                $i->ca_fecha=Carbon::now();
                $i->save();
                $idcliente = $i->id;
            }
        }
        $venta = \Session::get('carrito');
        $cantTipoArticulos = 0;
        $cantTotalArticulos = 0;
        $costototalArticulos = 0;
        foreach ($venta as $art ) { $cantTipoArticulos = $cantTipoArticulos + 1; $costototalArticulos = $costototalArticulos + ($art->costo);
            $cantTotalArticulos = $cantTotalArticulos + $art->cantidad; }
        $v = new venta();
        $v->vent_canTipoArticulos = $cantTipoArticulos;
        $v->vent_canArticulosTotal = $cantTotalArticulos;
        $v->vent_efectivoTotal = $costototalArticulos;
        $v->vent_IdCliente =$idcliente;
        $v->ca_cod_usu=Auth::user()->usu_ci;
        $v->ca_tipo="create";
        $v->ca_fecha=Carbon::now();
        $v->save();
        $idventa = $v->id;
        foreach ($venta as $art ) {
            $dv = new detalleVenta();
            $dv->cod_venta=$idventa;
            $dv->cod_art=$art->id;
            $dv->dv_cantidad=$art->cantidad;
            $dv->dv_efectivo=$art->costo;
            $dv->save();
        }
        $factura = factura::max('fact_numFactura');
        $fac = new factura();
        $fac->fact_numFactura=$factura+1;
        $fac->cod_venta=$idventa;
        $fac->fact_estado=1;
        $fac->fac_pago=$request->input("tipoPago");
        $fac->ca_cod_usu=Auth::user()->usu_ci;;
        $fac->ca_tipo="created";
        $fac->ca_fecha=Carbon::now();;
        $fac->ca_estado=1;
        $fac->save();


        \Session::put('numFactura',$fac->fact_numFactura);
        \Session::put('cliente',$a);
        \Session::put('dni',$b);
        \Session::flash('imprimir_factura');
        return redirect()->action('VentaController@index');
    }
    public function verificarventa()
    {
        $carrito = \Session::get('carrito');
        if ($carrito == null) {
            return "carritovacio";
        }else{
            return "correcto";
        }
//comprobar las existencias en stock
        $carritoError=array();
        foreach ($carrito as $art ) {
            $id=$art->id;
            $cantidad= $art->cantidad;
            $stockArt = stock::where('cod_art',$id)->value('sto_cantidad');
            if ($cantidad > $stockArt) {
                array_push($carritoError, $id);
            }
        }
        if ($carritoError) {

            $cont = "0";
            $costoTotal=0;
            foreach ($carrito as $art ) { $cont = $cont + 1; $costoTotal = $costoTotal + ($art->costo); }
            return view('venta.homeVentas')
                ->with("carrito",$carrito)
                ->with("costoTotal",$costoTotal)
                ->with("cont",$cont);
        }
        return "error1010";
    }
    public function verificarventaStockArt()
    {
        $carrito = \Session::get('carrito');
     //comprobar las existencias en stock
        $carritoError=array();
        foreach ($carrito as $art ) {
            $id=$art->id;
            $cantidad= $art->cantidad;
            $stockArt = stock::where('cod_art',$id)->value('sto_cantidad');
            if ($cantidad > $stockArt) {
//                array_push($carritoError, $id);
                $carritoError[$id]=$carrito[$id];
                $stock = stock::where('cod_art',$id)->value('sto_cantidad');
                $carritoError[$id]->stock=$stock;
                unset($carrito[$id]);
                \Session::put('carrito',$carrito);

            }
        }

        if ($carritoError) {
            return view('venta.listaArtVentaSinStock')->with("lista",$carritoError);
//            return $carritoError;
        }else{
            return "success";
        }

    }
    public function registrarVenta($nit,$tipoPago)
    {
    //return "$nit,$tipoPago";
    //return "se registrara la venta";
    //ejecucion de resta del stock de los articulos en carrito
        $carrito = \Session::get('carrito');
        $artVendido = array();
        $artFalla = array();
        foreach ($carrito as $carrito ) {
            $id = $carrito->id;
            $cantidad = $carrito->cantidad;
            $stockArt = stock::where('cod_art',$id)->value('sto_cantidad');
            if ($cantidad <= $stockArt) {
                $resto = $stockArt - $cantidad;
                $res = stock::where('cod_art',$id)->update(['sto_cantidad'=>$resto]);

                if ($res) {/*array_push($artVendido, $id);*/
                            $artVendido[$id]=$carrito[$id];
                }else{ /*array_push($artFalla, $id);*/
                        $artFalla[$id]=$carrito[$id];
                    $C = \Session::get('carrito');
                    unset($C[$id]);
                    \Session::put('carrito',$C);
                }
            }
            else{ /*array_push($artFalla, $id);*/
                $artFalla[$id]=$carrito[$id];
                $C = \Session::get('carrito');
                unset($C[$id]);
                \Session::put('carrito',$C);
            }
        }
        //return $artFalla;
//actualizar carrito de compra
       /* if ($artFalla) {
            $artNoVendidos = articulos::join('stocks as s','s.cod_art','=','articulos.id')
                ->select('articulos.art_nombreGenerico',
                    'articulos.art_nombreComercial',
                    'articulos.id as idart',
                    'articulos.art_costoVenta',
                    's.sto_cantidad')->whereIn('articulos.id',$carritoFalla)->get();
            $contArtNoVendidos = count($artFalla);
            \Session::put('carritoFalla',$artFalla);
            \Session::flash('flash_warning',"$contArtNoVendidos productos no agregados a la compra");
        }
        //guardar datos de venta t generar la factura
        $a = $request->input("nombre_cliente");
        $b = $request->input("dni");
        if ($a == null) {
            $a = "Nulo";
        }
        if ($b == null) {
            $b = "Nulo";
            $idcliente = 12;
        }else{
            $idcliente = clientes::where('vent_clienteNit',$b)->value('id');
            if ($idcliente == null) {
                $i = new clientes();
                $i->vent_clienteNombre=$a;
                $i->vent_clienteNit=$b;
                $i->ca_cod_usu=Auth::user()->usu_ci;
                $i->ca_tipo="create";
                $i->ca_fecha=Carbon::now();
                $i->save();
                $idcliente = $i->id;
            }
        }*/
        $nit= clientes::where('vent_clienteNit',$nit)->value('id');
        $venta = \Session::get('carrito');
        $cantTipoArticulos = 0;
        $cantTotalArticulos = 0;
        $costototalArticulos = 0;
        foreach ($venta as $art ) { $cantTipoArticulos = $cantTipoArticulos + 1; $costototalArticulos = $costototalArticulos + ($art->costo);
            $cantTotalArticulos = $cantTotalArticulos + $art->cantidad; }
            $v = new venta();
            $v->vent_canTipoArticulos = $cantTipoArticulos;
            $v->vent_canArticulosTotal = $cantTotalArticulos;
            $v->vent_efectivoTotal = $costototalArticulos;
            $v->vent_IdCliente =$nit;
            $v->ca_cod_usu=Auth::user()->usu_ci;
            $v->ca_tipo="create";
            $v->ca_fecha=Carbon::now();
            $v->save();
            $idventa = $v->id;
        foreach ($venta as $art ) {
            $dv = new detalleVenta();
            $dv->cod_venta=$idventa;
            $dv->cod_art=$art->id;
            $dv->dv_cantidad=$art->cantidad;
            $dv->dv_efectivo=$art->costo;
            $dv->save();
        }
        $factura = factura::max('fact_numFactura');
        $fac = new factura();
        $fac->fact_numFactura=$factura+1;
        $fac->cod_venta=$idventa;
        $fac->fact_estado=1;
        $fac->fac_pago=$tipoPago;
        $fac->ca_cod_usu=Auth::user()->usu_ci;;
        $fac->ca_tipo="created";
        $fac->ca_fecha=Carbon::now();;
        $fac->ca_estado=1;
        $fac->save();


        \Session::put('numFactura',$fac->fact_numFactura);
        \Session::put('cliente',(clientes::where('id',$nit)->value('vent_clienteNombre')));
        \Session::put('dni',(clientes::where('id',$nit)->value('vent_clienteNit')));
//        \Session::flash('imprimir_factura');
        /*return redirect()->action('VentaController@index');*/
        if ($artFalla){
//            return "con errores";
            return view('venta.listaArtVentaSinStock')->with("lista",$artFalla);
        }else{
            return"exito";
        }

    }

    public function anularVenta(Request $request)
    {
        return factura::where('id',$request->input('id'))->update(['fact_estado'=>0]); 
    }
}
