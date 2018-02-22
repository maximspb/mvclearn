CREATE DATABASE IF NOT EXISTS `learnbase` COLLATE 'utf8_general_ci';

USE learnbase;

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `news_id` int(11) NOT NULL
) ENGINE='InnoDB' COLLATE 'utf8_general_ci';

INSERT INTO `news` (`title`, `text`)
VALUES ('demo title', 'demo text');

INSERT INTO `comment` (`username`, `text`, `news_id`)
VALUES ('guest', 'first demo comment', '1');
