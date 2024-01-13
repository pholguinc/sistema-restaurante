<?php
require_once("../config/conexion.php");
require_once("../models/Mesas.php");

$mesa = new Mesas();

switch ($_GET["opcion"]) {

    case 'guardaryeditarMesas':
        if (empty($_POST["id_mesa"])) {
            $mesa->insertarMesa($_POST["nombreMesa"], $_POST["cbxPiso"], $_POST["capacidad"]);
        } else {
            $mesa->actualizarMesa($_POST["id_mesa"], $_POST["nombreMesa"], $_POST["cbxPiso"], $_POST["capacidad"]);
        }
        break;
    case 'listarMesas':
        //var_dump($_POST);
        $datos = $mesa->listarMesas();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre_mesa'];
            $sub_array[] = $row['capacidad'];
            $sub_array[] = $row['nombre_piso'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_mesa"] . ');" class="btn btn-info pelim "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_mesa"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';

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


    case 'eliminarMesa':
        #var_dump($_POST);
        $mesa->eliminarMesa($_POST["id_mesa"]);
        break;

    case 'mostrarMesa':
        //var_dump($_POST);
        $datos = $mesa->getMesaXId($_POST["id_mesa"]);
        // print_r($datos);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_mesa'] = $row['id_mesa'];
                $output['nombre'] = $row['nombre_mesa'];
                $output['capacidad'] = $row['capacidad'];
                $output['piso_id'] = $row['piso_id'];
                $output['nombre_piso'] = $row['nombre_piso'];
            }
            echo json_encode($output);
        }

        break;
    case 'comboPisos':
        $datos = $mesa->selectPisos();
        echo json_encode($datos);
        break;
}
