-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: proyecto_inda
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.31-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id_cliente` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `numero_cliente` varchar(45) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `nss` varchar(11) NOT NULL,
  `curp` varchar(25) NOT NULL,
  `afore` varchar(25) NOT NULL,
  `asesor` varchar(25) NOT NULL,
  `sc` int(6) unsigned NOT NULL,
  `sd` int(6) unsigned NOT NULL,
  `fb` date NOT NULL,
  `sbc` decimal(15,2) unsigned NOT NULL,
  `alta` date NOT NULL,
  `dias_transcurridos` date NOT NULL,
  `comentarios` varchar(250) NOT NULL,
  `id_oficina` int(11) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `id_usuario` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `nss_UNIQUE` (`nss`),
  UNIQUE KEY `numero_cliente_UNIQUE` (`numero_cliente`),
  KEY `id_ubicacion_fkc_idx` (`id_oficina`),
  KEY `id_usuario_fkc_idx` (`id_usuario`),
  CONSTRAINT `id_oficina_fkc` FOREIGN KEY (`id_oficina`) REFERENCES `oficina` (`id_oficina`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_fkc` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (3,'11111','usuariio de prueba','asdkjaskdj','234324324','sñdjadsl','aoñdjalñdñsjl','sdfljasdjsald',3433,234,'2020-07-17',55555.00,'2020-07-20','2020-09-05','rpobando alta',1,1,1,'2020-07-31 02:05:01','2020-08-12 00:00:25'),(6,'111112','alsdknads','asdkjaskdj','2343243243','sñdjadsl','aoñdjalñdñsjl','sdfljasdjsald',3433,234,'2020-07-17',0.00,'2020-07-20','0000-00-00','rpobando alta',1,1,1,'2020-07-31 02:07:16',NULL),(7,'3333','344','3434','233','234234','234234','234234',234234,0,'2020-08-03',234234.00,'2020-08-03','0000-00-00','234234',1,1,1,'2020-08-03 23:47:00',NULL),(8,'N123213','CARLOS','POOT','342342332','ASDNB234','SDLJFADJK','WDLKJNAKSN',3,3,'2020-08-05',222.00,'2020-08-04','2020-09-20','ES UNA PRUEBA',1,0,1,'2020-08-04 23:57:14','2020-08-12 00:55:01'),(9,'QWLEKJQWE','ALKDLAKD','ADLKJKD','12345678934','ASDKJNADNN','WLDKNKD','LKDNKANDSK',3,3,'2020-08-05',1.50,'2020-08-05','2020-09-21','PRUEBAA',1,0,1,'2020-08-05 00:00:42','2020-08-12 00:54:31'),(10,'52725278','EDITADO','APELLIDOO E','3812937444','SJK232KWSJ2ED','SDJ3E23EJEE','ADKASDKJ3KEJM',423215,2324235,'2020-08-12',234234.00,'0000-00-00','0000-00-00','PROABNDOOO EDITANDO',1,3,1,'2020-08-10 23:54:05','2020-08-11 01:25:10'),(11,'USUARIO MERIDA','NOMBRE','APELLIDO MERIDA','32394234293','Q39U4234LK','MERISAAA','A MESIRA',234234,23423,'2020-08-06',123123.00,'0000-00-00','0000-00-00','PRUEBA USUAERIO DE MERIDA',2,1,2,'2020-08-12 00:19:12',NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id_menu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Usuario','Menu para gestionar usuarios',NULL,NULL);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_opcion`
--

DROP TABLE IF EXISTS `menu_opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_opcion` (
  `id_menu_opcion` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) DEFAULT NULL,
  `id_opcion` int(11) DEFAULT NULL,
  `orden` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_menu_opcion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_opcion`
--

LOCK TABLES `menu_opcion` WRITE;
/*!40000 ALTER TABLE `menu_opcion` DISABLE KEYS */;
INSERT INTO `menu_opcion` VALUES (1,1,1,1),(2,1,2,2);
/*!40000 ALTER TABLE `menu_opcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_rol`
--

DROP TABLE IF EXISTS `menu_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_rol` (
  `id_menu_rol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_menu` int(10) unsigned NOT NULL,
  `id_rol` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_menu_rol`),
  KEY `id_menu_fkmr_idx` (`id_menu`),
  KEY `id_rol_fkmr_idx` (`id_rol`),
  CONSTRAINT `id_menu_fkmr` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_rol_fkmr` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_rol`
--

LOCK TABLES `menu_rol` WRITE;
/*!40000 ALTER TABLE `menu_rol` DISABLE KEYS */;
INSERT INTO `menu_rol` VALUES (1,1,1);
/*!40000 ALTER TABLE `menu_rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oficina`
--

DROP TABLE IF EXISTS `oficina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oficina` (
  `id_oficina` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_oficina`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oficina`
--

LOCK TABLES `oficina` WRITE;
/*!40000 ALTER TABLE `oficina` DISABLE KEYS */;
INSERT INTO `oficina` VALUES (1,'CALKINI',1,'2020-07-14 23:58:12',NULL),(2,'MERIDA',1,'2020-07-14 23:58:12',NULL),(3,'CAMPECHE',1,'2020-07-14 23:58:12',NULL),(4,'CIUDAD DEL CARMEN',1,'2020-07-14 23:58:12',NULL);
/*!40000 ALTER TABLE `oficina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcion_menu`
--

DROP TABLE IF EXISTS `opcion_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcion_menu` (
  `id_opcion_menu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `vista` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `controlador` varchar(45) DEFAULT NULL,
  `controlador_src` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_opcion_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcion_menu`
--

LOCK TABLES `opcion_menu` WRITE;
/*!40000 ALTER TABLE `opcion_menu` DISABLE KEYS */;
INSERT INTO `opcion_menu` VALUES (1,'Alta usuario','AltaUsuario.html','/alta-usuario','altaUsuarioController','AltaUsuarioController.js'),(2,'Consulta usuario','ConsultaUsuario.html','/consulta-usuario','consultaUsuarioController','ConsultaUsuarioController.js');
/*!40000 ALTER TABLE `opcion_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id_rol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Jefe de oficina','2020-06-12 00:09:02'),(2,'JEFE','2020-08-12 00:21:05'),(3,'OFICINA CENTRAL','2020-08-12 00:21:32');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol_usuario`
--

DROP TABLE IF EXISTS `rol_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol_usuario` (
  `id_rol_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_rol` int(10) unsigned NOT NULL,
  `id_usuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_rol_usuario`),
  KEY `id_rol_fkru_idx` (`id_rol`),
  KEY `id_usuario_fk_ru_idx` (`id_usuario`),
  CONSTRAINT `id_rol_fkru` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario_fk_ru` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_usuario`
--

LOCK TABLES `rol_usuario` WRITE;
/*!40000 ALTER TABLE `rol_usuario` DISABLE KEYS */;
INSERT INTO `rol_usuario` VALUES (1,1,1),(2,1,2),(3,2,1);
/*!40000 ALTER TABLE `rol_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_oficina` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_ubicacion_ufk_idx` (`id_oficina`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Carlos Poot','cpoot','bc47b81b3f1d88f66720beb8f15b02595b48557e',1,'2020-06-22 00:08:32',1),(2,'Usuario merida','merida','bc47b81b3f1d88f66720beb8f15b02595b48557e',1,'2020-08-12 00:17:38',2);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'proyecto_inda'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-14 11:03:12
