CREATE TABLE `tiposdealicuotasymontosnoimponibles` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Codigo` int(11) NOT NULL,
  `Descripcion` text NOT NULL,
  `PorcentajeARetenerInscriptos` decimal(10,2) DEFAULT NULL,
  `PorcentajeARetenerNoInscriptos` decimal(10,2) EFAULT NULL,
  `MontosNoSujetosARetencion` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8


INSERT INTO vidalac.tiposdealicuotasymontosnoimponibles (Id,Codigo,Descripcion,PorcentajeARetenerInscriptos,PorcentajeARetenerNoInscriptos,MontosNoSujetosARetencion) VALUES
(1,78,'Enajenación de bienes muebles y bienes de cambio.',2.00,10,224000.00),
(2,30,'Alquileres o arrendamientos de bienes muebles.',6.00,28,11200.00),
(3,94,'Locaciones de obra y/o servicios no ejecutados en relación de dependencia no mencionados expresamente en otros incisos',2.00,28,67170.00),
(4,95,'Operaciones de transporte de carga nacional e internacional.',0.25,28,67170.00);