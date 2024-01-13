function init() {
  $("#usuarios_form").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#usuarios_form")[0].reset();
  $("#id_usuario").val("");
  $("modal_usuarios").modal("show");
});

$(document).ready(function () {
  listarTabla();
  llenarSelectEmpleado();
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#usuarios_form")[0]);
  $.ajax({
    url: "../../controllers/usuario.php?opcion=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#usuarios_form")[0].reset();
      $("#modal_usuarios").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/usuario.php?opcion=listar",
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

function editar(id_usuario) {
  $("#modal_titulo").html("Editar");
  $("#modal_usuarios").modal("show");
  $.post(
    "../../controllers/usuario.php?opcion=mostrar",
    { id_usuario: id_usuario },
    function (data) {
      //console.log(data);
      data = JSON.parse(data);

      $("#id_usuario").val(data.id_usuario);
      $("#nombreUsu").val(data.nombre_usuario);
      $("#cdx_empleado").val(data.empleado_id);
      $("#password").prop("disabled", true);
    }
  );
  $("#modal_usuarios").modal("hide");
  console.log(id_usuario);
}

function eliminar(id_usuario) {
  console.log(id_usuario);
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
        "../../controllers/usuario.php?opcion=eliminar",
        { id_usuario: id_usuario },
        function (data) {
          console.log(data);
        }
      );
      listarTabla();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}

function llenarSelectEmpleado() {
  $.ajax({
    url: "../../controllers/usuario.php?opcion=comboEmpleado",
    type: "post",
    dataType: "json",
    success: function (response) {
      (template = `<option value="0">Seleccione Empleados</option>`),
        //console.log(response);
        response.forEach(function (response) {
          template += `<option value="${response.id_empleado}">${response.nombreCompleto}</option>`;
        });
      $("#cdx_empleado").html(template);
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}


init();
