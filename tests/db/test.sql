/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;

INSERT INTO `PlanesDeCuentas` VALUES (2,NULL,'ACTIVOS','1.00.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (3,2,'ACTIVO CORRIENTE','1.01.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (4,3,'DISPONIBILIDADES','1.01.01.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (5,4,'CAJA Y BANCOS','1.01.01.01.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (6,5,'CAJAS','1.01.01.01.01.00',0,0,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (27,3,'CREDITOS','1.01.02.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (28,27,'CUENTAS POR COBRAR POR VENTAS','1.01.02.01.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (29,28,'CLIENTES','1.01.02.01.01.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (30,28,'ANTICIPO PROVEEDORES','1.01.02.01.02.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (31,28,'COBRANZAS EXPORTACIONES','1.01.02.01.03.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (32,27,'OTRAS CUENTAS POR COBRAR','1.01.02.02.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (53,3,'BIENES DE CAMBIO','1.01.03.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (54,53,'MERCADERIAS','1.01.03.01.00.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (56,3,'INVERSIONES','1.01.04.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (57,56,'TITULOS Y ACCIONES','1.01.04.01.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (61,56,'OTRAS INVERSIONES','1.01.04.02.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (68,2,'ACTIVO NO CORRIENTE','1.02.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (69,68,'CREDITOS','1.02.01.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (70,69,'CUENTAS POR COBRAR','1.02.01.01.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (73,68,'BIENES DE USO','1.02.02.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (74,73,'RODADOS','1.02.02.01.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (77,73,'MAQUINAS Y HERRAMIENTAS','1.02.02.02.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (80,73,'MUEBLES Y UTILES DE OFICINA','1.02.02.03.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (83,73,'MUEBLES Y UTILES TALLER','1.02.02.04.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (86,73,'INSTALACIONES','1.02.02.05.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (89,73,'CONSTRUCCION INMUEBLES','1.02.02.06.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (92,73,'TERRENOS','1.02.02.07.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (94,73,'HERAMIENTAS MENORES','1.02.02.08.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (95,NULL,'PASIVO','2.00.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (96,95,'PASIVO CORRIENTE','2.01.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (97,96,'DEUDAS','2.01.01.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (98,97,'COMERCIALES','2.01.01.01.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (99,98,'PROVEEDORES','2.01.01.01.01.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (102,98,'ANTICIPO DE CLIENTES','2.01.01.01.04.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (107,97,'FISCALES','2.01.01.02.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (108,107,'IVA DEBITO FISCAL','2.01.01.02.01.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (117,97,'SOCIALES','2.01.01.03.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (122,97,'BANCARIAS','2.01.01.04.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (124,97,'OTRAS DEUDAS','2.01.01.05.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (126,NULL,'PATRIMONIO NETO','3.00.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (127,126,'CAPITAL Y RESERVAS','3.01.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (128,127,'CAPITAL','3.01.01.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (129,128,'CAPITAL SOCIAL','3.01.01.01.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (132,127,'RESERVAS','3.01.02.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (133,132,'RESERVAS LEGALES','3.01.02.01.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (135,126,'CUENTAS SOCIOS','3.02.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (136,135,'CUENTAS SOCIOS','3.02.01.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (137,136,'CUENTAS PARTICULARES','3.02.01.01.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (140,NULL,'RESULTADOS','4.00.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (141,140,'GANANCIAS','4.01.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (142,141,'GANANCIAS','4.01.01.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (143,142,'VENTAS','4.01.01.01.00.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (146,142,'OTROS INGRESOS','4.01.01.02.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (166,140,'PERDIDAS','4.02.00.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (167,166,'COSTOS','4.02.01.00.00.00',0,0,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (168,167,'COSTO BIENES DE CAMBIO','4.02.01.01.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (184,166,'GASTOS','4.02.02.00.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (185,184,'ADMINISTRACION','4.02.02.01.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (200,184,'COMERCIALIZACION','4.02.02.02.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (211,184,'FINANCIEROS','4.02.02.03.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (217,184,'OTROS GASTOS','4.02.02.04.00.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (236,200,'DESCUENTOS CONCEDIDOS','4.02.02.02.01.00',0,1,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (239,167,'SERVICIOS','4.02.01.01.00.00',0,0,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (240,239,'ENERGIA ELECTRICA','4.02.01.01.01.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (241,239,'TELEFONIA','4.02.01.01.02.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (242,239,'SERVICIOS DE INTERNET','4.02.01.01.03.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (243,69,'OTROS CREDITOS','1.02.01.02.00.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (245,243,'IVA CREDITO FISCAL','1.02.01.02.01.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (280,107,'RETENCIONES','2.01.01.02.02.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (281,107,'PERCEPCIONES','2.01.01.02.03.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (282,280,'RETENCION GANANCIA','2.01.01.02.02.01',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (283,280,'RETENCION IVA','2.01.01.02.02.02',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (284,280,'RETENCION SUSS','2.01.01.02.02.03',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (285,280,'RETENCION IB BS.AS.','2.01.01.02.02.04',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (286,280,'RETENCION IB CORDOBA','2.01.01.02.02.05',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (287,280,'RETENCION IB MENDOZA','2.01.01.02.02.06',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (288,280,'RETENCION IB SANTA FE','2.01.01.02.02.07',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (289,243,'RETENCIONES','1.02.01.02.02.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (290,243,'PERCEPCIONES','1.02.01.02.03.00',0,0,NULL,0);
INSERT INTO `PlanesDeCuentas` VALUES (291,289,'RETENCION GANANCIA','1.02.01.02.02.01',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (292,289,'RETENCION IVA','1.02.01.02.02.02',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (293,289,'RETENCION SUSS','1.02.01.02.02.03',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (294,289,'RETENCION IB BS.AS.','1.02.01.02.02.04',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (295,289,'RETENCION IB CORDOBA','1.02.01.02.02.05',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (296,289,'RETENCION IB MENDOZA','1.02.01.02.02.06',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (297,289,'RETENCION IB SANTA FE','1.02.01.02.02.07',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (298,290,'PERCEPCION IVA P2','1.02.01.02.03.01',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (299,290,'PERCEPCION IB CAP. FEDERAL','1.02.01.02.03.02',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (300,290,'PERCEPCION IB BS.AS.','1.02.01.02.03.03',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (301,290,'PERCEPCION IB CORRIENTES','1.02.01.02.03.04',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (302,290,'PERCEPCION IB MENDOZA','1.02.01.02.03.05',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (303,290,'PERCEPCION IB SANTA FE','1.02.01.02.03.06',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (305,281,'PERCEPCION IVA P2','2.01.01.02.03.01',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (306,281,'PERCEPCION IB CAP. FEDERAL','2.01.01.02.03.02',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (307,281,'PERCEPCION IB BS.AS.','2.01.01.02.03.03',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (308,281,'PERCEPCION IB CORRIENTES','2.01.01.02.03.04',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (309,281,'PERCEPCION IB MENDOZA','2.01.01.02.03.05',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (310,281,'PERCEPCION IB SANTA FE','2.01.01.02.03.06',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (311,243,'IMPUESTOS INTERNOS','1.02.01.02.04.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (312,107,'IMPUESTOS INTERNOS','2.01.01.02.04.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (313,28,'CUENTAS A COBRAR','1.01.02.01.04.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (316,6,'CAJA CHICA','1.01.01.01.01.01',1,0,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (317,6,'CAJA GENERAL','1.01.01.01.01.02',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (318,5,'BANCOS','1.01.01.01.02.00',0,0,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (319,318,'BANCOS GENERAL','1.01.01.01.02.01',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (320,5,'RECAUDACIONES A DEPOSITAR','1.01.01.01.03.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (321,289,'RETENCION OTRAS','1.02.01.02.02.08',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (322,280,'RETENCION OTRA','2.01.01.02.02.08',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (323,184,'GASTOS BANCARIOS','4.02.02.05.00.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (324,243,'OTROS IMPUESTOS','1.02.01.02.05.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (325,107,'OTROS IMPUESTOS','2.01.01.02.05.00',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (326,289,'RETENCION IB JUJUY','1.02.01.02.02.09',0,1,NULL,1);
INSERT INTO `PlanesDeCuentas` VALUES (327,280,'RETENCION IB JUJUY','2.01.01.02.02.09',0,1,NULL,1);
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

INSERT INTO `Cajas` VALUES (1,'Caja 1',6,1);
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

INSERT INTO `GruposDeUsuariosRoles` VALUES (1,1,4);
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

INSERT INTO `Usuarios` VALUES (1,'admin','admvida12','Administrador',1);
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

INSERT INTO `GruposDeUsuarios` VALUES (1,'Administrador');
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

INSERT INTO `AreasDeTrabajos` VALUES (1,'Producción');
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
