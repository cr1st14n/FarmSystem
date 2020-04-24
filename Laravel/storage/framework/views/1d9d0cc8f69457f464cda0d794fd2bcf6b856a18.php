<label id="CarritoCantidad" hidden><?php echo e($cont); ?></label>
<label id="CarritoCosto" hidden><?php echo e($costo); ?></label>
<label id="CarritoUnidades" hidden><?php echo e($unidades); ?></label>
<div class="box-body table-responsive no-padding">
    <table class="table table-hover ">
        <thead >
        <tr>
            <th style="border-color: #1fad83" >Cod</th>
            <th style="border-color: #1fad83">Descripcion</th>
            <th style="text-align: right;border-color: #1fad83;">unidad</th>
            <th style="text-align: right;border-color: #1fad83;">Precio unitario</th>
            <th style="text-align: right;border-color: #1fad83;">Total S/Descuento</th>
            <th style="text-align: right;border-color: #1fad83;">Descuento (%)</th>
            <th style="text-align: right;border-color: #1fad83;">Total con descuento</th>
            <th></th>
        </tr>
        </thead>
        <tbody >
        <?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th>Art-<?php echo e($carr->id); ?> </th>
                <th><?php echo e($carr->art_nombreGenerico); ?> - ( <?php echo e($carr->art_nombreComercial); ?> )</th>
                <th style="text-align: right;"><?php echo e($carr->cantidad); ?> u. </th>
                <th style="text-align: right;"><?php echo e($carr->art_costoVenta); ?> Bs.- </th>
                <th style="text-align: right;"><?php echo e($carr->costoSD); ?> Bs.</th>
                <th style="text-align: right;"><?php echo e($carr->descuento); ?>%</th>
                <th style="text-align: right;"><?php echo e($carr->costo); ?> Bs.</th>
                <th style="text-align: right;">
                  <span class="tooltip-area">
                      <a  class="btn btn-default btn-sm btn-xs" title="Eliminar" onclick="CarrElimiArt(<?php echo e($carr->id); ?>);"><i class="fa fa-trash-o"></i></a>
                  </span>
                        </th>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

