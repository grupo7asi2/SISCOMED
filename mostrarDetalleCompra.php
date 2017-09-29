<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
require 'database.php';
$codigoProducto = filter_input(INPUT_GET, 'codigoProducto');
$cantidad = filter_input(INPUT_GET, 'cantidad');
$vaciado = filter_input(INPUT_GET, 'vac');
$fechaVenc = filter_input(INPUT_GET, 'fechaVenc');

function encode_this($string) {
    $string = utf8_encode($string);
    $control = "qwerty"; //defino la llave para encriptar la cadena, cambiarla por la que deseamos usar
    $string = $control . $string . $control; //concateno la llave para encriptar la cadena
    $string = base64_encode($string); //codifico la cadena
    return($string);
}

if (!empty($_POST)) {
    $fechaCompraGlobal = $_POST['fechaCompraGlobal'];
    $total = $_POST['totalGlobal'];
    $valid = true;
    if (empty($fechaCompraGlobal)) {
        $fechaCompraGlobalError = "Ingrese la fecha de compra";
        $valid = false;
    }
    
    if ($valid){
        header("Location: comprarTodo.php?". encode_this('fecha='. $fechaCompraGlobal . '&total=' . $total));
    }    
}

if (isset($vaciado)) {
    if ($vaciado == 1) {
        $_SESSION['carritoCompra'] = null;
    }
}

if (isset($_REQUEST['uns'])) {
    //Codigo para eliminar articulos del detalle de compra
    $idArr = $_REQUEST['uns'];
    $arreglo = $_SESSION['carritoCompra'];
    unset($arreglo[$idArr]);
    $_SESSION['carritoCompra'] = array_values($arreglo);
}


if (isset($_SESSION['carritoCompra'])) {

    if (isset($codigoProducto)) {
        $arreglo = $_SESSION['carritoCompra'];
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
            $_SESSION['carritoCompra'] = $arreglo;
        } else {
            $nombreProducto = "";
            $precioCompra = 0;

            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT codigo_producto, nombre_producto, precio_compra from producto WHERE codigo_producto = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($codigoProducto));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

            $nombreProducto = $data['nombre_producto'];
            $precioCompra = $data['precio_compra'];

            $datosNuevos = ['Id' => $codigoProducto,
                'Nombre' => $nombreProducto,
                'PrecioCompra' => $precioCompra,
                'Cantidad' => $cantidad,
                'FechaVenc' => $fechaVenc,
                ];

            array_push($arreglo, $datosNuevos);
            $_SESSION['carritoCompra'] = $arreglo;
        }
    }
} else {
    if (isset($codigoProducto)) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT codigo_producto, nombre_producto, precio_compra from producto WHERE codigo_producto = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($codigoProducto));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        $nombreProducto = $data['nombre_producto'];
        $precioCompra = $data['precio_compra'];

        $arreglo[] = [
            "Id" => $codigoProducto,
            "Nombre" => $nombreProducto,
            "PrecioCompra" => $precioCompra,
            "Cantidad" => $cantidad,
            "FechaVenc" => $fechaVenc,
        ];

        $_SESSION['carritoCompra'] = $arreglo;
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Compra</title>
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
                <div class="col-lg-12">
                    <h1 class="page-header"> Mantenimientos Principales</h1>
                    
                </div>
                
                <!-- /. ROW  -->
                  <hr />
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="alert alert-info">
                             <strong>Bienvenido a los mantenimiento principales. </strong> 
                        </div>
                       
                    </div>
                    </div>
                    
                 
                 
                 
              <div class="row">
                 <!--  page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Compra</h1>
                </div>
                 <!-- end  page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Compra
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                
                                <form action="mostrarDetalleCompra.php" method="post" name="compra">
                                 

                                        <p>
                                            <?php
                                            if (isset($_SESSION['carritoCompra'])) {
                                                echo '<button type="submit" class="btn btn-success">Comprar Todo</button>';
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
                                                if (isset($_SESSION['carritoCompra'])) {
                                                    $datos = $_SESSION['carritoCompra'];

                                                    //$total = 0;
                                                    for ($i = 0; $i < count($datos); $i++) {
                                                        echo '<tr>';
                                                        echo '<td>' . $datos[$i]['Nombre'] . '</td>';
                                                        echo '<td>' . $datos[$i]['PrecioCompra'] . '</td>';
                                                        echo '<td>' . $datos[$i]['Cantidad'] . '</td>';
                                                        echo '<td>' . $datos[$i]['Cantidad'] * $datos[$i]['PrecioCompra'] . '</td>';
                                                        echo '<td width=300>';
                                                        echo '<a class="btn btn-success" href="mostrarDetalleCompra.php?uns=' . $i . '">Quitar de la Compra</a>';
                                                        echo '&nbsp;';
//                                                echo '<a class="btn btn-success" href="actualizarProducto.php?codigoProducto=' . $row['codigo_producto'] . '">Actualizar</a>';
//                                                echo '&nbsp;';
//                                                echo '<a class="btn btn-danger" href="eliminarProducto.php?codigoProducto=' . $row['codigo_producto'] . '">Eliminar</a>';
                                                        echo '</td>';
                                                        echo '</tr>';

                                                        $total = ($datos[$i]['Cantidad'] * $datos[$i]['PrecioCompra']) + $total;
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
                                    <div class="control-group <?php echo!empty($fechaCompraGlobalError) ? 'error' : ''; ?>">
                                        <label class="control-label">Fecha de Compra</label>
                                        <div class="controls">
                                            <input name="fechaCompraGlobal" type="date"  value="<?php echo!empty($fechaCompraGlobal) ? $fechaCompraGlobal : ''; ?>">
                                            <?php if (!empty($fechaCompraGlobalError)): ?>
                                                <span class="help-inline"><?php echo $fechaCompraGlobalError; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <p>
                                    <br>

                                        <a class="btn btn-default" href="mostrarRegistroCompra.php">Regresar</a>
                                        <a class="btn btn-default" href="mostrarDetalleCompra.php?vac=1" >Vaciar Detalle</a>
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
