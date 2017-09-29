<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require_once 'db_cliente.php';
$cliente = new cliente();
$html = $cliente->obtener_empleado();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de empleados</title>
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
              <div class="row">
                 <!--  page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Reporte de Empleados</h1>
                </div>
                 <!-- end  page header -->
            </div>

               <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                Filtros
                            </div>
                            <div class="panel-body">
                               <form target="blank" action="pdf/reporteEmpleado.php" method="POST">
                               <div class="input-group">
                                  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user fa"></i></span>
                                  <input id="texto" name="texto" type="text" class="form-control" placeholder="Busque por cualquier campo" aria-describedby="basic-addon1">
                                </div>
                            </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Reporte de Empleados
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <p>
                                <input type="submit" href="pdf/reporteEmpleado.php" class="btn btn-danger" value="Imprimir Reporte">
                                </form>
                                    </p>
                                    
                                    
                                    <thead>
                                            <tr>
                                                <th>Codigo Empleado</th>
                                                <th>Nombres Empleado</th>
                                                <th>Apellidos Empleado</th>
                                                <th>Cargo</th>
                                                <th>Correo</th>
                                                <th>Telefono</th>
                                                <th>Fecha Ingreso</th>
                                                <th>DUI</th>

                                            </tr>
                                        </thead>
                                        <tbody id="listado">
                                            <?php
                                                echo $html;
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
                 $('#texto').keyup(function(){
                var texto = $('#texto').val();
                
                 $.ajax({
                    url:"select_empleado.php",
                    method:"post",
                    data:{valor: texto},
                    success:function(data){
                        $('#listado').html(data);
                        console.log(data);
                    }
                });


            });
            });



        </script>


</body>

</html>

