<?php

include '../database.php';

class cliente {

    function __construct() {
        # code...
    }

    public function obtener_cliente($value = '') {
        $condicion = "";
        $html = "";
        $value = trim($value);
        if (!empty($value)) {
            $condicion = " WHERE codigo_cliente LIKE '%" . $value . "%' OR nombre_cliente LIKE '%" . $value . "%' 
			OR apellido_cliente LIKE '%" . $value . "%' OR correo LIKE '%" . $value . "%' OR telefono LIKE '%" . $value . "%' 
			OR direccion LIKE '%" . $value . "%' OR departamento LIKE '%" . $value . "%' OR municipio LIKE '%" . $value . "%' ";
        }
        $pdo = Database::connect();
        $sql = 'SELECT codigo_cliente,nombre_cliente,apellido_cliente,correo,telefono,direccion,departamento,
        municipio FROM cliente ' . $condicion . ' ORDER BY codigo_cliente ASC';
        foreach ($pdo->query($sql) as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['codigo_cliente'] . '</td>';
            $html .= '<td>' . $row['nombre_cliente'] . '</td>';
            $html .= '<td>' . $row['apellido_cliente'] . '</td>';
            $html .= '<td>' . $row['correo'] . '</td>';
            $html .= '<td>' . $row['telefono'] . '</td>';
            $html .= '<td>' . $row['direccion'] . '</td>';
            $html .= '<td>' . $row['departamento'] . '</td>';
            $html .= '<td>' . $row['municipio'] . '</td>';
            $html .= '</tr>';
        }
        Database::disconnect();
        return $html;
    }

    public function obtener_empleado($value = '') {
        $condicion = "";
        $html = "";
        $value = trim($value);
        if (!empty($value)) {
            $condicion = " WHERE codigo_empleado LIKE '%" . $value . "%' OR nombre_empleado LIKE '%" . $value . "%' 
			OR apellido_empleado LIKE '%" . $value . "%' OR correo LIKE '%" . $value . "%' OR telefono LIKE '%" . $value . "%' 
			OR nombre_cargo LIKE '%" . $value . "%' OR fecha_ingreso LIKE '%" . $value . "%' OR dui LIKE '%" . $value . "%' ";
        }
        $pdo = Database::connect();
        $sql = 'SELECT codigo_empleado,nombre_empleado,apellido_empleado,nombre_cargo,correo,telefono,fecha_ingreso,
        dui FROM empleado
        INNER JOIN cargo cr ON cr.codigo_cargo = empleado.codigo_cargo ' . $condicion . ' ORDER BY codigo_empleado ASC';
        foreach ($pdo->query($sql) as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['codigo_empleado'] . '</td>';
            $html .= '<td>' . $row['nombre_empleado'] . '</td>';
            $html .= '<td>' . $row['apellido_empleado'] . '</td>';
            $html .= '<td>' . $row['nombre_cargo'] . '</td>';
            $html .= '<td>' . $row['correo'] . '</td>';
            $html .= '<td>' . $row['telefono'] . '</td>';
            $html .= '<td>' . $row['fecha_ingreso'] . '</td>';
            $html .= '<td>' . $row['dui'] . '</td>';
        }
        Database::disconnect();
        return $html;
    }

    public function obtener_producto($producto = '', $proveedor = '', $tipo_producto = '') {
        $condicion = "";
        $html = "";
        $condicion_proveedor = "";
        $condicion_producto = "";
        $condicion_tipo = "";
        $producto = trim($producto);
        $proveedor = trim($proveedor);
        $tipo_producto = trim($tipo_producto);

        if (!empty($proveedor)) {
            $condicion_proveedor = " pr.codigo_proveedor LIKE '%" . $proveedor . "%' OR pr.nombre_empresa LIKE '%" . $proveedor . "%' ";
        }if (!empty($producto)) {
            $condicion_producto = " pd.codigo_producto LIKE '%" . $producto . "%' OR pd.nombre_producto LIKE '%" . $producto . "%' ";
        }if (!empty($tipo_producto) && $tipo_producto <> "0") {
            $condicion_tipo = " tp.codigo_tipoproducto = '" . $tipo_producto . "' ";
        }

        if (!empty($condicion_producto) && !empty($condicion_proveedor) && !empty($condicion_tipo)) {
            $condicion = " WHERE (" . $condicion_producto . ") AND (" . $condicion_proveedor . ") AND (" . $condicion_tipo . ")";
        } elseif (!empty($condicion_producto) && !empty($condicion_proveedor)) {
            $condicion = " WHERE (" . $condicion_producto . ") AND (" . $condicion_proveedor . ") ";
        } elseif (!empty($condicion_producto) && !empty($condicion_tipo)) {
            $condicion = " WHERE (" . $condicion_producto . ") AND (" . $condicion_tipo . ") ";
        } elseif (!empty($condicion_proveedor) && !empty($condicion_tipo)) {
            $condicion = " WHERE (" . $condicion_proveedor . ") AND (" . $condicion_tipo . ") ";
        } elseif (!empty($condicion_producto)) {
            $condicion = " WHERE " . $condicion_producto;
        } elseif (!empty($condicion_proveedor)) {
            $condicion = " WHERE " . $condicion_proveedor;
        } elseif (!empty($condicion_tipo)) {
            $condicion = " WHERE " . $condicion_tipo;
        }

        $pdo = Database::connect();
        $sql = "SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.precio_venta, pd.presentacion from producto pd
            INNER JOIN proveedor pr ON pd.codigo_proveedor = pr.codigo_proveedor
            INNER JOIN tipo_producto tp ON pd.codigo_tipoproducto = tp.codigo_tipoproducto " . $condicion;

        foreach ($pdo->query($sql) as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['codigo_producto'] . '</td>';
            $html .= '<td>' . $row['nombre_producto'] . '</td>';
            $html .= '<td>' . $row['nombre_empresa'] . '</td>';
            $html .= '<td>' . $row['nombre_tipoproducto'] . '</td>';
            $html .= '<td>' . $row['presentacion'] . '</td>';
            $html .= '<td>' . $row['precio_venta'] . '</td>';
            $html .= '</tr>';
        }
        Database::disconnect();
        return $html;
    }

    
    public function obtener_inventario($bodega = '', $movimiento = '', $producto = '') {
        $condicion = "";
        $html = "";
        
        $condicion_movimiento = "";
        $condicion_bodega = "";
        $condicion_producto = "";
        $bodega = trim($bodega);
        $movimiento = trim($movimiento);
        $producto = trim($producto);

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
    
    public function obtener_tipo_producto() {
        $html = "";
        $pdo = Database::connect();
        $sql = 'SELECT codigo_tipoproducto, nombre_tipoproducto FROM tipo_producto 
        ORDER BY nombre_tipoproducto ASC';
        foreach ($pdo->query($sql) as $row) {
            $html .= "<option value='" . $row['codigo_tipoproducto'] . "'>" . $row['nombre_tipoproducto'] . "</option>";
        }
        return $html;
    }
    
    
    public function obtener_productos() {
        $html = "";
        $pdo = Database::connect();
        $sql = 'SELECT codigo_producto, nombre_producto FROM producto 
        ORDER BY nombre_producto ASC';
        foreach ($pdo->query($sql) as $row) {
            $html .= "<option value='" . $row['codigo_producto'] . "'>" . $row['nombre_producto'] . "</option>";
        }
        return $html;
    }
    
    public function obtener_compras($usuario = '', $fecha = '') {
        $condicion = "";
        $html = "";
        
        $condicion_fecha = "";
        $condicion_usuario = "";
        $usuario = trim($usuario);
        $fecha = trim($fecha);
        

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
        $total = NULL;
        foreach ($pdo->query($sql) as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['usuario_login'] . '</td>';
            $html .= '<td>' . $row['fecha_compra'] . '</td>';
            $html .= '<td>' . $row['total'] . '</td>';
            $html .= '</tr>';
            $total += $row['total'];
        }
        $html .= '<tr><td colspan="2"></td><td>TOTAL: $'. $total . '</td></tr>';
        Database::disconnect();
        return $html;
    }
    
    
    public function getCodFactFormat($codigo='') {
        
        return $codFact;
    }
    
    
    
    public function obtener_ventas($factura = '', $cliente = '', $fecha = '') {
        $condicion = "";
        $html = "";

        $condicion_factura = "";
        $condicion_cliente = "";
        $condicion_fecha = "";

        $factura = trim($factura);
        $cliente = trim($cliente);
        $fecha = trim($fecha);

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

    

}

?>