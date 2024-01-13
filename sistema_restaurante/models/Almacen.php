<?php
class Almacen extends Conectar
{
    public function listarAlmacen()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT a.nombre as nombre_almacen,
        COALESCE(isu.nombre, '-') as nombre_insumo,
        COALESCE(p.nombre, '-') as nombre_producto,
        COALESCE(i.cantidad, '-') as cantidad
        FROM inventario i
        LEFT JOIN insumos isu ON isu.id_insumos = i.insumos_id
        LEFT JOIN productos p ON p.id_productos = i.productos_id
        INNER JOIN almacen a ON a.id_almacen = i.almacen_id
    WHERE (
            isu.es_activo = 1
            OR isu.es_activo IS NULL
        )
        AND (
            p.es_activo = 1
            OR p.es_activo IS NULL
        );";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
