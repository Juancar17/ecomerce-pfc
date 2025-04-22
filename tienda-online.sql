-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-04-2025 a las 20:40:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda-online`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` enum('pendiente','enviado','completado','cancelado') NOT NULL DEFAULT 'pendiente',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `direccion_envio` varchar(255) NOT NULL,
  `pais_envio` varchar(100) NOT NULL,
  `telefono_envio` varchar(20) NOT NULL,
  `ciudad_envio` varchar(100) NOT NULL,
  `codigo_postal_envio` varchar(10) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria_id`, `fecha_agregado`, `stock`) VALUES
(1, 'Camiseta Básica Blanca', 'Camiseta de algodón 100% suave y cómoda. Disponible en todas las tallas.', 12.99, 'camiseta.jpg', NULL, '2025-04-21 18:15:15', 0),
(2, 'Pantalón Vaquero', 'Pantalón vaquero azul clásico de corte recto.', 34.99, 'camiseta.jpg', NULL, '2025-04-21 18:15:15', 0),
(3, 'Sudadera con Capucha', 'Sudadera gris con capucha y bolsillo frontal. Perfecta para el invierno.', 29.99, 'camiseta.jpg', NULL, '2025-04-21 18:15:15', 0),
(4, 'Chaqueta de Cuero', 'Chaqueta de cuero sintético estilo motociclista, muy resistente.', 89.99, 'camiseta.jpg', NULL, '2025-04-21 18:15:15', 0),
(5, 'Vestido de Verano', 'Vestido ligero con estampado floral, ideal para los días soleados.', 24.99, 'camiseta.jpg', NULL, '2025-04-21 18:15:15', 0),
(6, 'Zapatillas Deportivas', 'Zapatillas cómodas y ligeras para el día a día o hacer deporte.', 45.50, 'camiseta.jpg', NULL, '2025-04-21 18:15:15', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` blob NOT NULL,
  `rol` enum('admin','responsable','usuario') NOT NULL DEFAULT 'usuario',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `direccion` varchar(255) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `direccion_adicional` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `rol`, `fecha_registro`, `estado`, `direccion`, `pais`, `telefono`, `ciudad`, `codigo_postal`, `direccion_adicional`) VALUES
(1, 'Administrador', 'admin@admin.com', 0x630b49d705a15b1ca4b0913dceb8b19f, 'admin', '2025-04-21 18:11:18', 'activo', '', '', '', '', '', NULL),
(2, 'Juan Pedro', 'pepe@gmail.com', 0x97cf5cb8b4bc2660b5cff12739757c9e, 'usuario', '2025-04-21 18:14:18', 'activo', 'Plaza Castilla La Mancha 7', 'España', '601348253', 'Rivas-Vaciamadrid', '28523', NULL),
(3, 'Responsable', 'responsable@responsable.com', 0xb19eace61909e35db98bee76acc99f00, 'responsable', '2025-04-21 18:22:07', 'activo', 'Calle Ejemplo 456', 'España', '+34 600 123 456', '', '', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
