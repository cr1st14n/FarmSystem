@extends('layouts.admLay')
@section('head')
    <link rel="stylesheet"  href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection
@section('dirNavegacion')
    <h1>
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Administracion</a></li>
        <li class="active">Registro de Articulos</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Registro de articulos</h3>
                </div>
                {{-- <div class="" >
                    {!! QrCode::size(1000)->generate($data); !!}
                    <p>Scan me to return to the original page.</p>
                </div> --}}
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row margin">
                        {{-- <div class="col-md-1">
                            <a class="btn btn-app" >
                                <i class="fa fa-edit"></i>Registrar
                            </a>
                        </div> --}}
                        <div class="col-md-4">
                            <div class="input-group margin">
                                {{-- <button class="btn btn-block btn-xs" >Listar todos los articulos</button> --}}
                                <input type="text" class="form-control xs" placeholder="Buscar Nombre comercial" oninput="filtrarNomComercial(this.value)">
                                <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group margin">
                                        <span class="input-group-addon">
                                            <i class="">Provedores:</i>
                                        </span>
                                        <select class="form-control" name="" id="" onchange="filtArtProve(this.value)">
                                            <option value="todos">Seleccionar...</option>
                                            @foreach($provs as $pro)
                                                <option value="{{$pro->id}}">{{$pro->prov_nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                                <a class="btn btn-app" onclick="showModalNesArt()">
                                    <i class="fa fa-edit"></i>Crear
                                </a>
                                <a class="btn btn-app" onclick="listProductos()">
                                    <i class="fa fa-barcode" ></i> Catalogo
                                </a>
                                <a class="btn btn-app" onclick="listProStock()">
                                    <i class="fa fa-inbox"></i> Stock
                                </a>
                            </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <table id="tableArticulos"  class="table table-striped display compact"  align="center">
                                    <thead>
                                    <tr>
                                        <th>Cod Art</th>
                                        <th>N. Comercial</th>
                                        <th>N. Generico</th>
                                        <th>Provedor</th>
                                        <th>Costo proveedor</th>
                                        <th>Costo venta</th>
                                        <th align="center">Stock</th>
                                        <th width="9%"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="listarticulos" >
                                    </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 row">
                            <div class="col-md-3">
                                <div class="input-group margin">
                                    <input type="text" class="form-control" placeholder="Buscar accion terapeutica" oninput="filtrarAcTe(this.value)">
                                    <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                                </span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group margin ">
                                            <input type="text" class="form-control" placeholder="Nombre generico" oninput="filtrarNomGenerico(this.value)">
                                            <span class="input-group-addon">
                                                <i class="fa fa-search"></i>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group margin ">
                                            <input type="text" class="form-control" placeholder="Buscar linea/marca" oninput="filtrarLiMa(this.value)">
                                            <span class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                    </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3">
                                <div class="input-group margin">
                                    <span class="input-group-addon">
                                        <i class="">Ordenar:</i>
                                    </span>
                                    <select class="form-control" name="" id="" onchange="orderCod()">
                                        <option value="todos">Seleccionar...</option>
                                        <option value="codigo">Codigo</option>
                                        <option value="descripcion">Descrpcion</option>
                                        <option value="provedores">Provedores</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- /.Modal prceso de producto -->
    <div class="modal fade" id="agregarStock" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Gestionar Descripcion y Stock del Articulo</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Descripcion:</h3>
                                </div>
                                <form class="form-horizontal" id="form-updateArt">{{ csrf_field()}}
                                    <input type="text" name="id_art" id="id_art" hidden="">
                                    <div class="box-body" id="datosArticulo1">
                                        <div class="form-group ">
                                            <div class="col-sm-6">
                                                <label for="" class=" control-label"><i class="fa  fa-plus-square"></i>N. Generico</label>
                                                <input type="text" class="form-control" id="ngenerico" name="ngenerico" placeholder="" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class=" control-label"><i class="fa  fa-plus-square"></i>N. Comercial</label>
                                                <input type="text" class="form-control" id="ncomercial" name="ncomercial" placeholder="">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class=" control-label"><i class="fa fa-bell-o"></i>Laboratorio</label>
                                                <input type="text" class="form-control" id="laboratorio" name="laboratorio" placeholder="">
                                            </div>
                                            <div class="col-sm-6"><div id="proveedor"></div>
                                                <label for="" class=" control-label"><i class="fa fa-truck"></i>Provedor</label>
                                                <select id="selectProvedor" name="proveedor" class="form-control">
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class=" control-label"><i class="fa fa-money"></i>Costo Provedor</label>
                                                <input type="number" step="0.01" min="0" class="form-control" id="cprovedor" name="cprovedor" placeholder="">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class=" control-label"><i class="fa fa-money"></i>Costo Venta</label>
                                                <input type="number" step="0.01" min="0" class="form-control" id="cventa" name="cventa" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-block btn-info btn-xs">Editar datos del articulo</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5" >
                            <h5>Resgistrar ingreso a Stock </h5>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="info-box" id="acantidad">
                                    <!-- aca se inllecta el stock de js-->
                                </div>
                            </div>
                            <form >
                                <h5>Ingresar nueva fecha de vencimiento de stock entrante</h5>
                                <div class="input-group">
                                    <input type="text" id="idArt" name="id" hidden>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="date" name="vencimiento" id="artVencimiento" class="form-control" >
                                </div>
                                <br>
                                <div class="input-group input-group-sm">
                                    <input class="form-control" type="number" name="cantidad" id="cantEntrante" required="" min="1" oninput="validar(this.id)">
                                    <span class="input-group-btn">
                                      <button class="btn btn-success btn-flat" type="button" onclick="addCantidad()">Ingresar Articulos</button>
                                    </span>
                                </div>
                            </form>
                            <hr>
                            <form>
                                <h5>Sustraer aticulos del stock</h5>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="idArt2" name="id" hidden>
                                    <input class="form-control" type="number" name="cantidad" id="cantSaliente" required="" min="0" oninput="validar(this.id)">
                                    <span class="input-group-btn">
                                      <button class="btn btn-danger btn-flat" type="button" onclick="subtractCantidad()">Sustraer Articulos</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- MODAL REGISTRAR ARTICULO-->
    <div class="modal fade" id="modal-regisArt">
        <form >
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Registrar nuevo articulo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box box-warning">
                            <!-- text input -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group " >
                                        <label for="nombre generico">Nombre generico</label>
                                        <input type="text"  name="nombre generico" id="art_Generico" class="form-control" placeholder="Nombre generico ..." required="" autocomplete="off" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre comercial">Nombre comercial</label>
                                        <input type="text" name="nombre comercial" id="art_Comercial" class="form-control" placeholder="Nombre comercial ..." required="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="composicion">Composicion</label>
                                        <input type="text" name="composicion" id="art_composicion" class="form-control" placeholder="Composicion ..." autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="laboratorio">Laboratorio</label>
                                        <input type="text" name="laboratorio" id="art_laboratorio" class="form-control" placeholder="Laboratorio ..." required="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Accion terapeutica</label>
                                    <input type="text" placeholder="Accion terapeutica" id="art_accionTerapeutica" class="form-control">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <select class="form-control select2" name="proveedor" id="art_proveedor" style="width: 100%;" required="">
                                    <option value="" disabled selected>Seleccionar proveedor...</option>
                                    @foreach($provs as $prov)
                                        <option value="{{$prov->id}} " >{{$prov->prov_nombre}} / {{$prov->prov_direccion}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">Bs.</span>
                                        <input type="number" step="0.01" name="costo proveedor" id="art_costoProveedor" class="form-control" placeholder="Costo proveedor ...">
                                    </div><br>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">Bs.</span>
                                        <input type="number" step="0.01" name="costo venta" id="art_costoVenta" class="form-control" placeholder="Costo para la venta ..." required="">
                                    </div><br>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">unidades</span>
                                        <input type="text" name="stock" class="form-control" id="unidades" placeholder="Cantidad inicial (opcional) ...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha de vencimiento (opcional)</label>
                                        <div class="input-group">
                                            <input type="date" name="fv" class="form-control" id="fechVen" placeholder="Fecha vencimiento (opcional) ...">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="createArt()">Registrar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>
    <!-- /.modal -->
@endsection
@section('scrípt')
    {{--<script src="{{ asset('asincrono/articulos.js') }}"></script>--}}
    <script src="{{ asset('asincrono/artinv.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>--}}
    <script>
        $(function () {
           /*  $('').DataTable() */
            $('#tableArticulos').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : true,
                "scrollY":        "30vh",
                "scrollCollapse": true,
                "paging":         false,
                "processing": false,
                "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "zeroRecords": "---------//--------",
                    "info": "Showing page _PAGE_ of _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
           } );
        });
    </script>
@endsection


