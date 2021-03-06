CREATE TABLE `timetable` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `name` VARCHAR(255) NULL,
  `description` VARCHAR(500) NULL,
  `tt_category_id` INT NULL,
  `create_date` TIMESTAMP NULL,
  `all_day_event` TINYINT(1) NULL,
  `duration` TINYINT NULL,
  `start_date` TIMESTAMP NULL,
  `end_date` TIMESTAMP NULL,
  `repition_id` INT NULL,
  `expense_type_id` INT NULL,
  `location_id` INT NULL,
  `location_text` VARCHAR(500) NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `timetable` 
CHANGE COLUMN `description` `description` VARCHAR(2000) NULL DEFAULT NULL ;
