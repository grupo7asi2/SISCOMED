<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require '../database.php';
$valorObtenido = filter_input(INPUT_GET, 'codigoProducto');
if (isset($valorObtenido)) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.presentacion, pd.precio_venta, pd.precio_compra from producto pd
            INNER JOIN proveedor pr ON pd.codigo_proveedor = pr.codigo_proveedor
            INNER JOIN tipo_producto tp ON pd.codigo_tipoproducto = tp.codigo_tipoproducto
            WHERE pd.codigo_producto = '" . $valorObtenido . "'";
    $q = $pdo->prepare($sql);
    $q->execute();
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    if (isset($data)) {
        $nombreProducto = $data['nombre_producto'];
        $proveedor = $data['nombre_empresa'];
        $tipoProducto = $data['nombre_tipoproducto'];
        $presentacion = $data['presentacion'];
        $precioCompra = $data['precio_compra'];
        $precioVenta = $data['precio_venta'];
    } else {
        echo "No se pudo cargar la información del producto.";
    }
}

$codigoProducto = null;
if (!empty($_GET['codigoProducto'])) {
    $codigoProducto = $_REQUEST['codigoProducto'];
}

if (null == $codigoProducto) {
    header("Location: ../Show/mostrarRegistroProducto.php");
}

if (!empty($_POST)) {
    // keep track validation errors
    $nombreProductoError = null;
    $proveedorError = null;
    $tipoProductoError = null;
    $presentacionError = null;
    $precioVentaError = null;
    $precioCompraError = null;

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

    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE producto set codigo_tipoproducto=?, codigo_proveedor=?, nombre_producto=?, presentacion=?, 
            precio_compra=?, precio_venta=? WHERE codigo_producto = ?;";
        $q = $pdo->prepare($sql);
        $q->execute(array($tipoProducto, $proveedor, $nombreProducto, $presentacion, $precioCompra, $precioVenta, $codigoProducto));
        Database::disconnect();
        header("Location: ../Show/mostrarRegistroProducto.php");
    } else {
        $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.presentacion, pd.precio_venta, pd.precio_compra from producto pd
            INNER JOIN proveedor pr ON pd.codigo_proveedor = pr.codigo_proveedor
            INNER JOIN tipo_producto tp ON pd.codigo_tipoproducto = tp.codigo_tipoproducto
            WHERE pd.codigo_producto = '" . $valorObtenido . "'";
    $q = $pdo->prepare($sql);
    $q->execute();
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    if (isset($data)) {
        $nombreProducto = $data['nombre_producto'];
        $proveedor = $data['nombre_empresa'];
        $tipoProducto = $data['nombre_tipoproducto'];
        $presentacion = $data['presentacion'];
        $precioCompra = $data['precio_compra'];
        $precioVenta = $data['precio_venta'];
    } else {
        echo "No se pudo cargar la información del producto.";
    }
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
            <!-- end navbar side --><!-- navbar top -->
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
                           Actualizar Producto
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form class="form-horizontal" action="../Actualizar/actualizarProducto.php?codigoProducto=<?php echo $codigoProducto ?>" method="post">

                                        <!--ingreso del codigo del Producto -->
                                        <div class="control-group <?php echo!empty($nombreProductoError) ? 'error' : ''; ?>">
                                            <label class="control-label">Nombre Producto</label>
                                            <div class="controls">
                                                <input name="nombreProducto" type="text"  placeholder="Nombre Producto" value="<?php echo!empty($nombreProducto) ? $nombreProducto : ''; ?>">
                                                <?php if (!empty($nombreProductoError)): ?>
                                                    <span class="help-inline"><?php echo $nombreProductoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($proveedorError) ? 'error' : ''; ?>">
                                            <label class="control-label">Proveedor</label>
                                            <div class="controls">
                                                <select require name="proveedor">

                                                    <?php
                                                    $infoProv = getProveedor();
                                                    foreach ($infoProv as $rows) {
                                                        $seleccionado = "";
                                                        if ($rows['nombre_empresa'] == $proveedor) {
                                                            $seleccionado = " selected ";
                                                        }
                                                        echo '<option ' . $seleccionado . ' value="' . $rows['codigo_proveedor'] . '">' . $rows['nombre_empresa'] . '</option>';
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

                                                    <?php
                                                    $infoProd = getTipoProducto();
                                                    foreach ($infoProd as $rows) {
                                                        $seleccionadoTipo = "";
                                                        if ($rows['nombre_tipoproducto'] == $tipoProducto) {
                                                            $seleccionadoTipo = " selected ";
                                                        }
                                                        echo '<option ' . $seleccionadoTipo . ' value="' . $rows['codigo_tipoproducto'] . '">' . $rows['nombre_tipoproducto'] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                                <?php if (!empty($tipoProductoError)): ?>
                                                    <span class="help-inline"><?php echo $tipoProductoError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($presentacionError) ? 'error' : ''; ?>">
                                            <label class="control-label">Presentación</label>
                                            <div class="controls">
                                                <input name="presentacion" type="text"  placeholder="presentacion" value="<?php echo!empty($presentacion) ? $presentacion : ''; ?>">
                                                <?php if (!empty($presentacionError)): ?>
                                                    <span class="help-inline"><?php echo $presentacionError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($precioCompraError) ? 'error' : ''; ?>">
                                            <label class="control-label">Precio de Compra</label>
                                            <div class="controls">
                                                <input name="precioCompra" type="text"  placeholder="precio de compra" value="<?php echo!empty($precioCompra) ? $precioCompra : ''; ?>">
                                                <?php if (!empty($precioCompraError)): ?>
                                                    <span class="help-inline"><?php echo $precioCompraError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="control-group <?php echo!empty($precioVentaError) ? 'error' : ''; ?>">
                                            <label class="control-label">Precio de Venta</label>
                                            <div class="controls">
                                                <input name="precioVenta" type="text"  placeholder="precio de venta" value="<?php echo!empty($precioVenta) ? $precioVenta : ''; ?>">
                                                <?php if (!empty($precioVentaError)): ?>
                                                    <span class="help-inline"><?php echo $precioVentaError; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <br>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success">Actualizar</button>
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