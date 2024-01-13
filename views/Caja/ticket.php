<?php

require '../../config/conexion.php';
require '../../public/assets/fpdf/fpdf.php';
require '../../public/helpers/NumeroALetras.php';

define('MONEDA', 'S/');
define('MONEDA_LETRA', 'SOLES');
define('MONEDA_DECIMAL', 'CENTIMOS');

$objeto = new Conectar();
$conexion = $objeto->Conexion();

$idVenta = isset($_GET['id_pedido']) ? intval($_GET['id_pedido']) : 1;

$sqlVenta = "SELECT p.id_pedido,s.nombre, total, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_venta, DATE_FORMAT(fecha,'%H:%i') AS hora
FROM pedidos p
INNER JOIN sala s on s.id_sala = p.sala_id WHERE id_pedido  = :idVenta LIMIT 1";


$sqlDetalle = "SELECT nombre, cantidad, precio FROM detalle_pedidos  WHERE pedido_id  = :idVenta";

try {
    $stmtVenta = $conexion->prepare($sqlVenta);
    $stmtVenta->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
    $stmtVenta->execute();

    $row_venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);

    $stmtDetalle = $conexion->prepare($sqlDetalle);
    $stmtDetalle->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
    $stmtDetalle->execute();

    $pdf = new FPDF('P', 'mm', array(80, 200));
    $pdf->AddPage();
    $pdf->SetMargins(5, 5, 5);
    $pdf->SetFont('Arial', 'B', 9);



    $pdf->Ln(1);

    $pdf->MultiCell(70, 5, 'SISTEMA RESTAURANTE', 0, 'C');

    $pdf->Ln(1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(17, 5, mb_convert_encoding('Núm ticket:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(53, 5, $row_venta['id_pedido'], 0, 1, 'L');

    $pdf->Cell(70, 2, '-------------------------------------------------------------------------', 0, 1, 'L');

    $pdf->Cell(10, 4, 'Cant.', 0, 0, 'L');
    $pdf->Cell(30, 4, mb_convert_encoding('Descripción', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
    $pdf->Cell(15, 4, 'Precio', 0, 0, 'C');
    $pdf->Cell(15, 4, 'Importe', 0, 1, 'C');

    $pdf->Cell(70, 2, '-------------------------------------------------------------------------', 0, 1, 'L');

    $totalProductos = 0;
    $pdf->SetFont('Arial', '', 7);

    while ($row_detalle = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
        $importe = number_format($row_detalle['cantidad'] * $row_detalle['precio'], 2, '.', ',');
        $totalProductos += $row_detalle['cantidad'];

        $pdf->Cell(10, 4, $row_detalle['cantidad'], 0, 0, 'L');

        $yInicio = $pdf->GetY();
        $pdf->MultiCell(30, 4, mb_convert_encoding($row_detalle['nombre'], 'ISO-8859-1', 'UTF-8'), 0, 'L');
        $yFin = $pdf->GetY();

        $pdf->SetXY(45, $yInicio);

        $pdf->Cell(15, 4, MONEDA . ' ' . number_format($row_detalle['precio'], 2, '.', ','), 0, 0, 'C');

        $pdf->SetXY(60, $yInicio);
        $pdf->Cell(15, 4, MONEDA . ' ' . $importe, 0, 1, 'R');
        $pdf->SetY($yFin);
    }

    $stmtDetalle->closeCursor();

    $pdf->Ln();

    $pdf->Cell(70, 4, mb_convert_encoding('Número de platos:  ' . $totalProductos, 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(70, 5, sprintf('Total: %s  %s', MONEDA, number_format($row_venta['total'], 2, '.', ',')), 0, 1, 'R');

    $pdf->Ln(2);

    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(70, 4, 'Son ' . strtolower(NumeroALetras::convertir($row_venta['total'], MONEDA_LETRA, MONEDA_DECIMAL)), 0, 'L', 0);

    $pdf->Ln();

    $pdf->Cell(35, 5, 'Fecha: ' . $row_venta['fecha_venta'], 0, 0, 'C');
    $pdf->Cell(35, 5, 'Hora: ' . $row_venta['hora'], 0, 1, 'C');

    $pdf->Ln();

    $pdf->MultiCell(70, 5, 'GRACIAS POR ELEGIRNOS, ESPERAMOS SORPRENDERTE PRONTO!!!', 0, 'C');

    $stmtVenta->closeCursor();
    $stmtDetalle->closeCursor();
    $conexion = null; // Cerrar la conexión

    $pdf->Output();
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
