<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}

include_once 'db_cliente.php';
$cliente = new cliente();

$select = "";
$select = $cliente->obtener_productos();


$html = "";
$html = $cliente->obtener_inventario();
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte de Productos</title>
        <!-- Core CSS - Include with every page -->
        <link href="../assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="../assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="../assets/css/style.css" rel="stylesheet" />
        <link href="../assets/css/main-style.css" rel="stylesheet" />



        <link href="../assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />


    </head>

    <body>
        <!--  wrapper -->
        <div id="wrapper">
            <!-- navbar top -->
            <?php include ("../includes/topMenu2.php"); ?>
            <!-- end navbar top -->

            <!-- navbar side -->
            <?php include ("../includes/leftMenu2.php"); ?>
            <!-- end navbar side -->
            <!--  page-wrapper -->
            <div id="page-wrapper">

                <div class="row">
                    <!-- Page Header -->
                    <div class="row">
                        <!--  page header -->
                        <div class="col-lg-12">
                            <h1 class="page-header">Inventario</h1>
                        </div>
                        <!-- end  page header -->
                    </div>

                    <form target="blank" action="pdf/reporteInventario.php" method="POST">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Filtros
                                    </div>
                                    <div class="panel-body">

                                        <div class="col-md-4">
                                            <label>Bodega</label>
                                            <div class="input-group">

                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-archive fa"></i></span>
                                                <input id="bodega" name="bodega" type="text" class="form-control" placeholder="Busque por Bodega" aria-describedby="basic-addon1">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Movimiento</label>
                                            <div class="input-group">

                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user fa"></i></span>
                                                <input id="movimiento" name="movimiento" type="text" class="form-control" placeholder="Busque por movimiento" aria-describedby="basic-addon1">
                                            </div>
                                        </div>


                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label>Producto</label>
                                                <select id="tipo" name="tipo" class="form-control">
                                                    <option></option>
                                                    <?php
                                                    echo $select;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Advanced Tables -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Inventario
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                                <p>
                                                    <input type="submit" href="pdf/reporteInventario.php" class="btn btn-danger" value="Imprimir Reporte">

                                                <thead>
                                                    <tr>
                                                        <th>Bodega</th>
                                                        <th>Movimiento</th>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Fecha de Movimiento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="listado">
                                                    <?php
                                                    echo $html;
                                                    ?>
                                                </tbody>
                                            </table>

                                            <p>

                                                <a class="btn btn-default" href="../mantenimientos.php">Regresar Menu</a>

                                            </p>
                                        </div>
                                    </div> <!-- /container -->
                                </div>
                                <br style="clear:both;" />
                            </div>
                        </div>
                    </form>
                </div>
                <div id="footer">
                    <div>


                    </div>
                </div>
            </div>
            <script src="../assets/plugins/jquery-1.10.2.js"></script>
            <script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
            <script src="../assets/plugins/metisMenu/jquery.metisMenu.js"></script>
            <script src="../assets/plugins/pace/pace.js"></script>
            <script src="../assets/scripts/siminta.js"></script>

            <script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
            <script src="../assets/plugins/dataTables/dataTables.bootstrap.js"></script>
            <script>
                $(document).ready(function () {

                    $('#bodega').keyup(function () {
                        var bodega = $('#bodega').val();
                        var movimiento = $('#movimiento').val();
                        var tipo = $('#tipo').val();
                        console.log(bodega);
                        console.log(movimiento);
                        console.log(tipo);
                        
                        $.ajax({
                            url: "select_productos.php",
                            method: "post",
                            data: {bodega: bodega, movimiento: movimiento, tipo: tipo},
                            success: function (data) {
                                $('#listado').html(data);
                                console.log(data);
                            }
                        });
                    });

                    $('#movimiento').keyup(function () {
                        var bodega = $('#bodega').val();
                        var movimiento = $('#movimiento').val();
                        var tipo = $('#tipo').val();
                        console.log(bodega);
                        console.log(movimiento);
                        console.log(tipo);
                        
                        $.ajax({
                            url: "select_productos.php",
                            method: "post",
                            data: {bodega: bodega, movimiento: movimiento, tipo: tipo},
                            success: function (data) {
                                $('#listado').html(data);
                                console.log(data);
                            }
                        });
                    });

                    $('#tipo').change(function () {
                        var bodega = $('#bodega').val();
                        var movimiento = $('#movimiento').val();
                        var tipo = $('#tipo').val();

                        $.ajax({
                            url: "select_productos.php",
                            method: "post",
                            data: {bodega: bodega, movimiento: movimiento, tipo: tipo},
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
