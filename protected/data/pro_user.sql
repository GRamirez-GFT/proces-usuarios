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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`url_product`,`company_id`,`token`) values (1,'Proces - Documentos','/documents',NULL,'1AD5BE0D83DCEFB7'),(2,'Proces - Proyectos','/projects',NULL,'1AD5BE0D1AD5BE0D'),(3,'Proces - Usuarios','/users',NULL,'1AD5BE0D6DD28E9B'),(4,'PROPIO','/propio',1,'1AD5BE0DF3B61B38'),(22,'PRUEBA','/prueba2',1,'1AD5BE0D647E170E');

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

insert  into `product_company`(`product_id`,`company_id`) values (1,1),(2,1),(3,1),(4,1),(22,1);

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

insert  into `product_user`(`user_id`,`product_id`) values (2,1),(2,2),(2,3),(2,4),(2,22);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(72) NOT NULL,
  `company_id` smallint(5) default NULL,
  `active` tinyint(1) NOT NULL COMMENT '0 = Inactivo\n1 = Activo',
  `date_create` date NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `company_user` (`company_id`),
  CONSTRAINT `company_user` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`,`company_id`,`active`,`date_create`) values (1,'Administrador','admin','$2a$08$WMUurR64q1wxOwyTsJYydOSihBHx6dwV74I1N8vhAlfXd3mvU6/9i',NULL,1,'2014-01-01'),(2,'Jorge Gonzalez','endor','$2a$13$UG5xUB6LgHWX2Zy5WKnxP.K.j1dwiJ16t17MijOqf16Em8b4goAlm',1,1,'2014-01-01'),(3,'Rafael J Torres','google','$2a$08$WMUurR64q1wxOwyTsJYydOSihBHx6dwV74I1N8vhAlfXd3mvU6/9i',2,1,'2014-01-01');

/*Table structure for table `user_session` */

DROP TABLE IF EXISTS `user_session`;

CREATE TABLE `user_session` (
  `id` int(11) NOT NULL auto_increment,
  `session` varchar(32) NOT NULL,
  `ipv4` varchar(15) NOT NULL,
  `time_login` timestamp NULL default CURRENT_TIMESTAMP,
  `time_logout` timestamp NULL default NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_user_session` (`user_id`),
  CONSTRAINT `user_user_session` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

/*Data for the table `user_session` */

insert  into `user_session`(`id`,`session`,`ipv4`,`time_login`,`time_logout`,`user_id`) values (72,'4f0b018c6433848e24abfeb5dd7dfced','127.0.0.1','2014-08-01 08:37:16','2014-08-01 08:47:29',1),(73,'c5ec1b692176f6973aa2eb08641582ad','127.0.0.1','2014-08-01 08:47:35',NULL,2),(74,'103e58fa7907dfaac0a1d2cacea5e701','127.0.0.1','2014-08-01 11:08:49',NULL,1),(75,'d2abf0882f36e9eed05317067549d733','127.0.0.1','2014-08-04 11:13:02','2014-08-04 11:18:17',1),(76,'115615a055fd881737bf46169d9c4459','127.0.0.1','2014-08-04 11:18:25',NULL,2),(77,'38d8af66fe6d3185ba116f56a9ab5aa7','127.0.0.1','2014-08-04 12:09:18',NULL,1),(78,'d47aa7599f2f8011a86b4c9ff05294d7','127.0.0.1','2014-08-04 12:29:08',NULL,2),(79,'4ce1ae0a4398fdc429702c637e462597','127.0.0.1','2014-08-04 16:07:57',NULL,1),(80,'a5452ba60f983ee4cf04f953e35afe46','127.0.0.1','2014-08-04 19:19:36',NULL,1),(81,'b598e2c01aeb87375810dae684e3980f','127.0.0.1','2014-08-04 19:33:16','2014-08-04 19:36:59',1),(82,'1824d2a3ae633542f71aa513623892ff','127.0.0.1','2014-08-04 19:37:08','2014-08-04 20:17:52',2),(83,'c55740208fcfa82d61b086d6616956b9','127.0.0.1','2014-08-04 20:17:57','2014-08-04 20:19:08',1),(84,'0bc7643b64f73ca7e14ded1e4260966a','127.0.0.1','2014-08-05 07:00:10',NULL,2),(85,'0f75c306b936c328b1cf7097c08e9552','127.0.0.1','2014-08-05 07:34:22','2014-08-05 07:34:23',1),(86,'06930072bac8eec74db10e12e4a09a1d','127.0.0.1','2014-08-05 07:34:37','2014-08-05 07:38:23',1),(87,'aa2ea1241fef5e1c82efc99559cc1122','127.0.0.1','2014-08-05 07:38:36',NULL,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
