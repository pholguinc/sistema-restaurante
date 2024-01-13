<?php
require_once("../config/conexion.php");
require_once("../models/Proveedores.php");

$proveedor = new Proveedores();

switch ($_GET["opcion"]) {
    case 'guardarEditar':
        //var_dump($_POST);
        if (empty($_POST["id_proveedor"])) {

            $proveedor->insertarProveedores($_POST["nombres"], $_POST["direccion"], $_POST["correo"], $_POST["telefono"]);
        } else {
            $proveedor->actualizarProveedor($_POST["id_proveedor"], $_POST["nombres"], $_POST["direccion"], $_POST["correo"], $_POST["telefono"]);
        }
        break;

    case 'listar':
        //var_dump($_POST);
        $datos = $proveedor->listarProveedores();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre'];
            $sub_array[] = $row['direccion'];
            $sub_array[] = $row['correo'];
            $sub_array[] = $row['telefono'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_proveedor"] . ');" class="btn btn-info pelim"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_proveedor"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';


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

    case 'eliminar':
        $proveedor->eliminarProveedor($_POST["id_proveedor"]);
        break;
    case 'mostrar':
        $datos = $proveedor->getProveedorXId($_POST["id_proveedor"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_proveedor'] = $row['id_proveedor'];
                $output['nombres'] = $row['nombre'];
                $output['direccion'] = $row['direccion'];
                $output['correo'] = $row['correo'];
                $output['telefono'] = $row['telefono'];
            }
            echo json_encode($output);
        }

        break;
}
