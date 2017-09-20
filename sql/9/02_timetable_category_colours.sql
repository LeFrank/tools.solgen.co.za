/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  francois
 * Created: 11 Sep 2017
 */

ALTER TABLE `solgen`.`timetable_category` 
ADD COLUMN `text_colour` VARCHAR(45) NULL AFTER `reminder`,
ADD COLUMN `background_colour` VARCHAR(45) NULL AFTER `text_colour`;
