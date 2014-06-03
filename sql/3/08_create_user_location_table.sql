CREATE TABLE `user_location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `latitude` VARCHAR(45) NULL,
  `longitude` VARCHAR(45) NULL,
  `create_date` TIMESTAMP NULL,
  `last_updated` TIMESTAMP NULL,
  PRIMARY KEY (`id`));
