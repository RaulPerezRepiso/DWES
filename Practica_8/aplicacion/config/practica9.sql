-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2025 a las 20:50:31
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
-- Base de datos: `practica9`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `nick` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '''''',
  `nif` varchar(10) NOT NULL DEFAULT '''''',
  `direccion` varchar(50) NOT NULL DEFAULT '''''',
  `poblacion` varchar(30) NOT NULL DEFAULT '''''',
  `provincia` varchar(30) NOT NULL DEFAULT '''''',
  `cp` varchar(5) NOT NULL DEFAULT '00000',
  `fecha_nacimiento` date DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `foto` varchar(50) NOT NULL DEFAULT ''''''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nick`, `nombre`, `nif`, `direccion`, `poblacion`, `provincia`, `cp`, `fecha_nacimiento`, `borrado`, `foto`) VALUES
(1, 'r18', 'Raúl', '\'\'', '\'\'', '\'\'', '\'\'', '29200', '2003-03-27', 0, 'raul.jpg'),
(2, 'r18', 'Raúl', '\'\'', '\'\'', '\'\'', '\'\'', '29200', '2003-03-27', 0, 'raul.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
