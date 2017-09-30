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
    <title>Mantto. Cliente</title>
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
                    <h1 class="page-header">Mantenimiento Cliente</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mantenimiento Cliente
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                
                                <p>

                                        <a href="../Crear/crearCliente.php" class="btn btn-success">Agregar Clientes</a>
                                    </p>
                                    
                                    
                                        <thead>
                                            <tr>
                                                <th>Codigo Cliente</th>
                                                <th>Nombre Cliente</th>
                                                <th>Apellidos Cliente</th>
                                                <th>Correo</th>
                                                <th>Telefono</th>
                                                <th>Direccion</th>
                                                <th>Departamento</th>
                                                <th>Municipio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../database.php';
                                            $pdo = Database::connect();
                                            $sql = 'SELECT codigo_cliente,nombre_cliente,apellido_cliente,correo,telefono,direccion,departamento,municipio FROM cliente ORDER BY codigo_cliente ASC';
                                            foreach ($pdo->query($sql) as $row) {
                                                echo '<tr>';
                                                echo '<td>' . $row['codigo_cliente'] . '</td>';
                                                echo '<td>' . $row['nombre_cliente'] . '</td>';
                                                echo '<td>' . $row['apellido_cliente'] . '</td>';
                                                echo '<td>' . $row['correo'] . '</td>';
                                                echo '<td>' . $row['telefono'] . '</td>';
                                                echo '<td>' . $row['direccion'] . '</td>';
                                                echo '<td>' . $row['departamento'] . '</td>';
                                                echo '<td>' . $row['municipio'] . '</td>';


                                                echo '<td width=300>';
                                                echo '<a class="btn btn-primary" href="../Consultar/consultarCliente.php?codigoCliente=' . $row['codigo_cliente'] . '">Consultar</a>';
                                                echo '&nbsp;'; 
                                                echo '<a class="btn btn-success" href="../Actualizar/actualizarCliente.php?codigoCliente=' . $row['codigo_cliente'] . '">Actualizar</a>';
                                                echo '&nbsp;';
                                                echo '<a class="btn btn-danger" href="../Delete/eliminarCliente.php?codigoCliente=' . $row['codigo_cliente'] . '">Eliminar</a>';
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


