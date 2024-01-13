<?php
require_once("../config/conexion.php");
require_once("../models/Almacen.php");

$almacen = new Almacen();

switch ($_GET["opcion"]) {
    case 'listar':
        //var_dump($_POST);
        $datos = $almacen->listarAlmacen();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre_almacen'];
            $sub_array[] = $row['nombre_insumo'];
            $sub_array[] = $row['nombre_producto'];
            $sub_array[] = $row['cantidad'];
            $data[] = $sub_array;
        }
        $resultado = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($resultado);
        break;
}
