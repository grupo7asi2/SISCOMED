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
    $nombreError = null;
    $apellidoError = null;
    $correoError = null;
    $telefonoError = null;
    $direccionError = null;
    $departamentoError = null;
    $municipioError = null;

    // keep track post values
    $nombre = $_POST['nombre_cliente'];
    $apellido = $_POST['apellido_cliente'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $departamento = $_POST['departamento'];
    $municipio = $_POST['municipio'];

    // validate input
    if (empty($nombre)) {
        $nombreError = 'Ingrese un nombre';
    }

    if (empty($apellido)) {
        $apellidoError = 'Ingrese un Apellido';
    }

    if (empty($telefono)) {
        $telefonoError = 'Ingrese telefono';
    }

    if (empty($direccion)) {
        $direccionError = 'Ingrese direccion';
    }

    if (empty($departamento)) {
        $departamentoError = 'Ingrese departamento';
    }

    if (empty($municipio)) {
        $municipioError = 'Ingrese municipio';
    }
    
    if(!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($direccion) && !empty($departamento) && !empty($municipio)){
        $valid = true;
    }else{
        $valid = false;
    }
    
    if (isset($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL) && $correo != ''){
        $correoError = 'Dirección No Valida';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO cliente (codigo_cliente,nombre_cliente,apellido_cliente,correo,telefono,direccion,departamento,municipio) values(?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($codigoCliente, $nombre, $apellido, $correo, $telefono, $direccion, $departamento, $municipio));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroCliente.php");
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
                    <h1 class="page-header">Cliente</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Agregar Cliente
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                
                               <div class="col-lg-12">


 <p>
                                            <a href="../Show/mostrarRegistroCliente.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Agregar Cliente</h3>
                                        
                                        
                                    <form class="form-horizontal" action="../Crear/crearCliente.php" method="post">
                                        <div class="control-group <?php echo!empty($codigoClienteError) ? 'error' : ''; ?>">
                                            <label class="control-label">Codigo del Cliente</label>
                                            <div class="controls">
                                                <input name="codigoCliente" type="text" disabled="true" placeholder="" value="">
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($nombreError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre Cliente </label>
                                            <div class="controls">
                                                <input name="nombre_cliente" type="text"   required placeholder="Ingrese el nombre" value="<?php echo!empty($nombre) ? $nombre : ''; ?>">
                                                <?php if (!empty($nombreError)): ?>
                                                    <span class="help-inline"><?php echo $nombreError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($apellidoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Apellido Cliente</label>
                                            <div class="controls">
                                                <input name="apellido_cliente" type="text" required  placeholder="Ingrese el apellido" value="<?php echo!empty($apellido) ? $apellido : ''; ?>">
                                                <?php if (!empty($apellidoError)): ?>
                                                    <span class="help-inline"><?php echo $apellidoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($correoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Correo</label>
                                            <div class="controls">
                                                <input name="correo" type="text"  required placeholder="Ingrese correo" value="<?php echo!empty($correo) ? $correo : ''; ?>">
                                                <?php if (!empty($correoError)): ?>
                                                    <span class="help-inline"><?php echo $correoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($telefonoError) ? 'error' : ''; ?>">
                                            <label class="control-label"> Telefono</label>
                                            <div class="controls">
                                                <input name="telefono" type="text"  placeholder="Ingrese el telefono" value="<?php echo!empty($telefono) ? $telefono : ''; ?>">
                                                <?php if (!empty($telefonoError)): ?>
                                                    <span class="help-inline"><?php echo $telefonoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>


                                        <div class="control-group <?php echo!empty($direccionError) ? 'error' : ''; ?>">
                                            <label class="control-label"> Direccion Cliente</label>
                                            <div class="controls">
                                                <input name="direccion" type="text" required placeholder="Ingrese la direccion" value="<?php echo!empty($direccion) ? $direccion : ''; ?>">
                                                <?php if (!empty($direccionError)): ?>
                                                    <span class="help-inline"><?php echo $direccionError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>


                                        <div class="control-group <?php echo!empty($departamentoError) ? 'error' : ''; ?>">
                                            <label class="control-label"> Departamento</label>
                                            <div class="controls">
                                                <input name="departamento" type="text"  placeholder="Ingrese departamento" value="<?php echo!empty($departamento) ? $departamento : ''; ?>">
                                                <?php if (!empty($departamentoError)): ?>
                                                    <span class="help-inline"><?php echo $departamentoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($municipioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Municipio</label>
                                            <div class="controls">
                                                <input name="municipio" type="text"  placeholder="Ingrese municipio" value="<?php echo!empty($municipio) ? $municipio : ''; ?>">
                                                <?php if (!empty($municipioError)): ?>
                                                    <span class="help-inline"><?php echo $municipioError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <br>




                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Crear</button>
                                            <a class="btn btn-default" href="../Show/mostrarRegistroCliente.php">Regresar</a>
                                         
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