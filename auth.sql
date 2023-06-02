SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `pp` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `birth_date` DATE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` INT(100) NOT NULL,
  `content` VARCHAR(255) NOT NULL, /*Image unutma*/
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `post_id` int(100) NOT NULL,
  `user_id` INT(100) NOT NULL,
  `content` varchar(100) NOT NULL,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`post_id`) REFERENCES posts(`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `user_id` int(100) NOT NULL,
  `friend_id` int(100) NOT NULL,
  PRIMARY KEY (`user_id`,`friend_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`friend_id`) REFERENCES users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `from_id` int(100) NOT NULL,
  `to_user_id` int(100) NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `content` VARCHAR(255),
   timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`to_user_id`) REFERENCES users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`email`, `password`, `name`, `surname`, `pp`, `birth_date`) 
VALUES ('example@example.com', 'password123', 'John', 'Doe', 'profile_pic.jpg', '1990-05-01');
INSERT INTO `notifications` (`id`, `from_id`, `to_user_id`, `type`, `content`, `timestamp`) 
VALUES ('2', '3', '2', 'IDK', 'YORULDUM', '1999-09-09');
COMMIT;