$(document).ready(function () {
  // Realiza la solicitud AJAX al servidor
  $.ajax({
    url: "../../controllers/caja.php?opcion=cargarMesas",
    method: "GET",
    dataType: "json", // Esperamos datos en formato JSON
    success: function (data) {
      //console.log(data);
      if (data.length > 0) {
        //console.log($("#salaContainer").length);
        data.forEach(function (sala) {
          var salaHtml = `

                      <div class="col-md-3 shadow-lg" id="tarjetaMesa">
                      <div class="col-12">
                        <img src="../../img/salas.jpg" class="imgSala" alt="Product Image">
                       </div>
                          <h6 class="my-3 text-center">
                              <span class="badge badge-info">${sala.nombre}</span>
                          </h6>
                          <div class="mt-4">
                              <a class="btn btn-primary btn-block btn-flat" href="mesas.php?id_sala=${sala.id_sala}&mesa=${sala.mesa}">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                                  Mesas
                              </a>
                          </div>
                      </div>
                  `;
          $("#salaContainer").append(salaHtml);
        });
      } else {
        // Maneja el caso en el que no hay datos
        $("#salaContainer").html("<p>No hay salas disponibles.</p>");
      }
    },
    error: function (error) {
      // Maneja errores aquí
      console.error("Error en la solicitud AJAX:", error);
    },
  });

  if ($("#detalle_pedido").length > 0) {
    listar();
  }

  $("#tbl").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    order: [[0, "desc"]],
  });

  $(".confirmar").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "Esta seguro de eliminar?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "SI, Eliminar!",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });

  $(".addDetalle").click(function () {
    let id_producto = $(this).data("id");
    //console.log(id_producto);
    registrarDetalle(id_producto);
  });

  $("#realizar_pedido").click(function (e) {
    e.preventDefault();
    var action = "procesarPedido";
    var id_sala = $("#id_sala").val();
    var mesa = $("#mesa").val();
    var observacion = $("#observacion").val();
    $.ajax({
      url: "ajax.php",
      async: true,
      data: {
        procesarPedido: action,
        id_sala: id_sala,
        mesa: mesa,
        observacion: observacion,
      },
      success: function (response) {
        const res = JSON.parse(response);
        if (response != "error") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Pedido Solicitado",
            showConfirmButton: false,
            timer: 2000,
          });
          setTimeout(() => {
            window.location =
              "mesas.php?id_sala=" + id_sala + "&mesa=" + res.mensaje;
          }, 1500);
        } else {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Error al generar",
            showConfirmButton: false,
            timer: 2000,
          });
        }
      },
      error: function (error) {
        alert(error);
      },
    });
  });

  $(".finalizarPedido").click(function () {
    var action = "finalizarPedido";
    var id_sala = $("#id_sala").val();
    console.log(id_sala);
    var mesa = $("#mesa").val();
    $.ajax({
      url: "ajax.php",
      async: true,
      data: {
        finalizarPedido: action,
        id_sala: id_sala,
        mesa: mesa,
      },
      success: function (response) {
        console.log("respuesta servidor, " + response);
        const res = JSON.parse(response);
        if (response != "error") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Pedido Finalizado",
            showConfirmButton: false,
            timer: 2000,
          });
          setTimeout(() => {
            window.location =
              "mesas.php?id_sala=" + id_sala + "&mesa=" + res.mensaje;
          }, 1500);
        } else {
          Swal.fire("Eliminado!", "Se elimino correctamente.", "success");
        }
      },
      error: function (error) {
        alert(error);
      },
    });
  });
});

function registrarDetalle(id_pro) {
  let action = "regDetalle";
  $.ajax({
    url: "ajax.php",
    type: "POST",
    dataType: "json",
    data: {
      id: id_pro,
      regDetalle: action,
    },

    success: function (response) {
      console.log("Respuesta del servidor:", response);
      if (response == "registrado") {
        listar();
      }
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Plato agregado",
        showConfirmButton: false,
        timer: 2000,
      });
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud AJAX:", status, error);
    },
  });
}

function listar() {
  let html = "";
  let detalle = "detalle";
  $.ajax({
    url: "ajax.php",
    dataType: "json",
    data: {
      detalle: detalle,
    },
    success: function (response) {
      response.forEach((row) => {
        html += `<div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                        <img class="imgSala" src="../../img/plato.jpg" alt="User Avatar">
                        </div>
                        <p class="my-3">${row.nombre}</p>
                        <h2 class="mb-0">${row.precio}</h2>
                        <div class="mt-1">
                            <input type="number" class="form-control addCantidad mb-2" data-id="${row.id}" value="${row.cantidad}">
                            <button class="btn btn-danger eliminarPlato" type="button" data-id="${row.id}">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>`;
      });
      document.querySelector("#detalle_pedido").innerHTML = html;
      $(".eliminarPlato").click(function () {
        let id = $(this).data("id");
        eliminarPlato(id);
      });
      $(".addCantidad").change(function (e) {
        let id = $(this).data("id");
        cantidadPlato(e.target.value, id);
      });
    },
  });
}

function eliminarPlato(id) {
  let detalle = "Eliminar";
  $.ajax({
    url: "ajax.php",
    data: {
      id: id,
      delete_detalle: detalle,
    },
    success: function (response) {
      if (response == "ok") {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Producto Eliminado",
          showConfirmButton: false,
          timer: 2000,
        });
        listar();
      } else {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error al eliminar el producto",
          showConfirmButton: false,
          timer: 2000,
        });
      }
    },
  });
}

function cantidadPlato(cantidad, id) {
  let detalle = "cantidad";
  $.ajax({
    url: "ajax.php",
    data: {
      id: id,
      cantidad: cantidad,
      detalle_cantidad: detalle,
    },
    success: function (response) {
      if (response != "ok") {
        listar();
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error al agregar cantidad",
          showConfirmButton: false,
          timer: 2000,
        });
      }
    },
  });
}

function imprimirTicket() {
  // Abre la vista de impresión
 // window.print();
}
