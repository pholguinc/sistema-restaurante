<?php
require_once("../config/conexion.php");
require_once("../models/Usuarios.php");

$usuario = new Usuario();

switch ($_GET["opcion"]) {
    case 'guardaryeditar':
        //ar_dump($_POST);
        if (empty($_POST["id_usuario"])) {

            $usuario->insertarUsuarios( $_POST["nombreUsu"], $_POST["password"],$_POST["cdx_empleado"],);
        } else {
            $usuario->actualizarUsuario($_POST["id_usuario"], $_POST["nombreUsu"], $_POST["cdx_empleado"]);
        }
        break;
    case 'listar':
        //var_dump($_POST);
        $datos = $usuario->listarUsuarios();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            // $sub_array[] = $row['empleado_id'];
            $sub_array[] = $row['nombreCompleto'];
            $sub_array[] = $row['nombre_usuario'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_usuario"] . ');" class="btn btn-info pelim "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_usuario"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';

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
        $usuario->eliminarUsuario($_POST["id_usuario"]);
        break;
    case 'mostrar':
        #var_dump($_POST);
        $datos = $usuario->getUsuarioXId($_POST["id_usuario"]);
        // print_r($datos);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_usuario'] = $row['id_usuario'];
                $output['nombre_usuario'] = $row['nombre_usuario'];
                $output['empleado_id'] = $row['empleado_id'];
                $output['nombres'] = $row['nombres'];
            }
            echo json_encode($output);
        }
        break;

    case 'comboEmpleado':
        $datos = $usuario->getEmpleado();
        echo json_encode($datos);
        break;
}
