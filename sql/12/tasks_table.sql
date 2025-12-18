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