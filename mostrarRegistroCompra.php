<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mantto. Compra</title>
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
                        <h1 class="page-header">Compra</h1>
                    </div>
                    <!-- end  page header -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Compra
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nombre Producto</th>
                                                    <th>Proveedor</th>
                                                    <th>Precio Compra</th>
                                                    <th>Tipo Producto</th>
                                                    <th>Presentacion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include 'database.php';
                                                $pdo = Database::connect();
                                                $sql = 'SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.precio_compra, pd.presentacion from producto pd
                                                    INNER JOIN proveedor pr ON pd.codigo_proveedor = pr.codigo_proveedor
                                                    INNER JOIN tipo_producto tp ON pd.codigo_tipoproducto = tp.codigo_tipoproducto';
                                                foreach ($pdo->query($sql) as $row) {
                                                    echo '<tr>';
                                                    echo '<td>' . $row['nombre_producto'] . '</td>';
                                                    echo '<td>' . $row['nombre_empresa'] . '</td>';
                                                    echo '<td>' . $row['precio_compra'] . '</td>';
                                                    echo '<td>' . $row['nombre_tipoproducto'] . '</td>';
                                                    echo '<td>' . $row['presentacion'] . '</td>';
                                                    echo '<td width=300>';
                                                    echo '<a class="btn btn-success" href="compraProductos.php?codigoProducto=' . $row['codigo_producto'] . '">Agregar para Compra</a>';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }
                                                Database::disconnect();
                                                ?>
                                            </tbody>
                                        </table>

                                        <p>
                                            <a class="btn btn-default" href="mantenimientos.php">Regresar Menu</a>
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
