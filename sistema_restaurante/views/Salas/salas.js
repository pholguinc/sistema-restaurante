function init() {
  $("#salasForm").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#salasForm")[0].reset();
  $("#id_sala").val("");
  $("modalSala").modal("show");
});

$(document).ready(function () {
  listarTabla();
  //console.log("Holaaa");
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#salasForm")[0]);
  $.ajax({
    url: "../../controllers/sala.php?opcion=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      //console.log(datos);
      $("#salasForm")[0].reset();
      $("#modalSala").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/sala.php?opcion=listar",
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

function editar(id_sala) {
  $("#modal_titulo").html("Editar");
  $("#modalSala").modal("show");
  $.post(
    "../../controllers/sala.php?opcion=mostrar",
    { id_sala: id_sala },
    function (data) {
      console.log(data);
      data = JSON.parse(data);

      $("#id_sala").val(data.id_sala);
      $("#nombres").val(data.nombre);
      $("#mesas").val(data.mesa);
    }
  );
  $("#modalSala").modal("hide");
  console.log(id_sala);
}

function eliminar(id_sala) {
  console.log(id_sala);
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
        "../../controllers/sala.php?opcion=eliminar",
        { id_sala: id_sala },
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
