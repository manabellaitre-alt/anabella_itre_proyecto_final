-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2026 a las 01:38:51
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
-- Base de datos: `fitzone`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Identificador unico del usuario',
  `nombre` varchar(80) NOT NULL COMMENT 'Nombre',
  `apellido` varchar(80) NOT NULL COMMENT 'Apellido',
  `dni` varchar(20) NOT NULL COMMENT 'Documento de identidad (unico)',
  `email` varchar(254) NOT NULL COMMENT 'Correo electronico (unico)',
  `password_hash` varchar(255) NOT NULL COMMENT 'Contrasena cifrada con password_hash()',
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario' COMMENT 'Rol de acceso',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de creacion de la cuenta',
  `archivado_en` datetime DEFAULT NULL COMMENT 'Fecha de archivado (NULL = cuenta activa)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Usuarios del sistema FitZone';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `dni`, `email`, `password_hash`, `rol`, `creado_en`, `archivado_en`) VALUES
(1, 'anabella', 'itre', '52027482', 'manabellaitre@gmail.com', '$2y$10$MEjf4kilrn25M51hztPId.SjLh9lmDOh73TTnfjCQZFSoXHjZC0TS', 'usuario', '2026-11-08 22:45:59', NULL),
(2, 'Maria', 'Itre', '50777333', 'anabellaitre@gmail.com', '$2y$10$ezu8CB/p32PjBB7pn7mz3O2pxI40s5NXqHvZWHLqy0WFUxvm3gkxy', 'admin', '2026-11-08 22:48:15', NULL),
(3, 'bella', 'Itre', '50222111', 'annnnabellaitre@gmail.com', '$2y$10$p20m1WmzIcGLyN5OErsTDOG6isBPbAgU4K6sk7h60LKWz24D/wTX6', 'usuario', '2026-11-08 23:05:39', '2026-11-11 20:35:38'),
(4, 'Tomas', 'Gamarra', '45784207', 'tomastomas@gmail.com', '$2y$10$bW0qaUQhiRLrkW7HaH859uyWtDZ.FBfws.81ZzhNVjOGD.V2wZ3ci', 'usuario', '2026-11-11 23:32:32', '2026-11-11 20:35:35');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico del usuario', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
