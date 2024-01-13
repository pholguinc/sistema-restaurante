<?php
require_once("../config/conexion.php");
require_once("../models/Salas.php");

$sala = new Salas();

switch ($_GET["opcion"]) {
    case 'guardaryeditar':
        var_dump($_POST);
        if (empty($_POST["id_sala"])) {
            //var_dump($_POST);
            $sala->insertarSala($_POST["nombres"], $_POST["mesas"]);
        } else {
            $sala->actualizarSala($_POST["id_sala"], $_POST["nombres"], $_POST["mesas"]);
        }
        break;
    case 'listar':
        //var_dump($_POST);
        $datos = $sala->listarSalas();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre'];
            $sub_array[] = $row['mesa'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_sala"] . ');" class="btn btn-info pelim "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_sala"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';

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
        $sala->eliminarSala($_POST["id_sala"]);
        break;
    case 'mostrar':
        $datos = $sala->getSalaXId($_POST["id_sala"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_sala'] = $row['id_sala'];
                $output['nombre'] = $row['nombre'];
                $output['mesa'] = $row['mesa'];
            }
            echo json_encode($output);
        }
        break;
   
}
