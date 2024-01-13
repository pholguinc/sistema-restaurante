function init() {
  $("#proveedores_form").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#proveedores_form")[0].reset();
  $("#id_proveedor").val("");
  $("modal_proveedores").modal("show");
});

$(document).ready(function () {
  listarTabla();
  //console.log("Holaaa");
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#proveedores_form")[0]);
  $.ajax({
    url: "../../controllers/proveedores.php?opcion=guardarEditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#proveedores_form")[0].reset();
      $("#modal_proveedores").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/proveedores.php?opcion=listar",
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

function editar(id_proveedor) {
  $("#modal_titulo").html("Editar");
  $("#modal_proveedores").modal("show");
  $.post(
    "../../controllers/proveedores.php?opcion=mostrar",
    { id_proveedor: id_proveedor },
    function (data) {
      data = JSON.parse(data);
      $("#id_proveedor").val(data.id_proveedor);
      $("#nombres").val(data.nombres);
      $("#direccion").val(data.direccion);
      $("#correo").val(data.correo);
      $("#telefono").val(data.telefono);
    }
  );
  $("#modal_proveedores").modal("hide");
  console.log(id_proveedor);
}

function eliminar(id_proveedor) {
  console.log(id_proveedor);
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
        "../../controllers/proveedores.php?opcion=eliminar",
        { id_proveedor: id_proveedor },
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
