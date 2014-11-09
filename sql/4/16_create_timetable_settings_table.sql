CREATE TABLE `solgen`.`timetable_settings` (
  `id` INT NOT NULL,
  `user_id` INT NULL,
  `reminder_email` TINYINT NULL,
  `reminder_sms` TINYINT NULL,
  `daily_reminder` TINYINT NULL,
  `weekly_reminder_digest` TINYINT NULL,
  `weekly_reminder_digest_dow` int null,
  `create_date` TIMESTAMP NULL,
  `update_date` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
COMMENT = 'Contains all Timetable option settings';
