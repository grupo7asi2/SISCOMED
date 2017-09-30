<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}

require '../database.php';
$codigoUsuario = 0;

if (!empty($_GET['codigoUsuario'])) {
    $codigoUsuario = $_REQUEST['codigoUsuario'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT u.usuario_login, concat(e.nombre_empleado, ' ', e.apellido_empleado) AS empleado from usuario u "
            . "INNER JOIN empleado e ON u.codigo_empleado = e.codigo_empleado "
            . "where u.codigo_usuario = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoUsuario));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}

if (!empty($_POST)) {
    // keep track post values
    $codigoUsuario = $_POST['codigoUsuario'];
    try {
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM usuario WHERE codigo_usuario = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($codigoUsuario));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroUsuario.php");
    } catch (Exception $ex) {
        $errorEliminar = "No se puede eliminar este elemento, consulte con el Administrador.";
    }
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
                                Eliminar Usuario

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h3>Eliminar Usuario</h3>
                                        <form class="form-horizontal" action="../Delete/eliminarUsuario.php" method="post">
                                            <input type="hidden" name="codigoUsuario" value="<?php echo $codigoUsuario; ?>"/>
                                            <?php if (!isset($errorEliminar)) { ?>
                                                <p class="alert alert-error">¿Esta Seguro que desea eliminar usuario <b> <?php echo $data['usuario_login']; ?></b> del empleado <b><?php echo $data['empleado']; ?></b>?</p>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-danger">Si</button>
                                                    <a class="btn btn-default" href="../Show/mostrarRegistroUsuario.php">No</a>
                                                <?php } else { ?>
                                                    <p class="alert alert-error"><?php echo $errorEliminar; ?></p>
                                                    <div class="form-actions">
                                                        <a class="btn btn-default" href="../Show/mostrarRegistroTipoProducto.php">Regresar</a>
                                                    </div>
                                                </div>
                                            <?php } ?>
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