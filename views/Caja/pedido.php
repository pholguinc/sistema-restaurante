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
                        <div class="card-header platos">
                            <h3 class="card-title" style="text-align: center; text-transform: uppercase; padding: 10px;">
                            <i class="fa fa-cutlery" aria-hidden="true"></i>
                                Platos
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row p-10">
                                <div class="col-7 col-sm-9">
                                    <div class="tab-content" id="vert-tabs-right-tabContent">
                                        <div class="tab-pane fade show active" id="vert-tabs-right-home" role="tabpanel" aria-labelledby="vert-tabs-right-home-tab">
                                            <input type="hidden" id="id_sala" value="<?= htmlspecialchars($_GET['id_sala']) ?>">
                                            <input type="hidden" id="mesa" value="<?= htmlspecialchars($_GET['mesa']) ?>">
                                            <div class="row">
                                                <?php
                                                require_once("../../config/conexion.php");
                                                $objeto = new Conectar();
                                                $conexion = $objeto->Conexion();

                                                $query = $conexion->prepare("SELECT * FROM platos WHERE es_activo = 1 and disponible = 1");
                                                $query->execute();
                                                $result = $query->rowCount();

                                                if ($result > 0) {
                                                    while ($data = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <div class="col-md-3">
                                                            <div class="col-12">
                                                                <img src="../../img/plato.jpg" class="imgSala" alt="Product Image">
                                                            </div>
                                                            <h6 class="my-3"><?= htmlspecialchars($data['nombre']); ?></h6>

                                                            <div class="bg-gray py-2 px-3 mt-4">
                                                                <h2 class="mb-0">
                                                                    $<?= ($data['precio']); ?>
                                                                </h2>
                                                            </div>

                                                            <div class="mt-4">
                                                                <a class="btn btn-primary btn-block btn-flat addDetalle" href="#" data-id="<?= ($data['id_platos']); ?>">
                                                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                                                    Agregar
                                                                </a>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pedido" role="tabpanel" aria-labelledby="pedido-tab">
                                            <div class="row" id="detalle_pedido"></div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="observacion">Observaciones</label>
                                                <textarea id="observacion" class="form-control" rows="3" placeholder="Observaciones"></textarea>
                                            </div>
                                            <button class="btn btn-primary" type="button" id="realizar_pedido">Realizar pedido</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5 col-sm-3">
                                    <div class="nav flex-column nav-tabs nav-tabs-right h-100" id="vert-tabs-right-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" id="vert-tabs-right-home-tab" data-toggle="pill" href="#vert-tabs-right-home" role="tab" aria-controls="vert-tabs-right-home" aria-selected="true">Platos</a>
                                        <a class="nav-link" id="pedido-tab" data-toggle="pill" href="#pedido" role="tab" aria-controls="pedido" aria-selected="false">Pedido</a>
                                    </div>
                                </div>
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