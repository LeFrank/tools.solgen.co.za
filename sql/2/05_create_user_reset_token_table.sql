CREATE TABLE `user_reset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(300) DEFAULT NULL,
  `creation_date` timestamp DEFAULT NULL,
  `expiration_date` timestamp DEFAULT NULL,
  `was_reset` boolean DEFAULT false,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;