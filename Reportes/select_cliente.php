<?php
include 'db_cliente.php';
$cliente = new cliente();
$valor = "";
$html = "";
if (isset($_POST['valor'])) {
	$valor = $_POST['valor'];
	$html = $cliente->obtener_cliente($valor);
}
echo $html;
?>