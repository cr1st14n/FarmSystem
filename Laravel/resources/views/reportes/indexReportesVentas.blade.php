@extends('layouts.admLay')

@section('head')
@endsection

@section('dirNavegacion')
<h1>  
  
  <small> </small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
  <li class="active">Generador de Reportes ventas</li>
</ol>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
        <div class="col-md-6">
          <div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-calendar"></i>
              <h3 class="box-title">Detalle del reporte de ventas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form class="form-horizontal" target="_blank" method="post" action="{{route('generar-reporte-ventas')}} ">@csrf
              <div class="box-body">
               
                 <div id=divFechaRango>   
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tipo de Venta</label>
                      <div class="col-sm-6">
                        <select name="tipoVenta" class="form-control">
                          <option value="general">General</option>
                          <option value="detalleArticulo">Venta con detalle de Articulos</option>
                        </select>
                      </div>
                    </div>
                </div>
                <div id=divFechaRango>   
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Seleccionar usuario</label>
                      <div class="col-sm-6">
                        <select name="selectUsuario" class="form-control" required="">
                          <option value="todos">Todos los usuarios</option>
                            @foreach($usuarios as $user)
                              <option value="{{$user->usu_ci}}">{{$user->usu_nombre }} {{$user->usu_appaterno }} {{$user->usu_apmaterno }} </option>
                            @endforeach
                         
                        </select>
                      </div>
                    </div>
                </div>
                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Tipo de fecha</label>

                  <div class="col-sm-6">
                    <select name="tipofecha" class="form-control" id="selectFechaVenta" required="">
                      <option value="" selected="" disabled="">Seleccionar</option>
                      <option value="1">Simple</option>
                      <option value="2">Rango</option>
                    </select>
                  </div>
                </div>
                  
                <div id="fechaSimpleVenta" style="display: none;">
                  <div class="form-group" id="fecha0" >
                    <label for="" class="col-sm-3 control-label">Fecha unica</label>

                    <div class="col-sm-6">
                      <input  name="fecha0" type="date" class="form-control" id="inpfecha0" value="{{$dateActual}}">
                    </div>
                  </div>
                </div>
                <div id="fechaRangoVenta" style="display: none;">   
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Fecha Inicio</label>
                      <div class="col-sm-6">
                        <input  name="fecha1" type="date" class="form-control" id="inpfecha1" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Fecha Final</label>

                      <div class="col-sm-6">
                        <input  name="fecha2" type="date" class="form-control" id="inpfecha2" placeholder="">
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" target="_blank" class="btn btn-success btn-xs btn-block">Generar imprecion</button>
              </div>
              <!-- /.box-footer -->
            </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-6">
         
        </div>
        <!-- /.col -->
      </div>
</section>
<!-- /.content -->
@endsection

@section('scrípt')
<script src="{{ asset('asincrono/articulos.js') }}"></script>
<script src="{{ asset('asincrono/reportes.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection


