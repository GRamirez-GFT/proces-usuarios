/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.0.91-community-nt : Database - pro_user
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` smallint(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `subdomain` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL COMMENT '0 = Inactivo\n1 = Activo',
  `date_create` date NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `subdomain` (`subdomain`),
  KEY `user_company` (`user_id`),
  CONSTRAINT `user_company` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `company` */

insert  into `company`(`id`,`name`,`subdomain`,`user_id`,`active`,`date_create`) values (1,'Grupo Endor','endor',2,1,'2014-01-01'),(2,'Google','google',3,1,'2014-07-29');

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` smallint(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `url_product` varchar(255) default NULL,
  `company_id` smallint(5) default NULL,
  `token` varchar(16) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `company_product` (`company_id`),
  CONSTRAINT `company_product` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`url_product`,`company_id`,`token`) values (1,'Proces - Documentos','/documents',NULL,'1AD5BE0D83DCEFB7'),(2,'Proces - Proyectos','/projects',NULL,'1AD5BE0D1AD5BE0D'),(3,'PROPIO','/propio',1,'1AD5BE0DF3B61B38'),(4,'A','A',NULL,'83DCEFB784B12BAE'),(5,'PRUEBA','/prueba2',1,'1AD5BE0D647E170E');

/*Table structure for table `product_company` */

DROP TABLE IF EXISTS `product_company`;

CREATE TABLE `product_company` (
  `product_id` smallint(5) NOT NULL,
  `company_id` smallint(5) NOT NULL,
  PRIMARY KEY  (`product_id`,`company_id`),
  KEY `product_product_company` (`product_id`),
  KEY `company_product_company` (`company_id`),
  CONSTRAINT `company_product_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `product_product_company` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `product_company` */

insert  into `product_company`(`product_id`,`company_id`) values (1,1),(2,1),(3,1),(4,1),(5,1);

/*Table structure for table `product_user` */

DROP TABLE IF EXISTS `product_user`;

CREATE TABLE `product_user` (
  `user_id` int(11) NOT NULL,
  `product_id` smallint(5) NOT NULL,
  PRIMARY KEY  (`user_id`,`product_id`),
  KEY `user_product_user` (`user_id`),
  KEY `product_product_user` (`product_id`),
  CONSTRAINT `product_product_user` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `user_product_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `product_user` */

insert  into `product_user`(`user_id`,`product_id`) values (2,1),(4,1),(5,1),(6,1),(2,2),(4,2),(2,3),(4,3),(6,3);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(72) NOT NULL,
  `email` varchar(100) default NULL,
  `company_id` smallint(5) default NULL,
  `active` tinyint(1) NOT NULL COMMENT '0 = Inactivo\n1 = Activo',
  `date_create` date NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `company_user` (`company_id`),
  CONSTRAINT `company_user` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`,`email`,`company_id`,`active`,`date_create`) values (1,'Administrador','admin','$2a$08$WMUurR64q1wxOwyTsJYydOSihBHx6dwV74I1N8vhAlfXd3mvU6/9i',NULL,NULL,1,'2014-01-01'),(2,'Jorge Gonzalez','endor','$2a$13$PAthe2Xhq1zfUeWXmvAFCeISo57lD3azDCS0hRgph2V15Pt.AClEW','jgonzalez@grupoendor.com',1,1,'2014-01-01'),(3,'Rafael J Torres','rafael','$2a$08$WMUurR64q1wxOwyTsJYydOSihBHx6dwV74I1N8vhAlfXd3mvU6/9i','rafaelt88@gmail.com',2,1,'2014-01-01'),(4,'Dummy','dummy','$2a$13$ZoXJXdI4RRRy1BYReuO97.RN57UXztTLsWOTeJf9itV40HlYU/HWK','rafaelt88@gmail.com',1,1,'2014-08-06'),(5,'prueba','prueba','$2a$13$RoBhjDZjuOBWOBc1NmYss.bjQwxeZyGOeOB/yg2GyxTuO7L.mqnYq','prueba@prueba.com',1,1,'2014-08-12'),(6,'pedro','pedro','$2a$13$LSizp0cqyLB9Z/A3gvA3KeBNL/bJ0ip690zNzqSuUvCJVwIwRKPbi','',1,1,'2014-08-18');

/*Table structure for table `user_session` */

DROP TABLE IF EXISTS `user_session`;

CREATE TABLE `user_session` (
  `id` int(11) NOT NULL auto_increment,
  `session` varchar(32) NOT NULL,
  `ipv4` varchar(15) NOT NULL,
  `time_login` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `time_logout` timestamp NULL default NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_user_session` (`user_id`),
  CONSTRAINT `user_user_session` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

/*Data for the table `user_session` */

insert  into `user_session`(`id`,`session`,`ipv4`,`time_login`,`time_logout`,`user_id`) values (72,'4f0b018c6433848e24abfeb5dd7dfced','127.0.0.1','2014-08-01 08:37:16','2014-08-01 08:47:29',1),(73,'c5ec1b692176f6973aa2eb08641582ad','127.0.0.1','2014-08-01 08:47:35',NULL,2),(74,'103e58fa7907dfaac0a1d2cacea5e701','127.0.0.1','2014-08-01 11:08:49',NULL,1),(75,'d2abf0882f36e9eed05317067549d733','127.0.0.1','2014-08-04 11:13:02','2014-08-04 11:18:17',1),(76,'115615a055fd881737bf46169d9c4459','127.0.0.1','2014-08-04 11:18:25',NULL,2),(77,'38d8af66fe6d3185ba116f56a9ab5aa7','127.0.0.1','2014-08-04 12:09:18',NULL,1),(78,'d47aa7599f2f8011a86b4c9ff05294d7','127.0.0.1','2014-08-04 12:29:08',NULL,2),(79,'4ce1ae0a4398fdc429702c637e462597','127.0.0.1','2014-08-04 16:07:57',NULL,1),(80,'a5452ba60f983ee4cf04f953e35afe46','127.0.0.1','2014-08-04 19:19:36',NULL,1),(81,'b598e2c01aeb87375810dae684e3980f','127.0.0.1','2014-08-04 19:33:16','2014-08-04 19:36:59',1),(82,'1824d2a3ae633542f71aa513623892ff','127.0.0.1','2014-08-04 19:37:08','2014-08-04 20:17:52',2),(83,'c55740208fcfa82d61b086d6616956b9','127.0.0.1','2014-08-04 20:17:57','2014-08-04 20:19:08',1),(84,'0bc7643b64f73ca7e14ded1e4260966a','127.0.0.1','2014-08-05 07:00:10',NULL,2),(85,'0f75c306b936c328b1cf7097c08e9552','127.0.0.1','2014-08-05 07:34:22','2014-08-05 07:34:23',1),(86,'06930072bac8eec74db10e12e4a09a1d','127.0.0.1','2014-08-05 07:34:37','2014-08-05 07:38:23',1),(87,'aa2ea1241fef5e1c82efc99559cc1122','127.0.0.1','2014-08-05 07:38:36',NULL,2),(88,'cd84d55e59c35fd17b431512e1bcc540','127.0.0.1','2014-08-05 21:18:21',NULL,1),(89,'c359dfd166f7c24fa364260ad48e0a56','127.0.0.1','2014-08-05 21:18:50','2014-08-05 21:20:17',1),(90,'88f72039499a9c89469a7da7d75778b3','127.0.0.1','2014-08-05 21:20:24',NULL,2),(91,'392d0acd742adf72627e8aa16dd13bfd','127.0.0.1','2014-08-06 06:42:38',NULL,1),(92,'59fa69cf63afd2a7441e68cb5c951738','127.0.0.1','2014-08-06 07:53:08',NULL,2),(93,'07a6c2851e4fa4bc50f0afc58f242a6b','127.0.0.1','2014-08-06 07:57:55',NULL,1),(94,'a9ea51bdc59b683a2ae82f51e4f14292','127.0.0.1','2014-08-06 20:37:36','2014-08-06 20:38:13',2),(95,'47532cb4382e1dcaaecd73487d82a5ab','127.0.0.1','2014-08-06 20:38:19','2014-08-06 20:42:04',4),(96,'d0d9a04644cfe510b0e6125a62de40fb','127.0.0.1','2014-08-06 20:42:13','2014-08-06 20:47:46',4),(97,'c38d4146967b654b71b8c6300c4abb08','127.0.0.1','2014-08-06 20:48:33',NULL,2),(98,'1464824b045f9e2b34ab2396eb03d6a7','186.95.243.141','2014-08-06 21:00:02','2014-08-06 21:07:14',4),(99,'415a81fe30a33c8b60ce3d07aa778693','186.95.243.141','2014-08-06 21:07:20','2014-08-06 21:10:31',1),(100,'3366728c2035d003d0f0219297345598','186.95.243.141','2014-08-06 21:10:40','2014-08-06 21:13:29',4),(101,'0f6d465de913f9e9edea1b4e98987527','186.95.243.141','2014-08-06 21:13:44','2014-08-06 21:14:49',2),(102,'e9a480fae2caa4bd04fd0b1fad8456f5','186.95.243.141','2014-08-06 21:15:01','2014-08-06 21:16:11',4),(103,'9feeff87a683b9cb444fd8226ceecfca','186.95.243.141','2014-08-06 21:16:20','2014-08-06 21:16:28',4),(104,'831b2bb4ea5e56f449b12188d5d9cbec','186.95.243.141','2014-08-06 21:16:49','2014-08-06 21:18:51',4),(105,'46f12336af367333b4c5675e4c4d6105','186.95.243.141','2014-08-06 21:19:01',NULL,4),(106,'c9389e7c7bc3d47e542d7df511705914','187.155.122.34','2014-08-06 21:25:54',NULL,4),(107,'81b6f74a8c9df3bdb047458923771b23','127.0.0.1','2014-08-07 09:31:12',NULL,2),(108,'ab52935fe289d4f6f2145a297067543d','127.0.0.1','2014-08-07 21:00:27',NULL,2),(109,'c30b98f096f8929b5d41140b196cb07e','127.0.0.1','2014-08-08 07:57:30',NULL,2),(110,'5ac35707960ae42d814e91b0403e539c','127.0.0.1','2014-08-08 11:25:09',NULL,2),(111,'9b18ef3245b5503e393388f5681a9834','127.0.0.1','2014-08-09 06:53:45',NULL,2),(112,'041eea56f5526be20ccf43842d61680e','127.0.0.1','2014-08-09 06:53:54',NULL,1),(113,'8ba8e716af3f48c2bfe93fb5303803dc','127.0.0.1','2014-08-09 07:56:55',NULL,2),(114,'1d620efa3b2585103ed8a126788d66ae','127.0.0.1','2014-08-09 08:41:15',NULL,2),(115,'fbc7a0dc6ce03e4621332197e771770d','127.0.0.1','2014-08-09 09:43:47',NULL,1),(116,'afbbf8514b281f89daad0a1d166941c8','127.0.0.1','2014-08-12 20:37:30',NULL,2),(117,'9a87d8457b6a4cf81af15dec9fad0b2f','127.0.0.1','2014-08-12 21:40:22',NULL,2),(118,'4063606bfb1dad8d4b306a5ad5bd90b9','127.0.0.1','2014-08-14 21:44:51',NULL,2),(119,'18be3795f825e8a58ed6f3376791a401','192.168.1.100','2014-08-14 22:35:11',NULL,2),(120,'07c08fe7b862467eb5ececdabd2c7c60','127.0.0.1','2014-08-15 06:38:37',NULL,2),(121,'92edeeae153a8b0fe2ddb210548ba109','127.0.0.1','2014-08-15 09:40:50',NULL,2),(122,'10721fbaf2be238cfbb15324de7bf794','127.0.0.1','2014-08-15 10:58:59',NULL,2),(123,'8ca5f13a25ca64e0e4eaa4a1bccb126e','127.0.0.1','2014-08-15 17:58:37',NULL,2),(124,'9f3a2f5f3e8190fe5e93708f0686c1a9','127.0.0.1','2014-08-18 10:37:20',NULL,2),(125,'f54aca8284f999a17f8d4740c13f54ee','127.0.0.1','2014-08-18 11:31:29',NULL,4),(126,'741ace6bd2d2585545a24b1d02b9fd0b','127.0.0.1','2014-08-18 11:33:46',NULL,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
