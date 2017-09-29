<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}

require '../database.php';
$valorObtenido = filter_input(INPUT_GET, 'codigoUsuario');
if (isset($valorObtenido)) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT u.codigo_usuario, tu.nombre_tipoUsuario, concat(e.nombre_empleado, ' ', e.apellido_empleado) AS empleado , "
    . "u.usuario_login, u.password_usuario from usuario u "
    . "INNER JOIN tipo_usuario tu ON u.codigo_tipoUsuario = tu.codigo_tipoUsuario "
    . "INNER JOIN empleado e ON u.codigo_empleado = e.codigo_empleado "
    . "WHERE u.codigo_usuario = '" . $valorObtenido . "'";

    $q = $pdo->prepare($sql);
    $q->execute();
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    if (isset($data)) {
        $codigoTipoUsuario = $data['nombre_tipoUsuario'];
        $codigoEmpleado = $data['empleado'];
        $usuarioLogin = $data['usuario_login'];
        $passwordUsuario = $data['password_usuario'];
    } else {
        echo "No se pudo cargar la información del producto.";
    }
}

$codigoUsuario = null;
if (!empty($_GET['codigoUsuario'])) {
    $codigoUsuario = $_REQUEST['codigoUsuario'];
}

if (null == $codigoUsuario) {
    header("Location: ../Show/mostrarRegistroUsuario.php");
}

if (!empty($_POST)) {
    // keep track validation errors
    $codigoTipoUsuarioError = null;
    $codigoEmpleadoError = null;
    $usuarioLoginError = null;
    $passwordUsuarioError = null;

    // keep track post values
    $codigoTipoUsuario = $_POST['codigoTipoUsuario'];
    $codigoEmpleado = $_POST['codigoEmpleado'];
    $usuarioLogin = $_POST['usuarioLogin'];
    $passwordUsuario = $_POST['passwordUsuario'];

    // validate input
    $valid = true;

    if (empty($codigoTipoUsuario)) {
        $codigoTipoUsuarioError = 'Seleccione un codigo';
        $valid = false;
    }

    if (empty($codigoEmpleado)) {
        $codigoEmpleadoError = 'Seleccione un codigo de empleado';
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

    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE usuario set codigo_tipoUsuario=?, codigo_empleado=?, usuario_login=?, password_usuario=? WHERE codigo_usuario = ?;";
        $q = $pdo->prepare($sql);
        $q->execute(array($codigoTipoUsuario, $codigoEmpleado, $usuarioLogin, $passwordUsuario, $codigoUsuario));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroUsuario.php");
    } else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT u.codigo_usuario, tu.nombre_tipoUsuario, concat(e.nombre_empleado, ' ', e.apellido_empleado) AS empleado, "
    . "u.usuario_login, u.password_usuario from usuario u "
    . "INNER JOIN tipo_usuario tu ON u.codigo_tipoUsuario = tu.codigo_tipoUsuario "
    . "INNER JOIN empleado e ON u.codigo_empleado = e.codigo_empleado "
    . "WHERE u.codigo_usuario = '" . $valorObtenido . "'";

    $q = $pdo->prepare($sql);
    $q->execute();
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    if (isset($data)) {
        $codigoTipoUsuario = $data['nombre_tipoUsuario'];
        $codigoEmpleado = $data['empleado'];
        $usuarioLogin = $data['usuario_login'];
        $passwordUsuario = $data['password_usuario'];
    } else {
        echo "No se pudo cargar la información del producto.";
    }
  }
}
function getUsuario() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_tipoUsuario, nombre_tipoUsuario FROM tipo_usuario";
    $q = $pdo->prepare($sql);
    $q->execute();
    $rows = $q->fetchAll();
    Database::disconnect();
    return $rows;
}

function getEmpleado() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_empleado, concat(nombre_empleado, ' ', apellido_empleado) AS empleado FROM empleado;";
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
            <!-- end navbar side --><!-- navbar top -->
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
                           Actualizar Usuario
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form class="form-horizontal" action="../Actualizar/actualizarUsuario.php?codigoUsuario=<?php echo $codigoUsuario ?>" method="post">

                                        <!--ingreso del codigo del Producto -->
                                        <div class="control-group <?php echo!empty($codigoTipoUsuarioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Tipo Usuario</label>
                                            <div class="controls">
                                                <select require name="codigoTipoUsuario">

                                                    <?php
                                                    $infoProv = getUsuario();
                                                    foreach ($infoProv as $rows) {
                                                        $seleccionado = "";
                                                        if ($rows['codigo_tipoUsuario'] == $codigoTipoUsuario) {
                                                            $seleccionado = " selected ";
                                                        }
                                                        echo '<option ' . $seleccionado . ' value="' . $rows['codigo_tipoUsuario'] . '">' . $rows['nombre_tipoUsuario'] . '</option>';
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

                                                    <?php
                                                    $infoProd = getEmpleado();
                                                    foreach ($infoProd as $rows) {
                                                        $seleccionadoTipo = "";
                                                        if ($rows['codigo_empleado'] == $codigoEmpleado) {
                                                            $seleccionadoTipo = " selected ";
                                                        }
                                                        echo '<option ' . $seleccionadoTipo . ' value="' . $rows['codigo_empleado'] . '">' . $rows['empleado'] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                                <?php if (!empty($codigoEmpleadoError)): ?>
                                                    <span class="help-inline"><?php echo $codigoEmpleadoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($usuarioLoginError) ? 'error' : ''; ?>">
                                            <label class="control-label">UserName</label>
                                            <div class="controls">
                                                <input name="usuarioLogin" type="text"  placeholder="usuarioLogin" value="<?php echo!empty($usuarioLogin) ? $usuarioLogin : ''; ?>">
                                                <?php if (!empty($usurioLoginError)): ?>
                                                    <span class="help-inline"><?php echo $usuarioLoginError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($passwordUsuarioError) ? 'error' : ''; ?>">
                                            <label class="control-label">Contraseña</label>
                                            <div class="controls">
                                                <input name="passwordUsuario" type="text"  placeholder="passwordUsuario" value="<?php echo!empty($passwordUsuario) ? $passwordUsuario : ''; ?>">
                                                <?php if (!empty($passwordUsuarioError)): ?>
                                                    <span class="help-inline"><?php echo $passwordUsuarioError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <br>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Actualizar</button>
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