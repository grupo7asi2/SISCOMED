<?php

//include_once '../mpdf60/mpdf.php';
include_once '../core/pdf/mpdf.php';
include '../../database.php';

function obtener_ventas($factura = '', $cliente='', $fecha= '') {
    $condicion = "";
    $html = "";

    $condicion_cliente = "";
    $condicion_factura = "";
    $condicion_fecha = "";
    
    if (!empty($factura)) {
            $condicion_factura = " factura.codigo_factura = " . $factura . "";
        }if (!empty($cliente)) {
            $condicion_cliente = " CONCAT(cliente.nombre_cliente, ' ', cliente.apellido_cliente) LIKE '%" . $cliente . "%'";
        }if (!empty($fecha)) {
            $condicion_fecha = " factura.fecha_venta LIKE '%" . $fecha . "%' ";
        }

        if (!empty($condicion_cliente) && !empty($condicion_factura) && !empty($condicion_fecha)) {
            $condicion = " WHERE (" . $condicion_cliente . ") AND (" . $condicion_factura . ") AND (" . $condicion_fecha . ")";
        } elseif (!empty($condicion_cliente) && !empty($condicion_factura)) {
            $condicion = " WHERE (" . $condicion_cliente . ") AND (" . $condicion_factura . ") ";
        } elseif (!empty($condicion_cliente) && !empty($condicion_fecha)) {
            $condicion = " WHERE (" . $condicion_cliente . ") AND (" . $condicion_fecha . ") ";
        } elseif (!empty($condicion_factura) && !empty($condicion_fecha)) {
            $condicion = " WHERE (" . $condicion_factura . ") AND (" . $condicion_fecha . ") ";
        } elseif (!empty($condicion_cliente)) {
            $condicion = " WHERE " . $condicion_cliente;
        } elseif (!empty($condicion_factura)) {
            $condicion = " WHERE " . $condicion_factura;
        } elseif (!empty($condicion_fecha)) {
            $condicion = " WHERE " . $condicion_fecha;
        }

        $pdo = Database::connect();
        $sql = "SELECT factura.codigo_factura, CONCAT(cliente.nombre_cliente, ' ', cliente.apellido_cliente) 
            as Cliente, factura.fecha_venta, factura.total FROM factura 
            INNER JOIN cliente ON cliente.codigo_cliente = factura.codigo_cliente " . $condicion;
        $total = NULL;
        foreach ($pdo->query($sql) as $row) {
            $codigo = $row['codigo_factura'];
            $codFact = NULL;
            if ($row['codigo_factura']<=9999){
                $codFact = "0" . $codigo;
            }
            if ($row['codigo_factura']<=999){
                $codFact = "00" . $codigo;
            }
            if ($row['codigo_factura']<=99){
                $codFact = "000" . $codigo;
            }
            if ($row['codigo_factura']<=9){
                $codFact = "0000" . $codigo;
            }
            $html .= '<tr>';
            $html .= '<td>' . $codFact . '</td>';
            $html .= '<td>' . $row['Cliente'] . '</td>';
            $html .= '<td>' . $row['fecha_venta'] . '</td>';
            $html .= '<td>' . $row['total'] . '</td>';
            $html .= '</tr>';
            $total += $row['total'];
        }
        $html .= '<tr><td colspan="3"></td><td>TOTAL: $'. $total . '</td></tr>';
        Database::disconnect();
        return $html;
}

$nombre_institucion = "SISCOMED";
$fecha = date('d/m/Y');

$valor = "";
$numFactura = "";
$nomCliente = "";
$fechaVenta = "";

if (isset($_POST['numfactura'])) {
	$numFactura = $_POST['numfactura'];
}
if (isset($_POST['cliente'])) {
	$nomCliente = $_POST['cliente'];
}
if (isset($_POST['fecha'])) {
	$fechaVenta = $_POST['fecha'];
}


$datos = obtener_ventas($numFactura, $nomCliente, $fechaVenta);


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
      <h1>Reporte de Ventas</h1>
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
                <th># Factura</th>
                <th>Cliente</th>
                <th>Fecha de Venta</th>
                <th>Total</th>
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