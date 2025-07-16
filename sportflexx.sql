-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2024 a las 20:10:08
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
-- Base de datos: `sportflexx`
--
CREATE DATABASE IF NOT EXISTS `sportflexx` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sportflexx`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `IdCategoria` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Descripcion` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`IdCategoria`, `Nombre`, `Descripcion`) VALUES
(1, 'HOMBRE', 'Ropa para hombre'),
(2, 'MUJER', 'Ropa para mujer'),
(3, 'ACCESORIOS', 'Accesorios de moda'),
(4, 'NOVEDADES', 'EDICIONES LIMITADAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `IdCliente` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `Nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Apellido` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sexo` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Dni` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`IdCliente`, `IdUsuario`, `Nombre`, `Apellido`, `Sexo`, `FechaNacimiento`, `Telefono`, `Dni`) VALUES
(1, 1, 'Danito', 'Chocoflan', 'male', '2005-06-10', '904931932', '78965412'),
(2, 2, 'Daniel', 'Gonzales', 'male', '2024-08-27', '924484038', '78965412'),
(3, 7, 'Sapnap', 'dasdsad', 'male', '2024-09-18', '904931932', '48545254184'),
(4, 8, 'Daniel', 'Wang', 'male', '2024-09-24', '924484038', '78965412');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupondescuento`
--

CREATE TABLE `cupondescuento` (
  `IdCuponDescuento` int(11) NOT NULL,
  `Codigo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Descripcion` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `DescuentoPorcentaje` decimal(5,2) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Activo` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cupondescuento`
--

INSERT INTO `cupondescuento` (`IdCuponDescuento`, `Codigo`, `Descripcion`, `DescuentoPorcentaje`, `FechaInicio`, `FechaFin`, `Activo`) VALUES
(1, 'U22', 'Descuento del 10%', 0.10, '2024-07-17', '2024-07-24', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `IdDetallePedido` int(11) NOT NULL,
  `IdPedido` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `PrecioUnitario` decimal(13,2) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Descuento` decimal(13,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `IdDireccion` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `Direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`IdDireccion`, `IdCliente`, `Direccion`) VALUES
(9, 6, 'Av 28 DE AGOSTO 369'),
(14, 10, 'Lima'),
(15, 11, 'Lima'),
(19, 10, 'Lima'),
(20, 6, 'Av 28 DE AGOSTO 369'),
(21, 15, 'AV 28 DE JULIO 317'),
(22, 16, 'AV PERUANIDAD 3369'),
(23, 23, 'Av 28 DE AGOSTO 369'),
(24, 24, 'AV 28 DE JULIO 317'),
(25, 25, 'AV 28 DE JULIO 317'),
(26, 1, 'AV 28 DE JULIO 317'),
(27, 2, 'AV PERUANIDAD 3369'),
(28, 3, 'where'),
(29, 3, 'AV 28 DE JULIO 317'),
(30, 4, 'where');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `IdMenu` int(11) NOT NULL,
  `Nombre` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Ruta` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`IdMenu`, `Nombre`, `Ruta`) VALUES
(1, 'MenuAdmin', 'MenuAdmin.php'),
(2, 'MenuPrincipalCliente', 'MenuPrincipalCliente.php'),
(3, 'HombreCliente', 'hombreCliente.php'),
(4, 'MujerCliente', 'mujerCliente.php'),
(5, 'AccesoriosClientes', 'accesoriosClientes.php'),
(6, 'Novedades', 'novedades.php'),
(7, 'MiPerfil', 'MiPerfil.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `IdPedido` int(11) NOT NULL,
  `IdCliente` int(11) DEFAULT NULL,
  `NumeroPedido` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Estado` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FechaPedido` date NOT NULL DEFAULT curdate(),
  `FechaEntrega` date DEFAULT NULL,
  `IdCuponDescuento` int(11) DEFAULT NULL,
  `SessionId` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`IdPedido`, `IdCliente`, `NumeroPedido`, `Estado`, `FechaPedido`, `FechaEntrega`, `IdCuponDescuento`, `SessionId`) VALUES
(1, 11, '4853', 'Completado', '2024-06-03', '2024-01-12', 2, NULL),
(2, 11, '4972', 'Completado', '2024-01-22', '2024-02-29', 3, '728235'),
(3, 3, '3778', 'Completado', '2024-05-08', '2024-05-14', 1, '631172'),
(4, 3, '3137', 'Pendiente', '2024-02-06', '2024-04-29', 2, '881252'),
(5, 13, '5959', 'Completado', '2024-04-24', '2024-01-25', 1, '466283'),
(6, 12, '3921', 'Pendiente', '2024-07-15', '2024-08-03', 0, '948516'),
(7, 6, '12', 'Pendiente', '2024-07-01', '2024-08-10', 1, NULL),
(8, 17, '1739', 'Cancelado', '2024-08-20', '2024-05-13', 4, '654982'),
(9, 2, '9842', 'Pendiente', '2024-02-17', '2024-03-11', 3, NULL),
(10, 5, '2948', 'Pendiente', '2024-01-25', '2024-07-05', 1, '774331'),
(11, 8, '8193', 'Completado', '2024-08-01', '2024-04-17', 2, '632981'),
(12, 16, '9874', 'Pendiente', '2024-04-12', '2024-05-03', 5, '438275'),
(13, 9, '3827', 'Completado', '2024-01-18', '2024-01-29', 1, NULL),
(14, 1, '8367', 'Cancelado', '2024-06-24', '2024-02-20', 3, '781249'),
(15, 20, '1283', 'Pendiente', '2024-07-31', '2024-03-27', 0, '983572'),
(16, 4, '7832', 'Completado', '2024-05-16', '2024-07-09', 4, NULL),
(17, 19, '8234', 'Cancelado', '2024-02-11', '2024-08-04', 2, '649731'),
(18, 14, '7625', 'Pendiente', '2024-03-02', '2024-01-18', 3, '514287'),
(19, 7, '9328', 'Completado', '2024-07-09', '2024-02-22', 0, '857324'),
(20, 18, '5327', 'Pendiente', '2024-08-19', '2024-04-09', 4, '294867');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `IdProducto` int(11) NOT NULL,
  `Nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Descripcion` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `IdCategoria` int(11) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `FechaRegistro` date NOT NULL DEFAULT curdate(),
  `ImagenProducto` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`IdProducto`, `Nombre`, `Descripcion`, `IdCategoria`, `PrecioUnitario`, `FechaRegistro`, `ImagenProducto`) VALUES
(100, 'Bolso Verde', 'Bolso verde moderno y cómodo', 3, 29.99, '2024-09-20', 'bolso verde.png'),
(101, 'Bolso Blanco', 'Bolso blanco elegante para todo tipo de uso', 3, 32.99, '2024-09-20', 'bolso blanco.png'),
(102, 'Bolso Negro', 'Bolso negro espacioso y versátil', 3, 28.99, '2024-09-20', 'bolso negro.png'),
(103, 'Mochila Negra', 'Mochila negra ideal para actividades diarias', 3, 49.99, '2024-09-20', 'mochila negra.png'),
(104, 'Mochila Blanca', 'Mochila blanca con diseño minimalista', 3, 54.99, '2024-09-20', 'mochila blanca.png'),
(105, 'Mochila Negra Xr', 'Mochila negra XR con más capacidad de almacenamiento', 3, 59.99, '2024-09-20', 'mochila negra Xr.png'),
(106, 'Mochila Tennis', 'Mochila diseñada especialmente para equipos de tennis', 3, 69.99, '2024-09-20', 'Mochila Tennis.png'),
(107, 'Mochilón Negro', 'Mochilón negro con múltiples compartimientos', 3, 89.99, '2024-09-20', 'mochilon negro.png'),
(108, 'Tomatodo', 'Botella de agua Tomatodo resistente para actividades deportivas', 3, 19.99, '2024-09-20', 'tomatodo.png'),
(109, 'Camiseta Negra Manga Corta', 'Details Style Laux_RB - 50530190 A high-impact jacket by HUGO, with a signature bull motif front and back. ', 1, 89.90, '2024-09-20', 'Camiseta Negra Manga Corta.png'),
(110, 'Camiseta Blanca sin Mangas', 'Camiseta blanca sin mangas para mayor libertad de movimiento.', 1, 74.90, '2024-09-20', 'image2.png'),
(111, 'Camiseta Verde Oliva', 'Camiseta ajustada verde oliva, perfecta para entrenamiento en el gimnasio.', 1, 85.00, '2024-09-20', 'image3.png'),
(112, 'Conjunto Deportivo Azul', 'Conjunto deportivo azul con sudadera y pantalones, ideal para entrenamiento o uso diario.', 1, 179.90, '2024-09-20', 'image4.png'),
(113, 'Pantalones Deportivos Grises', 'Pantalones deportivos grises para mayor comodidad durante el ejercicio.', 1, 120.00, '2024-09-20', 'image5.png'),
(114, 'Camiseta Gris Claro Ajustada', 'Camiseta ajustada de color gris claro, diseñada para acentuar la musculatura.', 1, 119.90, '2024-09-20', 'image6.png'),
(115, 'Camiseta Negra Entrenamiento', 'Camiseta negra de entrenamiento, ideal para sesiones de fuerza.', 1, 89.90, '2024-09-20', 'image7.png'),
(116, 'Camiseta Azul Marino', 'Camiseta ajustada de color azul marino para entrenamiento funcional.', 1, 85.00, '2024-09-20', 'image8.png'),
(117, 'Camiseta Gris Oversized', 'Camiseta gris de estilo oversized para un look relajado y moderno.', 1, 65.90, '2024-09-20', 'image9.png'),
(118, 'Top Deportivo Blanco', 'Top deportivo blanco, ideal para sesiones de entrenamiento intensas.', 2, 39.99, '2024-09-20', 'flaca1.png'),
(119, 'Conjunto Deportivo Negro', 'Conjunto deportivo negro de manga larga y pantalones, perfecto para yoga o correr.', 2, 59.99, '2024-09-20', 'flaca2.png'),
(120, 'Sudadera Negra', 'Sudadera negra ajustada para mantener el estilo durante el entrenamiento.', 2, 49.99, '2024-09-20', 'flaca3.png'),
(121, 'Pantalones Deportivos Negros', 'Pantalones deportivos negros con ajuste cómodo y flexible.', 2, 45.99, '2024-09-20', 'flaca4.jpg'),
(122, 'Top Deportivo Negro', 'Top deportivo negro, diseñado para ofrecer soporte y comodidad.', 2, 34.99, '2024-09-20', 'flaca5.jpg'),
(123, 'Pantalones Deportivos Sueltos', 'Pantalones deportivos sueltos, ideales para entrenamientos o uso casual.', 2, 54.99, '2024-09-20', 'flaca6.jpg'),
(124, 'Conjunto Beige Casual', 'Conjunto casual beige, perfecto para el uso diario o actividades ligeras.', 2, 69.99, '2024-09-20', 'flaca7.png'),
(125, 'Conjunto Deportivo Beige', 'Conjunto deportivo beige con un diseño moderno y cómodo.', 2, 64.99, '2024-09-20', 'flaca8.png'),
(126, 'Conjunto Deportivo Blanco', 'Conjunto deportivo blanco, perfecto para actividades físicas o relajación.', 2, 59.99, '2024-09-20', 'flaca9.png'),
(131, 'Camiseta Clásica de Fernando Alonso en Renault', 'Camiseta Clásica de Fernando Alonso en Renault', 4, 230.00, '2024-10-01', 'imagen1.png'),
(132, 'Camiseta Retro de Fernando Alonso en Renault', 'Camiseta Retro de Fernando Alonso en Renault Camiseta Retro de Fernando Alonso en Renault Camiseta Retro de Fernando Alonso en Renault', 4, 230.00, '2024-10-01', 'Captura de pantalla 2024-10-01 152651.png'),
(133, 'Pantalón Corto de Fernando Alonso en Renault', 'Pantalón Corto de Fernando Alonso en Renault\r\nPantalón Corto de Fernando Alonso en Renault\r\nPantalón Corto de Fernando Alonso en Renault', 4, 65.00, '2024-09-30', '66fc5ea1ef3b0.png'),
(141, 'Camiseta Renault R25 2005 Fernando Alonso F1', 'Esta camiseta fue creada para ser un compañero versátil y elegante para todas tus apariencias casuales. Con su tejido de punto de microfibra, grueso y de textura única, esta camiseta tiene una sensación premium y suave que sigue siendo ligera y altam', 4, 117.42, '2024-10-18', '6712d5c343f1e.png'),
(142, 'ING RENAULT F1 TEAM OFICIAL POLAR RETRO VINTAGE FERNANDO ALONSO', 'Renault F1 Team ING Formula One 1 Racing Motorsport azul amarillo chaqueta', 4, 488.41, '2024-10-18', '6712d6525ceda.png'),
(143, 'Daring Renault F1 Team Fernando Alonso Camiseta Precisport', 'El color en el artículo puede estar ligeramente apagado debido a la iluminación', 4, 1315.02, '2024-10-18', '6712d68c836e0.png'),
(144, 'Camiseta Giancarlo Physiella 2005 Colección Renault F1 Team', 'Polo Original GIANCARLO FISICHELLA Colección 2005 RENAULT F1 TEAM', 4, 920.54, '2024-10-18', '6712d71535586.png'),
(145, 'Camiseta De Colección 2005 Fernando Alonso Azul Nueva Con Etiquetas F1 Campeón del Mundo Renault', 'ganga', 4, 149.84, '2024-10-18', '6712d771cae6a.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_variantes`
--

CREATE TABLE `producto_variantes` (
  `IdVariante` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Talla` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_variantes`
--

INSERT INTO `producto_variantes` (`IdVariante`, `IdProducto`, `Talla`, `Stock`) VALUES
(1, 109, 'M', 25),
(2, 118, 'M', 20),
(3, 118, 'L', 15),
(4, 118, 'XL', 30),
(5, 119, 'S', 10),
(6, 119, 'M', 20),
(7, 119, 'L', 15),
(8, 119, 'XL', 30),
(9, 120, 'S', 10),
(10, 120, 'M', 20),
(11, 120, 'L', 15),
(12, 120, 'XL', 30),
(13, 121, 'S', 10),
(14, 121, 'M', 20),
(15, 121, 'L', 15),
(16, 121, 'XL', 30),
(17, 122, 'S', 10),
(18, 122, 'M', 20),
(19, 122, 'L', 15),
(20, 122, 'XL', 30),
(21, 123, 'S', 10),
(22, 123, 'M', 20),
(23, 123, 'L', 15),
(24, 123, 'XL', 30),
(25, 124, 'S', 10),
(26, 124, 'M', 20),
(27, 124, 'L', 15),
(28, 124, 'XL', 30),
(29, 125, 'S', 10),
(30, 125, 'M', 20),
(31, 125, 'L', 15),
(32, 125, 'XL', 30),
(33, 126, 'S', 10),
(34, 126, 'M', 20),
(35, 126, 'L', 15),
(36, 126, 'XL', 30),
(37, 126, 'S', 20),
(38, 126, 'M', 12),
(40, 131, 'L', 5),
(41, 132, 'M', 10),
(42, 133, 'M', 12),
(45, 109, 'XL', 34),
(48, 109, 'S', 20),
(49, 109, 'L', 15),
(50, 110, 'S', 15),
(51, 110, 'M', 10),
(52, 110, 'L', 10),
(53, 110, 'XL', 23),
(54, 100, 'S', 15),
(55, 100, 'M', 10),
(56, 111, 'S', 10),
(57, 111, 'M', 36),
(58, 111, 'L', 15),
(59, 111, 'XL', 12),
(60, 131, 'M', 15),
(61, 131, 'S', 10),
(62, 131, 'XL', 15),
(63, 132, 'S', 15),
(64, 132, 'XL', 12),
(65, 132, 'L', 10),
(66, 133, 'XL', 10),
(67, 133, 'L', 10),
(68, 133, 'S', 10),
(69, 141, 'S', 12),
(70, 141, 'M', 10),
(71, 141, 'L', 10),
(72, 141, 'XL', 20),
(73, 142, 'S', 12),
(74, 142, 'M', 15),
(75, 142, 'L', 14),
(76, 142, 'XL', 10),
(77, 143, 'S', 9),
(78, 143, 'M', 7),
(79, 143, 'L', 15),
(80, 143, 'XL', 10),
(81, 144, 'M', 15),
(82, 144, 'L', 10),
(83, 145, 'S', 20),
(84, 145, 'M', 10),
(85, 118, 'S', 10),
(86, 100, NULL, 15),
(87, 101, NULL, 15),
(88, 102, NULL, 15),
(89, 103, NULL, 15),
(90, 104, NULL, 15),
(91, 105, NULL, 15),
(92, 106, NULL, 15),
(93, 107, NULL, 15),
(94, 108, NULL, 15),
(95, 112, 'S', 10),
(96, 112, 'M', 20),
(97, 112, 'L', 15),
(98, 112, 'XL', 30),
(99, 113, 'S', 10),
(100, 113, 'M', 20),
(101, 113, 'L', 15),
(102, 113, 'XL', 30),
(103, 114, 'S', 10),
(104, 114, 'M', 20),
(105, 114, 'L', 15),
(106, 114, 'XL', 30),
(107, 115, 'S', 10),
(108, 115, 'M', 20),
(109, 115, 'L', 15),
(110, 115, 'XL', 30),
(111, 116, 'S', 10),
(112, 116, 'M', 20),
(113, 116, 'L', 15),
(114, 116, 'XL', 30),
(115, 117, 'S', 10),
(116, 117, 'M', 20),
(117, 117, 'L', 15),
(118, 117, 'XL', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `IdRol` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`IdRol`, `Nombre`) VALUES
(1, 'admin'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rolmenu`
--

CREATE TABLE `rolmenu` (
  `IdRolMenu` int(11) NOT NULL,
  `IdRol` int(11) NOT NULL,
  `IdMenu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rolmenu`
--

INSERT INTO `rolmenu` (`IdRolMenu`, `IdRol`, `IdMenu`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `NombreUsuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CorreoElectronico` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Contrasena` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `IdRol` int(11) NOT NULL,
  `Intentos` int(11) DEFAULT 3,
  `Bloqueado` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `NombreUsuario`, `CorreoElectronico`, `Contrasena`, `IdRol`, `Intentos`, `Bloqueado`) VALUES
(1, 'dan41', 'Trolazo@gmail.com', '$2y$10$bVWY9FrrshU39YecU.sQcOF5yyeYC.W8ehL.mLcACm7VljpqLl/X6', 2, 3, b'0'),
(2, 'danonino', 'trollll@gmail.com', '$2y$10$4jz1Xmw2lQFblDXe3NQXp.IliCChOrg7Icr5ynf89Hf4V4Fb8051y', 1, 3, b'0'),
(7, 'pana1', 'Trolazo@gmail.com', '$2y$10$ntwSrbNG7Q0OgSa8rTJUX.zLTbddHplIM07msXOJNQznvAeQUIz6S', 2, 3, b'0'),
(8, 'admin', 'Trolazo@gmail.com', '$2y$10$2oDDI9yj5yTfGEPCKLHTje8kyY3wiglT8skmow/U3OYuEiF0vzlzu', 1, 3, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `IdVenta` int(11) NOT NULL,
  `IdPedido` int(11) NOT NULL,
  `FechaVenta` date NOT NULL DEFAULT curdate(),
  `IGV` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Descuento` decimal(10,2) DEFAULT NULL,
  `IdTipoPago` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`IdVenta`, `IdPedido`, `FechaVenta`, `IGV`, `Total`, `Descuento`, `IdTipoPago`) VALUES
(3, 7, '2024-07-02', 10.00, 860.20, 18.00, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IdCliente`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `cupondescuento`
--
ALTER TABLE `cupondescuento`
  ADD PRIMARY KEY (`IdCuponDescuento`),
  ADD UNIQUE KEY `Codigo` (`Codigo`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`IdDetallePedido`),
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`IdDireccion`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`IdMenu`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`IdPedido`),
  ADD KEY `IdCliente` (`IdCliente`),
  ADD KEY `IdCuponDescuento` (`IdCuponDescuento`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `IdCategoria` (`IdCategoria`);

--
-- Indices de la tabla `producto_variantes`
--
ALTER TABLE `producto_variantes`
  ADD PRIMARY KEY (`IdVariante`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indices de la tabla `rolmenu`
--
ALTER TABLE `rolmenu`
  ADD PRIMARY KEY (`IdRolMenu`),
  ADD KEY `IdRol` (`IdRol`),
  ADD KEY `IdMenu` (`IdMenu`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD KEY `IdRol` (`IdRol`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdTipoPago` (`IdTipoPago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cupondescuento`
--
ALTER TABLE `cupondescuento`
  MODIFY `IdCuponDescuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `IdDetallePedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `IdDireccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `IdMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT de la tabla `producto_variantes`
--
ALTER TABLE `producto_variantes`
  MODIFY `IdVariante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `IdRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rolmenu`
--
ALTER TABLE `rolmenu`
  MODIFY `IdRolMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `IdVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`IdPedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detallepedido_pedido` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`IdPedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detallepedido_producto` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rolmenu`
--
ALTER TABLE `rolmenu`
  ADD CONSTRAINT `rolmenu_ibfk_1` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`),
  ADD CONSTRAINT `rolmenu_ibfk_2` FOREIGN KEY (`IdMenu`) REFERENCES `menu` (`IdMenu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
