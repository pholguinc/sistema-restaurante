<?php
require_once("../config/conexion.php");
require_once("../models/Productos.php");

$producto = new Productos();

switch ($_GET["opcion"]) {
    case 'guardarEditar':

        if (empty($_POST["id_productos"])) {

            $producto->insertarProductos($_POST["nombres"], $_POST["precio"], $_POST["cantidad"], $_POST["cbx_categoria"], $_POST["detalles"], $_POST["cbx_almacen"]);
        } else {
            $producto->actualizarProductos($_POST["id_productos"], $_POST["nombres"], $_POST["precio"], $_POST["cantidad"], $_POST["cbx_categoria"], $_POST["detalles"], $_POST["cbx_almacen"]);
        }
        break;

    case 'listar':
        //var_dump($_POST);
        $datos = $producto->listarProductos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombre'];
            $sub_array[] = $row['precio'];
            $sub_array[] = $row['cantidad'];
            $sub_array[] = $row['nombre_categoria'];
            $sub_array[] = $row['nombre_almacen'];
            $sub_array[] = $row['detalles'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_productos"] . ');" class="btn btn-info pelim"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_productos"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';


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
        $producto->eliminarProductos($_POST["id_productos"]);
        break;
    case 'mostrar':
        $datos = $producto->getProductoXId($_POST["id_productos"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_productos'] = $row['id_productos'];
                $output['nombre'] = $row['nombre'];
                $output['cantidad'] = $row['cantidad'];
                $output['precio'] = $row['precio'];
                $output['categoria_id'] = $row['categoria_id'];
                $output['nombre_categoria'] = $row['nombre_categoria'];
                $output['detalles'] = $row['detalles'];
                $output['almacen_id'] = $row['almacen_id'];
                $output['nombre_almacen'] = $row['nombre_almacen'];
            }
            echo json_encode($output);
        }

        break;
    case 'comboCategoria':
        $datos = $producto->getCategoria();
        echo json_encode($datos);
        break;
    case 'comboAlmacen':
        $datos = $producto->getAlmacen();
        echo json_encode($datos);
        break;
}
