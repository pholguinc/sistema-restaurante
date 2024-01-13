$(document).ready(function () {
  listarTabla();
  //console.log("Holaaa");
});

function listarTabla() {
  let tabla = $(".js-dataTable-full-pagination").DataTable();

  tabla.clear().draw();

  $.ajax({
    url: "../../controllers/almacen.php?opcion=listar",
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
