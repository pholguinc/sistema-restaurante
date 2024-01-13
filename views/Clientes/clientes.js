function init() {
  $("#clientes_form").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#clientes_form")[0].reset();
  $("#id_clientes").val("");
  $("modal_clientes").modal("show");
});

$(document).ready(function () {
  listarTabla();
  //console.log("Holaaa");
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#clientes_form")[0]);
  $.ajax({
    url: "../../controllers/clientes.php?opcion=guardarEditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#clientes_form")[0].reset();
      $("#modal_clientes").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/clientes.php?opcion=listar",
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

function editar(id_clientes) {
  $("#modal_titulo").html("Editar");
  $("#modal_clientes").modal("show");
  $.post(
    "../../controllers/clientes.php?opcion=mostrar",
    { id_clientes: id_clientes },
    function (data) {
      data = JSON.parse(data);
      $("#id_clientes").val(data.id_clientes);
      $("#nombres").val(data.nombres);
      $("#apellidos").val(data.apellidos);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
    }
  );
  $("#modal_clientes").modal("hide");
  console.log(id_clientes);
}

function eliminar(id_clientes) {
  console.log(id_clientes);
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
        "../../controllers/clientes.php?opcion=eliminar",
        { id_clientes: id_clientes },
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
