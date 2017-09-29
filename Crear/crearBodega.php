<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';

if (!empty($_POST)) {
    // keep track validation errors
    $BodegaError = null;
    $telefonoError = null;
    $direccionError = null;

    // keep track post values
    $bodega = $_POST['bodega'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    // validate input
    $valid = true;

    if (empty($bodega)) {
        $$bodega = 'Ingrese un nombre';
        $valid = false;
    }

    if (empty($telefono)) {
        $telefono = 'Ingrese un teléfono';
        $valid = false;
    }

    if (empty($direccion)) {
        $direccion = 'Ingrese la dirección';
        $valid = false;
    }

    if (empty($descripcion)) {
        $descripcion = '';
    } else {
        $descripcion = $_POST['descripcion'];
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO bodega (nombre_bodega, telefono, direccion, descripcion) values (?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($bodega, $telefono, $direccion, $descripcion));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroBodega.php");
    }
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
                                Agregar Bodega
                            </div>

                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-lg-12">

                                        <p>
                                            <a href="../Show/mostrarRegistroProducto.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Agregar Bodega</h3>


                                        <form class="form-horizontal" action="../Crear/crearBodega.php" method="post">

                                            <div class="control-group">
                                                <label class="control-label">Codigo de Bodega</label>
                                                <div class="controls">
                                                    <input name="codigoBodega" type="text" disabled="true" value="">
                                                </div>
                                            </div>

                                            <div class="control-group <?php echo!empty($bodega) ? 'error' : ''; ?>">
                                                <label class="control-label">Nombre Bodega</label>
                                                <div class="controls">
                                                    <input name="bodega" type="text"  placeholder="Ingrese el nombre " value="<?php echo!empty($bodega) ? $bodega : ''; ?>">
                                                    <?php if (!empty($BodegaError)): ?>
                                                        <span class="help-inline"><?php echo $BodegaError; ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="control-group <?php echo!empty($direccion) ? 'error' : ''; ?>">
                                                <label class="control-label">Dirección de Bodega</label>
                                                <div class="controls">
                                                    <input name="direccion" type="text" required  placeholder="Ingrese la dirección" value="<?php echo!empty($direccion) ? $direccion : ''; ?>">
                                                    <?php if (!empty($direccionError)): ?>
                                                        <span class="help-inline"><?php echo $direccionError; ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="control-group <?php echo!empty($telefono) ? 'error' : ''; ?>">
                                                <label class="control-label">Teléfono</label>
                                                <div class="controls">
                                                    <input name="telefono" type="text"  placeholder="Ingrese el teléfono" value="<?php echo!empty($telefono) ? $telefono : ''; ?>">
                                                    <?php if (!empty($telefonoError)): ?>
                                                        <span class="help-inline"><?php echo $telefonoError; ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Descripción</label>
                                                <div class="controls">
                                                    <textarea name="descripcion" rows="5" cols="40" placeholder="Ingrese una descripción" ><?php echo!empty($descripcion) ? $descripcion : ''; ?></textarea>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-success">Crear</button>
                                                <a class="btn btn-default" href="../Show/mostrarRegistroBodega.php">Regresar</a>

                                            </div>
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
