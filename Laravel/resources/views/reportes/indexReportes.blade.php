@extends('layouts.admLay')

@section('head')
@endsection

@section('dirNavegacion')
<h1>  
  
  <small> </small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
  <li class="active">Generador de Reportes</li>
</ol>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#articulos" data-toggle="tab">General</a></li>
              <li><a href="#provedores"  data-toggle="tab">Provedores</a></li>
              <li><a href="#Movimiento" data-toggle="tab">Movimiento</a></li>
            </ul>
            <div class="tab-content">
                
              <div class="active tab-pane" id="articulos">
                <div class="box-footer clearfix">
                  <a href="{{route('impArtReport-reportes')}} " target="_blank" class="btn btn-sm btn-info btn-flat pull-left">Imprimir</a>
                  <h4 class="pull-right">Articulos registrados: {{$articulo1}} Con stock: {{$articulo2}} Sin Stock: {{$articulo3}} </h4>
                </div>
                  <div class="table-responsive">
                    <table class="table  no-margin" id="repArtGen">
                      <thead>
                      <tr>
                        <th>Cod</th>
                        <th>N. Generico</th>
                        <th>N. Comercial</th>
                        <th>Laboratorio</th>
                        <th>Provedor</th>
                        <th>Costo P.</th>
                        <th>Costo V.</th>
                        <th>Stock.</th>
                      </tr>
                      </thead>
                     
                    </table>
                  </div>
              </div>
              <div class=" tab-pane" id="provedores">
                  <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Imprimir</a>
                  </div>
                    
                  <div class="table-responsive">
                    <table  class="compact table " id="headProvedor">
                      <thead>
                      <tr>
                        <th>cod</th>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Empresa</th>
                        <th>Ariculos Requeridos</th>
                        <th>2</th>
                      </tr>
                      </thead>
                      <tbody id="listProvArticulo">
                    
                      </tbody>
                    </table>
                     
                  </div>
               
              </div>
               <div class=" tab-pane" id="stock">
                  <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Imprimir</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat ">View All Orders</a>
                  </div>
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Item</th>
                        <th>Status</th>
                        <th>Popularity</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                        <td>Call of Duty IV</td>
                        <td><span class="label label-success">Shipped</span></td>
                        <td>
                          <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                        <td>Samsung Smart TV</td>
                        <td><span class="label label-warning">Pending</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                        <td>iPhone 6 Plus</td>
                        <td><span class="label label-danger">Delivered</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                        <td>Samsung Smart TV</td>
                        <td><span class="label label-info">Processing</span></td>
                        <td>
                          <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                        <td>Samsung Smart TV</td>
                        <td><span class="label label-warning">Pending</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                        <td>iPhone 6 Plus</td>
                        <td><span class="label label-danger">Delivered</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                        <td>Call of Duty IV</td>
                        <td><span class="label label-success">Shipped</span></td>
                        <td>
                          <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
               <div class=" tab-pane" id="Movimiento">
                  <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Imprimir</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat ">View All Orders</a>
                  </div>
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Item</th>
                        <th>Status</th>
                        <th>Popularity</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                        <td>Call of Duty IV</td>
                        <td><span class="label label-success">Shipped</span></td>
                        <td>
                          <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                        <td>Samsung Smart TV</td>
                        <td><span class="label label-warning">Pending</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                        <td>iPhone 6 Plus</td>
                        <td><span class="label label-danger">Delivered</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                        <td>Samsung Smart TV</td>
                        <td><span class="label label-info">Processing</span></td>
                        <td>
                          <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                        <td>Samsung Smart TV</td>
                        <td><span class="label label-warning">Pending</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                        <td>iPhone 6 Plus</td>
                        <td><span class="label label-danger">Delivered</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                        <td>Call of Duty IV</td>
                        <td><span class="label label-success">Shipped</span></td>
                        <td>
                          <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->

</section>
<!-- /.content -->
@endsection

@section('scrípt')
<script src="{{ asset('asincrono/articulos.js') }}"></script>
<script src="{{ asset('asincrono/reportes.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection


