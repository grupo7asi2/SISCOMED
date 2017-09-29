<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require 'database.php';
require './includes/utils.php';

$URI = filter_input(INPUT_SERVER, 'REQUEST_URI');

if (strpos($URI, '?')) {
    $vars = decode_get2($URI);

    if (isset($vars['vac'])) {
        $vaciado = $vars['vac'];
        if ($vaciado == 1) {
            $_SESSION['carritoVenta'] = null;
        }
    } elseif (isset($vars['uns'])) {
        $idArr = $vars['uns'];
        $arreglo = $_SESSION['carritoVenta'];
        unset($arreglo[$idArr]);
        $_SESSION['carritoVenta'] = array_values($arreglo);
    } else {
        if (isset($vars['codigoProducto'])) {
            $codigoProducto = $vars['codigoProducto'];
        }
        if (isset($vars['cantidad'])) {
            $cantidad = $vars['cantidad'];
        }
        if (isset($vars['fechaVenc'])) {
            $fechaVenc = $vars['fechaVenc'];
        }
    }
}

if (!empty($_POST)) {
    $fechaVentaGlobal = $_POST['fechaCompraGlobal'];
    $total = $_POST['totalGlobal'];
    $valid = true;
    if (empty($fechaVentaGlobal)) {
        $fechaVentaGlobalError = "Ingrese la fecha de Venta";
        $valid = false;
    }
    
    if ($valid){
        header("Location: facturar.php?". encode_this('fecha='. $fechaVentaGlobal . '&total=' . $total));
    }    
}
if (isset($_SESSION['carritoVenta'])) {

    if (isset($codigoProducto)) {
        $arreglo = $_SESSION['carritoVenta'];
        $encontro = false;
        $numero = 0;
        for ($i = 0; $i < count($arreglo); $i++) {
            if ($arreglo[$i]['Id'] == $codigoProducto) {
                $encontro = true;
                $numero = $i;
            }
        }
        if ($encontro == true) {
            $arreglo[$numero]['Cantidad'] = $arreglo[$numero]['Cantidad'] + $cantidad;
            $_SESSION['carritoVenta'] = $arreglo;
        } else {
            $nombreProducto = "";
            $precioVenta = 0;

            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT codigo_producto, nombre_producto, precio_venta from producto WHERE codigo_producto = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($codigoProducto));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

            $nombreProducto = $data['nombre_producto'];
            $precioVenta = $data['precio_venta'];

            $datosNuevos = [
                'Id' => $codigoProducto,
                'Nombre' => $nombreProducto,
                'PrecioVenta' => $precioVenta,
                'Cantidad' => $cantidad,
                ];

            array_push($arreglo, $datosNuevos);
            $_SESSION['carritoVenta'] = $arreglo;
        }
    }
} else {
    if (isset($codigoProducto)) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT codigo_producto, nombre_producto, precio_venta from producto WHERE codigo_producto = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($codigoProducto));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        $nombreProducto = $data['nombre_producto'];
        $precioVenta = $data['precio_venta'];
        $arreglo[] = [
            "Id" => $codigoProducto,
            "Nombre" => $nombreProducto,
            "PrecioVenta" => $precioVenta,
            "Cantidad" => $cantidad,
        ];
        $_SESSION['carritoVenta'] = $arreglo;
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Venta</title>
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
                
                
                <!-- /. ROW  -->
                  <hr />
                <div class="row">
                   
                    </div>
                    
                 
                 
                 
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
                           Venta
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <?php
                                        if (isset($_SESSION['nombreCliente'])) {
                                            echo '<h3>'.$_SESSION['nombreCliente'].'</h3><br>';
                                        }
                                    ?>
                              
                                <form action="mostrarDetalleVenta.php" method="post" name="compra">
                            

                                        <p>
                                            <?php
                                            if (isset($_SESSION['carritoVenta'])) {
                                                echo '<button type="submit" class="btn btn-success">Generar Factura</button>';
                                            }
                                            ?>
                                            <!--Falta detallar la compra e ingreso al inventario-->
                                        </p>

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>

                                                    <th>Nombre Producto</th>
                                                    <th>Precio Compra Unidad</th>
                                                    <th>Cantidad</th>
                                                    <th>Sub Total</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $total = 0;
                                                if (isset($_SESSION['carritoVenta'])) {
                                                    $datos = $_SESSION['carritoVenta'];

                                                    //$total = 0;
                                                    for ($i = 0; $i < count($datos); $i++) {
                                                        echo '<tr>';
                                                        echo '<td>' . $datos[$i]['Nombre'] . '</td>';
                                                        echo '<td>' . $datos[$i]['PrecioVenta'] . '</td>';
                                                        echo '<td>' . $datos[$i]['Cantidad'] . '</td>';
                                                        echo '<td>' . $datos[$i]['Cantidad'] * $datos[$i]['PrecioVenta'] . '</td>';
                                                        echo '<td width=300>';
                                                        echo '<a class="btn btn-success" href="mostrarDetalleVenta.php?' . encode_this('uns=' . $i) . '">Quitar del carrito</a>';
                                                        echo '&nbsp;';
                                                        echo '</td>';
                                                        echo '</tr>';

                                                        $total = ($datos[$i]['Cantidad'] * $datos[$i]['PrecioVenta']) + $total;
                                                    }
                                                } else {
                                                    echo '<center><h2>No has añadido ningun producto</h2></center>';
                                                }
                                                echo '<center><h2 id="total">Total: ' . $total . '</h2></center>';
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" name="totalGlobal" value="<?php echo $total;?>" />
                                    <div class="control-group <?php echo!empty($fechaVentaGlobalError) ? 'error' : ''; ?>">
                                        <label class="control-label">Fecha de Venta</label>
                                        <div class="controls">
                                            <input name="fechaCompraGlobal" type="date"  value="<?php echo!empty($fechaVentaGlobal) ? $fechaVentaGlobal : ''; ?>">
                                            <?php if (!empty($fechaVentaGlobalError)): ?>
                                                <span class="help-inline"><?php echo $fechaVentaGlobalError; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <p>
                                    <br>

                                        <a class="btn btn-default" href="mostrarRegistroVenta.php">Regresar</a>
                                        <?php
                                            echo '<a class="btn btn-default" href="mostrarDetalleVenta.php?' . encode_this('vac=1') . '">Vaciar Carrito</a>';
                                        ?>
                                    </p>
                                </form>
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
