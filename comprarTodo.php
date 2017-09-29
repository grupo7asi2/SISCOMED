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
$codigoProducto = filter_input(INPUT_GET, 'codigoProducto');
$cantidad = filter_input(INPUT_GET, 'cantidad');
$vaciado = filter_input(INPUT_GET, 'vac');
$fechaCompraGlobal = '';
$totalGlobal = 0;

if (isset($URI)) {
    $lastId = 0;
    $comprado = false;
    if (strpos($URI, '?')) {
        $vars = decode_get2($URI);
        if (isset($vars['fecha'])) {
            $fechaCompraGlobal = $vars['fecha'] . ' ' . date("H:i:s");
        }
        if (isset($vars['comprar'])) {
            $comprar = $vars['comprar'];
        } else {
            $comprar = false;
        }
        if (isset($vars['total'])) {
            $totalGlobal = $vars['total'];
        }
        if (isset($vars['comprado'])) {
            $comprado = $vars['comprado'];
        }
        //INGRESO DE LA COMPRA GENERAL
        if ($comprar) {
            if (isset($_SESSION['carritoCompra'])) {
                $idUsuario = $_SESSION['idUsuario'];
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO Compra (codigo_usuario, fecha_compra, total) values (?, ?, ?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($idUsuario, $fechaCompraGlobal, $totalGlobal));
                $lastId = $pdo->lastInsertId();
                Database::disconnect();
            }
        }
        //INGRESO DEL DETALLE DE LA COMPRA
        if ($lastId != 0) {
            if (isset($_SESSION['carritoCompra'])) {
                $datos = $_SESSION['carritoCompra'];
                $idUsuario = $_SESSION['idUsuario'];

                //SECUENCIA PARA INGRESAR LAS COMPRAS A LA BASE DE DATOS
                $pdo = Database::connect();
                for ($i = 0; $i < count($datos); $i++) {
                    $codigoProducto = $datos[$i]['Id'];
                    $idCompra = $lastId;
                    $cantProducto = $datos[$i]['Cantidad'];
                    $precioSubTotal = $datos[$i]['Cantidad'] * $datos[$i]['PrecioCompra'];
                    $fechaVenc = $datos[$i]['FechaVenc'];

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO detalle_compra (codigo_producto, codigo_compra, cantidad_producto, precio_tot_producto, fecha_vencimiento) "
                            . "values (?, ?, ?, ?, ?)";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($codigoProducto, $idCompra, $cantProducto, $precioSubTotal, $fechaVenc));
                }

                //INGRESO DE INFORMACIÓN AL INVENTARIO (LA BODEGA QUE SE UTILIZARÁ POR DEFECTO SERÁ LA #3, PRINCIPAL)
                $movimiento = 'COMPRA';
                $idBodega = 3;
                for ($i = 0; $i < count($datos); $i++) {
                    $codigoProducto = $datos[$i]['Id'];
                    $cantProducto = $datos[$i]['Cantidad'];

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO inventario (codigo_bodega, codigo_producto, tipo_movimiento, fecha_movimiento, cantidad_producto) "
                            . "VALUES (?, ?, ?, ?, ?)";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($idBodega, $codigoProducto, $movimiento, $fechaCompraGlobal, $cantProducto));
                }

                /* INGRESO O ACTUALIZACIÓN DE TABLA STOCK PARA VERIFICAR EXISTENCIA DE PRODUCTOS
                 * PARA ELLO, PRIMERO SE VERIFICA SI LA TABLA YA CONTIENE AL PRODUCTO, DE SER ASÍ
                 * SOLO SE PROCEDE A SER ACTUALIZADO, DE LO CONTRARIO, SE CREA EL NUEVO REGISTRO EN LA TABLA
                 * PARA PODER SER ACTUALIZADO POSTERIORMENTE.
                 */

                for ($i = 0; $i < count($datos); $i++) {
                    $codigoProducto = $datos[$i]['Id'];
                    $cantProducto = $datos[$i]['Cantidad'];

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT existencia FROM stock where codigo_producto = " . $codigoProducto . " AND codigo_bodega = " . $idBodega;
                    $q = $pdo->prepare($sql);
                    $q->execute();
                    $row = $q->fetch(PDO::FETCH_ASSOC);

                    if (!empty($row)) {
                        $cantActualizada = $row['existencia'] + $cantProducto;
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "UPDATE stock set existencia=? WHERE codigo_bodega=" . $idBodega . " AND codigo_producto=" . $codigoProducto;
                        $q = $pdo->prepare($sql);
                        $q->execute(array($cantActualizada));
                    } else {
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "INSERT INTO stock (codigo_bodega, codigo_producto, existencia) VALUES (?, ?, ?)";
                        $q = $pdo->prepare($sql);
                        $q->execute(array($idBodega, $codigoProducto, $cantProducto));
                    }
                }

                Database::disconnect();
                $_SESSION['carritoCompra'] = null;
                header("Location: comprarTodo.php?" . encode_this("comprado=true"));
            }
        }
    }
}

if (isset($vaciado)) {
    if ($vaciado == 1) {
        $_SESSION['carritoCompra'] = null;
    }
}

if (isset($_REQUEST['uns'])) {
    //Codigo para eliminar articulos del detalle de compra
    $idArr = $_REQUEST['uns'];
    $arreglo = $_SESSION['carritoCompra'];
    unset($arreglo[$idArr]);
    $_SESSION['carritoCompra'] = array_values($arreglo);
}
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mantto. CTodo</title>
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
                                Verificacion de datos de compra
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Detalle Compra</h3>
                                        <?php
                                        if ($comprado == false) {
                                            echo '<h3>¿Desea comprar todos los productos?</h3>';
                                        }
                                        ?>
                                        <p>
                                            <?php
                                            if ($comprado == false) {
                                                echo '<a class="btn btn-success" href="comprarTodo.php?' . encode_this("comprar=true&total=" . $totalGlobal . "&fecha=" . $fechaCompraGlobal) . '">SI</a>';
                                                echo '&nbsp;';
                                                echo '<a class="btn btn-danger" href="mostrarDetalleCompra.php">NO</a>';
                                            }
                                            ?>
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
                                                if (isset($_SESSION['carritoCompra'])) {
                                                    $datos = $_SESSION['carritoCompra'];

                                                    //$total = 0;
                                                    for ($i = 0; $i < count($datos); $i++) {
                                                        echo '<tr>';
                                                        echo '<td>' . $datos[$i]['Nombre'] . '</td>';
                                                        echo '<td>' . $datos[$i]['PrecioCompra'] . '</td>';
                                                        echo '<td>' . $datos[$i]['Cantidad'] . '</td>';
                                                        echo '<td>' . $datos[$i]['Cantidad'] * $datos[$i]['PrecioCompra'] . '</td>';
                                                        echo '<td width=300>';
                                                        echo '</tr>';
                                                        $total = ($datos[$i]['Cantidad'] * $datos[$i]['PrecioCompra']) + $total;
                                                    }
                                                } else {
                                                    if ($comprado) {
                                                        echo '<center><h2>Compra realizada con éxito!</h2></center>';
                                                    } else {
                                                        echo '<center><h2>No has añadido ningun producto</h2></center>';
                                                    }
                                                }
                                                echo '<center><h2 id="total">Total: ' . $total . '</h2></center>';
                                                ?>

                                            </tbody>
                                        </table>

                                        <p>

                                            <a class="btn btn-default" href="mostrarRegistroCompra.php">Regresar</a>
                                            <?php
                                            if ($comprado == false) {
                                                echo '<a class="btn btn-default" href="mostrarDetalleCompra.php?vac=1" >Vaciar Detalle</a>';
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
