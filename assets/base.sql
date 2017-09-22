/*
SQLyog Community v12.16 (64 bit)
MySQL - 5.5.45 : Database - fede20c_3deF
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varbinary(255) NOT NULL,
  `activa` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `categorias` */

insert  into `categorias`(`id`,`nombre`,`activa`) values 
(1,'Veredas y calles',1),
(2,'Limpieza',1),
(3,'Espacios verdes y arboleda',1),
(4,'Mobiliario vía pública',1),
(5,'Luminaria',1);

/*Table structure for table `imagenes` */

DROP TABLE IF EXISTS `imagenes`;

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_reportes` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reportes` (`id_reportes`),
  KEY `id_usuarios` (`id_usuarios`),
  CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`id_reportes`) REFERENCES `reportes` (`id`),
  CONSTRAINT `imagenes_ibfk_2` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `imagenes` */

/*Table structure for table `keys` */

DROP TABLE IF EXISTS `keys`;

CREATE TABLE `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `keys` */

/*Table structure for table `reportes` */

DROP TABLE IF EXISTS `reportes`;

CREATE TABLE `reportes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `lng` float(10,6) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `direccion` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `texto` text COLLATE utf8_bin,
  `titulo` text COLLATE utf8_bin,
  `imagen` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` int(1) DEFAULT '0' COMMENT '¿Estados? 0-sin probar 1- Abierto 2-En proceso 3-Fin',
  `fecha_cierre` datetime DEFAULT NULL,
  `sub_categoria` int(11) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_categoria` (`sub_categoria`),
  KEY `categoria` (`categoria`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`sub_categoria`) REFERENCES `sub_categorias` (`id`),
  CONSTRAINT `reportes_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`),
  CONSTRAINT `reportes_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `reportes` */

insert  into `reportes`(`id`,`id_usuario`,`lng`,`lat`,`direccion`,`texto`,`titulo`,`imagen`,`fecha`,`estado`,`fecha_cierre`,`sub_categoria`,`categoria`) values 
(29,8,-58.600658,-34.564690,'Río Jáchal 788, B1657CFD Loma Hermosa, Buenos Aires, Argentina','Basura sin recolectar','Problemas con la Basura',NULL,'2015-12-01 19:08:31',1,NULL,NULL,2),
(31,9,-58.585888,-34.583542,'Campo de Mayo 258','Bache en la calle','Bache',NULL,'2015-12-01 19:10:27',1,NULL,NULL,2),
(32,10,-58.597446,-34.575912,'Av. Bernabe Marquez, B1657CTN Loma Hermosa, Buenos Aires, Argentina','Verada rota','Vereda rota',NULL,'2015-12-01 19:12:04',1,NULL,NULL,4),
(33,11,-58.609501,-34.559994,'Gral. Pico 9699-9799, El Libertador, Buenos Aires, Argentina','Calle rota','Otro reporte',NULL,'2015-12-01 20:07:52',1,NULL,NULL,1),
(34,12,-58.601654,-34.581001,'Av. Bernabe Marquez 2065, Pablo Podesta, Buenos Aires, Argentina','calle cortada','Calle cortada',NULL,'2015-12-01 20:29:45',0,NULL,NULL,1),
(35,13,-58.570583,-34.612442,'Dr. Rebizzo 5165, B1678BDA Caseros, Buenos Aires, Argentina','Sin resolver','Problema',NULL,'2015-12-01 21:09:39',3,NULL,NULL,2),
(36,14,-58.602879,-34.570969,'Gabino Ezeiza 8826-8898, B1657AJP Loma Hermosa, Buenos Aires, Argentina','Falta cartel de Stop','Falta señalamiento',NULL,'2015-12-02 20:12:10',1,NULL,NULL,1),
(37,15,-58.595840,-34.580860,'Panamá 7700-7798, B1683AQF Martín Coronado, Buenos Aires, Argentina','Es un problema','Problema',NULL,'2015-12-03 01:21:32',1,NULL,NULL,2),
(38,16,-58.587086,-34.587574,'Panamá 6626-6698, B1683APJ Martín Coronado, Buenos Aires, Argentina','Mas','Más titulo',NULL,'2015-12-03 01:24:27',1,NULL,NULL,4),
(39,17,-58.561680,-34.598526,'Av. Libertador Gral. San Martín 1825, B1678GPH Caseros, Buenos Aires, Argentina','mil','Pol',NULL,'2015-12-03 01:41:47',1,NULL,NULL,1),
(40,18,-58.552364,-34.613731,'Bartolomé Mitre 3844, B1678AUW Caseros, Buenos Aires, Argentina','Cante','Mila',NULL,'2015-12-03 01:44:05',1,NULL,NULL,2),
(41,19,-58.546040,-34.613667,'chiclana 100','basura','Basura',NULL,'2015-12-03 01:45:13',1,NULL,NULL,2),
(42,20,-58.591030,-34.602268,'De las Tipas 2800-2898, B1684BUH Cdad. Jardin Lomas de Palomar, Buenos Aires, Argentina','Otra vereda','Vereda Rota',NULL,'2015-12-03 01:47:38',1,NULL,NULL,4),
(43,21,-58.584938,-34.592945,'José C. Crotto 6054, B1683AXF Martín Coronado, Buenos Aires, Argentina','Calle, mila','Calle roto',NULL,'2015-12-03 02:05:15',3,NULL,NULL,1),
(44,22,-58.620213,-34.572380,'Luis Ángel Firpo 9735, B1689AJI Remedios de Escalada de San Martin, Buenos Aires, Argentina','Mas basura','Otro Reporte',NULL,'2015-12-03 02:11:10',1,NULL,NULL,2),
(45,22,-58.615582,-34.579376,'Luis Ángel Firpo, Pablo Podesta, Buenos Aires, Argentina','Calle','La firpo',NULL,'2015-12-03 02:39:47',1,NULL,NULL,1),
(46,23,-58.544514,-34.632008,'Au Acceso Oeste, Ciudadela, Buenos Aires, Argentina','Dos autos chocaron','Choque',NULL,'2015-12-03 14:26:59',1,NULL,NULL,1),
(47,24,-58.573608,-34.602341,'Juan Bautista Alberdi 5300-5398, B1678CLT Caseros, Buenos Aires, Argentina','Mira la foto','Reporte con foto',NULL,'2015-12-03 14:36:09',1,NULL,NULL,2),
(48,25,-58.577728,-34.587078,'Ascasubi 5809-5899, B1682AFC Villa Bosch, Buenos Aires, Argentina','Otra foto','Con foto',NULL,'2015-12-03 14:39:08',2,NULL,NULL,4),
(49,26,-58.557384,-34.621765,'Gral. Villegas 4302-4400, B1678BXD Caseros, Buenos Aires, Argentina','foto','Mas fotos',NULL,'2015-12-03 14:51:56',1,NULL,NULL,4),
(50,27,-58.538158,-34.598171,'Juan Bautista Anchordoqui 1084, B1674AZH Sáenz Peña, Buenos Aires, Argentina','Des','Otro',NULL,'2015-12-03 14:56:25',1,NULL,NULL,1),
(51,28,-58.621845,-34.557323,'Miramar 1399-1499, B1691AHA Churruca, Buenos Aires, Argentina','otra foro','Foto',NULL,'2015-12-03 14:58:32',3,NULL,NULL,2),
(52,29,-58.590431,-34.589764,'Pres. Juan Domingo Perón 6697, Martín Coronado, Buenos Aires, Argentina','Con foto','Otro título',NULL,'2015-12-03 15:00:18',1,NULL,NULL,2),
(53,30,-58.605453,-34.585876,'Av. Bernabe Marquez, Martín Coronado, Buenos Aires, Argentina','foto','Con foto','56604c618992c.jpg','2015-12-03 15:06:25',3,NULL,NULL,1),
(54,31,-58.596523,-34.600220,'Aviador Tte. Benjamín Matienzo 2867-2899, B1684DJH Cdad. Jardin Lomas de Palomar, Buenos Aires, Argentina','server foto','Con foto','56604cafa34a7.jpg','2015-12-03 11:07:43',1,NULL,NULL,2),
(55,32,-58.590389,-34.574993,'Juan XXIII 1009, B1682BEI Villa Bosch, Buenos Aires, Argentina','verde','Mi reporte verde',NULL,'2015-12-04 16:30:53',1,NULL,NULL,3),
(56,33,-58.599144,-34.590260,'Paracaidista Roca 2202-2300, Cdad. Jardin Lomas de Palomar, Buenos Aires, Argentina','Mi reporte con foto','Otro verde con foto','5661ea1f63bc9.jpg','2015-12-04 16:31:43',1,NULL,NULL,3),
(57,34,-58.612362,-34.569695,'Soldado Hector Caballero 9500-9598, Remedios de Escalada de San Martin, Buenos Aires, Argentina','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','Reporte del sitio nuevo',NULL,'2015-12-07 13:41:05',1,NULL,NULL,4),
(58,35,-58.537689,-34.639351,'Ohiggins 2-100, B1702FHB Ciudadela, Buenos Aires, Argentina','esto es un gracuias','Gracias por tordo','5665bde740d83.png','2015-12-07 14:12:07',1,NULL,NULL,2),
(59,36,-58.545155,-34.639774,'Av. Maipú 2913, Ciudadela, Buenos Aires, Argentina','Aca va una descript','Ahora con png to jpg','5665c35ae2ff9.png','2015-12-07 14:35:23',1,NULL,NULL,1),
(60,37,-58.541378,-34.639988,'Av Rivadavia 12526-12598, Ciudadela, Buenos Aires, Argentina','test','Png img thumb','5665c4b77b485.png','2015-12-07 14:41:11',1,NULL,NULL,3),
(61,38,-58.533569,-34.639492,'Av Rivadavia 9, Ciudadela, Buenos Aires, Argentina','asdasdasd','asdasd','5665c5a29405a','2015-12-07 14:45:06',3,NULL,NULL,4),
(62,38,-58.547558,-34.639492,'Av. Maipú 4373, Ciudadela, Buenos Aires, Argentina','11321321','La vencida?º',NULL,'2015-12-07 14:47:32',1,NULL,NULL,2),
(63,38,-58.540092,-34.635822,'Av. Juan B. Justo 3818, B1702AIV Ciudadela, Buenos Aires, Argentina','asdasd','cascasd','5665c749892f3.png','2015-12-07 14:52:09',1,NULL,NULL,3),
(64,39,-58.613346,-34.587502,'Tambo Nuevo 399-449, Hurlingham, Buenos Aires, Argentina','descriot','Mi titulo','5665cda66bbd2.png','2015-12-07 15:19:18',3,NULL,NULL,2),
(65,40,-58.601849,-34.594498,'Aviador Fredes 7118, B1684ANJ Cdad. Jardin Lomas de Palomar, Buenos Aires, Argentina','21321','2131',NULL,'2015-12-07 15:24:33',2,NULL,NULL,1),
(66,41,-58.572792,-34.623039,'Catriló 5241, B1678CAY Caseros, Buenos Aires, Argentina','Falta luz','Liminaria',NULL,'2015-12-07 21:12:36',2,NULL,NULL,5),
(67,42,-58.562321,-34.604603,'Valentín Gómez 4699, B1678ABG Caseros, Buenos Aires, Argentina','luz','No more luz','5666217c3dcc6.gif','2015-12-07 21:17:00',3,NULL,NULL,5),
(68,43,-58.572193,-34.592308,'Marco Polo 5300-5398, Villa Bosch, Buenos Aires, Argentina','luminarioa','luz',NULL,'2015-12-07 21:17:44',2,NULL,NULL,5),
(69,44,-58.543869,-34.636028,'9 de julio e Italia, ciudadela','Hay un bache entre 9 de julio e Italia','Bache',NULL,'2015-12-11 12:43:50',1,NULL,NULL,1),
(70,45,-58.569225,-34.594639,'Fray Justo Sta María de Oro 5109-5149, B1678DGO Caseros, Buenos Aires, Argentina','Foto grande','Otro reporte','566f2431f1ad5.jpg','2015-12-14 17:18:58',1,NULL,NULL,3),
(71,46,-58.580555,-34.595417,'Pres. Juan Domingo Perón 5791-5849, Caseros, Buenos Aires, Argentina','Mas','Otro','566f2483e79af.jpg','2015-12-14 17:20:21',1,NULL,NULL,4),
(72,47,-58.582527,-34.598103,'Aviadora Carola Lorenzini 2240, B1684BRB Cdad. Jardin Lomas de Palomar, Buenos Aires, Argentina','oiopiopiopi','poipoi','566f270351ed7.jpg','2015-12-14 17:31:00',1,NULL,NULL,3),
(73,48,-58.582874,-34.600574,'Juan Bautista Alberdi 5201, B1678CLQ Caseros, Buenos Aires, Argentina','asdasd','Otra foro','566f292db3561.jpg','2015-12-14 17:40:14',1,NULL,NULL,3);

/*Table structure for table `sub_categorias` */

DROP TABLE IF EXISTS `sub_categorias`;

CREATE TABLE `sub_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_bin NOT NULL,
  `activa` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `sub_categorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `sub_categorias` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `sub_categorias` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(60) NOT NULL,
  `user_date` datetime NOT NULL,
  `user_modified` datetime NOT NULL,
  `user_last_login` datetime DEFAULT NULL,
  `ci_session_id` varchar(40) NOT NULL,
  `voluntario` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`user_id`,`user_email`,`user_pass`,`user_date`,`user_modified`,`user_last_login`,`ci_session_id`,`voluntario`) values 
(2,'fede','$2a$08$u6SmdjwGz4uol8Ci4m8VXeSbVE9WmtbdHswssneDzFlth1L7x247y','2015-12-03 18:11:41','2015-12-03 18:11:41','2015-12-08 15:45:53','',0);

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `apellido` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `dni` int(8) NOT NULL,
  `genero` int(1) NOT NULL COMMENT '1-F 2-M',
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `celular` int(10) DEFAULT NULL,
  `celular_area` int(4) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_actualizacion` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id`,`nombre`,`apellido`,`dni`,`genero`,`email`,`celular`,`celular_area`,`fecha_creacion`,`fecha_actualizacion`) values 
(8,'Carlos','Milo',21546789,1,'milo@carlos.com.iu',58450000,11,'2015-12-01 19:05:37','2015-12-01 19:08:55'),
(9,'Jose','Kis',11589632,1,'mi@correo.com',12328547,11,'2015-12-01 19:10:27','2015-12-01 19:10:27'),
(10,'Lina','Des',2155888,2,'poline@lop.com.yt',1325585,11,'2015-12-01 19:12:04','2015-12-01 19:12:04'),
(11,'Jacinta','Pol',125555666,1,'ja@a.pol.io',88885555,11,'2015-12-01 20:07:52','2015-12-01 20:07:52'),
(12,'Juan','Sik',2147483647,1,'cas@oplli.kki.a',25581,11,'2015-12-01 20:29:45','2015-12-01 20:29:45'),
(13,'Sin resolver','Problema',1122558,1,'cas@poll.com',222522,11,'2015-12-01 21:09:38','2015-12-01 21:09:38'),
(14,'Juan','Esmil',12555885,1,'jj@killlo.com',12331233,22,'2015-12-02 20:12:10','2015-12-02 20:12:10'),
(15,'Nombre','Apellido',54789789,1,'cas@milas.com',125521,55,'2015-12-03 01:21:31','2015-12-03 01:21:31'),
(16,'Néstor','R',123,1,'cas@pol.com',1235,11,'2015-12-03 01:24:27','2015-12-03 01:24:27'),
(17,'Néstor','R',256985,1,'pol@com.ar',12345678,11,'2015-12-03 01:41:47','2015-12-03 01:41:47'),
(18,'Lopez','Poli',21255656,1,'a@a.com',515,11,'2015-12-03 01:44:05','2015-12-03 01:44:05'),
(19,'Bol','Loe',12555888,1,'a@a.com',1552212,11,'2015-12-03 01:45:13','2015-12-03 01:45:13'),
(20,'T','s',121,1,'c@a.com',123123,22,'2015-12-03 01:47:38','2015-12-03 01:47:38'),
(21,'Fede','Tres',1256569,1,'cas@as.com',2155,11,'2015-12-03 02:05:15','2015-12-03 02:05:15'),
(22,'a','a',1,1,'a@a.com',1,1,'2015-12-03 02:11:10','2015-12-03 02:39:47'),
(23,'Jose','Frente',12558996,1,'cas@allo.com',7878978,88,'2015-12-03 14:26:59','2015-12-03 14:26:59'),
(24,'Juan','Seba',25698698,1,'faster@han.com',125125,11,'2015-12-03 14:36:09','2015-12-03 14:36:09'),
(25,'Juan','Res',2122235,1,'a@p.com',12341234,11,'2015-12-03 14:39:08','2015-12-03 14:39:08'),
(26,'Ros','Ter',25123434,1,'lo@lo.com',1233123,11,'2015-12-03 14:51:55','2015-12-03 14:51:55'),
(27,'Néstor','f',121222,1,'c@a.com',221222,21,'2015-12-03 14:56:25','2015-12-03 14:56:25'),
(28,'Néstor','R',125125,1,'a@a.com',123123,11,'2015-12-03 14:58:32','2015-12-03 14:58:32'),
(29,'ALos','Teros',12365985,1,'a@a.com',123312,11,'2015-12-03 15:00:18','2015-12-03 15:00:18'),
(30,'F','F',1155552,1,'a@al.com',558212,11,'2015-12-03 15:06:25','2015-12-03 15:06:25'),
(31,'F','F',112255,1,'a@al.com',125125,11,'2015-12-03 11:07:43','2015-12-03 11:07:43'),
(32,'Fede','R',12551215,1,'a@as.com',12331233,11,'2015-12-04 16:30:53','2015-12-04 16:30:53'),
(33,'Juli','Ant',25698744,1,'pol@a.com',1231115,11,'2015-12-04 16:31:43','2015-12-04 16:31:43'),
(34,'Jacinto','Recontinco',25986698,1,'mil@a.com',55852365,11,'2015-12-07 13:41:05','2015-12-07 13:41:05'),
(35,'Nombre','Otro',31582125,1,'cas@a.com',215568,11,'2015-12-07 14:12:07','2015-12-07 14:12:07'),
(36,'Javier','Ruil',1255558,1,'a@a.com',2252121,11,'2015-12-07 14:35:23','2015-12-07 14:35:23'),
(37,'asa','asd',2562563,1,'cas@a.com',1256321,11,'2015-12-07 14:41:11','2015-12-07 14:41:11'),
(38,'21312','cas',1231232,1,'cas@a.com',12312322,22,'2015-12-07 14:45:06','2015-12-07 14:52:09'),
(39,'Pol','Sil',12589632,1,'cas@a.com',12561256,11,'2015-12-07 15:19:18','2015-12-07 15:19:18'),
(40,'2123','1321',12341234,1,'a@a.com',12341234,12,'2015-12-07 15:24:33','2015-12-07 15:24:33'),
(41,'Jas','Ras',1255854,1,'a@lope.com',1125256,111,'2015-12-07 21:12:36','2015-12-07 21:12:36'),
(42,'Pol','Lop',31589632,1,'a@a.com',12521258,11,'2015-12-07 21:17:00','2015-12-07 21:17:00'),
(43,'asd','aee',1256322,1,'a@s.com',1233123,22,'2015-12-07 21:17:44','2015-12-07 21:17:44'),
(44,'Lu','Bonifacio',32867441,1,'lucianaabonifacio@gmail.com',25671902,11,'2015-12-11 12:43:50','2015-12-11 12:43:50'),
(45,'Juan','Re',21555222,1,'cas@a.com',1231232,11,'2015-12-14 17:18:58','2015-12-14 17:18:58'),
(46,'Car','Pel',213333,1,'a@a.com',125555,112,'2015-12-14 17:20:21','2015-12-14 17:20:21'),
(47,'kajd','kjlkasd',1231522,1,'ca@a.com',1231515,11,'2015-12-14 17:31:00','2015-12-14 17:31:00'),
(48,'Casa','asda',213155,1,'cas@a.com',12351235,11,'2015-12-14 17:40:14','2015-12-14 17:40:14');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
