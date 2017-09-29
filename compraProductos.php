<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}

require 'database.php';

$codigoProducto = filter_input(INPUT_GET, 'codigoProducto');

if (!empty($_POST)) {
    // keep track validation errors
    $cantidadError = NULL;
    $fechaVencimientoError = NULL;
    $codigoProducto = $_POST['codigoProducto'];
    // keep track post values
    $cantidad = $_POST['cantidad'];
    $fechaVencimiento = $_POST['fechaVencimiento'];
    // validate input
    $valid = true;

    if (empty($cantidad)) {
        $cantidadError = 'Ingrese la cantidad a adquirir';
        $valid = false;
    }
    if (empty($fechaVencimiento)) {
        $fechaVencimientoError = 'Ingrese fecha de Vencimiento';
        $valid = false;
    }

    if ($valid) {
        header("Location: mostrarDetalleCompra.php?codigoProducto=" . $codigoProducto . "&cantidad=" . $cantidad . "&fechaVenc=" . $fechaVencimiento);
    }
}

if (isset($codigoProducto)) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.presentacion, pd.precio_compra from producto pd
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
        <title>Compra Producto</title>
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

                                        <p>
                                            <a href="mostrarRegistroCompra.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Compra de Productos</h3>

                                        <form class="form-horizontal" action="compraProductos.php" method="post" name="compra">

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
                                                <label class="control-label">Precio Compra</label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <?php echo $data['precio_compra']; ?>
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
                                                <label class="control-label">Cantidad a adquirir</label>
                                                <div class="controls">
                                                    <input name="cantidad" type="text"  placeholder="Ingrese cantidad en unidades" value="<?php echo!empty($cantidad) ? $cantidad : ''; ?>">
                                                </div>
                                            </div>

                                            <div class="control-group <?php echo!empty($fechaVencimientoError) ? 'error' : ''; ?>">
                                                <label class="control-label">Fecha de Vencimiento</label>
                                                <div class="controls">
                                                    <input name="fechaVencimiento" type="date"  value="<?php echo!empty($fechaVencimiento) ? $fechaVencimiento : ''; ?>">
                                                    <?php if (!empty($fechaVencimientoError)): ?>
                                                        <span class="help-inline"><?php echo $fechaVencimientoError; ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-actions">
                                                <?php // echo '<a class="btn btn-success" href="mostrarDetalleCompra?codigoProducto=' . $data['codigo_producto'] . '&cant=' . $cantidad . '">Agregar para Compra</a>'; ?>
                                                <button type="submit" class="btn btn-success">Agregar para Compra</button>
                                                <a class="btn btn-default" href="mostrarRegistroCompra.php">Regresar</a>

                                            </div>
                                        </form>
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