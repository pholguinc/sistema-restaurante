<?php
require_once("../../config/conexion.php");

if (isset($_SESSION["id_usuario"])) {
    $objeto = new Conectar();
    $conexion = $objeto->Conexion();

    $sql1 = "SELECT COUNT(id_sala) AS total FROM sala WHERE estado = 1";
    $query1 = $conexion->prepare($sql1);
    $query1->execute();
    $totalSalas = $query1->fetch(PDO::FETCH_ASSOC);

    // Consulta para obtener el total de platos activos
    $sql2 = "SELECT COUNT(id_platos) AS total FROM platos WHERE es_activo = 1";
    $query2 = $conexion->prepare($sql2);
    $query2->execute();
    $totalPlatos = $query2->fetch(PDO::FETCH_ASSOC);

    // Consulta para obtener el total de usuarios activos
    $sql3 = "SELECT COUNT(id_usuario) AS total FROM usuarios WHERE es_activo = 1";
    $query3 = $conexion->prepare($sql3);
    $query3->execute();
    $totalUsuarios = $query3->fetch(PDO::FETCH_ASSOC);

    // Consulta para obtener el total de pedidos activos
    $sql4 = "SELECT COUNT(id_pedido) AS total FROM pedidos WHERE estado = 1";
    $query4 = $conexion->prepare($sql4);
    $query4->execute();
    $totalPedidos = $query4->fetch(PDO::FETCH_ASSOC);

    // Consulta para obtener el total de ventas (suma de totales de pedidos)
    $sql5 = "SELECT SUM(total) AS total FROM pedidos";
    $query5 = $conexion->prepare($sql5);
    $query5->execute();
    $totalVentas = $query5->fetch(PDO::FETCH_ASSOC);
?>

    <!doctype html>
    <html lang="en" class="no-focus"> <!--<![endif]-->

    <head>
        <?php require_once("../../views/MainHead/MainHead.php") ?>
        <title>Sistema Restaurante</title>
    </head>

    <body>

        <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-boxed sidebar-inverse">
            <!-- Side Overlay-->
            <aside id="side-overlay">
                <!-- Side Overlay Scroll Container -->
                <div id="side-overlay-scroll">
                    <!-- Side Header -->
                    <div class="content-header content-header-fullrow">
                        <div class="content-header-section align-parent">
                            <!-- Close Side Overlay -->
                            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                            <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <!-- END Close Side Overlay -->

                            <!-- User Info -->
                            <div class="content-header-item">
                                <a class="img-link mr-5" href="be_pages_generic_profile.html">
                                    <img class="img-avatar img-avatar32" src="../../public/assets/img/avatars/avatar15.jpg" alt="">
                                </a>
                                <a class="align-middle link-effect text-primary-dark font-w600" href="be_pages_generic_profile.html">John Smith</a>
                            </div>
                            <!-- END User Info -->
                        </div>
                    </div>
                    <!-- END Side Header -->


                </div>
                <!-- END Side Overlay Scroll Container -->
            </aside>
            <!-- END Side Overlay -->

            <!-- Sidebar -->

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
                <!-- Page Content -->
                <div class="content">
                    <?php if ($_SESSION["rol_id"] == 1) { ?>
                        <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                            <!-- Row #1 -->
                            <div class="col-6 col-xl-3">
                                <a class="block block-rounded block-bordered block-link-shadow" href="../Caja/listaVentas.php">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="float-right mt-15 d-none d-sm-block">
                                            <i class="si si-bag fa-2x text-primary-light"></i>
                                        </div>
                                        <div class="font-size-h3 font-w600 text-primary js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="1500"><?php echo $totalPedidos['total']; ?></div>
                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Pedidos</div>
                                    </div>
                                </a>
                            </div>


                            <div class="col-6 col-xl-3">
                                <a class="block block-rounded block-bordered block-link-shadow" href="">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="float-right mt-15 d-none d-sm-block">
                                            <i class="si si-wallet fa-2x text-earth-light"></i>
                                        </div>
                                        <div class="font-size-h3 font-w600 text-earth">S/<span data-toggle="countTo" data-speed="1000" data-to="780" class="js-count-to-enabled"><?php echo $totalVentas['total']; ?></span></div>
                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Total Ventas</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-6 col-xl-3">
                                <a class="block block-rounded block-bordered block-link-shadow" href="../Salas/">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="float-right mt-15 d-none d-sm-block">
                                            <i class="si si-envelope-open fa-2x text-elegance-light"></i>
                                        </div>
                                        <div class="font-size-h3 font-w600 text-elegance js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="15"><?php echo $totalSalas['total']; ?></div>
                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Salas</div>
                                    </div>
                                </a>
                            </div>


                            <div class="col-6 col-xl-3">
                                <a class="block block-rounded block-bordered block-link-shadow" href="../Usuarios/">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="float-right mt-15 d-none d-sm-block">
                                            <i class="si si-users fa-2x text-pulse"></i>
                                        </div>
                                        <div class="font-size-h3 font-w600 text-pulse js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="4252"><?php echo $totalUsuarios['total']; ?></div>
                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Usuarios</div>
                                    </div>
                                </a>
                            </div>

                            <!-- END Row #1 -->
                        </div>
                    <?php } else { ?>
                        <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                            <div class="col-6 col-xl-3">
                                <a class="block block-rounded block-bordered block-link-shadow" href="">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="float-right mt-15 d-none d-sm-block">
                                            <i class="si si-bag fa-2x text-primary-light"></i>
                                        </div>
                                        <div class="font-size-h3 font-w600 text-primary js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="1500"><?php echo $totalPedidos['total']; ?></div>
                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Pedidos</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-xl-3">
                                <a class="block block-rounded block-bordered block-link-shadow" href="">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="float-right mt-15 d-none d-sm-block">
                                            <i class="si si-wallet fa-2x text-earth-light"></i>
                                        </div>
                                        <div class="font-size-h3 font-w600 text-earth">S/<span data-toggle="countTo" data-speed="1000" data-to="780" class="js-count-to-enabled"><?php echo $totalVentas['total']; ?></span></div>
                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Total Ventas</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>




                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Ventas</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-center">
                            <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            <!-- Bars Chart Container -->
                            <canvas class="js-chartjs-bars chartjs-render-monitor" width="850" height="425" style="display: block; width: 850px; height: 425px;" id="sales-chart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- Fin Contenido -->

            <!-- Footer -->
            <?php require_once("../../views/MainFooter/MainFooter.php") ?>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->
        <?php require_once("../../views/MainJs/MainJs.php") ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="dashboard.js"></script>

    </body>



    </html>
<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>