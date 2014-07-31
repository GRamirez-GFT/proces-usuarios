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

insert  into `company`(`id`,`name`,`subdomain`,`user_id`,`active`,`date_create`) values (1,'Grupo Endor','endor',2,0,'2014-01-01'),(2,'Google','google',3,0,'2014-07-29');

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` smallint(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `url_product` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url_product` (`url_product`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`url_product`) values (1,'Proces - Documentos','/documents'),(2,'Proces - Proyectos','/projects'),(3,'Proces - Usuarios','/users');

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

insert  into `product_company`(`product_id`,`company_id`) values (2,1);

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

insert  into `product_user`(`user_id`,`product_id`) values (2,2),(4,2);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`,`company_id`,`active`,`date_create`) values (1,'Administrador','admin','$2a$08$WMUurR64q1wxOwyTsJYydOSihBHx6dwV74I1N8vhAlfXd3mvU6/9i',NULL,1,'2014-01-01'),(2,'Jorge Gonzalez','endor','$2a$13$PtXpve6gvj81aVyBjl2rfe7Ws3kMr.QQtRid9LB9Hk7V3J/AWIlBy',1,1,'2014-01-01'),(3,'Rafael J Torres','rafael','$2a$13$w2Z31IsfXMcwm.lSzmykheERVvMDNDz519PFvpwwis7fFirIit1Fq',2,1,'2014-01-01'),(4,'Angel Perez','angel','$2a$13$4N6wK3NoEoCHm1YqN/6L.eYMXygenyb.5H1pS7BYVSqQW8oOhay2C',1,1,'2014-07-30');

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `user_session` */

insert  into `user_session`(`id`,`session`,`ipv4`,`time_login`,`time_logout`,`user_id`) values (1,'4e8f66013721fe47bf06020f946221f3','127.0.0.1','2014-07-28 21:42:38',NULL,1),(2,'2635acf7076e2d81a085cf17ba8afe62','127.0.0.1','2014-07-28 21:44:01',NULL,1),(3,'731e48a7733a92bc709682911f032ba9','127.0.0.1','2014-07-28 21:44:31','2014-07-28 21:44:35',1),(4,'79750d0399b04a29159a6ed7d2debfe9','127.0.0.1','2014-07-28 21:45:13','2014-07-28 21:45:40',2),(5,'12ec96fe43ca553d433d76519c3e49f8','127.0.0.1','2014-07-28 21:45:45','2014-07-28 21:45:49',1),(6,'73994d17448cf77c39d3bfd60e631078','127.0.0.1','2014-07-28 21:45:56','2014-07-28 21:49:43',2),(7,'71e7a91c6b3156d8216eb4b74b2620c8','127.0.0.1','2014-07-28 21:49:57','2014-07-28 21:49:58',1),(8,'a1154ca1e0edf60d9610548f15c64045','127.0.0.1','2014-07-28 21:50:04','2014-07-28 21:57:03',2),(9,'91b42eeb4b01183a7e8226db4fe57d9d','127.0.0.1','2014-07-28 21:57:08',NULL,1),(10,'830b55ec0379ad32dce11ad9ebd73bfa','127.0.0.1','2014-07-29 07:30:46',NULL,1),(11,'15fa68d2fb9909030e3e3750b0181f01','127.0.0.1','2014-07-29 15:45:50',NULL,1),(12,'2ee234784a8500a87491d84eb561f442','127.0.0.1','2014-07-29 16:15:16','2014-07-29 16:15:18',2),(13,'428b60821af1059410dc922515e0c940','127.0.0.1','2014-07-29 16:15:39','2014-07-29 16:15:50',2),(14,'d101c73c8cf783db4c40242ed79c90e1','127.0.0.1','2014-07-29 16:26:04','2014-07-29 16:26:07',2),(15,'03866b8676ad2061cc98728d2e02a0e8','127.0.0.1','2014-07-30 06:13:16',NULL,1),(16,'6af430bcbd9ab353c98e33efde73d84a','127.0.0.1','2014-07-30 07:30:46','2014-07-30 07:31:40',1),(17,'c6efddc99852db49d9504043a33b0608','127.0.0.1','2014-07-30 07:31:45',NULL,2),(18,'75702a02dfca09974471a7000c3b5dd3','127.0.0.1','2014-07-30 08:09:14',NULL,2),(19,'468dc7edad99c60af4a3d71d4ead01d6','127.0.0.1','2014-07-30 21:28:02','2014-07-30 21:56:56',1),(20,'ce1b807deae31d13a1a2d6d659e78c09','127.0.0.1','2014-07-30 21:57:00','2014-07-30 22:04:48',2),(21,'6dec565e041b09624115c50252ae99cc','127.0.0.1','2014-07-30 22:04:51','2014-07-30 22:40:15',4),(22,'96de30ed3de28307b770bb67c3322a0e','127.0.0.1','2014-07-30 22:40:22','2014-07-30 22:40:37',2),(23,'f84f1e1813681470f8a720ce8214667c','127.0.0.1','2014-07-30 22:40:47',NULL,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
