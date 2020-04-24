@extends('layouts.admLay')


@section('dirNavegacion')
<h1>

<small> </small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
<li class="active">Registro de provedores</li>
</ol>
@endsection


@section('content')
<!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Proveedores registrados</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-footer clearfix">
              <button type="button" class="btn btn-sm btn-primary btn-flat pull-left" data-toggle="modal" data-target="#modal-regisUser">
               Registrar proveedor
              </button>
            </div>
            <!-- /.box-footer -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  @if($resulLisArt != 0)
                  <thead>
                  <tr>
                    <th>Cod Art</th>
                    <th>Nombre generico</th>
                    <th>Nombre comercial</th>
                    <th>Laboratorio</th>
                    <th>Proveedor</th>
                    <th width="5%">Costo proveedor</th>
                    <th width="5%">Costo venta</th>
                    <th>Stock</th>
                    <th width="16%">Accion</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($listArt as $art)
                    <tr>
                      <td>art-{{ $art-> id}} </td>
                      <td>{{ $art->art_nombreGenerico}} </td>
                      <td>{{ $art->art_nombreComercial}} </td>
                      
                      <td>{{ $art->art_laboratorio}} </td>
                      <td>{{ $art->art_proveedor}}</td>
                      <td>{{ $art->art_costoProveedor}} Bs.- </td>
                      <td>{{ $art->art_costoVenta}} Bs.-</td>
                      <td>Calculando... </td>
                      <td>
                          <span class="tooltip-area">
                          <a href="" class="btn btn-default btn-sm" title="Ingreso"><i class="fa  fa-arrow-down"></i></a>
                          <a href="" class="btn btn-default btn-sm" title="salida"><i class="fa  fa-arrow-up"></i></a>
                          <a href="" class="btn btn-default btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>
                          <a href="{{route('destroy.articulo',$art->id)}} " class="btn btn-default btn-sm" title="Eliminar"><i class="fa fa-trash-o"></i></a>
                          </span>
                      </td>  
                    </tr>
                  @endforeach
                      
                  
                  
                  </tbody>
                  @else
                  No se registraron articulos...
                  @endif
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /.box -->


    <!-- MODAL REGISTRAR USUARIO-->          
        <div class="modal fade" id="modal-regisUser">
          <form role="form" action="{{route('gregar-stock')}} " method="post">
                  @csrf
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Datos del proveedor</h4>
              </div>
              <div class="modal-body">
                 <div class="box box-warning">                                
                    <!-- text input -->
                    <div class="form-group" >
                      <input type="text"  name="nombre" class="form-control" placeholder="Nombre..." required="">
                    </div>
                    <div class="form-group">
                      <input type="text" name="direccion" class="form-control" placeholder="Direccion...">
                    </div>
                    <div class="form-group">
                      <input type="text" name="telf" class="form-control" placeholder="Numero telefono / celular ...">
                    </div>
                    <div class="form-group">
                      <input type="text" name="empresa" class="form-control" placeholder="Empresa ...">
                    </div>
                    
              
          </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
          </form>
        </div>
        <!-- /.modal -->
@endsection