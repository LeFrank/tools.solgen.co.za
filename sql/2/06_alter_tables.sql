alter table expense_type ADD COLUMN update_date timestamp DEFAULT NULL;

alter table payment_method ADD COLUMN update_date timestamp DEFAULT NULL;

ALTER TABLE `expense_type` 
ADD COLUMN `examples` VARCHAR(255) NULL AFTER `update_date`;
