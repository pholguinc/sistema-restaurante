<?php
require_once("../../config/conexion.php");
$objeto = new Conectar();
$conexion = $objeto->Conexion();
if ($_POST['action'] == 'sales') {
    $desde = date('Y') . '-01-01 00:00:00';
    $hasta = date('Y') . '-12-31 23:59:59';

    $sql = "SELECT 
    SUM(IF(MONTH(fecha) = 1, total, 0)) AS ene,
    SUM(IF(MONTH(fecha) = 2, total, 0)) AS feb,
    SUM(IF(MONTH(fecha) = 3, total, 0)) AS mar,
    SUM(IF(MONTH(fecha) = 4, total, 0)) AS abr,
    SUM(IF(MONTH(fecha) = 5, total, 0)) AS may,
    SUM(IF(MONTH(fecha) = 6, total, 0)) AS jun,
    SUM(IF(MONTH(fecha) = 7, total, 0)) AS jul,
    SUM(IF(MONTH(fecha) = 8, total, 0)) AS ago,
    SUM(IF(MONTH(fecha) = 9, total, 0)) AS sep,
    SUM(IF(MONTH(fecha) = 10, total, 0)) AS oct,
    SUM(IF(MONTH(fecha) = 11, total, 0)) AS nov,
    SUM(IF(MONTH(fecha) = 12, total, 0)) AS dic 
FROM pedidos 
WHERE fecha BETWEEN :desde AND :hasta";

    $query = $conexion->prepare($sql);
    $query->bindParam(':desde', $desde, PDO::PARAM_STR);
    $query->bindParam(':hasta', $hasta, PDO::PARAM_STR);
    $query->execute();

    $arreglo = $query->fetch(PDO::FETCH_ASSOC);

    echo json_encode($arreglo);
    die();
}
