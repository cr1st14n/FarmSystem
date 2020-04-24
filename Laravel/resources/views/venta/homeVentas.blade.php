@extends('layouts.admLay')


@section('dirNavegacion')
<h1>
Formulario de venta
<small> </small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
<li class="active">Gestionar Venta</li>
</ol>
@endsection


@section('content')
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Descripcion de compra</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="hello">
              <div class="col-md-4">
                 <form method="post" action="{{route('venta-agregar')}} "> @csrf
                  <div class="form-group">
                      <input type="number" name="" id="producto" hidden="">
                    <select required  name="producto" class="form-control select2" id="selecArticulo" >
                      <option value="" selected disabled>Seleccione producto</option>
                      @foreach($listArt as $art)
                      <option value ="{{$art->idart}}">
                      {{ $art->art_nombreGenerico}} - {{ $art->art_nombreComercial}} 
                      </option>
                      @endforeach
                    </select>
                  </div>
              <!-- /.form-group -->
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td>
                          <div class="col-md-6">
                            <h5>Sock:<br>
                                Precio:</h5>
                          </div>
                          <div class="col-md-6">
                            <h5 id="detalleArt">... u. <br>
                                00 Bs.-</h5>
                          </div>                          
                        </td>
                        <td>
                          <div>
                            <input id="precioArt" type="text" hidden="">
                            <input  id="cantidad" onkeyup="calcularPrecio(this.value);" placeholder="Cantidad" class="form-control"  type="number" name="cantidad" min="0" max="10" required="">
                          </div>
                        </td>
                          
                      </tr>
                      <tr>
                        <td>
                          <div style="text-align: right;">
                             <button class="btn btn-block btn-default btn-lg" type="submit">
                              <i class="fa fa-shopping-cart"> </i> Agregar al carrito
                            </button>
                          </div>
                        </td>
                        <td style="text-align: right;">
                            <h3 id="Costo1">...Bs.-</h3>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              </div>

              <form method="post" action="{{route('cerrarVenta')}} " id="cerraVenta">@csrf
              <div class="col-md-4">
                <div class="form-group">
                  <label>Datos del cliente</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                          <i class="fa fa-spinner"></i>
                      </div>
                          <input type="text" name="dni" value="{{old('dni')}}" id="clieNit" class="form-control" placeholder=" CI / NIT" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user-plus"></i>
                    </div>
                      <input type="text" name="nombre_cliente" value="{{old('nombre_cliente')}}" id="clieNombre" class="form-control" placeholder="Nomnbre del cliente" autocomplete="off">
                    </div>
                      <span class="help-block" id="nomspan"></span>
                </div>

                  <h5>Tipo de pago</h5>
                <div class="form-group col-xs-3">
                  <div class="radio">
                    <label>
                      <input type="radio" name="tipoPago" id="tipoPago1" value="contado" checked="">
                      Contado
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="tipoPago" id="tipoPago2" value="credito">
                      Credito
                    </label>
                  </div>
                  
                </div>
                <div class="form-group col-xs-9">
                    <a class="btn btn-app"  onclick="document.getElementById('cerraVenta').submit()" >
                      <span class="badge bg-green">{{$cont}} </span>
                      <i class="fa fa-barcode" ></i> Emitir factura
                    </a>
                    <a class="btn btn-app" href="{{route('reiniciar-carrito')}}">
                      <i class="fa fa-repeat"></i> Reiniciar
                    </a>
                </div>
               
                 
              </div>

              <div class="col-md-4">
                <div class="col-md-12">
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Precio Total</span>
                        <span class="info-box-number"><h2>
                            @if($carrito != null)
                              {{$costoTotal}} Bs.-
                            @else
                              ...
                            @endif
                            </h2></span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
                </div>
                <div class="col-md-12" >
                  
                </div>
              </div>           
              </form>
            <div class="col-md-12">
             
              @if($carrito == null)
              Lista sin articulos agregados
              @else
            	<table class="displayn table-bordered table-striped datatable" id="tableCarrito" style="width:100%;" align="right">
                  <thead>
                  <tr>
                    <th width="20%">cod-art</th>
                    <th>Nombre </th>
                    <th>Laboratorio </th>
                    <th style="text-align: right;">Precio unitario</th>
                    <th style="text-align: right;">Cantidad</th>
                    <th style="text-align: right;">Costo</th>
                    <th width="6%" ></th>
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($carrito as $carr)
                 	<tr>
                 		<td>Art-{{$carr->id}} </td>
                 		<td>{{$carr->art_nombreGenerico}} - ( {{$carr->art_nombreComercial}} )</td>
                    <td>{{$carr->art_laboratorio}} </td>
                    <td style="text-align: right;">{{$carr->art_costoVenta}} Bs.- </td>
                 		<td style="text-align: right;">{{$carr->cantidad}} u. </td>
                 		<td style="text-align: right;">{{$carr->costo}} Bs.</td>
                    <td style="text-align: right;">
                      <span class="tooltip-area">
                         
                          <a href="{{route('venta-eliminar',$carr->id)}} " class="btn btn-default btn-sm btn-xs" title="Eliminar"><i class="fa fa-trash-o"></i></a>
                          </span>
                    </td>
                 	</tr>
                 	@endforeach
                  </tbody>
                </table>
              @endif

              @if ($listas != null)

                <div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h5 class="box-titlet" style="text-align: center;: " >
                      <span><i class="icon fa fa-warning"></i> </span>
                      Articulos Observados (Verificar cantidad en stock)
                    </h5>
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <thead>
                            <tr>
                              <th>Codigo</th>
                              <th>Descripcion del articulo</th>
                              <th>Cantidad actual en estock</th>
                            </tr>
                          </thead>
                          <tbody>
                               @foreach($listas as $l)
                                <tr>
                                  <td>Art-{{$l->idart}}</td>
                                  <td>{{$l->art_nombreGenerico}} - {{$l->art_nombreComercial}}</td>
                                  <td>{{$l->sto_cantidad}}</td>
                                </tr>
                                @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              @endif
             
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       
      </div>
     

@endsection

@section('scrípt')
<script src="{{ asset('plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('factura/script2.js') }}"></script>
<script src="{{ asset('asincrono/admin.js') }}"></script>
<script src="{{ asset('asincrono/ventas.js') }}"></script>



<script language="Javascript">
  function imprSelec(nombre) {
    var ficha = document.getElementById(nombre);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write( ficha.innerHTML );
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
  }
  </script>
  @if(Session()->has('imprimir_factura'))

  <script type="text/javascript">

  var ventana = window.open('', 'PRINT', 'height=600,width=600');
   ventana.location.href="printFactura";

  ventana.document.close();
  ventana.focus();
  location.href="reiniciar";
  location.reload();
  </script>
@endif




@endsection