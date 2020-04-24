<?php $__env->startSection('dirNavegacion'); ?>
<h1>

<small> </small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Clientes</a></li>
<li class="active">Registro</li>
</ol>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<!-- TABLE: LATEST ORDERS -->
<div class="row" >
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Clientes registrados</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-footer clearfix" >
        <button type="button" class="btn btn-sm btn-primary btn-flat pull-left" data-toggle="modal" data-target="#modal-regisUser">
         Registrar Cliente Nuevo
        </button>
      </div>
      <!-- /.box-footer -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin" onload="onListClientes();">
            <thead>
            <tr>
              <th>COD</th>
              <th>DNI</th>
              <th>NOMBRE</th>
              <th width="18%"></th>
            </tr>
            </thead >
            <tbody id="listClientes">
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Datos de registro de clientes</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body ">
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Este mez</span>
              <span class="info-box-number"><?php echo e($clieMez); ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 10%"></div>
              </div>
              <span class="progress-description">
                    % incremeto Mensual
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-yellow disabled color-palette">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Anual</span>
              <span class="info-box-number"><?php echo e($clieAño); ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 10%"></div>
              </div>
              <span class="progress-description">
                    % incremento anula
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-green ">
            <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total clientes</span>
              <span class="info-box-number"><?php echo e($clieTotal); ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 10%"></div>
              </div>
              <span class="progress-description">
                    Total clientes
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
    </div>
  </div>
</div>
    <!-- MODAL REGISTRAR USUARIO -->          
<div class="modal fade" id="modal-regisUser">
  <form role="form" action="<?php echo e(route('clientes-registrar')); ?>" method="post">
          <?php echo csrf_field(); ?>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="Codventa">Registrar nuevo Cliente</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="" name="Nombre" placeholder="Nombre completo del Cliente...">
            </div>
          </div><br>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">DNI:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="" name="dni" placeholder="CI / DNI...">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-default pull-right" >Registrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </form>
</div>
    <!-- MODAL editar USUARIO -->          
<div class="modal fade" id="modal-editUser">
  <form role="form" id="form-cliente_update">
          <?php echo csrf_field(); ?>
          <input type="number" id="id_cliente_update" name="id_cliente_update">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="Codventa">Actualizar datos del cliente Cliente</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="Nombre_clie_up" name="Nombre_clie_up" placeholder="Nombre completo del Cliente...">
            </div>
          </div><br>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">DNI:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="dni_clie_up" name="dni_clie_up" placeholder="CI / DNI...">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-danger pull-right" >Actualizar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </form>
</div>
<!-- /.modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scrípt'); ?>
<script src="<?php echo e(asset('asincrono/admin.js')); ?>"></script>
<script src="<?php echo e(asset('asincrono/clientes.js')); ?>"></script>
<script type="text/javascript">
  window.onload = onListClientes();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admLay', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>