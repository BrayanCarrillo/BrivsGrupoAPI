-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2024 a las 20:42:25
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
  `menuName` varchar(25) NOT NULL,
  `activate` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_menu`
--

INSERT INTO `tbl_menu` (`menuID`, `menuName`, `activate`) VALUES
(9, 'Cocidos o al Vapor', 1),
(10, 'Bebidas', 1),
(11, 'Sopas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_menuitem`
--

CREATE TABLE `tbl_menuitem` (
  `itemID` int(11) NOT NULL,
  `menuID` int(11) NOT NULL,
  `menuItemName` text NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `activate` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_menuitem`
--

INSERT INTO `tbl_menuitem` (`itemID`, `menuID`, `menuItemName`, `price`, `activate`) VALUES
(20, 10, 'Plato Actualizado', 15000.00, 1),
(21, 9, 'Salmón al Vapor', 16000.00, 1),
(22, 9, 'Cazuela de Mariscos', 17000.00, 1),
(23, 9, 'Arroz con Camarones', 14000.00, 1),
(24, 9, 'Pescado al Vapor con Hierbas', 15000.00, 1),
(25, 10, 'Agua de Coco', 3000.00, 1),
(26, 10, 'Limonada de Maracuyá', 3500.00, 1),
(27, 11, 'Sopa de Pescado con Verduras', 12000.00, 1),
(54, 9, 'Capibara a la plancha', 50000.00, 0),
(55, 9, 'mojarra sada', 50000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mesa`
--

CREATE TABLE `tbl_mesa` (
  `mesaID` int(11) NOT NULL,
  `activate` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_mesa`
--

INSERT INTO `tbl_mesa` (`mesaID`, `activate`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1);

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
(1047, 'preparando', 16000.00, '2024-06-27', 1),
(1048, 'listo', 3000.00, '2024-06-27', 3),
(1049, 'esperando', 12000.00, '2024-06-27', 4),
(1050, 'listo', 100000.00, '2024-06-27', 2);

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
(1047, 83, 21, 1, NULL),
(1048, 84, 25, 1, NULL),
(1049, 85, 27, 1, NULL),
(1050, 86, 55, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role` varchar(25) NOT NULL
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
  `status` tinyint(1) NOT NULL,
  `role` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_staff`
--

INSERT INTO `tbl_staff` (`staffID`, `username`, `password`, `status`, `role`) VALUES
(1, 'Juan', '$2y$10$skZTaK.l3byhf5ksLAjVMOitNwe5tqQMPnx406VFuHRY4NUoBBLdu', 1, 'Chef'),
(4, 'Pedro', '1234abcd..', 1, 'Mesero'),
(5, 'Adriana', '1234abcd..', 1, 'Chef'),
(6, 'Robert', '1234abcd..', 1, 'Chef'),
(7, 'Sofia', 'abc123', 1, 'Mesero'),
(9, 'Marin', '$2y$10$hb4gjT7ju.5c6WztfWf.NOkYahrVSQr9jsV/4VWy2QajUxfFXOnai', 1, 'Chef');

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
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `mesaID` (`mesaID`);

--
-- Indices de la tabla `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  ADD PRIMARY KEY (`orderDetailID`),
  ADD KEY `itemID` (`itemID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `mesaID` (`mesaID`);

--
-- Indices de la tabla `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`role`);

--
-- Indices de la tabla `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `menuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `tbl_menuitem`
--
ALTER TABLE `tbl_menuitem`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  MODIFY `mesaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1051;

--
-- AUTO_INCREMENT de la tabla `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  MODIFY `orderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `staffID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_menuitem`
--
ALTER TABLE `tbl_menuitem`
  ADD CONSTRAINT `fk_menuID` FOREIGN KEY (`menuID`) REFERENCES `tbl_menu` (`menuID`);

--
-- Filtros para la tabla `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `fk_order_mesaID` FOREIGN KEY (`mesaID`) REFERENCES `tbl_mesa` (`mesaID`);

--
-- Filtros para la tabla `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  ADD CONSTRAINT `fk_itemID` FOREIGN KEY (`itemID`) REFERENCES `tbl_menuitem` (`itemID`),
  ADD CONSTRAINT `fk_mesaID` FOREIGN KEY (`mesaID`) REFERENCES `tbl_mesa` (`mesaID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orderID` FOREIGN KEY (`orderID`) REFERENCES `tbl_order` (`orderID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role`) REFERENCES `tbl_role` (`role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
