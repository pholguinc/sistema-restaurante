<?php
require_once("../../config/conexion.php");
if ($_SESSION["id_usuario"] == 1) {

?>
    <!doctype html>
    <meta lang="es">

    <head>
        <?php require_once("../../views/MainHead/MainHead.php") ?>
        <title>Sistema Restaurante</title>
    </head>

    <body>

        <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-boxed sidebar-inverse">
            <aside id="side-overlay">
                <div id="side-overlay-scroll">
                    <div class="content-header content-header-fullrow">
                        <div class="content-header-section align-parent">
                            <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </aside>

            <nav id="sidebar">
                <!-- Sidebar Scroll Container -->
                <div id="sidebar-scroll">
                    <!-- Sidebar Content -->
                    <div class="sidebar-content">
                        <?php require_once("../../views/MainSidebar/MainSidebar.php") ?>
                        <!-- Navegacion -->
                        <?php require_once("../../views/MainMenu/MainMenu.php") ?>
                        <!-- fin de navegacion -->
                    </div>
                    <!-- Sidebar Content -->
                </div>
                <!-- END Sidebar Scroll Container -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <?php require_once("../../views/MainHeader/MainHeader.php") ?>
            <!-- END Header -->


            <!-- Contenido -->
            <main id="main-container">
                <div class="content">
                    <div class="block">
                        <div class="block-header block-header-default d-flex justify-content-between align-items-center mr-10 pt-30">
                            <h2 class="block-title">Listado de productos e insumos</h2>
                        </div>
                        <!-- DataTable -->
                        <div class="block-content block-content-full">
                            <table id="tabla_almacen" class="table table-responsive  table-bordered table-striped table-vcenter js-dataTable-full-pagination ">
                                <thead>
                                    <tr>
                                        <th>Almacen</th>
                                        <th>Insumo</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- End DataTable -->
                    </div>
                </div>
            </main>
            <!-- Fin Contenido -->

            <!-- Footer -->
            <?php require_once("../../views/MainFooter/MainFooter.php") ?>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <?php require_once("../../views/MainJs/MainJs.php") ?>
        <script type="text/javascript" src="almacen.js"></script>
    </body>
    <!-- <script type="text/javascript" src="clientes.js"></script> -->

    </html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>