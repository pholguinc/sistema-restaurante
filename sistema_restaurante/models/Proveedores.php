<?php
class Proveedores extends Conectar
{

    public function insertarProveedores($nombre, $direccion, $correo, $telefono)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO proveedores (nombre,direccion,correo,telefono)VALUES (?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $direccion);
        $sql->bindValue(3, $correo);
        $sql->bindValue(4, $telefono);
        $sql->execute();
    }
    public function listarProveedores()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM proveedores WHERE es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }
    public function getProveedorXId($id_proveedor)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM proveedores WHERE id_proveedor = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_proveedor);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function eliminarProveedor($id_proveedor)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE proveedores set es_activo = 0,fecha_elimina= now()
         WHERE id_proveedor = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_proveedor);
        $sql->execute();
    }
    public function actualizarProveedor($id_proveedor, $nombres, $direccion, $correo, $telefono)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE proveedores set 
        nombre = ?,
        direccion = ?,
        correo = ?,
        telefono = ?,
        fecha_modi= now()
         WHERE id_proveedor = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $direccion);
        $sql->bindValue(3, $correo);
        $sql->bindValue(4, $telefono);
        $sql->bindValue(5, $id_proveedor);
        $sql->execute();
    }
}
