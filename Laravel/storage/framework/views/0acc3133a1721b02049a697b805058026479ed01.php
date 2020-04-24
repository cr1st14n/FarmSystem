<?php $__env->startSection('content'); ?>

 

    
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo e($provedores); ?> </h3>

              <p>Provedores </p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo e($articulos); ?> <sup style="font-size: 20px"></sup></h3>

              <p>Articulos </p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo e($usuarios); ?></h3>

              <p>Usuarios </p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo e($clientes); ?> </h3>

              <p>Clientes</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Lista de articulos por vencer</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
              <ul class="todo-list">
                <?php $__currentLoopData = $list1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <small class="label label-danger "><i class="fa fa-clock-o"></i></small>
                  <span class="text"><?php echo e($l1->art_nombreGenerico); ?> -<?php echo e($l1->art_nombreComercial); ?>- <?php echo e($l1->art_laboratorio); ?> - <?php echo e($l1->fv_fechavencimiento); ?></span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>	
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $list2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <small class="label label-warning"><i class="fa fa-clock-o"></i></small>
                  <span class="text"><?php echo e($l2->art_nombreGenerico); ?> -<?php echo e($l2->art_nombreComercial); ?>- <?php echo e($l2->art_laboratorio); ?> - <?php echo e($l2->fv_fechavencimiento); ?> </span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>	
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $list3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                   
                  <small class="label label-info"><i class="fa fa-clock-o"></i></small>
                  <span class="text"><?php echo e($l3->art_nombreGenerico); ?> -<?php echo e($l3->art_nombreComercial); ?>- <?php echo e($l3->art_laboratorio); ?> - <?php echo e($l3->fv_fechavencimiento); ?> </span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>	
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $list4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                   
                  <small class="label label-success"><i class="fa fa-clock-o"></i></small>
                  <span class="text"><?php echo e($l4->art_nombreGenerico); ?> -<?php echo e($l4->art_nombreComercial); ?>- <?php echo e($l4->art_laboratorio); ?> <?php echo e($l4->fv_fechavencimiento); ?> </span>
                  <div class="tools">
                    <i class="fa fa-edit"><a href="www.facebook.com"></a></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>	
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $list5; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l5): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                   
                  <small class="label label-default"><i class="fa fa-clock-o"></i></small>
                  <span class="text"><?php echo e($l5->art_nombreGenerico); ?> -<?php echo e($l5->art_nombreComercial); ?>- <?php echo e($l5->art_laboratorio); ?> - <?php echo e($l5->fv_fechavencimiento); ?> </span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>	
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </section>
        <section class="col-lg-5 connectedSortable">
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Descripcion del codigo de colores</h3>
            </div>
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
              <ul class="todo-list">
                <li>
                  <!-- todo text -->
                  <small class="label label-danger"><i class="fa fa-clock-o"></i></small>
                  <span class="text">Vencera dentro los proximos 5 dias</span>
                  <!-- Emphasis label -->
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                   
                  <small class="label label-warning"><i class="fa fa-clock-o"></i></small>
                  <span class="text">Vencera dentro los proximos 10 dias </span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      
                  <small class="label label-info"><i class="fa fa-clock-o"></i></small>
                  <span class="text">Vencera dentro los proximos 15 dias</span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      
                  <small class="label label-success"><i class="fa fa-clock-o"></i></small>
                  <span class="text">Vencera dentro los proximos 20 dias</span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      
                  <small class="label label-primary"><i class="fa fa-clock-o"></i></small>
                  <span class="text">Vencera dentro los proximos 30 dias</span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      
                  <small class="label label-default"><i class="fa fa-clock-o"></i></small>
                  <span class="text">Vencera dentro los proximos 60 dias</span>
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <!-- /.box -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">


        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admLay', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>