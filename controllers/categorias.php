<?php
require_once("../config/conexion.php");
require_once("../models/Categorias.php");

$categoria = new Categorias();

switch ($_GET["opcion"]) {
    case 'guardaryeditar':
        if (empty($_POST["id_categoria"])) {

            $categoria->insertarCategoria($_POST["nombres"]);
        } else {
            $categoria->actualizarCategoria($_POST["id_categoria"], $_POST["nombres"]);
        }
        break;
    case 'listar':
        //var_dump($_POST);
        $datos = $categoria->listarCategoria();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_categoria"] . ');" class="btn btn-info pelim "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_categoria"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';

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
        $categoria->eliminarCategoria($_POST["id_categoria"]);
        break;
    case 'mostrar':
        #var_dump($_POST);
        $datos = $categoria->getCategoriaXId($_POST["id_categoria"]);
        // print_r($datos);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_categoria'] = $row['id_categoria'];
                $output['nombre'] = $row['nombre'];
            }
            echo json_encode($output);
        }

        break;
}
