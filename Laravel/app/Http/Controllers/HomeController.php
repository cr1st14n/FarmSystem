<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\user;
use App\articulos;
use App\stock;
use App\provedores;
use App\fechvencimiento;
use App\clientes;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function indexAdm()
    {
        $a = 2018 - 10 - 05;
        $b = 2018 - 10 - 06;
        $a = Carbon::parse($a)->format('d-m-Y');
        $b = Carbon::parse($b)->format('Y-m-d');
        //$l = provedores::where('ca_fecha','>=','2018-10-01')->where('ca_fecha','<=','2018-10-11')->select('ca_fecha')->get();
        //return $l;
        $usuarios = user::count('id');
        $provedores = provedores::count('id');
        $articulos = articulos::count('id');
        $clientes = clientes::count('id');
        $fechActual = Carbon::now();
        $fecha0 = Carbon::now()->format('d-m-y');
        $fecha1a = Carbon::now()->format('Y-m-d');
        $fecha1b = Carbon::now()->addDay(5)->format('Y-m-d');
        $fecha2a = Carbon::now()->addDay(6)->format('Y-m-d');
        $fecha2b = Carbon::now()->addDay(10)->format('Y-m-d');
        $fecha3a = Carbon::now()->addDay(11)->format('Y-m-d');
        $fecha3b = Carbon::now()->addDay(15)->format('Y-m-d');
        $fecha4a = Carbon::now()->addDay(16)->format('Y-m-d');
        $fecha4b = Carbon::now()->addDay(20)->format('Y-m-d');
        $fecha5a = Carbon::now()->addDay(21)->format('Y-m-d');
        $fecha5b = Carbon::now()->addDay(30)->format('Y-m-d');
        //return " $fecha1a / $fecha1b  , $fecha2a / $fecha2b, $fecha3a / $fecha3b, $fecha4a / $fecha4b, $fecha5a / $fecha5b";
        //$list1 = fechvencimiento::select('cod_art')->groupBy('fv_fechavencimiento','cod_art')->get();
        $list1 = DB::table('fechvencimientos as f')->join('articulos as a', 'a.id', '=', 'f.cod_art')
            ->select('f.fv_fechavencimiento', 'art_nombreGenerico', 'art_nombreComercial', 'art_laboratorio')
            ->where('f.fv_fechavencimiento', '>=', $fecha1a)
            ->where('f.fv_fechavencimiento', '<=', $fecha1b)
            ->groupBy('f.fv_fechavencimiento', 'a.art_nombreGenerico', 'a.art_nombreComercial', 'art_laboratorio')
            ->get();
        $list2 = DB::table('fechvencimientos as f')->join('articulos as a', 'a.id', '=', 'f.cod_art')
            ->select('f.fv_fechavencimiento', 'art_nombreGenerico', 'art_nombreComercial', 'art_laboratorio')
            ->where('f.fv_fechavencimiento', '>=', $fecha2a)
            ->where('f.fv_fechavencimiento', '<=', $fecha2b)
            ->groupBy('f.fv_fechavencimiento', 'a.art_nombreGenerico', 'a.art_nombreComercial', 'art_laboratorio')
            ->get();
        $list3 = DB::table('fechvencimientos as f')->join('articulos as a', 'a.id', '=', 'f.cod_art')
            ->select('f.fv_fechavencimiento', 'art_nombreGenerico', 'art_nombreComercial', 'art_laboratorio')
            ->where('f.fv_fechavencimiento', '>=', $fecha3a)
            ->where('f.fv_fechavencimiento', '<=', $fecha3b)
            ->groupBy('f.fv_fechavencimiento', 'a.art_nombreGenerico', 'a.art_nombreComercial', 'art_laboratorio')
            ->get();
        $list4 = DB::table('fechvencimientos as f')->join('articulos as a', 'a.id', '=', 'f.cod_art')
            ->select('f.fv_fechavencimiento', 'art_nombreGenerico', 'art_nombreComercial', 'art_laboratorio')
            ->where('f.fv_fechavencimiento', '>=', $fecha4a)
            ->where('f.fv_fechavencimiento', '<=', $fecha4b)
            ->groupBy('f.fv_fechavencimiento', 'a.art_nombreGenerico', 'a.art_nombreComercial', 'art_laboratorio')
            ->get();
        $list5 = DB::table('fechvencimientos as f')->join('articulos as a', 'a.id', '=', 'f.cod_art')
            ->select('f.fv_fechavencimiento', 'art_nombreGenerico', 'art_nombreComercial', 'art_laboratorio')
            ->where('f.fv_fechavencimiento', '>=', $fecha5a)
            ->where('f.fv_fechavencimiento', '<=', $fecha5b)
            ->groupBy('f.fv_fechavencimiento', 'a.art_nombreGenerico', 'a.art_nombreComercial', 'art_laboratorio')
            ->get();
        //return $list1;
        //$list1 = fechvencimiento::select('fv_fechavencimiento')->groupBy('fv_fechavencimiento')->join('articulos','articulos.id','=','fechvencimientos.cod_art')->select('fechvencimientos.cod_art','articulos.art_nombreGenerico','articulos.art_nombreComercial','articulos.art_laboratorio' )->where('fv_fechavencimiento','>=',$fecha1a)->where('fv_fechavencimiento','<=',$fecha1b)->get();

        //$list1 = fechvencimiento::join('articulos','articulos.id','=','fechvencimientos.cod_art')->select('fechvencimientos.cod_art','articulos.art_nombreGenerico','articulos.art_nombreComercial','articulos.art_laboratorio' )->where('fv_fechavencimiento','>=',$fecha1a)->where('fv_fechavencimiento','<=',$fecha1b)->get();
        //$list2 = fechvencimiento::join('articulos','articulos.id','=','fechvencimientos.cod_art')->select('fechvencimientos.*','articulos.art_nombreGenerico','articulos.art_nombreComercial','articulos.art_laboratorio' )->where('fv_fechavencimiento','>=',$fecha2a)->where('fv_fechavencimiento','<=',$fecha2b)->get();
        //$list3 = fechvencimiento::join('articulos','articulos.id','=','fechvencimientos.cod_art')->select('fechvencimientos.*','articulos.art_nombreGenerico','articulos.art_nombreComercial','articulos.art_laboratorio' )->where('fv_fechavencimiento','>=',$fecha3a)->where('fv_fechavencimiento','<=',$fecha3b)->get();
        //$list4 = fechvencimiento::join('articulos','articulos.id','=','fechvencimientos.cod_art')->select('fechvencimientos.*','articulos.art_nombreGenerico','articulos.art_nombreComercial','articulos.art_laboratorio' )->where('fv_fechavencimiento','>=',$fecha4a)->where('fv_fechavencimiento','<=',$fecha4b)->get();
        //$list5 = fechvencimiento::join('articulos','articulos.id','=','fechvencimientos.cod_art')->select('fechvencimientos.*','articulos.art_nombreGenerico','articulos.art_nombreComercial','articulos.art_laboratorio' )->where('fv_fechavencimiento','>=',$fecha5a)->where('fv_fechavencimiento','<=',$fecha5b)->get();

        //return " $list1 $list2 $list3 $list4 $list5";

        return view('homeAdm')->with("usuarios", $usuarios)
            ->with("provedores", $provedores)
            ->with("articulos", $articulos)
            ->with("clientes", $clientes)
            ->with("list1", $list1)
            ->with("list2", $list2)
            ->with("list3", $list3)
            ->with("list4", $list4)
            ->with("list5", $list5);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function modelo()
    {
        return view('modelo');
    }

    public function cont123()
    {
        $pdf = PDF::setPaper('a4')->loadView('welcome');
        return $pdf->stream('invoice.pdf');
        
    }
}
