CREATE TABLE `tasks_status` (
    `id` int NOT NULL AUTO_INCREMENT, 
    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
    `description`mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
    `text_colour` VARCHAR(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `background_colour` VARCHAR(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_id` int DEFAULT NULL, 
    `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

alter table tasks_status modify description mediumtext;
