<?php
class Roles extends Conectar
{

    public function insertar_rol($nombre)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO roles(nombre)VALUES (?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->execute();
    }


    public function listar_rol()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM roles WHERE es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_rol_x_id($id_rol)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM roles WHERE id_roles = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_rol);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar_rol($id_rol)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE roles set es_activo = 0,fecha_elimina= now()
         WHERE id_roles = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_rol);
        $sql->execute();
    }
    public function actualizar_rol($id_rol, $nombre)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE roles set 
        nombre = ?,
        fecha_modi= now()
         WHERE id_roles = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $id_rol);
        $sql->execute();
    }
}
