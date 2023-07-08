-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2023 a las 04:35:08
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tickets_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `usuario` text NOT NULL,
  `estado` text NOT NULL,
  `fecha_actualizacion` datetime NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id`, `usuario`, `estado`, `fecha_actualizacion`, `fecha_creacion`) VALUES
(1, 'Anjellin Morales Panesso', 'abierto', '2023-07-08 00:53:49', '2023-07-07 22:55:05'),
(2, 'Monica Cecilia Toro Toro', 'abierto', '2023-07-08 00:53:49', '2023-07-07 22:55:05'),
(3, 'Juan Sebastian Medina Toro', 'abierto', '2023-07-08 00:53:49', '2023-07-07 22:55:05'),
(4, 'Emilia Cano Benavides', 'abierto', '2023-07-08 01:22:19', '2023-07-07 23:24:15'),
(5, 'Doralba Muñoz Cano', 'cerrado', '2023-07-08 01:22:19', '2023-07-07 23:24:15'),
(6, 'Fabio de Jesus Medina Henao', 'abierto', '2023-07-08 01:22:19', '2023-07-07 23:24:15'),
(7, 'Luis Alfonso Gallego Bran', 'cerrado', '2023-07-08 01:22:19', '2023-07-07 23:24:15'),
(8, 'Gabriela Marin Otalvaro', 'cerrado', '2023-07-08 01:22:19', '2023-07-07 23:24:15'),
(9, 'Ermenegilda Faustina Rodriguez', 'abierto', '2023-07-08 01:22:19', '2023-07-07 23:24:15'),
(11, 'Viviana Gallego Torres', 'abierto', '0000-00-00 00:00:00', '2023-07-08 00:51:38'),
(13, 'Federico Villa Valderrama', 'cerrado', '0000-00-00 00:00:00', '2023-07-08 00:58:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
