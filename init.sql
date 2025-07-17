-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2025 at 06:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportflexx`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `IdCategoria` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Descripcion` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`IdCategoria`, `Nombre`, `Descripcion`) VALUES
(1, 'HOMBRE', 'Ropa para hombre'),
(2, 'MUJER', 'Ropa para mujer'),
(3, 'ACCESORIOS', 'Accesorios de moda'),
(4, 'NOVEDADES', 'EDICIONES LIMITADAS');

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
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
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`IdCliente`, `IdUsuario`, `Nombre`, `Apellido`, `Sexo`, `FechaNacimiento`, `Telefono`, `Dni`) VALUES
(1, 1, 'Danito', 'Chocoflan', 'male', '2005-06-10', '904931932', '78965412'),
(2, 2, 'Daniel', 'Wang', 'male', '2024-08-27', '924484038', '78965412'),
(3, 7, 'Sapnap', 'dasdsad', 'male', '2024-09-18', '904931932', '48545254184'),
(4, 8, 'Daniel', 'Wang', 'male', '2024-09-24', '924484038', '78965412'),
(5, 11, 'tom', 'tom', 'male', '2001-07-10', '999999999', '71881819'),
(6, 12, 'tom', 'tom', 'male', '2001-09-09', '999999999', '72424044');

-- --------------------------------------------------------

--
-- Table structure for table `cupondescuento`
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
-- Dumping data for table `cupondescuento`
--

INSERT INTO `cupondescuento` (`IdCuponDescuento`, `Codigo`, `Descripcion`, `DescuentoPorcentaje`, `FechaInicio`, `FechaFin`, `Activo`) VALUES
(1, 'U22', 'Descuento del 10%', 0.10, '2024-07-17', '2024-07-24', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `detallepedido`
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
-- Table structure for table `direccion`
--

CREATE TABLE `direccion` (
  `IdDireccion` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `Direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `direccion`
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
(30, 4, 'where'),
(31, 5, 'av nusi'),
(32, 6, 'av nusi');

-- --------------------------------------------------------

--
-- Table structure for table `flyway_schema_history`
--

CREATE TABLE `flyway_schema_history` (
  `installed_rank` int(11) NOT NULL,
  `version` varchar(50) DEFAULT NULL,
  `description` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `script` varchar(1000) NOT NULL,
  `checksum` int(11) DEFAULT NULL,
  `installed_by` varchar(100) NOT NULL,
  `installed_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `execution_time` int(11) NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flyway_schema_history`
--

INSERT INTO `flyway_schema_history` (`installed_rank`, `version`, `description`, `type`, `script`, `checksum`, `installed_by`, `installed_on`, `execution_time`, `success`) VALUES
(1, '1', '<< Flyway Baseline >>', 'BASELINE', '<< Flyway Baseline >>', NULL, 'root', '2024-12-03 00:52:08', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `IdMenu` int(11) NOT NULL,
  `Nombre` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Ruta` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
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
-- Table structure for table `opinionproducto`
--

CREATE TABLE `opinionproducto` (
  `IdOpinionProducto` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Comentario` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Calificacion` int(11) DEFAULT NULL CHECK (`Calificacion` between 1 and 5),
  `FechaOpinion` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
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
-- Dumping data for table `pedido`
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
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `IdProducto` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `IdCategoria` int(11) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `FechaRegistro` date NOT NULL DEFAULT curdate(),
  `Genero` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ImagenProducto` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `imagen_producto` varchar(255) DEFAULT NULL,
  `precio_unitario` decimal(38,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`IdProducto`, `nombre`, `descripcion`, `IdCategoria`, `PrecioUnitario`, `FechaRegistro`, `Genero`, `ImagenProducto`, `fecha_registro`, `id_categoria`, `imagen_producto`, `precio_unitario`) VALUES
(100, 'Bolso Verde', 'Bolso verde moderno y cómodo', 3, 29.99, '2024-09-20', 'U', 'bolso verde.png', NULL, 0, NULL, 0.00),
(101, 'Bolso Blanco', 'Bolso blanco elegante para todo tipo de uso', 3, 32.99, '2024-09-20', 'U', 'bolso blanco.png', NULL, 0, NULL, 0.00),
(102, 'Bolso Negro', 'Bolso negro espacioso y versátil', 3, 28.99, '2024-09-20', 'U', 'bolso negro.png', NULL, 0, NULL, 0.00),
(103, 'Mochila Negra', 'Mochila negra ideal para actividades diarias', 3, 49.99, '2024-09-20', 'U', 'mochila negra.png', NULL, 0, NULL, 0.00),
(104, 'Mochila Blanca', 'Mochila blanca con diseño minimalista', 3, 54.99, '2024-09-20', 'U', 'mochila blanca.png', NULL, 0, NULL, 0.00),
(105, 'Mochila Negra Xr', 'Mochila negra XR con más capacidad de almacenamiento', 3, 59.99, '2024-09-20', 'U', 'mochila negra Xr.png', NULL, 0, NULL, 0.00),
(106, 'Mochila Tennis', 'Mochila diseñada especialmente para equipos de tennis', 3, 69.99, '2024-09-20', 'U', 'Mochila Tennis.png', NULL, 0, NULL, 0.00),
(107, 'Mochilón Negro', 'Mochilón negro con múltiples compartimientos', 3, 89.99, '2024-09-20', 'U', 'mochilon negro.png', NULL, 0, NULL, 0.00),
(108, 'Tomatodo', 'Botella de agua Tomatodo resistente para actividades deportivas', 3, 19.99, '2024-09-20', 'U', 'tomatodo.png', NULL, 0, NULL, 0.00),
(109, 'Camiseta Negra Manga Corta', 'Camiseta deportiva negra de manga corta, ideal para entrenamientos intensos.', 1, 89.90, '2024-09-20', 'M', 'Camiseta Negra Manga Corta.png', NULL, 0, NULL, 0.00),
(110, 'Camiseta Blanca sin Mangas', 'Camiseta blanca sin mangas para mayor libertad de movimiento.', 1, 74.90, '2024-09-20', 'M', 'image2.png', NULL, 0, NULL, 0.00),
(111, 'Camiseta Verde Oliva', 'Camiseta ajustada verde oliva, perfecta para entrenamiento en el gimnasio.', 1, 85.00, '2024-09-20', 'M', 'image3.png', NULL, 0, NULL, 0.00),
(112, 'Conjunto Deportivo Azul', 'Conjunto deportivo azul con sudadera y pantalones, ideal para entrenamiento o uso diario.', 1, 179.90, '2024-09-20', 'M', 'image4.png', NULL, 0, NULL, 0.00),
(113, 'Pantalones Deportivos Grises', 'Pantalones deportivos grises para mayor comodidad durante el ejercicio.', 1, 120.00, '2024-09-20', 'M', 'image5.png', NULL, 0, NULL, 0.00),
(114, 'Camiseta Gris Claro Ajustada', 'Camiseta ajustada de color gris claro, diseñada para acentuar la musculatura.', 1, 119.90, '2024-09-20', 'M', 'image6.png', NULL, 0, NULL, 0.00),
(115, 'Camiseta Negra Entrenamiento', 'Camiseta negra de entrenamiento, ideal para sesiones de fuerza.', 1, 89.90, '2024-09-20', 'M', 'image7.png', NULL, 0, NULL, 0.00),
(116, 'Camiseta Azul Marino', 'Camiseta ajustada de color azul marino para entrenamiento funcional.', 1, 85.00, '2024-09-20', 'M', 'image8.png', NULL, 0, NULL, 0.00),
(117, 'Camiseta Gris Oversized', 'Camiseta gris de estilo oversized para un look relajado y moderno.', 1, 65.90, '2024-09-20', 'M', 'image9.png', NULL, 0, NULL, 0.00),
(118, 'Top Deportivo Blanco', 'Top deportivo blanco, ideal para sesiones de entrenamiento intensas.', 2, 39.99, '2024-09-20', 'F', 'flaca1.png', NULL, 0, NULL, 0.00),
(119, 'Conjunto Deportivo Negro', 'Conjunto deportivo negro de manga larga y pantalones, perfecto para yoga o correr.', 2, 59.99, '2024-09-20', 'F', 'flaca2.png', NULL, 0, NULL, 0.00),
(120, 'Sudadera Negra', 'Sudadera negra ajustada para mantener el estilo durante el entrenamiento.', 2, 49.99, '2024-09-20', 'F', 'flaca3.png', NULL, 0, NULL, 0.00),
(121, 'Pantalones Deportivos Negros', 'Pantalones deportivos negros con ajuste cómodo y flexible.', 2, 45.99, '2024-09-20', 'F', 'flaca4.jpg', NULL, 0, NULL, 0.00),
(122, 'Top Deportivo Negro', 'Top deportivo negro, diseñado para ofrecer soporte y comodidad.', 2, 34.99, '2024-09-20', 'F', 'flaca5.jpg', NULL, 0, NULL, 0.00),
(123, 'Pantalones Deportivos Sueltos', 'Pantalones deportivos sueltos, ideales para entrenamientos o uso casual.', 2, 54.99, '2024-09-20', 'F', 'flaca6.jpg', NULL, 0, NULL, 0.00),
(124, 'Conjunto Beige Casual', 'Conjunto casual beige, perfecto para el uso diario o actividades ligeras.', 2, 69.99, '2024-09-20', 'F', 'flaca7.png', NULL, 0, NULL, 0.00),
(125, 'Conjunto Deportivo Beige', 'Conjunto deportivo beige con un diseño moderno y cómodo.', 2, 64.99, '2024-09-20', 'F', 'flaca8.png', NULL, 0, NULL, 0.00),
(126, 'Conjunto Deportivo Blanco', 'Conjunto deportivo blanco, perfecto para actividades físicas o relajación.', 2, 59.99, '2024-09-20', 'F', 'flaca9.png', NULL, 0, NULL, 0.00),
(127, 'Ejemplo4', 'sdfghjkl', 1, 230.00, '2024-09-26', '0', 'image9.png', NULL, 0, NULL, 0.00),
(128, 'Ejemploo963', 'asdasdsad', 3, 63.00, '2024-09-26', '0', 'mochila negra Xr.png', NULL, 0, NULL, 0.00),
(129, 'Ejemplo964 (1) (1)', 'ASDFGHJKLQWERTYUIASDFGHM', 3, 963.00, '2024-09-03', '0', 'bolso negro.png', NULL, 0, NULL, 0.00),
(130, 'Conjunto Deportivo', '[Oferta Especial] Conjunto Deportivo de Secado Rápido para Hombre - 2 piezas, Camiseta de Seda Helada & Shorts para Correr, Fitness & Entrenamiento de Baloncesto, Ropa Deportiva de Verano.', 1, 120.00, '2024-10-01', 'M', 'oferta2.png', NULL, 0, NULL, 0.00),
(131, 'Camiseta Clásica de Fernando Alonso en Renault', 'Camiseta Clásica de Fernando Alonso en Renault', 4, 230.00, '2024-10-01', 'M', 'imagen1.png', NULL, 0, NULL, 0.00),
(132, 'Camiseta Retro de Fernando Alonso en Renault', 'Camiseta Retro de Fernando Alonso en Renault Camiseta Retro de Fernando Alonso en Renault Camiseta Retro de Fernando Alonso en Renault', 4, 230.00, '2024-10-01', '0', 'Captura de pantalla 2024-10-01 152651.png', NULL, 0, NULL, 0.00),
(133, 'Pantalón Corto de Fernando Alonso en Renault', 'Pantalón Corto de Fernando Alonso en Renault\r\nPantalón Corto de Fernando Alonso en Renault\r\nPantalón Corto de Fernando Alonso en Renault', 4, 65.00, '2024-09-30', '0', '66fc5ea1ef3b0.png', NULL, 0, NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `producto_variantes`
--

CREATE TABLE `producto_variantes` (
  `IdVariante` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Talla` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Color` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producto_variantes`
--

INSERT INTO `producto_variantes` (`IdVariante`, `IdProducto`, `Talla`, `Color`, `Stock`) VALUES
(1, 109, 'M', 'Negro', 10),
(37, 128, 'S', 'Gris', 20),
(38, 129, '', 'Negro', 36),
(39, 130, 'L', 'Negro', 10),
(40, 131, 'L', 'Celeste', 5),
(41, 132, 'M', 'Celeste', 5),
(42, 133, 'M', 'Celeste', 15);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `IdRol` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`IdRol`, `Nombre`) VALUES
(1, 'admin'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Table structure for table `rolmenu`
--

CREATE TABLE `rolmenu` (
  `IdRolMenu` int(11) NOT NULL,
  `IdRol` int(11) NOT NULL,
  `IdMenu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rolmenu`
--

INSERT INTO `rolmenu` (`IdRolMenu`, `IdRol`, `IdMenu`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tipopago`
--

CREATE TABLE `tipopago` (
  `IdTipoPago` int(11) NOT NULL,
  `Tipo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipopago`
--

INSERT INTO `tipopago` (`IdTipoPago`, `Tipo`) VALUES
(1, 'Tarjeta de Crédito'),
(2, 'Efectivo');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
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
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `NombreUsuario`, `CorreoElectronico`, `Contrasena`, `IdRol`, `Intentos`, `Bloqueado`) VALUES
(1, 'dan41', 'Trolazo@gmail.com', '$2y$10$bVWY9FrrshU39YecU.sQcOF5yyeYC.W8ehL.mLcACm7VljpqLl/X6', 2, 3, b'0'),
(2, 'danonino', 'asdasda@gmail.com', '$2y$10$4jz1Xmw2lQFblDXe3NQXp.IliCChOrg7Icr5ynf89Hf4V4Fb8051y', 1, 3, b'0'),
(7, 'pana1', 'Trolazo@gmail.com', '$2y$10$ntwSrbNG7Q0OgSa8rTJUX.zLTbddHplIM07msXOJNQznvAeQUIz6S', 2, 3, b'0'),
(8, 'admin', 'Trolazo@gmail.com', '$2y$10$2oDDI9yj5yTfGEPCKLHTje8kyY3wiglT8skmow/U3OYuEiF0vzlzu', 1, 3, b'0'),
(11, 'nusi', 'asasa@hotmail.com', '123', 2, 0, b'1'),
(12, 'u22234043@utp.edu.pe', 'U22234043@utp.edu.pe', '$2y$10$6mfSdnRrbeo/DQw1zBFDG.PXAf/6ZG3KNXpQsevb6NkD4En6lq7YC', 2, 3, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `venta`
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
-- Dumping data for table `venta`
--

INSERT INTO `venta` (`IdVenta`, `IdPedido`, `FechaVenta`, `IGV`, `Total`, `Descuento`, `IdTipoPago`) VALUES
(3, 7, '2024-07-02', 10.00, 860.20, 18.00, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IdCliente`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indexes for table `cupondescuento`
--
ALTER TABLE `cupondescuento`
  ADD PRIMARY KEY (`IdCuponDescuento`),
  ADD UNIQUE KEY `Codigo` (`Codigo`);

--
-- Indexes for table `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`IdDetallePedido`),
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indexes for table `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`IdDireccion`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- Indexes for table `flyway_schema_history`
--
ALTER TABLE `flyway_schema_history`
  ADD PRIMARY KEY (`installed_rank`),
  ADD KEY `flyway_schema_history_s_idx` (`success`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`IdMenu`);

--
-- Indexes for table `opinionproducto`
--
ALTER TABLE `opinionproducto`
  ADD PRIMARY KEY (`IdOpinionProducto`),
  ADD KEY `IdProducto` (`IdProducto`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`IdPedido`),
  ADD KEY `IdCliente` (`IdCliente`),
  ADD KEY `IdCuponDescuento` (`IdCuponDescuento`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `IdCategoria` (`IdCategoria`);

--
-- Indexes for table `producto_variantes`
--
ALTER TABLE `producto_variantes`
  ADD PRIMARY KEY (`IdVariante`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indexes for table `rolmenu`
--
ALTER TABLE `rolmenu`
  ADD PRIMARY KEY (`IdRolMenu`),
  ADD KEY `IdRol` (`IdRol`),
  ADD KEY `IdMenu` (`IdMenu`);

--
-- Indexes for table `tipopago`
--
ALTER TABLE `tipopago`
  ADD PRIMARY KEY (`IdTipoPago`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD KEY `IdRol` (`IdRol`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdTipoPago` (`IdTipoPago`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cupondescuento`
--
ALTER TABLE `cupondescuento`
  MODIFY `IdCuponDescuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `IdDetallePedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `direccion`
--
ALTER TABLE `direccion`
  MODIFY `IdDireccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `IdMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `producto_variantes`
--
ALTER TABLE `producto_variantes`
  MODIFY `IdVariante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `IdRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rolmenu`
--
ALTER TABLE `rolmenu`
  MODIFY `IdRolMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tipopago`
--
ALTER TABLE `tipopago`
  MODIFY `IdTipoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `venta`
--
ALTER TABLE `venta`
  MODIFY `IdVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`IdPedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
