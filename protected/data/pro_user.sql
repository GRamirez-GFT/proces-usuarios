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
  KEY `user_company` (`user_id`),
  KEY `company_id` (`id`),
  CONSTRAINT `user_company` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `company` */

insert  into `company`(`id`,`name`,`subdomain`,`user_id`,`active`,`date_create`) values (1,'Grupo Endor','endor',2,1,'2014-01-01'),(2,'Google','google',3,1,'2014-07-29');

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` smallint(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `url_product` varchar(255) default NULL,
  `company_id` smallint(5) default NULL,
  PRIMARY KEY  (`id`),
  KEY `product_id` (`id`),
  KEY `company_product` (`company_id`),
  CONSTRAINT `company_product` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`url_product`,`company_id`) values (1,'Proces - Documentos','/documents',NULL),(2,'Proces - Proyectos','/projects',NULL),(3,'Proces - Usuarios','/users',NULL),(4,'PROPIO','',1),(16,'OTRO','',1);

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

insert  into `product_company`(`product_id`,`company_id`) values (2,1),(3,1),(4,1),(16,1);

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

insert  into `product_user`(`user_id`,`product_id`) values (2,2),(2,3),(2,4),(2,16);

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
  KEY `user_id` (`id`),
  CONSTRAINT `company_user` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`,`company_id`,`active`,`date_create`) values (1,'Administrador','admin','$2a$08$WMUurR64q1wxOwyTsJYydOSihBHx6dwV74I1N8vhAlfXd3mvU6/9i',NULL,1,'2014-01-01'),(2,'Jorge Gonzalez','endor','$2a$13$uUZk0qf99ZnIsi1ieP/OlOpsdbU.KXTD8gWf6V/HKdT1QkEEkkiES',1,1,'2014-01-01'),(3,'Rafael J Torres','google','$2a$13$w2Z31IsfXMcwm.lSzmykheERVvMDNDz519PFvpwwis7fFirIit1Fq',2,1,'2014-01-01');

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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

/*Data for the table `user_session` */

insert  into `user_session`(`id`,`session`,`ipv4`,`time_login`,`time_logout`,`user_id`) values (72,'4f0b018c6433848e24abfeb5dd7dfced','127.0.0.1','2014-08-01 08:37:16',NULL,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
