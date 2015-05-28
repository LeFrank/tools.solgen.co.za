
CREATE TABLE `weather_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `measurement` VARCHAR(45) NULL,
  `create_date` TIMESTAMP NULL,
  `update_date` TIMESTAMP NULL,
  PRIMARY KEY (`id`));