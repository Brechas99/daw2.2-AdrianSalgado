-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-11-2020 a las 13:31:49
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `wikifutbol`
--
CREATE DATABASE IF NOT EXISTS `wikifutbol` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `wikifutbol`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
                                           `id` int(11) NOT NULL AUTO_INCREMENT,
                                           `pais` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `pais`) VALUES
(1, 'España'),
(2, 'Argentina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

DROP TABLE IF EXISTS `jugadores`;
CREATE TABLE IF NOT EXISTS `jugadores` (
                                         `id` int(11) NOT NULL AUTO_INCREMENT,
                                         `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                         `equipo` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                         `edad` varchar(80) DEFAULT NULL,
                                         `posicion` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                         `estrella` tinyint(1) NOT NULL DEFAULT 0,
                                         `paisId` int(11) NOT NULL,
                                         PRIMARY KEY (`id`),
                                         KEY `fk_paisIdIdx` (`paisId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `nombre`, `equipo`, `edad`,`posicion`, `estrella`, `paisId`) VALUES
(1, 'Messi', 'Barcelona', 33, 'Delantero', 1, 2);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
    ADD CONSTRAINT `fk_paisId` FOREIGN KEY (`paisId`) REFERENCES `paises` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;