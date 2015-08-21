CREATE TABLE `solgen`.`expense_budget` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(10000) NULL,
  `user_id` INT NOT NULL,
  `expense_period_id` INT NOT NULL,
  `total_limit` INT NOT NULL,
  `create_date` TIMESTAMP NULL,
  `update_date` TIMESTAMP NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `solgen`.`expense_budget_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `budget_id` INT NOT NULL,
  `expense_type_id` INT NOT NULL,
  `limit_amount` INT NOT NULL,
  `period_outcome_amount` INT NULL,
  `amount_sign` CHAR NULL,
  `create_date` TIMESTAMP NOT NULL,
  `update_date` TIMESTAMP NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `expense_budget_items` 
ADD COLUMN `description` VARCHAR(255) NULL AFTER `limit_amount`;
