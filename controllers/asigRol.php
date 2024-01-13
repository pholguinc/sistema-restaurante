<?php
require_once("../config/conexion.php");
require_once("../models/AsigRol.php");

$asig = new Asignar();

switch ($_GET["opcion"]) {
    case 'guardarEditar':
        //var_dump($_POST);
        if (empty($_POST["id_rol_usuario"])) {
            $asig->insertarRol($_POST["cdx_rol"], $_POST["cbx_usuario"]);
        } else {
            $asig->actualizarRol($_POST["id_rol_usuario"], $_POST["cbx_usuario"], $_POST["cdx_rol"]);
        }
        break;

    case 'listar':
        //var_dump($_POST);
        $datos = $asig->listarAsigRol();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombreEmpleado'];
            $sub_array[] = $row['nombre_usuario'];
            $sub_array[] = $row['nombre'];

            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_rol_usuario"] . ');" class="btn btn-info pelim"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_rol_usuario"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';


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
        $asig->eliminarAsigRol($_POST["id_rol_usuario"]);
        break;
    case 'mostrar':
        //var_dump($_POST);
        $datos = $asig->getRolUsuarioXId($_POST["id_rol_usuario"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_rol_usuario'] = $row['id_rol_usuario'];
                $output['id_usuario'] = $row['id_usuario'];
                $output['nombreEmpleado'] = $row['nombreEmpleado'];
                $output['rol_id'] = $row['rol_id'];
                $output['nombre'] = $row['nombre'];
            }
            echo json_encode($output);
        }
        break;
    case 'comboEmpleado':
        $datos = $asig->getUsuario();
        echo json_encode($datos);
        break;
    case 'comboRol':
        $datos = $asig->getRoles();
        echo json_encode($datos);
        break;
}
