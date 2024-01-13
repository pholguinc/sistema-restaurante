<?php
require_once("../../config/conexion.php");

$idUsuario = $_SESSION["id_usuario"];
$conexion = new Conectar();
$conectar = $conexion->Conexion();
$sql = "SELECT ru.rol_id from roles_usuario ru INNER JOIN usuarios u on u.id_usuario = ru.usuario_id
    WHERE ru.usuario_id = $idUsuario";
$statement = $conectar->prepare($sql);
$statement->execute();
$resultado = $statement->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION["id_usuario"]) || $resultado["rol_id"] == 1 || $resultado["rol_id"] == 3) {
    $objeto = new Conectar();
    $conexion = $objeto->Conexion();

    $sql = "SELECT SUM(total) as total_ventas FROM pedidos WHERE estado = 0 AND DATE(fecha) = CURDATE()";
    $query = $conexion->query($sql);
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    // $resultado = isset($['total_ventas']) ? number_format($['total_ventas'], 2, '.', '') : '0.00';





?>
    <!doctype html>
    <meta lang="es">

    <head>
        <?php require_once("../../views/MainHead/MainHead.php") ?>
        <title>Sistema Restaurante </title>

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
                    <?php if ($_SESSION["rol_id"] == 1) { ?>
                        <div class="card-body mb-5">
                            <div class="row" id="">

                                <div class="col-8 bg-white d-flex align-items-center">
                                    <h2 style="text-transform: uppercase; font-weight: bold; text-align: start;">ventas del dia: S/ <?php echo $resultado["total_ventas"] ?></h2>
                                </div>

                                <div class="col-4 bg-white d-flex justify-content-between  align-items-center">
                                    <button class="btn btn-primary btn-flat"> <a href="listaVentas.php" style="color: white;">Historial Ventas</a></button>
                                    <button class="btn btn-success btn-flat"> <a href="../Salas/" style="color: white;">Salas</a></button>
                                    <button class="btn btn-info btn-flat"> <a href="../Platos/" style="color: white;">Platos</a></button>
                                </div>

                            </div>

                        </div>
                    <?php } ?>
                    <div class="">
                        <div class="card-header text-center p-5">

                        </div>
                        <div class="card-body">
                            <p style="text-transform: uppercase; font-weight: bold; color: black; text-align: center; font-size: 25px;">Salas</p>
                            <div class="row" id="salaContainer">

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