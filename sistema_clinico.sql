-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-09-2026 a las 18:03:24
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
-- Base de datos: `sistema_clinico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `hora_final` time NOT NULL,
  `motivo` text DEFAULT NULL,
  `estado` enum('pendiente','atendida','cancelada') DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `consultorio` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(60) NOT NULL,
  `Logo` varchar(255) NOT NULL,
  `direccion` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `convenciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#ef4444',
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `convenciones`
--

INSERT INTO `convenciones` (`id`, `nombre`, `codigo`, `color`, `descripcion`, `activo`, `created_at`) VALUES
(1, 'Caries', 'CAR', '#ef4444', 'Lesión cariosa activa', 1, '2026-08-17 18:56:00'),
(2, 'Obturado', 'OBT', '#3b82f6', 'Restauración en buen estado', 1, '2026-08-17 18:56:00'),
(3, 'Sellador', 'SEL', '#22c55e', 'Sellador de fotocurado aplicado', 1, '2026-08-17 18:56:00'),
(4, 'Corona', 'COR', '#eab308', 'Prótesis fija o corona existente', 1, '2026-08-17 18:56:00'),
(5, 'Endodoncia', 'ENDO', '#a855f7', 'Tratamiento de conducto realizado', 1, '2026-08-17 18:56:00'),
(6, 'Diente Ausente', 'AUS', '#64748b', 'Pieza dental ausente o extraída', 1, '2026-08-17 18:56:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas_atencion_doctores`
--

CREATE TABLE `fechas_atencion_doctores` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time DEFAULT '08:00:00',
  `hora_fin` time DEFAULT '18:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `historias_clinicas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `motivo_consulta` text NOT NULL,
  `diagnostico` text NOT NULL,
  `tratamiento` text NOT NULL,
  `observaciones` text DEFAULT NULL,
  `acudiente_nombre` varchar(150) DEFAULT NULL,
  `acudiente_documento` varchar(50) DEFAULT NULL,
  `acudiente_parentesco` varchar(50) DEFAULT NULL,
  `firma_base64` longtext DEFAULT NULL,
  `odontograma` longtext DEFAULT NULL,
  `fecha_consulta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `historias_clinicas_base` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `alerta_medica` text DEFAULT NULL,
  `ant_hipertension` varchar(5) DEFAULT 'No',
  `ant_traumas` varchar(5) DEFAULT 'No',
  `ant_cirugias` varchar(5) DEFAULT 'No',
  `ant_hepatitis` varchar(5) DEFAULT 'No',
  `ant_convulsiones` varchar(5) DEFAULT 'No',
  `ant_alergias` varchar(5) DEFAULT 'No',
  `ant_hipoglicemia_diabetes` varchar(5) DEFAULT 'No',
  `ant_gastritis_resp` varchar(5) DEFAULT 'No',
  `ant_t_mentales` varchar(5) DEFAULT 'No',
  `ant_enf_cardiovascular` varchar(5) DEFAULT 'No',
  `ant_cancer` varchar(5) DEFAULT 'No',
  `ant_embarazo` varchar(5) DEFAULT 'No',
  `ant_fiebre_reumatica` varchar(5) DEFAULT NULL,
  `ant_sida` varchar(5) DEFAULT NULL,
  `ant_otras` text DEFAULT NULL,
  `higiene_cepillado` varchar(5) DEFAULT NULL,
  `higiene_cepillado_cant` varchar(50) DEFAULT NULL,
  `higiene_seda` varchar(5) DEFAULT NULL,
  `higiene_seda_cant` varchar(50) DEFAULT NULL,
  `higiene_enjuague` varchar(5) DEFAULT NULL,
  `higiene_enjuague_cant` varchar(50) DEFAULT NULL,
  `higiene_otro` varchar(5) DEFAULT NULL,
  `higiene_otro_cual` varchar(100) DEFAULT NULL,
  `examen_estomatologico` text DEFAULT NULL,
  `acudiente_nombre` varchar(150) DEFAULT NULL,
  `acudiente_documento` varchar(50) DEFAULT NULL,
  `acudiente_parentesco` varchar(50) DEFAULT 'No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `historias_ortodoncia` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `hoja_numero` varchar(50) DEFAULT NULL,
  `fecha_apertura` date DEFAULT NULL,
  `remitido_por` text DEFAULT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `tratamiento_previo_ortodoncia` tinyint(1) DEFAULT 0,
  `tipo_tratamiento` varchar(50) DEFAULT 'CORRECTIVO',
  `tipo_cara` varchar(50) DEFAULT NULL,
  `tipo_sonrisa` varchar(50) DEFAULT NULL,
  `perfil_facial` varchar(50) DEFAULT NULL,
  `tonicidad_labial_sup` varchar(50) DEFAULT NULL,
  `tonicidad_labial_inf` varchar(50) DEFAULT NULL,
  `posicion_labial_sup` varchar(50) DEFAULT NULL,
  `posicion_labial_inf` varchar(50) DEFAULT NULL,
  `frenillo_sobreinsertado_sup` tinyint(1) DEFAULT 0,
  `frenillo_sobreinsertado_inf` tinyint(1) DEFAULT 0,
  `frenillo_sobreinsertado_lat` tinyint(1) DEFAULT 0,
  `frenillo_sobreinsertado_lin` tinyint(1) DEFAULT 0,
  `habito_onicofagia` tinyint(1) DEFAULT 0,
  `habito_respiracion_oral` tinyint(1) DEFAULT 0,
  `habito_succion_digital` tinyint(1) DEFAULT 0,
  `habito_succion_labial` tinyint(1) DEFAULT 0,
  `habito_presion` tinyint(1) DEFAULT 0,
  `habito_alternacion_foniatricas` tinyint(1) DEFAULT 0,
  `deglucion_empuje_lingual_simple` tinyint(1) DEFAULT 0,
  `deglucion_empuje_lingual_complejo` tinyint(1) DEFAULT 0,
  `deglucion_infantil` tinyint(1) DEFAULT 0,
  `bruxismo_diurno` tinyint(1) DEFAULT 0,
  `bruxismo_nocturno` tinyint(1) DEFAULT 0,
  `ruido_cliking` tinyint(1) DEFAULT 0,
  `ruido_crepitacion` tinyint(1) DEFAULT 0,
  `ruidos_articulares_lado` varchar(50) DEFAULT NULL,
  `ruidos_localizacion` varchar(50) DEFAULT NULL,
  `medida_apertura_maxima_mm` decimal(5,2) DEFAULT NULL,
  `medida_lateralidad_derecha_mm` decimal(5,2) DEFAULT NULL,
  `medida_lateralidad_izquierda_mm` decimal(5,2) DEFAULT NULL,
  `desviacion_mandibular_mm` decimal(5,2) DEFAULT NULL,
  `dolor_articular_lado` varchar(50) DEFAULT NULL,
  `dolor_articular_fase` varchar(50) DEFAULT NULL,
  `dolor_muscular_presente` tinyint(1) DEFAULT 0,
  `dolor_muscular_detalle` text DEFAULT NULL,
  `periodonto_disminuido` tinyint(1) DEFAULT 0,
  `periodonto_disminuido_dientes` text DEFAULT NULL,
  `dientes_retenidos_impactados` tinyint(1) DEFAULT 0,
  `dientes_retenidos_dientes` text DEFAULT NULL,
  `dientes_supernumerarios` tinyint(1) DEFAULT 0,
  `dientes_supernumerarios_dientes` text DEFAULT NULL,
  `longitud_radicular_disminuida` tinyint(1) DEFAULT 0,
  `longitud_radicular_disminuida_dientes` text DEFAULT NULL,
  `perfil_esqueletico` varchar(50) DEFAULT NULL,
  `prognatismo_total` varchar(50) DEFAULT NULL,
  `retrognatismo_total` varchar(50) DEFAULT NULL,
  `tipo_crecimiento` varchar(50) DEFAULT NULL,
  `protrusion_alveolar` varchar(50) DEFAULT NULL,
  `retrusion_alveolar` varchar(50) DEFAULT NULL,
  `macrognatismo` varchar(50) DEFAULT NULL,
  `micrognatismo` varchar(50) DEFAULT NULL,
  `cefalometrico_perfil_facial` varchar(50) DEFAULT NULL,
  `proquelia` varchar(50) DEFAULT NULL,
  `retroquelia` varchar(50) DEFAULT NULL,
  `firma_paciente_base64` longtext DEFAULT NULL,
  `firma_doctor_base64` longtext DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `analisis_denticion` varchar(50) DEFAULT NULL,
  `analisis_relacion_derecha_canina` varchar(50) DEFAULT NULL,
  `analisis_relacion_derecha_molar` varchar(50) DEFAULT NULL,
  `analisis_relacion_izquierda_canina` varchar(50) DEFAULT NULL,
  `analisis_relacion_izquierda_molar` varchar(50) DEFAULT NULL,
  `analisis_transversal_mayoral` varchar(50) DEFAULT NULL,
  `analisis_transversal_bogue` varchar(50) DEFAULT NULL,
  `analisis_transversal_paciente` varchar(50) DEFAULT NULL,
  `sobremordida_horizontal` varchar(50) DEFAULT NULL,
  `sobremordida_vertical` varchar(50) DEFAULT NULL,
  `linea_media` varchar(50) DEFAULT NULL,
  `morfologia_arco_superior` varchar(50) DEFAULT NULL,
  `morfologia_arco_inferior` varchar(50) DEFAULT NULL,
  `mordida_cruzada_posterior_der` tinyint(1) DEFAULT 0,
  `mordida_cruzada_posterior_izq` tinyint(1) DEFAULT 0,
  `mordida_cruzada_anterior` tinyint(1) DEFAULT 0,
  `mordida_abierta_anterior` tinyint(1) DEFAULT 0,
  `mordida_abierta_posterior` tinyint(1) DEFAULT 0,
  `linea_media_superior` varchar(50) DEFAULT NULL,
  `linea_media_superior_mm` varchar(20) DEFAULT NULL,
  `linea_media_inferior` varchar(50) DEFAULT NULL,
  `linea_media_inferior_mm` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;



CREATE TABLE `ortodoncia_evoluciones` (
  `id` int(11) NOT NULL,
  `historia_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `descripcion_evolucion` text NOT NULL,
  `valor_evolucion` decimal(12,2) DEFAULT 0.00,
  `radiografia_pdf` varchar(255) DEFAULT NULL,
  `firma_paciente_base64` longtext DEFAULT NULL,
  `fecha_consulta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `genero` enum('masculino','femenino') NOT NULL,
  `tipo_documento` varchar(10) NOT NULL DEFAULT 'CC',
  `documento` varchar(20) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellido`, `genero`, `tipo_documento`, `documento`, `fecha_nacimiento`, `telefono`, `email`, `foto`, `created_at`) VALUES
(1, 'Jhon Mario', 'Chilito Calderon', 'masculino', 'CC', '1004419254', '2003-06-11', '+573144160224', 'whoaomi11@gmail.com', '', '2026-08-17 19:31:53'),
(4, 'Juan Carlos', 'Perdomo', 'masculino', 'TI', '55180321', '2017-03-16', '+573144160224', 'vendedor@sigeve.com', 'paciente_6a848396da476.png', '2026-08-17 19:55:04'),
(6, 'Marina ', 'Recalde', 'masculino', 'CC', '12344556666', '2000-08-17', '', '', 'paciente_6a848687074c4.jpg', '2026-08-18 02:28:07'),
(12, 'Angela Tatiana', 'Chilito Calderón', 'masculino', 'CC', '1083984725', '2006-10-07', '8444090278078', NULL, NULL, '2026-08-19 18:44:43'),
(17, 'Felipe', 'Gómez Cabrera', 'masculino', 'CC', '1082779877', '1996-08-11', '3213096491', '', 'paciente_6a989389b2691.jpeg', '2026-08-20 02:26:19'),
(20, 'Carlos', 'Pérez', 'masculino', 'CC', '1000000001', '1985-04-12', '3101234567', 'carlos.perez1@example.com', NULL, '2026-09-10 17:00:00'),
(21, 'Ana', 'Gómez', 'femenino', 'CC', '1000000002', '1990-07-23', '3209876543', 'ana.gomez2@example.com', NULL, '2026-09-10 17:01:00'),
(22, 'Luis', 'Rodríguez', 'masculino', 'CC', '1000000003', '1978-11-05', '3154567890', 'luis.rodriguez3@example.com', NULL, '2026-09-10 17:02:00'),
(23, 'María', 'López', 'femenino', 'CC', '1000000004', '1995-02-19', '3187654321', 'maria.lopez4@example.com', NULL, '2026-09-10 17:03:00'),
(24, 'Jorge', 'Martínez', 'masculino', 'CC', '1000000005', '1982-09-30', '3112345678', 'jorge.martinez5@example.com', NULL, '2026-09-10 17:04:00'),
(25, 'Lucía', 'Fernández', 'femenino', 'CC', '1000000006', '2000-01-15', '3168765432', 'lucia.fernandez6@example.com', NULL, '2026-09-10 17:05:00'),
(26, 'Andrés', 'García', 'masculino', 'CC', '1000000007', '1988-06-21', '3123456789', 'andres.garcia7@example.com', NULL, '2026-09-10 17:06:00'),
(27, 'Sofía', 'Díaz', 'femenino', 'CC', '1000000008', '1992-12-04', '3179876543', 'sofia.diaz8@example.com', NULL, '2026-09-10 17:07:00'),
(28, 'David', 'Torres', 'masculino', 'CC', '1000000009', '1975-03-11', '3134567890', 'david.torres9@example.com', NULL, '2026-09-10 17:08:00'),
(29, 'Valentina', 'Ruiz', 'femenino', 'CC', '1000000010', '1998-08-25', '3191234567', 'valentina.ruiz10@example.com', NULL, '2026-09-10 17:09:00'),
(30, 'Alejandro', 'Ramírez', 'masculino', 'CC', '1000000011', '1983-05-14', '3145678901', 'alejandro.ramirez11@example.com', NULL, '2026-09-10 17:10:00'),
(31, 'Camila', 'Flores', 'femenino', 'CC', '1000000012', '1991-10-09', '3202345678', 'camila.flores12@example.com', NULL, '2026-09-10 17:11:00'),
(32, 'Mateo', 'Benítez', 'masculino', 'CC', '1000000013', '1980-07-02', '3156789012', 'mateo.benitez13@example.com', NULL, '2026-09-10 17:12:00'),
(33, 'Mariana', 'Acosta', 'femenino', 'CC', '1000000014', '1996-03-28', '3213456789', 'mariana.acosta14@example.com', NULL, '2026-09-10 17:13:00'),
(34, 'Lucas', 'Medina', 'masculino', 'CC', '1000000015', '1979-11-18', '3167890123', 'lucas.medina15@example.com', NULL, '2026-09-10 17:14:00'),
(35, 'Valeria', 'Rojas', 'femenino', 'CC', '1000000016', '1993-06-07', '3224567890', 'valeria.rojas16@example.com', NULL, '2026-09-10 17:15:00'),
(36, 'Gabriel', 'Herrera', 'masculino', 'CC', '1000000017', '1986-01-22', '3178901234', 'gabriel.herrera17@example.com', NULL, '2026-09-10 17:16:00'),
(37, 'Gabriela', 'Castro', 'femenino', 'CC', '1000000018', '1994-09-13', '3235678901', 'gabriela.castro18@example.com', NULL, '2026-09-10 17:17:00'),
(38, 'Daniel', 'Ortiz', 'masculino', 'CC', '1000000019', '1981-04-05', '3189012345', 'daniel.ortiz19@example.com', NULL, '2026-09-10 17:18:00'),
(39, 'Paula', 'Silva', 'femenino', 'CC', '1000000020', '1999-12-20', '3246789012', 'paula.silva20@example.com', NULL, '2026-09-10 17:19:00'),
(40, 'Santiago', 'Jiménez', 'masculino', 'CC', '1000000021', '1984-08-16', '3190123456', 'santiago.jimenez21@example.com', NULL, '2026-09-10 17:20:00'),
(41, 'Daniela', 'Iglesias', 'femenino', 'CC', '1000000022', '1992-02-11', '3257890123', 'daniela.iglesias22@example.com', NULL, '2026-09-10 17:21:00'),
(42, 'Sebastián', 'Vargas', 'masculino', 'CC', '1000000023', '1977-05-29', '3201234567', 'sebastian.vargas23@example.com', NULL, '2026-09-10 17:22:00'),
(43, 'Isabella', 'Mendoza', 'femenino', 'CC', '1000000024', '1997-10-03', '3268901234', 'isabella.mendoza24@example.com', NULL, '2026-09-10 17:23:00'),
(44, 'Nicolás', 'Ríos', 'masculino', 'CC', '1000000025', '1989-03-24', '3212345678', 'nicolas.rios25@example.com', NULL, '2026-09-10 17:24:00'),
(45, 'Sara', 'Navarro', 'femenino', 'CC', '1000000026', '1990-09-17', '3279012345', 'sara.navarro26@example.com', NULL, '2026-09-10 17:25:00'),
(46, 'Samuel', 'Guerrero', 'masculino', 'CC', '1000000027', '1985-11-26', '3223456789', 'samuel.guerrero27@example.com', NULL, '2026-09-10 17:26:00'),
(47, 'Martina', 'Molina', 'masculino', 'CC', '1000000028', '1995-07-08', '3280123456', 'martina.molina28@example.com', NULL, '2026-09-10 17:27:00'),
(48, 'Emiliano', 'Delgado', 'masculino', 'CC', '1000000029', '1982-01-31', '3234567890', 'emiliano.delgado29@example.com', NULL, '2026-09-10 17:28:00'),
(49, 'Victoria', 'Patiño', 'femenino', 'CC', '1000000030', '1994-06-12', '3291234567', 'victoria.patino30@example.com', NULL, '2026-09-10 17:29:00'),
(51, 'Thomas Arango', 'Chavarro', 'masculino', 'TI', '1016053898', '2011-02-25', '3214117525', NULL, NULL, '2026-09-11 21:39:54'),
(52, 'David', 'Trujillo', 'masculino', 'CC', '1163832988', '2000-07-20', '3207893456', NULL, NULL, '2026-09-11 21:40:02'),
(53, 'Juanita', 'Pérez', 'femenino', 'PAS', '151718282828', '1995-05-20', '3105374052', NULL, NULL, '2026-09-11 21:42:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `firma_base64` longtext DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','doctor','auxiliar') NOT NULL DEFAULT 'doctor',
  `especialidad` enum('general','ortodoncia') DEFAULT 'general',
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `ultimo_acceso` datetime DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `foto`, `firma_base64`, `password`, `rol`, `especialidad`, `estado`, `ultimo_acceso`, `creado_en`, `actualizado_en`) VALUES
(1, 'Administrador', 'admin@clinica.com', 'user_6a83968196bfb.png', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAApwAAAB4CAYAAABfASIYAAAQAElEQVR4AeydB7xUxfn3n+Nfo4IKWBCIBRAVexfEAthLrFhij+UTRaPRJCTYwYo9KhgliLFEjV1jFwVEUCECooI0qaFKV0SC+vId3zmeu/de2Hvv2d3Z3V8+zp6ZOefMPOd7ltxnn2eeZ9b4Uf8TAREQAREQAREQAREQgRwSWMP0PxEQAREQgQAISAQREAERKF0CUjhL993qyURABERABERABEQgCAJFpXAGQUxCiIAIiIAIiIAIiIAI1IiAFM4a4dLFIiACIiACZiYIIiACIlAjAlI4a4RLF4uACIiACIiACIiACNSUgBTOmhLL9npdJwIiIAIiIAIiIAIi4AhI4XQY9CECIiACIlCqBPRcIiAChScghbPw70ASiIAIiIAIiIAIiEBJE5DCWdKvN9uH03UiIAIiIAIiIAIikDsCUjhzx1Yji4AIiIAIiEDNCOhqEShRAlI4S/TF6rFEQAREQAREQAREIBQCUjhDeROSI1sCuk4EREAEREAERKDICEjhLLIXJnFFQAREQAREIAwCkkIEsicghTN7VrpSBERABERABERABESgFgSkcNYCmm4RgWwJhH7dN998Y9dcc401bdrUjjrqKJszZ07oIks+ERABERCBIiQghbMIX5pEFoG0CAwbNsxeeOEFmzVrlr322mv2t7/9La2hNY4IiIAIhERAshSYgBTOAr8ATS8ChSQwaNAgmzlzZizCgAED4roqIiACIiACIpAWASmcaZHUOCJQhAQaNmxoa6+99k+Sr/ycMmXKyk/9JwIiIAIiIALpEpDCmS5PjSYCRUVg/vz5tmzZsljmRo0axXVVREAEREAECkOgFGeVwlmKb1XPJAJZEthkk01s3XXXja9u3LhxXFdFBERABERABNIiIIUzLZIaRwSKkMDcuXPt22+/jSVfsmRJXA+7IulEQAREQASKiYAUzmJ6W5JVBFImsOaaa9oaa/z8fwP169dPeQYNJwIiIAIiUNIEsny4n//SZHmDLhMBESgdAlg3V6xYET9QUvmMO1URAREQAREQgToSkMJZR4C6XQSKmQABQ99//338CMuXL4/rqqRGQAOJgAiIQNkTkMJZ9l8BAShnAiibP/74Y4xAUeoxClVEQAREQARSJBCGwpniA2koERCB7AnMmDHD2N7S30HUuq/rKAIiIAIiIAJpEZDCmRZJjSMCRUZg3LhxlfZOT1o7i+xxJG5KBDSMCIiACOSCgBTOXFDVmCJQBATGjx9vpEVKijpr1qxkU3UREAEREAERSIWAFM4aY9QNIlAaBIYMGWKTJk2q8DALFy6s0FZDBERABERABNIgIIUzDYoaQwSKjMDgwYNtwIABtnTp0gqSN2jQoEJbDREImoCEEwERKBoCUjiL5lVJUBFIj8D8+fNt8eLFlQbcYIMNKvWpQwREQAREQATqSkAKZ10Jhn2/pBOBKglMnz69UsAQF0ZRxEFFBERABERABFIlIIUzVZwaTATCJzBt2jTDpT5nzpxKwv7www+V+tQhAiKQBgGNIQLlTUAKZ3m/fz19GRL45JNPbMSIEe7JoyiyKIpcnQ+t4YSCigiIgAiIQNoEpHCmTVTj1ZqAbsw9AXJvPvbYYzZmzBg3WdOmTa1evXquzsfaa6/NQUUEREAEREAEUiUghTNVnBpMBMIlsGzZMhs6dKgrPsH7zjvvbBtuuGEsdJMmTeK6KiIgAmVLQA8uAqkTkMKZOlINKAJhEiDn5jPPPGOTJ092ArZq1cratm1rSTd6Uvl0F+lDBERABERABFIgIIUzBYgaogwJFOEjz5w500aOHBlLftppp1m7du3s//7v/+K+9dZbL66rIgIiIAIiIAJpEZDCmRZJjSMCAROYMGGC3XXXXTZ16lQn5UEHHWRHH320NW/e3JLrNhs3buzO60MEREAEioWA5CwOAlI4i+M9SUoRqDUBdhPq16+fvfbaa26MzTff3Nq3b2/NmjWzNdZYw/X5j3XXXddXdRQBERABERCB1AhU/GuT2rAaSAREIBQCixcvtvfff998oNAuu+xinTp1cgrnihUr4v5Q5JUcIiACIiACpUdACmfpvVM9kQhUILBw4ULr37+/6yMFUps2bWz77bd37V/84hcVrJz/+9//XL8+REAEREAEckCgjIeUwlnGL1+PXvoESIX07rvv2owZM9zD4ko/5ZRTXJ2P77//voKFUy51qKiIgAiIgAikTUAKZ9pENZ4IBERg3rx5dttttzmJ1l9/fdtjjz2MdEiuY+UHazij6OedhnCxr+wu5H+aWwREQAREoAQJSOEswZeqRxIBCOAe79u3r02ZMoWmtW7d2o488sgKW1mSBmmttdZy5/mgzVFFBERABESg3Amk+/xSONPlqdFEIBgCkydPdqmQEAjrJjk3d9ppJ5pxiaKfrZt0RlHFNn0qIiACIiACIlBXAlI460pQ94tAoARwpRMwFEWRtWzZ0s466yzLtGASNJRM/F6/fv1AnyZMsSSVCIiACIhAdgSkcGbHSVeJQFERGDFihPXp08fJ3KhRIzvjjDNs9913d+3kB2s4k23VRUAEREAERCAXBHKscOZCZI0pAiKwOgK9evVyl6BQEiR0zjnnuHbmB9ZNrvH9WDx9XUcREAEREAERSIuAFM60SGocEQiEwOjRo+3xxx930jRs2NAuvvhi22ijjVw78+O7774zUiNl9qtdggT0SCIgAiJQQAJSOAsIX1OLQC4I3HHHHUaEOmPjTj/iiCOoZlWWL1+e1XW6SAREQAREQARqQkAK58+0VBOBoifwySef2Msvv2w//PCDrbnmmnbiiSfaJptskvVzyaWeNSpdGAABvudffPFF/AMrAJEkggiIQDUEpHBWA0bdIlBsBGbOnGkXXnihLViwwInetm1bu/rqq129ug+U0uQaTm8Zre569YtAfgisfhbSfu277762ww47GJb8zz77bPU36QoREIGCEZDCWTD0mlgE0iPAH1sCg4YPH+6sm1tttZU9/fTTldIgZc6YVDY5t/baa3NQEYHgCTz33HM2ceJE933/5ptv7L777gteZgkoAuVMQApnkb59iS0CECDg58UXX7STTz7Z3nrrLWMN5gYbbGDPP/+8NW3alEtWWTItnFGkxO+rBFbGJ//73//a5Zdfbp06dbIBAwYUnMTIkSNt0aJFsRzDhg2L66qIgAiER0AKZ3jvRBLVggCKForXDTfcYLiWazFE0d0yduxY5zK/9NJLbcyYMfbjjz+67SuHDBlimTsKVfdwURSZt3KifEaRFE7T/yoRWLFihaHgYUXkx8zDDz9sc+fOrXRdPjsC+r7m87E1lwgULQEpnEX76iR4kkD//v3t1FNPtWuvvdYOO+ww505eunRp8pKSqbN2rWvXrnbIIYdYjx49bNq0aUawzwUXXGDvvvuubb/99hZFUVbP65VNLsZammzTpyICEMCS+Oabb8YptP7zn//YBx98wKmClW+//TaWByFQijmqiIAIhElACmeY76W0pMrD0xCt6v/gfPrpp3bKKadY48aNbZ999rEuXboYShoWwDyIkpMpeDb+yJ933nnWpk0bu/XWW52iyWREod97771GOiTc6FGUnbLJvUkFEz78EadfRQSSBNZZZx3beuut4y7+vVHijjxXpk+fbrj4+Xfhp54/f76v6igCIhAgASmcAb4UiVRzAu3atbN77rnHCJbB2scIBBJ8+OGHThFr0aKFNWnSxG3x+MADD9jXX3/NJcGXhQsXuvWYRx99tO21117Wt29fmzNnjpO7QYMG1rFjR5fk/dxzz11tgJC7KeMDhbN+/frGjkOc+uqrrzioiEAFAvx74d+S7yQVET/sfDvfx3HjxsXZGPzcPjuDb+tYNQH1ikChCEjhLBR5zZsqAZSviy66yPgj+OSTT9ree+8dK1F+IhS1f/7zn9a5c2fbeOONDSUON6E/X8jjkiVLDNm6rnSVH3vssU4+lEHSvRCk8cYbb8TibbHFFsZa1VGjRjkX+qGHHmprrbVWfL6mlXXXXTdex4lbvab36/rSJ4AlMVOhYynHrFmzCvLwgwYNshkzZlSYu1SX0FR4SDVEoIgJSOEs4pcn0SsTQHk64YQT7L333rO3337bqGPBy7ySLR1feeUVO+qoo6x169Z22WWX2b/+9S+bPXt25qU5aaP8PvHEE3bNNdc49/92221nZ555pnOVk7h93rx5LgjITx5FkYs6Z43q4MGDXbAQiqc/X5cjLLx7FLd6XcbSvaVJAG8BP+aST4eCV4glGMgyevRow/qflIcfaMm26iIgAmERkMIZ1vuQNCkRIJ8k7uannnrKHnzwQSNBNFGtmcNj0SPaG3f8r3/9a2vevLlzy++8887uyPpIgnAI0DnuuOOMwJw//elPLsH6brvt5oJzoiiq9siayksuucSwQu63337WqlUrd+2mm25qp59+ut14440uwIn1aFUpey1atLDjjz/eeI7x48db9+7dbbPNNst8jDq1URq8wlkXS2mdhNDNwRLg+/HCCy8Y6yaTQvLvyS/FSPbnuo5lf8qUKRV+kDEn/6Y4qpQQAT1KSRGQwllSr1MPk0kABQrFjuhtothX9wdy2bJl9uWXXzrXPEfWNJJyqF+/fvbSSy9Z79697c4773RK7MiRIzOnq9TG5dizZ09nbcUySaLqShet7EAuLK2HH3643X333fb+++8bbkxkIA0NeTarstSuvLVO/6Fws7uQV3br1atXp/F0c+kRIEK9V69elR5s6NCh9vnn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', '$2y$10$jUfMG9eRk.ilK/bWqr4d6ep5I.ejS6zsGwEruG7nsQQJXW7FQCELK', 'admin', 'general', 1, '2026-09-10 15:28:11', '2026-08-18 03:16:38', '2026-09-10 15:28:11'),
(7, 'Natalia Anacona', 'anacona@gmail.com', 'user_6a8483c0eadeb.png', 'data:image/png;base64,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', '$2y$10$rk42JyHVl9wzwyOOZfYMKOn.I0JsZN.DACKz16bj7M3fHie4C86Fq', 'doctor', 'ortodoncia', 1, NULL, '2026-08-18 06:22:26', '2026-08-19 21:01:40'),
(8, 'Faddy Guatibonza', 'faddy@gmail.com', 'user_6a8484b3e2339.png', 'data:image/png;base64,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', '$2y$10$gFL.c7BN78kn.mJsNCnfdeuLBCc4WzsyAylGDwsSETUuWsrUXDhH6', 'doctor', 'general', 1, '2026-08-18 15:05:50', '2026-08-18 06:22:59', '2026-08-18 15:05:50'),
(151, 'Ana Gómez', 'ana.gomez@clinica.com', 'ana_gomez.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-09-09 15:30:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(152, 'Luis Torres', 'luis.torres@clinica.com', 'luis_torres.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-09-10 08:15:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(153, 'María Rodríguez', 'maria.rodriguez@clinica.com', 'maria_rodriguez.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-09-08 11:00:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(154, 'Jorge Ramírez', 'jorge.ramirez@clinica.com', 'jorge_ramirez.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-09-07 14:20:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(155, 'Elena Morales', 'elena.morales@clinica.com', 'elena_morales.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-09-10 09:45:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(156, 'Ricardo Castillo', 'ricardo.castillo@clinica.com', 'ricardo_castillo.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-09-06 16:10:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(157, 'Sofía Herrera', 'sofia.herrera@clinica.com', 'sofia_herrera.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-09-05 13:25:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(158, 'Fernando Castro', 'fernando.castro@clinica.com', 'fernando_castro.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-09-04 10:50:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(159, 'Valentina Ríos', 'valentina.rios@clinica.com', 'valentina_rios.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-09-08 17:00:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(160, 'Diego Vargas', 'diego.vargas@clinica.com', 'diego_vargas.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-09-03 12:15:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(161, 'Camila Ortiz', 'camila.ortiz@clinica.com', 'camila_ortiz.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-09-09 11:40:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(162, 'Mateo Silva', 'mateo.silva@clinica.com', 'mateo_silva.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-09-02 09:30:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(163, 'Lucía Navarro', 'lucia.navarro@clinica.com', 'lucia_navarro.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-09-01 16:00:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(164, 'Gabriel Mendoza', 'gabriel.mendoza@clinica.com', 'gabriel_mendoza.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-09-10 07:20:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(165, 'Daniela Rojas', 'daniela.rojas@clinica.com', 'daniela_rojas.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-31 14:50:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(166, 'Alejandro Cruz', 'alejandro.cruz@clinica.com', 'alejandro_cruz.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-30 10:10:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(167, 'Martina Medina', 'martina.medina@clinica.com', 'martina_medina.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-08-29 15:00:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(168, 'Joaquín Romero', 'joaquin.romero@clinica.com', 'joaquin_romero.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-28 11:30:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(169, 'Valeria Flores', 'valeria.flores@clinica.com', 'valeria_flores.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-27 09:00:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(170, 'Emiliano Soto', 'emiliano.soto@clinica.com', 'emiliano_soto.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 0, '2026-08-26 13:40:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(171, 'Renata Paredes', 'renata.paredes@clinica.com', 'renata_paredes.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-25 16:20:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(172, 'Lucas Benítez', 'lucas.benitez@clinica.com', 'lucas_benitez.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-24 10:25:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(173, 'Victoria Acuña', 'victoria.acuna@clinica.com', 'victoria_acuna.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-08-23 14:15:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(174, 'Bruno Espinoza', 'bruno.espinoza@clinica.com', 'bruno_espinoza.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-22 08:50:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(175, 'Antonia Guzmán', 'antonia.guzman@clinica.com', 'antonia_guzman.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-21 12:00:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(176, 'Felipe Campos', 'felipe.campos@clinica.com', 'felipe_campos.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-08-20 17:10:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(177, 'Agustina Molina', 'agustina.molina@clinica.com', 'agustina_molina.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-19 15:35:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(178, 'Maximiliano Vega', 'maximiliano.vega@clinica.com', 'maximiliano_vega.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-18 11:20:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(179, 'Julieta Cordero', 'julieta.cordero@clinica.com', 'julieta_cordero.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-08-17 09:40:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(180, 'Tomás Lagos', 'tomas.lagos@clinica.com', 'tomas_lagos.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-16 14:05:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(181, 'Catalina Fuentes', 'catalina.fuentes@clinica.com', 'catalina_fuentes.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-15 10:55:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(182, 'Ignacio Bravo', 'ignacio.bravo@clinica.com', 'ignacio_bravo.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-08-14 16:30:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(183, 'Emilia Saavedra', 'emilia.saavedra@clinica.com', 'emilia_saavedra.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-13 13:15:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(184, 'Vicente Lara', 'vicente.lara@clinica.com', 'vicente_lara.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-12 08:30:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(185, 'Isabella Ponce', 'isabella.ponce@clinica.com', 'isabella_ponce.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-08-11 11:50:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(186, 'Martín Valenzuela', 'martin.valenzuela@clinica.com', 'martin_valenzuela.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-10 15:20:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(187, 'Trinidad Sepúlveda', 'trinidad.sepulveda@clinica.com', 'trinidad_sepulveda.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-09 10:00:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(188, 'Alonso Donoso', 'alonso.donoso@clinica.com', 'alonso_donoso.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-08-08 14:40:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(189, 'Rafaela Urzúa', 'rafaela.urzua@clinica.com', 'rafaela_urzua.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-07 09:10:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(190, 'Damián Vergara', 'damian.vergara@clinica.com', 'damian_vergara.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-06 12:25:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(191, 'Josefa Orellana', 'josefa.orellana@clinica.com', 'josefa_orellana.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 0, '2026-08-05 16:50:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(192, 'Gaspar Alarcón', 'gaspar.alarcon@clinica.com', 'gaspar_alarcon.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-04 11:05:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(193, 'Amelia Peña', 'amelia.pena@clinica.com', 'amelia_pena.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-08-03 14:30:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(194, 'Cristóbal Letelier', 'cristobal.letelier@clinica.com', 'cristobal_letelier.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-08-02 10:15:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(195, 'Francesca Parra', 'francesca.parra@clinica.com', 'francesca_parra.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-08-01 09:00:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(196, 'Matías Contreras', 'matias.contreras@clinica.com', 'matias_contreras.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-07-31 15:40:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(197, 'Florencia Jaramillo', 'florencia.jaramillo@clinica.com', 'florencia_jaramillo.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'ortodoncia', 1, '2026-07-30 11:25:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(198, 'Benjamín Retamal', 'benjamin.retamal@clinica.com', 'benjamin_retamal.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'auxiliar', 'general', 1, '2026-07-29 13:50:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56'),
(199, 'Maite Salazar', 'maite.salazar@clinica.com', 'maite_salazar.png', NULL, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeF9S3vN3s6fP8N7u3s3s3s3s3s3s3s3s', 'doctor', 'general', 1, '2026-07-28 16:10:00', '2026-09-10 20:31:56', '2026-09-10 15:31:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permisos`
--

CREATE TABLE `usuario_permisos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `modulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_permisos`
--

INSERT INTO `usuario_permisos` (`id`, `usuario_id`, `modulo`) VALUES
(46, 7, 'pacientes'),
(56, 8, 'citas'),
(57, 8, 'citas_editar'),
(54, 8, 'historia'),
(55, 8, 'historia_ortodoncia');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `consultorio`
--
ALTER TABLE `consultorio`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `convenciones`
--
ALTER TABLE `convenciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fechas_atencion_doctores`
--
ALTER TABLE `fechas_atencion_doctores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_doctor_fecha` (`usuario_id`,`fecha`);

--
-- Indices de la tabla `historias_clinicas`
--
ALTER TABLE `historias_clinicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `fk_historias_usuario` (`usuario_id`);

--
-- Indices de la tabla `historias_clinicas_base`
--
ALTER TABLE `historias_clinicas_base`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `paciente_id_2` (`paciente_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `historias_ortodoncia`
--
ALTER TABLE `historias_ortodoncia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ortodoncia_usuario` (`usuario_id`);

--
-- Indices de la tabla `ortodoncia_evoluciones`
--
ALTER TABLE `ortodoncia_evoluciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evo_historia` (`historia_id`),
  ADD KEY `fk_evo_usuario` (`usuario_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuario_permisos`
--
ALTER TABLE `usuario_permisos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`modulo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `consultorio`
--
ALTER TABLE `consultorio`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `convenciones`
--
ALTER TABLE `convenciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `fechas_atencion_doctores`
--
ALTER TABLE `fechas_atencion_doctores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historias_clinicas`
--
ALTER TABLE `historias_clinicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historias_clinicas_base`
--
ALTER TABLE `historias_clinicas_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historias_ortodoncia`
--
ALTER TABLE `historias_ortodoncia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ortodoncia_evoluciones`
--
ALTER TABLE `ortodoncia_evoluciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT de la tabla `usuario_permisos`
--
ALTER TABLE `usuario_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `fechas_atencion_doctores`
--
ALTER TABLE `fechas_atencion_doctores`
  ADD CONSTRAINT `fk_fechas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historias_clinicas`
--
ALTER TABLE `historias_clinicas`
  ADD CONSTRAINT `fk_historias_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `historias_clinicas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historias_ortodoncia`
--
ALTER TABLE `historias_ortodoncia`
  ADD CONSTRAINT `fk_ortodoncia_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ortodoncia_evoluciones`
--
ALTER TABLE `ortodoncia_evoluciones`
  ADD CONSTRAINT `fk_evo_historia` FOREIGN KEY (`historia_id`) REFERENCES `historias_ortodoncia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_evo_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuario_permisos`
--
ALTER TABLE `usuario_permisos`
  ADD CONSTRAINT `usuario_permisos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
