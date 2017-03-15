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
  `restrict_connection` tinyint(1) UNSIGNED NOT NULL default 0 COMMENT '0 = Libre acceso\n1 = Restringir',
  `date_create` date NOT NULL,
  `url_logo` varchar(200) default NULL,
  `licenses` smallint(3) UNSIGNED NOT NULL,
  `storage` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Representing GB',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `subdomain` (`subdomain`),
  KEY `user_company` (`user_id`),
  CONSTRAINT `user_company` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `allowed_ip` */

DROP TABLE IF EXISTS `allowed_ip`;

CREATE TABLE `allowed_ip` (
  `ipv4` varchar(15) NOT NULL,
  `company_id` smallint(5) NOT NULL,
  PRIMARY KEY  (`ipv4`,`company_id`),
  KEY `company_allowed_ip` (`company_id`),
  CONSTRAINT `company_allowed_ip` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*Table structure for table `user_session` */

DROP TABLE IF EXISTS `user_session`;

CREATE TABLE `user_session` (
  `id` BIGINT NOT NULL auto_increment,
  `session` varchar(32) NOT NULL,
  `ipv4` varchar(15) NOT NULL,
  `time_login` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `time_logout` timestamp NULL default NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_user_session` (`user_id`),
  CONSTRAINT `user_user_session` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `used_storage` */

DROP TABLE IF EXISTS `used_storage`;

CREATE TABLE `used_storage` (
  `quantity` DECIMAL(19,2) NOT NULL DEFAULT '0.00' COMMENT 'Representing KB',
  `product_id` smallint(11) NOT NULL,
  `company_id` smallint(11) NOT NULL,
  PRIMARY KEY  (`product_id`, `company_id`),
  INDEX `used_storage_product_id_idx` (`product_id`),
  INDEX `used_storage_company_id_idx` (`company_id`),
  CONSTRAINT `used_storage_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `used_storage_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
