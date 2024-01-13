<?php
class Insumos extends Conectar
{

    public function insertarInsumos($nombre, $cantidad, $precio, $descripcion, $presentacion, $almacen, $proveedor)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO insumos (nombre,cantidad,precio_unitario,descripcion,presentacion_id,almacen_id,proveedor_id)VALUES (?,?,?,?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $cantidad);
        $sql->bindValue(3, $precio);
        $sql->bindValue(4, $descripcion);
        $sql->bindValue(5, $presentacion);
        $sql->bindValue(6, $almacen);
        $sql->bindValue(7, $proveedor);
        if ($sql->execute()) {
            $ultimo_id = $conectar->lastInsertId();
            $sql1 = "SELECT id_insumos,a.id_almacen,i.cantidad FROM insumos i INNER JOIN almacen a 
            ON a.id_almacen = i.almacen_id WHERE id_insumos = ?";
            $sql1 = $conectar->prepare($sql1);
            $sql1->bindValue(1, $ultimo_id);
            $sql1->execute();
            $resultado = $sql1->fetch(PDO::FETCH_ASSOC);

            $sqlAlmacen = "INSERT INTO inventario (almacen_id,insumos_id,cantidad) values(?,?,?)";
            $sqlAlmacen = $conectar->prepare($sqlAlmacen);
            $sqlAlmacen->bindValue(1, $resultado["id_almacen"]);
            $sqlAlmacen->bindValue(2, $resultado["id_insumos"]);
            $sqlAlmacen->bindValue(3, $resultado["cantidad"]);
            $sqlAlmacen->execute();
        }
    }
    public function listarInsumos()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT i.id_insumos,i.nombre,i.cantidad,i.precio_unitario,i.descripcion,i.presentacion_id, p.nombre as nombre_presentacion,i.almacen_id,a.nombre as nombre_almacen,i.proveedor_id,pro.nombre as nombre_proveedor FROM insumos i INNER JOIN presentacion p on p.id_presentacion = i.presentacion_id
        INNER JOIN almacen a on a.id_almacen = i.almacen_id
        INNER JOIN proveedores pro ON pro.id_proveedor = i.proveedor_id
        WHERE i.es_activo = 1;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }
    public function getInsumosXId($id_insumos)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT i.id_insumos,i.nombre,i.cantidad,i.precio_unitario,i.descripcion,i.presentacion_id, p.nombre as nombre_presentacion,i.almacen_id,a.nombre as nombre_almacen,i.proveedor_id,pro.nombre as nombre_proveedor FROM insumos i INNER JOIN presentacion p on p.id_presentacion = i.presentacion_id
        INNER JOIN almacen a on a.id_almacen = i.almacen_id
        INNER JOIN proveedores pro ON pro.id_proveedor = i.proveedor_id WHERE id_insumos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_insumos);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function eliminarInsumos($id_insumos)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE insumos set es_activo = 0,fecha_elimina= now()
         WHERE id_insumos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_insumos);
        $sql->execute();
    }
    public function actualizarInsumos($id_insumos, $nombre, $cantidad, $precio, $descripcion, $presentacion, $almacen, $proveedor)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE insumos set 
        nombre = ?,
        cantidad = ?,
        precio_unitario = ?,
        descripcion = ?,
        presentacion_id = ?,
        almacen_id = ?,
        proveedor_id = ?,
        fecha_modi= now()
        WHERE id_insumos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $cantidad);
        $sql->bindValue(3, $precio);
        $sql->bindValue(4, $descripcion);
        $sql->bindValue(5, $presentacion);
        $sql->bindValue(6, $almacen);
        $sql->bindValue(7, $proveedor);
        $sql->bindValue(8, $id_insumos);
        $sql->execute();
    }

    public function getPresentacion()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM presentacion WHERE es_activo=1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAlmacen()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM almacen WHERE es_activo=1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProveedor()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM proveedores WHERE es_activo=1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
