<?php
class Clientes extends Conectar
{

    public function insertarClientes($nombres, $apellidos, $direccion, $telefono)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO clientes (nombres,apellidos,direccion,telefono)VALUES (?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $apellidos);
        $sql->bindValue(3, $direccion);
        $sql->bindValue(4, $telefono);
        $sql->execute();
    }
    public function listarClientes()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM clientes WHERE es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }
    public function getClienteXId($idCliente)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM clientes WHERE id_clientes = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idCliente);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function eliminarClientes($idCliente)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE clientes set es_activo = 0,fecha_elimina= now()
         WHERE id_clientes = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idCliente);
        $sql->execute();
    }
    public function actualizarClientes($idCliente, $nombres, $apellidos, $direccion, $telefono)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE clientes set 
        nombres = ?,
        apellidos = ?,
        direccion = ?,
        telefono = ?,
        fecha_modi= now()
         WHERE id_clientes = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $apellidos);
        $sql->bindValue(3, $direccion);
        $sql->bindValue(4, $telefono);
        $sql->bindValue(5, $idCliente);
        $sql->execute();
    }
}
