<?php
class Platos extends Conectar
{

    public function insertarPlatos($nombre, $precio, $categoria)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO platos (nombre,precio,categoria_id)VALUES (?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $precio);
        $sql->bindValue(3, $categoria);
        $sql->execute();
    }


    public function listarPlatos()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT id_platos,p.nombre as nombre_plato,p.precio,disponible,c.id_categoria,c.nombre as nombre_categoria FROM platos p INNER JOIN categoria c on p.categoria_id = c.id_categoria WHERE p.es_activo = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPlatosXId($id_platos)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT id_platos,p.nombre as nombre_plato,p.precio,disponible,c.id_categoria,c.nombre as nombre_categoria FROM platos p INNER JOIN categoria c on p.categoria_id = c.id_categoria WHERE id_platos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_platos);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategoria()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM categoria WHERE es_activo=1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarPlatos($id_platos)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE platos set es_activo = 0,fecha_elimina= now()
         WHERE id_platos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_platos);
        $sql->execute();
    }
    public function actualizarPlatos($id_platos, $nombre, $precio, $categoria)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE platos set 
        nombre = ?,
        precio = ?,
        categoria_id = ?,
        fecha_modi= now()
         WHERE id_platos= ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $precio);
        $sql->bindValue(3, $categoria);
        $sql->bindValue(4, $id_platos);
        $sql->execute();
    }

    public function actualizarEstado($id_platos)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE platos set 
        disponible = IF(disponible = 1, 0, 1),
        fecha_modi = now()
         WHERE id_platos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_platos);
        $sql->execute();

        // Después de la actualización, obtén el nuevo estado
        $sql = "SELECT disponible FROM platos WHERE id_platos = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_platos);
        $sql->execute();
        $nuevo_estado = $sql->fetch(PDO::FETCH_ASSOC);

        // Devuelve el nuevo estado
        echo json_encode(array("disponible" => $nuevo_estado['disponible']));
    }
}
