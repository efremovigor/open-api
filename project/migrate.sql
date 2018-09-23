CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
);
CREATE TABLE `gift` (
  `gift_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `data` text,
  `send` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`gift_id`)
)