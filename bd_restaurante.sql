-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-01-2024 a las 02:11:05
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id_almacen` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id_almacen`, `nombre`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Primer Piso', 1, '2023-10-08 01:07:27', NULL, NULL),
(2, 'Segundo Piso', 1, '2023-10-08 01:07:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_pedidos_delivery`
--

CREATE TABLE `asignacion_pedidos_delivery` (
  `id_asignacion` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL COMMENT 'en camino, preparación, entregado',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Bebidas', 1, '2023-10-06 15:55:04', NULL, NULL),
(2, 'Entradas', 1, '2023-10-06 15:55:14', NULL, NULL),
(3, 'Segundos', 1, '2023-10-06 15:55:26', NULL, NULL),
(4, 'Sacos editados', 1, '2023-10-08 02:39:51', NULL, NULL),
(5, 'Sacos editados', 1, '2023-10-08 02:41:00', NULL, NULL),
(6, 'prueba', 1, '2023-11-21 01:55:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_clientes` int(11) NOT NULL,
  `nombres` varchar(150) DEFAULT NULL,
  `apellidos` varchar(150) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `es_activo` int(11) DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_clientes`, `nombres`, `apellidos`, `direccion`, `telefono`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Christian', 'Castro Guerra', 'Jr.Zanjon #473', '971763092', 0, '2023-09-26 02:07:17', '2023-10-02 15:53:06', '2023-10-06 14:44:45'),
(2, 'testina', 'testtt', 'tess', '45346436', 0, '2023-09-26 17:52:02', '2023-09-27 17:05:17', '2023-11-09 14:40:54'),
(3, 'Luis', 'pruebaa', 'pruebaD', '2324343', 0, '2023-10-03 03:19:17', '2023-10-03 03:43:37', '2023-11-09 14:40:58'),
(4, 'prueba cliente', 'Castro', 'christiacastro@gmail.com', '973211879', 1, '2023-10-06 14:21:35', '2023-11-09 14:41:13', NULL),
(5, 'Gloria', 'Jr Gloria', 'leche@gloria.com', '45346436', 0, '2023-10-06 14:23:14', NULL, '2023-11-08 23:39:05'),
(6, 'Gloria', 'Jr Gloria', 'leche@gloria.com', '45346436', 0, '2023-10-06 14:24:31', NULL, '2023-11-08 23:39:08'),
(7, 'Gloria', 'Jr Gloria', 'leche@gloria.com', '2324343', 0, '2023-10-06 14:26:35', NULL, '2023-11-08 23:39:38'),
(8, 'Gloria', 'Jr Gloria', 'leche@gloria.com', '45346436', 0, '2023-10-06 14:26:53', NULL, '2023-11-08 23:39:42'),
(9, 'hola', 'Castro Guerra', NULL, NULL, 0, '2023-11-09 13:52:39', NULL, '2023-11-09 14:22:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle_factura` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `empledo_id` int(11) NOT NULL,
  `platos_id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `mesa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `nombre`, `precio`, `cantidad`, `pedido_id`) VALUES
(7, 'Ceviche', 10.00, 2, 6),
(8, 'Ceviche', 10.00, 1, 7),
(9, 'Ceviche', 10.00, 1, 8),
(10, 'Ceviche', 10.00, 1, 9),
(11, 'Ceviche', 10.00, 2, 10),
(12, 'Hamburguesa', 5.00, 1, 11),
(13, 'Hamburguesa', 5.00, 1, 12),
(14, 'Ceviche', 10.00, 2, 13),
(15, 'Hamburguesa', 5.00, 1, 13),
(16, 'Hamburguesa', 5.00, 1, 14),
(17, 'Hamburguesa', 5.00, 1, 15),
(18, 'Ceviche', 10.00, 2, 16),
(19, 'Hamburguesa', 5.00, 1, 17),
(20, 'Ceviche', 10.00, 1, 18),
(21, 'Ceviche', 10.00, 1, 19),
(22, 'Ceviche', 10.00, 1, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombres` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `dni` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombres`, `apellidos`, `dni`, `correo`, `telefono`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, '\0\0\0C\0\0\0h\0\0\0r\0\0\0i\0\0\0s\0\0\0t\0\0\0i\0\0\0a\0\0\0n', 'Castro Guerra', '74505141', 'castroguerrachristian4@gmail.com', '970763092', 1, '2023-09-21 16:29:33', '2023-11-12 16:10:08', '2023-11-09 14:32:08'),
(9, '\0\0\0L\0\0\0u\0\0\0i\0\0\0s', 'Talledo', '03465792', 'luis@gmail.com', '987654321', 1, '2023-11-09 14:40:37', NULL, NULL),
(10, 'nombre prueba', 'prueba apellidos', '123456789', 'prueba@gmail.com', '974133145', 0, '2023-11-12 16:10:35', '2023-11-12 16:12:36', '2023-11-12 16:12:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `id_insumos` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `descripcion` text NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `presentacion_id` int(11) DEFAULT NULL,
  `almacen_id` int(11) DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`id_insumos`, `nombre`, `cantidad`, `precio_unitario`, `descripcion`, `es_activo`, `presentacion_id`, `almacen_id`, `proveedor_id`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(2, 'test', 20, 10.50, 'esto es una prueba', 1, 2, 1, 2, '2023-10-08 01:41:31', '2023-10-08 03:17:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `insumos_id` int(11) DEFAULT NULL,
  `productos_id` int(11) DEFAULT NULL,
  `almacen_id` int(11) DEFAULT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `insumos_id`, `productos_id`, `almacen_id`, `es_activo`, `cantidad`) VALUES
(1, 2, NULL, 1, 1, 20),
(2, NULL, 1, 2, 1, 25),
(3, NULL, 2, 2, 1, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_productos`
--

CREATE TABLE `inventario_productos` (
  `id_inventario_productos` int(11) DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tipo_movimiento` int(11) NOT NULL COMMENT '0->Salida\r\n1->Entrada',
  `fecha` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id_mesa` int(11) NOT NULL,
  `nombre_mesa` varchar(50) NOT NULL,
  `piso_id` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `nombre_mesa`, `piso_id`, `capacidad`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'prueba', 1, 5, 1, '2023-11-12 23:18:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT 'fectivo, tarjeta',
  `monto` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `sala_id` int(11) NOT NULL,
  `numero_mesa` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1->Pendiente 0 ->compleatado',
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `sala_id`, `numero_mesa`, `fecha`, `total`, `observaciones`, `estado`, `usuario_id`) VALUES
(6, 1, 1, '2023-11-14 18:56:31', 20.00, '', 0, 1),
(7, 1, 2, '2023-11-14 18:59:30', 10.00, '', 0, 1),
(8, 1, 3, '2023-11-15 02:10:06', 10.00, '', 0, 1),
(9, 1, 4, '2023-11-15 02:11:46', 10.00, '', 0, 1),
(10, 2, 1, '2023-11-15 04:00:01', 20.00, 'con arto aji', 0, 1),
(11, 2, 2, '2023-11-20 01:42:18', 5.00, '', 0, 1),
(12, 2, 2, '2023-11-20 01:42:53', 5.00, '', 0, 1),
(13, 1, 1, '2023-11-20 01:46:26', 25.00, 'Para la hamburguesa solo de cremas aji', 0, 1),
(14, 1, 1, '2023-11-20 04:13:58', 5.00, '', 0, 1),
(15, 1, 1, '2023-11-20 05:02:23', 5.00, '', 0, 1),
(16, 1, 1, '2023-11-20 06:38:08', 20.00, 'Sin aji', 0, 1),
(17, 1, 1, '2023-11-20 06:39:49', 5.00, '', 0, 1),
(18, 1, 1, '2023-11-20 23:36:13', 10.00, '', 0, 1),
(19, 1, 2, '2023-11-20 23:41:17', 10.00, '', 1, 1),
(20, 1, 1, '2023-11-22 01:11:20', 10.00, '', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_delivery`
--

CREATE TABLE `pedidos_delivery` (
  `id_delivery` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `platos_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL COMMENT 'pendiente, preparacion, entregado',
  `direccion_entrega` varchar(150) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pisos`
--

CREATE TABLE `pisos` (
  `id_piso` int(11) NOT NULL,
  `nombre_piso` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pisos`
--

INSERT INTO `pisos` (`id_piso`, `nombre_piso`, `descripcion`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Primer Piso ', 'Cuenta espacio para diez mesas editado', 1, '2023-10-11 17:13:45', '2023-10-12 14:49:17', NULL),
(2, 'Segundo piso', 'Esta es la descripción del segundo piso', 1, '2023-10-12 14:49:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `id_platos` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `precio` int(11) NOT NULL,
  `disponible` int(11) NOT NULL DEFAULT 1 COMMENT '0-> No disponible\r\n1-> Disponible',
  `categoria_id` int(11) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`id_platos`, `nombre`, `precio`, `disponible`, `categoria_id`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Ceviche', 10, 1, 2, 1, '2023-11-14 15:30:42', '2023-11-14 15:32:15', NULL),
(2, 'Hamburguesa', 5, 1, 3, 1, '2023-11-15 04:01:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `id_presentacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`id_presentacion`, `nombre`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Sacos ', 1, '2023-10-06 16:00:27', '2023-11-08 23:41:26', '2023-10-08 02:43:11'),
(2, 'test', 0, '2023-10-08 02:42:59', NULL, '2023-10-08 03:22:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_productos` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `detalles` text NOT NULL,
  `almacen_id` int(11) DEFAULT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_productos`, `nombre`, `precio`, `cantidad`, `categoria_id`, `detalles`, `almacen_id`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Producto A', 10.00, 25, 1, 'prueba de producto', 2, 1, '2023-10-08 01:47:36', NULL, NULL),
(2, 'prueba', 100.00, 15, 2, 'prueba numero dos', 2, 1, '2023-10-08 02:25:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `direccion`, `correo`, `telefono`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'test', 'Jr test', 'test@test.com', '98762345', 0, '2023-10-06 14:14:42', NULL, '2023-10-06 14:45:45'),
(2, 'Gloria ', 'Jr GloriaA', 'leche@gloria.com', '45346436', 1, '2023-10-06 14:31:07', '2023-10-08 01:51:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `id_reserva` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `mesa_id` int(11) NOT NULL,
  `fecha_reservacion` timestamp NULL DEFAULT current_timestamp(),
  `fecha_reserva` date NOT NULL,
  `numero_personas` int(11) NOT NULL,
  `estado_reserva` int(11) NOT NULL COMMENT 'Pendiente, Confirmada,Cancelada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_roles` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_roles`, `nombre`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Administrador ', 1, '2023-10-04 16:42:02', '2023-11-09 13:30:00', NULL),
(2, 'Cajero', 0, '2023-10-04 17:40:20', '2023-11-09 13:31:45', '2023-11-21 03:06:43'),
(3, 'Moso', 1, '2023-10-04 17:50:27', '2023-11-09 13:31:38', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuario`
--

CREATE TABLE `roles_usuario` (
  `id_rol_usuario` int(11) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles_usuario`
--

INSERT INTO `roles_usuario` (`id_rol_usuario`, `rol_id`, `usuario_id`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 1, 1, 1, '2023-11-12 23:13:19', '2023-11-12 23:13:19', NULL),
(2, 3, 3, 1, '2023-11-12 23:13:31', '2023-11-12 23:13:31', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `id_sala` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `mesa` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`id_sala`, `nombre`, `mesa`, `estado`) VALUES
(1, 'Principal', 5, 1),
(2, 'Secundaria', 2, 1),
(3, 'Tercera', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp_pedidos`
--

CREATE TABLE `temp_pedidos` (
  `id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(150) NOT NULL,
  `password_usuario` varchar(150) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `es_activo` int(11) NOT NULL DEFAULT 1,
  `fecha_crea` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `fecha_elimina` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `password_usuario`, `empleado_id`, `es_activo`, `fecha_crea`, `fecha_modi`, `fecha_elimina`) VALUES
(1, 'Chris editado', '123', 1, 1, '2023-09-21 16:30:02', '2023-11-09 17:57:33', '2023-11-09 17:54:05'),
(3, 'luis', '123', 9, 1, '2023-11-09 17:58:46', '2023-11-09 18:13:19', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `asignacion_pedidos_delivery`
--
ALTER TABLE `asignacion_pedidos_delivery`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `delivery_id` (`delivery_id`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_clientes`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle_factura`),
  ADD KEY `factura_id` (`factura_id`),
  ADD KEY `empledo_id` (`empledo_id`),
  ADD KEY `platos_id` (`platos_id`),
  ADD KEY `mesa_id` (`mesa_id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`id_insumos`),
  ADD KEY `presentacion_id` (`presentacion_id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `insumos_ibfk_1` (`almacen_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `insumos_id` (`insumos_id`),
  ADD KEY `productos_id` (`productos_id`),
  ADD KEY `almacen_id` (`almacen_id`);

--
-- Indices de la tabla `inventario_productos`
--
ALTER TABLE `inventario_productos`
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `piso_id` (`piso_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `pedidos_delivery`
--
ALTER TABLE `pedidos_delivery`
  ADD PRIMARY KEY (`id_delivery`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `platos_id` (`platos_id`);

--
-- Indices de la tabla `pisos`
--
ALTER TABLE `pisos`
  ADD PRIMARY KEY (`id_piso`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id_platos`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`id_presentacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_productos`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `almacen_id` (`almacen_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `mesa_id` (`mesa_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`);

--
-- Indices de la tabla `roles_usuario`
--
ALTER TABLE `roles_usuario`
  ADD PRIMARY KEY (`id_rol_usuario`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`id_sala`);

--
-- Indices de la tabla `temp_pedidos`
--
ALTER TABLE `temp_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `asignacion_pedidos_delivery`
--
ALTER TABLE `asignacion_pedidos_delivery`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_clientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `insumos`
--
ALTER TABLE `insumos`
  MODIFY `id_insumos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `pedidos_delivery`
--
ALTER TABLE `pedidos_delivery`
  MODIFY `id_delivery` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pisos`
--
ALTER TABLE `pisos`
  MODIFY `id_piso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `id_platos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles_usuario`
--
ALTER TABLE `roles_usuario`
  MODIFY `id_rol_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `temp_pedidos`
--
ALTER TABLE `temp_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion_pedidos_delivery`
--
ALTER TABLE `asignacion_pedidos_delivery`
  ADD CONSTRAINT `asignacion_pedidos_delivery_ibfk_1` FOREIGN KEY (`delivery_id`) REFERENCES `pedidos_delivery` (`id_delivery`),
  ADD CONSTRAINT `asignacion_pedidos_delivery_ibfk_2` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id_empleado`);

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `detalle_factura_ibfk_2` FOREIGN KEY (`empledo_id`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `detalle_factura_ibfk_3` FOREIGN KEY (`platos_id`) REFERENCES `platos` (`id_platos`),
  ADD CONSTRAINT `detalle_factura_ibfk_4` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id_mesa`);

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id_pedido`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id_clientes`);

--
-- Filtros para la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD CONSTRAINT `insumos_ibfk_1` FOREIGN KEY (`almacen_id`) REFERENCES `almacen` (`id_almacen`),
  ADD CONSTRAINT `insumos_ibfk_2` FOREIGN KEY (`presentacion_id`) REFERENCES `presentacion` (`id_presentacion`),
  ADD CONSTRAINT `insumos_ibfk_3` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`insumos_id`) REFERENCES `insumos` (`id_insumos`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id_productos`),
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`almacen_id`) REFERENCES `almacen` (`id_almacen`);

--
-- Filtros para la tabla `inventario_productos`
--
ALTER TABLE `inventario_productos`
  ADD CONSTRAINT `inventario_productos_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_productos`);

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesas_ibfk_1` FOREIGN KEY (`piso_id`) REFERENCES `pisos` (`id_piso`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id_pedido`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`sala_id`) REFERENCES `platos` (`id_platos`);

--
-- Filtros para la tabla `pedidos_delivery`
--
ALTER TABLE `pedidos_delivery`
  ADD CONSTRAINT `pedidos_delivery_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id_clientes`),
  ADD CONSTRAINT `pedidos_delivery_ibfk_2` FOREIGN KEY (`platos_id`) REFERENCES `platos` (`id_platos`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`almacen_id`) REFERENCES `almacen` (`id_almacen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
