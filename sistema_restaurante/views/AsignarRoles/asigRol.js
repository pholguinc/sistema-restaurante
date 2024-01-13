function init() {
  $("#asigRolForm").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#asigRolForm")[0].reset();
  $("#id_rol_usuario").val("");
  $("modalAsigRol").modal("show");
});

$(document).ready(function () {
  listarTabla();
  llenarSelectUsuario();
  llenarSelectRol();
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#asigRolForm")[0]);
  $.ajax({
    url: "../../controllers/asigRol.php?opcion=guardarEditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#asigRolForm")[0].reset();
      $("#modalAsigRol").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/asigRol.php?opcion=listar",
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

function editar(id_rol_usuario) {
  console.log(id_rol_usuario);
  $("#modal_titulo").html("Editar");
  $("#modalAsigRol").modal("show");
  $.post(
    "../../controllers/asigRol.php?opcion=mostrar",
    { id_rol_usuario: id_rol_usuario },
    function (data) {
      console.log(data);
      data = JSON.parse(data);

      $("#id_rol_usuario").val(data.id_rol_usuario);
      $("#cdx_rol").val(data.rol_id);
      $("#cbx_usuario").val(data.id_usuario);
    }
  );
  $("#modalAsigRol").modal("hide");
  // console.log(id_rol_usuario);
}

function eliminar(id_rol_usuario) {
  console.log(id_rol_usuario);
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
        "../../controllers/asigRol.php?opcion=eliminar",
        { id_rol_usuario: id_rol_usuario },
        function (data) {
          //console.log(data);
        }
      );
      listarTabla();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}

function llenarSelectUsuario() {
  $.ajax({
    url: "../../controllers/asigRol.php?opcion=comboEmpleado",
    type: "post",
    dataType: "json",
    success: function (response) {
      (template = `<option value="0">Seleccione Usuario</option>`),
        //console.log(response);
        response.forEach(function (response) {
          template += `<option value="${response.id_usuario}">${response.nombre_usuario}</option>`;
        });
      $("#cbx_usuario").html(template);
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}

function llenarSelectRol() {
  $.ajax({
    url: "../../controllers/asigRol.php?opcion=comboRol",
    type: "post",
    dataType: "json",
    success: function (response) {
      (template = `<option value="0">Seleccione Rol</option>`),
        //console.log(response);
        response.forEach(function (response) {
          template += `<option value="${response.id_roles}">${response.nombre}</option>`;
        });
      $("#cdx_rol").html(template);
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}

init();
