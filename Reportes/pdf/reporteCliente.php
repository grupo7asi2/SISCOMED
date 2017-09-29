<?php
include_once '../core/pdf/mpdf.php';
//include_once '../mpdf60/mpdf.php';
include '../../database.php';

function obtener_cliente($value='')
  {
    $condicion = "";
    $html = "";
    if (!empty($value)) {
      $condicion = " WHERE codigo_cliente LIKE '%".$value."%' OR nombre_cliente LIKE '%".$value."%' 
      OR apellido_cliente LIKE '%".$value."%' OR correo LIKE '%".$value."%' OR telefono LIKE '%".$value."%' 
      OR direccion LIKE '%".$value."%' OR departamento LIKE '%".$value."%' OR municipio LIKE '%".$value."%' ";
    }
        $pdo = Database::connect();
        $sql = 'SELECT codigo_cliente,nombre_cliente,apellido_cliente,correo,telefono,direccion,departamento,
        municipio FROM cliente '.$condicion.' ORDER BY codigo_cliente ASC';
    foreach ($pdo->query($sql) as $row) {
        $html .=  '<tr>';
                                                $html .=  '<td>' . $row['codigo_cliente'] . '</td>';
                                                $html .=  '<td>' . $row['nombre_cliente'] . '</td>';
                                                $html .=  '<td>' . $row['apellido_cliente'] . '</td>';
                                                $html .=  '<td>' . $row['correo'] . '</td>';
                                                $html .=  '<td>' . $row['telefono'] . '</td>';
                                                $html .=  '<td>' . $row['direccion'] . '</td>';
                                                $html .=  '<td>' . $row['departamento'] . '</td>';
                                                $html .=  '<td>' . $row['municipio'] . '</td>';
                                               
    }
    Database::disconnect();
    return $html;
  }

$nombre_institucion = "SISCOMED";
$fecha = date('d/m/Y');

$valor = "";
$datos = "";

if (isset($_POST['texto'])) {
  $valor = $_POST['texto'];
}
$datos = obtener_cliente($valor);


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
      <h1>Reporte de clientes</h1>
      <div id="company" class="clearfix">
        <div>'.$nombre_institucion. '</div>        
      </div>
      <div id="project">        
        <div><span>FECHA IMPRESIÓN: </span>'.$fecha.'</div>        
        <!--><div><span>DUE DATE</span> September 17, 2015</div>-->
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
                                                <th>Codigo</th>
                                                <th>Nombre Cliente</th>
                                                <th>Apellidos Cliente</th>
                                                <th>Correo</th>
                                                <th>Telefono</th>
                                                <th>Direccion</th>
                                                <th>Departamento</th>
                                                <th>Municipio</th>
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
        
          
$pdf = new mPDF('c','A4');
$pdf->writeHTML($html);
$pdf->Output("reporte.pdf","I");


?>