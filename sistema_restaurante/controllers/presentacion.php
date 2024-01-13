<?php
require_once("../config/conexion.php");
require_once("../models/Presentacion.php");

$presentacion = new Presentacion();

switch ($_GET["opcion"]) {
    case 'guardaryeditar':
        var_dump($_POST);
        if (empty($_POST["id_presentacion"])) {

            $presentacion->insertarPresentacion($_POST["nombres"]);
        } else {
            $presentacion->actualizarPresentacion($_POST["id_presentacion"], $_POST["nombres"]);
        }
        break;
    case 'listar':
        //var_dump($_POST);
        $datos = $presentacion->listarPresentacion();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_presentacion"] . ');" class="btn btn-info pelim "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_presentacion"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';

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
        #var_dump($_POST);
        $presentacion->eliminarPresentacion($_POST["id_presentacion"]);
        break;
    case 'mostrar':
        #var_dump($_POST);
        $datos = $presentacion->getPresentacionXId($_POST["id_presentacion"]);
        // print_r($datos);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_presentacion'] = $row['id_presentacion'];
                $output['nombre'] = $row['nombre'];
            }
            echo json_encode($output);
        }

        break;
}
