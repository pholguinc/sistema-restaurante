<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {
    $objeto = new Conectar();
    $conexion = $objeto->Conexion();
    $id_user = $_SESSION['id_usuario'];
    $query = $conexion->prepare("SELECT p.*, s.nombre AS sala, u.nombre_usuario FROM pedidos p INNER JOIN sala s ON p.sala_id = s.id_sala INNER JOIN usuarios u ON p.usuario_id = u.id_usuario");
    $query->execute();
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
                            <h2 class="block-title">Historial de ventas</h2>

                        </div>

                        <div id="modal_roles" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-center" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-dialog-center  role=" document">
                                <div class="modal-content">
                                    <div class="block block-themed block-transparent mb-5">
                                        <div class="block-header bg-primary">
                                            <h3 class="block-title" id="modal_titulo" style="text-transform: uppercase;"></h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                    <i class="si si-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" id="roles_form">
                                        <div class="block-content">
                                            <input type="hidden" name="id_roles" id="id_roles">
                                            <div class="form-group row">
                                                <label class="col-12">Nombre:</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombre.." required>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" name="action" value="add" id="btnGuardar" class="btn btn-alt-success">
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
                            <table id="tabla_clientes" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination ">
                                <thead>
                                    <tr>
                                        <th class="">Sala</th>
                                        <th class="">Mesa</th>
                                        <th class="">Usuario</th>
                                        <th class="">Total</th>
                                        <th class="">Fecha</th>
                                        <th class="">Estado</th>
                                        <th class="" style="width: 12%;">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                        if ($row['estado'] == 1) {
                                            $estado = '<span class="badge badge-danger">Pendiente</span>';
                                            $mostrarBoton = false; // No mostrar el botón si el estado es Pendiente
                                        } else {
                                            $estado = '<span class="badge badge-success">Completado</span>';
                                            $mostrarBoton = true; // Mostrar el botón solo si el estado es Completado
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $row['sala']; ?></td>
                                            <td><?php echo $row['numero_mesa']; ?></td>
                                            <td><?php echo $row['nombre_usuario']; ?></td>
                                            <td><?php echo $row['total']; ?></td>
                                            <td><?php echo $row['fecha']; ?></td>
                                            <td>
                                                <a href="#" class="btn"><?php echo $estado; ?></a>
                                            </td>
                                            <td>
                                                <?php if ($mostrarBoton) { ?>
                                                    <a class="btn btn-info" href="ticket.php?id_pedido=<?php echo $row['id_pedido']; ?>" target="_blank" >
                                                        <i class="fa fa-print" aria-hidden="true"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
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
        <script type="text/javascript" src="caja.js"></script>
    </body>
    <!-- <script type="text/javascript" src="clientes.js"></script> -->

    </html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>