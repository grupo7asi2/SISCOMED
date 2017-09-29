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
        <title>Mantenimientos</title>
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
                        <h1 class="page-header"> Mantenimientos Principales</h1>
                    </div>
                    <!--End Page Header -->
                </div>
                
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="alert alert-info">
                            <strong>Bienvenido a los Sub mantenimientos. </strong> 
                        </div>
                    </div>
                </div>
                <!-- /. ROW  --> 

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="Show/mostrarRegistroCargo.php" >
                            <i class="fa fa-clipboard fa-5x"></i>
                            <h4>Cargo</h4>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="Show/mostrarRegistroTipoProducto.php" >
                            <i class="fa fa-clipboard fa-5x"></i>
                            <h4>Tipo Producto</h4>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="Show/mostrarRegistroTipoUsuario.php" >
                            <i class="fa fa-clipboard fa-5x"></i>
                            <h4>Tipo Usuario</h4>
                        </a>
                    </div>
                </div>
                <!-- end page-wrapper -->
            </div>
            <!-- end wrapper -->

            <!-- Core Scripts - Include with every page -->
            <script src="assets/plugins/jquery-1.10.2.js"></script>
            <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
            <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
            <script src="assets/plugins/pace/pace.js"></script>
            <script src="assets/scripts/siminta.js"></script>
    </body>
</html>