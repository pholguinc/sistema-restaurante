<?php
require_once("../config/conexion.php");
require_once("../models/Insumos.php");

$insumo = new Insumos();

switch ($_GET["opcion"]) {
    case 'guardarEditar':

        if (empty($_POST["id_insumos"])) {

            $insumo->insertarInsumos($_POST["nombres"], $_POST["cantidad"], $_POST["precio"], $_POST["descripcion"], $_POST["cbx_presentacion"], $_POST["cbx_almacen"], $_POST["cbx_proveedor"]);
        } else {
            $insumo->actualizarInsumos($_POST["id_insumos"], $_POST["nombres"], $_POST["cantidad"], $_POST["precio"], $_POST["descripcion"], $_POST["cbx_presentacion"], $_POST["cbx_almacen"], $_POST["cbx_proveedor"]);
        }
        break;

    case 'listar':
        //var_dump($_POST);
        $datos = $insumo->listarInsumos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre'];
            $sub_array[] = $row['cantidad'];
            $sub_array[] = $row['precio_unitario'];
            $sub_array[] = $row['nombre_presentacion'];
            $sub_array[] = $row['nombre_almacen'];
            $sub_array[] = $row['nombre_proveedor'];
            $sub_array[] = $row['descripcion'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_insumos"] . ');" class="btn btn-info pelim"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_insumos"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';


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
        $insumo->eliminarInsumos($_POST["id_insumos"]);
        break;
    case 'mostrar':
        $datos = $insumo->getInsumosXId($_POST["id_insumos"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_insumos'] = $row['id_insumos'];
                $output['nombre'] = $row['nombre'];
                $output['cantidad'] = $row['cantidad'];
                $output['precio_unitario'] = $row['precio_unitario'];
                $output['presentacion_id'] = $row['presentacion_id'];
                $output['nombre_presentacion'] = $row['nombre_presentacion'];
                $output['almacen_id'] = $row['almacen_id'];
                $output['nombre_almacen'] = $row['nombre_almacen'];
                $output['proveedor_id'] = $row['proveedor_id'];
                $output['nombre_proveedor'] = $row['nombre_proveedor'];
                $output['descripcion'] = $row['descripcion'];
            }
            echo json_encode($output);
        }
        break;
    case 'comboPresentacion':
        $datos = $insumo->getPresentacion();
        echo json_encode($datos);
        break;
    case 'comboAlmacen':
        $datos = $insumo->getAlmacen();
        echo json_encode($datos);
        break;
    case 'comboProveedor':
        $datos = $insumo->getProveedor();
        echo json_encode($datos);
        break;
}
