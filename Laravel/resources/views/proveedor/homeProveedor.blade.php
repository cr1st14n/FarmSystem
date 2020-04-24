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
        <thead>
          <tr>
            <th>Codigo</th>
            <th>Nombre </th>
            <th>Direccion</th>
            <th>Telf/Cel </th>
            <th>Empresa</th>
            <th width="16%">Accion</th>
          </tr>
        </thead>
        <tbody id="provedores-list-table">

        </tbody>

      </table>
    </div>
    <!-- /.table-responsive -->
  </div>
  <!-- /.box-body -->

</div>
<!-- /.box -->


<!-- MODAL REGISTRAR USUARIO-->
<div class="modal fade" id="modal-regisUser">
  <form role="form" action="{{route('crear-proveedor')}} " method="post">
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
            <div class="form-group">
              <input type="text" name="nombre" class="form-control" placeholder="Nombre..." required="" required="">
            </div>
            <div class="form-group">
              <input type="text" name="direccion" class="form-control" placeholder="Direccion..." required="">
            </div>
            <div class="form-group">
              <input type="text" name="telf" class="form-control" placeholder="Numero telefono / celular ..." required="">
            </div>
            <div class="form-group">
              <input type="text" name="empresa" class="form-control" placeholder="Empresa ..." required="">
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
<div class="modal fade" id="modal-edit-Provedor">
  <form id="form-edit-Provedor">
  <input type="text" id="form-edit-Provedor-id" hidden>
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
            <div class="form-group">
              <input type="text" id="nombreUP" class="form-control" placeholder="Nombre..." required="" required="">
            </div>
            <div class="form-group">
              <input type="text" id="direccionUP" class="form-control" placeholder="Direccion..." required="">
            </div>
            <div class="form-group">
              <input type="text" id="telfUP" class="form-control" placeholder="Numero telefono / celular ..." required="">
            </div>
            <div class="form-group">
              <input type="text" id="empresaUP" class="form-control" placeholder="Empresa ..." required="">
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
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="md-delete-prov">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-md-eliminar-close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="text-md-prov-eliminar"></h4>
      </div>
      <div class="modal-footer" id="btn-md-prov-eliminar">
        <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Aceptar</button> -->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

@endsection
@section('scrípt')
<script src="{{ asset('asincrono/provedores.js') }}"></script>
@endsection