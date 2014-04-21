CREATE TABLE `expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` float(11,2) DEFAULT NULL,
  `expense_type_id` int(11) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `expense_date` timestamp DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `payment_method_id` int(3);
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `expense_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `create_date` timestamp DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `solgen_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `user_type` varchar(25) DEFAULT NULL,
  `create_date` timestamp DEFAULT NULL,
  `last_login` timestamp DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `payment_method`(
    `id` int(11) not null auto_increment,
    `description` varchar(255) DEFAULT NULL,
    `user_id` int(11) DEFAULT NULL,
    `enabled` boolean DEFAULT FALSE,
    `create_date` timestamp DEFAULT now(),
    PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;