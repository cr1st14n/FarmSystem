<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>FarmSystem | {{ Auth::user()->usu_cargo }}</title>
  <!-- icono del sistema -->
  <link rel="icon" type="image/png" href="{{ asset('login/images/icons/favicon.ico') }}" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/jvectormap/jquery-jvectormap.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('plantilla/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('plantilla/dist/css/skins/_all-skins.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/select2/dist/css/select2.min.css') }}">



  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('plantilla/plugins/iCheck/all.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plantilla/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{ asset('plantilla/plugins/timepicker/bootstrap-timepicker.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- AlerttiFY -->
  <link rel="stylesheet" type="text/css" href="{{ asset('alertifyjs/alertifyjs/css/alertify.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('alertifyjs/alertifyjs/css/themes/default.css') }}">
  <script src="{{ asset('alertifyjs/alertifyjs/alertify.js') }}"></script>
  @yield('head')

</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">

      <!-- Logo -->
      <a class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>F</b>S</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Farm</b>SYSTEM</span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs">NIT: 6845502013 // <span id="diaSemana">Martes</span> <span id="dia">1</span> de <span id="mes">agosto</span> del <span id="year">2015</span> // <span id="horas">12</span>:<span id="minutos">00</span>:<span id="segundos">00</span> <span id="ampm">AM</span> </span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{ asset('plantilla/dist/img/img-02.png') }} " class="img-circle" alt="User Image">

                  <p>
                    {{ Auth::user()->usu_nombre }} - {{ Auth::user()->usu_cargo }}
                    <small>CI: {{ Auth::user()->usu_ci }}</small>
                  </p>
                </li>
                <!-- Menu Body -->

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{route('perfil-usuario')}}" class="btn btn-default btn-flat">Perfil</a>
                    <a href="#" class="btn btn-default btn-flat">Ventas</a>
                  </div>

                  <div class="pull-right">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Cerrar Cesion</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </div>
                </li>
              </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('plantilla/dist/img/img-02.png') }} " class="user-image" alt="User Image">
                <span class="hidden-xs">Usuario: {{ Auth::user()->usu_nombre }} {{ Auth::user()->usu_appaterno }} </span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{ asset('plantilla/dist/img/img-02.png') }} " class="img-circle" alt="User Image">

                  <p>
                    {{ Auth::user()->usu_nombre }} - {{ Auth::user()->usu_cargo }}
                    <small>CI: {{ Auth::user()->usu_ci }}</small>
                  </p>
                </li>
                <!-- Menu Body -->

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{route('perfil-usuario')}}" class="btn btn-default btn-flat">Perfil</a>
                    <a href="#" class="btn btn-default btn-flat">Ventas</a>
                  </div>

                  <div class="pull-right">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Cerrar Cesion</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->

          </ul>
        </div>

      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ asset('plantilla/dist/img/img-02.png') }} " class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->usu_cargo }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> </a>
          </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li><a href="{{route('home-administracion')}} "><i class="fa fa-home "></i> <span>INICIO</span></a></li>

          <!-- solo acceso a super usuarios -->
          @if((Auth::user()->usu_cargo) == "Administrador" )
          <li class="header">GESTION DE USUARIOS</li>
          <li><a href="{{ route('usuarios-index') }} "><i class="fa fa-user "></i> <span>usuarios</span></a></li>
          <li class="header">GESTION DE INVENTARIO</li>
          <li><a href="{{ route('AI_home')}} " id="btnArticulos"><i class="fa fa-clipboard "></i> <span>Articulos y Almacen</span></a></li>
          {{--<li><a href="{{ route('AlmInven-index')}} " id="btnArticulos"><i class="fa fa-clipboard "></i> <span>Articulos</span></a></li>--}}
          <li><a href="{{ route('proveedor-index')}} "><i class="fa fa-users "></i> <span>Provedores</span></a></li>
          @endif
          <li class="header">GESTION DE VENTAS</li>
          <li><a href="{{ route('formularioVentaV2')}} "><i class="fa fa-shopping-cart "></i> <span>Realizar Venta</span></a></li>
          <li><a href="{{ route('registro-ventas')}} "><i class="fa fa-th-list "></i> <span>Registro de Ventas</span></a></li>
          <li><a href="{{ route('clientes-home')}} ">
              <i class="fa fa-user-plus "></i>
              <span>Clientes</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right">...</span>
              </span>
            </a>
          </li>

          @if((Auth::user()->usu_cargo) == "Administrador" )
          <li class=" treeview ">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>Reportes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{route('home-reportes')}} "><i class="fa fa-circle-o"></i> Reporte de inventario</a></li>
              <li><a href="{{route('ReportVentas-reportes')}} "><i class="fa fa-circle-o"></i> Reporte de ventas</a></li>
              <li><a href=""><i class="fa fa-circle-o"></i> Reporte de clientes</a></li>
            </ul>
          </li>
          @endif

          {{--<li><a href="{{route('formularioVentaV2')}}"><i class="fa fa-circle-o text-aqua"></i> <span>Crear Venta</span></a></li>--}}
          <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Almacen</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @if(Session()->has('flash_success'))
      <div class="callout callout-success" style="position: absolute;  right: 0% ; z-index: 100">
        <h5><i class="icon fa fa-check"></i> Exelente</h5>
        <p>{{ Session('flash_success')}}</p>
      </div>
      @endif
      @if(Session()->has('flash_info'))
      <div class="callout callout-info" style="position: absolute;  right: 0% ; z-index: 100">
        <h5><i class="icon fa fa-ban"></i> Nota</h5>
        <p>{{ Session('flash_info')}}</p>
      </div>
      @endif
      @if(Session()->has('flash_warning'))
      <div class="callout callout-warning" style="position: absolute;  right: 0% ; z-index: 100">
        <h5><i class="icon fa fa-ban"></i> Alerta</h5>
        <p>{{ Session('flash_warning')}}</p>
      </div>
      @endif
      @if(Session()->has('flash_danger'))
      <div class="callout callout-danger" style="position: absolute;  right: 0% ; z-index: 100">
        <h5><i class="icon fa fa-ban"></i> Error</h5>
        <p>{{ Session('flash_danger')}}</p>
      </div>
      @endif
      <!-- Content Header (Page header) -->
      <section class="content-header">
        @yield('dirNavegacion')
      </section>
      <!-- Main content -->
      <section class="content">
        {{--<div class="row">
        <div class="col-xs-12">--}}
        @yield('content')
        {{--</div>
        <!-- /.col -->
      </div>--}}
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.5.0
      </div>
      <strong hidden="">Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> Sistema en desarrollo.
    </footer>
    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery 3 -->
  <script src="{{ asset('plantilla/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('plantilla/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('plantilla/bower_components/fastclick/lib/fastclick.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('plantilla/dist/js/adminlte.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('plantilla/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
  <!-- jvectormap  -->
  <script src="{{ asset('plantilla/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
  <script src="{{ asset('plantilla/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
  <!-- SlimScroll -->
  <script src="{{ asset('plantilla/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('plantilla/bower_components/chart.js/Chart.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('plantilla/dist/js/pages/dashboard2.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('plantilla/dist/js/demo.js') }}"></script>

  <!-- Select2 -->
  <script src="{{ asset('plantilla/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <!-- InputMask -->
  <script src="{{ asset('plantilla/plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('plantilla/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
  <script src="{{ asset('plantilla/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
  <!-- date-range-picker -->
  <script src="{{ asset('plantilla/bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <!-- bootstrap datepicker -->
  <script src="{{ asset('plantilla/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- bootstrap color picker -->
  <script src="{{ asset('plantilla/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
  <!-- bootstrap time picker -->
  <script src="{{ asset('plantilla/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

  <!-- iCheck 1.0.1 -->
  <script src="{{ asset('plantilla/plugins/iCheck/icheck.min.js') }}"></script>
  <script type="text/javascript">
    //$('div.alert').delay(1700).slideDown(-800);
    $('div.callout').delay(1700).slideUp(300);
    //$("div.alert").slideToggle("slow");
  </script>
  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        format: 'MM/DD/YYYY h:mm A'
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Hoy': [moment(), moment()],
            'Aller': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
            'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
            'Este Mez': [moment().startOf('month'), moment().endOf('month')],
            'Mez Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      })

      //iCheck for checkbox and radio inputs
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
      })
      //Red color scheme for iCheck
      $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
      })
      //Flat red color scheme for iCheck
      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
      })

      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()

      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      })
    })
  </script>
  <script src="{{ asset('asincrono/home.js') }}"></script>

  @yield('scrípt')
</body>

</html>