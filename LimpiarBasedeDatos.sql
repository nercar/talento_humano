-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.1.35-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5437
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para politach
DROP DATABASE IF EXISTS `politach`;
CREATE DATABASE IF NOT EXISTS `politach` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `politach`;

-- Volcando estructura para tabla politach.cargos
DROP TABLE IF EXISTS `cargos`;
CREATE TABLE IF NOT EXISTS `cargos` (
  `id` int(10) unsigned NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_empresa` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla politach.conteo_envios
DROP TABLE IF EXISTS `conteo_envios`;
CREATE TABLE IF NOT EXISTS `conteo_envios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_curso` int(10) unsigned NOT NULL,
  `id_departamento` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `intento` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla politach.cursos
DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_desde` date NOT NULL,
  `fecha_hasta` date NOT NULL,
  `horario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tiempo` decimal(4,1) unsigned NOT NULL,
  `enviado` date DEFAULT NULL,
  `id_tipo` int(10) unsigned NOT NULL,
  `origen` int(10) unsigned NOT NULL DEFAULT '1',
  `tipo_medicion` int(1) unsigned NOT NULL DEFAULT '1',
  `entidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orador` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `suspender` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para vista politach.cursos_part
DROP VIEW IF EXISTS `cursos_part`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `cursos_part` (
	`id` INT(10) UNSIGNED NOT NULL,
	`nombre` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`fecha_desde` DATE NOT NULL,
	`fecha_hasta` DATE NOT NULL,
	`enviado` DATE NULL,
	`id_tipo` INT(10) UNSIGNED NOT NULL,
	`estado` INT(11) NOT NULL,
	`suspendido` TINYINT(1) NOT NULL,
	`tipo` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`participantes` BIGINT(21) NULL,
	`asistieron` BIGINT(21) NULL,
	`evaluados` DECIMAL(25,0) NULL,
	`intento` BIGINT(11) NULL,
	`horario` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`tiempo` DECIMAL(4,1) UNSIGNED NOT NULL,
	`origen` INT(10) UNSIGNED NOT NULL,
	`tipo_medicion` INT(1) UNSIGNED NOT NULL,
	`entidad` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`orador` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`total_eval` DOUBLE NULL
) ENGINE=MyISAM;

-- Volcando estructura para tabla politach.departamentos
DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int(10) unsigned NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jefe` int(10) unsigned DEFAULT NULL,
  `id_empresa` int(10) unsigned NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla politach.detalle_cursos
DROP TABLE IF EXISTS `detalle_cursos`;
CREATE TABLE IF NOT EXISTS `detalle_cursos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_curso` int(10) unsigned NOT NULL,
  `id_empleado` int(10) unsigned NOT NULL,
  `evaluado` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `asistio` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `motivo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_motivo` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla politach.empleados
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int(10) unsigned NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cargo` int(10) unsigned NOT NULL,
  `id_departamento` int(10) unsigned NOT NULL,
  `id_empresa` int(10) unsigned NOT NULL,
  `activo` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla politach.empresas
DROP TABLE IF EXISTS `empresas`;
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `directorio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla politach.evaluar_cursos
DROP TABLE IF EXISTS `evaluar_cursos`;
CREATE TABLE IF NOT EXISTS `evaluar_cursos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `id_tipo` int(10) unsigned NOT NULL,
  `id_curso` int(10) unsigned NOT NULL,
  `id_empleado` int(10) unsigned NOT NULL,
  `id_pregunta` int(11) unsigned NOT NULL,
  `respuesta` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla politach.jefes_departamentos
DROP TABLE IF EXISTS `jefes_departamentos`;
CREATE TABLE IF NOT EXISTS `jefes_departamentos` (
  `id` int(10) unsigned NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Login en intranet vieja',
  `cargo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Correo para enviar notificacion de la evaluación pendiente',
  `activo` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Esta tabla sirve por el momento para poder eenlazar los usuarios jefes de la intranet vieja con los departamento de TH, para poder determinar al momento de loguearse el jefe cual o cuales departamentos están a su mando. y así poder listar sólo los empleados de sus áreas al momento de evaluar.';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para vista politach.participantescursos
DROP VIEW IF EXISTS `participantescursos`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `participantescursos` (
	`nomemp` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`apeemp` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`cedula` INT(10) UNSIGNED NOT NULL,
	`nomcar` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`id_curso` INT(10) UNSIGNED NULL,
	`estado` INT(11) NOT NULL,
	`empresa` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`id_departamento` INT(10) UNSIGNED NOT NULL,
	`id_jefe` INT(10) UNSIGNED NULL,
	`departamento` VARCHAR(150) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`reenviado` DATE NULL,
	`intentos` BIGINT(11) NULL,
	`evaluado` TINYINT(1) UNSIGNED NULL,
	`asistio` TINYINT(1) UNSIGNED NULL,
	`motivo` VARCHAR(10) NULL COLLATE 'utf8mb4_unicode_ci',
	`fecha_motivo` DATE NULL,
	`total_eval` DOUBLE NULL
) ENGINE=MyISAM;

-- Volcando estructura para vista politach.cursos_part
DROP VIEW IF EXISTS `cursos_part`;
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `cursos_part`;
CREATE ALGORITHM=UNDEFINED DEFINER=`politach`@`localhost` SQL SECURITY DEFINER VIEW `cursos_part` AS select `c`.`id` AS `id`,`c`.`nombre` AS `nombre`,`c`.`fecha_desde` AS `fecha_desde`,`c`.`fecha_hasta` AS `fecha_hasta`,`c`.`enviado` AS `enviado`,`c`.`id_tipo` AS `id_tipo`,`c`.`estado` AS `estado`,`c`.`suspender` AS `suspendido`,`t`.`nombre` AS `tipo`,(select count(`dc`.`id_curso`) from (`detalle_cursos` `dc` join `empleados` `e` on(((`e`.`id` = `dc`.`id_empleado`) and (`e`.`activo` <> 0)))) where (`dc`.`id_curso` = `c`.`id`)) AS `participantes`,(select count(`dc`.`asistio`) from `detalle_cursos` `dc` where ((`dc`.`asistio` <> 0) and (`dc`.`id_curso` = `c`.`id`))) AS `asistieron`,(select sum(`dc`.`evaluado`) from `detalle_cursos` `dc` where (`dc`.`id_curso` = `c`.`id`)) AS `evaluados`,(select `ce`.`intento` from `conteo_envios` `ce` where ((`ce`.`id_curso` = `c`.`id`) and (`ce`.`activo` <> 0)) limit 1) AS `intento`,`c`.`horario` AS `horario`,`c`.`tiempo` AS `tiempo`,`c`.`origen` AS `origen`,`c`.`tipo_medicion` AS `tipo_medicion`,`c`.`entidad` AS `entidad`,`c`.`orador` AS `orador`,(select sum(`ec`.`respuesta`) from `evaluar_cursos` `ec` where ((`ec`.`id_curso` = `c`.`id`) and (`ec`.`id_pregunta` between 3 and 7))) AS `total_eval` from (`cursos` `c` join `tipos` `t` on((`t`.`id` = `c`.`id_tipo`))) group by `c`.`id`,`c`.`nombre`,`c`.`fecha_desde`,`c`.`fecha_hasta`,`c`.`enviado`,`c`.`id_tipo`,`c`.`estado`,`t`.`nombre`,`c`.`suspender`,`c`.`horario`,`c`.`tiempo`,`c`.`tipo_medicion`,`c`.`entidad`,`c`.`origen`,`c`.`orador` order by `c`.`id`;

-- Volcando estructura para vista politach.participantescursos
DROP VIEW IF EXISTS `participantescursos`;
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `participantescursos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`politach`@`localhost` SQL SECURITY DEFINER VIEW `participantescursos` AS select `e`.`nombre` AS `nomemp`,`e`.`apellido` AS `apeemp`,`e`.`id` AS `cedula`,`c`.`nombre` AS `nomcar`,`d`.`id_curso` AS `id_curso`,`t`.`estado` AS `estado`,`f`.`nombre` AS `empresa`,`o`.`id` AS `id_departamento`,`o`.`id_jefe` AS `id_jefe`,`o`.`nombre` AS `departamento`,(select `s`.`fecha` from `conteo_envios` `s` where ((`s`.`id_curso` = `d`.`id_curso`) and (`s`.`id_departamento` = `o`.`id`) and (`s`.`activo` <> 0))) AS `reenviado`,(select `s`.`intento` from `conteo_envios` `s` where ((`s`.`id_curso` = `d`.`id_curso`) and (`s`.`id_departamento` = `o`.`id`) and (`s`.`activo` <> 0))) AS `intentos`,`d`.`evaluado` AS `evaluado`,`d`.`asistio` AS `asistio`,`d`.`motivo` AS `motivo`,`d`.`fecha_motivo` AS `fecha_motivo`,(case when (`t`.`tipo_medicion` = 2) then (select sum(`ec`.`respuesta`) from `evaluar_cursos` `ec` where ((`ec`.`id_curso` = `d`.`id_curso`) and (`ec`.`id_empleado` = `e`.`id`) and (`ec`.`id_pregunta` between 1 and 6))) else (select sum(`ec`.`respuesta`) from `evaluar_cursos` `ec` where ((`ec`.`id_curso` = `d`.`id_curso`) and (`ec`.`id_empleado` = `e`.`id`) and (`ec`.`id_pregunta` between 3 and 7))) end) AS `total_eval` from (((((`empleados` `e` join `cargos` `c` on((`c`.`id` = `e`.`id_cargo`))) join `empresas` `f` on(((`f`.`id` = `e`.`id_empresa`) and (`c`.`id_empresa` = `f`.`id`)))) join `departamentos` `o` on(((`o`.`id` = `e`.`id_departamento`) and (`o`.`id_empresa` = `f`.`id`)))) left join `detalle_cursos` `d` on((`d`.`id_empleado` = `e`.`id`))) join `cursos` `t` on((`t`.`id` = `d`.`id_curso`))) where (`e`.`activo` = 1) order by `f`.`nombre`,`o`.`nombre`,`e`.`nombre`,`e`.`apellido`;

-- Volcando estructura para tabla politach.tipos
DROP TABLE IF EXISTS `tipos`;
CREATE TABLE IF NOT EXISTS `tipos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla politach.tipos: ~3 rows (aproximadamente)
DELETE FROM `tipos`;
/*!40000 ALTER TABLE `tipos` DISABLE KEYS */;
INSERT INTO `tipos` (`id`, `nombre`, `activo`, `created_at`, `updated_at`) VALUES
  (1, 'Gestión ISO', 1, NULL, NULL),
  (2, 'Ocupacional', 1, NULL, NULL),
  (3, 'Inducción', 1, NULL, NULL);
/*!40000 ALTER TABLE `tipos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
