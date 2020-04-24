$('#form-updateArt').submit(function (e) { 
    e.preventDefault();
    var data=$(this).serialize();
    EditDatosArt(data);
});
/* listProductos(); */
alertify.set('notifier','position', 'top-right');
// alertify.success('Current position : ' + alertify.get('notifier','position'));
function listProductos() {
    $.get('/FarmSystem/Adm/AlmInven/store').done(function (data) { 
        listProductos1(data);
    }).fail(function () {
        alertify.error("ERROR SERVER INVENTARIO STOCK");
    });
}
function listProductos1(data) {
    var html = data.map(function (elem,index) {
        return(`<tr>
                    <td>Art-${elem.id}</td>
                    <td>${elem.art_nombreComercial}</td>        
                    <td>${elem.art_nombreGenerico}</td>
                    <td>${elem.prov_nombre}</td>
                    <td>${elem.art_costoProveedor}</td>
                    <td>${elem.art_costoVenta}</td>
                    <td>${elem.sto_cantidad}</td>
                    <td><span class="tooltip-area">
						<button class="btn btn-default btn-sm" title="Ver" onclick="showPro(${elem.id});"><i class="fa fa-eye"></i></button>
                        <button class="btn btn-default btn-sm" title="Eliminar" onclick="deletePro(${elem.id})"><i class="fa fa-trash-o"></i></button>
                        </span></td>
                </tr>`);

    }).join(" ");
    document.getElementById('listarticulos').innerHTML=html;
    probarLocal(data);
}
function listProStock() {
    $.get('/FarmSystem/Adm/AlmInven/storeStock').done(function (data) {  
        listProductos1(data);
    }).fail(function () {
        alertify.error("ERROR SERVER INVENTARIO STOCK");
    });
}
function validar(id) {
    var elemento = document.getElementById(id);
    // console.log(elemento.value);
    if (elemento.checkValidity()){
        elemento.style.borderColor="green";
        elemento.style.backgroundColor="";

    }else if (elemento.value==""){
        elemento.style.borderColor="";
        elemento.style.backgroundColor="";
    }
    else {
        elemento.style.borderColor="red";
        elemento.style.backgroundColor="#ffd3d3";
    }
}
function showPro(idPro) {
    $("#cantEntrante").val("");
    $("#artVencimiento").val("");
    $("#cantSaliente").val("");
    document.getElementById("artVencimiento").style.bordercolor="#d2d6de";
    document.getElementById("cantSaliente").style.bordercolor="#d2d6de";

    $.get('/FarmSystem/api/VerArticulosAjax/'+idPro+'',function(articulo){
        // console.log(articulo);
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
        document.getElementById('cantSaliente').setAttribute('max',articulo.sto_cantidad);
        document.getElementById('idArt').value=articulo.id;
        document.getElementById('idArt2').value=articulo.id;

        $.get('/FarmSystem/api/listProvedores/', function(provedor){
            console.log(provedor);
            var html_select = '<option value="">'+articulo.prov_nombre+'</option>';
            for (var i = provedor.length - 1; i >= 0; i--) {
                html_select += '<option value="'+provedor[i].id+'">'+provedor[i].prov_nombre+'</option>';
                $('#selectProvedor').html(html_select);
            }
        });

    });
    $("#agregarStock").modal('show');
}
function addCantidad() {
    var url='/FarmSystem/Adm/stock/agregarCant';
    var data= { '_token': $('meta[name=csrf-token]').attr('content'),
                'id':$("#idArt").val(),'vencimiento':$("#artVencimiento").val(),
                'cantidad':$("#cantEntrante").val()
                };
    $.post(url,data).done(function (data) {
        console.log(data);
        if (data=="success"){
            $("#agregarStock").modal('hide');
            alertify.success("Stock actualizado");
            listProductos();
        } else{
            alertify.error("Error de procesamiento Vuelva a intentarlo");
        }
    }).fail(function () {
        alertify.warning("ERROR SERVER ADDCANTIDAD");
    });

}
function subtractCantidad() {
    var url='/FarmSystem/Adm/stock/sustraerCant';
    var data= { '_token': $('meta[name=csrf-token]').attr('content'),
        'id':$("#idArt").val(),
        'cantSaliente':$("#cantSaliente").val()
    };
    $.post(url,data).done(function (data) {
        // console.log(data);
        if (data=="success"){
            alertify.success("Estock Actualizado");
            listProductos();
            $("#agregarStock").modal('hide');
        } else if (data=="fail"){
            alertify.error("Error en prosesamiento vuelva a intentarlo");
            listProductos();
            $("#agregarStock").modal('hiden');
        } else if ("cantExedeStock"){
            alertify.warning("Cantidad supera existencia en stock");
        }
    }).fail(function () {
        alertify.warning("ERROR SERVER SUBTRACTCANTIDAD");
        $("#agregarStock").modal('hide');
    })
}
function deletePro(idPro) {
    // alertify.set('notifier','position', 'top-center');
    var dlt= confirm("Desea eliminar este articulo!");
    if (dlt){
        alertify.success("Articulo eliminado");
        document.getElementById('listarticulos').innerHTML="";
    }else{
        alertify.warning("ERROR SERVER DELETE ARTICULO");
    }


}
function filtArtProve(pro) {
  console.log(pro);
  $.get('/FarmSystem/Adm/stock/storeProv/'+pro+'').done(function (data) {
      listProductos1(data);
  }).fail(function () {
      alertify.error("ERROR SERVER LIST FILTR PROVEDORES");
  });
}
/* function filtrarArt() {
    // var valor = document.getElementById('buscar').value;
    // if (valor == null) {alert("vector vacion");}
    console.log();
    if ( == ""){
        document.getElementById('listarticulos').innerHTML="Sin resultados";
    } else {
        $.get('/FarmSystem/Adm/stock/storeNonCNomG/'++'').done(function (data) {
            listProductos1(data);
        }).fail(function () {
            alertify.error("ERROR SERVER LIST FILTRADO  ART");
        });
    }
} */
function filtrarAcTe(at) {
    console.log(at);
    if (at!=""){
        $.get('/FarmSystem/Adm/stock/storeAcTe/'+at+'').done(function (data) {
            listProductos1(data);
        }).fail(function () {
            alertify.error("ERROR SERVER FILTRO AT");
        });
    }
}
function filtrarLiMa(at) {
    console.log(at);
    if (at!=""){
        $.get('/FarmSystem/Adm/stock/storeLiMa/'+at+'').done(function (data) {
            listProductos1(data);
        }).fail(function () {
            alertify.error("ERROR SERVER FILTRO LM");
        });
    }
}
function filtrarNomComercial(NomCom) {
    if (NomCom.length!=0) {
        url='/FarmSystem/Adm/stock/storeNomC'
        datos={'_token': $('meta[name=csrf-token]').attr('content'),
               'texto':NomCom};
        $.post(url,datos).done(function (data) {
            listProductos1(data);
        }).fail(function () {
            
        })       
    }else{
        console.log("no se buscara");
    }
}
function filtrarNomGenerico(NomGen) {
    if (NomGen.length!=0) {
        console.log("se buscara");
        url='/FarmSystem/Adm/stock/storeNomG'
        datos={'_token': $('meta[name=csrf-token]').attr('content'),
               'texto':NomGen};
        $.post(url,datos).done(function (data) {
            console.log(data);
            listProductos1(data);
        }).fail(function () {
            
        })       
    }else{
        console.log("no se buscara");
    }
}
function showModalNesArt() {
    $("#modal-regisArt").modal('show');
}
function createArt() {
    var art_Generico = document.getElementById('art_Generico');
    var art_Comercial = document.getElementById('art_Comercial');
    var art_composicion = document.getElementById('art_composicion');
    var art_laboratorio = document.getElementById('art_laboratorio');
    var art_accionTerapeutica = document.getElementById('art_accionTerapeutica');
    var art_proveedor = document.getElementById('art_proveedor');
    var art_costoProveedor = document.getElementById('art_costoProveedor');
    var art_costoVenta = document.getElementById('art_costoVenta');
    var unidades = document.getElementById('unidades');
    var fechVen = document.getElementById('fechVen');
    // var art_Generico = $("#");
    if (art_Comercial.checkValidity() && art_Generico.checkValidity() &&
        art_composicion.checkValidity() && art_laboratorio.checkValidity() &&
        art_accionTerapeutica.checkValidity() && art_proveedor.checkValidity() &&
        art_costoProveedor.checkValidity() && art_costoVenta.checkValidity() &&
        unidades.checkValidity() && fechVen.checkValidity()
    ){
        var url='/FarmSystem/Adm/stock/createART';
        var data={ '_token': $('meta[name=csrf-token]').attr('content'),
            'art_nombreGenerico': art_Generico.value,
            'art_nombreComercial': art_Comercial.value,
            'art_composicion': art_composicion.value,
            'art_laboratorio': art_laboratorio.value,
            'art_accionTerapeutica': art_accionTerapeutica.value,
            'art_proveedor': art_proveedor.value,
            'art_costoProveedor': art_costoProveedor.value,
            'art_costoVenta': art_costoVenta.value,
            'unidades': unidades.value,
            'fechVen': fechVen.value
        };
        $.post(url,data).done(function (data) {
            console.log(data);
            if (data=="success"){
                alertify.success("Producto registrado exitosamente!");
                listProductos();
                $("#modal-regisArt").modal('hide');
            } else {
                alertify.error("Error. Vuelva a intentarlo!");
                listProductos();
            }
        }).fail(function () {
            alertify.error("ERROR SERVER NEW ART");
        });
        console.log("corregido");
    } else {
        console.log("tiene errores");
        alertify.warning("Verificar Datos del formulario formulario");
    }
}
/* if (typeof(Storage)!=='undefined') {
    console.log("disponible");
}else{
    console.log("incompatible")
} */
/* localStorage.setItem("titulo","curso de symfoy de victor robles");
var usuario={
    :"tian",email:"tian@mail.com",web:"TimeRanges.com"
};
localStorage.setItem("usu",JSON.stringify(usuario));
var userjs = JSON.parse(localStorage.getItem("usu"));
console.log(userjs); */
function probarLocal(data) {
    
    localStorage.setItem("list",JSON.stringify(data));
    var listjs = JSON.parse(localStorage.getItem("list"));
    
    ordenarDesc(listjs, 'art_proveedor');
    console.log(listjs);
    
    
    
}
function ordenarDesc(p_array_json, p_key) {
    ordenarAsc(p_array_json, p_key); p_array_json.reverse(); 
 }
function ordenarAsc(p_array_json, p_key) {
    p_array_json.sort(function (a, b) {
       return a[p_key] > b[p_key];
    });
 }
 function orderCod() {
    var listjs = JSON.parse(localStorage.getItem("list"));
    ordenarAsc(listjs,"id");
    console.log(listjs);
 }

 function  EditDatosArt(data) {
    $.ajax({
        type: "POST",
        url: "updateV2",
        data:data,
        // dataType: "text",
        success: function (data) {
            console.log(data);
            if (data==1) {
                alertify.success("Datos Actualizados!");
                // showPro()
            } else {
                
            }
        }
    });
}

