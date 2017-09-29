<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}

date_default_timezone_set('America/El_Salvador');
require 'database.php';
require './includes/utils.php';

$URI = filter_input(INPUT_SERVER, 'REQUEST_URI');

if (isset($URI)) {
    $lastId = 0;
    $vendido = false;
    if (strpos($URI, '?')) {
        $vars = decode_get2($URI);
        if (isset($vars['fecha'])) {
            $fechaVentaGlobal = $vars['fecha'] . ' ' . date("H:i:s");
        }
        if (isset($vars['vender'])) {
            $vender = $vars['vender'];
        } else {
            $vender = false;
        }
        if (isset($vars['total'])) {
            $totalGlobal = $vars['total'];
        }
        if (isset($vars['vendido'])) {
            $vendido = $vars['vendido'];
        }
        if ($vender) {
            if (isset($_SESSION['carritoVenta'])) {
                //SECUENCIA PARA INGRESAR LA FACTURA GENERAL
                $idUsuario = $_SESSION['idUsuario'];
                $idCliente = $_SESSION['idCliente'];
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO factura (codigo_usuario, codigo_cliente, fecha_venta, total) values (?, ?, ?, ?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($idUsuario, $idCliente, $fechaVentaGlobal, $totalGlobal));
                $lastId = $pdo->lastInsertId();
                echo $lastId;
                Database::disconnect();
            }
        }
        if ($lastId != 0) {
            //SECUENCIA PARA INGRESAR EL DETALLE DE LA FACTURA EN TODAS LAS TABLAS
            if (isset($_SESSION['carritoVenta'])) {
                $datos = $_SESSION['carritoVenta'];
                $idUsuario = $_SESSION['idUsuario'];

                $pdo = Database::connect();
                for ($i = 0; $i < count($datos); $i++) {
                    $codigoProducto = $datos[$i]['Id'];
                    $idFactura = $lastId;
                    $cantProducto = $datos[$i]['Cantidad'];
                    $precioSubTotal = $datos[$i]['Cantidad'] * $datos[$i]['PrecioVenta'];

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO detalle_venta (codigo_factura, codigo_producto, cantidad, precio_tot_producto)"
                            . " values (?, ?, ?, ?)";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($idFactura, $codigoProducto, $cantProducto, $precioSubTotal));
                }

                //INGRESO DE INFORMACIÓN AL INVENTARIO (LA BODEGA QUE SE UTILIZARÁ POR DEFECTO SERÁ LA #3, PRINCIPAL)
                $movimiento = 'VENTA';
                $idBodega = 3;
                for ($i = 0; $i < count($datos); $i++) {
                    $codigoProducto = $datos[$i]['Id'];
                    $cantProducto = $datos[$i]['Cantidad'];

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO inventario (codigo_bodega, codigo_producto, tipo_movimiento, fecha_movimiento, cantidad_producto) "
                            . "VALUES (?, ?, ?, ?, ?)";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($idBodega, $codigoProducto, $movimiento, $fechaVentaGlobal, $cantProducto));
                }

                //DETALLE PARA ACTUALIZAR EL STOCK PARA LA DISMINUCIÓN DE PRODUCTO
                for ($i = 0; $i < count($datos); $i++) {
                    $codigoProducto = $datos[$i]['Id'];
                    $cantProducto = $datos[$i]['Cantidad'];

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT existencia FROM stock where codigo_producto = " . $codigoProducto . " AND codigo_bodega = " . $idBodega;
                    $q = $pdo->prepare($sql);
                    $q->execute();
                    $row = $q->fetch(PDO::FETCH_ASSOC);

                    $cantActualizada = $row['existencia'] - $cantProducto;
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "UPDATE stock set existencia=? WHERE codigo_bodega=" . $idBodega . " AND codigo_producto=" . $codigoProducto;
                    $q = $pdo->prepare($sql);
                    $q->execute(array($cantActualizada));
                }



                Database::disconnect();
                $_SESSION['carritoVenta'] = null;
                $_SESSION['nombreCliente'] = null;
                $_SESSION['idCliente'] = null;
                $_SESSION['idUltimaFactura'] = $idFactura;
                header("Location: mostrarFactura.php");
            }
        }
    }
}

if (isset($vaciado)) {
    if ($vaciado == 1) {
        $_SESSION['carritoVenta'] = null;
    }
}


if (isset($_REQUEST['uns'])) {
    //Codigo para eliminar articulos del detalle de compra
    $idArr = $_REQUEST['uns'];
    $arreglo = $_SESSION['carritoVenta'];
    unset($arreglo[$idArr]);
    $_SESSION['carritoVenta'] = array_values($arreglo);
}
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Factura</title>
        <!-- Core CSS - Include with every page -->
        <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/main-style.css" rel="stylesheet" />
        <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    </head>

    <body>
        <!--  wrapper -->
        <div id="wrapper">
            <!-- navbar top -->
            <?php include ("./includes/topMenu.php"); ?>
            <!-- end navbar top -->

            <!-- navbar side -->
            <?php include ("./includes/leftMenu.php"); ?>
            <!-- end navbar side -->
            <!--  page-wrapper -->
            <div id="page-wrapper">

                <div class="row">
                    <!-- Page Header -->
                    <div class="col-lg-12">
                        <h1 class="page-header">Datos </h1>
                    </div>
                    <!--End Page Header -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Verificacion de datos de factura
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Detalle Factura</h3>
                                        <?php
                                        if ($vendido == false) {
                                            echo '<h3>¿Desea Generar Factura?</h3>';
                                        }
                                        ?>
                                        <p>
                                            <?php
                                            if ($vendido == false) {
                                                echo '<a class="btn btn-success" href="facturar.php?' . encode_this("vender=true&total=" . $totalGlobal . "&fecha=" . $fechaVentaGlobal) . '">SI</a>';
                                                echo '&nbsp;';
                                                echo '<a class="btn btn-danger" href="mostrarDetalleVenta.php">NO</a>';
                                            }
                                            ?>
                                            <!--Falta detallar la compra e ingreso al inventario-->
                                        </p>

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>

                                                    <th>Nombre Producto</th>
                                                    <th>Precio Compra Unidad</th>
                                                    <th>Cantidad</th>
                                                    <th>Sub Total</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $total = 0;
                                                if (isset($_SESSION['carritoVenta'])) {
                                                    $datos = $_SESSION['carritoVenta'];

                                                    //$total = 0;
                                                    for ($i = 0; $i < count($datos); $i++) {
                                                        echo '<tr>';
                                                        echo '<td>' . $datos[$i]['Nombre'] . '</td>';
                                                        echo '<td>' . $datos[$i]['PrecioVenta'] . '</td>';
                                                        echo '<td>' . $datos[$i]['Cantidad'] . '</td>';
                                                        echo '<td>' . $datos[$i]['Cantidad'] * $datos[$i]['PrecioVenta'] . '</td>';
                                                        echo '<td width=300>';
                                                        echo '</td>';
                                                        echo '</tr>';

                                                        $total = ($datos[$i]['Cantidad'] * $datos[$i]['PrecioVenta']) + $total;
                                                    }
                                                } else {
                                                    if ($vendido) {
                                                        echo '<center><h2>Factura Generada con éxito!</h2></center>';
                                                    } else {
                                                        echo '<center><h2>No has añadido ningun producto</h2></center>';
                                                    }
                                                }
                                                echo '<center><h2 id="total">Total: ' . $total . '</h2></center>';
                                                ?>

                                            </tbody>
                                        </table>

                                        <p>
                                            <br>
                                            <a class="btn btn-default" href="mostrarRegistroVenta.php">Regresar</a>
                                            <?php
                                            if ($vendido == false) {
                                                echo '<a class="btn btn-default" href="mostrarDetalleVenta.php?' . encode_this('vac=1') . '">Vaciar Detalle</a>';
                                            }
                                            ?>

                                        </p>

                                    </div>
                                </div> <!-- /container -->
                            </div>
                            <br style="clear:both;" />
                        </div>
                    </div>
                </div>

                <div id="footer">
                    <div>
                    </div>
                </div>

            </div>
            <script src="assets/plugins/jquery-1.10.2.js"></script>
            <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
            <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
            <script src="assets/plugins/pace/pace.js"></script>
            <script src="assets/scripts/siminta.js"></script>
            <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
            <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
            <script>
                $(document).ready(function () {
                    $('#dataTables-example').dataTable();
                });
            </script>
    </body>
</html>
