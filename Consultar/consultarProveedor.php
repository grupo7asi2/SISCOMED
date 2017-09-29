<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';
$codigoProveedor = null;
if (!empty($_GET['codigoProveedor'])) {
    $codigoProveedor = $_REQUEST['codigoProveedor'];
}

if (null == $codigoProveedor) {
    header("Location: ../Show/mostrarRegistroProveedor.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_proveedor, nombre_empresa, direccion, representante_empresa, identificacion, telefono, correo, comentario FROM proveedor WHERE codigo_proveedor = '" . $codigoProveedor . "'";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoProveedor));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantto. Cargo</title>
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
                    <h1 class="page-header">Proveedor</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Consultar Proveedo
                     
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-horizontal" >
                                        <div class="control-group">
                                            <label class="control-label">Codigo Proveedor</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['codigo_proveedor']; ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Empresa</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['nombre_empresa']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Direccion</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['direccion']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Representante</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['representante_empresa']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Identificación </label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['identificacion']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Teléfono</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['telefono']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Correo</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['correo']; ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Comentario</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['comentario']; ?>
                                                </label>
                                            </div>
                                        </div>
                                        
                                         <br>

                                        <div class="form-actions">
                                           
                                            <a class="btn btn-default" href="../Show/mostrarRegistroProveedor.php">Regresar</a>
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