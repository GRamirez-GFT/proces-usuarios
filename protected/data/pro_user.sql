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
/*Table structure for table `action` */

DROP TABLE IF EXISTS `action`;

CREATE TABLE `action` (
  `id` smallint(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `controller_id` smallint(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `controller_action` (`controller_id`),
  KEY `action_id` (`id`),
  CONSTRAINT `controller_action` FOREIGN KEY (`controller_id`) REFERENCES `controller` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `action` */

/*Table structure for table `action_user` */

DROP TABLE IF EXISTS `action_user`;

CREATE TABLE `action_user` (
  `action_id` smallint(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`action_id`,`user_id`),
  KEY `user_action_user` (`user_id`),
  KEY `action_action_user` (`action_id`),
  CONSTRAINT `action_action_user` FOREIGN KEY (`action_id`) REFERENCES `action` (`id`),
  CONSTRAINT `user_action_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `action_user` */

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` smallint(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `subdomain` varchar(30) default NULL,
  `active` tinyint(1) NOT NULL COMMENT '0 = Inactivo\n1 = Activo',
  `date_create` date NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `company_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `company` */

insert  into `company`(`id`,`name`,`subdomain`,`active`,`date_create`) values (1,'Grupo Endor','endor',1,'2014-01-01');

/*Table structure for table `controller` */

DROP TABLE IF EXISTS `controller`;

CREATE TABLE `controller` (
  `id` smallint(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `url_controller` varchar(255) default NULL,
  `product_id` smallint(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `product_controller` (`product_id`),
  KEY `controller_id` (`id`),
  CONSTRAINT `product_controller` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `controller` */

insert  into `controller`(`id`,`name`,`url_controller`,`product_id`) values (1,'TestController','/test',1);

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` smallint(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `url_product` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `product_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`url_product`) values (1,'Proces - Proyectos','/projects');

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

/*Table structure for table `product_user` */

DROP TABLE IF EXISTS `product_user`;

CREATE TABLE `product_user` (
  `user_id` int(11) NOT NULL,
  `user_type_id` smallint(5) NOT NULL,
  PRIMARY KEY  (`user_id`,`user_type_id`),
  KEY `user_product_user` (`user_id`),
  KEY `user_type_product_user` (`user_type_id`),
  CONSTRAINT `user_type_product_user` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`),
  CONSTRAINT `user_product_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `product_user` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(72) NOT NULL,
  `active` tinyint(1) NOT NULL COMMENT '0 = Inactivo\n1 = Activo',
  `date_create` date NOT NULL,
  `company_id` smallint(5) default NULL,
  PRIMARY KEY  (`id`),
  KEY `company_user` (`company_id`),
  KEY `user_id` (`id`),
  CONSTRAINT `company_user` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`,`active`,`date_create`,`company_id`) values (1,'Administrador','admin','$2a$13$Gyk9xo2JZP/UlyuBGZnWTOOodJMCkGOTdxvsp6DYQrwF3QR3ZJhJu',1,'2014-01-01',1);

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
  KEY `user_session_id` (`id`),
  CONSTRAINT `user_user_session` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

/*Data for the table `user_session` */

insert  into `user_session`(`id`,`session`,`ipv4`,`time_login`,`time_logout`,`user_id`) values (15,'367462099e72ba94884bd8e6cc585c45','127.0.0.1','2014-07-17 08:10:24',NULL,1),(16,'63cc1056e1c9ea95d9d25374561bdecd','127.0.0.1','2014-07-17 08:10:35','2014-07-17 07:49:46',1),(17,'dcefa5e0cef5d08265c2e9b88c1b8f30','127.0.0.1','2014-07-17 20:44:50',NULL,1),(18,'535084e2303e91e0ca5824a6f3eb6613','127.0.0.1','2014-07-17 20:46:49','2014-07-17 20:54:13',1),(19,'cbc8ef1f47612a0f57c099104a424522','127.0.0.1','2014-07-17 20:47:02','2014-07-17 20:24:02',1),(20,'ecc8160555149f12725e16f5d68eb030','127.0.0.1','2014-07-17 20:54:16','2014-07-17 20:55:32',1),(21,'462e17b833416d504cff62f96dda4289','127.0.0.1','2014-07-25 09:43:55',NULL,1),(22,'cb9c07e66d51cc724792ce9a0cc5f101','127.0.0.1','2014-07-25 16:08:15','2014-07-25 16:29:58',1),(23,'ab19922a43f9af61d04f7abdc5486e10','127.0.0.1','2014-07-25 16:30:14',NULL,1),(24,'1445f0711501bfb3f0b3f5186ddfa519','127.0.0.1','2014-07-25 17:53:28','2014-07-25 17:53:58',1),(25,'1c45c61c627b7f30c2dbadb17122b1ae','127.0.0.1','2014-07-25 17:54:29',NULL,1),(26,'a61c14a97037178e62c961fc40767b8e','127.0.0.1','2014-07-25 18:40:54','2014-07-25 18:40:55',1),(27,'9b64303523ab60d915d56fcfc077a21d','127.0.0.1','2014-07-25 18:55:00',NULL,1),(28,'255b78ee2cc731f01b4bf270b31be3c8','127.0.0.1','2014-07-28 08:15:11',NULL,1);

/*Table structure for table `user_type` */

DROP TABLE IF EXISTS `user_type`;

CREATE TABLE `user_type` (
  `id` smallint(5) NOT NULL auto_increment,
  `product_id` smallint(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `product_user_type` (`product_id`),
  KEY `user_type_id` (`id`),
  CONSTRAINT `product_user_type` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `user_type` */

insert  into `user_type`(`id`,`product_id`,`name`) values (9,1,'PRUEBA');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
