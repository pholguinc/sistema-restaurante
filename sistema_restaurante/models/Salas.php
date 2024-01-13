<?php
class Salas extends Conectar
{

    public function insertarSala($nombre, $mesas)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO sala (nombre,mesa)VALUES (?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $mesas);
        $sql->execute();
    }

    public function listarSalas()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * from sala where estado = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSalaXId($id_sala)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM sala WHERE id_sala  = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_sala);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarSala($id_sala)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE sala set estado = 0;
         WHERE id_sala  = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_sala);
        $sql->execute();
    }

    public function actualizarSala($id_sala, $nombre, $mesas)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE sala set 
        nombre = ?,
        mesa = ?
        WHERE id_sala  = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $mesas);
        $sql->bindValue(3, $id_sala);
        $sql->execute();
    }
}
