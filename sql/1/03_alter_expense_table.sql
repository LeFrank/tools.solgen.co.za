/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  francois
 * Created: 07 Feb 2017
 */

ALTER TABLE `solgen`.`expense` 
CHANGE COLUMN `expense_date` `expense_date` TIMESTAMP NOT NULL DEFAULT NOW() ,
ADD COLUMN `locationId` INT(11) NULL AFTER `location`;
ALTER TABLE `solgen`.`expense` 
CHANGE COLUMN `locationId` `location_id` INT(11) NULL DEFAULT NULL ;
