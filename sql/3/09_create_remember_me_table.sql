CREATE TABLE `user_remember_me` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `series_id` VARCHAR(45) NULL,
  `expiration_date` TIMESTAMP NULL,
  `active` TINYINT NULL DEFAULT 1,
  `create_date` TIMESTAMP NULL DEFAULT now(),
  `hash` VARCHAR(255) NULL,
  PRIMARY KEY (`id`));
