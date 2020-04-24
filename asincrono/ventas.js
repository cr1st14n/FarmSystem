

$(document).ready(function() {
     var table = $('#regisVentas').DataTable({
        "language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
        //"searching":   false;
        "processing": false,
        "serverSide": false,
        "scrollY":        "50vh",
        "scrollCollapse": true,
        "paging":         false,
         "ajax": {
            "url": "/FarmSystem/api/listRegistroVentas/",
            "type": "POST"
        },
        "columns":[
            {data:"fact_numFactura"},
            {data:'vent_canTipoArticulos'},
            {data:'vent_efectivoTotal'},
            {data:'fac_pago'},
            {data:'vent_clienteNombre'},
            {data:'ca_cod_usu'},
            {data:'created_at'},
            {defaultContent:"<button type='button' data-toggle='modal' data-target='#modal-regisUser' class='mostrar btn btn-default btn-sm'><i class='fa fa-eye'></i></button> <button type='button' class='eliminar btn btn-default btn-sm' data-toggle='modal' data-target='#modalEliminar' ><i class='fa fa-trash-o'></i></button>"},
        ]

     });
    mostrar_data("#regisVentas tbody",table);
});



var mostrar_data = function(tbody,table){
    $(tbody).on("click","button.mostrar",function(){
        var data=table.row($(this).parents("tr")).data();
        console.log(data.id);
        $.get('/FarmSystem/api/detallVenta/'+data.id+'',function(venta){
        var  html_list = '<label >Detalle venta</label><br>'
        $("#table").html("");
        for (var i = venta.length - 1; i >= 0; i--) {
            var tr = `<tr>
                      <td>`+venta[i].art_nombreGenerico+' / '+venta[i].art_nombreComercial+`</td>
                      <td>`+venta[i].dv_cantidad+`</td>
                      <td>`+venta[i].dv_efectivo+`Bs.-</td>
                    </tr>`;
                    $("#table").append(tr)  
        
        }       
    }); 
    document.getElementById('Codventa').innerHTML='FACTURA : #'+data.fact_numFactura+' , Detalle de venta';
    document.getElementById('CostoDeVenta').innerHTML='Efectivo Total: '+ data.vent_efectivoTotal ;
    document.getElementById('ventaUsuario').innerHTML='Cod de usuario encargado :'+data.ca_cod_usu;
    document.getElementById('ventaFecha').innerHTML='Realizado en fecha : '+data.ca_fecha;
    } );
}


