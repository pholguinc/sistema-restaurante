<?php
class Pisos extends Conectar
{

    public function insertarPiso($nombres, $descripcion)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO pisos (nombre_piso, descripcion)VALUES (?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $descripcion);
        $sql->execute();
    }



    public function listarPisos()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM pisos WHERE es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPisosXId($id_piso)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM pisos WHERE id_piso = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_piso);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    public function eliminarPiso($id_piso)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE pisos set es_activo = 0,fecha_elimina= now()
         WHERE id_piso = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_piso);
        $sql->execute();
    }


    public function actualizarPiso($id_piso, $nombre, $descripcion)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE pisos set 
        nombre_piso = ?,
        descripcion = ?,
        fecha_modi= now()
         WHERE id_piso = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $descripcion);
        $sql->bindValue(3, $id_piso);
        $sql->execute();
    }
}
