function init() {
  $("#roles_form").on("submit", function (e) {
    guardar_editar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#roles_form")[0].reset();
  $("#id_roles").val("");
  $("modal_roles").modal("show");
});

$(document).ready(function () {
  listar_tabla();
  //console.log("Holaaa");
});

function guardar_editar(e) {
  e.preventDefault();
  let formData = new FormData($("#roles_form")[0]);
  $.ajax({
    url: "../../controllers/roles.php?opcion=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      //console.log(datos);
      $("#roles_form")[0].reset();
      $("#modal_roles").modal("hide");
      listar_tabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listar_tabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/roles.php?opcion=listar",
    type: "post",
    dataType: "json",
    success: function (response) {
      //console.log(response);
      if (response.aaData) {
        // Agregar los nuevos datos a la tabla
        tabla.rows.add(response.aaData).draw();
      } else {
        console.error("No se encontró respuesta del servidor.");
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}

function editar(id_roles) {
  $("#modal_titulo").html("Editar");
  $("#modal_roles").modal("show");
  $.post(
    "../../controllers/roles.php?opcion=mostrar",
    { id_roles: id_roles },
    function (data) {
      console.log(data);
      data = JSON.parse(data);

      $("#id_roles").val(data.id_roles);
      $("#nombres").val(data.nombre);
    }
  );
  $("#modal_roles").modal("hide");
  console.log(id_roles);
}

function eliminar(id_roles) {
  console.log(id_roles);
  Swal.fire({
    title: "AVISO DEL SISTEMA",
    text: "¿Desea eliminar este registro?",
    icon: "error",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Confirmar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../../controllers/roles.php?opcion=eliminar",
        { id_roles: id_roles },
        function (data) {
          console.log(data);
        }
      );
      listar_tabla();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}
init();
