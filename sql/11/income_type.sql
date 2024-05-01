CREATE TABLE `income_type` (
    `id` int NOT NULL AUTO_INCREMENT, 
    `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `enabled` tinyint(1) DEFAULT NULL, 
    `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    `user_id` int DEFAULT NULL, 
    `update_date` timestamp NULL DEFAULT NULL, 
    `examples` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
    `template` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;