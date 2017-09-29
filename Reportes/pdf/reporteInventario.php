<?php

//include_once '../mpdf60/mpdf.php';
include_once '../core/pdf/mpdf.php';
include '../../database.php';

function obtener_inventario($bodega = '', $movimiento = '', $producto = '') {
    $condicion = "";
    $html = "";

    $condicion_movimiento = "";
    $condicion_bodega = "";
    $condicion_producto = "";

    if (!empty($movimiento)) {
        $condicion_movimiento = " inventario.tipo_movimiento LIKE '%" . $movimiento . "%'";
    }if (!empty($bodega)) {
        $condicion_bodega = " bodega.nombre_bodega LIKE '%" . $bodega . "%'";
    }if (!empty($producto) && $producto <> "0") {
        $condicion_producto = " producto.codigo_producto = '" . $producto . "' ";
    }

    if (!empty($condicion_bodega) && !empty($condicion_movimiento) && !empty($condicion_producto)) {
        $condicion = " WHERE (" . $condicion_bodega . ") AND (" . $condicion_movimiento . ") AND (" . $condicion_producto . ")";
    } elseif (!empty($condicion_bodega) && !empty($condicion_movimiento)) {
        $condicion = " WHERE (" . $condicion_bodega . ") AND (" . $condicion_movimiento . ") ";
    } elseif (!empty($condicion_bodega) && !empty($condicion_producto)) {
        $condicion = " WHERE (" . $condicion_bodega . ") AND (" . $condicion_producto . ") ";
    } elseif (!empty($condicion_movimiento) && !empty($condicion_producto)) {
        $condicion = " WHERE (" . $condicion_movimiento . ") AND (" . $condicion_producto . ") ";
    } elseif (!empty($condicion_bodega)) {
        $condicion = " WHERE " . $condicion_bodega;
    } elseif (!empty($condicion_movimiento)) {
        $condicion = " WHERE " . $condicion_movimiento;
    } elseif (!empty($condicion_producto)) {
        $condicion = " WHERE " . $condicion_producto;
    }

    $pdo = Database::connect();
    $sql = "SELECT bodega.nombre_bodega, inventario.tipo_movimiento, producto.nombre_producto, "
            . "inventario.cantidad_producto, inventario.fecha_movimiento from inventario "
            . "INNER JOIN bodega ON inventario.codigo_bodega = bodega.codigo_bodega "
            . "INNER JOIN producto ON inventario.codigo_producto = producto.codigo_producto " . $condicion;

    foreach ($pdo->query($sql) as $row) {
        $html .= '<tr>';
        $html .= '<td>' . $row['nombre_bodega'] . '</td>';
        $html .= '<td>' . $row['tipo_movimiento'] . '</td>';
        $html .= '<td>' . $row['nombre_producto'] . '</td>';
        $html .= '<td>' . $row['cantidad_producto'] . '</td>';
        $html .= '<td>' . $row['fecha_movimiento'] . '</td>';
        $html .= '</tr>';
    }
    Database::disconnect();
    return $html;
}

$nombre_institucion = "SISCOMED";
$fecha = date("d.m.y");  

$valor = "";
$movimiento = "";
$bodega = "";
$producto = "";

if (isset($_POST['bodega'])) {
    $bodega = $_POST['bodega'];
}if (isset($_POST['proveedor'])) {
    $movimiento = $_POST['proveedor'];
}if (isset($_POST['tipo'])) {
    $producto = $_POST['tipo'];
}


$datos = obtener_inventario($bodega, $movimiento, $producto);


$html = '<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte de clientes</title>
    <link rel="stylesheet" href="estilo_reporte.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="logo_reporte.png" width="100px">
      </div>
      <h1>Reporte de Inventario</h1>
      <div id="company" class="clearfix">
        <div>' . $nombre_institucion . '</div>        
      </div>
      <div id="project">        
        <div><span>FECHA IMPRESIÓN: </span>' . $fecha . '</div>        
        <!--><div><span>DUE DATE</span> September 17, 2015</div>-->
      </div>
    </header>
    <main>
      <table>
        <thead>
            <tr>
                <th>Bodega</th>
                <th>Movimiento</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Fecha de Movimiento</th>
            </tr>
        </thead>
        <tbody>';
$html .= $datos;


$html .= '</tbody>
      </table>
     
    </main>
    <footer>
     	
    </footer>
  </body>
</html>';


$pdf = new mPDF('c', 'A4');
$pdf->writeHTML($html);
$pdf->Output("reporte.pdf", "I");
?>