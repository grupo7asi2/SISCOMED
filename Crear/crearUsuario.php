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
    $codigoEmpleadoError = null;
    $usuarioLoginError = null;
    $passwordUsuarioError = null;
    //$fechaVencimientoError = null;
    // keep track post values
    $codigoTipoUsuario = $_POST['codigoTipoUsuario'];
    $codigoEmpleado = $_POST['codigoEmpleado'];
    $usuarioLogin = $_POST['usuarioLogin'];
    $passwordUsuario = $_POST['passwordUsuario'];

    // validate input
    $valid = true;

    if (empty($codigoTipoUsuario)) {
        $codigoTipoUsuarioError = 'Seleccione codigo';
        $valid = false;
    }

    if (empty($codigoEmpleado)) {
        $codigoEmpleadoError = 'Seleccione un codigo empleado';
        $valid = false;
    }

    if (empty($usuarioLogin)) {
        $usuarioLoginError = 'Ingrese username';
        $valid = false;
    }

    if (empty($passwordUsuario)) {
        $passwordUsuarioError = 'Ingrese contraseña';
        $valid = false;
    }


    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO usuario (codigo_tipoUsuario, codigo_empleado, usuario_login, password_usuario) values(?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($codigoTipoUsuario, $codigoEmpleado, $usuarioLogin, $passwordUsuario));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroUsuario.php");
    }
}

function getProveedor() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_tipoUsuario, nombre_tipoUsuario FROM tipo_usuario";
    $q = $pdo->prepare($sql);
    $q->execute();
    $rows = $q->fetchAll();
    Database::disconnect();
    return $rows;
}

function getTipoProducto() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_empleado, concat(nombre_empleado, ' ', apellido_empleado) AS empleado FROM empleado";
    $q = $pdo->prepare($sql);
    $q->execute();
    $rows = $q->fetchAll();
    Database::disconnect();
    return $rows;
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
                           Agregar Usuario
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                
                               <div class="col-lg-12">


 <p>
                                            <a href="../Show/mostrarRegistroUsuario.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Agregar Usuario</h3>

                                    <form class="form-horizontal" action="../Crear/crearUsuario.php" method="post">
                                        <div class="control-group <?php echo!empty($codigoUsuarioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Codigo del Usuario</label>
                                            <div class="controls">
                                                <input name="codigoUsuario" type="text" disabled="true" value="<?php echo!empty($codigoUsuario) ? $codigoUsuario : ''; ?>">
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($usuarioLoginError) ? 'error' : ''; ?>">
                                            <label class="control-label">Usuario</label>
                                            <div class="controls">
                                                <input name="usuarioLogin" type="text"  placeholder="Ingrese el username" value="<?php echo!empty($usuarioLogin) ? $usuarioLogin: ''; ?>">
                                                <?php if (!empty($usuarioLoginError)): ?>
                                                    <span class="help-inline"><?php echo $usuarioLoginError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($passwordUsuarioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Contraseña</label>
                                            <div class="controls">
                                                <input name="passwordUsuario" type="text"  placeholder="Ingrese la contraseña " value="<?php echo!empty($passwordUsuario) ? $passwordUsuario : ''; ?>">
                                                <?php if (!empty($passwordUsuarioError)): ?>
                                                    <span class="help-inline"><?php echo $passwordUsuarioError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($codigoTipoUsuarioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Tipo Usuario</label>
                                            <div class="controls">

                                                <select require name="codigoTipoUsuario">
                                                    <option value="">Seleccione el codigo</option>
                                                    <?php
                                                    $info = getProveedor();
                                                    foreach ($info as $rows) {
                                                        echo '<option value="' . $rows['codigo_tipoUsuario'] . '">' . $rows['nombre_tipoUsuario'] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                                <?php if (!empty($codigoTipoUsuarioError)): ?>
                                                    <span class="help-inline"><?php echo $codigoTipoUsuarioError; ?></span>
                                                <?php endif; ?>

                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($codigoEmpleadoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Empleado</label>
                                            <div class="controls">

                                                <select require name="codigoEmpleado">
                                                    <option value="">Seleccione el empleado</option>
                                                    <?php
                                                    $array = getTipoProducto();
                                                    foreach ($array as $rows) {
                                                        echo '<option value="' . $rows['codigo_empleado'] . '">' . $rows['empleado'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <?php if (!empty($codigoEmpleadoError)): ?>
                                                    <span class="help-inline"><?php echo $codigoEmpleadoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Crear</button>
                                            <a class="btn btn-default" href="../Show/mostrarRegistroUsuario.php">Regresar</a>
                                            
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