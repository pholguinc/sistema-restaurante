<?php
require_once("../config/conexion.php");
require_once("../models/Clientes.php");

$cliente = new Clientes();

switch ($_GET["opcion"]) {
    case 'guardarEditar':

        if (empty($_POST["id_clientes"])) {

            $cliente->insertarClientes($_POST["nombres"], $_POST["apellidos"], $_POST["direccion"], $_POST["telefono"]);
        } else {
            $cliente->actualizarClientes($_POST["id_clientes"], $_POST["nombres"], $_POST["apellidos"], $_POST["direccion"], $_POST["telefono"]);
        }
        break;

    case 'listar':
        //var_dump($_POST);
        $datos = $cliente->listarClientes();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombres'];
            $sub_array[] = $row['apellidos'];
            $sub_array[] = $row['direccion'];
            $sub_array[] = $row['telefono'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_clientes"] . ');" class="btn btn-info pelim"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_clientes"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';


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
        $cliente->eliminarClientes($_POST["id_clientes"]);
        break;
    case 'mostrar':
        $datos = $cliente->getClienteXId($_POST["id_clientes"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_clientes'] = $row['id_clientes'];
                $output['nombres'] = $row['nombres'];
                $output['apellidos'] = $row['apellidos'];
                $output['direccion'] = $row['direccion'];
                $output['telefono'] = $row['telefono'];
            }
            echo json_encode($output);
        }

        break;
}
