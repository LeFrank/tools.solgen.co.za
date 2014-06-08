
ALTER TABLE `user_location` 
ADD COLUMN `name` VARCHAR(255) NULL AFTER `user_id`,
ADD COLUMN `description` VARCHAR(255) NULL AFTER `name`,
ADD COLUMN `address` VARCHAR(255) NULL AFTER `longitude`,
ADD COLUMN `priority` INT NULL AFTER `address`,
ADD COLUMN `ktoi` TINYINT NULL DEFAULT 0 COMMENT 'Keep. Tabs. On. It.' AFTER `priority`,
ADD COLUMN `prm_id` INT NULL AFTER `last_updated`;