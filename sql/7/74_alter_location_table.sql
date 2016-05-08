/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  francois
 * Created: 08 May 2016
 */

ALTER TABLE `solgen`.`user_location` 
ADD COLUMN `telephone` VARCHAR(20) NULL DEFAULT NULL AFTER `prm_id`,
ADD COLUMN `mobile` VARCHAR(45) NULL AFTER `telephone`,
ADD COLUMN `fax` VARCHAR(45) NULL AFTER `mobile`,
ADD COLUMN `email` VARCHAR(350) NULL AFTER `fax`,
ADD COLUMN `operating hours` VARCHAR(500) NULL AFTER `email`,
ADD COLUMN `website` TEXT NULL AFTER `operating hours`;
