<?php
require_once("../config/conexion.php");
require_once("../models/Empleados.php");

$empleado = new Empleados();

switch ($_GET["opcion"]) {
    case 'guardarEditar':

        if (empty($_POST["id_empleado"])) {

            $empleado->insertarEmpleados($_POST["nombres"], $_POST["apellidos"], $_POST["dni"], $_POST["correo"], $_POST["telefono"]);
        } else {
            $empleado->actualizarEmpleados($_POST["id_empleado"], $_POST["nombres"], $_POST["apellidos"], $_POST["dni"], $_POST["correo"], $_POST["telefono"]);
        }
        break;

    case 'listar':
        //var_dump($_POST);
        $datos = $empleado->listarEmpleados();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['nombres'];
            $sub_array[] = $row['apellidos'];
            $sub_array[] = $row['dni'];
            $sub_array[] = $row['correo'];
            $sub_array[] = $row['telefono'];
            $sub_array[] = '<button type="button" id ="btnEditar" onclick="editar(' . $row["id_empleado"] . ');" class="btn btn-info pelim"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" onclick="eliminar(' . $row["id_empleado"] . ');" class="btn btn-danger pelim"><i class="fa fa-trash" aria-hidden="true"></i></button>';


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
        $empleado->eliminarEmpleados($_POST["id_empleado"]);
        break;
    case 'mostrar':
        //var_dump($_POST);
        $datos = $empleado->getEmpleadoXId($_POST["id_empleado"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output['id_empleado'] = $row['id_empleado'];
                $output['nombres'] = $row['nombres'];
                $output['apellidos'] = $row['apellidos'];
                $output['dni'] = $row['dni'];
                $output['correo'] = $row['correo'];
                $output['telefono'] = $row['telefono'];
              
            }
            echo json_encode($output);
        }
        break;
  
}
