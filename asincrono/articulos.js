$(function(){
	//$('#buscar').on('keyup',onBuscarArticulo());
	$('#btnArticulos').on('Click',listarArticulos());
});
function onVerArticulo(id){
	
	$.get('/FarmSystem/api/VerArticulosAjax/'+id+'',function(articulo){
    console.log(articulo.id);
    document.getElementById('id_art').value=articulo.id;
    document.getElementById('ngenerico').value=articulo.art_nombreGenerico;
    document.getElementById('ncomercial').value=articulo.art_nombreComercial;
    document.getElementById('laboratorio').value=articulo.art_laboratorio;
    document.getElementById('cprovedor').value=articulo.art_costoProveedor;
    document.getElementById('cventa').value=articulo.art_costoVenta;
    document.getElementById('acantidad').innerHTML= `<span class="info-box-icon bg-aqua"><i class="fa fa-cubes"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Stock</span>
                  <span class="info-box-number">`+articulo.sto_cantidad+`</span>
                </div>`;
    document.getElementById('cantSaliente').max=articulo.sto_cantidad;
    document.getElementById('idArt').value=articulo.id;
    document.getElementById('idArt2').value=articulo.id;

    $.get('/FarmSystem/api/listProvedores/', function(provedor){
    var html_select = '<option value="">'+articulo.prov_nombre+'</option>';
    for (var i = provedor.length - 1; i >= 0; i--) {
      html_select += '<option value="'+provedor[i].id+'">'+provedor[i].prov_nombre+'</option>';
      $('#selectProvedor').html(html_select);
    }
  });

  });
      

}
function onBuscarArticulo(){
    var valor = document.getElementById('buscar').value;
    if (valor == null) {alert("vector vacion");}

	$.get('/FarmSystem/api/buscarArticulosAjax/'+valor+'',function(articulo){
    $('#listarticulo').html("");

    for (var i = articulo.length - 1; i >= 0; i--) {
      console.log(articulo[i]);
      var tr = `<tr>
                <td>Art-`+articulo[i].id+`</td>
                <td>`+articulo[i].art_nombreGenerico+`</td>
                <td>`+articulo[i].art_nombreComercial+`</td>
                <td>`+articulo[i].art_costoProveedor+`</td>
                <td>`+articulo[i].art_costoVenta+`</td>
                <td>`+articulo[i].sto_cantidad+`</td>
                <td>
                         <span class="tooltip-area">
                        <button class="btn btn-default btn-sm"  title="Ver" name="" data-toggle="modal" data-target="#agregarStock" onclick="onVerArticulo(`+articulo[i].id+`);"><i class="fa fa-eye"></i></button>
                        <a href="destroyArt/`+articulo[i].id+`" class="btn btn-default btn-sm" title="Eliminar"><i class="fa fa-trash-o"></i></a>
                        </span>
                      </td>  
                </tr>`;
      $("#listarticulo").append(tr) 
    }
  });
}
function listarArticulos (){
	$.get('/FarmSystem/api/listArticulosAjax/',function(articulo){
    $('#listarticulo').html("");
    for (var i = articulo.length - 1; i >= 0; i--) {
      console.log(articulo[i]);
      var tr = `<tr>
                <td>Art-`+articulo[i].id+`</td>
                <td>`+articulo[i].art_nombreGenerico+`</td>
                <td>`+articulo[i].art_nombreComercial+`</td>
                <td>`+articulo[i].art_costoProveedor+` Bs.-</td>
                <td>`+articulo[i].art_costoVenta+` Bs.-</td>
                <td>`+articulo[i].sto_cantidad+`</td>
                <td>
                        <span class="tooltip-area">
						<button class="btn btn-default btn-sm"  title="Ver" name="" data-toggle="modal" data-target="#agregarStock" onclick="onVerArticulo(`+articulo[i].id+`);"><i class="fa fa-eye"></i></button>
                        <a href="destroyArt/`+articulo[i].id+`" class="btn btn-default btn-sm" title="Eliminar"><i class="fa fa-trash-o"></i></a>
                        </span>
                      </td>  
                </tr>`;
      $("#listarticulo").append(tr) 
    }
  });
}