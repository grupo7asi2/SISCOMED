<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';
require '../database2.php';

if (!empty($_POST)) {
    // keep track validation errors
    $empresaError = null;
    $direccionError = null;
    $representanteError = null;
    $identificacionError = null;
    $telefonoError = null;
    $correoError = null;
    
    // keep track post values
    $empresa = $_POST['nombre_empresa'];
    $direccion = $_POST['direccion'];
    $representante = $_POST['representante'];
    $identificacion = $_POST['identificacion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $comentario = $_POST['comentario'];
    // validate input
    if (empty($empresa)) {
        $empresaError = 'Ingrese la Empresa';
    }

    if (empty($direccion)) {
        $direccionError = 'Ingrese direccion';
    }

    if (empty($representante)) {
        $representanteError = 'Ingrese el Representante';
    }

    if (empty($identificacion)) {
        $identificacionError = 'Ingrese identificación';
    }

    if (empty($telefono)) {
        $telefonoError = 'Ingrese telefono';
    }

    if (empty($comentario)){
        $comentario='';
    } else{
        $comentario=$_POST['comentario'];
    }
        
        
    if (!empty($empresa) && !empty($direccion) && !empty($representante) && !empty($identificacion) && !empty($telefono)) {
        $valid = true;
    }else{
        $valid = false;
    }

    if (isset($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL) && $correo != '') {
        $correoError = 'Dirección No Valida';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO proveedor (nombre_empresa, direccion, representante_empresa, identificacion, telefono, correo, comentario) values(?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($empresa, $direccion, $representante, $identificacion, $telefono, $correo, $comentario));
        Database::disconnect();
        header("Location: mostrarRegistroProveedor.php");
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantto. Proveedor</title>
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
                    <h1 class="page-header">Proveedor</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Agregar Proveedor
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                
                               <div class="col-lg-12">


 <p>
                                            <a href="../Show/mostrarRegistroProveedor.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Agregar Proveedor</h3>
                                    

                                    <form class="form-horizontal" action="crearProveedor.php" method="post">
                                        <div class="control-group <?php echo!empty($codigoProveedorError) ? 'error' : ''; ?>">
                                            <label class="control-label">Codigo del Proveedor</label>
                                            <div class="controls">
                                                <input name="codigoProveedor" type="text"  disabled="true" value="<?php echo!empty($codigoProveedor) ? $codigoProveedor : ''; ?>">
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($empresaError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre de Empresa</label>
                                            <div class="controls">
                                                <input name="nombre_empresa" type="text"  placeholder="Ingrese la Empresa" value="<?php echo!empty($empresa) ? $empresa : ''; ?>">
                                                <?php if (!empty($empresaError)): ?>
                                                    <span class="help-inline"><?php echo $empresaError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($direccionError) ? 'error' : ''; ?>">
                                            <label class="control-label">Dirección de Empresa</label>
                                            <div class="controls">
                                                <input name="direccion" type="text"  placeholder="Ingrese la direccion" value="<?php echo!empty($direccion) ? $direccion : ''; ?>">
                                                <?php if (!empty($direccionError)): ?>
                                                    <span class="help-inline"><?php echo $direccionError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($representanteError) ? 'error' : ''; ?>">
                                            <label class="control-label">Representante</label>
                                            <div class="controls">
                                                <input name="representante" type="text"  placeholder="Ingrese el apellido" value="<?php echo!empty($representante) ? $representante : ''; ?>">
                                                <?php if (!empty($representanteError)): ?>
                                                    <span class="help-inline"><?php echo $representanteError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($identificacionError) ? 'error' : ''; ?>">
                                            <label class="control-label">Identificacion</label>
                                            <div class="controls">
                                                <input name="identificacion" type="text"  placeholder="Ingrese identificacion" value="<?php echo!empty($identificacion) ? $identificacion : ''; ?>">
                                                <?php if (!empty($identificacionError)): ?>
                                                    <span class="help-inline"><?php echo $identificacionError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($telefonoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Telefono</label>
                                            <div class="controls">
                                                <input name="telefono" type="text"  placeholder="Ingrese el telefono" value="<?php echo!empty($telefono) ? $telefono : ''; ?>">
                                                <?php if (!empty($telefonoError)): ?>
                                                    <span class="help-inline"><?php echo $telefonoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($correoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Correo</label>
                                            <div class="controls">
                                                <input name="correo" type="text"  placeholder="Ingrese correo" value="<?php echo!empty($correo) ? $correo : ''; ?>">
                                                <?php if (!empty($correoError)): ?>
                                                    <span class="help-inline"><?php echo $correoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Comentario</label>
                                            <div class="controls">
                                                <textarea name="comentario" rows="5" cols="40" placeholder="Ingrese un comentario" ><?php echo !empty($comentario) ? $comentario: '';?></textarea>
                                            </div>
                                        </div>
                                        
                                        
                                        <br>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Crear</button>
                                            <a class="btn btn-default" href="../Show/mostrarRegistroProveedor.php">Regresar</a>
                                           
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