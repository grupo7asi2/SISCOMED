<?php session_start(); 
    if (!isset($_SESSION['idUsuario'])){
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
            <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header"> Mantenimientos Principales</h1>
                    
                </div>
                
                <!-- /. ROW  -->
                  <hr />
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="alert alert-info">
                             <strong>Bienvenido a los mantenimiento principales. </strong> 
                        </div>
                       
                    </div>
                    </div>
                    
                 
                 
                 
              <div class="row">
                 <!--  page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Mantenimiento Tipo Producto</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mantenimiento Tipo Producto
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                
                                

                                    <p>

                                        <a href="../Crear/crearTipoProducto.php" class="btn btn-success">Agregar Tipo Producto</a>
                                    </p>
                                    
                                        <thead>
                                            <tr>
                                                <th>Codigo Tipo Producto</th>
                                                <th>Nombre Tipo Producto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../database.php';
                                            $pdo = Database::connect();
                                            $sql = 'SELECT * FROM tipo_producto ORDER BY codigo_tipoproducto ASC';
                                            foreach ($pdo->query($sql) as $row) {
                                                echo '<tr>';
                                                echo '<td>' . $row['codigo_tipoproducto'] . '</td>';
                                                echo '<td>' . $row['nombre_tipoproducto'] . '</td>';
                                                echo '<td width=300>';
                                                echo '<a class="btn btn-primary" href="../Consultar/consultarTipoProducto.php?codigoTipoProducto=' . $row['codigo_tipoproducto'] . '">Consultar</a>';
                                                echo '&nbsp;';
                                                echo '<a class="btn btn-success" href="../Actualizar/actualizarTipoProducto.php?codigoTipoProducto=' . $row['codigo_tipoproducto'] . '">Actualizar</a>';
                                                echo '&nbsp;';
                                                echo '<a class="btn btn-danger" href="../Delete/eliminarTipoProducto.php?codigoTipoProducto=' . $row['codigo_tipoproducto'] . '">Eliminar</a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            Database::disconnect();
                                            ?>
                                        </tbody>
                                    </table>

                                    <p>

                                        <a class="btn btn-default" href="../submantenimientos.php">Regresar Menu</a>

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
        <script src="../assets/plugins/jquery-1.10.2.js"></script>
    <script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/plugins/pace/pace.js"></script>
    <script src="../assets/scripts/siminta.js"></script>
    
     <script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    </body>
</html>