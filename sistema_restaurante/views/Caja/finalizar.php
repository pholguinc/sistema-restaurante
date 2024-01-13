<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {
    $fecha = date('Y-m-d');
    $id_sala = $_GET['id_sala'];
    $mesa = $_GET['mesa'];

    //ID DEL PEDIDO
    $objeto = new Conectar();
    $conexion = $objeto->Conexion();
    $query = $conexion->prepare("SELECT * FROM pedidos WHERE sala_id = $id_sala AND numero_mesa = $mesa AND estado = 1");
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
   

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
                    <div class="card card-primary card-outline">
                        <div class="row card-header text-center">
                            <div class="col-12">
                                <h3 class="card-title pt-3">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    Detalles Ventas
                                </h3>
                            </div>
                            <div class="col-12 pt-20">
                                
                                <a class="btn btn-info" href="ticket.php?id_pedido=<?php echo $resultado['id_pedido']; ?>" target="_blank" >
                                                        <i class="fa fa-print" aria-hidden="true"></i>Imprimir Ticket
                                                    </a>
                            </div>
                        </div>


                        <div class="card-body">
                            <input type="hidden" id="id_sala" value="<?php echo $_GET['id_sala']; ?>">
                            <input type="hidden" id="mesa" value="<?php echo $_GET['mesa']; ?>">
                            <div class="row">
                                <?php
                                require_once("../../config/conexion.php");
                                $objeto = new Conectar();
                                $conexion = $objeto->Conexion();

                                $query = $conexion->prepare("SELECT * FROM pedidos WHERE sala_id = $id_sala AND numero_mesa = $mesa AND estado = 1");
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_ASSOC);
                                if (!empty($result)) { ?>
                                    <div class="col-md-12 text-center">
                                        <div class="col-12">
                                            Fecha: <?php echo $result['fecha']; ?>
                                            <hr>
                                            Mesa: <?php echo $_GET['mesa']; ?>

                                        </div>

                                        <div class="bg-gray py-2 px-3 mt-4">
                                            <h2 class="mb-0">
                                                $<?php echo $result['total']; ?>
                                            </h2>
                                        </div>
                                        <hr>
                                        <h3>Platos</h3>
                                        <div class="row">
                                            <?php $id_pedido = $result['id_pedido'];
                                            $query1 = $conexion->prepare("SELECT * FROM detalle_pedidos WHERE pedido_id = $id_pedido");
                                            $query1->execute();
                                            while ($data1 = $query1->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <div class="col-md-4 card card-widget widget-user">
                                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                                    <div class="widget-user-header bg-warning">
                                                        <h3 class="widget-user-username">Precio</h3>
                                                        <h5 class="widget-user-desc"><?php echo $data1['precio']; ?></h5>
                                                    </div>
                                                    <div class="widget-user-image">
                                                        <img class="img-circle elevation-2" src="../../img/salas.jpg" alt="User Avatar">
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="description-block">
                                                            <span><?php echo $data1['nombre']; ?></span>
                                                        </div>
                                                        <!-- /.row -->
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="mt-4 p-50">
                                            <a class="btn btn-success btn-flat finalizarPedido" href="#">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>

                                                Finalizar
                                            </a>
                                            <a class="btn btn-danger btn-flat" href="index.php">
                                                <i class="fa fa-ban" aria-hidden="true"></i>

                                                Cancelar
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- /.card -->
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