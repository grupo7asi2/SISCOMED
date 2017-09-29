<?php
include 'db_cliente.php';
$cliente = new cliente();
$producto = "";
$proveedor = "";
$tipo = "";
$html = "";

if (isset($_POST['producto'])) {
	$producto = $_POST['producto'];
}
if (isset($_POST['proveedor'])) {
	$proveedor = $_POST['proveedor'];
}
if (isset($_POST['tipo'])) {
	$tipo = $_POST['tipo'];
}

$html = $cliente->obtener_producto($producto,$proveedor,$tipo);

echo $html;
?>