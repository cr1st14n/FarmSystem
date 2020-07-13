@extends('layouts.admLay')
@section('head')
<script>

function comprobarClave(){ 
   	clave1 = document.getElementById('key1').value; 
   	clave2 = document.getElementById('key2').value;

   	if (clave1 == clave2){
		document.getElementById('ActualizarKey').style.display = ''; 
   	}
   	else{  
      	// alert("Los campos no coindicen Buelva a intentarlo");
		document.getElementById('ActualizarKey').style.display = 'none'; 
	}
} 
</script> 
@endsection
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

<section class="content">
  <div class="row">
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ asset('plantilla/dist/img/img-02.png') }}" alt="User profile picture">

          <h3 class="profile-username text-center">{{Auth::user()->usu_nombre}} </h3>

          <p class="text-muted text-center">Cargo: {{Auth::user()->usu_cargo}}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Articulos Vendidos: </b> <a class="pull-right">...</a>
            </li>
            <li class="list-group-item">
              <b>Venta Actual: </b> <a class="pull-right">...</a>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <!-- About Me Box -->
      <div class="box box-primary">
        
        <!-- /.box-header -->
        <div class="box-body">
          <p class="text-muted">
           Nombre: {{Auth::user()->usu_nombre}} <br>
           Apellido: {{Auth::user()->usu_appaterno}} {{Auth::user()->usu_apmaterno}}<br>
           C.I.: {{Auth::user()->usu_ci}}<br>
           Tel/Cel: {{Auth::user()->usu_telf}}<br>
           Zona: {{Auth::user()->usu_zona}}<br>
           Domicilio:{{Auth::user()->usu_domicilio}}
          </p>
          <hr>
          <button type="button" class="btn btn-primary btn-block btn-xs" data-toggle="modal" data-target="#modal-default">
                Restablecer contraseña
              </button>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#activity" data-toggle="tab">Actividad Anual</a></li>
          <li><a href="#settings" data-toggle="tab">Editar Datos</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="activity">
           	<div class="row">
		        <div class="col-md-12">
		          <div class="box">
		            <div class="box-header with-border">
		              <h3 class="box-title">Captura de reporte anual</h3>

		              <div class="box-tools pull-right">
		                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
		                </button>
		                <div class="btn-group">
		                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
		                    <i class="fa fa-wrench"></i></button>
		                  <ul class="dropdown-menu" role="menu">
		                    <li><a href="#">Accion</a></li>
		                    <li><a href="#">Refresacar</a></li>
		                    <li><a href="#">Opciones</a></li>
		                    <li class="divider"></li>
		                    <li><a href="#">Separar fechas</a></li>
		                  </ul>
		                </div>
		                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		              </div>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <div class="row">
		                <div class="col-md-8">
		                  <p class="text-center">
		                    <strong>Ventas de: 0-00-000 a 0-00-0000</strong>
		                  </p>

		                  <div class="chart">
		                    <!-- Sales Chart Canvas -->
		                    <canvas id="salesChart" style="height: 180px;"></canvas>
		                  </div>
		                  <!-- /.chart-responsive -->
		                </div>
		                <!-- /.col -->
		                <div class="col-md-4">
		                  <p class="text-center">
		                    <strong>Actividades</strong>
		                  </p>

		                  <div class="progress-group">
		                    <span class="progress-text">Productos agregado</span>
		                    <span class="progress-number"><b>160</b>/200</span>

		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
		                    </div>
		                  </div>
		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">Ventas completadas</span>
		                    <span class="progress-number"><b>310</b>/400</span>

		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-red" style="width: 80%"></div>
		                    </div>
		                  </div>
		                  <!-- /.progress-group -->
		                  
		                  <!-- /.progress-group -->
		                </div>
		                <!-- /.col -->
		              </div>
		              <!-- /.row -->
		            </div>
		            <!-- ./box-body -->
		            
		          </div>
		          <!-- /.box -->
		        </div>
		        <!-- /.col -->
		      </div>
		      <!-- /.row -->
          </div>


          <div class="tab-pane" id="settings">
            <form class="form-horizontal" method="post" action="{{route('actualizarPerfil-usuario')}}">@csrf
               <div class="form-group">
                <label for="inputName" class="col-sm-4 control-label">Numero de Carner de Identidad</label>

                <div class="col-sm-3">
                  <input type="text" class="form-control{{ $errors->has('usu_ci') ? 'is-invalid' : '' }}" name="usu_ci" id="ci" placeholder="Cedula de indentidad" value="{{Auth::user()->usu_ci}}">
                	@if ($errors->has('usu_ci'))
                        <span class="invalid-feedback" role="alert">
                            <strong>CI ya registrado</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-4 control-label">Correo Electronico</label>

                <div class="col-sm-5">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Correo Electronico..." value="{{Auth::user()->email}}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-4 control-label">Nombre</label>

                <div class="col-sm-3">
                  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{{Auth::user()->usu_nombre}} ">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-4 control-label">Apellido Paterno</label>

                <div class="col-sm-3">
                  <input type="text" class="form-control" name="apaterno" id="apaterno" placeholder="Apellido Paterno" value="{{Auth::user()->usu_appaterno}}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-4 control-label">Apellido Materno</label>

                <div class="col-sm-3">
                  <input type="text" class="form-control" name="aMaterno" id="aMaterno" placeholder="Apellido Materno" value="{{Auth::user()->usu_apmaterno}}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputExperience" class="col-sm-4 control-label">Zona Resisdencial</label>

                <div class="col-sm-3">
                  <input type="text" class="form-control" name="zona" id="domicilio" placeholder="Zona" value="{{Auth::user()->usu_zona}}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputSkills" class="col-sm-4 control-label">Direccion del Domicilio </label>

                <div class="col-sm-5">
                  <textarea class="form-control" name="domicilio" id="domicilio" placeholder="Direccion del domicilio...">{{Auth::user()->usu_domicilio}}</textarea>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-danger">Actualizar Informacion</button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <div class="modal fade" id="modal-default">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Restablecer Contraseña</h4>
	      </div>
		<form action="{{route('resetKey-usuario')}} " method="any">@csrf
	      <div class="modal-body">
	         <div class="register-box-body">
			      <div class="form-group has-feedback">
			        <input id="key1" onkeyup="comprobarClave();" type="password" name="key" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Contraseña" required="" minlength="5" >
			        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
			      </div>
			      <div class="form-group has-feedback">
			        <input id="key2" onkeyup="comprobarClave();" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Repetir Contraseña" required="" minlength="5">
			        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
			        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
			      </div>
	 		 </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
	        <button type="submit" id="ActualizarKey" class="btn btn-primary">Actualizar contraseña</button>
	      </div>
		</form>
	    </div>
	    <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

  
@endsection

@section('scrípt')
<script type="text/javascript">
		
document.getElementById('ActualizarKey').style.display = 'none'; 
</script>
@endsection
