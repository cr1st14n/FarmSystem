<?php

namespace App\Http\Controllers;

use App\articulos;
use App\stock;
use App\provedores;
use App\fechvencimiento;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticulosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ListAjax');
        //$this->middleware('log')->except(['index','privacy']);

    }
    public function index()
    {
        $proveedores = provedores::select('id', 'prov_nombre', 'prov_empresa')->get();
        $resulLisArt = articulos::count("id");
        if ($resulLisArt != 0) {
            $resulLisArt = 1;
        } else {
            $resulLisArt = 0;
        }
        //return "  $listArt";
        return view('articulos.homeArticulos')->with("resulLisArt", $resulLisArt)->with("proveedores", $proveedores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //return $request;
        $art = new articulos;
        $art->art_nombreGenerico = $request->input("nombre_generico");
        $art->art_nombreComercial = $request->input("nombre_comercial");
        $art->art_composicion = $request->input("composicion");
        $art->art_laboratorio = $request->input("laboratorio");
        $art->art_proveedor = $request->input("proveedor");
        $art->art_costoProveedor = $request->input("costo_proveedor");
        $art->art_costoVenta = $request->input("costo_venta");
        $res = $art->save();
        $a = $art->id;
        $cantidad = $request->input("stock");
        if ($cantidad == null) {
            $cantidad = 0;
        }
        //return "$a $cant";
        if ($res) {
            # code...
            $fecven = new fechvencimiento;
            $fecven->cod_art = $a;
            $fecven->fv_fechavencimiento = $request->input("fv");
            $fecven->fv_estado = "1";
            $fecven->ca_cod_usu = Auth::user()->usu_ci;
            $fecven->ca_fecha = Carbon::now();
            $fecven->save();


            $cant = new stock;
            $cant->cod_art = $a;
            $cant->sto_cantidad = $cantidad;
            $res2 = $cant->save();
            if ($res2) {
                # code...
                \Session::flash('flash_info', 'Articulo redistrado exitosamente');
                return redirect()->action('ArticulosController@index');
            } else {
                $res3 = articulos::where('id', $a)->delete();
                if ($res3) {
                    \Session::flash('flash_danger', 'Error en el registro vuela a intentarlo');
                    return redirect()->action('ArticulosController@index');
                } else {
                    articulos::where('id', $a)->delete();
                    \Session::flash('flash_danger', 'Error en el registro vuela a intentarlo');
                    return redirect()->action('ArticulosController@index');
                }
            }
        } else {
            \Session::flash('flash_danger', 'Error en el registro vuela a intentarlo');
            return redirect()->action('ArticulosController@index');
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
     * @param  \App\articulos  $articulos
     * @return \Illuminate\Http\Response
     */
    public function show(articulos $articulos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\articulos  $articulos
     * @return \Illuminate\Http\Response
     */
    public function edit(articulos $articulos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\articulos  $articulos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, articulos $articulos)
    {
        if ($request->input("proveedor") == null) {
            $res = articulos::where('id', $request->input("id_art"))->update([
                'art_nombreGenerico' => $request->input("ngenerico"),
                'art_nombreComercial' => $request->input("ncomercial"),
                'art_laboratorio' => $request->input("laboratorio"),
                'art_costoProveedor' => $request->input("cprovedor"),
                'art_costoVenta' => $request->input("cventa"),
            ]);
        } else {
            $res = articulos::where('id', $request->input("id_art"))->update([
                'art_nombreGenerico' => $request->input("ngenerico"),
                'art_nombreComercial' => $request->input("ncomercial"),
                'art_laboratorio' => $request->input("laboratorio"),
                'art_costoProveedor' => $request->input("cprovedor"),
                'art_costoVenta' => $request->input("cventa"),
                'art_nombreGenerico' => $request->input("ngenerico"),
            ]);
        }
        if ($res) {
            \Session::flash('flash_info', 'Articulo Actualizado');
        } else {
            \Session::flash('flash_danger', 'Error, Intentelo Nuevamente');
        }
        return redirect()->action('artInvController@index');
    }
    public function updateV2(Request $request)
    {
        // $ver=articulos::where('art_nombreGenerico',$request->input('ngenerico')->where('art_nombreComercial',$request->input('ncomercial')))->count();
        return  articulos::where('id', $request->input("id_art"))->update([
        'art_nombreGenerico' => $request->input("ngenerico"),
            'art_nombreComercial' => $request->input("ncomercial"),
            'art_laboratorio' => $request->input("laboratorio"),
            'art_proveedor' => $request->input("proveedor"),
            'art_costoProveedor' => $request->input("cprovedor"),
            'art_costoVenta' => $request->input("cventa"),
        ]);
        
    }
    public function destroy($id)
    {
        $resul = articulos::where('id', $id)->delete();
        stock::where('cod_art', $id)->delete();
        if ($resul) {
            \Session::flash('flash_info', 'Articulo eliminado exitosamente');
        } else {
            \Session::flash('flash_danger', 'Error, Intentelo Nuevamente');
        }
        return redirect()->action('ArticulosController@index');
    }
    public function ListAjax()
    {
        //return datatables()->eloquent(articulos::join('stocks','stocks.cod_art','=','articulos.id')->join('provedores','provedores.id','=','art_proveedor')->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')->latest('actualizacion'))->toJson();
        return  articulos::join('stocks', 'stocks.cod_art', '=', 'articulos.id')->join('provedores', 'provedores.id', '=', 'art_proveedor')->select('articulos.*', 'stocks.sto_cantidad', 'stocks.updated_at as actualizacion', 'provedores.prov_nombre')->orderBy('id')->get();
    }
}
