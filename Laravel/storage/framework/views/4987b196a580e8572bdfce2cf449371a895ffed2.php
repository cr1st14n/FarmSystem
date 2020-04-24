<?php $__env->startSection('dirNavegacion'); ?>
<h1>

<small> </small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i>Administrar</a></li>
<li class="active">Registro de ventas</li>
</ol>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Ventas registradas</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-footer clearfix " style="position: absolute;" hidden="">
              <button type="button" class="btn btn-sm btn-primary btn-flat pull-left" data-toggle="modal" data-target="#modal-regisUser">
               Registrar proveedor
              </button>
            </div>
            <!-- /.box-footer -->
            <div class="box-body">
              <div class="table-responsive">
               
                <table class="table table-striped display compact  " id="regisVentas" style="width:100%;">
                  <thead>

                  <tr>
                    <th># Factura</th>
                    <th>Articulos</th>
                    <th>Venta </th>
                    <th>Estado de pago</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th width="9%"></th>
                  </tr>
                  </thead>
                 
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /.box -->



    <!-- MODAL REGISTRAR USUARIO-->          
        <div class="modal fade" id="modal-regisUser">
          <form role="form" action="" method="post">
                  <?php echo csrf_field(); ?>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="Codventa">...</h4>
              </div>
              <div class="modal-body">
                    <table class="table" >
                    <thead>
                      <th>Articulo</th>
                      <th>Cantidad</th>
                      <th>Precio</th>
                    </thead>
                    <tbody id="table">
                    </tbody>
                  </table>
                    <label id="CostoDeVenta">...</label><br>
                    <h4>Descrion </h4>
                    <label id="ventaUsuario">...</label><br>
                    <label id="ventaFecha">...</label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
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

<script src="<?php echo e(asset('plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('asincrono/ventas.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admLay', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>