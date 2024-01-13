<?php
class Presentacion extends Conectar
{

    public function insertarPresentacion($nombre)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO presentacion (nombre)VALUES (?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->execute();
    }


    public function listarPresentacion()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM presentacion WHERE es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPresentacionXId($id_presentacion)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM presentacion WHERE id_presentacion = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_presentacion);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarPresentacion($id_presentacion)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE presentacion set es_activo = 0,fecha_elimina= now()
         WHERE id_presentacion = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_presentacion);
        $sql->execute();
    }
    public function actualizarPresentacion($id_presentacion, $nombre)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE presentacion set 
        nombre = ?,
        fecha_modi= now()
         WHERE id_presentacion = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $id_presentacion);
        $sql->execute();
    }
}
