alertify.set("notifier", "position", "top-right");
window.onload = onListClientes();
//FUNCION PARA LLENAR HOMEclientes
function onListClientes() {
  $.get("/FarmSystem/api/clientes/list/", function (clientes) {
    $("#listClientes").html("");
    for (var i = clientes.length - 1; i >= 0; i--) {
      var tr =
        `	<tr id="col-clie-` +
        clientes[i].id +
        `">
							<td>clie-` +
        clientes[i].id +
        `</td>
							<td>` +
        clientes[i].vent_clienteNit +
        `</td>
							<td>` +
        clientes[i].vent_clienteNombre +
        `</td>
							<td>
								<span class="tooltip-area">
								<a href="#" class="btn btn-default btn-sm"  title="Editar"  onclick="editDatosCliente(` +
        clientes[i].id +
        `)"  ><i class="fa fa-eye"></i></a>
								<a href="#" class="btn btn-default btn-sm" title="Eliminar" onclick="deleteClie(` +
        clientes[i].id +
        `)"  ><i class="fa fa-trash-o"></i></a>
								</span>
							</td>  
						</tr>`;
      $("#listClientes").append(tr);
    }
  });
}
function editDatosCliente(id) {
  $.ajax({
    type: "get",
    url: "clienteEdit",
    data: { id: id },
    success: function (data) {
      console.log(data);
      $("#Nombre_clie_up").val(data.vent_clienteNombre);
      $("#dni_clie_up").val(data.vent_clienteNit);
      $("#id_cliente_update").val(data.id);
      $("#modal-editUser").modal("show");
    },
  });
}
$("#form-cliente_update").submit(function (e) {
  e.preventDefault();
  $.ajax({
    type: "post",
    url: "updateCliente",
    data: $(this).serialize(),
    success: function (response) {
      console.log(response);
      if (response == 1) {
        alertify.success("Datos Actualizados");
        $("#modal-editUser").modal("hide");
        $("#form-cliente_update").trigger("reset");
        onListClientes();
      } else {
        alertify.error("Error Vuelva a intentarlo");
      }
    },
  });
});

function deleteClie(id) {
  $.ajax({
    type: "post",
    url: "delete",
    data: { _token: $("meta[name=csrf-token]").attr("content"), id: id },
    success: function (response) {
      if (response == 1) {
        id = `#col-clie-${id}`;
        $(id).empty();
		alertify.success('Cliente eliminado!')
      } else if(response == 'unauthorized') {
		  alertify.warning('Operación no autorizada')
		}else{
			alertify.error('Error. Vuelva a intentarlo!')
	  }
    },
  });
}
