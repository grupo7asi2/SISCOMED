<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}

require '../database.php';
$codigoUsuario = null;
if (!empty($_GET['codigoUsuario'])) {
    $codigoUsuario = $_REQUEST['codigoUsuario'];
}

if (null == $codigoUsuario) {
    header("Location: ../Show/mostrarRegistroUsuario.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT u.codigo_usuario, tu.nombre_tipoUsuario, concat(e.nombre_empleado, ' ', e.apellido_empleado) AS empleado , "
            . "u.usuario_login, u.password_usuario from usuario u "
            . "INNER JOIN tipo_usuario tu ON u.codigo_tipoUsuario = tu.codigo_tipoUsuario "
            . "INNER JOIN empleado e ON u.codigo_empleado = e.codigo_empleado "
            . "WHERE u.codigo_usuario = ?";

    $q = $pdo->prepare($sql);
    $q->execute(array($codigoUsuario));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mantto. Uuario</title>
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
                        <h1 class="page-header">Usuario</h1>
                    </div>
                    <!--End Page Header -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Consultar Usuario
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-horizontal" >
                                            <div class="control-group">
                                                <label class="control-label">Codigo Usuario</label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <?php echo $data['codigo_usuario']; ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Tipo Usuario</label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <?php echo $data['nombre_tipoUsuario']; ?>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Empleado</label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <?php echo $data['empleado']; ?>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Nombre de Usuario</label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <?php echo $data['usuario_login']; ?>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Contraseña </label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <?php echo $data['password_usuario']; ?>
                                                    </label>
                                                </div>
                                            </div>



                                            <div class="form-actions">

                                                <a class="btn btn-default" href="../Show/mostrarRegistroUsuario.php">Regresar</a>
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
        </div>
    </body>
</html>