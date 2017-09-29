<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}

require '../database.php';

$codigoBodega = null;
if (!empty($_GET['codigoBodega'])) {
    $codigoBodega = $_REQUEST['codigoBodega'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM bodega where codigo_bodega = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoBodega));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    $bodega = $data['nombre_bodega'];
    $telefono = $data['telefono'];
    $direccion = $data['direccion'];
    $descripcion = $data['descripcion'];
}

if (null == $codigoBodega) {
    header("Location: ../Show/mostrarRegistroBodega.php");
}

if (!empty($_POST)) {
    // keep track validation errors
    $bodegaError = null;
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

    if (empty($descripcion)){
        $descripcion='';
    } else{
        $descripcion=$_POST['descripcion'];
    }
    
    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE bodega set nombre_bodega=?, telefono=?, direccion=?, descripcion=? WHERE codigo_bodega=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($bodega, $telefono, $direccion, $descripcion, $codigoBodega));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroBodega.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM bodega where codigo_bodega = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($codigoBodega));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantto. Producto</title>
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
                           Actualizar Bodega
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form class="form-horizontal" action="../Actualizar/actualizarBodega.php?codigoBodega=<?php echo $codigoBodega ?>" method="post">

                                        <div class="control-group <?php echo!empty($bodegaError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre de la Bodega</label>
                                            <div class="controls">
                                                <input name="bodega" type="text"  placeholder="Nombre de Bodega" value="<?php echo!empty($bodega) ? $bodega : ''; ?>">
                                                <?php if (!empty($bodegaError)): ?>
                                                    <span class="help-inline"><?php echo $bodegaError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group <?php echo!empty($telefonoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre del cargo</label>
                                            <div class="controls">
                                                <input name="telefono" type="text"  placeholder="Teléfono" value="<?php echo!empty($telefono) ? $telefono : ''; ?>">
                                                <?php if (!empty($telefonoError)): ?>
                                                    <span class="help-inline"><?php echo $telefonoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group <?php echo!empty($direccionError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre del cargo</label>
                                            <div class="controls">
                                                <input name="direccion" type="text"  placeholder="Dirección de Bodega" value="<?php echo!empty($direccion) ? $direccion : ''; ?>">
                                                <?php if (!empty($direccionError)): ?>
                                                    <span class="help-inline"><?php echo $direccionError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Descripción</label>
                                            <div class="controls">
                                                <textarea name="descripcion" rows="5" cols="40" placeholder="Ingrese una descripción" ><?php echo !empty($descripcion) ? $descripcion: '';?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Actualizar</button>
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