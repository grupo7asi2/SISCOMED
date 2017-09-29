<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';
$codigoProducto = null;
if (!empty($_GET['codigoProducto'])) {
    $codigoProducto = $_REQUEST['codigoProducto'];
}

if (null == $codigoProducto) {
    header("Location: ../Show/mostrarRegistroProducto.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.presentacion, pd.precio_venta, pd.precio_compra from producto pd
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
    <title>Mantto. Producto</title>
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
            <!-- end navbar side --><!-- navbar top -->
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Producto</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Consultar Producto
                       </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-horizontal" >
                                        <div class="control-group">
                                            <label class="control-label">Codigo de Producto</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['codigo_producto']; ?>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Nombre del Producto</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['nombre_producto']; ?>
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

                                        <div class="control-group">
                                            <label class="control-label">Presentación</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['presentacion']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Precio de Compra</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['precio_compra']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Precio de Venta</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['precio_venta']; ?>
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-actions">
                                           
                                            <a class="btn btn-default" href="../Show/mostrarRegistroProducto.php">Regresar</a>
                                        </div>

                                    </div>
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
     <script src="../assets/plugins/jquery-1.10.2.js"></script>
    <script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/plugins/pace/pace.js"></script>
    <script src="../assets/scripts/siminta.js"></script> 


    </body>
</html>