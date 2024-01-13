<?php
class Caja extends Conectar
{
    // public function getPisosConMesas()
    // {
    //     $conectar = parent::Conexion();
    //     parent::set_names();
    //     $sql = "SELECT CONCAT('Piso ', p.id_piso) as nombre_piso, COUNT(m.id_mesa) as total_mesas,  m.id_mesa as id_mesa
    //     FROM pisos p 
    //     LEFT JOIN mesas m ON p.id_piso = m.piso_id 
    //     WHERE p.es_activo = 1
    //     GROUP BY p.id_piso;
    //     ";
    //     $sql = $conectar->prepare($sql);
    //     $sql->execute();
    //     return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    // }
    public function getPisosConMesas()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT CONCAT('Piso ', p.id_piso) as nombre_piso, (SELECT COUNT(m.id_mesa) FROM mesas m WHERE m.piso_id = p.id_piso) as total_mesas, m.id_mesa FROM pisos p JOIN mesas m ON p.id_piso = m.piso_id WHERE p.es_activo = 1;
    ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $pisos = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $pisos[$fila['nombre_piso']][] = array(
                'id_mesa' => $fila['id_mesa'],
                'total_mesas' => $fila['total_mesas']
            );
        }
        return $pisos;
    }

    public function getSalaMesas()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM sala WHERE estado = 1";
        $statement = $conectar->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
