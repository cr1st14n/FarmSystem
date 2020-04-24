<?php

namespace App\Http\Controllers;

use App\stock;
use App\articulos;
use App\fechvencimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StockController extends Controller
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
        $listArt = articulos::join('stocks','stocks.id','=','articulos.id')->select('articulos.*','stocks.sto_cantidad')->get();
        $resulLisArt = articulos::count("id");
        if ( $resulLisArt != 0)  {
            $resulLisArt = 1;
        }else{
            $resulLisArt = 0;
        }
        //return "$resulLisArt  $listArt";
        return view('articulos.homeArticulos')->with("listArt",$listArt)->with("resulLisArt",$resulLisArt);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(stock $stock)
    {
        //
    }

    public function agregar(Request $request)
    {
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
                \Session::flash('flash_info','Stock Actualizado');
                return redirect()->action('ArticulosController@index');
            }else{
                \Session::flash('flash_danger','Error vuelva a intentarlo');
                return redirect()->action('ArticulosController@index');
            }    
    }
    public function sustraer(Request $request)
    {
        //return $request;
        $id= $request->input("id");
        $cantidad= $request->input("cantidad");
        $stock= stock::where('cod_art',$id)->value('sto_cantidad');
        $stock= $stock - $cantidad;
        $resul= stock::where('cod_art',$id)->update(['sto_cantidad' => $stock, 'updated_at'=> Carbon::now(), 'ca_cod_usu' => Auth::user()->usu_ci, 'ca_tipo' => "actualizacion"]);
        if ($resul) {
                \Session::flash('flash_info','Stock Actualizado');
                return redirect()->action('ArticulosController@index');
            }else{
                \Session::flash('flash_danger','Error vuelva a intentarlo');
                return redirect()->action('ArticulosController@index');
            }
    }
}
