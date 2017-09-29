<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';

$codigoTipoUsuario = filter_input(INPUT_GET, 'codigoTipoUsuario');
if (!empty($codigoTipoUsuario)) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM tipo_usuario where codigo_tipoUsuario = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoTipoUsuario));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    $nombreTipoUsuario = $data['nombre_tipoUsuario'];
}

if (null == $codigoTipoUsuario) {
    header("Location: ../Show/mostrarRegistroTipoUsuario.php");
}

if (!empty($_POST)) {
    // keep track validation errors

    $nombreTipoUsuarioError = null;

    // keep track post values

    $nombreTipoUsuario = $_POST['nombreTipoUsuario'];

    // validate input
    $valid = true;
    if (empty($nombreTipoUsuario)) {
        $nombreTipoUsuarioError = 'Ingrese el nombre';
        $valid = false;
    }

    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tipo_usuario set nombre_tipoUsuario= ? WHERE codigo_tipoUsuario = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($nombreTipoUsuario, $codigoTipoUsuario));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroTipoUsuario.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM tipo_usuario where codigo_tipoUsuario = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoTipoUsuario));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantto. Tipo Usuario</title>
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
                    <h1 class="page-header">Tipo Usuario</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Actualizar Tipo Usuario
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form class="form-horizontal" action="../Actualizar/actualizarTipoUsuario.php?codigoTipoUsuario=<?php echo $codigoTipoUsuario ?>" method="post">

                                        <!--ingreso del codigo del paciente -->
                                        <div class="control-group <?php echo!empty($nombreTipoUsuarioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre tipo de usuario</label>
                                            <div class="controls">
                                                <input name="nombreTipoUsuario" type="text"  placeholder="Nombre de Tipo Usuario" value="<?php echo!empty($nombreTipoUsuario) ? $nombreTipoUsuario : ''; ?>">
                                                <?php if (!empty($nombreTipoUsuarioError)): ?>
                                                    <span class="help-inline"><?php echo $nombreTipoUsuarioError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        
                                        </br>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Actualizar</button>
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