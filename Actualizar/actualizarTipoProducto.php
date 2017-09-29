<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';

$codigoTipoProducto = filter_input(INPUT_GET, 'codigoTipoProducto');
if (!empty($codigoTipoProducto)) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM tipo_producto where codigo_tipoproducto = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoTipoProducto));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    $nombreTipoProducto = $data['nombre_tipoproducto'];
}

if (null == $codigoTipoProducto) {
    header("Location: ../Show/mostrarRegistroTipoProducto.php");
}

if (!empty($_POST)) {
    // keep track validation errors
    $nombreTipoProductoError = null;

    // keep track post values
    $nombreTipoProducto = $_POST['nombreTipoProducto'];

    // validate input
    $valid = true;
    if (empty($nombreTipoProducto)) {
        $nombreTipoProductoError = 'Ingrese el nombre';
        $valid = false;
    }

    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tipo_producto set nombre_tipoproducto= ? WHERE codigo_tipoproducto = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($nombreTipoProducto, $codigoTipoProducto));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroTipoProducto.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM tipo_producto where codigo_tipoproducto = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoTipoProducto));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantto. Tipo Producto</title>
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
                    <h1 class="page-header">TipoProducto</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Actualizar TipoProducto
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form class="form-horizontal" action="../Actualizar/actualizarTipoProducto.php?codigoTipoProducto=<?php echo $codigoTipoProducto ?>" method="post">

                                        <!--ingreso del codigo del paciente -->
                                        <div class="control-group <?php echo!empty($nombreTipoProductoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre tipo de producto</label>
                                            <div class="controls">
                                                <input name="nombreTipoProducto" type="text"  placeholder="Nombre de Tipo Producto" value="<?php echo!empty($nombreTipoProducto) ? $nombreTipoProducto : ''; ?>">
                                                <?php if (!empty($nombreTipoProductoError)): ?>
                                                    <span class="help-inline"><?php echo $nombreTipoProductoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        
                                        </br>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                            <a class="btn btn-default" href="../Show/mostrarRegistroTipoProducto.php">Regresar</a>
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
    <script src="../assets/plugins/jquery-1.10.2.js"></script>
    <script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/plugins/pace/pace.js"></script>
    <script src="../assets/scripts/siminta.js"></script> 


    </body>

</html>