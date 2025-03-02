-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2024 a las 21:07:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `juanchos_lab`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_edit` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(6, 'Proteinas', 1, '2024-06-03 03:42:23', '2024-06-03 05:55:24'),
(7, 'Creatinas', 1, '2024-05-02 21:20:57', '2024-05-02 21:20:57'),
(9, 'Pre Entreno', 1, '2024-06-05 07:45:44', '2024-06-05 07:45:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `tipo_consulta` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `resuelto` tinyint(4) NOT NULL DEFAULT 0,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_edit` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id`, `nombre`, `email`, `tipo_consulta`, `mensaje`, `resuelto`, `fecha_alta`, `fecha_edit`) VALUES
(5, 'Juan', 'juancoronel172@gmail.com', 'Mayoristas', 'Prueba', 1, '2024-06-05 19:46:21', '2024-06-05 22:46:21'),
(6, 'Juan', 'juancoronel172@gmail.com', 'Mayoristas', 'Prueba', 1, '2024-06-05 19:43:51', '2024-06-05 22:43:51'),
(7, 'Juan', 'juancoronel172@gmail.com', 'Atención al cliente', 'Prueba', 1, '2024-06-05 19:43:53', '2024-06-05 22:43:53'),
(8, 'Juan', 'juancoronel172@gmail.com', 'Mayoristas', 'Prueba', 1, '2024-06-05 20:11:16', '2024-06-05 23:11:16'),
(9, 'Juan', 'juancoronel172@gmail.com', 'Mayoristas', 'Quiero precio', 0, '2024-06-08 03:31:28', '2024-06-08 06:31:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `id_producto`, `id_pedido`, `precio_unitario`, `cantidad`, `precio_total`) VALUES
(4, 23, 3, 35650.00, 4, 142600.00),
(5, 27, 3, 25000.00, 4, 100000.00),
(6, 23, 4, 35650.00, 3, 106950.00),
(7, 28, 4, 30000.00, 5, 150000.00),
(8, 29, 4, 45750.00, 1, 45750.00),
(11, 27, 6, 25000.00, 10, 250000.00),
(12, 28, 7, 30000.00, 3, 90000.00),
(13, 29, 8, 45750.00, 100, 4575000.00),
(14, 28, 9, 30000.00, 9, 270000.00),
(15, 27, 10, 25000.00, 1, 25000.00),
(16, 22, 11, 22500.00, 1, 22500.00),
(17, 21, 12, 38000.00, 1, 38000.00),
(18, 21, 13, 38000.00, 1, 38000.00),
(19, 21, 14, 38000.00, 12, 456000.00),
(20, 21, 15, 38000.00, 23, 874000.00),
(21, 28, 16, 30000.00, 14, 420000.00),
(22, 24, 17, 25000.00, 17, 425000.00),
(23, 22, 18, 22500.00, 10, 225000.00),
(24, 22, 19, 22500.00, 1, 22500.00),
(25, 27, 19, 25000.00, 1, 25000.00),
(26, 20, 20, 65000.00, 9, 585000.00),
(27, 29, 20, 45750.00, 10, 457500.00),
(28, 25, 20, 20000.00, 1, 20000.00),
(29, 21, 21, 38000.00, 3, 114000.00),
(30, 20, 22, 65000.00, 140, 9100000.00),
(31, 22, 22, 22500.00, 99, 2227500.00),
(32, 18, 23, 30000.00, 2, 60000.00),
(33, 28, 23, 30000.00, 2, 60000.00),
(34, 26, 24, 25000.00, 10, 250000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_edit` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(4, 'Star Nutrition', 0, '2024-04-28 18:39:54', '2024-04-28 21:39:54'),
(5, 'ENA', 1, '2024-04-30 17:51:54', '2024-04-30 20:51:54'),
(6, 'STAR NUTRITION', 1, '2024-05-14 23:24:42', '2024-05-14 23:24:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `precio_total` decimal(10,2) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `medio_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `precio_total`, `estado`, `fecha_compra`, `medio_pago`) VALUES
(3, 6, 242600.00, 'En Preparación', '2024-05-23 18:38:33', 'Efectivo'),
(4, 6, 302700.00, 'En Preparación', '2024-05-30 03:12:24', 'Efectivo'),
(6, 6, 250000.00, 'En Preparación', '2024-05-31 19:36:46', 'Mercado Pago'),
(7, 6, 90000.00, 'En Preparación', '2024-05-31 19:37:15', 'Tarjeta Débito/Credito'),
(8, 6, 4575000.00, 'En Preparación', '2024-05-31 19:38:49', 'Tarjeta Débito/Credito'),
(9, 6, 270000.00, 'En Preparación', '2024-05-31 19:39:54', 'Mercado Pago'),
(10, 10, 25000.00, 'En Preparación', '2024-06-03 03:53:02', 'Efectivo'),
(11, 8, 22500.00, 'En Preparación', '2024-06-04 15:31:39', 'Efectivo'),
(12, 6, 38000.00, 'En Preparación', '2024-06-04 21:21:13', 'Efectivo'),
(13, 6, 38000.00, 'En Preparación', '2024-06-04 21:21:27', 'Efectivo'),
(14, 6, 456000.00, 'En Preparación', '2024-06-04 21:36:32', 'Mercado Pago'),
(15, 6, 874000.00, 'En Preparación', '2024-06-05 03:05:05', 'Efectivo'),
(16, 6, 420000.00, 'En Preparación', '2024-06-05 03:51:05', 'Tarjeta Débito/Credito'),
(17, 6, 425000.00, 'En Preparación', '2024-06-05 18:23:25', 'Tarjeta Débito/Credito'),
(18, 12, 225000.00, 'En Preparación', '2024-06-05 19:04:05', 'Efectivo'),
(19, 6, 47500.00, 'En Preparación', '2024-06-06 02:48:08', 'Efectivo'),
(20, 12, 1062500.00, 'En Preparación', '2024-06-06 02:51:32', 'Tarjeta Débito/Credito'),
(21, 12, 114000.00, 'En Preparación', '2024-06-06 02:54:10', 'Efectivo'),
(22, 10, 11327500.00, 'En Preparación', '2024-06-08 01:58:03', 'Mercado Pago'),
(23, 13, 120000.00, 'En Preparación', '2024-06-08 03:23:14', 'Mercado Pago'),
(24, 8, 250000.00, 'En Preparación', '2024-06-08 03:33:08', 'Efectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `contenido` int(10) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1,
  `imagen` varchar(255) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_edit` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio_venta`, `precio_compra`, `stock`, `contenido`, `id_categoria`, `id_unidad`, `id_marca`, `activo`, `imagen`, `fecha_alta`, `fecha_edit`) VALUES
(18, 'Proteina', 30000.00, 20000.00, 298, 2, 6, 15, 6, 1, '1714496123_d9b72452e798e3f7bfe3.webp', '2024-06-08 03:28:21', '2024-06-08 06:28:21'),
(19, 'Proteina Whey', 45000.00, 2332.00, 0, 22, 6, 15, 5, 0, '1714498773_092403f5f9c39d3cbb06.png', '2024-05-21 20:42:22', '2024-05-21 23:42:22'),
(20, 'Proteina Juan', 65000.00, 20000.00, 0, 2, 6, 15, 5, 1, '1714510837_00b852bc3f15a5441f68.webp', '2024-06-08 01:58:03', '2024-06-08 04:58:03'),
(21, 'Proteina Naranja', 38000.00, 20000.00, 60, 10, 6, 15, 5, 1, '1715796984_17bc5966c2500d6ca099.png', '2024-06-06 02:54:10', '2024-06-06 05:54:10'),
(22, 'Proteina Colageno', 22500.00, 20000.00, 889, 2, 6, 16, 5, 1, '1714673891_5a1f062ff9540c6ecf16.png', '2024-06-08 01:58:03', '2024-06-08 04:58:03'),
(23, 'Proteina Chocolate', 35650.00, 20000.00, 689, 2, 6, 15, 5, 1, '1714595482_3162fafecf72d40bc8a5.png', '2024-06-04 14:01:53', '2024-06-04 17:01:53'),
(24, 'Proteina Naranja', 25000.00, 20000.00, 19983, 2, 6, 16, 5, 1, '1714658077_26f40acbcdb1e12f52f7.webp', '2024-06-05 18:23:25', '2024-06-05 21:23:25'),
(25, 'Proteina Juancho', 20000.00, 32332.00, 1000, 2, 6, 16, 5, 1, '1714667694_345df2fe89a406eee58b.webp', '2024-06-06 02:55:34', '2024-06-06 05:55:34'),
(26, 'Creatina Micronizada', 25000.00, 20000.00, 90, 300, 6, 17, 5, 1, '1714674223_aac55637529cb5ffee99.webp', '2024-06-08 03:33:08', '2024-06-08 06:33:08'),
(27, 'Proteina Juan', 25000.00, 20000.00, 67, 2, 7, 16, 5, 1, '1717184671_af5b0c6dc285d810ca27.webp', '2024-06-06 02:48:08', '2024-06-06 05:48:08'),
(28, 'Creatina Micronizada', 30000.00, 20000.00, 967, 300, 9, 17, 5, 1, '1715719362_142ea23c777b9695b2f1.webp', '2024-06-08 03:23:14', '2024-06-08 06:23:14'),
(29, 'Proteina taller', 45750.00, 20000.00, 889, 300, 7, 17, 5, 1, '1715796692_162fe85c4818153c2043.webp', '2024-06-06 02:51:32', '2024-06-06 05:51:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nombre_corto` varchar(10) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_edit` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `nombre_corto`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(14, 'Libraa', 'Lb', 0, '2024-04-28 18:32:09', '2024-04-28 21:32:09'),
(15, 'Kilo', 'Kg', 1, '2024-04-28 18:49:35', '2024-04-28 21:49:35'),
(16, 'Libra', 'Lb', 1, '2024-05-01 22:14:50', '2024-05-01 22:14:50'),
(17, 'Gramo', 'Grs', 1, '2024-05-02 21:21:44', '2024-05-02 21:21:44'),
(18, 'Pounds', 'Lb', 0, '2024-05-31 19:10:07', '2024-05-31 22:10:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contraseña` varchar(200) NOT NULL,
  `esAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `carrito` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_edit` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contraseña`, `esAdmin`, `carrito`, `fecha_alta`, `fecha_edit`) VALUES
(6, 'Pedro Ramirez', 'juancho@gmail.com', '$2y$10$K82d2LyuMJqrch94H/GbXOruox4wWQj1EtgfJ.jOJtPvy9Xrqzm.e', 0, '[]', '2024-04-26 18:56:13', NULL),
(7, 'Juan Coronel', 'juancoronel1725@gmail.com', '$2y$10$s6jtaXhX45FTEFINb2NcHOxnZHy7FOTQFbi7xbW2zwjx4/aaNA0L2', 1, '[]', '2024-04-26 19:31:23', NULL),
(8, 'Pedro Flores', 'pedro@gmail.com', '$2y$10$MA3uDS8Os.1PwQJkz2y9FeeLudkXaqxmDyul.ig1NGPQdC/tWRFFW', 1, '[]', '2024-04-27 16:54:26', NULL),
(9, 'Pedro Contreras', 'pedro2@gmail.com', '$2y$10$5ycGW0odltlQlQ2PaMBfie32kmjDRjbIgswLHJuJSxcWDkIhyez16', 1, '', '2024-04-27 16:54:57', NULL),
(10, 'Juan Coronel', 'admin@gmail.com', '$2y$10$/sxsmSvgiJkYUo4kvGL0leHbCXxpeFFhneGP5K2xzSgrFnCLdZWOm', 1, '[]', '2024-04-30 21:17:42', NULL),
(12, 'pedro gonzalez ', 'pablo@gmail.com', '$2y$10$R1EtQKsOt8xRCz9Hf1U7PeXmaQqC2VNXrKlUGNBGMieeuIRnsnXRu', 0, '[]', '2024-06-04 16:01:28', NULL),
(13, 'Magali figueroa', 'magafigueroa608@gmail.com', '$2y$10$Sf9wpctN29WbFpkV82r2tOwBATw9SPB4qKzllv6Iw7Lgsj8Tx9AgS', 0, '[]', '2024-06-08 03:21:03', NULL),
(14, 'Profe  Zalazar', 'profe@gmail.com', '$2y$10$RrUM67PqnBvdb.YTSfBznuZxaCHxM8MAJcbRoLy3s9sP5Z2DzU6ca', 0, '', '2024-06-13 19:06:03', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_producto` (`id_producto`),
  ADD KEY `fk_detalle_pedido` (`id_pedido`) USING BTREE;

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedidos_usuarios` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_unidad` (`id_unidad`),
  ADD KEY `fk_producto_categoria` (`id_categoria`),
  ADD KEY `fk_producto_marca` (`id_marca`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `fk_detalle_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `fk_producto_marca` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`),
  ADD CONSTRAINT `fk_producto_unidad` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
