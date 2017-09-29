<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require 'database.php';
require './includes/utils.php';

$codigoProducto = filter_input(INPUT_GET, 'codigoProducto');

if (!empty($_POST)) {
    // keep track validation errors
    $cantidadError = NULL;
    $errorStock = NULL;
    $codigoProducto = $_POST['codigoProducto'];
    // keep track post values
    $cantidad = $_POST['cantidad'];
    // validate input
    $valid = true;

    if (empty($cantidad)) {
        $cantidadError = 'Ingrese la cantidad a adquirir';
        $valid = false;
    }

    //SECUENCIA PARA VERIFICAR EL STOCK DE PRODUCTOS, EN CASO QUE NO HAYAN SUFICIENTES, SE DESPLEGARÁ UN ERROR
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT existencia FROM stock where codigo_producto = " . $codigoProducto . " AND codigo_bodega = 3";
    $q = $pdo->prepare($sql);
    $q->execute();
    $row = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if (!empty($row)) {
        $existActual = $row['existencia'];
        if ($existActual < $cantidad) {
            $errorStock = ":::No hay suficiente producto en stock::: <br>Disponible: " . $existActual;
            $valid = false;
        }
    } else {
        $errorStock = ":::No hay suficiente producto en stock::: <br>Disponible: 0";
        $valid = false;
    }


    if ($valid) {
        $vars = encode_this("codigoProducto=" . $codigoProducto . "&cantidad=" . $cantidad);
        header("Location: mostrarDetalleVenta.php?" . $vars);
    }
}

if (isset($codigoProducto)) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.presentacion, pd.precio_venta from producto pd
            INNER JOIN proveedor pr ON pd.codigo_proveedor = pr.codigo_proveedor
            INNER JOIN tipo_producto tp ON pd.codigo_tipoproducto = tp.codigo_tipoproducto
            WHERE pd.codigo_producto = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoProducto));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Venta Producto</title>
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
                                Verificacion de datos de venta
                            </div>

                            <div class="panel-body">

                                <div class="col-lg-12">
                                    <p>
                                        <a href="mostrarRegistroVenta.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                    </p>
                                    <h3>Venta de Productos</h3>
                                    <?php
                                    if (isset($errorStock)) {
                                        echo "<label class='checkbox' style='color: red'>" . $errorStock . "</label>";
                                    }
                                    ?>

                                    <form class="form-horizontal" action="ventaProductos.php" method="post" name="compra">

                                        <input type="hidden" name="codigoProducto" value="<?php echo!empty($codigoProducto) ? $codigoProducto : ''; ?>">

                                        <div class="control-group">
                                            <label class="control-label">Producto</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo isset($data) ? $data['nombre_producto'] : $codigoProducto; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Presentación</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['presentacion']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Precio Venta</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['precio_venta']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Proveedor</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['nombre_empresa']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Tipo de Producto</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['nombre_tipoproducto']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($cantidadError) ? 'error' : ''; ?>">
                                            <label class="control-label">Cantidad</label>
                                            <div class="controls">
                                                <input name="cantidad" type="text"  placeholder="Ingrese cantidad en unidades" value="<?php echo!empty($cantidad) ? $cantidad : ''; ?>">
                                            </div>
                                        </div>

                                        <br>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Agregar al carrito</button>
                                            <a class="btn btn-default" href="mostrarRegistroVenta.php">Regresar</a>

                                        </div>
                                    </form>
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