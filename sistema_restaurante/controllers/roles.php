<?php
require_once("../config/conexion.php");
require_once("../models/Roles.php");

$rol = new Roles();

switch ($_GET["opcion"]) {
    case 'guardaryeditar':

        if (empty($_POST["id_roles"])) {
            var_dump($_POST);
            $rol->insertar_rol($_POST["nombres"]);
        } else {
            $rol->actualizar_rol($_POST["id_roles"], $_POST["nombres"]);
        }
        break;
    case 'listar':
        //var_dump($_POST);
        $datos = $rol->listar_rol();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_roles"] . ');" class="btn btn-info pelim "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_roles"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';

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
        $rol->eliminar_rol($_POST["id_roles"]);
        break;
    case 'mostrar':
        #var_dump($_POST);
        $datos = $rol->get_rol_x_id($_POST["id_roles"]);
        // print_r($datos);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_roles'] = $row['id_roles'];
                $output['nombre'] = $row['nombre'];
            }
            echo json_encode($output);
        }
        break;
}
