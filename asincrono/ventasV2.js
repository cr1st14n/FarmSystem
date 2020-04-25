$(function () {
    $('#cantidadArt').on('keyup',calcularPrecioArt);
    $('#nitCliente').on('keyup',buscarCliente);
    $('#btnAgregarArt').on('click',agregarArt);
    $('#articuloSelec').on('change',datosArt);
    $('#btnAgregarCliente').on('click',modalNewCliente);
    $('#btnRegisClie').on('click',registrarCliente);
    $('#btnEliminarVenta').on('click',eliminarVenta);
    $('#btnRealizarVenta').on('click',realizarVenta);
});
listCarrito();
alertify.set('notifier','position', 'top-right');
function validar(id) {
    var elemento = document.getElementById(id);
    if (elemento.checkValidity()){
        elemento.style.borderColor="green";
        elemento.style.backgroundColor="";

    }else{
        elemento.style.borderColor="red";
        elemento.style.backgroundColor="#ffd3d3";
    }
}
function modalNewCliente() {
    var nit = document.getElementById('nitCliente').value;
    document.getElementById('nitNewCliente').value=nit;
    document.getElementById('nombreNewCliente').value="";
    document.getElementById('nombreNewCliente').style.borderColor="";
    document.getElementById('nombreNewCliente').style.backgroundColor="";
    $('#modalCreateCliente').modal('show'); // abrir
    //$('#myModalExito').modal('hide'); // cerrar
}
function registrarCliente() {
    var nit1 = document.getElementById('nitNewCliente').value;
    var nombreCliente1 = document.getElementById('nombreNewCliente').value;
    var nit = document.getElementById('nitNewCliente').checkValidity();
    var nomCliente = document.getElementById('nombreNewCliente').checkValidity();
    if (nit && nomCliente){
        $.get('/FarmSystem/Adm/clientes/verificarExistenciaCliente/'+nit1+'',function (res) {
            if (res == 0){
                console.log("se creara");
                var url = '/FarmSystem/Adm/clientes/create';
                var data= { '_token': $('meta[name=csrf-token]').attr('content'),
                    'dni': nit1,
                    'Nombre': nombreCliente1};
                $.post(url,data).done(function (resp) {
                    console.log(resp);
                    $('#modalCreateCliente').modal('hide');
                    alertify.success("Cliente registrado Exitosamente");
                    buscarCliente();
                }).fail(function(){
                    console.log("error en el servidor");
                }
            );


            }else{
                console.log("no se creara");
                alertify.error("Nit ya registrado");
            }
            console.log(res);

        });

    }else{
        alertify.error("Completar Datos del cliente !");
    }
}
function calcularPrecioArt() {
    var artElegido = document.getElementById('articuloSelec').value;
    if (artElegido == 'null' ){
        document.getElementById('cantidadArt').style.borderColor="green";
        document.getElementById('cantidadArt').style.backgroundColor="";
    }
    else{
        var precio = document.getElementById('precioART').innerHTML;
        var cantidad = document.getElementById('cantidadArt').value;
        if (cantidad != ""){
            var total = precio*cantidad;
            document.getElementById('TotalPrecioArt').innerHTML= total;
        }else{
            document.getElementById('cantidadArt').style.borderColor= "";
            document.getElementById('cantidadArt').style.backgroundColor= "";
            document.getElementById('TotalPrecioArt').innerHTML= "...";

        }


    }
}
function agregarArt() {
    alertify.set('notifier','position', 'top-right');
    var cantidad = document.getElementById('cantidadArt').checkValidity();
    var art = document.getElementById('articuloSelec').checkValidity();
    var desc = document.getElementById('descuentoArt').checkValidity();

    var cantidadArt = document.getElementById('cantidadArt').value;
    var artSelect = document.getElementById('articuloSelec').value;
    var artDescuento = document.getElementById('descuentoArt').value;
    if (cantidad && art && desc){
        var url = '/FarmSystem/Adm/venta/agregarV2';
        var data= { '_token': $('meta[name=csrf-token]').attr('content'),
            'producto': artSelect,
            'descuento': artDescuento,
            'cantidad': cantidadArt};
        $.post(url,data).done(function (resp) {
            console.log(resp);
            if (resp == "ya agregado"){
                alertify.warning("Articulo ya agregado");
            }else{
                alertify.success("Articulo agregado");
                listCarrito();
                document.getElementById("articuloSelec").click();
                console.log(resp);
            }
        }).fail(function () {
           alertify.error("Error de servidor...");
        });
    }else{
        alertify.warning("Error, verificar articulo o cantidad");
        document.getElementById('cantidadArt').style.borderColor="red";
        document.getElementById('cantidadArt').style.backgroundColor="#ffd3d3";
    }
}
function buscarCliente() {
    var nit = document.getElementById('nitCliente').value;
    if (nit != "" ){
        console.log("se buscara");
        $.get('/FarmSystem/Adm/clientes/buscarCliente/'+nit+'',function (clie) {
            console.log(clie);
            if (clie.vent_clienteNombre != null){
                document.getElementById('nombreClienteVenta').value=clie.vent_clienteNombre;
                document.getElementById('nombreClienteVenta').style.backgroundColor="";

            }else{
                document.getElementById('nombreClienteVenta').value="No registrado";
                document.getElementById('nombreClienteVenta').style.backgroundColor="#ffd3d3";
            }
        });
    }else{
        console.log("no se buscara");
        document.getElementById('nombreClienteVenta').value="";
        document.getElementById('nombreClienteVenta').style.backgroundColor="";
    }
}
function datosArt() {
    var id = document.getElementById('articuloSelec').value;
    $.get('/FarmSystem/Adm/venta/datoArtVenta/'+id+'',function (datos) {
        console.log(datos);
        document.getElementById('stockART').innerHTML=datos.sto_cantidad;
        document.getElementById('precioART').innerHTML=datos.art_costoVenta;
        document.getElementById('nomGenericoArt').innerHTML=datos.art_nombreGenerico;
        document.getElementById('provedorArt').innerHTML=datos.prov_nombre;
        document.getElementById('art_accionTerapeutica').innerHTML=datos.art_accionTerapeutica;
        document.getElementById('art_laboratorio').innerHTML=datos.art_laboratorio;
        // console.log(datos);
        document.getElementById('cantidadArt').setAttribute('max',datos.sto_cantidad);
        document.getElementById('cantidadArt').value="";
        document.getElementById('descuentoArt').value="";
        document.getElementById('cantidadArt').style.borderColor="green";
        document.getElementById('cantidadArt').style.backgroundColor="";
        document.getElementById('descuentoArt').style.borderColor="";
        document.getElementById('descuentoArt').style.backgroundColor="";
        document.getElementById('cantidadArt').focus();

    });
    document.getElementById('imagenArt').innerHTML=` <img src="/FarmSystem/plantilla/dist/img/pastilla.jpg" width="70" height="70">`;
}
function listCarrito() {
    $.get('/FarmSystem/Adm/venta/listaVentaV2',function (resp) {
        if (resp == "carrito_vacio"){
            document.getElementById('cantidadVenta').value= "";
            document.getElementById('CostoTotal').value="";
            document.getElementById('tableCarrito').innerHTML="";
        }else{
            // $("#tableCarrito").append("");
            document.getElementById('tableCarrito').innerHTML="";

            $("#tableCarrito").append(resp);
            var unidades = document.getElementById('CarritoUnidades').innerHTML;
            var costoTotal = document.getElementById('CarritoCosto').innerHTML;
            document.getElementById('cantidadVenta').innerText= unidades;
            document.getElementById('CostoTotal').innerText=costoTotal+"Bs.-";
        }
    });
}
function CarrElimiArt(id) {
    console.log(id);
    $.get('/FarmSystem/Adm/venta/eliminar/'+id+'',function (resp) {
        console.log(resp);
        listCarrito();
    })
}
function eliminarVenta() {
    $.get('/FarmSystem/Adm/venta/reiniciar',function () {
        alertify.warning("Venta Reiniciada");
        document.getElementById('cantidadVenta').innerText="";
        document.getElementById('CostoTotal').innerText="";
        document.getElementById('tableCarrito').innerHTML="";
        document.getElementById('cantidadArt').value="";
        document.getElementById('nitCliente').value="";
        document.getElementById('nombreClienteVenta').value="";
    });
}
function realizarVenta() {
    /*verificar si venta tiene art agregados*/
    $.get('/FarmSystem/Adm/venta/ventaVerificar').done(function (data) {
        if (data != "carritovacio"){
            /*funcion verificar cantidades de la venta*/
            ventaVerificarStock();
        }else {
            alertify.error("Venta sin articulos agregados");
        }
    }).fail(function () {
        alertify.error("Error server VCLL.");
    });
}
function ventaVerificarStock() {
    $.get('/FarmSystem/Adm/venta/ventaVerificarStock').done(function (data1) {
        if (data1 == "success"){
            // console.log(data1);
            // alertify.success("Se realizara la factura.");
            cerrarventa();
        }else {
            alertify.warning("Verificar Cantidades de articulos.");
            // console.log(data1);
            $('#modalArtSinStock').modal('show');
            document.getElementById('listArtSinStock').innerHTML=data1;
        }
        listCarrito();
    }).fail(function () {
        alertify.error("Error server VVS")
    });
}
function cerrarventa() {
    var cliente=document.getElementById('nitCliente').value;
    var pago = document.getElementById('ventaTipoPago').value;
    if (cliente == ""){
        alertify.warning("ingrese NIT clliente");
        document.getElementById('nitCliente').focus();
        $("#mdFacturar").modal('hide');
    }else{
        //Cerrar venta
        $.get('/FarmSystem/Adm/venta/registrarVenta/'+cliente+'/pago/'+pago+'').done(function (data) {
            if  (data == "exito"){
                // console.log(data);
                alertify.success("Venta realizada");
                $("#mdFacturar").modal('hide');
                imprimirElemento();

                /*$.get('/FarmSystem/Adm/venta/reiniciar',function (data) {
                    console.log(data);
                    listCarrito();
                    /!*document.getElementById('cantidadVenta').value="";
                    document.getElementById('CostoTotal').value="";
                    document.getElementById('tableCarrito').innerHTML="";
                    document.getElementById('cantidadArt').value="";*!/
                });*/
            }else{
                console.log(data);
                alertify.warning("venta realizada con observacion en los articulos agregados.");
                $('#modalArtSinStock').modal('show');
                document.getElementById('listArtSinStock').innerHTML=data;
                document.getElementById('titleModalArtSinStocl').innerHTML="Error de Stock en los siguientes articulos";
            }

        }).fail(function () {
            alertify.error("Error server CV")
        });
    }

}
function cerrarventaSF() {
    var cliente=document.getElementById('nitCliente').value;
    var pago = document.getElementById('ventaTipoPago').value;
    if (cliente == ""){
        alertify.warning("ingrese NIT clliente");
        document.getElementById('nitCliente').focus();
        $("#mdFacturar").modal('hide');
    }else{
        //Cerrar venta
        $.get('/FarmSystem/Adm/venta/registrarVenta/'+cliente+'/pago/'+pago+'').done(function (data) {
            if  (data == "exito"){
                // console.log(data);
                alertify.success("Venta realizada");
                $("#mdFacturar").modal('hide');
                eliminarVenta();
                // imprimirElemento();

                /*$.get('/FarmSystem/Adm/venta/reiniciar',function (data) {
                    console.log(data);
                    listCarrito();
                    /!*document.getElementById('cantidadVenta').value="";
                    document.getElementById('CostoTotal').value="";
                    document.getElementById('tableCarrito').innerHTML="";
                    document.getElementById('cantidadArt').value="";*!/
                });*/
            }else{
                console.log(data);
                alertify.warning("venta realizada con observacion en los articulos agregados.");
                $('#modalArtSinStock').modal('show');
                document.getElementById('listArtSinStock').innerHTML=data;
                document.getElementById('titleModalArtSinStocl').innerHTML="Error de Stock en los siguientes articulos";
            }

        }).fail(function () {
            alertify.error("Error server CV")
        });
    }

}
function imprimirElemento(/*elemento*/) {
    $.get('/FarmSystem/Adm/venta/printFactura').done(function (factura) {
        // console.log(factura);
        var ventana = window.open('', 'PRINT', 'height=400,width=600');
        // ventana.document.write('<html><head><title>' + document.title + '</title>');
        // ventana.document.write('<link rel="stylesheet" href="style.css">');
        // ventana.document.write('</head><body >');
        ventana.document.write(factura);
        // ventana.document.write('</body></html>');
        ventana.document.close();
        ventana.focus();
        ventana.onload = function () {
            ventana.print();
            ventana.close();
        }
        // return true;
    }).fail(function () {
        alertify.error("ErrorServer ImpFactura");
    });
    setTimeout("eliminarVenta()",2000);
}

function ShowModalFacturar() {
    $("#mdFacturar").modal("show");
}
// * funcion para calcular
function calcularCambio(efec) {
    var costo=$('#CostoTotal').html();
    var val1=parseFloat(costo);
    var val2=parseFloat(efec);
    $('#ventCambio').val(val2-val1);
  }

