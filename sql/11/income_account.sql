CREATE TABLE `income_asset` (
    `id` int NOT NULL AUTO_INCREMENT, 
    `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
    `user_id` int DEFAULT NULL, 
    `enabled` tinyint(1) DEFAULT '0', 
    `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;