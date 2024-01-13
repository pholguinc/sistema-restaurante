function init() {
  $("#presentacion_form").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#presentacion_form")[0].reset();
  $("#id_presentacion").val("");
  $("modal_presentacion").modal("show");
});

$(document).ready(function () {
  listarTabla();
  //console.log("Holaaa");
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#presentacion_form")[0]);
  $.ajax({
    url: "../../controllers/presentacion.php?opcion=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      //console.log(datos);
      $("#presentacion_form")[0].reset();
      $("#modal_presentacion").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/presentacion.php?opcion=listar",
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

function editar(id_presentacion) {
  $("#modal_titulo").html("Editar");
  $("#modal_presentacion").modal("show");
  $.post(
    "../../controllers/presentacion.php?opcion=mostrar",
    { id_presentacion: id_presentacion },
    function (data) {
      console.log(data);
      data = JSON.parse(data);

      $("#id_presentacion").val(data.id_presentacion);
      $("#nombres").val(data.nombre);
    }
  );
  $("#modal_presentacion").modal("hide");
  console.log(id_presentacion);
}

function eliminar(id_presentacion) {
  console.log(id_presentacion);
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
        "../../controllers/presentacion.php?opcion=eliminar",
        { id_presentacion: id_presentacion },
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
