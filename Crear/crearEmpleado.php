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
    $cargoError = null;
    $correoError = null;
    $telefonoError = null;
    $duiError = null;
    $fechaIngresoError = null;

    // keep track post values
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $dui = $_POST['dui'];
    $fechaIngreso = $_POST['fechaIngreso'];


    // validate input
    $valid = true;
    if (empty($nombre)) {
        $nombreError = 'Ingrese un nombre';
        $valid = false;
    }

    if (empty($apellido)) {
        $apellidoError = 'Ingrese un Apellido';
        $valid = false;
    }

    if (empty($cargo)) {
        $cargoError = 'Ingrese cargo';
        $valid = false;
    }

    if (empty($correo)) {
        $correoError = 'Ingrese correo';
        $valid = false;
    }

    if (empty($telefono)) {
        $telefonoError = 'Ingrese telefono';
        $valid = false;
    }

    if (empty($fechaIngreso)) {
        $fechaIngresoError = 'Ingrese fecha de ingreso';
        $valid = false;
    }

    if (empty($dui)) {
        $duiError = 'Ingrese número';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO empleado (codigo_cargo,nombre_empleado,apellido_empleado,correo,telefono,fecha_ingreso,dui) values(?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($cargo, $nombre, $apellido, $correo, $telefono, $fechaIngreso, $dui));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroEmpleado.php");
    }
}
function getCargos() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_cargo, nombre_cargo FROM cargo";
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
    <title>Mantto. Emp</title>
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
                    <h1 class="page-header">Empleado</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Agregar Empleado
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                
                               <div class="col-lg-12">


 <p>
                                            <a href="../Show/mostrarRegistroEmpleado.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Agregar Empleado</h3>
                                    

                                    <form class="form-horizontal" action="../Crear/crearEmpleado.php" method="post">
                                        <div class="control-group <?php echo!empty($codigoEmpleadoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Codigo del Empleado</label>
                                            <div class="controls">
                                                <input name="codigoEmpleado" type="text" disabled="true" value="<?php echo!empty($codigo) ? $codigo : ''; ?>">
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($nombreError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre Empleado</label>
                                            <div class="controls">
                                                <input name="nombre" type="text" required placeholder="Ingrese el nombre" value="<?php echo!empty($nombre) ? $nombre : ''; ?>">
                                                <?php if (!empty($nombreError)): ?>
                                                    <span class="help-inline"><?php echo $nombreError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($apellidoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Apellido Empleado</label>
                                            <div class="controls">
                                                <input name="apellido" type="text" required placeholder="Ingrese el apellido" value="<?php echo!empty($apellido) ? $apellido : ''; ?>">
                                                <?php if (!empty($apellidoError)): ?>
                                                    <span class="help-inline"><?php echo $apellidoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($cargoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Cargo</label>
                                            <div class="controls">
                                                <select require name="cargo">
                                                    <option value="">Seleccione Cargo</option>
                                                    <?php
                                                    $info = getCargos();
                                                    foreach ($info as $rows) {
                                                        echo '<option value="' . $rows['codigo_cargo'] . '">' . $rows['nombre_cargo'] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                                <!--<input name="codigoLaboratorio" type="text"  placeholder="Seleccione el laboratorio  " value="<?php echo!empty($codigoPaciente) ? $codigoPaciente : ''; ?>">-->
                                                <?php if (!empty($cargoError)): ?>
                                                    <span class="help-inline"><?php echo $cargoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($correoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Correo</label>
                                            <div class="controls">
                                                <input name="correo" type="text"  placeholder="Ingrese la correo" value="<?php echo!empty($correo) ? $correo : ''; ?>">
                                                <?php if (!empty($correoError)): ?>
                                                    <span class="help-inline"><?php echo $correoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($telefonoError) ? 'error' : ''; ?>">
                                            <label class="control-label"> Telefono</label>
                                            <div class="controls">
                                                <input name="telefono" type="text" required  placeholder="Ingrese el telefono" value="<?php echo!empty($telefono) ? $telefono : ''; ?>">
                                                <?php if (!empty($telefonoError)): ?>
                                                    <span class="help-inline"><?php echo $telefonoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($duiError) ? 'error' : ''; ?>">
                                            <label class="control-label"> DUI </label>
                                            <div class="controls">
                                                <input name="dui" type="text" required placeholder="Ingrese número DUI" value="<?php echo!empty($dui) ? $dui : ''; ?>">
                                                <?php if (!empty($dui)): ?>
                                                    <span class="help-inline"><?php echo $duiError; ?></span>
                                                <?php endif; ?>


                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($fechaIngresoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Fecha Registro</label>
                                            <div class="controls">
                                                <input name="fechaIngreso" type="date"  placeholder="Digite fecha de Ingreso" value="<?php echo!empty($fechaIngreso) ? $fechaIngreso : ''; ?>">
                                                <?php if (!empty($fechaIngresoError)): ?>
                                                    <span class="help-inline"><?php echo $fechaIngresoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Crear</button>
                                            <a class="btn btn-default" href="../Show/mostrarRegistroEmpleado.php">Regresar</a>
                                     
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