-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2016 a las 21:49:34
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `farmacia`
--
CREATE DATABASE IF NOT EXISTS `farmacia` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `farmacia`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `codigo_bodega` int(11) NOT NULL,
  `nombre_bodega` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`codigo_bodega`, `nombre_bodega`, `telefono`, `direccion`, `descripcion`) VALUES
(2, 'San Lorenzo', 77445555, 'Calle Vista Hermosa, Colonia EscalÃ³n Norte, San Salvador', 'Se guardan todos los medicamentos'),
(3, 'Bodega La BendiciÃ³n', 25884566, 'Calle Loma Linda, pasaje 3, casa #24, San Salvador', 'Bodega principal de la empresa.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `codigo_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`codigo_cargo`, `nombre_cargo`) VALUES
(1, 'Cajero'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `codigo_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `apellido_cliente` varchar(100) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(50) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `municipio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`codigo_cliente`, `nombre_cliente`, `apellido_cliente`, `correo`, `telefono`, `direccion`, `departamento`, `municipio`) VALUES
(1, 'William', 'Shakespeare', 'shakespeare@mail.com', '79855522', 'Av. Las Magnolias #25', 'San Salvador', 'San Salvador'),
(3, 'Ana', 'Cornejo', '', '79550011', 'Residencial Villas del Mar #43', 'San Salvador', 'San Salvador'),
(4, 'Raul Ignacio', 'Perez Peraza', 'perez@hotmail.com', '76664555', 'Calle al VolcÃ¡n, casa 54', 'San Salvador', 'San Salvador'),
(5, 'MartÃ­n', 'Pescador', '', '78787899', 'Colonia Iberia', 'San Salvador', 'San Salvador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `codigo_compra` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`codigo_compra`, `codigo_usuario`, `fecha_compra`, `total`) VALUES
(2, 1, '2016-11-30 15:29:57', 455.8),
(3, 1, '2016-11-30 15:30:17', 146.2),
(4, 1, '2016-11-30 11:48:42', 406.8),
(5, 1, '2016-12-02 06:31:42', 52.5),
(6, 1, '2016-12-02 06:32:25', 52.5),
(7, 1, '2016-12-02 06:33:42', 52.5),
(8, 1, '2016-12-30 06:37:12', 52.5),
(9, 1, '2016-12-29 06:38:21', 52.5),
(10, 1, '2016-12-30 06:38:55', 52.5),
(11, 1, '2016-12-30 06:40:12', 52.5),
(12, 1, '2016-12-16 06:45:43', 52.5),
(13, 1, '2016-12-15 06:46:12', 231),
(14, 1, '2016-12-09 06:48:16', 52.5),
(15, 1, '2016-12-02 08:29:21', 265),
(16, 1, '2016-12-21 08:45:08', 265),
(17, 1, '2016-12-29 08:47:26', 265);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `codigo_pedido` int(11) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `codigo_compra` int(11) NOT NULL,
  `cantidad_producto` int(11) NOT NULL,
  `precio_tot_producto` double NOT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`codigo_pedido`, `codigo_producto`, `codigo_compra`, `cantidad_producto`, `precio_tot_producto`, `fecha_vencimiento`) VALUES
(1, 1, 2, 43, 225.75, '2016-11-29'),
(2, 4, 2, 43, 230.05, '2016-11-30'),
(3, 3, 3, 43, 146.2, '2016-11-29'),
(4, 1, 4, 53, 278.25, '2016-12-01'),
(5, 3, 4, 22, 74.8, '2016-12-01'),
(6, 5, 4, 43, 53.75, '2016-12-10'),
(7, 1, 5, 10, 52.5, '2016-12-30'),
(8, 1, 6, 10, 52.5, '2016-12-30'),
(9, 1, 7, 10, 52.5, '2016-12-30'),
(10, 1, 8, 10, 52.5, '2016-12-02'),
(11, 1, 9, 10, 52.5, '2016-12-02'),
(12, 1, 10, 10, 52.5, '2016-12-02'),
(13, 1, 11, 10, 52.5, '2016-12-22'),
(14, 1, 12, 10, 52.5, '2016-12-30'),
(15, 1, 13, 44, 231, '2016-12-02'),
(16, 1, 14, 10, 52.5, '2016-12-02'),
(17, 6, 15, 50, 265, '2016-12-30'),
(18, 6, 16, 50, 265, '2016-12-22'),
(19, 6, 17, 50, 265, '2016-12-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `codigo_venta` int(11) NOT NULL,
  `codigo_factura` int(11) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_tot_producto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`codigo_venta`, `codigo_factura`, `codigo_producto`, `cantidad`, `precio_tot_producto`) VALUES
(1, 1, 4, 1, 7.89),
(2, 1, 5, 5, 18),
(3, 2, 1, 2, 25),
(4, 2, 4, 1, 7.89),
(5, 2, 5, 5, 18),
(6, 3, 3, 2, 16.5),
(7, 3, 5, 4, 14.4),
(8, 3, 1, 1, 12.5),
(9, 4, 1, 1, 12.5),
(10, 4, 5, 11, 39.6),
(11, 4, 4, 2, 15.78),
(12, 5, 1, 10, 125),
(13, 6, 1, 10, 125),
(14, 7, 1, 1, 12.5),
(15, 8, 6, 50, 325),
(16, 9, 1, 3, 37.5),
(17, 10, 1, 1, 12.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `codigo_empleado` int(11) NOT NULL,
  `codigo_cargo` int(11) NOT NULL,
  `nombre_empleado` varchar(100) NOT NULL,
  `apellido_empleado` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `dui` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`codigo_empleado`, `codigo_cargo`, `nombre_empleado`, `apellido_empleado`, `correo`, `telefono`, `fecha_ingreso`, `dui`) VALUES
(1, 3, 'Osiris', 'ChÃ¡vez', 'osiris@mail.com', '797979792', '2016-11-01', 41597511),
(91354, 1, 'Marco Antonio', 'SolÃ­s', 'marco@solis.com', '99999999', '2016-08-11', 114512541),
(91355, 1, 'Sor Juana', 'InÃ©s de la Cruz', 'sorjuana@cruz.com', '7894561322', '2013-02-13', 123456789);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `codigo_factura` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `codigo_cliente` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`codigo_factura`, `codigo_usuario`, `codigo_cliente`, `fecha_venta`, `total`) VALUES
(1, 1, 4, '2016-11-30 12:05:52', 25.89),
(2, 2, 1, '2016-11-30 22:13:36', 50.89),
(3, 1, 4, '2016-11-30 23:10:19', 43.4),
(4, 1, 5, '2016-12-01 01:16:08', 67.88),
(5, 1, 4, '2016-12-22 22:22:35', 125),
(6, 1, 4, '2016-12-28 08:27:54', 125),
(7, 1, 1, '2016-12-29 08:44:34', 12.5),
(8, 1, 4, '2016-12-29 08:47:49', 325),
(9, 1, 1, '2016-12-21 13:34:21', 37.5),
(10, 1, 4, '2016-12-28 13:36:13', 12.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `codigo_inventario` int(11) NOT NULL,
  `codigo_bodega` int(11) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `tipo_movimiento` varchar(8) NOT NULL,
  `fecha_movimiento` datetime NOT NULL,
  `cantidad_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`codigo_inventario`, `codigo_bodega`, `codigo_producto`, `tipo_movimiento`, `fecha_movimiento`, `cantidad_producto`) VALUES
(1, 3, 1, 'COMPRA', '2016-12-02 06:32:25', 10),
(2, 3, 1, 'COMPRA', '2016-12-02 06:33:42', 10),
(3, 3, 1, 'COMPRA', '2016-12-30 06:37:12', 10),
(4, 3, 1, 'COMPRA', '2016-12-29 06:38:21', 10),
(5, 3, 1, 'COMPRA', '2016-12-30 06:38:55', 10),
(6, 3, 1, 'COMPRA', '2016-12-30 06:40:12', 10),
(7, 3, 1, 'COMPRA', '2016-12-16 06:45:43', 10),
(8, 3, 1, 'COMPRA', '2016-12-15 06:46:12', 44),
(9, 3, 1, 'COMPRA', '2016-12-09 06:48:16', 10),
(10, 3, 6, 'COMPRA', '2016-12-02 08:29:21', 50),
(11, 3, 6, 'COMPRA', '2016-12-21 08:45:08', 50),
(12, 3, 6, 'COMPRA', '2016-12-29 08:47:26', 50),
(13, 3, 1, 'VENTA', '2016-12-21 13:34:21', 3),
(14, 3, 1, 'VENTA', '2016-12-28 13:36:13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo_producto` int(11) NOT NULL,
  `codigo_tipoproducto` int(11) NOT NULL,
  `codigo_proveedor` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `presentacion` varchar(50) NOT NULL,
  `precio_compra` double NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo_producto`, `codigo_tipoproducto`, `codigo_proveedor`, `nombre_producto`, `presentacion`, `precio_compra`, `precio_venta`) VALUES
(1, 3, 1, 'Shampoo de GÃ¼ayaba', 'Bote 150ml', 5.25, 12.5),
(3, 2, 1, 'Miel de Abeja Reina', 'Bote 100ml', 3.4, 8.25),
(4, 2, 4, 'Aceite de Almendras', 'Frasco de 80ml', 5.35, 7.89),
(5, 3, 2, 'Piel de Naranja', 'Bolsa de 15g', 1.25, 3.6),
(6, 4, 3, 'Pocion de Ajenjo', 'Frasco de 150ml', 5.3, 6.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codigo_proveedor` int(11) NOT NULL,
  `nombre_empresa` varchar(80) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `representante_empresa` varchar(100) NOT NULL,
  `identificacion` varchar(30) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `comentario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codigo_proveedor`, `nombre_empresa`, `direccion`, `representante_empresa`, `identificacion`, `telefono`, `correo`, `comentario`) VALUES
(1, 'Fucrisan', 'Av. Las Magnolias #25', 'Manuel Acevedo', '14232134', '1234234', '', 'Medicinas Naturales'),
(2, 'Laboratorio LÃ³pez', 'Santa Tecla', 'Don Manolo', '04560216', '335454465', '', 'Loratadinas'),
(3, 'Laboratorio PÃ©rez', 'San Miguel', 'JuliÃ¡n Medina', '54650123', '3355442211', 'medina@gmail.com', 'Otras medicinas y yerbas.'),
(4, 'Laboratorio El Natural', 'Residencial Lomas de San Juan, San Salvador', 'Sergio Raul Ramos Zepeda', '154455699', '25884666', 'sergio@gmail.com', 'Proveedor de medicina natural.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL,
  `codigo_bodega` int(11) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `existencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id_stock`, `codigo_bodega`, `codigo_producto`, `existencia`) VALUES
(1, 3, 1, 39),
(4, 3, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `codigo_tipoproducto` int(11) NOT NULL,
  `nombre_tipoproducto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`codigo_tipoproducto`, `nombre_tipoproducto`) VALUES
(2, 'Natural'),
(3, 'Shampoo'),
(4, 'UngÃ¼ento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `codigo_tipoUsuario` int(11) NOT NULL,
  `nombre_tipoUsuario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`codigo_tipoUsuario`, `nombre_tipoUsuario`) VALUES
(1, 'Administrador'),
(2, 'Encargado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `codigo_usuario` int(11) NOT NULL,
  `codigo_tipoUsuario` int(11) NOT NULL,
  `codigo_empleado` int(11) NOT NULL,
  `usuario_login` varchar(100) NOT NULL,
  `password_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`codigo_usuario`, `codigo_tipoUsuario`, `codigo_empleado`, `usuario_login`, `password_usuario`) VALUES
(1, 1, 1, 'ochavez', '123456'),
(2, 1, 91355, 'sines', '123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`codigo_bodega`),
  ADD UNIQUE KEY `codigo_bodega_UNIQUE` (`codigo_bodega`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`codigo_cargo`),
  ADD UNIQUE KEY `codigo_cargo_UNIQUE` (`codigo_cargo`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`codigo_cliente`),
  ADD UNIQUE KEY `codigo_cliente_UNIQUE` (`codigo_cliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`codigo_compra`),
  ADD UNIQUE KEY `codigo_compra_UNIQUE` (`codigo_compra`),
  ADD KEY `fk_Compra_Usuario_idx` (`codigo_usuario`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`codigo_pedido`),
  ADD UNIQUE KEY `codigo_pedido_UNIQUE` (`codigo_pedido`),
  ADD KEY `fk_Pedido_Producto_idx` (`codigo_producto`),
  ADD KEY `fk_Pedido_Compra_idx` (`codigo_compra`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`codigo_venta`),
  ADD UNIQUE KEY `codigo_venta_UNIQUE` (`codigo_venta`),
  ADD KEY `fk_Venta_Factura1_idx` (`codigo_factura`),
  ADD KEY `fk_Venta_Producto1_idx` (`codigo_producto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`codigo_empleado`),
  ADD UNIQUE KEY `codigo_empleado_UNIQUE` (`codigo_empleado`),
  ADD KEY `fk_Empleado_Cargo1_idx` (`codigo_cargo`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`codigo_factura`),
  ADD UNIQUE KEY `codigo_factura_UNIQUE` (`codigo_factura`),
  ADD KEY `fk_Factura_Cliente1_idx` (`codigo_cliente`),
  ADD KEY `fk_Factura_Usuario1_idx` (`codigo_usuario`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`codigo_inventario`),
  ADD UNIQUE KEY `codigo_inventario_UNIQUE` (`codigo_inventario`),
  ADD KEY `fk_Inventario_Producto1_idx` (`codigo_producto`),
  ADD KEY `fk_Inventario_Bodega_idx` (`codigo_bodega`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo_producto`),
  ADD UNIQUE KEY `codigo_producto_UNIQUE` (`codigo_producto`),
  ADD KEY `fk_Productos_Tipo_Producto1_idx` (`codigo_tipoproducto`),
  ADD KEY `fk_Producto_Proveedor1_idx` (`codigo_proveedor`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codigo_proveedor`),
  ADD UNIQUE KEY `codigo_proveedor_UNIQUE` (`codigo_proveedor`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD UNIQUE KEY `id_stock` (`id_stock`),
  ADD KEY `codigo_bodega` (`codigo_bodega`) USING BTREE,
  ADD KEY `codigo_producto` (`codigo_producto`) USING BTREE;

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`codigo_tipoproducto`),
  ADD UNIQUE KEY `codigo_tipoproducto_UNIQUE` (`codigo_tipoproducto`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`codigo_tipoUsuario`),
  ADD UNIQUE KEY `codigo_tipUsuario_UNIQUE` (`codigo_tipoUsuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo_usuario`),
  ADD UNIQUE KEY `codigo_usuario_UNIQUE` (`codigo_usuario`),
  ADD KEY `fk_Usuario_Tipo_Usuario1_idx` (`codigo_tipoUsuario`),
  ADD KEY `fk_Usuario_Empleado1_idx` (`codigo_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bodega`
--
ALTER TABLE `bodega`
  MODIFY `codigo_bodega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `codigo_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `codigo_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `codigo_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `codigo_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `codigo_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `codigo_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91356;
--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `codigo_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `codigo_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codigo_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codigo_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `codigo_tipoproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `codigo_tipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_Compra_Usuario` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_Pedido_Compra` FOREIGN KEY (`codigo_compra`) REFERENCES `compra` (`codigo_compra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Pedido_Producto` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_Venta_Factura1` FOREIGN KEY (`codigo_factura`) REFERENCES `factura` (`codigo_factura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Venta_Producto1` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_Empleado_Cargo1` FOREIGN KEY (`codigo_cargo`) REFERENCES `cargo` (`codigo_cargo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_Factura_Cliente1` FOREIGN KEY (`codigo_cliente`) REFERENCES `cliente` (`codigo_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Factura_Usuario1` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_Inventario_Bodega` FOREIGN KEY (`codigo_bodega`) REFERENCES `bodega` (`codigo_bodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Inventario_Producto` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_Producto_Proveedor1` FOREIGN KEY (`codigo_proveedor`) REFERENCES `proveedor` (`codigo_proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Productos_Tipo_Producto1` FOREIGN KEY (`codigo_tipoproducto`) REFERENCES `tipo_producto` (`codigo_tipoproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_Stock_Bodega` FOREIGN KEY (`codigo_bodega`) REFERENCES `bodega` (`codigo_bodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Stock_Producto` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_Usuario_Empleado1` FOREIGN KEY (`codigo_empleado`) REFERENCES `empleado` (`codigo_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Usuario_Tipo_Usuario1` FOREIGN KEY (`codigo_tipoUsuario`) REFERENCES `tipo_usuario` (`codigo_tipoUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
