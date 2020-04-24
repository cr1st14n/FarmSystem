@extends('layouts.admLay')

@section('head')
<link rel="stylesheet"  href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('dirNavegacion')
<h1>
Articulos registrados
<small> </small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
<li class="active">Registro de Articulos</li>
</ol>
@endsection

@section('content')
<div class="box">
    <div class="box-header">
      <button type="button" class="btn btn-sm btn-primary btn-flat pull-left" data-toggle="modal" data-target="#modal-regisUser">
       Agregar articulo
      </button>
      <div class="bo-tools pull-right">
        <div class="input-group input-group-sm"  style="width: 150px;">
          <input type="text" class="form-control " name="buscar" id="buscar" onkeyup="onBuscarArticulo();">
          <div class="input-group-btn" >
            <button class="btn  btn-default" id="btnBuscar" type="button" onclick="onBuscarArticulo();">
              <i class="fa fa-search"></i>
            </button>
            
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="tableArticulos"  class="table table-striped display compact"  align="center">
        @if($resulLisArt != 0)
          <thead>
          <tr>
            <th>Cod Art</th>
            <th>N. generico</th>
            <th>N. comercial</th>
            <th>Costo proveedor</th>
            <th>Costo venta</th>
            <th align="center">Stock</th>
            <th width="9%"></th>
          </tr>
          </thead>
          <tbody id="listarticulo" >
          </tbody>
          @else
          No se registraron articulos...
          @endif
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

  <div class="modal fade" id="agregarStock" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Gestionar Descripcion y Stock del Articulo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-7">
            
             <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Descripcion:</h3>
            </div>
            <form class="form-horizontal" method="post" action="{{route('update-art')}} ">@csrf
            <input type="text" name="id_art" id="id_art" hidden="">
              <div class="box-body" id="datosArticulo1">
                <div class="form-group ">
                  <div class="col-sm-6">
                    <label for="" class=" control-label"><i class="fa  fa-plus-square"></i>N. Generico</label>
                    <input type="text" class="form-control" id="ngenerico" name="ngenerico" placeholder="">
                  </div>
                  <div class="col-sm-6">
                    <label for="" class=" control-label"><i class="fa  fa-plus-square"></i>N. Comercial</label>
                    <input type="text" class="form-control" id="ncomercial" name="ncomercial" placeholder="">
                  </div>
                  <div class="col-sm-6">
                    <label for="" class=" control-label"><i class="fa fa-bell-o"></i>Laboratorio</label>
                    <input type="text" class="form-control" id="laboratorio" name="laboratorio" placeholder="">
                  </div>
                  <div class="col-sm-6"><div id="proveedor"></div>
                    <label for="" class=" control-label"><i class="fa fa-truck"></i>Provedor</label>
                    <select id="selectProvedor" name="proveedor" class="form-control">
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label for="" class=" control-label"><i class="fa fa-money"></i>Costo Provedor</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="cprovedor" name="cprovedor" placeholder="">
                  </div>
                  <div class="col-sm-6">
                    <label for="" class=" control-label"><i class="fa fa-money"></i>Costo Venta</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="cventa" name="cventa" placeholder="">
                  </div>
                </div>
              </div>
            <button type="submit" class="btn btn-block btn-info btn-xs">Editar datos del articulo</button>
            </form> 
          </div> 
            </div>
            <div class="col-md-5" >
                <h5>Resgistrar ingreso a Stock </h5>
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="info-box" id="acantidad">
                    <!-- aca se inllecta el stock de js-->          
              </div>
            </div>
              <form action="{{route('agregar-stock')}} " method="post">@csrf
              <div class="input-group">
                <input type="text" id="idArt" name="id" hidden>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" name="vencimiento" class="form-control" >
              </div>
              <br>
              <div class="input-group input-group-sm">
                <input class="form-control" type="number" name="cantidad" id="cantEntrante" required="" min="0">
                <span class="input-group-btn">
                  <button class="btn btn-success btn-flat" type="submit">Ingresar Articulos</button>
                </span>
              </div>
              </form>
              <hr>
              <form action="{{route('sustraer-stock')}}" method="post">@csrf
              <h5>Sustraer aticulos del stock</h5>
              <div class="input-group input-group-sm">
                <input type="text" id="idArt2" name="id" hidden>
                <input class="form-control" type="number" name="cantidad" id="cantSaliente" required="" min="0">
                <span class="input-group-btn">
                  <button class="btn btn-danger btn-flat" type="submit">Sustraer Articulos</button>
                </span>
              </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="form-group">
          </div>
        </div>
       </div>
    </div>
  </div>
<!-- MODAL REGISTRAR USUARIO-->          
  <div class="modal fade" id="modal-regisUser">
    <form role="form" action="{{route('crear-art')}} " method="post">
            @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Registrar nuevo articulo</h4>
        </div>
        <div class="modal-body">
           <div class="box box-warning">                  	            
              <!-- text input -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group " >
                    <input type="text"  name="nombre generico" class="form-control" placeholder="Nombre generico ..." required="" autocomplete="off" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="nombre comercial" class="form-control" placeholder="Nombre comercial ..." required="" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="composicion" class="form-control" placeholder="Composicion ...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="laboratorio" class="form-control" placeholder="Laboratorio ..." required="">
                  </div>
                </div>

              </div>
              <div class="form-group">
                <select class="form-control select2" name="proveedor" style="width: 100%;" required="">
                  <option value="" disabled selected>Seleccionar proveedor...</option>
                  @foreach($proveedores as $prov)
                    <option value="{{$prov->id}} " >{{$prov->prov_nombre}} / {{$prov->prov_direccion}} </option>
                  @endforeach
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">Bs.</span>
                    <input type="number" step="0.01" name="costo proveedor" class="form-control" placeholder="Costo proveedor ...">
                  </div><br>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">Bs.</span>
                    <input type="number" step="0.01" name="costo venta" class="form-control" placeholder="Costo para la venta ..." required="">
                  </div><br>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">unidades</span>
                    <input type="text" name="stock" class="form-control" placeholder="Cantidad inicial (opcional) ...">
                  </div><br>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Fecha de vencimiento (opcional)</label>
                    <div class="input-group">
                      <input type="date" name="fv" class="form-control" placeholder="Fecha vencimiento (opcional) ...">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                    </div><br>
                  </div>
                </div>
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

@section('scrípt')
<script src="{{ asset('asincrono/articulos.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
  $(function () {
    $('').DataTable()
    $('#tableArticulos').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true,
      "scrollY":        "60vh",
      "scrollCollapse": true,
      "paging":         false,
      "language": {
            "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        }
    })
  })
</script>
@endsection


