<?php
class Empleados extends Conectar
{

    public function insertarEmpleados($nombres, $apellidos, $dni, $correo, $telefono)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO empleados (nombres,apellidos,dni,correo,telefono)VALUES (?,?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $apellidos);
        $sql->bindValue(3, $dni);
        $sql->bindValue(4, $correo);
        $sql->bindValue(5, $telefono);
    
        $sql->execute();
    }
    public function listarEmpleados()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM `empleados` WHERE es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }
    public function getEmpleadoXId($idEmpleado)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM `empleados` WHERE id_empleado = ? ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idEmpleado);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function eliminarEmpleados($idEmpleado)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE empleados set es_activo = 0,fecha_elimina= now()
         WHERE id_empleado = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idEmpleado);
        $sql->execute();
    }
    public function actualizarEmpleados($idEmpleado, $nombres, $apellidos, $dni, $correo, $telefono)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE empleados set 
        nombres = ?,
        apellidos = ?,
        dni = ?,
        correo = ?,
        telefono = ?,
        fecha_modi= now()
         WHERE id_empleado = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $apellidos);
        $sql->bindValue(3, $dni);
        $sql->bindValue(4, $correo);
        $sql->bindValue(5, $telefono);
        $sql->bindValue(6, $idEmpleado);
        $sql->execute();
    }

}
