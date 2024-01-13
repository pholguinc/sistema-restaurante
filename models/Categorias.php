<?php
class Categorias extends Conectar
{

    public function insertarCategoria($nombres)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO categoria (nombre)VALUES (?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->execute();
    }


    public function listarCategoria()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM categoria WHERE es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategoriaXId($id_categoria)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM categoria WHERE id_categoria = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_categoria);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarCategoria($id_categoria)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE categoria set es_activo = 0,fecha_elimina= now()
         WHERE id_categoria = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_categoria);
        $sql->execute();
    }
    public function actualizarCategoria($id_categoria, $nombres)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE categoria set 
        nombre = ?,
        fecha_modi= now()
         WHERE id_categoria = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $id_categoria);
        $sql->execute();
    }
}
