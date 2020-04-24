<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reporte| Inventario</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('plantilla/dist/css/AdminLTE.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> Farmacia "SANTI"
          <small class="pull-right">FarmSystem <br> {{$fechaActual}} </small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
     
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <strong>Datos:</strong> 
        <address>
          Nombre:  {{ Auth::user()->usu_nombre }} {{ Auth::user()->usu_appaterno}} <br>
          Cod Usuariuo:  {{ Auth::user()->usu_ci }} <br>
          Fecha de Filtro: {{$fecha0}} <br>
          @if($tabla =="ventas")
            Tipo de reporte: Facturas en General.<br>
          @else($tabla =="aticulo")
            Tipo de reporte: Venta de articulos.<br>
          @endif
        </address>
      </div>
      
      <!-- /.col -->
      <div class="col-sm-8 invoice-col">
        <b>Resumen </b><br>
       Total facturas: {{$cantidad}} <br>
       Total Ingreso: {{$CostoTotal}} Bs.-<br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="display table-striped" style="width:100%">
          @if($tabla == "venta")    
              <thead>
              <tr>
                <th># Factura</th>
                <th>Cliente</th>
                <th>NIT</th>
                <th>Tipo articulos</th>
                <th>Total articulos</th>
                <th>Efectivo</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Pago</th>
              </tr>
              </thead>
              <tbody>
                 @foreach($ventas as $venta)
                  <tr>
                      <td>{{$venta->fact_numFactura }} </td>
                      <td>{{$venta->vent_clienteNombre }} </td>
                      <td>{{$venta->vent_clienteNit }} </td>
                      <td>{{$venta->vent_canTipoArticulos }} </td>
                      <td>{{$venta->vent_canArticulosTotal }} </td>
                      <td>{{$venta->vent_efectivoTotal }} </td>
                      <td>
                      {{date('d-m-Y H:i', strtotime($venta->ca_fecha))}}
                      </td>
                      <td>{{$venta->ca_cod_usu }} </td>
                      <td>Cancelado </td>
                  </tr>
                @endforeach
              </tbody>
          @else($tabla == "articulo")
              <thead>
              <tr>
                <th># Factura</th>
                <th>Cliente</th>
                <th>NIT</th>
                <th>Articulo</th>
                <th>Cantidad</th>
                <th>Efectivo</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Pago</th>
              </tr>
              </thead>
              <tbody>
                @foreach($ventas as $venta)
                  <tr>
                      <td>{{$venta->fact_numFactura }} </td>
                      <td>{{$venta->vent_clienteNombre }} </td>
                      <td>{{$venta->vent_clienteNit }} </td>
                      <td>{{$venta->art_nombreGenerico }} / {{$venta->art_nombreComercial }} </td>
                      <td>{{$venta->dv_cantidad }} </td>
                      <td>{{$venta->dv_efectivo }} </td>
                      <td>
                      {{date('d-m-Y H:i', strtotime($venta->created_at))}}
                      </td>
                      <td>{{$venta->usu_ci }} </td>
                      <td>Cancelado </td>
                  </tr>
                @endforeach
              </tbody>
          @endif
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<script src="{{ asset('plantilla/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript">
  window.print();
  window.close();

</script>
</body>
</html>
