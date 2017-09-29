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
    $nombreCargoError = null;


    // keep track post values
    $nombreCargo = $_POST['nombreCargo'];

    // validate input
    $valid = true;

    if (empty($nombreCargo)) {
        $nombreCargo = 'Ingrese un nombre';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO cargo (nombre_cargo) values (?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nombreCargo));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroCargo.php");
    }
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
            <!-- end navbar side -->
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
                           Agregar Cargo
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">


 <p>
                                            <a href="../Show/mostrarRegistroCargo.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Agregar Cargo</h3>
                                   

                                    <form class="form-horizontal" action="crearCargo.php" method="post">
                                        <div class="control-group <?php echo!empty($codigoCargoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Codigo del Cargo</label>
                                            <div class="controls">
                                                <input name="codigoCargo" type="text"  disabled="true" value="<?php echo!empty($codigoCargo) ? $codigoCargo : ''; ?>">
                                            </div>
                                        </div>
                                        
                                          <br>
                                        <!--ingreso del codigo del paciente -->
                                        <div class="control-group <?php echo!empty($nombreCargo) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre Cargo</label>
                                            <div class="controls">
                                                <input name="nombreCargo" type="text" required  placeholder="Ingrese el nombre " value="<?php echo!empty($nombreCargo) ? $nombreCargo : ''; ?>">
                                                <?php if (!empty($nombreCargoError)): ?>
                                                    <span class="help-inline"><?php echo $nombreCargooError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                          <br>
                                            <br>
                                        
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Crear</button>
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
      
            

   
        <!-- end page-wrapper -->

  
    <!-- end wrapper -->

     <script src="../assets/plugins/jquery-1.10.2.js"></script>
    <script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/plugins/pace/pace.js"></script>
    <script src="../assets/scripts/siminta.js"></script>                  
                                       
       
    </body>

</html>