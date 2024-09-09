CREATE DATABASE IF NOT EXISTS `asot`;
use `asot`;

CREATE TABLE `asot`.`political`(
  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `question` text NOT NULL,
  `options` json NOT NULL DEFAULT '[]',
  `answer` varchar(500) NOT NULL
);

CREATE TABLE `asot`.`history`(
  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `question` text NOT NULL,
  `options` json NOT NULL DEFAULT '[]',
  `answer` varchar(500) NOT NULL
);

CREATE TABLE `asot`.`geography`(
  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `question` text NOT NULL,
  `options` json NOT NULL DEFAULT '[]',
  `answer` varchar(500) NOT NULL
);

CREATE TABLE `asot`.`economics`(
  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `question` text NOT NULL,
  `options` json NOT NULL DEFAULT '[]',
  `answer` varchar(500) NOT NULL
);

CREATE TABLE `asot`.`urdu`(
  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `question` text NOT NULL,
  `options` json NOT NULL DEFAULT '[]',
  `answer` varchar(500) NOT NULL
);

CREATE TABLE `asot`.`hindi`(
  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `question` text NOT NULL,
  `options` json NOT NULL DEFAULT '[]',
  `answer` varchar(500) NOT NULL
);

CREATE TABLE `asot`.`admin`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(50) NOT NULL DEFAULT 'SHAHZADA MODASSIR',
  `auth` varchar(50) NOT NULL DEFAULT '_admin',
  `passkey` varchar(500) NOT NULL,
  `conducted` varchar(11) NOT NULL DEFAULT '',
  `act_result` varchar(11) NOT NULL DEFAULT '',
  `act_answer` varchar(11) NOT NULL DEFAULT ''
);

INSERT INTO `admin` (`passkey`) VALUES ('$2y$10$0039CovJZcTxudVyLyAohenmB8sDux2SPeGScakSjki0CSlLYkW9O');

CREATE TABLE `asot`.`tests`(
  `subject` varchar(50) NOT NULL,
  `start` varchar(100) NOT NULL,
  `subcode` varchar(50) NOT NULL,
  `duration` varchar(100) NOT NULL
);

CREATE TABLE `asot`.`users`(
  `username` varchar(30) NOT NULL,
  `uid` varchar(200) NOT NULL,
  `rollno` int(11) NOT NULL,
  `rollcode` int(11) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `political` int(3) NOT NULL DEFAULT 0,
  `history` int(3) NOT NULL DEFAULT 0,
  `geography` int(3) NOT NULL DEFAULT 0,
  `economics` int(3) NOT NULL DEFAULT 0,
  `urdu` int(3) NOT NULL DEFAULT 0,
  `hindi` int(3) NOT NULL DEFAULT 0,
  `present` varchar(11) NOT NULL DEFAULT 'NA'
);