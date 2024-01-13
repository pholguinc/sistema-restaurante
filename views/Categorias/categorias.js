function init() {
  $("#categorias_form").on("submit", function (e) {
    guardar_editar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#categorias_form")[0].reset();
  $("#id_categoria").val("");
  $("modal_clientes").modal("show");
});

$(document).ready(function () {
  listar_tabla();
  //console.log("Holaaa");
});

function guardar_editar(e) {
  e.preventDefault();
  let formData = new FormData($("#categorias_form")[0]);
  $.ajax({
    url: "../../controllers/categorias.php?opcion=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      //console.log(datos);
      $("#categorias_form")[0].reset();
      $("#modal_categorias").modal("hide");
      listar_tabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listar_tabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/categorias.php?opcion=listar",
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

function editar(id_categoria) {
  $("#modal_titulo").html("Editar");
  $("#modal_categorias").modal("show");
  $.post(
    "../../controllers/categorias.php?opcion=mostrar",
    { id_categoria: id_categoria },
    function (data) {
      console.log(data);
      data = JSON.parse(data);

      $("#id_categoria").val(data.id_categoria);
      $("#nombres").val(data.nombre);
    }
  );
  $("#modal_categorias").modal("hide");
  console.log(id_categoria);
}

function eliminar(id_categoria) {
  console.log(id_categoria);
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
        "../../controllers/categorias.php?opcion=eliminar",
        { id_categoria: id_categoria },
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
