<?php $__env->startSection('dirNavegacion'); ?>
<h1>
    Formulario de venta
    <small> </small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
    <li class="active">Gestionar Venta</li>
</ol>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Usuario</label>
                        <select class="form-control select2 select2-hidden-accessible small" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="<?php echo e(Auth::user()->usu_ci); ?>"><?php echo e(Auth::user()->usu_nombre); ?> <?php echo e(Auth::user()->usu_appaterno); ?> / <?php echo e(Auth::user()->usu_ci); ?> </option>
                            <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->usu_ci); ?>"><?php echo e($user->usu_nombre); ?> <?php echo e($user->usu_appaterno); ?> / <?php echo e($user->usu_ci); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>Fecha</label>
                        <input type="date" class="form-control " value="<?php echo e($fecha); ?>">
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Almacen</label>
                        <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a State" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option>almacen 1</option>
                            <option>almacen 2</option>
                            <option>almacen 3</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>Tipo</label>
                        <select id="ventaTipoPago" class="form-control select2 select2-hidden-accessible" data-placeholder="Select a State" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option>Contado</option>
                            <option>Credito</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>NIT /CI</label>
                                <div class="input-group ">
                                    <input type="text" id="nitCliente" class="form-control small">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" id="btnAgregarCliente"><i class="fa fa-user-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Cliente</label><br>
                                <input type="text" class="form-control small" id="nombreClienteVenta">
                            </div>
                        </div>
                    </div>

                    <!-- /.form-group -->
                    <div class="form-group-sm">
                        <label>Razon Social</label>
                        <input type="text" class="form-control input-group-sm">
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-3">
                    <!-- /.form-group -->
                    <div class="box-body">
                        <a class="btn btn-app" onclick="ShowModalFacturar()">
                            <i class="fa fa-shopping-cart"></i> Comcluir Venta
                        </a>
                        <a class="btn btn-app" id="btnEliminarVenta">
                            <i class="fa fa-eraser"></i> Eliminar Venta
                        </a>
                        <p></p>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Seleccionar articulo</label>
                        <select id="articuloSelec" class="form-control select2 select2-hidden-accessible small" style="width: 100%;" aria-hidden="true" required tabindex="1">
                            <option value="" selected disabled>...</option>
                            <?php $__currentLoopData = $articulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $art): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($art->id); ?>"><?php echo e($art->art_nombreGenerico); ?> - <?php echo e($art->art_nombreComercial); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label> Precio U. :</label> <span><strong id="precioART"> ... </strong> Bs.-</span><br>
                            <label> Stock: </label> <span><strong id="stockART"> ... </strong></span><br>
                            <label> Total :</label> <span><strong id="TotalPrecioArt"> ... </strong> Bs.-</span>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group ">
                                <input type="number" id="cantidadArt" class="form-control" min="0" oninput="validar('cantidadArt')"  required placeholder="Unidades" tabindex="2"  >
                                <div class="input-group-btn">
                                    <button id="btnAgregarArt" type="submit" class="btn btn-success" tabindex="4"><i class="fa fa-shopping-cart"></i></button>
                                </div>
                                <!-- /btn-group -->
                            </div>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Descuento" size="" min="0" max="100" id="descuentoArt" oninput="validar('descuentoArt')" tabindex="3">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-1" id="imagenArt">
                    
                </div>
                <div class="col-md-3">
                    <h4>Accion terapeutica: <strong>... </strong><br>
                        Nombre generico: <strong id="nomGenericoArt">...</strong><br>
                        Linea / marca: <strong>...</strong><br>
                        Provedor havitual: <strong id="provedorArt">...</strong><br>
                    </h4>
                </div>
                <!-- /.col -->
                <div class="col-md-3">
                    <h4>
                        Unidades : <label id="cantidadVenta"></label><br>
                        Precio total: <label id="CostoTotal"></label>
                    </h4>
                    <h4>
                    </h4>
                        <form class=" form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="ventEfectivo" class="col-sm-4 control-label">Efectivo</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="ventEfectivo" placeholder="Efectivo" onkeyup="calcularCambio(this.value)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ventCambio" class="col-sm-4 control-label">Cambio</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="ventCambio" placeholder="Cambio" value="890" disabled>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.box-body -->

    </div>
    <br>
    <br>
    <!-- /.box -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Detalle de venta</h3>
                    
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12" id="tableCarrito">
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
</section>
<div class="modal fade" id="modalCreateCliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar nuevo cliente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Nombre </label>
                        <input type="text" class="form-control" id="nombreNewCliente" oninput="validar('nombreNewCliente')" required minlength="3">
                    </div>
                    <div class="form-group col-sm-6">
                        <lavel>NIT / CI</lavel>
                        <input type="number" id="nitNewCliente" class="form-control" oninput="validar('nitNewCliente')" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnRegisClie" class="btn btn-primary">Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="mdFacturar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 style="text-align: center">Desea imprimir factura?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnFacturar" class="btn btn-primary pull-left" onclick="cerrarventaSF()">No imprimir factura</button>
                <button type="button" class="btn btn-success" id="btnRealizarVenta">Imprimir factura</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /.modal -->
<div class="modal fade" id="modalArtSinStock" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titleModalArtSinStocl">Lista de articulos que ecceden eccistencias en Stock</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="listArtSinStock">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <h5>Los articulos fueron eliminados de la venta, Agreguelos nuevamente!</h5>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scrípt'); ?>
<script src="<?php echo e(asset('plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>



<script src="<?php echo e(asset('asincrono/ventasV2.js')); ?>"></script>
<script language="Javascript">
    function imprSelec(nombre) {
        var ficha = document.getElementById(nombre);
        var ventimp = window.open(' ', 'popimpr');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.close();
        ventimp.print();
        ventimp.close();
    }
</script>
<?php if(Session()->has('imprimir_factura')): ?>
<script type="text/javascript">
    var ventana = window.open('', 'PRINT', 'height=600,width=600');
    ventana.location.href = "printFactura";
    ventana.document.close();
    ventana.focus();
    location.href = "reiniciar";
    location.reload();
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admLay', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>