<?php
include 'db_cliente.php';
$cliente = new cliente();
$bodega = "";
$movimiento = "";
$producto = "";
$html = "";

if (isset($_POST['bodega'])) {
	$bodega = $_POST['bodega'];
}
if (isset($_POST['movimiento'])) {
	$movimiento = $_POST['movimiento'];
}
if (isset($_POST['tipo'])) {
	$producto = $_POST['tipo'];
}

$html = $cliente->obtener_inventario($bodega,$movimiento,$producto);

echo $html;
?>