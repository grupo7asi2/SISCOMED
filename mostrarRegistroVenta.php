<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require 'database.php';
require './includes/utils.php';
$idCliente = null;
$URI = filter_input(INPUT_SERVER, 'REQUEST_URI');

if (strpos($URI, '?')) {
    $vars = decode_get2($URI);

    if (isset($vars['cambioCliente'])) {
        $cambioCliente = $vars['cambioCliente'];
        if ($cambioCliente) {
            $_SESSION['idCliente'] = null;
            $_SESSION['nombreCliente'] = null;
            $_SESSION['carritoVenta'] = null;
        }
    }
}

if (!empty($_POST)) {
    $idCliente = filter_input(INPUT_POST, 'Cliente');
    
    
    if (!empty($idCliente)) {
        $arr = getClienteById($idCliente);
        foreach ($arr as $aux) {
            if (!isset($_SESSION['nombreCliente'])) {
                $_SESSION['nombreCliente'] = $aux['nombre_cliente'] . ' ' . $aux['apellido_cliente'];
            }
            if (!isset($_SESSION['idCliente'])) {
                $_SESSION['idCliente'] = $idCliente;
            }
        }
    }
}

function getClientes() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT codigo_cliente, nombre_cliente, apellido_cliente FROM cliente";
    $q = $pdo->prepare($sql);
    $q->execute();
    $rows = $q->fetchAll();
    Database::disconnect();
    return $rows;
}

function getClienteById($id) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT nombre_cliente, apellido_cliente FROM cliente where codigo_cliente = " . $id;
    $q = $pdo->prepare($sql);
    $q->execute();
    $row = $q->fetchAll();
    Database::disconnect();
    return $row;
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mantto. Venta</title>
        <!-- Core CSS - Include with every page -->
        <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/main-style.css" rel="stylesheet" />
        <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    </head>

    <body>
        <!--  wrapper -->
        <div id="wrapper">
            <!-- navbar top -->
            <?php include ("./includes/topMenu.php"); ?>
            <!-- end navbar top -->

            <!-- navbar side -->
            <?php include ("./includes/leftMenu.php"); ?>
            <!-- end navbar side -->
            <!--  page-wrapper -->
            <div id="page-wrapper">

                <div class="row">
                    <!-- Page Header -->

                    <div class="row">
                        <!--  page header -->
                        <div class="col-lg-12">
                            <h1 class="page-header">Venta</h1>
                        </div>
                        <!-- end  page header -->
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Advanced Tables -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Venta Producto
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                            <br>
                                            <div class="container">
                                                <?php
                                                if (isset($_SESSION['idCliente'])) {
                                                    echo '<h3>' . $_SESSION['nombreCliente'] . '<h3>';
                                                }
                                                ?>
                                            </div>

                                            <div class="container">
                                                <div class="row">
                                                    <h3>Venta de Productos</h3>
                                                </div>
                                                <div class="row">

                                                    <p>
                                                    </p>
                                                    <?php if (!isset($_SESSION['idCliente'])) { ?>
                                                        <form name="formCliente" action="mostrarRegistroVenta.php" method="POST">
                                                            <div class="control-group <?php echo!empty($clienteError) ? 'error' : ''; ?>">
                                                                <label class="control-label">Cliente</label>
                                                                <div class="controls">

                                                                    <select require name="Cliente">
                                                                        <option value="">Seleccione un Cliente</option>
                                                                        <?php
                                                                        $array = getClientes();
                                                                        foreach ($array as $rows) {
                                                                            echo '<option value="' . $rows['codigo_cliente'] . '">' . $rows['nombre_cliente'] . ' ' . $rows['apellido_cliente'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <?php if (!empty($clienteError)): ?>
                                                                        <span class="help-inline"><?php echo $clienteError; ?></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <button type="submit" class="btn btn-success">Seleccionar</button>
                                                        </form>
                                                        <?php
                                                    }else {
                                                        ?>
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre Producto</th>
                                                                    <th>Proveedor</th>
                                                                    <th>Precio Venta</th>
                                                                    <th>Tipo Producto</th>
                                                                    <th>Presentacion</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $pdo = Database::connect();
                                                                $sql = 'SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.precio_venta, pd.presentacion from producto pd
                                                    INNER JOIN proveedor pr ON pd.codigo_proveedor = pr.codigo_proveedor
                                                    INNER JOIN tipo_producto tp ON pd.codigo_tipoproducto = tp.codigo_tipoproducto';
                                                                foreach ($pdo->query($sql) as $row) {
                                                                    echo '<tr>';
                                                                    echo '<td>' . $row['nombre_producto'] . '</td>';
                                                                    echo '<td>' . $row['nombre_empresa'] . '</td>';
                                                                    echo '<td>' . $row['precio_venta'] . '</td>';
                                                                    echo '<td>' . $row['nombre_tipoproducto'] . '</td>';
                                                                    echo '<td>' . $row['presentacion'] . '</td>';
                                                                    echo '<td width=300>';
                                                                    echo '<a class="btn btn-success" href="ventaProductos.php?codigoProducto=' . $row['codigo_producto'] . '">Agregar para Venta</a>';
                                                                    echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                                Database::disconnect();
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <?php
                                                    }
                                                    ?>
                                                    <p>

                                                        <br>
                                                        <br>
                                                        <a class="btn btn-default" href="mantenimientos.php">Regresar Menu</a>
                                                        <?php
                                                        echo '<a class="btn btn-default" href="mostrarRegistroVenta.php?' . encode_this('cambioCliente=true') . '">Cambiar Cliente</a>';
                                                        echo '<a class="btn btn-default" href="mostrarDetalleVenta.php">Ver Carrito</a>';
                                                        ?>
                                                    </p>
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
                    <script src="assets/plugins/jquery-1.10.2.js"></script>
                    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
                    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
                    <script src="assets/plugins/pace/pace.js"></script>
                    <script src="assets/scripts/siminta.js"></script>
                    <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
                    <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
                    <script>
                        $(document).ready(function () {
                            $('#dataTables-example').dataTable();
                        });
                    </script>


                    </body>
                    </html>
