CREATE TABLE `admin` (
`id`  int NOT NULL AUTO_INCREMENT ,
`username`  varchar(50) NULL ,
`password`  varchar(255) NULL ,
`created_at`  datetime NULL ,
`updated_at`  datetime NULL ,
PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

CREATE TABLE `member` (
`id` INT NOT NULL AUTO_INCREMENT,
`name`  VARCHAR (50) NOT NULL ,
`photo` VARCHAR (255) NOT NULL ,
`sex` TINYINT NOT NULL DEFAULT 0,
`status` TINYINT NOT NULL DEFAULT 0, -- 是否显示
`created_at`  datetime NULL ,
`updated_at`  datetime NULL ,
PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

CREATE TABLE `member_info`(
`id` INT NOT NULL AUTO_INCREMENT,
`member_id` INT NOT NULL ,
`qq` VARCHAR(255) NOT NULL DEFAULT '',
`wx` VARCHAR(255) NOT NULL DEFAULT '',
`tel` VARCHAR(255) NOT NULL DEFAULT '',
`z_imgs` VARCHAR (255) NOT NULL ,
`province` VARCHAR (50) NOT NULL ,
`city` VARCHAR (50) NOT NULL ,
`area` VARCHAR (50) NOT NULL ,
`desc` TEXT,
`created_at`  datetime NULL ,
`updated_at`  datetime NULL ,
PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;