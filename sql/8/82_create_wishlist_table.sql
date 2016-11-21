/* 
 */
/**
 * Author:  francois
 * Created: 18 Sep 2016
 */

CREATE TABLE `solgen`.`wishlist` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `reason` TEXT NULL,
  `priority` TINYINT NULL DEFAULT 0,
  `cost` FLOAT(11,2) NULL,
  `target_date` TIMESTAMP NULL,
  `status` TINYINT NULL,
  `creation_date` TIMESTAMP NULL,
  `update_date` TIMESTAMP NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `solgen`.`wishlist` 
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `id`;

ALTER TABLE `wishlist` CHANGE COLUMN `status` `status` TINYINT(4) NULL DEFAULT 0 ;
