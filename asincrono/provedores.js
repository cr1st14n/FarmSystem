alertify.set("notifier", "position", "top-right");
setTimeout(() => {
  listProvedores();
}, 500);
$("#form-edit-Provedor").submit(function(e) {
  e.preventDefault();
  provedorUpdate();
});
function listProvedores() {
  $.get("/FarmSystem/Adm/proveedor/list", function(data) {
    var listProv = data
      .map(function(e) {
        return `
             <tr>
             <td>Prov-${e.id} </td>  
             <td>${e.prov_nombre} </td>  
             <td>${e.prov_direccion} </td>  
             <td>${e.prov_telf} </td>  
             <td>${e.prov_empresa} </td>  
             <td>
                 <span class="tooltip-area">
                 <a onClick="editProv(${e.id})" class="btn btn-default btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>
                 <a onClick="deleteProv(${e.id})" class="btn btn-default btn-sm" title="Eliminar"><i class="fa fa-trash-o"></i></a>
                 </span>
             </td>  
           </tr>
             `;
      })
      .join(" ");
    $("#provedores-list-table").html(listProv);
  });
}
function editProv(id) {
  if (id > 0) {
    var data = { id: id };
    $.get("/FarmSystem/Adm/proveedor/edit", data, function(data) {
      $("#form-edit-Provedor").trigger("reset");
      $("#form-edit-Provedor-id").val(data.id);
      $("#nombreUP").val(data.prov_nombre);
      $("#direccionUP").val(data.prov_direccion);
      $("#telfUP").val(data.prov_telf);
      $("#empresaUP").val(data.prov_empresa);
      $("#modal-edit-Provedor").modal("show");
    });
  } else {
    alertyfy.error("Error! Vuelva a intentarlo");
  }
}
function provedorUpdate() {
  var data = {
    _token: $("meta[name=csrf-token]").attr("content"),
    id: $("#form-edit-Provedor-id").val(),
    prov_nombre: $("#nombreUP").val(),
    prov_direccion: $("#direccionUP").val(),
    prov_telf: $("#telfUP").val(),
    prov_empresa: $("#empresaUP").val()
  };
  $.post("/FarmSystem/Adm/proveedor/update", data, function(data) {
    console.log(data);
    if (data == "success") {
      listProvedores();
      alertify.success("Provedor actualizado");
      $("#modal-edit-Provedor").modal("hide");
    } else {
      alertify.error("Error!. Vuelva a intentarlo");
    }
  });
}
function deleteProv(id) {
  $("#md-delete-prov").modal("show");
  var htmlId = `Eliminar provedor, codigo: Prov-${id}`;
  var html = `
   <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
   <button type="button" class="btn btn-primary" onClick="provDestroy(${id})">Aceptar</button>
   `;
  $("#text-md-prov-eliminar").text(htmlId);
  $("#btn-md-prov-eliminar").html(html);
}
function provDestroy(id) {
  var data = {
    _token: $("meta[name=csrf-token]").attr("content"),
    id: id
  };
  $.post("/FarmSystem/Adm/proveedor/destroy", data, function(data) {
    if (data == "success") {
      listProvedores();
      alertify.success("Provedor eliminado!");
      $("#md-delete-prov").modal("hide");
    } else {
      alertify.error("Error!. Vuelva a intentarlo!");
    }
  });
}
