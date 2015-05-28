alter table expense_type ADD COLUMN update_date timestamp DEFAULT NULL;

alter table payment_method ADD COLUMN update_date timestamp DEFAULT NULL;