<?php

//include_once '../mpdf60/mpdf.php';
include_once '../core/pdf/mpdf.php';
include '../../database.php';

function obtener_compras($usuario = '', $fecha= '') {
    $condicion = "";
    $html = "";

    $condicion_usuario = "";
    $condicion_fecha = "";
    
    if (!empty($fecha)) {
            $condicion_fecha = " compra.fecha_compra LIKE '%" . $fecha . "%'";
        }if (!empty($usuario)) {
            $condicion_usuario = " usuario.usuario_login LIKE '%" . $usuario . "%'";
        }

    if (!empty($condicion_usuario) && !empty($condicion_fecha)) {
            $condicion = " WHERE (" . $condicion_usuario . ") AND (" . $condicion_fecha . ") ";
        } elseif (!empty($condicion_usuario)) {
            $condicion = " WHERE " . $condicion_usuario;
        } elseif (!empty($condicion_fecha)) {
            $condicion = " WHERE " . $condicion_fecha;
        }

    $pdo = Database::connect();
        $sql = "SELECT usuario.usuario_login, compra.fecha_compra, compra.total from compra
                INNER JOIN usuario ON usuario.codigo_usuario = compra.codigo_usuario " . $condicion;

        foreach ($pdo->query($sql) as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['usuario_login'] . '</td>';
            $html .= '<td>' . $row['fecha_compra'] . '</td>';
            $html .= '<td>' . $row['total'] . '</td>';
            $html .= '</tr>';
            $total += $row['total'];
        }
        $html .= '<tr><td colspan="2"></td><td>TOTAL: $'. $total . '</td></tr>';
        return $html;
}

$nombre_institucion = "SISCOMED";
$fecha = date('d/m/Y');

$valor = "";
$usuario = "";
$fechaBusq = "";
$producto = "";

if (isset($_POST['usuario'])) {
	$usuario = $_POST['usuario'];
}
if (isset($_POST['fecha'])) {
	$fechaBusq = $_POST['fecha'];
}


$datos = obtener_compras($usuario, $fechaBusq);


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
      <h1>Reporte de Compras</h1>
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
                <th>Usuario</th>
                <th>Fecha de Compra</th>
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