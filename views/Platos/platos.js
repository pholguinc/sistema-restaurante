function init() {
  $("#platos_form").on("submit", function (e) {
    guardar_editar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#platos_form")[0].reset();
  $("#id_platos").val("");
  $("#modal_platos").modal("show");
});

$(document).ready(function () {
  listar_tabla();
  //console.log("Holaaa");
  llenarSelectCategorias();
});

function guardar_editar(e) {
  e.preventDefault();
  let formData = new FormData($("#platos_form")[0]);
  $.ajax({
    url: "../../controllers/platos.php?opcion=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#platos_form")[0].reset();
      $("#modal_platos").modal("hide");
      listar_tabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function llenarSelectCategorias() {
  $.ajax({
    url: "../../controllers/platos.php?opcion=comboCategoria",
    type: "post",
    dataType: "json",
    success: function (response) {
      (template = `<option value="0">Seleccione Categoria</option>`),
        //console.log(response);
        response.forEach(function (response) {
          template += `<option value="${response.id_categoria}">${response.nombre}</option>`;
        });
      $("#cbx_categoria").html(template);
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}

function listar_tabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/platos.php?opcion=listar",
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

function editar(id_platos) {
  $("#modal_titulo").html("Editar");
  $("#modal_platos").modal("show");
  $.post(
    "../../controllers/platos.php?opcion=mostrar",
    { id_platos: id_platos },
    function (data) {
      console.log(data);
      data = JSON.parse(data);

      $("#id_platos").val(data.id_platos);
      $("#nombres").val(data.nombre);
      $("#precio").val(data.precio);
      $("#cbx_categoria").val(data.id_categoria);
    }
  );
  $("#modal_platos").modal("hide");
  console.log(id_platos);
}

function eliminar(id_platos) {
  console.log(id_platos);
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
        "../../controllers/platos.php?opcion=eliminar",
        { id_platos: id_platos },
        function (data) {
          //console.log(data);
        }
      );
      listar_tabla();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}

function cambiarEstado(id_platos) {
  console.log("el id del estado " + id_platos);
  $.ajax({
    url: "../../controllers/platos.php?opcion=cambiarEstado",
    type: "post",
    data: { id_platos: id_platos },
    dataType: "json",
    success: function (response) {
      if (response.disponible == 1) {
        $("#spanEstado")
          .text("Disponible")
          .removeClass("badge-danger")
          .addClass("badge-success");
      } else {
        $("#spanEstado")
          .text("No Disponible")
          .removeClass("badge-success")
          .addClass("badge-danger");
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}
init();
