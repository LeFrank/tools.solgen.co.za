/**
 * Author:  francois
 * Created: 1 January 2024
 */

CREATE TABLE `solgen`.`income` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `amount` FLOAT(11,2) NULL,
  `income_type_id` INT NULL,
  `source` VARCHAR(255) NULL,
  `source_id` INT NULL,
  `payment_method_id` INT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `solgen`.`income` 
ADD COLUMN `description` MEDIUMTEXT NULL AFTER `income_type_id`,
ADD COLUMN `income_date` TIMESTAMP NULL AFTER `description`;
