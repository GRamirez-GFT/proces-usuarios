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
  `url_logo` varchar(200) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `subdomain` (`subdomain`),
  KEY `user_company` (`user_id`),
  CONSTRAINT `user_company` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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

insert  into `product`(`id`,`name`,`url_product`,`company_id`,`token`) values (1,'Proces - Usuarios','/usuarios',NULL,'CE6204AC6DD28E9B'),(2,'Proces - Documentos','/documentos',NULL,'1AD5BE0D83DCEFB7'),(3,'Proces - Proyectos','/projectos',NULL,'1AD5BE0D1AD5BE0D');

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

/*Table structure for table `product_user` */

DROP TABLE IF EXISTS `product_user`;

CREATE TABLE `product_user` (
  `user_id` int(11) NOT NULL,
  `product_id` smallint(5) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`user_id`,`product_id`),
  KEY `user_product_user` (`user_id`),
  KEY `product_product_user` (`product_id`),
  CONSTRAINT `product_product_user` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `user_product_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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

insert  into `user`(`id`,`name`,`username`,`password`,`email`,`company_id`,`active`,`date_create`) values (1,'Administrador','admin','$2a$08$WMUurR64q1wxOwyTsJYydOSihBHx6dwV74I1N8vhAlfXd3mvU6/9i',NULL,NULL,1,'2014-01-01');

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
