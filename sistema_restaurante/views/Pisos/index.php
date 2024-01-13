<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {

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
                <div class="col">
                    <div class="content ">
                        <div class="block">
                            <div class="block-header block-header-default d-flex justify-content-between align-items-center mr-10 pt-30">
                                <h2 class="block-title">Listado de Pisos</h2>
                                <div class="ml-auto">
                                    <button type="button" id="btnAñadirPisos" class="btn btn-alt-primary mb-0" data-toggle="modal" data-target="#modal_pisos">Añadir</button>
                                </div>
                            </div>

                            <div id="modal_pisos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-center" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-dialog-center  role=" document">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent mb-5">
                                            <div class="block-header bg-primary">
                                                <h3 class="block-title" id="modal_titulo_pisos" style="text-transform: uppercase;"></h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                        <i class="si si-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" id="pisos_form">
                                            <div class="block-content">
                                                <input type="hidden" name="id_pisos" id="id_pisos">
                                                <div class="form-group row">
                                                    <label class="col-12">Nombre:</label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" id="nombrPiso" name="nombrPiso" placeholder="Nombre.." required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12">Descripción:</label>
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" id="descripcionPiso" name="descripcionPiso" rows="2" placeholder="Descripcion..." style="resize: none;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" name="action" value="add" id="btnGuardarPiso" class="btn btn-alt-success">
                                                        <i class="fa fa-check"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>


                            <!-- DataTable -->
                            <div class="block-content block-content-full">
                                <table id="tabla_pisos" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination ">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th style="width: 14%;">Opciones</th>



                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- End DataTable -->
                        </div>

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
        <script type="text/javascript" src="pisos.js"></script>
    </body>


    </html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>