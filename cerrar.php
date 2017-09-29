<?php
session_start(); 
$_SESSION['usuario']= NULL;
$_SESSION['idUsuario']= NULL;
$_SESSION['carritoVenta'] = NULL;
$_SESSION['carritoCompra'] = NULL;
$_SESSION['idCliente'] = NULL;
$_SESSION['nombreCliente'] = NULL;
session_destroy();
header("Location: login.php");
?>