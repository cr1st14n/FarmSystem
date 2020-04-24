$(function(){
	$('#clieNit').on('keyup',onPrecioUnidad);
	$('#art').on('change',onSelectFecha);

	//activacion para select articulo
	$('#selecArticulo').on('change',onSelectArt);

	//ver detalle de venta
	//$('#verVentaDetalle').on('click',onDetalleVenta(this.name));
});

function onSelectArt(){
	var idArt = $(this).val();
	$.get('/FarmSystem/api/articuloStock/'+idArt+'', function(articulo){
		var stock = articulo.sto_cantidad;
		var precio = articulo.art_costoVenta;
        	document.getElementById('cantidad').value ='';
        	document.getElementById('precioArt').value =precio;
        	document.getElementById('detalleArt').innerHTML =stock+'u. <br>'+ precio +'Bs.-';
        	document.getElementById('cantidad').max =stock;


	});
}
function calcularPrecio(x){
        	var precio = document.getElementById('precioArt').value;
        	var total = x * precio;
        	document.getElementById('Costo1').innerHTML=total+'Bs.-';
        }
function onPrecioUnidad(){
	var idArt = $(this).val();
	$.get('/FarmSystem/api/clenteDatos/'+idArt+'',function(data){
		if (data.vent_clienteNombre == null) {
        	document.getElementById('clieNombre').value ='';
        	//document.getElementById('clieNombre').focus();
        	document.getElementById('nomspan').innerHTML ='Cliente no registrado ';
	setTimeout(clearSpan,5000);
        	return;
		}
        document.getElementById('nomspan').innerHTML ='';
		var nombre = data.vent_clienteNombre;
		var apellido = data.vent_clienteApellidi;
        document.getElementById('clieNombre').value =nombre+' '+apellido;
	setTimeout(clearSpan,5000);
	//console.log(nombre+apellido);
	//alert(nombre+apellido);
	});
	function clearSpan(){
        document.getElementById('nomspan').innerHTML ='';
	}
}
function onSelectFecha(){
	var idArt = $(this).val();
	$.get('/FarmSystem/api/artF/'+idArt+'', function(data){
		var html_select = '<option value="">seleccionar</option>';
		for (var i = data.length - 1; i >= 0; i--) {
			html_select += '<option value="'+data[i].id+'">'+data[i].cod_art+'</option>';
			$('#art-fecha').html(html_select);
		}
	});
}
function onDetalleVenta(idVenta){
	var usuario = document.getElementById('usu'+idVenta).innerHTML;
	var fecha = document.getElementById('fecha'+idVenta).innerHTML;
	var precioVT = document.getElementById('precioVT'+idVenta).innerHTML;
	$.get('/FarmSystem/api/detallVenta/'+idVenta+'',function(venta){
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
	document.getElementById('Codventa').innerHTML='Descripcion de venta: # de factura :'+idVenta;
	document.getElementById('CostoDeVenta').innerHTML='Efectivo Total: '+ precioVT ;
	document.getElementById('ventaUsuario').innerHTML='Usuario :'+usuario;
	document.getElementById('ventaFecha').innerHTML='Fecha: '+fecha;
}


//funcion para llenar tabla de articulos
function onTableArticulos(){
	alert("va bien");
	$.get('/FarmSystem/api/listArticulosAjax/',function(articulo){
		$('#listarticulo').html("");
		for (var i = articulo.length - 1; i >= 0; i--) {
			console.log(articulo[i]);
			var tr = `<tr>
			          <td>Art-`+articulo[i].id+`</td>
			          <td>`+articulo[i].art_nombreGenerico+`</td>
			          <td>`+articulo[i].art_nombreComercial+`</td>
			          <td>`+articulo[i].art_composicion+`</td>
			          <td>`+articulo[i].art_laboratorio+`</td>
			          <td>`+articulo[i].art_proveedor+`</td>
			          <td>`+articulo[i].art_costoProveedor+`</td>
			          <td>`+articulo[i].art_costoVenta+`</td>
			          <td>`+articulo[i].sto_cantidad+`</td>
			          <td>
                          <span class="tooltip-area">
                          <a href="" class="btn btn-default btn-sm"  title="Editar" name="" onclick="" id="verClieDetalle" data-toggle="modal" data-target="#modal-regisUser"><i class="fa fa-eye"></i></a>
                          <a href="" class="btn btn-default btn-sm" title="Eliminar"><i class="fa fa-trash-o"></i></a>
                          </span>
                      </td>  
		   	        </tr>`;
			$("#listarticulo").append(tr)	
		}
	});
}

