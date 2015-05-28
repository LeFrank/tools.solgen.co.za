CREATE TABLE `timetable_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL DEFAULT NULL,
  `name` VARCHAR(160) NULL,
  `description` VARCHAR(255) NULL,
  `create_date` TIMESTAMP NULL,
  `update_date` TIMESTAMP NULL,
  `enabled` TINYINT NULL DEFAULT 1,
  PRIMARY KEY (`id`));