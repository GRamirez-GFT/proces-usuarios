/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`,`email`,`company_id`,`active`,`date_create`) values (1,'Administrador','admin','$2a$08$WMUurR64q1wxOwyTsJYydOSihBHx6dwV74I1N8vhAlfXd3mvU6/9i',NULL,NULL,1,'2014-01-01');

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`url_product`,`company_id`,`token`) values 
(1,'Proces - Usuarios','/usuarios',NULL,'CE6204AC6DD28E9B'),
(2,'Proces - Documentos','/documentos',NULL,'1AD5BE0D83DCEFB7'),
(3,'Proces - Proyectos','/proyectos',NULL,'1AD5BE0D1AD5BE0D'),
(4,'Proces - Guias','/guias',NULL,'3AE8BE0E1AD5BE6D');