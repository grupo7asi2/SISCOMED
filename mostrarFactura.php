<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}

require 'database.php';
require './includes/utils.php';

$ultimaFactura = NULL;
$fechaVenta = NULL;
$cliente = NULL;
$total = NULL;

if (isset($_SESSION['idUltimaFactura'])) {
    $ultimaFactura = $_SESSION['idUltimaFactura'];
    $idUsuario = $_SESSION['idUsuario'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "Select factura.codigo_factura, factura.fecha_venta, concat(cliente.nombre_cliente, ' ', cliente.apellido_cliente) AS Cliente, "
            . "producto.nombre_producto, detalle_venta.cantidad, detalle_venta.precio_tot_producto, factura.total "
            . "from factura "
            . "INNER JOIN detalle_venta ON detalle_venta.codigo_factura = factura.codigo_factura "
            . "INNER JOIN producto ON producto.codigo_producto = detalle_venta.codigo_producto "
            . "INNER JOIN cliente ON cliente.codigo_cliente = factura.codigo_cliente "
            . "WHERE factura.codigo_factura=" . $ultimaFactura;
    $q = $pdo->prepare($sql);
    $q->execute();
    $data = $q->fetchAll();
    Database::disconnect();
    foreach ($data as $rows) {
        $cliente = $rows['Cliente'];
        $total = $rows['total'];
        $fechaVenta = $rows['fecha_venta'];
    }
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mostrar Factura</title>
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
                    <!--  page header -->
                    <div class="col-lg-12">
                        <h1 class="page-header">Factura</h1>
                    </div>
                    <!-- end  page header -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Factura
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                        <p>
                                            <a class="btn btn-success" href="Reportes/pdf/imprimirFactura.php" target="blank" >IMPRIMIR</a>
                                        </p>
                                        <div>
                                            <?php
                                            if (isset($ultimaFactura)) {
                                                if ($ultimaFactura < 9999) {
                                                    if ($ultimaFactura < 999) {
                                                        if ($ultimaFactura < 99) {
                                                            if ($ultimaFactura < 9) {
                                                                echo "<h2 style='color: red'>0000" . $ultimaFactura . "<h2>";
                                                            } else {
                                                                echo "<h2 style='color: red'>000" . $ultimaFactura . "<h2>";
                                                            }
                                                        } else {
                                                            echo "<h2 style='color: red'>00" . $ultimaFactura . "<h2>";
                                                        }
                                                    } else {
                                                        echo "<h2 style='color: red'>0" . $ultimaFactura . "<h2>";
                                                    }
                                                } else {
                                                    echo "<h2 style='color: red'>" . $ultimaFactura . "<h2>";
                                                }
                                            }

                                            if (isset($fechaVenta)) {
                                                echo '<h3>' . $fechaVenta . '</h3>';
                                            }

                                            if (isset($cliente)) {
                                                echo '<h3>' . $cliente . '</h3>';
                                            }
                                            ?>
                                        </div>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>

                                                    <th>Cantidad</th>
                                                    <th>Detalle</th>
                                                    <th>Sub Total</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach ($data as $rows) {
                                                    echo '<tr>';
                                                    echo '<td>' . $rows['cantidad'] . '</td>';
                                                    echo '<td>' . $rows['nombre_producto'] . '</td>';
                                                    echo '<td>' . $rows['precio_tot_producto'] . '</td>';
                                                }
                                                echo '<center><h2 id="total">Total: ' . $total . '</h2></center>';
                                                ?>
                                            </tbody>
                                        </table>

                                        <p>
                                            <a class="btn btn-default" href="index.php">Regresar Menú</a>
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
        <script>
            $(document).ready(function () {

                $('#fechaVenta').keyup(function () {
                    var producto = $('#producto').val();
                    var proveedor = $('#proveedor').val();
                    var tipo = $('#tipo').val();
                    console.log(producto);
                    console.log(proveedor);
                    console.log(tipo);


                    $.ajax({
                        url: "select_producto.php",
                        method: "post",
                        data: {producto: producto, proveedor: proveedor, tipo: tipo},
                        success: function (data) {
                            $('#listado').html(data);
                            console.log(data);
                        }
                    });


                });




                $('#proveedor').keyup(function () {
                    var producto = $('#producto').val();
                    var proveedor = $('#proveedor').val();
                    var tipo = $('#tipo').val();
                    console.log(producto);
                    console.log(proveedor);
                    console.log(tipo);


                    $.ajax({
                        url: "select_producto.php",
                        method: "post",
                        data: {producto: producto, proveedor: proveedor, tipo: tipo},
                        success: function (data) {
                            $('#listado').html(data);
                            console.log(data);
                        }
                    });


                });



                $('#tipo').change(function () {
                    var producto = $('#producto').val();
                    var proveedor = $('#proveedor').val();
                    var tipo = $('#tipo').val();

                    $.ajax({
                        url: "select_producto.php",
                        method: "post",
                        data: {producto: producto, proveedor: proveedor, tipo: tipo},
                        success: function (data) {
                            $('#listado').html(data);
                            console.log(data);
                        }
                    });


                });
            });
        </script>

    </body>
</html>
