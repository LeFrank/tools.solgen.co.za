
CREATE TABLE `notes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `heading` VARCHAR(250) NULL,
  `body`	text NULL,
  `tagg` varchar(250),
  `create_date` TIMESTAMP NULL,
  `update_date` TIMESTAMP NULL,
  PRIMARY KEY (`id`));