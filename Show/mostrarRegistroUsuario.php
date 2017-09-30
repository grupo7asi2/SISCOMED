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
        <title>Mantto. Usuario</title>
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
                    <div class="row">
                        <!--  page header -->
                        <div class="col-lg-12">
                            <h1 class="page-header">Mantenimiento Usuario</h1>
                        </div>
                        <!-- end  page header -->
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Advanced Tables -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Mantenimiento Usuario
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                            <p>
                                                <a href="../Crear/crearUsuario.php" class="btn btn-success">Agregar Usuario</a>
                                            </p>

                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Tipo Usuario</th>
                                                    <th>Empleado</th>
                                                    <th>Usuario Login</th>
                                                    <th>Contraseña</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include '../database.php';
                                                $pdo = Database::connect();
                                                $sql = "SELECT u.codigo_usuario, tu.nombre_tipoUsuario, concat(e.nombre_empleado, ' ', e.apellido_empleado) AS empleado , u.usuario_login, u.password_usuario from usuario u "
                                                        . "INNER JOIN tipo_usuario tu ON u.codigo_tipoUsuario = tu.codigo_tipoUsuario "
                                                        . "INNER JOIN empleado e ON u.codigo_empleado = e.codigo_empleado";
                                                foreach ($pdo->query($sql) as $row) {
                                                    echo '<tr>';
                                                    echo '<td>' . $row['codigo_usuario'] . '</td>';
                                                    echo '<td>' . $row['nombre_tipoUsuario'] . '</td>';
                                                    echo '<td>' . $row['empleado'] . '</td>';
                                                    echo '<td>' . $row['usuario_login'] . '</td>';
                                                    echo '<td>' . $row['password_usuario'] . '</td>';

                                                    echo '<td width=300>';
                                                    echo '<a class="btn btn-primary" href="../Consultar/consultarUsuario.php?codigoUsuario=' . $row['codigo_usuario'] . '">Consultar</a>';
                                                    echo '&nbsp;';
                                                    echo '<a class="btn btn-success" href="../Actualizar/actualizarUsuario.php?codigoUsuario=' . $row['codigo_usuario'] . '">Actualizar</a>';
                                                    echo '&nbsp;';
                                                    echo '<a class="btn btn-danger" href="../Delete/eliminarUsuario.php?codigoUsuario=' . $row['codigo_usuario'] . '">Eliminar</a>';
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
