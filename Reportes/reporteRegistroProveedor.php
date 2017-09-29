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
    <title>Mantto. Proveedor</title>
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
                    <h1 class="page-header">Mantenimiento Proveedor</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mantenimiento Proveedor
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                
                                <p>

                                        <a href="../Crear/crearProveedor.php" class="btn btn-success">Agregar Proveedor</a>
                                    </p>
                                        <thead>
                                            <tr>
                                                <th>Codigo Proveedor</th>
                                                <th>Empresa</th>
                                                <th>Direccion</th>
                                                <th>Representante</th>
                                                <th>Identificación</th>
                                                <th>Telefono</th>
                                                <th>Correo</th>
                                                <th>Comentario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../database.php';
                                            $pdo = Database::connect();
                                            $sql = 'SELECT codigo_proveedor, nombre_empresa, direccion, representante_empresa, identificacion, telefono, correo, comentario FROM proveedor ORDER BY codigo_proveedor ASC';
                                            foreach ($pdo->query($sql) as $row) {
                                                echo '<tr>';
                                                echo '<td>' . $row['codigo_proveedor'] . '</td>';
                                                echo '<td>' . $row['nombre_empresa'] . '</td>';
                                                echo '<td>' . $row['direccion'] . '</td>';
                                                echo '<td>' . $row['representante_empresa'] . '</td>';
                                                echo '<td>' . $row['identificacion'] . '</td>';
                                                echo '<td>' . $row['telefono'] . '</td>';
                                                echo '<td>' . $row['correo'] . '</td>';
                                                echo '<td>' . $row['comentario'] . '</td>';

                                                echo '<td width=300>';
                                                echo '<a class="btn btn-primary" href="../Consultar/consultarProveedor.php?codigoProveedor=' . $row['codigo_proveedor'] . '">Consultar</a>';
                                                echo '&nbsp;';
                                                echo '<a class="btn btn-success" href="../Actualizar/actualizarProveedor.php?codigoProveedor=' . $row['codigo_proveedor'] . '">Actualizar</a>';
                                                echo '&nbsp;';
                                                echo '<a class="btn btn-danger" href="../Delete/eliminarProveedor.php?codigoProveedor=' . $row['codigo_proveedor'] . '">Eliminar</a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            Database::disconnect();
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
