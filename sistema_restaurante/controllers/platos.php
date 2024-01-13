<?php
require_once("../config/conexion.php");
require_once("../models/Platos.php");

$platos = new Platos();

switch ($_GET["opcion"]) {
    case 'guardaryeditar':
        if (empty($_POST["id_platos"])) {

            $platos->insertarPlatos($_POST["nombres"], $_POST["precio"], $_POST["cbx_categoria"]);
        } else {
            $platos->actualizarPlatos($_POST["id_platos"], $_POST["nombres"], $_POST["precio"], $_POST["cbx_categoria"]);
        }
        break;
    case 'listar':
        //var_dump($_POST);
        $datos = $platos->listarPlatos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre_plato'];
            $sub_array[] = $row['precio'];
            $sub_array[] = $row['nombre_categoria'];
            $disponibilidad = ($row["disponible"] == 1) ? "Disponible" : "No Disponible";
            $claseBadge = ($row["disponible"] == 1) ? "badge-success" : "badge-danger";
            $sub_array[] = '<span id="spanEstado" class="badge ' . $claseBadge . '">' . $disponibilidad . '</span>';
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_platos"] . ');" class="btn btn-info pelim "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button type="button" id ="btnCambiar" onclick="cambiarEstado(' . $row["id_platos"] . ');" class="btn btn-secondary pelim js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="Cambiar estado" style = "background-color:green; color:white;"><i class="fa fa-random" aria-hidden="true"></i></button>
            <button type="button" onclick="eliminar(' . $row["id_platos"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';

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
        $platos->eliminarPlatos($_POST["id_platos"]);
        break;
    case 'mostrar':
        #var_dump($_POST);
        $datos = $platos->getPlatosXId($_POST["id_platos"]);

        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_platos'] = $row['id_platos'];
                $output['nombre'] = $row['nombre_plato'];
                $output['precio'] = $row['precio'];
                $output['id_categoria'] = $row['id_categoria'];
                $output['nombre_categoria'] = $row['nombre_categoria'];
            }
            echo json_encode($output);
        }
        break;
    case 'comboCategoria':
        $datos = $platos->getCategoria();
        echo json_encode($datos);
        break;
    case 'cambiarEstado':
        $platos->actualizarEstado($_POST["id_platos"]);
        break;
}
