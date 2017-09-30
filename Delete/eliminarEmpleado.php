<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';
$codigoEmpleado = 0;

if (!empty($_GET['codigoEmpleado'])) {
    $codigoEmpleado = $_REQUEST['codigoEmpleado'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT nombre_empleado, apellido_empleado from empleado WHERE codigo_empleado = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoEmpleado));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}

if (!empty($_POST)) {
    // keep track post values
    $codigoEmpleado = $_POST['codigoEmpleado'];
    try {
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM empleado WHERE codigo_empleado = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($codigoEmpleado));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroEmpleado.php");
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
        <title>Mantto. Emp</title>
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
                        <h1 class="page-header">Empleado</h1>
                    </div>
                    <!--End Page Header -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Eliminar Empleado

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">

                                        <h3>Eliminar Empleado</h3>

                                        <form class="form-horizontal" action="../Delete/eliminarEmpleado.php" method="post">
                                            <input type="hidden" name="codigoEmpleado" value="<?php echo $codigoEmpleado; ?>"/>
                                            <?php if (!isset($errorEliminar)) { ?>
                                                <p class="alert alert-error">Esta Seguro que desea eliminar al empleado <b><?php echo $data['nombre_empleado'], ' ', $data['apellido_empleado']; ?></b>?</p>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-danger">Si </button>
                                                    <a class="btn btn-default" href="../Show/mostrarRegistroEmpleado.php">No</a>
                                                </div>
                                            <?php } else { ?>
                                                <p class="alert alert-error"><?php echo $errorEliminar; ?></p>
                                                <div class="form-actions">
                                                    <a class="btn btn-default" href="../Show/mostrarRegistroEmpleado.php">Regresar</a>
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