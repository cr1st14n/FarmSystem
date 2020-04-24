@extends('layouts.admLay')


@section('dirNavegacion')
<h1>
  Farm System
  <small>Version 1.0</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
  <li class="active">Registro de usuarios</li>
</ol>
@endsection


@section('content')
<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Usuarios registrados</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-footer clearfix">
    <button type="button" class="btn btn-sm btn-info btn-flat pull-left" data-toggle="modal" data-target="#modal-regisUser">
      Agregar usuario
    </button>
  </div>
  <!-- /.box-footer -->
  <div class="box-body">
    <div class="table-responsive">
      <table class="table no-margin">
        @if($countUser == null)
        No se encontraron Usuarios registrados ...!
        @else
        <thead>
          <tr>
            <th>Cod Usuario</th>
            <th>Nombre Apellido</th>
            <th>C.I.</th>
            <th>Cargo </th>
            <th>Acceso </th>
            <th width="12%"></th>
          </tr>
        </thead>
        <tbody id="listUser">
        </tbody>
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
  <form role="form" action="{{route('crear-usuario')}} " method="post">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Registro de usuario</h4>
        </div>
        <div class="modal-body">
          <div class="box box-warning">

            <!-- text input -->
            <div class="form-group">
              <input type="text" name="nombre" class="form-control" placeholder="Nombre ..." required="" autocomplete="off">
              <input type="text" name="key" value="contraseña" hidden="">
            </div>
            <div class="form-group">
              <input type="text" name="AP" class="form-control" placeholder="Apellido Paterno ..." autocomplete="off">
            </div>
            <div class="form-group">
              <input type="text" name="AM" class="form-control" placeholder="Apellido Materno ..." autocomplete="off">
            </div>
            <div class="form-group">
              <input type="text" name="ci" class="form-control" placeholder="Carnet de identidad C.I. ..." required="" autocomplete="off">
            </div>
            <!-- radio -->
            <div class="form-group">
              <div class="radio">
                <label>
                  <input type="radio" name="acceso" id="optionsRadios1" value="1" checked>
                  Permitir acceso al sistema
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="acceso" id="optionsRadios2" value="0">
                  Denegar acceso al sistema
                </label>
              </div>
            </div>
            <!-- select -->
            <div class="form-group">
              <label>Seleccionar privilegio de usuario</label>
              <select class="form-control" name="cargo">
                <option>Administrador</option>
                <option>Operador </option>
                <option>Atencion</option>
              </select>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <label>Contraseña de usuario por defecto " contraseña "</label>
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </form>
</div>
<!-- /.modal -->


<!-- MODAL Actualizar USUARIO-->
<div class="modal fade" id="modal-actualizatUser">
  <form id="userFormEdit">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" id="btn-modal-actualizatUser-close" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Actualizar Usuario</h4>
        </div>
        <div class="modal-body">
          <div class="box box-warning">

            <!-- text input -->
            <div class="form-group">
              <input type="text" name="nombre" id="nombreUp" class="form-control" placeholder="Nombre ..." required="" autocomplete="off">
            </div>
            <div class="form-group">
              <input type="text" name="AP" id="APUp" class="form-control" placeholder="Apellido Paterno ..." autocomplete="off" required>
            </div>
            <div class="form-group">
              <input type="text" name="AM" id="AMUp" class="form-control" placeholder="Apellido Materno ..." autocomplete="off">
            </div>
            <div class="form-group">
              <input type="text" name="id" id="idUserUdit" hidden>
              <input type="text" name="usu_ci" id="usu_ciUp" class="form-control" placeholder="Carnet de identidad C.I. ..." required="" autocomplete="off">
            </div>
            <!-- select -->
            <div class="form-group">
              <label>Seleccionar privilegio de usuario</label>
              <select class="form-control" name="cargo" id="cargoUp">
                <option value="Administrador">Administrador</option>
                <option value="Operador">Operador </option>
                <option value="Atencion">Atencion</option>
              </select>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left btn-sm" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
          <a type="button" href=" " class="btn btn-danger btn-sm">Resetear Contraseña "12345"</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </form>
</div>
<!-- /.modal -->
<!-- modal delete user -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modal-delete-User">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-md-eliminar-close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Eliminar registro ?</h4>
      </div>
      <div class="modal-footer" id="btn-md-eliminar">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('scrípt')
<script src="{{ asset('asincrono/users.js') }}"></script>

@if($editModal == 1)
<script type="text/javascript">
  $(document).ready(function() {
    $("#modal-actualizatUser").modal("show");
    $('#cargo > option[value={{$usuario->usu_cargo}}]').attr('selected', 'selected');
  });
</script>
@endif
@endsection