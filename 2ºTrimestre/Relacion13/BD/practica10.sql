-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2026 a las 19:03:00
-- Versión del servidor: 12.1.2-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practica10`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_roles`
--

CREATE TABLE `acl_roles` (
  `cod_acl_role` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `perm1` tinyint(1) NOT NULL DEFAULT 0,
  `perm2` tinyint(1) NOT NULL DEFAULT 0,
  `perm3` tinyint(1) NOT NULL DEFAULT 0,
  `perm4` tinyint(1) NOT NULL DEFAULT 0,
  `perm5` tinyint(1) NOT NULL DEFAULT 0,
  `perm6` tinyint(1) NOT NULL DEFAULT 0,
  `perm7` tinyint(1) NOT NULL DEFAULT 0,
  `perm8` tinyint(1) NOT NULL DEFAULT 0,
  `perm9` tinyint(1) NOT NULL DEFAULT 0,
  `perm10` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_roles`
--

INSERT INTO `acl_roles` (`cod_acl_role`, `nombre`, `perm1`, `perm2`, `perm3`, `perm4`, `perm5`, `perm6`, `perm7`, `perm8`, `perm9`, `perm10`) VALUES
(1, 'administrativo', 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(2, 'comprador', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0),
(3, 'administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_usuarios`
--

CREATE TABLE `acl_usuarios` (
  `cod_acl_usuario` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `contrasenia` varchar(64) NOT NULL,
  `cod_acl_role` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_usuarios`
--

INSERT INTO `acl_usuarios` (`cod_acl_usuario`, `nick`, `nombre`, `contrasenia`, `cod_acl_role`, `borrado`) VALUES
(4, 'raul', 'raul', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 3, 0),
(5, 'comp', 'comp', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 2, 0);
(6, 'pepe', 'pepe', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cod_categoria` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cod_categoria`, `descripcion`) VALUES
(1, 'Electrónica'),
(2, 'Hogar'),
(3, 'Deportes'),
(4, 'Informática'),
(5, 'Juguetes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `cod_compra` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `importe_base` float NOT NULL,
  `importe_iva` float NOT NULL,
  `importe_total` float NOT NULL,
  `modo_pago` varchar(50) NOT NULL,
  `datos_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`cod_compra`, `cod_usuario`, `fecha`, `importe_base`, `importe_iva`, `importe_total`, `modo_pago`, `datos_pago`) VALUES
(1, 8, '2026-01-04', 340, 71.4, 411.4, 'transferencia', ''),
(2, 8, '2026-01-04', 299, 62.79, 361.79, 'tarjeta', ''),
(3, 8, '2026-01-04', 41, 8.61, 49.61, 'tarjeta', ''),
(4, 8, '2026-01-04', 41, 8.61, 49.61, 'tarjeta', 'adw'),
(5, 8, '2026-01-04', 365.96, 76.86, 442.82, 'tarjeta', 'Holaaaaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_lineas`
--

CREATE TABLE `compra_lineas` (
  `cod_compra_linea` int(11) NOT NULL,
  `cod_compra` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_unidad` float NOT NULL,
  `iva` int(11) NOT NULL,
  `importe_base` float NOT NULL,
  `importe_iva` float NOT NULL,
  `importe_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `compra_lineas`
--

INSERT INTO `compra_lineas` (`cod_compra_linea`, `cod_compra`, `cod_producto`, `orden`, `unidades`, `precio_unidad`, `iva`, `importe_base`, `importe_iva`, `importe_total`) VALUES
(1, 1, 5, 1, 1, 299, 0, 299, 62.79, 361.79),
(2, 1, 10, 2, 1, 41, 0, 41, 8.61, 49.61),
(3, 2, 5, 1, 1, 299, 0, 299, 62.79, 361.79),
(4, 3, 10, 1, 1, 41, 0, 41, 8.61, 49.61),
(5, 4, 10, 1, 1, 41, 0, 41, 8.61, 49.61),
(6, 5, 1, 1, 2, 59.99, 0, 119.98, 25.2, 145.18),
(7, 5, 6, 2, 1, 24.99, 0, 24.99, 5.25, 30.24),
(8, 5, 10, 3, 1, 41, 0, 41, 8.61, 49.61),
(9, 5, 9, 4, 1, 179.99, 0, 179.99, 37.8, 217.79);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_compras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_compras` (
`cod_compra` int(11)
,`cod_usuario` int(11)
,`nick` varchar(50)
,`nombre` varchar(50)
,`fecha` date
,`importe_total` float
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_compra_lineas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_compra_lineas` (
`cod_compra` int(11)
,`cod_producto` int(11)
,`nombre_producto` varchar(50)
,`unidades` int(11)
,`precio_unidad` float
,`importe_total` float
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_productos` (
`cod_producto` int(11)
,`nombre` varchar(50)
,`fabricante` varchar(50)
,`fecha_alta` date
,`unidades` int(11)
,`precio_base` float
,`iva` int(11)
,`precio_iva` float
,`precio_venta` double
,`foto` varchar(50)
,`borrado` tinyint(1)
,`cod_categoria` int(11)
,`nombre_categoria` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `cod_producto` int(11) NOT NULL,
  `cod_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fabricante` varchar(50) NOT NULL,
  `fecha_alta` date NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_base` float NOT NULL,
  `iva` int(11) NOT NULL,
  `precio_iva` float NOT NULL,
  `precio_venta` double NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`cod_producto`, `cod_categoria`, `nombre`, `fabricante`, `fecha_alta`, `unidades`, `precio_base`, `iva`, `precio_iva`, `precio_venta`, `foto`, `borrado`) VALUES
(1, 1, 'Auriculares Bluetooth', 'Sony', '2024-01-10', 48, 40, 21, 48.4, 59.99, 'auriculares.jpg', 0),
(2, 1, 'Smartwatch Deportivo', 'Xiaomi', '2024-02-01', 30, 60, 21, 72.6, 89.99, 'smartwatch.jpg', 0),
(3, 4, 'Teclado Mecánico RGB', 'Logitech', '2024-01-15', 20, 70, 21, 84.7, 99, 'teclado.jpg', 0),
(4, 4, 'Ratón Gaming', 'Razer', '2024-01-20', 35, 35, 21, 42.35, 54.99, 'raton.jpg', 0),
(5, 2, 'Aspiradora Ciclónica', 'Dyson', '2024-01-05', 3, 200, 21, 242, 299, 'aspiradora.jpg', 0),
(6, 3, 'Balón de Fútbol', 'Adidas', '2024-02-10', 89, 15, 21, 18.15, 24.99, 'balon.jpg', 0),
(7, 3, 'Bicicleta Montaña', 'Orbea', '2024-01-25', 5, 300, 21, 363, 449.99, 'bicicleta.jpg', 0),
(8, 5, 'Lego Star Wars', 'LEGO', '2024-02-12', 20, 50, 21, 60.5, 79.99, 'lego.jpg', 0),
(9, 2, 'Cafetera Automática', 'Philips', '2024-01-18', 14, 120, 21, 145.2, 179.99, 'cafetera.jpg', 0),
(10, 4, 'Altavoz Inteligent', 'Amazon', '2026-01-01', 41, 25, 21, 30.25, 41, 'altavoz.jpg', 0),
(11, 4, 'Monitor 27\" 144Hz', 'Samsung', '2024-02-15', 25, 180, 21, 217.8, 249.99, 'monitor.jpg', 0),
(12, 2, 'Robot Aspirador Inteligente', 'Roomba', '2024-01-28', 12, 220, 21, 266.2, 329.99, 'robot_aspirador.jpg', 0),
(13, 3, 'Camiseta Térmica', 'Nike', '2024-03-01', 50, 20.62, 21, 4.33, 24.95, 'nofoto.png', 0),
(14, 5, 'Puzzle 1000 piezas', 'Ravensburger', '2024-02-15', 30, 11.98, 21, 2.52, 14.5, 'nofoto.png', 0),
(15, 3, 'Tierra', 'Amazon', '2025-07-22', 45, 12, 21, 14.52, 14.52, NULL, 0),
(16, 3, 'Tierra2', 'Amazon', '2025-07-22', 45, 12, 21, 14.52, 14.52, NULL, 1),
(17, 3, 'Camiseta Térmica', 'Nike', '2024-03-01', 50, 20.62, 21, 4.33, 24.95, 'nofoto.png', 0),
(18, 5, 'Puzzle 1000 piezas', 'Ravensburger', '2024-02-15', 30, 11.98, 21, 2.52, 14.5, 'nofoto.png', 0),
(19, 3, 'Camiseta Térmicas', 'Nike', '2024-03-01', 50, 20.62, 21, 4.33, 24.95, 'nofoto.png', 0),
(20, 5, 'Puzzle 10001 piezas', 'Ravensburger', '2027-02-15', 30, 11.98, 21, 2.52, 14.5, 'nofoto.png', 0),
(21, 3, 'Camiseta Térmicass', 'Nike', '2024-03-01', 50, 20.62, 21, 4.33, 24.95, 'nofoto.png', 0),
(22, 5, 'Puzzle 100011 piezas', 'Ravensburger', '2027-02-15', 30, 11.98, 21, 2.52, 14.5, 'nofoto.png', 0),
(23, 3, 'Camiseta Trmicass', 'Nike', '2024-03-01', 50, 20.62, 21, 4.33, 24.95, 'nofoto.png', 0),
(24, 5, 'Puzzle 101 piezas', 'Ravensburger', '2027-02-15', 30, 11.98, 21, 2.52, 14.5, 'nofoto.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nick`, `nombre`) VALUES
(1, 'comprador', 'Comprador4'),
(2, 'adminis', 'Administrativo'),
(3, 'admin', 'Administrador'),
(4, 'raul', 'raul'),
(5, 'carmen', 'carmen'),
(6, 'pepe', 'pepe'),
(7, 'marcos', 'ErBicho'),
(8, 'mama', 'Caracola');

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_compras`
--
DROP TABLE IF EXISTS `cons_compras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_compras`  AS SELECT `c`.`cod_compra` AS `cod_compra`, `c`.`cod_usuario` AS `cod_usuario`, `u`.`nick` AS `nick`, `u`.`nombre` AS `nombre`, `c`.`fecha` AS `fecha`, `c`.`importe_total` AS `importe_total` FROM (`compras` `c` join `usuarios` `u` on(`c`.`cod_usuario` = `u`.`cod_usuario`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_compra_lineas`
--
DROP TABLE IF EXISTS `cons_compra_lineas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_compra_lineas`  AS SELECT `cl`.`cod_compra` AS `cod_compra`, `cl`.`cod_producto` AS `cod_producto`, `p`.`nombre` AS `nombre_producto`, `cl`.`unidades` AS `unidades`, `cl`.`precio_unidad` AS `precio_unidad`, `cl`.`importe_total` AS `importe_total` FROM (`compra_lineas` `cl` join `productos` `p` on(`cl`.`cod_producto` = `p`.`cod_producto`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_productos`
--
DROP TABLE IF EXISTS `cons_productos`;

CREATE ALGORITHM=MERGE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_productos`  AS SELECT `p`.`cod_producto` AS `cod_producto`, `p`.`nombre` AS `nombre`, `p`.`fabricante` AS `fabricante`, `p`.`fecha_alta` AS `fecha_alta`, `p`.`unidades` AS `unidades`, `p`.`precio_base` AS `precio_base`, `p`.`iva` AS `iva`, `p`.`precio_iva` AS `precio_iva`, `p`.`precio_venta` AS `precio_venta`, `p`.`foto` AS `foto`, `p`.`borrado` AS `borrado`, `c`.`cod_categoria` AS `cod_categoria`, `c`.`descripcion` AS `nombre_categoria` FROM (`productos` `p` join `categorias` `c` on(`p`.`cod_categoria` = `c`.`cod_categoria`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  ADD PRIMARY KEY (`cod_acl_role`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD PRIMARY KEY (`cod_acl_usuario`),
  ADD UNIQUE KEY `uq_acl_roles_1` (`nick`),
  ADD KEY `cod_acl_role` (`cod_acl_role`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cod_categoria`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`cod_compra`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indices de la tabla `compra_lineas`
--
ALTER TABLE `compra_lineas`
  ADD PRIMARY KEY (`cod_compra_linea`),
  ADD KEY `cod_compra` (`cod_compra`),
  ADD KEY `cod_producto` (`cod_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`cod_producto`),
  ADD KEY `cod_categoria` (`cod_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  MODIFY `cod_acl_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  MODIFY `cod_acl_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `cod_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `cod_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compra_lineas`
--
ALTER TABLE `compra_lineas`
  MODIFY `cod_compra_linea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `cod_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD CONSTRAINT `fk_acl_roles_1` FOREIGN KEY (`cod_acl_role`) REFERENCES `acl_roles` (`cod_acl_role`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
