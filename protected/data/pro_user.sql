/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.31 : Database - pro_user
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE SCHEMA IF NOT EXISTS `pro_user` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `pro_user` ;

/*Table structure for table `action` */

DROP TABLE IF EXISTS `action`;

CREATE TABLE `action` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `controller_id` smallint(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `controller_action` (`controller_id`),
  KEY `action_id` (`id`),
  CONSTRAINT `controller_action` FOREIGN KEY (`controller_id`) REFERENCES `controller` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `action` */

/*Table structure for table `action_role` */

DROP TABLE IF EXISTS `action_role`;

CREATE TABLE `action_role` (
  `action_id` smallint(5) NOT NULL,
  `role_id` smallint(5) NOT NULL,
  PRIMARY KEY (`action_id`,`role_id`),
  KEY `action_action_role` (`action_id`),
  KEY `role_action_role` (`role_id`),
  CONSTRAINT `action_action_role` FOREIGN KEY (`action_id`) REFERENCES `action` (`id`),
  CONSTRAINT `role_action_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `action_role` */

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `subdomain` varchar(30) DEFAULT NULL,
  `active` tinyint(1) NOT NULL COMMENT '0 = Inactivo\n1 = Activo',
  `date_create` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `company` */

insert  into `company`(`id`,`name`,`subdomain`,`active`,`date_create`) values (1,'Grupo Endor','endor',1,'2014-01-01');

/*Table structure for table `company_product` */

DROP TABLE IF EXISTS `company_product`;

CREATE TABLE `company_product` (
  `company_id` smallint(5) NOT NULL,
  `product_id` smallint(5) NOT NULL,
  `date_create` date NOT NULL,
  PRIMARY KEY (`company_id`,`product_id`),
  KEY `company_company_product` (`company_id`),
  KEY `product_company_product` (`product_id`),
  CONSTRAINT `company_company_product` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `product_company_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `company_product` */

/*Table structure for table `controller` */

DROP TABLE IF EXISTS `controller`;

CREATE TABLE `controller` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url_controller` varchar(255) DEFAULT NULL,
  `product_id` smallint(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_controller` (`url_controller`),
  UNIQUE KEY `url_controller_2` (`url_controller`),
  KEY `controller_id` (`id`),
  KEY `product_controller` (`product_id`),
  CONSTRAINT `product_controller` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `controller` */

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url_product` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`url_product`) values (1,'Proces - Proyectos','/projects');

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company_id` smallint(5) NOT NULL,
  `product_id` smallint(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_role` (`company_id`),
  KEY `product_role` (`product_id`),
  KEY `role_id` (`id`),
  CONSTRAINT `company_role` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `product_role` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `role` */

insert  into `role`(`id`,`name`,`company_id`,`product_id`) values (1,'Administrador',1,1);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(72) NOT NULL,
  `active` tinyint(1) NOT NULL COMMENT '0 = Inactivo\n1 = Activo',
  `date_create` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`,`active`,`date_create`) values (1,'Administrador','admin','$2a$13$mixvyvN4lYpt6rAKPeAVzeNR/E1PV6D.UQW.BNa3H3mSMB8drFakW',1,'2014-01-01');

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` smallint(5) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_user_role` (`user_id`),
  KEY `role_user_role` (`role_id`),
  CONSTRAINT `role_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `user_user_role` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_role` */

insert  into `user_role`(`user_id`,`role_id`) values (1,1);

/*Table structure for table `user_session` */

DROP TABLE IF EXISTS `user_session`;

CREATE TABLE `user_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(32) NOT NULL,
  `ipv4` varchar(15) NOT NULL,
  `time_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_logout` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_user_session` (`user_id`),
  KEY `user_session_id` (`id`),
  CONSTRAINT `user_user_session` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `user_session` */

insert  into `user_session`(`id`,`session`,`ipv4`,`time_login`,`time_logout`,`user_id`) values (15,'367462099e72ba94884bd8e6cc585c45','127.0.0.1','2014-07-17 08:10:24',NULL,1),(16,'63cc1056e1c9ea95d9d25374561bdecd','127.0.0.1','2014-07-17 08:10:35','2014-07-17 07:49:46',1),(17,'dcefa5e0cef5d08265c2e9b88c1b8f30','127.0.0.1','2014-07-17 20:44:50',NULL,1),(18,'535084e2303e91e0ca5824a6f3eb6613','127.0.0.1','2014-07-17 20:46:49','2014-07-17 20:54:13',1),(19,'cbc8ef1f47612a0f57c099104a424522','127.0.0.1','2014-07-17 20:47:02','2014-07-17 20:24:02',1),(20,'ecc8160555149f12725e16f5d68eb030','127.0.0.1','2014-07-17 20:54:16','2014-07-17 20:55:32',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
