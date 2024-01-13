<?php
require_once("../../config/conexion.php");
$objeto = new Conectar();
$conexion = $objeto->Conexion();
//session_start();

if (isset($_GET['detalle'])) {
    $id = $_SESSION['id_usuario'];
    $datos = array();
    $detalle = $conexion->prepare("SELECT d.*, p.nombre, p.precio FROM temp_pedidos d INNER JOIN platos p ON d.producto_id = p.id_platos WHERE d.usuario_id = :id");
    $detalle->bindParam(':id', $id, PDO::PARAM_INT);
    $detalle->execute();

    while ($row = $detalle->fetch(PDO::FETCH_ASSOC)) {
        $data['id'] = $row['id'];
        $data['nombre'] = $row['nombre'];
        $data['cantidad'] = $row['cantidad'];
        $data['precio'] = $row['precio'];
        // $data['imagen'] = ($row['imagen'] == null) ? '../assets/img/default.png' : $row['imagen'];
        $data['total'] = $data['precio'] * $data['cantidad'];
        array_push($datos, $data);
    }

    echo json_encode($datos);
    die();
} else if (isset($_GET['delete_detalle'])) {
    $id_detalle = $_GET['id'];
    $query = $conexion->prepare("DELETE FROM temp_pedidos WHERE id = :id_detalle");
    $query->bindParam(':id_detalle', $id_detalle, PDO::PARAM_INT);
    $query->execute();

    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }

    echo $msg;
    die();
} else if (isset($_GET['detalle_cantidad'])) {
    $id_detalle = $_GET['id'];
    $cantidad = $_GET['cantidad'];
    $query = $conexion->prepare("UPDATE temp_pedidos SET cantidad = :cantidad WHERE id = :id_detalle");
    $query->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $query->bindParam(':id_detalle', $id_detalle, PDO::PARAM_INT);
    $query->execute();

    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }

    echo $msg;
    die();
} else if (isset($_GET['procesarPedido'])) {
    $id_sala = $_GET['id_sala'];
    $id_user = $_SESSION['id_usuario'];
    $mesa = $_GET['mesa'];
    $observacion = $_GET['observacion'];

    $consulta = $conexion->prepare("SELECT d.*, p.nombre FROM temp_pedidos d INNER JOIN platos p ON d.producto_id = p.id_platos WHERE d.usuario_id = :id_user");
    $consulta->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $consulta->execute();

    $total = 0;
    while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $total += $row['cantidad'] * $row['precio'];
    }

    $insertar = $conexion->prepare("INSERT INTO pedidos (sala_id, numero_mesa, total, observaciones, usuario_id) VALUES (:id_sala, :mesa, :total, :observacion, :id_user)");
    $insertar->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
    $insertar->bindParam(':mesa', $mesa, PDO::PARAM_INT);
    $insertar->bindParam(':total', $total);
    $insertar->bindParam(':observacion', $observacion);
    $insertar->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $insertar->execute();

    $id_pedido = $conexion->lastInsertId();

    if ($insertar) {
        $consulta = $conexion->prepare("SELECT d.*, p.nombre FROM temp_pedidos d INNER JOIN platos p ON d.producto_id = p.id_platos WHERE d.usuario_id = :id_user");
        $consulta->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $consulta->execute();

        while ($dato = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $nombre = $dato['nombre'];
            $cantidad = $dato['cantidad'];
            $precio = $dato['precio'];

            $insertarDet = $conexion->prepare("INSERT INTO detalle_pedidos (nombre, precio, cantidad, pedido_id) VALUES (:nombre, :precio, :cantidad, :id_pedido)");
            $insertarDet->bindParam(':nombre', $nombre);
            $insertarDet->bindParam(':precio', $precio);
            $insertarDet->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $insertarDet->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
            $insertarDet->execute();
        }

        if ($insertarDet) {
            $eliminar = $conexion->prepare("DELETE FROM temp_pedidos WHERE usuario_id = :id_user");
            $eliminar->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $eliminar->execute();

            $sala = $conexion->prepare("SELECT * FROM sala WHERE id_sala = :id_sala");
            $sala->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
            $sala->execute();

            $resultSala = $sala->fetch(PDO::FETCH_ASSOC);
            $msg = array('mensaje' => $resultSala['mesa']);
        }
    } else {
        $msg = array('mensaje' => 'error');
    }

    echo json_encode($msg);
    die();
} else if (isset($_GET['editarUsuario'])) {
    $idusuario = $_GET['id'];
    $sql = $conexion->prepare("SELECT * FROM usuario WHERE idusuario = :idusuario");
    $sql->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
    exit;
} else if (isset($_GET['editarProducto'])) {
    $id = $_GET['id'];
    $sql = $conexion->prepare("SELECT * FROM platos WHERE id_platos = :id");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
    exit;
} else if (isset($_GET['finalizarPedido'])) {
    $id_sala = $_GET['id_sala'];
    $id_user = $_SESSION['id_usuario'];
    $mesa = $_GET['mesa'];

    $insertar = $conexion->prepare("UPDATE pedidos SET estado=0 WHERE sala_id=:id_sala AND numero_mesa=:mesa AND estado=1 AND usuario_id=:id_user");
    $insertar->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
    $insertar->bindParam(':mesa', $mesa, PDO::PARAM_INT);
    $insertar->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $insertar->execute();

    if ($insertar) {
        $sala = $conexion->prepare("SELECT * FROM sala WHERE id_sala = :id_sala");
        $sala->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $sala->execute();

        $resultSala = $sala->fetch(PDO::FETCH_ASSOC);
        $msg = array('mensaje' => $resultSala['mesa']);
    } else {
        $msg = array('mensaje' => 'error');
    }

    echo json_encode($msg);
    die();
}

if (isset($_POST['regDetalle'])) {
    $id_producto = $_POST['id'];
    echo $id_producto;
    $id_user = $_SESSION['id_usuario'];

    $consulta = $conexion->prepare("SELECT * FROM temp_pedidos WHERE producto_id = :id_producto AND usuario_id = :id_user");
    $consulta->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $consulta->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $consulta->execute();

    $row = $consulta->fetch(PDO::FETCH_ASSOC);

    if (empty($row)) {
        $producto = $conexion->prepare("SELECT * FROM platos WHERE id_platos = :id_producto");
        $producto->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $producto->execute();

        $result = $producto->fetch(PDO::FETCH_ASSOC);
        $precio = $result['precio'];

        $query = $conexion->prepare("INSERT INTO temp_pedidos (cantidad, precio, producto_id, usuario_id) VALUES (1, :precio, :id_producto, :id_user)");
        $query->bindParam(':precio', $precio);
        $query->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $query->execute();

        if ($query) {
            $msg = "registrado";
        } else {
            $msg = "Error al ingresar";
        }
    } else {
        $nueva = $row['cantidad'] + 1;
        $query = $conexion->prepare("UPDATE temp_pedidos SET cantidad = :nueva WHERE producto_id = :id_producto AND usuario_id = :id_user");
        $query->bindParam(':nueva', $nueva, PDO::PARAM_INT);
        $query->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $query->execute();
        if ($query) {
            $msg = "registrado";
        } else {
            $msg = "Error al ingresar";
        }
    }
    ob_clean(); // Limpiar el búfer de salida
    echo json_encode($msg);
    die();
    
}
