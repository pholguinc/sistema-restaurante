function init() {
  $("#productos_form").on("submit", function (e) {
    guardarEditar(e);
  });
}

$(document).on("click", "#btnAñadir", function (e) {
  $("#modal_titulo").html("Registrar");
  $("#productos_form")[0].reset();
  $("#id_productos").val("");
  $("modal_productos").modal("show");
});

$(document).ready(function () {
  listarTabla();
  llenarSelectCategorias();
  llenarSelectAlmacen();
  //console.log("Holaaa");
});

function guardarEditar(e) {
  e.preventDefault();
  let formData = new FormData($("#productos_form")[0]);
  $.ajax({
    url: "../../controllers/productos.php?opcion=guardarEditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $("#productos_form")[0].reset();
      $("#modal_productos").modal("hide");
      listarTabla();
      Swal.fire("Registrado!", "Se registro correctamente.", "success");
    },
  });
}

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/productos.php?opcion=listar",
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

function editar(id_productos) {
  $("#modal_titulo").html("Editar");
  $("#modal_productos").modal("show");
  $.post(
    "../../controllers/productos.php?opcion=mostrar",
    { id_productos: id_productos },
    function (data) {
      console.log(data);
      data = JSON.parse(data);
      $("#id_productos").val(data.id_productos);
      $("#nombres").val(data.nombre);
      $("#precio").val(data.precio);
      $("#cantidad").val(data.cantidad);
      $("#detalles").val(data.detalles);
      $("#cbx_categoria").val(data.categoria_id);
      $("#cbx_almacen").val(data.almacen_id);
    }
  );
  $("#modal_productos").modal("hide");
  console.log(id_productos);
}

function eliminar(id_productos) {
  console.log(id_productos);
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
        "../../controllers/productos.php?opcion=eliminar",
        { id_productos: id_productos },
        function (data) {
          console.log(data);
        }
      );
      listarTabla();
      Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
    }
  });
}

function llenarSelectCategorias() {
  $.ajax({
    url: "../../controllers/productos.php?opcion=comboCategoria",
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

function llenarSelectAlmacen() {
  $.ajax({
    url: "../../controllers/productos.php?opcion=comboAlmacen",
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
init();
