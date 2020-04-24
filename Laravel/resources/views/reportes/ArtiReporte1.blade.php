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
          <small class="pull-right">Fecha: {{$fecha}} </small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
     
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Datos
        <address>
          <strong>Nombre:  {{ Auth::user()->usu_nombre }} {{ Auth::user()->usu_appaterno }}</strong><br>
          Cod Usuariuo:  {{ Auth::user()->usu_ci }} <br>
          Fecha: {{$fecha}} <br>
          Tipode reporte: General de Articulos.<br>
        </address>
      </div>
      
      <!-- /.col -->
      <div class="col-sm-8 invoice-col">
        <b>Articulos registrados {{$articulo1}} </b><br>
       Con existencia en alamcen: {{$articulo2}} <br>
       Sin existencia en alamcen: {{$articulo3}} <br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="display table-striped" style="width:100%">
          <thead>
          <tr>
            <th>Cod</th>
            <th>N. Generico</th>
            <th>N. Comercial</th>
            <th>Composicion</th>
            <th>Laboratorio</th>
            <th>Provedor</th>
            <th>C.P.</th>
            <th>C.V.</th>
            <th>St.</th>
          </tr>
          </thead>
          <tbody id="listaArticulosStock">
       
          </tbody>
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
    $.get('/FarmSystem/api/listArticulosAjax/',function(articulo){
        $('#listaArticulosStock').html("");
        for (var i = articulo.length - 1; i >= 0; i--) {
            console.log(articulo[i]);
            var tr = `<tr>
                      <td>Art-`+articulo[i].id+`</td>
                      <td>`+articulo[i].art_nombreGenerico+`</td>
                      <td>`+articulo[i].art_nombreComercial+`</td>
                      <td>`+articulo[i].art_composicion+`</td>
                      <td>`+articulo[i].art_laboratorio+`</td>
                      <td>`+articulo[i].prov_nombre+`</td>
                      <td>`+articulo[i].art_costoProveedor+`</td>
                      <td>`+articulo[i].art_costoVenta+`</td>
                      <td>`+articulo[i].sto_cantidad+`</td>
                     
                    </tr>`;
            $("#listaArticulosStock").append(tr)   
        }
        window.print();
    });
</script>

</body>
</html>
