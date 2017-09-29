<?php
include 'db_cliente.php';
$cliente = new cliente();
$usuario = "";
$fecha = "";
$html = "";

if (isset($_POST['usuario'])) {
	$usuario = $_POST['usuario'];
}
if (isset($_POST['fecha'])) {
	$fecha = $_POST['fecha'];
}

$html = $cliente->obtener_compras($usuario, $fecha);

echo $html;
?>