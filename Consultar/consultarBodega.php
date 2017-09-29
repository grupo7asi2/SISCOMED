<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';
$codigoBodega = null;
if (!empty($_GET['codigoBodega'])) {
    $codigoBodega = $_REQUEST['codigoBodega'];
}

if (null == $codigoBodega) {
    header("Location: ../Show/mostrarRegistroBodega.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM bodega where codigo_bodega = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoBodega));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantto. Bodega</title>
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
                    <h1 class="page-header">Bodega</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Consultar Bodega
                       </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">


                                    <div class="form-horizontal" >
                                        <div class="control-group">
                                            <label class="control-label">Codigo Bodega</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['codigo_bodega']; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-horizontal" >
                                        <div class="control-group">
                                            <label class="control-label">Nombre Bodega</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['nombre_bodega']; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-horizontal" >
                                        <div class="control-group">
                                            <label class="control-label">Teléfono Bodega</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['telefono']; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-horizontal" >
                                        <div class="control-group">
                                            <label class="control-label">Dirección Bodega</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['direccion']; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-horizontal" >
                                        <div class="control-group">
                                            <label class="control-label">Descripción</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <?php echo $data['descripcion']; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                     <br>

                                    <div class="form-actions">
                                
                                        <a class="btn btn-default" href="../Show/mostrarRegistroBodega.php">Regresar</a>
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
     <script src="../assets/plugins/jquery-1.10.2.js"></script>
    <script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/plugins/pace/pace.js"></script>
    <script src="../assets/scripts/siminta.js"></script> 
    </body>
</html>