<?php
class Productos extends Conectar
{

    public function insertarProductos($nombre, $precio, $cantidad, $categoria, $detalles, $almacen)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO productos (nombre,precio,cantidad,categoria_id,detalles,almacen_id)VALUES (?,?,?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $precio);
        $sql->bindValue(3, $cantidad);
        $sql->bindValue(4, $categoria);
        $sql->bindValue(5, $detalles);
        $sql->bindValue(6, $almacen);
        if ($sql->execute()) {
            $ultimo_id = $conectar->lastInsertId();
            $sql1 = "SELECT id_productos,a.id_almacen,i.cantidad FROM productos i INNER JOIN almacen a 
            ON a.id_almacen = i.almacen_id WHERE id_productos = ?";
            $sql1 = $conectar->prepare($sql1);
            $sql1->bindValue(1, $ultimo_id);
            $sql1->execute();
            $resultado = $sql1->fetch(PDO::FETCH_ASSOC);

            $sqlAlmacen = "INSERT INTO inventario (almacen_id,productos_id,cantidad) values(?,?,?)";
            $sqlAlmacen = $conectar->prepare($sqlAlmacen);
            $sqlAlmacen->bindValue(1, $resultado["id_almacen"]);
            $sqlAlmacen->bindValue(2, $resultado["id_productos"]);
            $sqlAlmacen->bindValue(3, $resultado["cantidad"]);
            $sqlAlmacen->execute();
        }
    }
    public function listarProductos()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT p.id_productos,p.nombre, p.precio,p.cantidad, p.categoria_id,c.nombre as nombre_categoria,p.detalles,p.almacen_id, a.nombre as nombre_almacen FROM productos p INNER JOIN categoria c on c.id_categoria = p.categoria_id
        INNER JOIN almacen a on a.id_almacen = p.almacen_id WHERE p.es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }
    public function getProductoXId($id_productos)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT p.id_productos,p.nombre, p.precio,p.cantidad, p.categoria_id,c.nombre as nombre_categoria,p.detalles,p.almacen_id, a.nombre as nombre_almacen FROM productos p INNER JOIN categoria c on c.id_categoria = p.categoria_id
        INNER JOIN almacen a on a.id_almacen = p.almacen_id WHERE id_productos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_productos);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function eliminarProductos($id_productos)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE productos set es_activo = 0,fecha_elimina= now()
         WHERE id_productos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_productos);
        $sql->execute();
    }
    public function actualizarProductos($id_productos, $nombre, $precio, $cantidad, $categoria, $detalles, $almacen)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE productos set 
        nombre = ?,
        precio = ?,
        cantidad = ?,
        categoria_id = ?,
        detalles = ?,
        almacen_id = ?,
        fecha_modi= now()
         WHERE id_productos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $precio);
        $sql->bindValue(3, $cantidad);
        $sql->bindValue(4, $categoria);
        $sql->bindValue(5, $detalles);
        $sql->bindValue(6, $almacen);
        $sql->bindValue(7, $id_productos);
        $sql->execute();
    }

    public function getCategoria()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM categoria WHERE es_activo=1";
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
}
