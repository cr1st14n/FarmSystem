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
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class artInvController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');   
    }
    public function index()
    {
        $data="este es un asuntode prueba jeua jua jadlfjñalsjfcjsañljfslñfjkl";
        $prov=provedores::select('id','prov_nombre','prov_empresa')->get();
        return view('articulos.homeArt')->with("provs",$prov)->with("data",$data);
//        return "hola";
    }
    public function createART(Request $request)
    {
        $art = new articulos;
        $art->art_nombreGenerico = $request->input("art_nombreGenerico");
        $art->art_nombreComercial = $request->input("   ");
        $art->art_composicion = $request->input("art_composicion");
        $art->art_laboratorio = $request->input("art_laboratorio");
        $art->art_accionTerapeutica = $request->input("art_accionTerapeutica");
        $art->art_proveedor = $request->input("art_proveedor");
        $art->art_costoProveedor = $request->input("art_costoProveedor");
        $art->art_costoVenta = $request->input("art_costoVenta");
        $res=$art->save();
        $a=$art->id;
        $cantidad=$request->input("unidades");
        if ($cantidad == null) {$cantidad = 0;}
        //return "$a $cant";
        if ($res) {
            # code...
            $fecven= new fechvencimiento;
            $fecven->cod_art = $a;
            $fecven->fv_fechavencimiento = $request->input("fechVen");
            $fecven->fv_estado = "1";
            $fecven->ca_cod_usu = Auth::user()->usu_ci;
            $fecven->ca_fecha = Carbon::now();
            $fecven->save();


            $cant = new stock;
            $cant->cod_art=$a;
            $cant->sto_cantidad=$cantidad;
            $res2=$cant->save();
            if ($res2) {
                return"success";
            }else{
                $res3 = articulos::where('id',$a)->delete();
                if ($res3) {
                    return"fail";
                    \Session::flash('flash_danger','Error en el registro vuela a intentarlo');
                    return redirect()->action('ArticulosController@index');
                }else{
                    return"fail";
                    articulos::where('id',$a)->delete();
                    \Session::flash('flash_danger','Error en el registro vuela a intentarlo');
                    return redirect()->action('ArticulosController@index');
                }
            }


        }else{
            return"fail";
            \Session::flash('flash_danger','Error en el registro vuela a intentarlo');
            return redirect()->action('ArticulosController@index');
        }
    }
    public function store()
    {
        return articulos::join('stocks','stocks.cod_art','=','articulos.id')
            ->join('provedores','provedores.id','=','art_proveedor')
            ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')->get();
        /* return datatables()->eloquent(articulos::join('stocks','stocks.cod_art','=','articulos.id')
        ->join('provedores','provedores.id','=','art_proveedor')
        ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre'))->toJson(); */
    }
    public function storeStock()
    {
        return articulos::join('stocks','stocks.cod_art','=','articulos.id')
            ->join('provedores','provedores.id','=','art_proveedor')
            ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')
            ->where('stocks.sto_cantidad','>',0)
            ->get();
    }
    public function storePro($pro)
    {
        return articulos::join('stocks','stocks.cod_art','=','articulos.id')
            ->join('provedores','provedores.id','=','art_proveedor')
            ->where('provedores.id',$pro)
            ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')->get();
    }
    public function storeNonCNomG($valor)
    {
        return  articulos::join('stocks','stocks.cod_art','=','articulos.id')
            ->join('provedores','provedores.id','=','art_proveedor')
            ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')
            ->where('prov_nombre','like','%'.$valor.'%')
            /* ->orWhere('art_nombreGenerico','like','%'.$valor.'%') */
            ->orWhere('art_nombreComercial','like','%'.$valor.'%')
            /* ->orWhere('art_composicion','like','%'.$valor.'%')
            ->orWhere('art_laboratorio','like','%'.$valor.'%') */
            ->latest('actualizacion')
            ->get();
    }
    public function storeNomC(Request $request)
    {
        $valor=$request->input("texto");
        return  articulos::join('stocks','stocks.cod_art','=','articulos.id')
        ->join('provedores','provedores.id','=','art_proveedor')
        ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')
        ->where('prov_nombre','like','%'.$valor.'%')
        /* ->orWhere('art_nombreGenerico','like','%'.$valor.'%') */
        ->orWhere('art_nombreComercial','like','%'.$valor.'%')
        /* ->orWhere('art_composicion','like','%'.$valor.'%')
        ->orWhere('art_laboratorio','like','%'.$valor.'%') */
        ->latest('actualizacion')
        ->get();
    }
    public function storeNomG(Request $request)
    {
        $valor=$request->input("texto");
        return  articulos::join('stocks','stocks.cod_art','=','articulos.id')
        ->join('provedores','provedores.id','=','art_proveedor')
        ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')
        ->where('prov_nombre','like','%'.$valor.'%')
        ->orWhere('art_nombreGenerico','like','%'.$valor.'%')
        /* ->orWhere('art_nombreComercial','like','%'.$valor.'%')
        ->orWhere('art_composicion','like','%'.$valor.'%')
        ->orWhere('art_laboratorio','like','%'.$valor.'%') */
        ->latest('actualizacion')
        ->get();
    }
    public function storeAcTe($valor)
    {
        return  articulos::join('stocks','stocks.cod_art','=','articulos.id')
            ->join('provedores','provedores.id','=','art_proveedor')
            ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')
            ->where('art_accionTerapeutica','like','%'.$valor.'%')
//            ->orWhere('art_nombreGenerico','like','%'.$valor.'%')
//            ->orWhere('art_nombreComercial','like','%'.$valor.'%')
//            ->orWhere('art_composicion','like','%'.$valor.'%')
//            ->orWhere('art_laboratorio','like','%'.$valor.'%')
            ->latest('actualizacion')
            ->get();
    }
    public function storeLiMa($valor)
    {
        return  articulos::join('stocks','stocks.cod_art','=','articulos.id')
            ->join('provedores','provedores.id','=','art_proveedor')
            ->select('articulos.*','stocks.sto_cantidad','stocks.updated_at as actualizacion','provedores.prov_nombre')
            ->where('art_laboratorio','like','%'.$valor.'%')
//            ->orWhere('art_nombreGenerico','like','%'.$valor.'%')
//            ->orWhere('art_nombreComercial','like','%'.$valor.'%')
//            ->orWhere('art_composicion','like','%'.$valor.'%')
//            ->orWhere('art_laboratorio','like','%'.$valor.'%')
            ->latest('actualizacion')
            ->get();
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
    public function agregarCant(Request $request)
    {
//        return $request;
        $id= $request->input("id");
        $cantidad= $request->input("cantidad");
        $stock= stock::where('cod_art',$id)->value('sto_cantidad');
        $stock= $stock+ $cantidad;
        $resul= stock::where('cod_art',$id)->update(['sto_cantidad' => $stock,
            'updated_at'=> Carbon::now(),
            'ca_cod_usu' => Auth::user()->usu_ci,
            'ca_tipo' => "actualizacion"]);
        $fv = new fechvencimiento;
        $fv->cod_art = $request->input("id");
        $fv->ca_cod_usu = Auth::user()->usu_ci;
        $fv->fv_fechavencimiento = $request->input("vencimiento");
        $fv->fv_estado = 1;
        $fv->ca_fecha = Carbon::now();
        $fv->save();

        if ($resul) {
            return"success";
        }else{
            return"fail";
        }
    }
    public function sustraerCant(Request $request)
    {
//        return $request;
        $id= $request->input("id");
        $cantidad= $request->input("cantSaliente");
        $stock= stock::where('cod_art',$id)->value('sto_cantidad');
        if ($cantidad <=$stock){
            $stock= $stock - $cantidad;
            $resul= stock::where('cod_art',$id)->update(['sto_cantidad' => $stock, 'updated_at'=> Carbon::now(), 'ca_cod_usu' => Auth::user()->usu_ci, 'ca_tipo' => "actualizacion"]);
            if ($resul) {
                return "success";
            }else{
                return "fail";
            }
        }else{
            return"cantExedeStock";
        }

    }
}
