/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  francois
 * Created: 27 May 2018
 */

CREATE TABLE `solgen`.`health_metric` (
  `id` INT(11) NOT NULL,
  `measurement_date` TIMESTAMP NULL,
  `create_date` TIMESTAMP NULL,
  `weight` INT(5) NULL,
  `waist` INT(5) NULL,
  `sleep` INT(3) NULL,
  `note` TEXT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `solgen`.`health_metric` 
CHANGE COLUMN `create_date` `create_date` TIMESTAMP NULL DEFAULT now() ;

ALTER TABLE `health_metric` 
ADD COLUMN `user_id` INT(11) NULL AFTER `id`;

ALTER TABLE `health_metric` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `health_metric` 
CHANGE COLUMN `weight` `weight` FLOAT(5,2) NULL DEFAULT NULL ,
CHANGE COLUMN `waist` `waist` FLOAT(5,2) NULL DEFAULT NULL ,
CHANGE COLUMN `sleep` `sleep` FLOAT(5,2) NULL DEFAULT NULL ;

CREATE TABLE `health_exercise_tracker` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NULL,
  `created_date` TIMESTAMP NULL,
  `start_date` TIMESTAMP NULL,
  `end_date` TIMESTAMP NULL,
  `exercise_type_id` INT(11) NULL,
  `distance` INT(11) NULL,
  `difficulty` INT(2) NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `solgen`.`exercise_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NULL,
  `name` VARCHAR(255) NULL,
  `description` VARCHAR(500) NULL,
  `created_date` TIMESTAMP NULL,
  `default_measurement_name` VARCHAR(255) NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `health_exercise_tracker` 
ADD COLUMN `measurement_value` INT(11) NULL AFTER `exercise_type_id`;


INSERT INTO `exercise_type` 
(`user_id`, `name`, `description`, `created_date`, `default_measurement_name`) VALUES 
(null, 'Walking', 'Walking ', now(), 'Steps');



ALTER TABLE `health_exercise_tracker` 
ADD COLUMN `note` TEXT NULL AFTER `difficulty`;

ALTER TABLE `health_exercise_tracker` 
ADD COLUMN `update_date` TIMESTAMP NULL AFTER `description`;

ALTER TABLE `health_metric` 
ADD COLUMN `update_date` TIMESTAMP NULL AFTER `note`;
