ALTER TABLE `solgen`.`timetable_category` 
ADD COLUMN `appear_on_dashboard` TINYINT(4) NULL AFTER `enabled`,
ADD COLUMN `reminder` TINYINT(4) NULL AFTER `appear_on_dashboard`;