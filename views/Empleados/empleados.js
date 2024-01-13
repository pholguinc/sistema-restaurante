function init() {
  $("#empleados_form").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#empleados_form")[0].reset();
  $("#id_empleado").val("");
  $("modal_empleados").modal("show");
});

$(document).ready(function () {
  listarTabla();
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#empleados_form")[0]);
  $.ajax({
    url: "../../controllers/empleados.php?opcion=guardarEditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#empleados_form")[0].reset();
      $("#modal_empleados").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/empleados.php?opcion=listar",
    type: "post",
    dataType: "json",
    success: function (response) {
      console.log(response);
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

function editar(id_empleado) {
  $("#modal_titulo").html("Editar");
  $("#modal_empleados").modal("show");
  $.post(
    "../../controllers/empleados.php?opcion=mostrar",
    { id_empleado: id_empleado },
    function (data) {
      data = JSON.parse(data);
      console.log(data);
      $("#id_empleado").val(data.id_empleado);
      $("#nombres").val(data.nombres);
      $("#apellidos").val(data.apellidos);
      $("#dni").val(data.dni);
      $("#correo").val(data.correo);
      $("#telefono").val(data.telefono);
      //$("#nombreRol").val(data.nombreRol);
      //$("#cbx_cargo").val(data.idRol);
    }
  );
  $("#modal_empleados").modal("hide");
  console.log(id_empleado);
}



function eliminar(id_empleado) {
  console.log(id_empleado);
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
        "../../controllers/empleados.php?opcion=eliminar",
        { id_empleado: id_empleado },
        function (data) {
          console.log(data);
        }
      );
      listarTabla();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}
init();
