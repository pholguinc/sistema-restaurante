<?php
require_once("../../config/conexion.php");
if ($_SESSION["rol_id"] == 1) {

?>

    <!-- Side Navigation -->



    <div class="content-side content-side-full">
        <ul class="nav-main">
            <li>
                <a href="../Dashboard/"><i class="si si-compass"></i><span class="sidebar-mini-hide">Dashboard </span></a>
            </li>
            <li>
                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-cup"></i><span class="sidebar-mini-hide">Gestion de inventario</span></a>
                <ul>
                    <li>
                        <a href="../Productos/">Productos</a>
                    </li>
                    <li>
                        <a href="../Insumos/">Insumos</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="../Almacen/"><i class="si si-compass"></i><span class="sidebar-mini-hide">Gestion de almacen</span></a>
            </li>


            <li>
                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-cup"></i><span class="sidebar-mini-hide">Gestion de ventas</span></a>

                <ul>
                    <li>
                        <a href="../Caja/">Caja</a>
                    </li>
                    <li>
                        <a href="../Mosos/">Mosos</a>
                    </li>

                </ul>
            </li>

            <li>
                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-cup"></i><span class="sidebar-mini-hide">Gestion de personal</span></a>

                <ul>
                    <li>
                        <a href="../Clientes/">Clientes</a>
                    </li>
                    <li>
                        <a href="../Empleados/">Empleados</a>
                    </li>
                    <li>
                        <a href="../AsignarRoles/">Asignar Roles</a>
                    </li>
                    <li>
                        <a href="../Usuarios/">Usuarios</a>
                    </li>
                </ul>
            </li>



            <li>
                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-cup"></i><span class="sidebar-mini-hide">Configuración</span></a>

                <ul>
                    <li>
                        <a href="../Categorias/">Categorias</a>
                    </li>

                    <li>
                        <a href="../Platos/">Platos</a>
                    </li>


                    <li>
                        <a href="../Salas/">Salas</a>
                    </li>
                    <li>
                        <a href="../Roles/">Roles</a>
                    </li>
                    <li>
                        <a href="../Proveedores/">Proveedores</a>
                    </li>
                    <li>
                        <a href="../Presentacion/">Presentación</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>

    <!-- END Side Navigation -->
<?php
} ?>

<?php if ($_SESSION["rol_id"] == 3) { ?>
    <div class="content-side content-side-full">
        <ul class="nav-main">
            <li>
                <a href="../Dashboard/"><i class="si si-compass"></i><span class="sidebar-mini-hide">Dashboard </span></a>
            </li>
            <li>
                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-cup"></i><span class="sidebar-mini-hide">Gestion de ventas</span></a>

                <ul>
                    <li>
                        <a href="../Caja/">Ventas</a>
                    </li>
                   

                </ul>
            </li>
            <li>
                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-cup"></i><span class="sidebar-mini-hide">Configuración</span></a>

                <ul>
                    <li>
                        <a href="../Categorias/">Categorias</a>
                    </li>

                    <li>
                        <a href="../Platos/">Platos</a>
                    </li>


                    <!-- <li>
                        <a href="../Salas/">Salas</a>
                    </li>
                    <li>
                        <a href="../Roles/">Roles</a>
                    </li>
                    <li>
                        <a href="../Proveedores/">Proveedores</a>
                    </li>
                    <li>
                        <a href="../Presentacion/">Presentación</a>
                    </li> -->
                </ul>
            </li>

        </ul>
    </div>


<?php } 

// else { 
//     header("Location:" . Conectar::ruta() . "index.php");
// }
