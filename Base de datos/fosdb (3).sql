-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2024 a las 06:44:44
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
-- Base de datos: `fosdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `ID` int(2) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_admin`
--

INSERT INTO `tbl_admin` (`ID`, `username`, `password`) VALUES
(0, 'admin', '1234abcd..'),
(1, 'admin1', '$2y$10$.8dKdxlVSSfV1CsiPj2Xqe6Wifbre0xzIDHPoYw.n/DlI5yQm3xRu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `menuID` int(11) NOT NULL,
  `menuName` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_menu`
--

INSERT INTO `tbl_menu` (`menuID`, `menuName`) VALUES
(8, 'a la Parrilla'),
(9, 'Cocidos o al Vapor'),
(10, 'Bebidas'),
(11, 'Sopas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_menuitem`
--

CREATE TABLE `tbl_menuitem` (
  `itemID` int(11) NOT NULL,
  `menuID` int(11) NOT NULL,
  `menuItemName` text NOT NULL,
  `price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_menuitem`
--

INSERT INTO `tbl_menuitem` (`itemID`, `menuID`, `menuItemName`, `price`) VALUES
(17, 8, 'Bacalao', 15000.00),
(20, 8, 'Plato Actualizado', 15000.00),
(21, 9, 'Salmón al Vapor', 16000.00),
(22, 9, 'Cazuela de Mariscos', 17000.00),
(23, 9, 'Arroz con Camarones', 14000.00),
(24, 9, 'Pescado al Vapor con Hierbas', 15000.00),
(25, 10, 'Agua de Coco', 3000.00),
(26, 10, 'Limonada de Maracuyá', 3500.00),
(27, 11, 'Sopa de Pescado con Verduras', 12000.00),
(28, 11, 'Crema de Mariscos', 14000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mesa`
--

CREATE TABLE `tbl_mesa` (
  `mesaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_mesa`
--

INSERT INTO `tbl_mesa` (`mesaID`) VALUES
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_order`
--

CREATE TABLE `tbl_order` (
  `orderID` int(11) NOT NULL,
  `status` text NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `order_date` date NOT NULL,
  `mesaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_order`
--

INSERT INTO `tbl_order` (`orderID`, `status`, `total`, `order_date`, `mesaID`) VALUES
(5, 'cancelado', 10000.00, '2023-01-25', 0),
(6, 'listo', 15500.00, '2023-01-25', 0),
(7, 'preparando', 12000.00, '2023-12-17', 1),
(8, 'preparando', 13000.00, '2023-12-17', 1),
(9, 'preparando', 13000.00, '2023-12-17', 1),
(10, 'preparando', 48000.00, '2023-12-17', 1),
(11, 'preparando', 13000.00, '2023-12-17', 1),
(12, 'preparando', 16000.00, '2023-12-17', 1),
(13, 'listo', 60000.00, '2023-12-17', 1),
(14, 'esperando', 36000.00, '2023-12-17', 1),
(15, 'esperando', 45000.00, '2023-12-17', 1),
(16, 'cancelado', 12000.00, '2023-12-17', 8),
(17, 'cancelado', 12000.00, '2023-12-17', 9),
(18, 'cancelado', 12000.00, '2023-12-17', 5),
(19, 'cancelado', 12000.00, '2023-12-17', 4),
(20, 'cancelado', 12000.00, '2023-12-17', 7),
(21, 'cancelado', 12000.00, '2023-12-17', 4),
(22, 'cancelado', 24000.00, '2023-12-17', 6),
(23, 'cancelado', 12000.00, '2023-12-17', 3),
(24, 'cancelado', 12000.00, '2023-12-17', 4),
(25, 'cancelado', 13000.00, '2023-12-17', 7),
(26, 'listo', 24000.00, '2023-12-17', 5),
(27, 'esperando', 24000.00, '2023-12-17', 12),
(28, 'listo', 12000.00, '2023-12-17', 7),
(29, 'listo', 12000.00, '2023-12-17', 12),
(30, 'listo', 12000.00, '2023-12-18', 14),
(1001, 'esperando', 0.00, '2024-03-31', 3),
(1002, 'esperando', 0.00, '2024-03-31', 3),
(1003, 'esperando', 0.00, '2024-04-01', 3),
(1004, 'esperando', 0.00, '2024-04-01', 3),
(1008, 'esperando', 30000.00, '2024-04-01', 4),
(1009, 'esperando', 12000.00, '2024-04-01', 12),
(1010, 'listo', 3000.00, '2024-04-01', 13),
(1011, 'esperando', 21000.00, '2024-04-01', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_orderdetail`
--

CREATE TABLE `tbl_orderdetail` (
  `orderID` int(11) NOT NULL,
  `orderDetailID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `mesaID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_orderdetail`
--

INSERT INTO `tbl_orderdetail` (`orderID`, `orderDetailID`, `itemID`, `quantity`, `mesaID`) VALUES
(26, 34, 17, 2, 5),
(27, 35, 17, 2, 12),
(28, 36, 17, 1, 7),
(29, 37, 17, 1, 12),
(30, 38, 17, 1, 14),
(1008, 43, 17, 2, NULL),
(1009, 44, 27, 1, NULL),
(1010, 45, 25, 1, NULL),
(1011, 46, 17, 1, NULL),
(1011, 47, 25, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_role`
--

INSERT INTO `tbl_role` (`role`) VALUES
('Chef'),
('Mesero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `staffID` int(2) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_staff`
--

INSERT INTO `tbl_staff` (`staffID`, `username`, `password`, `status`, `role`) VALUES
(1, 'Juan', '1234abcd..', 'Online', 'mesero'),
(4, 'Pedro', '1234abcd..', 'Online', 'Chef'),
(5, 'Emily', '1234abcd..', 'Online', 'Chef'),
(6, 'Robert', '1234abcd..', 'Online', 'Chef'),
(7, 'Sofia', 'abc123', 'Offline', 'Mesero'),
(9, 'Marin', '1234abcd..', 'Online', 'Chef'),
(10, 'Ana', '1234abcd..', 'Offline', 'Chef');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`menuID`);

--
-- Indices de la tabla `tbl_menuitem`
--
ALTER TABLE `tbl_menuitem`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `menuID` (`menuID`);

--
-- Indices de la tabla `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  ADD PRIMARY KEY (`mesaID`);

--
-- Indices de la tabla `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`orderID`);

--
-- Indices de la tabla `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  ADD PRIMARY KEY (`orderDetailID`),
  ADD KEY `itemID` (`itemID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `mesaID` (`mesaID`);

--
-- Indices de la tabla `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`staffID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `menuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_menuitem`
--
ALTER TABLE `tbl_menuitem`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  MODIFY `mesaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

--
-- AUTO_INCREMENT de la tabla `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  MODIFY `orderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `staffID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  ADD CONSTRAINT `fk_mesaID` FOREIGN KEY (`mesaID`) REFERENCES `tbl_mesa` (`mesaID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orderID` FOREIGN KEY (`orderID`) REFERENCES `tbl_order` (`orderID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
