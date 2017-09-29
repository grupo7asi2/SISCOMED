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
    $nombreProductoError = null;
    $proveedorError = null;
    $tipoProductoError = null;
    $precioCompraError = null;
    $precioVentaError = null;
    $presentacionError = null;
    //$fechaVencimientoError = null;
    // keep track post values
    $nombreProducto = $_POST['nombreProducto'];
    $proveedor = $_POST['proveedor'];
    $tipoProducto = $_POST['tipoProducto'];
    $presentacion = $_POST['presentacion'];
    $precioCompra = $_POST['precioCompra'];
    $precioVenta = $_POST['precioVenta'];

    // validate input
    $valid = true;

    if (empty($nombreProducto)) {
        $nombreProductoError = 'Ingrese el nombre del producto';
        $valid = false;
    }

    if (empty($proveedor)) {
        $proveedorError = 'Seleccione un proveedor';
        $valid = false;
    }

    if (empty($tipoProducto)) {
        $tipoProductoError = 'Seleccione un tipo de producto';
        $valid = false;
    }

    if (empty($precioCompra)) {
        $precioCompraError = 'Ingrese el precio de compra';
        $valid = false;
    }

    if (empty($precioVenta)) {
        $precioVentaError = 'Ingrese el precio de venta';
        $valid = false;
    }

    if (empty($presentacion)) {
        $presentacionError = 'Ingrese la presentacion';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO producto (codigo_tipoproducto, codigo_proveedor, nombre_producto, presentacion, precio_compra, precio_venta) values(?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($tipoProducto, $proveedor, $nombreProducto, $presentacion, $precioCompra, $precioVenta));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroProducto.php");
    }
}

function getProveedor() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_proveedor, nombre_empresa FROM proveedor";
    $q = $pdo->prepare($sql);
    $q->execute();
    $rows = $q->fetchAll();
    Database::disconnect();
    return $rows;
}

function getTipoProducto() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_tipoproducto, nombre_tipoproducto FROM tipo_producto";
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
            <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Producto</h1>
                </div>
                <!--End Page Header -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Agregar Producto
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                
                               <div class="col-lg-12">


 <p>
                                            <a href="../Show/mostrarRegistroProducto.php" class="btn btn-success">Mostrar Todos los Registros</a>
                                        </p>
                                        <h3>Agregar Producto</h3>

                                    <form class="form-horizontal" action="../Crear/crearProducto.php" method="post">
                                        <div class="control-group <?php echo!empty($codigoProductoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Codigo del Producto</label>
                                            <div class="controls">
                                                <input name="codigoProducto" type="text" disabled="true" value="<?php echo!empty($codigoProducto) ? $codigoProducto : ''; ?>">
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($nombreProductoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre del Producto</label>
                                            <div class="controls">
                                                <input name="nombreProducto" type="text"  placeholder="Ingrese el nombre " value="<?php echo!empty($nombreProducto) ? $nombreProducto : ''; ?>">
                                                <?php if (!empty($nombreProductoError)): ?>
                                                    <span class="help-inline"><?php echo $nombreProductoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($presentacionError) ? 'error' : ''; ?>">
                                            <label class="control-label">Presentacion</label>
                                            <div class="controls">
                                                <input name="presentacion" type="text"  placeholder="Ingrese el nombre " value="<?php echo!empty($presentacion) ? $presentacion : ''; ?>">
                                                <?php if (!empty($presentacionError)): ?>
                                                    <span class="help-inline"><?php echo $presentacionError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($proveedorError) ? 'error' : ''; ?>">
                                            <label class="control-label">Proveedor</label>
                                            <div class="controls">

                                                <select require name="proveedor">
                                                    <option value="">Seleccione el proveedor</option>
                                                    <?php
                                                    $info = getProveedor();
                                                    foreach ($info as $rows) {
                                                        echo '<option value="' . $rows['codigo_proveedor'] . '">' . $rows['nombre_empresa'] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                                <?php if (!empty($proveedorError)): ?>
                                                    <span class="help-inline"><?php echo $proveedorError; ?></span>
                                                <?php endif; ?>

                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($tipoProductoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Tipo Producto</label>
                                            <div class="controls">

                                                <select require name="tipoProducto">
                                                    <option value="">Seleccione el tipo de producto</option>
                                                    <?php
                                                    $array = getTipoProducto();
                                                    foreach ($array as $rows) {
                                                        echo '<option value="' . $rows['codigo_tipoproducto'] . '">' . $rows['nombre_tipoproducto'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <?php if (!empty($tipoProductoError)): ?>
                                                    <span class="help-inline"><?php echo $tipoProductoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($precioCompraError) ? 'error' : ''; ?>">
                                            <label class="control-label">Precio de Compra</label>
                                            <div class="controls">
                                                <input name="precioCompra" type="text"  placeholder="Ingrese precio de Compra" value="<?php echo!empty($precioCompra) ? $precioCompra : ''; ?>">
                                                <?php if (!empty($precioCompraError)): ?>
                                                    <span class="help-inline"><?php echo $precioCompraError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($precioVentaError) ? 'error' : ''; ?>">
                                            <label class="control-label">Precio de Venta</label>
                                            <div class="controls">
                                                <input name="precioVenta" type="text"  placeholder="Ingrese precio de Venta" value="<?php echo!empty($precioVenta) ? $precioVenta : ''; ?>">
                                                <?php if (!empty($precioVentaError)): ?>
                                                    <span class="help-inline"><?php echo $precioVentaError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Crear</button>
                                            <a class="btn btn-default" href="../Show/mostrarRegistroProducto.php">Regresar</a>
                                            
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