<?php
include 'db_cliente.php';
$cliente = new cliente();
$numFactura = "";
$nomCliente = "";
$fecha = "";
$html = "";

if (isset($_POST['numfactura'])) {
	$numFactura = $_POST['numfactura'];
}
if (isset($_POST['cliente'])) {
	$nomCliente = $_POST['cliente'];
}
if (isset($_POST['fecha'])) {
	$fecha = $_POST['fecha'];
}

$html = $cliente->obtener_ventas($numFactura, $nomCliente, $fecha);

echo $html;
?>