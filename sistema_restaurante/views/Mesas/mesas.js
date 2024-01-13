function init() {
  $("#mesasForm").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadirMesas", function (e) {
  $("#modalTituloMesas").html("Registrar");
  $("#mesasForm")[0].reset();
  $("#id_mesa").val("");
  $("modalMesas").modal("show");
});

$(document).ready(function () {
  listarMesas();
  llenarSelectPisos();
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#mesasForm")[0]);
  $.ajax({
    url: "../../controllers/mesas.php?opcion=guardaryeditarMesas",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#mesasForm")[0].reset();
      $("#modalMesas").modal("hide");
      listarMesas();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarMesas() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/mesas.php?opcion=listarMesas",
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

function editar(id_mesa) {
  $("#modalTituloMesas").html("Editar");
  $("#modalMesas").modal("show");
  $.post(
    "../../controllers/mesas.php?opcion=mostrarMesa",
    { id_mesa: id_mesa },
    function (data) {
      console.log(data);
      data = JSON.parse(data);

      $("#id_mesa").val(data.id_mesa);
      $("#nombrMesa").val(data.nombre);
      $("#capacidad").val(data.capacidad);
      $("#cbxPiso").val(data.piso_id);
    }
  );
  $("#modalMesas").modal("hide");
  console.log(id_mesa);
}

function eliminar(id_mesa) {
  console.log(id_mesa);
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
        "../../controllers/pisos.php?opcion=eliminarMesa",
        { id_mesa: id_mesa },
        function (data) {
          console.log(data);
        }
      );
      listarMesas();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}

function llenarSelectPisos() {
  $.ajax({
    url: "../../controllers/mesas.php?opcion=comboPisos",
    type: "post",
    dataType: "json",
    success: function (response) {
      (template = `<option value="0">Seleccione Piso</option>`),
        //console.log(response);
        response.forEach(function (response) {
          template += `<option value="${response.id_piso}">${response.nombre_piso}</option>`;
        });
      $("#cbxPiso").html(template);
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}
init();
