-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2024 a las 09:24:18
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
-- Base de datos: `boutique`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL CHECK (`cantidad` > 0),
  `subtotal` decimal(10,2) NOT NULL CHECK (`subtotal` >= 0),
  `fecha_agregado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_reservacion`
--

CREATE TABLE `detalle_reservacion` (
  `id_detalle` int(11) NOT NULL,
  `id_reservacion` int(11) NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL CHECK (`cantidad` > 0),
  `subtotal` decimal(10,2) NOT NULL CHECK (`subtotal` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id_habitacion` int(11) NOT NULL,
  `tipo` enum('Sencilla','Doble','Deluxe','Ejecutiva','Presidencial') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `capacidad` int(11) NOT NULL CHECK (`capacidad` > 0),
  `precio` decimal(10,2) NOT NULL CHECK (`precio` >= 0),
  `disponibles` int(11) NOT NULL CHECK (`disponibles` >= 0),
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`id_habitacion`, `tipo`, `descripcion`, `capacidad`, `precio`, `disponibles`, `imagen`) VALUES
(1, 'Sencilla', 'Una habitacion sencilla con una cama, un baño y servicio a la habitación.', 1, 500.00, 5, 'Sencilla.webp'),
(2, 'Doble', 'Como la sencilla pero con el doble de risas...\r\nAdmitelo, estas solo no necesitas la doble a menos de que te sobre el dinero...', 2, 1000.00, 4, 'Doble.webp'),
(3, 'Deluxe', 'La nueva hiper requete contra omega ninja super deluxe edition of the year del año 2024 habitacion, es la habitacion de tus sueños, lleva la comodidad a otro nivel con la cama ultra suave de plumas de dodo y caviar bajo la almohada. \r\n', 2, 10000.00, 3, 'Deluxe.webp'),
(5, 'Ejecutiva', 'Habitación Ejecutiva para los hombres de negocio que necesitan una escapada de la sociedad y una excusa para gastar dinero.', 2, 50000.00, 2, 'img_674963b06e3ee.webp'),
(6, 'Presidencial', 'Buenas tardes señora presidenta, el dia de hoy le ofresco esta humilde habitación ya hay que ser austeros, pero no por eso, esta habitación cuenta con lo ulitmo de lo ultimo en autos, moda y rock and roll', 1, 99999999.99, 1, 'img_674963193cc1b.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `id_reservacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_reservacion` datetime DEFAULT current_timestamp(),
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `estado` enum('Pendiente','Confirmada','Cancelada') DEFAULT 'Pendiente',
  `total` decimal(10,2) NOT NULL CHECK (`total` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id_sesion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_inicio` datetime DEFAULT current_timestamp(),
  `fecha_cierre` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE usuarios (
  id_usuario int(11) NOT NULL,
  nombre_usuario varchar(50) NOT NULL,
  contrasena varchar(255) NOT NULL,
  tipo_usuario enum('Administrador','Huesped') NOT NULL,
  email varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla usuarios
--

INSERT INTO usuarios (id_usuario, nombre_usuario, contrasena, tipo_usuario, email) VALUES
(3, 'russ', '$2y$10$bfZHTQlBn33anzjO/tLriOCjnOtBPYWVz7mcm0hVG9vlkG8fLjYJm', 'Huesped', 'russ@gmail.com'),
(4, 'admin', '$2y$10$hkGcKIKzpSTsrfvSrICcNeBH9mq1gYYISCisFEI91TQunwy3OUHHO', 'Administrador', 'admin@example.com'),
(5, 'user', '$2y$10$lTp9gthalL/Nwa.25tC5Z.McAc4J7GlWcBiSsjidneJqxJdmSsEei', 'Huesped', 'user@example.com');
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD UNIQUE KEY `uniq_carrito_usuario_habitacion` (`id_usuario`,`id_habitacion`),
  ADD KEY `id_habitacion` (`id_habitacion`);

--
-- Indices de la tabla `detalle_reservacion`
--
ALTER TABLE `detalle_reservacion`
  ADD PRIMARY KEY (`id_detalle`),
  ADD UNIQUE KEY `uniq_reservacion_habitacion` (`id_reservacion`,`id_habitacion`),
  ADD KEY `id_habitacion` (`id_habitacion`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id_habitacion`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`id_reservacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id_sesion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `fecha_inicio` (`fecha_inicio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_reservacion`
--
ALTER TABLE `detalle_reservacion`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `id_reservacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `id_sesion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id_habitacion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_reservacion`
--
ALTER TABLE `detalle_reservacion`
  ADD CONSTRAINT `detalle_reservacion_ibfk_1` FOREIGN KEY (`id_reservacion`) REFERENCES `reservaciones` (`id_reservacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_reservacion_ibfk_2` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id_habitacion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD CONSTRAINT `reservaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
