<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';

$codigoCargo = null;
if (!empty($_GET['codigoCargo'])) {
    $codigoCargo = $_REQUEST['codigoCargo'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM cargo where codigo_cargo = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoCargo));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    $nombreCargo = $data['nombre_cargo'];
}

if (null == $codigoCargo) {
    header("Location: ../Show/mostrarRegistroCargo.php");
}

if (!empty($_POST)) {
    // keep track validation errors
    $nombreCargoError = null;

    // keep track post values
    $nombreCargo = $_POST['nombreCargo'];

    // validate input
    $valid = true;
    if (empty($nombreCargo)) {
        $nombreCargoError = 'Ingrese el nombre';
        $valid = false;
    }

    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE cargo set nombre_cargo = ? WHERE codigo_cargo = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($nombreCargo, $codigoCargo));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroCargo.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM cargo where codigo_cargo = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoCargo));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantto. Cargo</title>
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
                    <h1 class="page-header">Cargo</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Actualizar Cargo
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">


                                    <form class="form-horizontal" action="../Actualizar/actualizarCargo.php?codigoCargo=<?php echo $codigoCargo ?>" method="post">

                                        <!--ingreso del codigo del paciente -->
                                        <div class="control-group <?php echo!empty($nombreCargoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre del cargo</label>
                                               <br>
                                                  <br>
                                            <div class="controls">
                                                <input name="nombreCargo" type="text"  placeholder="Nombre del cargo" value="<?php echo!empty($nombreCargo) ? $nombreCargo : ''; ?>">
                                                <?php if (!empty($nombreCargoError)): ?>
                                                    <span class="help-inline"><?php echo $nombreCargoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                          <br>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                            <a class="btn" href="../Show/mostrarRegistroCargo.php">Regresar</a>
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