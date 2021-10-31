SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `cjstone_bookshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cjstone_bookshop`;

CREATE TABLE `books` (
  `bookID` int(11) NOT NULL,
  `title` varchar(125) NOT NULL,
  `author` varchar(100) NOT NULL,
  `year` smallint(4) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  `cost` decimal(5,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `books` (`bookID`, `title`, `author`, `year`, `description`, `cost`, `quantity`, `image`) VALUES
(1, 'Game of Thrones (A Song of Ice and Fire, Book 1), A', 'George R.R. Martin', 2011, 'The original book that inspired the HBO series.', '6.74', 4, 'game_of_thrones.jpg'),
(2, 'Deep Down Dark: The Untold Stories of 33 Men Buried in a Chilean Mine, and the Miracle That Set Them', 'Héctor Tobar', 2014, 'The shocking true story of 33 trapped Chilean miners and their survival.', '19.45', 7, 'deep_down_dark.jpg'),
(3, 'Gone Girl', 'Gillian Flynn', 2012, 'The original book that inspired the David Fincher film.', '8.43', 8, 'gone_girl.jpg'),
(4, 'What If?: Serious Scientific Answers to Absurd Hypothetical Questions', 'Randall Munroe', 2014, 'The creator of the famous XKCD web comic tackles absurd hypotheticals with a serious and captivating manner.', '13.20', 4, 'what_if.jpg'),
(5, 'Attempting Normal', 'Marc Maron', 2013, 'Reflecting on his career and personal life, the stand-up comedian and sitcom star shares his unique views.', '12.02', 6, 'attempting_normal.jpg');

CREATE TABLE `purchases` (
  `purchID` int(11) NOT NULL,
  `tranID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `qty` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `transactions` (
  `tranID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `addr1` varchar(100) NOT NULL,
  `addr2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` char(5) NOT NULL,
  `credit` varchar(250) NOT NULL,
  `expire` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varbinary(250) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `updated` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `books`
  ADD PRIMARY KEY (`bookID`);

ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchID`);

ALTER TABLE `transactions`
  ADD PRIMARY KEY (`tranID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

ALTER TABLE `books`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `purchases`
  MODIFY `purchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `transactions`
  MODIFY `tranID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
