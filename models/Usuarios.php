<?php
class Usuario extends Conectar
{
    public function login()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        //var_dump($_POST);
        if (isset($_POST["enviar"])) {

            $password = $_POST["password"];
            $usuario = $_POST["usuario"];

            if (empty($usuario) and empty($password)) {
                header("Location:" . Conectar::ruta() . "index.php?m=2");
                exit();
            } else {
                $sql = "SELECT u.id_usuario, r.nombre as nombreRol, u.nombre_usuario,u.password_usuario,e.nombres,e.apellidos, ru.rol_id FROM usuarios u INNER JOIN empleados e on e.id_empleado= u.empleado_id INNER JOIN roles_usuario ru on ru.usuario_id = u.id_usuario 
                INNER JOIN roles r on r.id_roles = ru.rol_id
                where nombre_usuario=? and password_usuario=? and u.es_activo=1;";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $usuario);
                $sql->bindValue(2, $password);
                $sql->execute();
                $resultado = $sql->fetch();

                if (is_array($resultado) and count($resultado) > 0) {
                    $_SESSION["id_usuario"] = $resultado["id_usuario"];
                    $_SESSION["nombre_usuario"] = $resultado["nombre_usuario"];
                    $_SESSION["nombres"] = $resultado["nombres"];
                    $_SESSION["apellidos"] = $resultado["apellidos"];
                    $_SESSION["rol_id"] = $resultado["rol_id"];
                    $_SESSION["nombreRol"] = $resultado["nombreRol"];
                    // $_SESSION["cargo"] = $resultado["cargo"];
                    header("Location:" . Conectar::ruta() . "views/Dashboard/");
                    exit();
                } else {
                    header("Location:" . Conectar::ruta() . "index.php?m=1");
                    exit();
                }
            }
        }
    }

    public function insertarUsuarios($nombreUsu, $password, $empleadoId)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO usuarios (nombre_usuario,password_usuario,empleado_id)VALUES (?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombreUsu);
        $sql->bindValue(2, $password);
        $sql->bindValue(3, $empleadoId);
        $sql->execute();
    }


    public function listarUsuarios()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT u.id_usuario, u.nombre_usuario, u.empleado_id, CONCAT(e.nombres,' ', e.apellidos) as nombreCompleto FROM `usuarios` u inner join empleados e on u.empleado_id = e.id_empleado WHERE u.es_activo = 1;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsuarioXId($id_usuario)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT u.id_usuario, u.nombre_usuario, u.empleado_id, e.nombres FROM `usuarios` u inner join empleados e on u.empleado_id = e.id_empleado WHERE id_usuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarUsuario($id_usuario)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE usuarios set es_activo = 0,fecha_elimina= now()
         WHERE id_usuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
    }
    public function actualizarUsuario($id_usuario, $nombreUsu, $empleadoId)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE usuarios set 
        nombre_usuario = ?,
        empleado_id = ?,
        fecha_modi= now()
         WHERE id_usuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombreUsu);
        $sql->bindValue(2, $empleadoId);
        $sql->bindValue(3, $id_usuario);
        $sql->execute();
    }

    public function getEmpleado()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT id_empleado, CONCAT(nombres, ' ', apellidos) AS nombreCompleto 
        FROM empleados 
        WHERE es_activo = 1;
        ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
