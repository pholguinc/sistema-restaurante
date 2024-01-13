<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {
    $id = $_GET['id_sala'];
    $mesas = $_GET['mesa'];
?>
    <!doctype html>
    <meta lang="es">

    <head>
        <?php require_once("../../views/MainHead/MainHead.php") ?>
        <title>Sistema Restaurante</title>
        <link rel="stylesheet" href="../../CSS/style.css">

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
                    <div class="card">
                        <div class="card-header text-center p-20">
                            <p style="text-transform: uppercase; font-weight: bold; color: black; text-align: center; font-size: 25px;"> Mesas</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                require_once("../../config/conexion.php");
                                $objeto = new Conectar();
                                $conexion = $objeto->Conexion();
                                $query = $conexion->prepare("SELECT * FROM sala WHERE id_sala = :id");
                                $query->bindParam(":id", $id, PDO::PARAM_INT);
                                $query->execute();
                                $result = $query->rowCount();

                                if ($result > 0) {
                                    $data = $query->fetch(PDO::FETCH_ASSOC);
                                    if ($data['mesa'] == $mesas) {
                                        $item = 1;
                                        for ($i = 0; $i < $mesas; $i++) {
                                            $consulta = $conexion->prepare("SELECT * FROM pedidos WHERE sala_id = :id AND numero_mesa= :item AND estado = 1");
                                            $consulta->bindParam(":id", $id, PDO::PARAM_INT);
                                            $consulta->bindParam(":item", $item, PDO::PARAM_INT);
                                            $consulta->execute();
                                            $resultPedido = $consulta->fetch(PDO::FETCH_ASSOC);
                                ?>
                                            <div class="col-md-3">
                                                <div class="card card-widget widget-user">
                                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                                    <div class="widget-user-header bg-<?php echo empty($resultPedido) ? 'success' : 'danger'; ?>">
                                                        <h3 class="widget-user-username">MESA</h3>
                                                        <h5 class="widget-user-desc"><?php echo $item; ?></h5>
                                                    </div>
                                                    <div class="widget-user-image">
                                                        <img class="img-circle elevation-2" src="../../img/salas.jpg" alt="User Avatar">
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="description-block">
                                                            <?php
                                                            if (empty($resultPedido)) {
                                                                echo '<a class="btn btn-outline-info" href="pedido.php?id_sala=' . $id . '&mesa=' . $item . '">Atender</a>';
                                                            } else {
                                                                echo '<a class="btn btn-outline-success" href="finalizar.php?id_sala=' . $id . '&mesa=' . $item . '">Finalizar</a>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <!-- /.row -->
                                                    </div>
                                                </div>
                                            </div>

                                <?php $item++;
                                        }
                                    }
                                } ?>
                            </div>

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
        <script type="text/javascript" src="caja.js"></script>
    </body>
    <!-- <script type="text/javascript" src="clientes.js"></script> -->

    </html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>