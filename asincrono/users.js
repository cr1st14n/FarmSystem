alertify.set("notifier", "position", "top-right");
setTimeout(() => {
  listAllUser();
}, 500);
$("#userFormEdit").submit(function(e) {
  e.preventDefault();
  updateUser();
});
function listAllUser() {
  $.get("/FarmSystem/Adm/users/list1", function(data, textStatus, jqXHR) {
    console.log(data);
    var acceso = "";
    var listU = data
      .map(function(data) {
        if (data.usu_acceso == 1) {
          acceso = `<span class="label label-success">Permitido</span>`;
          accesoBtn = `<a href="{{route('acceso-usuario',$user->id)}}" class="btn btn-default btn-sm" title="Eliminar"><i class="fa fa-unlock"></i></a>`;
        } else {
          acceso = `<span class="label label-danger">Denegado</span>`;
          accesoBtn = `<a href="{{route('acceso-usuario',$user->id)}}" class="btn btn-default btn-sm" title="Eliminar"><i class="fa fa-lock"></i></a>`;
        }
        return `
      <tr>
        <td>usu-${data.id} </td>
        <td>${data.usu_nombre} ${data.usu_appaterno} ${data.usu_apmaterno} </td>
        <td>${data.usu_ci} </td>
        <td>${data.usu_cargo} </td>
        <td>${acceso}</td>
        <td>
          <span class="tooltip-area">
            ${accesoBtn}
            <a onclick="userEdit('${data.id}')" class="btn btn-default btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>
            <a onclick="deleteUser(${data.id})" class="btn btn-default btn-sm" title="Eliminar"><i class="fa fa-trash-o"></i></a>
          </span>
        </td>
      </tr>
      `;
      })
      .join(" ");
    $("#listUser").html(listU);
  });
}
function userEdit(id) {
  var dat = { id: id };
  data = { id: id };
  $("#userFormEdit").trigger("reset");
  $.get("/FarmSystem/Adm/users/edit", data, function(data, textStatus, jqXHR) {
    // console.log(data);
    $("#idUserUdit").val(data.id);
    $("#nombreUp").val(data.usu_nombre);
    $("#APUp").val(data.usu_appaterno);
    $("#AMUp").val(data.usu_apmaterno);
    $("#usu_ciUp").val(data.usu_ci);
    document.getElementById("cargoUp").value = data.usu_cargo;
  });
  $("#modal-actualizatUser").modal("show");
}
function updateUser() {
  var data = {
    _token: $("meta[name=csrf-token]").attr("content"),
    id: $("#idUserUdit").val(),
    nombre: $("#nombreUp").val(),
    AP: $("#APUp").val(),
    AM: $("#AMUp").val(),
    ci: $("#usu_ciUp").val(),
    cargo: $("#cargoUp").val()
  };
  $.post("/FarmSystem/Adm/users/update", data, function(data) {
    console.log(data);
    switch (data) {
      case "success":
        alertify.success("Datos actualizados");
        $("#btn-modal-actualizatUser-close").click();
        listAllUser();
        break;
      case "error1":
        alertify.error("CI ya registrado ");
        break;
      case "fail":
        alertify.error("Error vuelva a intentarlo");
        break;

      default:
        break;
    }
  });
}
function deleteUser(id) {
  // var resp = confirm("desea eliminar" + id);
  // if (resp) {
  //   var data = { id: id, _token: $("meta[name=csrf-token]").attr("content") };
  //   $.post(
  //     "/FarmSystem/Adm/users/destroy",
  //     data,
  //     function(data, textStatus, jqXHR) {
  //       if (data) {
  //         alertify.success("Registro eliminado");
  //         listAllUser();
  //       } else {
  //         alertify.error("Error vuela a intentarlo");
  //       }
  //     }
  //   );
  // } else {
  // }
  var html = `
  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-primary" onClick=destroyUser(${id})>Aceptar</button>`;
  $("#btn-md-eliminar").html(html);
  $("#modal-delete-User").modal("show");
}
function destroyUser(id) {
  var data = { 
    _token: $("meta[name=csrf-token]").attr("content"),
    id: id };
  $.post("/FarmSystem/Adm/users/destroy", data, function(data) {
    if (data == "success") {
      listAllUser();
      $("#btn-md-eliminar-close").click();
      alertify.success('Usuario eliminado');
    } else {
      alertify.error('Error! vuelva a intentarlo');
    }
  });
}

function resetKey(idUsu) {
  $.ajax({
    type: "Post",
    url: "resetKey1",
    data: {idUsu:idUsu, _token: $("meta[name=csrf-token]").attr("content")},
    success: function (res) {
      if (res==1) {
        alertify.success('Contraseña restablecida a: 12345');
        $('#modal-actualizatUser').modal('hide');
      } else {
        alertify.error('Error. Vueva a intentarlo');
      }
    }
  });
  }
