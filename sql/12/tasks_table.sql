CREATE TABLE `tasks` (
    `id` int NOT NULL AUTO_INCREMENT, 
    `domain_id` int DEFAULT NULL, 
    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
    `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
    `status_id` int DEFAULT NULL, 
    `user_id` int DEFAULT NULL, 
    `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `end_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `target_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

alter table tasks modify description mediumtext;


ALTER TABLE tasks
ADD COLUMN importance_level_id int DEFAULT 0,
ADD COLUMN urgency_level_id int DEFAULT 0,
ADD COLUMN risk_level_id int DEFAULT 0,
ADD COLUMN gain_level_id int DEFAULT 0,
ADD COLUMN reward_category_id int DEFAULT 0,
ADD COLUMN cycle_id int DEFAULT 1,
ADD COLUMN scale_id int DEFAULT 1,
ADD COLUMN scope_id int DEFAULT 1;

ALTER TABLE tasks
ADD COLUMN difficulty_level_id int DEFAULT 1;

-- ALTER TABLE tasks 
-- RENAME COLUMN reward_level_id TO reward_category_id;

-- ALTER TABLE tasks 
-- RENAME COLUMN impoartance_level_id TO importance_level_id;

-- ALTER TABLE tasks 
-- RENAME COLUMN urgence_level_id TO  urgency_level_id;