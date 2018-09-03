CREATE TABLE `admin` (
`id`  int NOT NULL AUTO_INCREMENT ,
`username`  varchar(50) NULL ,
`password`  varchar(255) NULL ,
`created_at`  datetime NULL ,
`updated_at`  datetime NULL ,
PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;