function init() {
  $("#pisos_form").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadirPisos", function (e) {
  $("#modal_titulo_pisos").html("Registrar");
  $("#pisos_form")[0].reset();
  $("#id_pisos").val("");
  $("modal_pisos").modal("show");
});

$(document).ready(function () {
  listarTablaPisos();
  //listarTablaMesas();
  //console.log("Holaaa");
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#pisos_form")[0]);
  $.ajax({
    url: "../../controllers/pisos.php?opcion=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      //console.log(datos);
      $("#pisos_form")[0].reset();
      $("#modal_pisos").modal("hide");
      listarTablaPisos();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTablaPisos() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/pisos.php?opcion=listar",
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

function editar(id_pisos) {
  $("#modal_titulo_pisos").html("Editar");
  $("#modal_pisos").modal("show");
  $.post(
    "../../controllers/pisos.php?opcion=mostrar",
    { id_pisos: id_pisos },
    function (data) {
      console.log(data);
      data = JSON.parse(data);

      $("#id_pisos").val(data.id_piso);
      $("#nombrPiso").val(data.nombre);
      $("#descripcionPiso").val(data.descripcion);
    }
  );
  $("#modal_pisos").modal("hide");
  console.log(id_pisos);
}

function eliminar(id_pisos) {
  console.log(id_pisos);
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
        "../../controllers/pisos.php?opcion=eliminar",
        { id_pisos: id_pisos },
        function (data) {
          console.log(data);
        }
      );
      listarTablaPisos();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}
init();
