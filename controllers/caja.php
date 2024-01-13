<?php
require_once("../config/conexion.php");
require_once("../models/Caja.php");

$caja = new Caja();

switch ($_GET["opcion"]) {

    case 'mostrar':
        #var_dump($_POST);
        $datos = $caja->getPisosConMesas();
        echo json_encode($datos);
        break;
    case 'cargarMesas':
       $datosMesas = $caja->getSalaMesas();
        echo json_encode($datosMesas);
        break;
}
