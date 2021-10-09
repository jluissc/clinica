-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-10-2021 a las 23:34:31
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clinica_db6`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_detalle`
--

CREATE TABLE `cita_detalle` (
  `id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `recetas` text DEFAULT NULL,
  `prohibicion` text DEFAULT NULL,
  `otros` varchar(45) DEFAULT NULL,
  `citas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_pagos`
--

CREATE TABLE `cita_pagos` (
  `id` int(11) NOT NULL,
  `detalles` varchar(100) NOT NULL,
  `nmr_transaccion` varchar(45) DEFAULT NULL,
  `medio_pago` varchar(45) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `total` decimal(6,2) DEFAULT NULL,
  `estado` int(2) DEFAULT NULL,
  `citas_id` int(11) NOT NULL,
  `tipo_pago_id1` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cita_pagos`
--

INSERT INTO `cita_pagos` (`id`, `detalles`, `nmr_transaccion`, `medio_pago`, `fecha`, `total`, `estado`, `citas_id`, `tipo_pago_id1`) VALUES
(1, 'ggg', '09298234 238424 23842', 'INTERBANK', '2021-10-06 14:59:19', '50.00', 1, 13, 2),
(2, 'd adas', '011154201215', 'BCP', '2021-10-07 03:41:03', '80.00', 1, 20, 1),
(3, 'pago directo', 'xxxxxxx', 'Pago directo', '2021-10-07 03:50:18', '80.00', 1, 28, 3),
(4, '154523', NULL, 'BBVA', '2021-10-07 09:03:11', '80.00', 1, 15, 2),
(5, '1020353', NULL, 'INTERBANK', '2021-10-07 09:26:34', '50.00', 1, 29, 2),
(6, 'PAGO DIRECTO', NULL, 'FISICO', '2021-10-07 09:59:13', '80.00', 1, 33, 3),
(7, 'PAGO DIRECTO', NULL, 'FISICO', '2021-10-07 10:11:45', '80.00', 1, 27, 3),
(8, 'PAGO DIRECTO', NULL, 'FISICO', '2021-10-07 10:12:58', '80.00', 1, 31, 3),
(9, 'PAGO DIRECTO', NULL, 'FISICO', '2021-10-07 13:22:18', '80.00', 1, 8, 3),
(10, '154856', NULL, 'BCP', '2021-10-07 13:23:02', '50.00', 0, 30, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `id` int(1) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `horaInicio` time NOT NULL,
  `horaFin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`id`, `codigo`, `nombre`, `horaInicio`, `horaFin`) VALUES
(13, '35094', 'Tardes, Lun, Mierc, Sab', '08:00:00', '19:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias`
--

CREATE TABLE `dias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dias`
--

INSERT INTO `dias` (`id`, `nombre`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miercoles'),
(4, 'Jueves'),
(5, 'Viernes'),
(6, 'Sábado'),
(7, 'Domingo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias_hora_atencion`
--

CREATE TABLE `dias_hora_atencion` (
  `id` int(11) NOT NULL,
  `dias_id` int(11) NOT NULL,
  `tipo_cita_id` int(11) NOT NULL,
  `config_id` int(11) NOT NULL,
  `horainicio` time DEFAULT NULL,
  `horafin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dias_hora_atencion`
--

INSERT INTO `dias_hora_atencion` (`id`, `dias_id`, `tipo_cita_id`, `config_id`, `horainicio`, `horafin`) VALUES
(36, 1, 1, 13, '08:00:00', '19:00:00'),
(37, 1, 2, 13, '08:00:00', '19:00:00'),
(38, 3, 1, 13, '08:00:00', '19:00:00'),
(39, 3, 2, 13, '08:00:00', '19:00:00'),
(40, 6, 1, 13, '08:00:00', '19:00:00'),
(41, 6, 2, 13, '08:00:00', '19:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `materiales_id` int(11) NOT NULL,
  `precio` decimal(11,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `persona_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `persona_id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `termino` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `code`, `persona_id`, `nombre`, `termino`) VALUES
(1, '2164', 43, 'PIESITO', 0),
(2, '5191', 2, 'COLUMNA', 0),
(4, '5194', 44, 'Hombir', 0),
(5, '1425', 45, 'VElita', 0),
(6, '4305', 38, 'Manitoo', 0),
(7, '9453', 46, 'Primer Cons', 0),
(8, '6993', 36, 'SOLSITO', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_detalle`
--

CREATE TABLE `historial_detalle` (
  `id` int(11) NOT NULL,
  `historial_id` int(11) NOT NULL,
  `tratamientos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historial_detalle`
--

INSERT INTO `historial_detalle` (`id`, `historial_id`, `tratamientos_id`) VALUES
(1, 1, 14),
(2, 2, 15),
(5, 4, 20),
(12, 5, 27),
(13, 2, 28),
(14, 2, 29),
(15, 2, 30),
(16, 6, 31),
(17, 6, 32),
(18, 7, 33),
(19, 6, 34),
(20, 6, 35),
(21, 6, 36),
(22, 6, 37),
(23, 8, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas`
--

CREATE TABLE `horas` (
  `id` int(11) NOT NULL,
  `hora` time DEFAULT NULL,
  `estado` int(1) NOT NULL,
  `servicios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horas`
--

INSERT INTO `horas` (`id`, `hora`, `estado`, `servicios_id`) VALUES
(60, '08:00:00', 1, 17),
(61, '08:30:00', 1, 17),
(62, '09:00:00', 1, 17),
(63, '09:30:00', 1, 17),
(64, '10:00:00', 1, 17),
(65, '10:30:00', 1, 17),
(66, '11:00:00', 1, 17),
(67, '11:30:00', 1, 17),
(68, '12:00:00', 1, 17),
(69, '15:00:00', 1, 17),
(70, '15:30:00', 1, 17),
(71, '16:00:00', 1, 17),
(72, '16:30:00', 1, 17),
(73, '17:00:00', 1, 17),
(74, '08:00:00', 1, 18),
(75, '09:00:00', 1, 18),
(76, '10:00:00', 1, 18),
(77, '11:00:00', 1, 18),
(78, '12:00:00', 1, 18),
(79, '15:00:00', 1, 18),
(80, '16:00:00', 1, 18),
(81, '17:00:00', 1, 18),
(82, '18:00:00', 1, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(45) DEFAULT NULL,
  `servicios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(95) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `id` int(11) NOT NULL,
  `experiencia` varchar(45) DEFAULT NULL,
  `especialidad` varchar(45) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`) VALUES
(1, 'PAGOS'),
(2, 'GASTOS'),
(3, 'CITAS'),
(4, 'SERVICIOS'),
(5, 'MATERIALES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_user`
--

CREATE TABLE `permisos_user` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `permisos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permisos_user`
--

INSERT INTO `permisos_user` (`id`, `persona_id`, `permisos_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(60, 33, 3),
(61, 33, 1),
(62, 40, 2),
(63, 40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `dni` int(8) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `correo` varchar(25) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `tipo_user_id` int(11) NOT NULL,
  `estado` int(1) NOT NULL,
  `logueo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `nombre`, `apellidos`, `dni`, `celular`, `correo`, `direccion`, `foto`, `user`, `password`, `tipo_user_id`, `estado`, `logueo`) VALUES
(1, 'DR.', 'Alcantara', 12345678, '991509111', 'jlsc.hco96@gmail.com', 'Jr. Pucallpa 187 ', 'abc.png', 'admin', 'eTc1MmRqY3NZYUtxR2pMWnRFczdPQT09', 1, 1, 1),
(2, 'JOSE LUIS', 'SOTO CHAHUA', 60691536, '991509111', 'sdfsfs', 'fsfss', 'sfsfsd', '60691536', 'eTc1MmRqY3NZYUtxR2pMWnRFczdPQT09', 4, 1, 1),
(33, 'CRISTIAN', 'PEÑA DORIA', 77816565, '991509111', '', NULL, NULL, '77816565', '77816565', 2, 1, 0),
(36, 'SHEYLA SOLEDAD', 'RAMON VALDIVIA', 48540264, '947877278', '', NULL, NULL, '48540264', '48540264', 4, 1, 0),
(38, 'Noemi', 'Chahua', 22510467, '917895325', '', NULL, NULL, '22510467', '22510467', 4, 1, 0),
(39, 'JOHANES', 'SALVADOR', 22499941, '923424284', '', NULL, NULL, '22499941', '22499941', 4, 1, 0),
(40, 'HENRI IVAN', 'JAMANCA QUIÑONES', 45785692, '991509111', '', NULL, NULL, '45785692', '45785692', 2, 1, 0),
(41, 'ISABEL', 'LOPEZ SULLANI', 45789658, '978456321', '', NULL, NULL, '45789658', '45789658', 4, 1, 0),
(43, 'MARGARITA DONATA', 'HUERTA CHILLCA', 46798531, '978456321', '', NULL, NULL, '46798531', '46798531', 4, 1, 0),
(44, 'PEPELUcho', 'ROJAS Montero', 26485695, '92482384', '', NULL, NULL, '26485695', '26485695', 4, 1, 0),
(45, 'ELEIB ELISEO', 'VELA LASTRA', 71945378, '991509111', '22510467', NULL, NULL, '71945378', '71945378', 4, 1, 0),
(46, 'Luigui', 'Arevalo Monterios', 78604859, '923567846', '', NULL, NULL, '78604859', '78604859', 4, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`id`, `nombre`, `email`, `telefono`, `direccion`, `logo`) VALUES
(1, 'RHABILITACION', 'RH@GMAIL.COM', '934563454', 'Jr Naranjas 182', 'RH');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_normal` decimal(6,2) DEFAULT NULL,
  `precio_venta` decimal(6,2) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `tiempo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `precio_normal`, `precio_venta`, `estado`, `tiempo`) VALUES
(17, 'CONSULTAS', 'Para revisar el estado de tu salud y otras cosas mas...', '100.00', '80.00', 1, 30),
(18, 'TERAPIA FISICA ', '', '80.00', '50.00', 1, 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_tipo`
--

CREATE TABLE `servicios_tipo` (
  `id` int(11) NOT NULL,
  `servicios_id` int(11) NOT NULL,
  `tipo_cita_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicios_tipo`
--

INSERT INTO `servicios_tipo` (`id`, `servicios_id`, `tipo_cita_id`) VALUES
(20, 17, 1),
(21, 17, 2),
(22, 18, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `id` int(11) NOT NULL,
  `testimonio` text DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cita`
--

CREATE TABLE `tipo_cita` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `precio` varchar(45) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_cita`
--

INSERT INTO `tipo_cita` (`id`, `nombre`, `precio`, `estado`) VALUES
(1, 'ONLINE', '0', 1),
(2, 'PRESENCIAL', '0', 1),
(3, 'DOMICILIO', '15', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `id` int(1) NOT NULL,
  `tipo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`id`, `tipo`) VALUES
(1, 'PAGO TARJETA'),
(2, 'TRANSFERENCIA'),
(3, 'PAGO DIRECTO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_user`
--

CREATE TABLE `tipo_user` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_user`
--

INSERT INTO `tipo_user` (`id`, `nombre`) VALUES
(1, 'ADMINn'),
(2, 'CAJERO'),
(3, 'MEDICO'),
(4, 'PACIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `tiempo` int(2) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `atentido` int(1) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `horas_id` int(11) NOT NULL,
  `servicios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tratamientos`
--

INSERT INTO `tratamientos` (`id`, `fecha`, `tiempo`, `mensaje`, `estado`, `atentido`, `paciente_id`, `horas_id`, `servicios_id`) VALUES
(8, '2021-10-04', 30, '', 1, 1, 39, 72, 17),
(13, '2021-10-04', 30, '', 1, 1, 41, 69, 17),
(14, '2021-10-04', 30, '', 1, 1, 43, 69, 17),
(15, '2021-10-04', 30, '', 1, 1, 2, 70, 17),
(20, '2021-10-04', 30, '', 1, 1, 44, 71, 17),
(27, '2021-10-09', 30, '', 1, 1, 45, 70, 17),
(28, '2021-10-09', 30, '', 1, 1, 2, 82, 18),
(29, '2021-10-09', 30, '', 1, 1, 2, 81, 18),
(30, '2021-10-09', 30, '', 1, 1, 2, 80, 18),
(31, '2021-10-09', 30, '', 1, 1, 38, 73, 17),
(32, '2021-10-09', 30, '', 1, 1, 38, 79, 18),
(33, '2021-10-09', 30, '', 1, 1, 46, 72, 17),
(34, '2021-10-11', 30, '', 1, 1, 38, 82, 18),
(35, '2021-10-09', 30, '', 1, 1, 38, 78, 18),
(36, '2021-10-16', 30, '', 1, 1, 38, 82, 18),
(37, '2021-10-25', 30, '', 1, 1, 38, 79, 18),
(38, '2021-10-11', 30, '', 1, 1, 36, 73, 17);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cita_detalle`
--
ALTER TABLE `cita_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_id` (`citas_id`);

--
-- Indices de la tabla `cita_pagos`
--
ALTER TABLE `cita_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_id` (`citas_id`),
  ADD KEY `tipo_pago_id1` (`tipo_pago_id1`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dias`
--
ALTER TABLE `dias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dias_hora_atencion`
--
ALTER TABLE `dias_hora_atencion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dias_id` (`dias_id`),
  ADD KEY `tipo_cita_id` (`tipo_cita_id`),
  ADD KEY `config_id` (`config_id`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materiales_id` (`materiales_id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `historial_detalle`
--
ALTER TABLE `historial_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historial_id` (`historial_id`),
  ADD KEY `tratamientos_id` (`tratamientos_id`);

--
-- Indices de la tabla `horas`
--
ALTER TABLE `horas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicios_id` (`servicios_id`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicios_id` (`servicios_id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos_user`
--
ALTER TABLE `permisos_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`),
  ADD KEY `permisos_id` (`permisos_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD KEY `tipo_user_id` (`tipo_user_id`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios_tipo`
--
ALTER TABLE `servicios_tipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicios_id` (`servicios_id`),
  ADD KEY `tipo_cita_id` (`tipo_cita_id`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `tipo_cita`
--
ALTER TABLE `tipo_cita`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_user`
--
ALTER TABLE `tipo_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `horas_id` (`horas_id`),
  ADD KEY `servicios_id` (`servicios_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cita_detalle`
--
ALTER TABLE `cita_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cita_pagos`
--
ALTER TABLE `cita_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `dias`
--
ALTER TABLE `dias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `dias_hora_atencion`
--
ALTER TABLE `dias_hora_atencion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `historial_detalle`
--
ALTER TABLE `historial_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `horas`
--
ALTER TABLE `horas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `permisos_user`
--
ALTER TABLE `permisos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `servicios_tipo`
--
ALTER TABLE `servicios_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_cita`
--
ALTER TABLE `tipo_cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_user`
--
ALTER TABLE `tipo_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita_detalle`
--
ALTER TABLE `cita_detalle`
  ADD CONSTRAINT `cita_detalle_ibfk_1` FOREIGN KEY (`citas_id`) REFERENCES `tratamientos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita_pagos`
--
ALTER TABLE `cita_pagos`
  ADD CONSTRAINT `cita_pagos_ibfk_1` FOREIGN KEY (`citas_id`) REFERENCES `tratamientos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cita_pagos_ibfk_2` FOREIGN KEY (`tipo_pago_id1`) REFERENCES `tipo_pago` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dias_hora_atencion`
--
ALTER TABLE `dias_hora_atencion`
  ADD CONSTRAINT `dias_hora_atencion_ibfk_1` FOREIGN KEY (`dias_id`) REFERENCES `dias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `dias_hora_atencion_ibfk_2` FOREIGN KEY (`tipo_cita_id`) REFERENCES `tipo_cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `dias_hora_atencion_ibfk_3` FOREIGN KEY (`config_id`) REFERENCES `config` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`materiales_id`) REFERENCES `materiales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `gastos_ibfk_2` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial_detalle`
--
ALTER TABLE `historial_detalle`
  ADD CONSTRAINT `historial_detalle_ibfk_1` FOREIGN KEY (`historial_id`) REFERENCES `historial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `historial_detalle_ibfk_2` FOREIGN KEY (`tratamientos_id`) REFERENCES `tratamientos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `horas`
--
ALTER TABLE `horas`
  ADD CONSTRAINT `horas_ibfk_1` FOREIGN KEY (`servicios_id`) REFERENCES `servicios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`servicios_id`) REFERENCES `servicios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`empresa_id`) REFERENCES `sede` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permisos_user`
--
ALTER TABLE `permisos_user`
  ADD CONSTRAINT `permisos_user_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `permisos_user_ibfk_2` FOREIGN KEY (`permisos_id`) REFERENCES `permisos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`tipo_user_id`) REFERENCES `tipo_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `servicios_tipo`
--
ALTER TABLE `servicios_tipo`
  ADD CONSTRAINT `servicios_tipo_ibfk_1` FOREIGN KEY (`servicios_id`) REFERENCES `servicios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `servicios_tipo_ibfk_2` FOREIGN KEY (`tipo_cita_id`) REFERENCES `tipo_cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `testimonio_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tratamientos_ibfk_2` FOREIGN KEY (`horas_id`) REFERENCES `horas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tratamientos_ibfk_3` FOREIGN KEY (`servicios_id`) REFERENCES `servicios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
