-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:8889
-- Tiempo de generación: 03-01-2018 a las 23:34:15
-- Versión del servidor: 5.5.42
-- Versión de PHP: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `facturas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE IF NOT EXISTS `asignaciones` (
  `idk_contacto` varchar(35) NOT NULL,
  `idk_rol` varchar(35) NOT NULL,
  `alta` datetime NOT NULL,
  `creador_idk` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `asignaciones`
--

TRUNCATE TABLE `asignaciones`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE IF NOT EXISTS `contactos` (
  `id` int(11) NOT NULL,
  `idk` varchar(35) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(90) DEFAULT NULL,
  `doc_tipo` enum('DNI','NIE','PASAPORTE','OTRO') DEFAULT NULL,
  `doc_numero` varchar(50) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `email` varchar(90) NOT NULL,
  `notas` text NOT NULL,
  `alta` datetime NOT NULL,
  `ultimo` datetime NOT NULL,
  `activo` int(11) NOT NULL DEFAULT '0',
  `estado` set('alta','baja','suspendido','modificado','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `contactos`
--

TRUNCATE TABLE `contactos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `idk` varchar(35) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `alta` datetime NOT NULL,
  `ultimo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `roles`
--

TRUNCATE TABLE `roles`;
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD UNIQUE KEY `idk_contacto` (`idk_contacto`,`idk_rol`) USING BTREE;

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idk` (`idk`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;