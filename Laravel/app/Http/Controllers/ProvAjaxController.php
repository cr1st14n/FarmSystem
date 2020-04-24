<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\articulos;
use App\stock;
use App\provedores;
use App\fechvencimiento;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProvAjaxController extends Controller
{
	public function listSelect()
	{
		return provedores::select('id','prov_nombre')->get();
	}
	public function listProvArti1()
	{
		 //return datatables()->eloquent(articulos::join('provedores','provedores.id','=','articulos.art_proveedor')->select('provedores.*','articulos.art_nombreGenerico','articulos.art_nombreComercial')->orderBy('provedores.id'))->toJson();

		return articulos::join('provedores','provedores.id','=','articulos.art_proveedor')->select('provedores.*','articulos.art_nombreGenerico','articulos.art_nombreComercial')->orderBy('provedores.id')->get();
	}
}
