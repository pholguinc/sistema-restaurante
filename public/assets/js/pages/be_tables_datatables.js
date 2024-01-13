/*
 *  Document   : be_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var BeTableDatatables = (function () {
  // Override a few DataTable defaults, for more examples you can check out https://www.datatables.net/
  var exDataTable = function () {
    jQuery.extend(jQuery.fn.dataTable.ext.classes, {
      sWrapper: "dataTables_wrapper dt-bootstrap4",
    });
  };

  // Init full DataTable, for more examples you can check out https://www.datatables.net/
  var initDataTableFull = function () {
    jQuery(".js-dataTable-full").dataTable({
      columnDefs: [{ orderable: false, targets: [4] }],
      pageLength: 8,
      lengthMenu: [
        [5, 8, 15, 20],
        [5, 8, 15, 20],
      ],
      autoWidth: false,
    });
  };

  // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
  var initDataTableFullPagination = function () {
    jQuery(".js-dataTable-full-pagination").dataTable({
      buttons: [
        {
          extend: "copy",
          text: "Copiar",
        },
        {
          extend: "excel",
          text: "Exportar a Excel",
        },
        {
          extend: "pdf",
          text: "Exportar a PDF",
          title: "REPORTE",
          exportOptions: {
            columns: ":visible",
          },
        },
      ],
      dom: "Bfrtip",
      pagingType: "full_numbers",
      // columnDefs: [{ orderable: false, targets: [4] }],
      columnDefs: [{ defaultContent: "-", target: "_all" }],
      pageLength: 5,
      lengthMenu: [
        [5, 10, 15, 20],
        [5, 10, 15, 20],
      ],
      autoWidth: false,
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo:
          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando 0 de 0 de 0 entradas",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
      },
    });
  };

  // Init simple DataTable, for more examples you can check out https://www.datatables.net/
  var initDataTableSimple = function () {
    jQuery(".js-dataTable-simple").dataTable({
      columnDefs: [{ orderable: false, targets: [4] }],
      pageLength: 8,
      lengthMenu: [
        [5, 8, 15, 20],
        [5, 8, 15, 20],
      ],
      autoWidth: false,
      searching: false,
      oLanguage: {
        sLengthMenu: "",
      },
      dom: "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
    });
  };

  return {
    init: function () {
      // Override a few DataTable defaults
      exDataTable();

      // Init Datatables
      initDataTableSimple();
      initDataTableFull();
      initDataTableFullPagination();
    },
  };
})();

// Initialize when page loads
jQuery(function () {
  BeTableDatatables.init();
});
