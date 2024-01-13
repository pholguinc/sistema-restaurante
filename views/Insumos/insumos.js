function init() {
  $("#insumos_form").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#insumos_form")[0].reset();
  $("#id_insumos").val("");
  $("modal_insumos").modal("show");
});

$(document).ready(function () {
  listarTabla();
  llenarSelectPresentacion();
  llenarSelectAlmacen();
  llenarSelectProveedor();
  //console.log("Holaaa");
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#insumos_form")[0]);
  $.ajax({
    url: "../../controllers/insumos.php?opcion=guardarEditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#insumos_form")[0].reset();
      $("#modal_insumos").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/insumos.php?opcion=listar",
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

function editar(id_insumos) {
  $("#modal_titulo").html("Editar");
  $("#modal_insumos").modal("show");
  $.post(
    "../../controllers/insumos.php?opcion=mostrar",
    { id_insumos: id_insumos },
    function (data) {
      console.log(data);
      data = JSON.parse(data);
      $("#id_insumos").val(data.id_insumos);
      $("#nombres").val(data.nombre);
      $("#cantidad").val(data.cantidad);
      $("#precio").val(data.precio_unitario);
      $("#descripcion").val(data.descripcion);
      $("#cbx_presentacion").val(data.presentacion_id);
      $("#cbx_almacen").val(data.almacen_id);
      $("#cbx_proveedor").val(data.proveedor_id);
    }
  );
  $("#modal_insumos").modal("hide");
  console.log(id_insumos);
}

function eliminar(id_insumos) {
  console.log(id_insumos);
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
        "../../controllers/insumos.php?opcion=eliminar",
        { id_insumos: id_insumos },
        function (data) {
          console.log(data);
        }
      );
      listarTabla();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}

function llenarSelectPresentacion() {
  $.ajax({
    url: "../../controllers/insumos.php?opcion=comboPresentacion",
    type: "post",
    dataType: "json",
    success: function (response) {
      (template = `<option value="0">Seleccione Presentación</option>`),
        //console.log(response);
        response.forEach(function (response) {
          template += `<option value="${response.id_presentacion}">${response.nombre}</option>`;
        });
      $("#cbx_presentacion").html(template);
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}

function llenarSelectAlmacen() {
  $.ajax({
    url: "../../controllers/insumos.php?opcion=comboAlmacen",
    type: "post",
    dataType: "json",
    success: function (response) {
      (template = `<option value="0">Seleccione Almacen</option>`),
        //console.log(response);
        response.forEach(function (response) {
          template += `<option value="${response.id_almacen}">${response.nombre}</option>`;
        });
      $("#cbx_almacen").html(template);
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}

function llenarSelectProveedor() {
  $.ajax({
    url: "../../controllers/insumos.php?opcion=comboProveedor",
    type: "post",
    dataType: "json",
    success: function (response) {
      (template = `<option value="0">Seleccione Proveedor</option>`),
        //console.log(response);
        response.forEach(function (response) {
          template += `<option value="${response.id_proveedor}">${response.nombre}</option>`;
        });
      $("#cbx_proveedor").html(template);
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", errorThrown);
    },
  });
}
init();
