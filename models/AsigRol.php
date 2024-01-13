<?php
class Asignar extends Conectar
{

    public function insertarRol($idRol, $idUsuario)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO roles_usuario (rol_id,usuario_id)VALUES (?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idRol);
        $sql->bindValue(2, $idUsuario);
        $sql->execute();
    }
    public function listarAsigRol()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT id_rol_usuario,CONCAT(e.nombres,' ', e.apellidos) as nombreEmpleado,u.id_usuario, u.nombre_usuario,ru.rol_id,r.nombre FROM `roles_usuario` ru INNER JOIN usuarios u on u.id_usuario = ru.usuario_id INNER JOIN empleados e on e.id_empleado = u.empleado_id INNER JOIN roles r ON r.id_roles = ru.rol_id WHERE ru.es_activo = 1;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }
    public function getRolUsuarioXId($idRolUsuario)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT id_rol_usuario, u.id_usuario, CONCAT(e.nombres,' ', e.apellidos) as nombreEmpleado, u.nombre_usuario,ru.rol_id,r.nombre FROM `roles_usuario` ru INNER JOIN usuarios u on u.id_usuario = ru.usuario_id INNER JOIN empleados e on e.id_empleado = u.empleado_id INNER JOIN roles r ON r.id_roles = ru.rol_id WHERE id_rol_usuario =? ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idRolUsuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function eliminarAsigRol($idRolUsuario)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE roles_usuario set es_activo = 0,fecha_elimina= now()
         WHERE id_rol_usuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idRolUsuario);
        $sql->execute();
    }
    public function actualizarRol($idRolUsuario,$idUsuario, $idRol )
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE roles_usuario set 
        rol_id = ?,
        usuario_id = ?,
        fecha_modi= now()
         WHERE id_rol_usuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idRol);
        $sql->bindValue(2, $idUsuario);
        $sql->bindValue(3, $idRolUsuario);
        if($sql->execute()){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function getUsuario()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT *
        FROM usuarios 
        WHERE es_activo = 1;
        ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoles()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM roles 
        WHERE es_activo = 1;
        ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
