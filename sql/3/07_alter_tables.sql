ALTER TABLE `solgen_user` 
ADD COLUMN `subscribed` TINYINT(1) NULL DEFAULT 1 AFTER `active`;