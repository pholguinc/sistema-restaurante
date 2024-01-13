<?php
require_once("../config/conexion.php");
require_once("../models/Pisos.php");

$piso = new Pisos();

switch ($_GET["opcion"]) {
    case 'guardaryeditar':
        if (empty($_POST["id_pisos"])) {

            $piso->insertarPiso($_POST["nombrPiso"], $_POST["descripcionPiso"]);
        } else {
            $piso->actualizarPiso($_POST["id_pisos"], $_POST["nombrPiso"], $_POST["descripcionPiso"]);
        }
        break;

    case 'listar':
        //var_dump($_POST);
        $datos = $piso->listarPisos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre_piso'];
            $sub_array[] = $row['descripcion'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_piso"] . ');" class="btn btn-info pelim "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_piso"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';

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
        $piso->eliminarPiso($_POST["id_pisos"]);
        break;

    case 'mostrar':
        #var_dump($_POST);
        $datos = $piso->getPisosXId($_POST["id_pisos"]);
        // print_r($datos);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_piso'] = $row['id_piso'];
                $output['nombre'] = $row['nombre_piso'];
                $output['descripcion'] = $row['descripcion'];
            }
            echo json_encode($output);
        }

        break;
}
