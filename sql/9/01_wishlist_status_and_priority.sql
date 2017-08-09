/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  francois
 * Created: 12 Feb 2017
 */
CREATE TABLE `solgen`.`wishlist_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NULL,
  `description` VARCHAR(500) NULL,
  `ordr` INT NULL,
  `user_id` INT(11) NULL,
  `create_date` TIMESTAMP NULL,
  `colour-code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `solgen`.`wishlist_priority` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NOT NULL,
  `description` VARCHAR(500) NULL,
  `ordr` INT NOT NULL,
  `user_id` INT(11) NULL,
  `create_date` TIMESTAMP NULL,
  `symbol_code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

INSERT INTO `solgen`.`wishlist_priority` (`name`, `description`, `ordr`, `create_date`, `symbol_code`) 
VALUES ('None', '', '0', now(), '');

INSERT INTO `solgen`.`wishlist_priority` (`name`, `description`, `ordr`, `create_date`, `symbol_code`) 
VALUES ('Low', '', '1', now(), '');

INSERT INTO `solgen`.`wishlist_priority` (`name`, `description`, `ordr`, `create_date`, `symbol_code`) 
VALUES ('Medium', '', '1', now(), '');

INSERT INTO `solgen`.`wishlist_priority` (`name`, `description`, `ordr`, `create_date`, `symbol_code`) 
VALUES ('High', '', '2', now(), '');

INSERT INTO `solgen`.`wishlist_priority` (`name`, `description`, `ordr`, `create_date`, `symbol_code`) 
VALUES ('Summit', '', '3', now(), '');


INSERT INTO `solgen`.`wishlist_status` (`name`, `ordr`, `create_date`) VALUES ('Rethink', '-1', now());

INSERT INTO `solgen`.`wishlist_status` (`name`, `ordr`, `create_date`) VALUES ('None', '0', now());

INSERT INTO `solgen`.`wishlist_status` (`name`, `ordr`, `create_date`) VALUES ('Some Day', '1', now());

INSERT INTO `solgen`.`wishlist_status` (`name`, `ordr`, `create_date`) VALUES ('Awaiting Action', '2', now());

INSERT INTO `solgen`.`wishlist_status` (`name`, `ordr`, `create_date`) VALUES ('In Progress', '3', now());

INSERT INTO `solgen`.`wishlist_status` (`name`, `ordr`, `create_date`) VALUES ('Done', '4', now());

ALTER TABLE `solgen`.`wishlist` ADD COLUMN `expense_type_id` INT(11) NULL AFTER `update_date`;
