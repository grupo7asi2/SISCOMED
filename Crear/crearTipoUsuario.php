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
    $codigoTipoUsuarioError = null;
    $nombreTipoUsuarioError = null;

    // keep track post values
    $codigoTipoUsuario = $_POST['codigoTipoUsuario'];
    $nombreTipoUsuario = $_POST['nombreTipoUsuario'];

    // validate input
    $valid = true;

    if (empty($nombreTipoUsuario)) {
        $nombreTipoUsuarioError = 'Ingrese el nombre el Tipo Usuario';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tipo_usuario (codigo_tipoUsuario, nombre_tipoUsuario) values(?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($codigoTipoUsuario, $nombreTipoUsuario));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroTipoUsuario.php");
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantto. Tipo Producto</title>
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
                    <h1 class="page-header">Tipo Usuario</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Agregar Tipo Usuario
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                
                               <div class="col-lg-12">

                                            <a href="../Show/mostrarRegistroTipoUsuario.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Agregar Tipo de Usuario</h3>
                                

                                    <form class="form-horizontal" action="crearTipoUsuario.php" method="post">
                                        <div class="control-group <?php echo!empty($codigoTipoUsuarioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Codigo Tipo Usuario</label>
                                            <div class="controls">
                                                <input name="codigoTipoUsuario" type="text"  disabled="true" value="">
                                            </div>
                                        </div>
                                        <!--ingreso del codigo del paciente -->
                                        <div class="control-group <?php echo!empty($nombreTipoUsuarioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre del Tipo Usuario</label>
                                            <div class="controls">
                                                <input name="nombreTipoUsuario" type="text"  placeholder="Ingrese el nombre " value="<?php echo!empty($nombreTipoUsuario) ? $nombreTipoUsuario : ''; ?>">
                                                <?php if (!empty($nombreTipoUsuarioError)): ?>
                                                    <span class="help-inline"><?php echo $nombreTipoUsuarioError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <br>


                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Crear</button>
                                            <a class="btn btn-default" href="../Show/mostrarRegistroTipoUsuario.php">Regresar</a>
                                           
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