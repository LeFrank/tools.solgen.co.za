CREATE TABLE `weather_data` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `location_id` INT NULL,
  `data` TEXT NULL,
  `create_date` TIMESTAMP NULL,
  `expiration_date` TIMESTAMP NULL,
  `data_type` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
COMMENT = 'Stores the data from the weather service for a set amount of time per user and location.';

