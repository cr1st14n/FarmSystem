$(function(){
    //activacion para select articulo
    $('#ventaGeneralTipo').on('change',ventaGeneralTipoDivs);
    $('#selectFechaVenta').on('change',onVerfechasVenta);
    $('#VGBuscar').on('keload',onVentaGeneralBuscar);
});



$(document).ready(function() {
  var table = $('#repArtGen').DataTable( {
        "language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
        "searching":false,
        "processing": true,
        "serverSide": false,
        "scrollY":        "50vh",
        "scrollCollapse": true,
        "paging":         false,
        //"ajax": "/api/listRegistroVentas/",
         "ajax": {
            "url": "/FarmSystem/api/listArticulos/",
            "type": "POST"
        },
        "columns":[
        	{data:"id"},
        	{data:'art_nombreGenerico'},
        	{data:'art_nombreComercial'},
        	{data:'art_laboratorio'},
        	{data:'art_proveedor'},
            {data:'art_costoProveedor'},
            {data:'art_costoVenta'},
        	{data:'sto_cantidad'},
        ]
    });
});

$(document).ready(function() {
    $.get('/FarmSystem/api/listProvAticulo/',function(prov){
    $('#listProvArticulo').html("");
    for (var i = prov.length - 1; i >= 0; i--) {
      var tr = `<tr>
                <td>Art-`+prov[i].id+`</td>
                <td>`+prov[i].prov_nombre+`</td>
                <td>`+prov[i].prov_direccion+`</td>
                <td>`+prov[i].prov_telf+` Bs.-</td>
                <td>`+prov[i].prov_empresa+` Bs.-</td>
                <td>`+prov[i].art_nombreGenerico+`</td>
                <td>`+prov[i].art_nombreComercial+`</td>
                
                </tr>`;
      $("#listProvArticulo").append(tr) 
      console.log(prov[i]);
    }
  });
   
});

function ventaGeneralTipoDivs(){
    var cod = $(this).val();
    var div1 = document.getElementById('DVG1');
    var div2 = document.getElementById('DVG2');
        if (cod == 1) {
            div1.style.display='block';
            div2.style.display='none';
        }
        if(cod == 2){
            div1.style.display='none';
            div2.style.display='block';
        }
}
function onVerfechasVenta(){
    var sel = $(this).val();
    var fecha0=document.getElementById('fechaSimpleVenta');
    var fecha1=document.getElementById('fechaRangoVenta');
        if (sel == 1) {
            fecha0.style.display='block';
            fecha1.style.display='none';
                $("#inpfecha0").setAttribute("required");

        }
        if (sel == 2) {
            fecha0.style.display='none';
            fecha1.style.display='block';
                $("#inpfecha1").setAttribute("required");
                $("#inpfecha2").setAttribute("required");

        }
}

function onVentaGeneralBuscar(){
    var VGtipoBusqueda = document.getElementById('ventaGeneralTipo').value;
    var fecha1 = document.getElementById('VGfecha1').value;
    var fecha2 = document.getElementById('VGfecha2').value;
    var fecha3 = document.getElementById('VGfecha3').value;

        if (VGtipoBusqueda == 1) {
            $("#tablaVG").dataTable().fnDestroy();
            var table = $('#tablaVG').DataTable( {
                
                 "ajax": {
                    "url": "/FarmSystem/api/listVentaGeneralSinple/"+fecha1,
                    
                },
                    "columns":[
                        {data:"id"},
                        {data:'vent_canTipoArticulos'},
                        {data:'vent_canArticulosTotal'},
                        {data:'vent_efectivoTotal'}     
                    ]
                });
        }
        if (VGtipoBusqueda == 2) {
             $("#tablaVG").dataTable().fnDestroy();
            var table = $('#tablaVG').DataTable( {
                
                 "ajax": {
                    "url": "/FarmSystem/api/listVentaGeneralRango/"+fecha2+"/"+fecha3,
                    
                },
                    "columns":[
                        {data:"id"},
                        {data:'vent_canTipoArticulos'},
                        {data:'vent_canArticulosTotal'},
                        {data:'vent_efectivoTotal'}     
                    ]
                });
        }

    
}





