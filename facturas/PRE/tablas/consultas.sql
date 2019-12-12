-- create table busquedas(
-- 	id int not null primary key AUTO_INCREMENT,
-- 	idk varchar (35) not null  default '-sin-clave-',
-- 	nombre VARCHAR(255) not null,
-- 	consulta TEXT not null,
-- 	bbdd varchar(255) not null default '',
-- 	alta datetime null,
-- 	ultimo timestamp null default CURRENT_TIMESTAMP,
-- 	errores int not null default 0,
-- 	funciona int not null default 0
-- );



-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:8889
-- Tiempo de generación: 17-01-2018 a las 20:06:20
-- Versión del servidor: 5.5.42
-- Versión de PHP: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `facturas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `busquedas`
--

CREATE TABLE `busquedas` (
  `id` int(11) NOT NULL,
  `idk` varchar(35) NOT NULL DEFAULT '-sin-clave-',
  `nombre` varchar(255) NOT NULL,
  `consulta` text NOT NULL,
  `bbdd` varchar(255) NOT NULL DEFAULT '',
  `alta` datetime DEFAULT NULL,
  `ultimo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `errores` int(11) NOT NULL DEFAULT '0',
  `funciona` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `busquedas`
--
ALTER TABLE `busquedas`
  ADD UNIQUE KEY `idk` (`idk`),
  ADD UNIQUE KEY `consulta` (`consulta`(255));
