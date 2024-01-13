<?php
class Mesas extends Conectar
{

    public function insertarMesa($nombre, $piso, $capacidad)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO mesas (nombre_mesa,piso_id,capacidad)VALUES (?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $piso);
        $sql->bindValue(3, $capacidad);
        $sql->execute();
    }

    public function listarMesas()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT id_mesa, nombre_mesa, m.piso_id, p.nombre_piso, m.capacidad FROM mesas m INNER JOIN pisos p ON p.id_piso = m.piso_id WHERE m.es_activo =1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMesaXId($id_mesa)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT id_mesa, nombre_mesa, capacidad, m.piso_id as piso_id, p.nombre_piso as nombre_piso, m.capacidad FROM mesas m INNER JOIN pisos p ON p.id_piso = m.piso_id  WHERE id_mesa = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_mesa);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarMesa($id_mesa)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE mesas set es_activo = 0,fecha_elimina= now()
         WHERE id_mesa = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_mesa);
        $sql->execute();
    }

    public function actualizarMesa($id_mesa, $nombre, $piso, $capacidad)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE mesas set 
        nombre_mesa = ?,
        piso_id = ?,
        capacidad = ?,
        fecha_modi= now()
         WHERE id_mesa = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $piso);
        $sql->bindValue(3, $capacidad);
        $sql->bindValue(4, $id_mesa);
        $sql->execute();
    }
    public function selectPisos()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM pisos WHERE es_activo=1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
