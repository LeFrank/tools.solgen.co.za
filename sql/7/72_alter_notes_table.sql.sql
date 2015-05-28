ALTER TABLE `notes` 
ADD COLUMN `tool_id` INT NULL DEFAULT NULL AFTER `update_date`,
ADD COLUMN `tool_data_id` INT NULL DEFAULT NULL AFTER `tool_id`,
ADD COLUMN `update_count` INT NULL DEFAULT NULL AFTER `tool_data_id`;
