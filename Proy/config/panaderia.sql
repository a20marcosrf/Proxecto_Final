-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2022 a las 20:46:06
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `panaderia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `codigo` int(10) NOT NULL,
  `usuario` int(10) NOT NULL,
  `producto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargo`
--

CREATE TABLE `encargo` (
  `codigo` int(10) NOT NULL,
  `nombre_usuario` varchar(25) NOT NULL,
  `fecha` date NOT NULL,
  `fecha2` date NOT NULL,
  `producto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `codigo` int(10) NOT NULL,
  `nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`codigo`, `nombre`) VALUES
(1, 'Masa empanadill'),
(2, 'Masa bolleria'),
(3, 'Verduras'),
(4, 'Chocolate'),
(5, 'Crema'),
(6, 'Nata'),
(7, 'Pollo'),
(8, 'Carne'),
(9, 'Bechamel'),
(10, 'Azucar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `numero` int(10) NOT NULL,
  `usuario` int(10) NOT NULL,
  `fecha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`numero`, `usuario`, `fecha`) VALUES
(11, 28, '02/22/2022 01:33:07 pm'),
(12, 28, '02/22/2022 01:42:27 pm'),
(13, 28, '02/22/2022 01:43:17 pm'),
(14, 28, '02/22/2022 01:44:27 pm'),
(15, 27, '02/22/2022 01:54:47 pm'),
(16, 27, '02/25/2022 02:06:49 pm'),
(17, 27, '03/01/2022 06:25:43 pm'),
(18, 27, '03/01/2022 07:29:57 pm'),
(19, 27, '03/01/2022 09:06:42 pm'),
(20, 27, '03/01/2022 09:15:48 pm'),
(21, 27, '03/01/2022 09:48:53 pm'),
(22, 27, '03/02/2022 12:49:46 pm'),
(24, 27, '03/02/2022 02:07:02 pm'),
(25, 27, '03/02/2022 02:31:04 pm'),
(27, 27, '03/02/2022 08:37:34 pm'),
(33, 27, '03/10/2022 05:34:20 pm'),
(34, 27, '03/10/2022 06:13:54 pm'),
(35, 27, '03/10/2022 07:07:47 pm'),
(36, 27, '03/10/2022 07:26:28 pm'),
(37, 33, '03/10/2022 07:36:47 pm'),
(38, 27, '03/10/2022 07:41:37 pm'),
(39, 27, '03/10/2022 07:43:20 pm'),
(40, 27, '03/10/2022 08:04:16 pm'),
(41, 27, '03/10/2022 08:05:31 pm'),
(42, 27, '03/10/2022 08:18:37 pm'),
(43, 27, '03/10/2022 08:25:01 pm'),
(44, 32, '03/10/2022 08:33:03 pm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mods`
--

CREATE TABLE `mods` (
  `numero` int(10) NOT NULL,
  `usuario` int(10) NOT NULL,
  `fecha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mods`
--

INSERT INTO `mods` (`numero`, `usuario`, `fecha`) VALUES
(5, 28, '02/22/2022 01:33:26 pm'),
(6, 28, '02/22/2022 01:34:31 pm'),
(7, 28, '02/22/2022 01:34:40 pm'),
(8, 28, '02/22/2022 01:35:13 pm'),
(9, 28, '02/22/2022 01:42:41 pm'),
(10, 28, '02/22/2022 01:42:47 pm'),
(11, 28, '02/22/2022 01:43:04 pm'),
(12, 28, '02/22/2022 01:46:35 pm'),
(13, 27, '02/25/2022 02:07:06 pm'),
(14, 27, '02/25/2022 02:07:38 pm'),
(15, 27, '02/25/2022 02:07:49 pm'),
(16, 27, '03/01/2022 06:26:13 pm'),
(17, 27, '03/01/2022 07:55:10 pm'),
(18, 27, '03/01/2022 08:32:55 pm'),
(19, 27, '03/01/2022 08:33:27 pm'),
(20, 27, '03/01/2022 08:51:12 pm'),
(21, 27, '03/01/2022 09:12:55 pm'),
(22, 27, '03/01/2022 09:13:13 pm'),
(23, 27, '03/01/2022 09:13:25 pm'),
(24, 27, '03/01/2022 09:13:38 pm'),
(25, 27, '03/01/2022 09:13:48 pm'),
(26, 27, '03/01/2022 09:14:33 pm'),
(27, 27, '03/01/2022 09:14:48 pm'),
(28, 27, '03/01/2022 09:15:06 pm'),
(29, 27, '03/01/2022 09:15:17 pm'),
(30, 27, '03/10/2022 06:14:18 pm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo` int(10) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `grupo` varchar(25) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio` float NOT NULL,
  `url` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `nombre`, `grupo`, `cantidad`, `precio`, `url`, `descripcion`) VALUES
(1, 'Empanadilla Pol', 'Salado', 10, 1.4, 'view/media/pollo.jpg', 'Empanadilla rellenada de pollo de la mejor calidad'),
(4, 'Donut ', 'Dulce', 2, 1, 'view/media/donut.jpg', 'Donut normal'),
(6, 'Cristina nata', 'Dulce', 5, 1.3, 'view/media/cristina.jpg', 'Cristina rellena de nata y bañada en chocolate'),
(7, 'Cristina crema', 'Dulce', 5, 1.3, 'view/media/cristina2.jpg', 'Cristina rellena de crema con azucar en polvo'),
(8, 'Donut ', 'Dulce', 2, 1, 'view/media/donut.jpg', 'Donut normal'),
(9, 'Donut chocolate', 'Dulce', 2, 1.2, 'view/media/donut2.jpg', 'Donut bañado en chocolate'),
(10, 'Cristina nata', 'Dulce', 5, 1.3, 'view/media/cristina.jpg', 'Cristina rellena de nata y bañada en chocolate'),
(11, 'Cristina crema', 'Dulce', 5, 1.3, 'view/media/cristina2.jpg', 'Cristina rellena de crema con azucar en polvo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_ingrediente`
--

CREATE TABLE `producto_ingrediente` (
  `producto` int(10) NOT NULL,
  `ingrediente` int(10) NOT NULL,
  `cantidad` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_ingrediente`
--

INSERT INTO `producto_ingrediente` (`producto`, `ingrediente`, `cantidad`) VALUES
(1, 1, 1),
(1, 7, 3),
(4, 2, 1),
(6, 2, 1),
(6, 4, 1),
(6, 6, 1),
(7, 2, 1),
(7, 5, 1),
(7, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(2) NOT NULL,
  `rol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(0, 'root'),
(1, 'user'),
(2, 'anon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(10) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `correo` varchar(25) NOT NULL,
  `telefono` int(9) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `contraseña` varchar(120) NOT NULL,
  `ficheros` varchar(30) DEFAULT NULL,
  `rol` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`codigo`, `nombre`, `correo`, `telefono`, `direccion`, `contraseña`, `ficheros`, `rol`) VALUES
(27, 'franzabaleta', 'franza@gmail.com', 345345, '123', '$2y$10$aGjpCsaggWW0qh9TtPQJ6OXLqPctpe8QFm1fIKRaUIxhg29rydU5G', '../usuarios/franzabaleta/', 0),
(28, '321', '123@gmail.com', 98712, '123123123', '$2y$10$8QZjTpzaDm6zWXyFMMY0t.1RBK6MjFYBgc0aYyGMPFU81kUOrmSMy', '/usuarios/321/', 1),
(32, '1', '1@1.com', 1, '1', '$2y$10$EOBDgoB5kp29Khr1cZutYeTqtFSG.rOxhv61kL8bG3oOyM1kQK65W', '../../../usuarios/1@1.com/', 1),
(33, '1', '2@2.com', 1, '1', '$2y$10$BfI8Pavng07bxpeB76IjgOOpYJPyZgzoKNJGiEE23tJKP9Keu2/Ke', '../../../usuarios/2@2.com/', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`usuario`,`producto`),
  ADD KEY `cod` (`codigo`),
  ADD KEY `fk_carrito_producto` (`producto`);

--
-- Indices de la tabla `encargo`
--
ALTER TABLE `encargo`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_encargo_producto` (`producto`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `fk_usuario_log` (`usuario`);

--
-- Indices de la tabla `mods`
--
ALTER TABLE `mods`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `fk_usuario_mod` (`usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `producto_ingrediente`
--
ALTER TABLE `producto_ingrediente`
  ADD PRIMARY KEY (`producto`,`ingrediente`),
  ADD KEY `fk_ingrediente_producto` (`ingrediente`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `codigo` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `codigo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `numero` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `mods`
--
ALTER TABLE `mods`
  MODIFY `numero` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codigo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_carrito_producto` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo`),
  ADD CONSTRAINT `fk_carrito_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`);

--
-- Filtros para la tabla `encargo`
--
ALTER TABLE `encargo`
  ADD CONSTRAINT `fk_encargo_producto` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo`);

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_usuario_log` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mods`
--
ALTER TABLE `mods`
  ADD CONSTRAINT `fk_usuario_mod` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_ingrediente`
--
ALTER TABLE `producto_ingrediente`
  ADD CONSTRAINT `fk_ingrediente_producto` FOREIGN KEY (`ingrediente`) REFERENCES `ingrediente` (`codigo`),
  ADD CONSTRAINT `fk_producto_producto` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
