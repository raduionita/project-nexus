-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2013 at 06:16 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nexus`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`article_id`, `created`, `modified`, `published`, `views`, `status`) VALUES
(1, 3241234, 4234234, 5454324, 2, 1),
(2, 4324235, 5234234, 2345345, 3, 0),
(3, 2341234, 7456867, 6573455, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `article_image`
--

CREATE TABLE IF NOT EXISTS `article_image` (
  `article_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  PRIMARY KEY (`article_image_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `article_image`
--

INSERT INTO `article_image` (`article_image_id`, `article_id`, `image_id`, `caption`) VALUES
(1, 1, 1, 'duck'),
(2, 1, 2, 'quack'),
(3, 1, 3, 'hello'),
(4, 2, 4, 'dolly'),
(5, 2, 2, 'not');

-- --------------------------------------------------------

--
-- Table structure for table `article_lang`
--

CREATE TABLE IF NOT EXISTS `article_lang` (
  `article_lang_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`article_lang_id`),
  KEY `article_id` (`article_id`,`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `article_lang`
--

INSERT INTO `article_lang` (`article_lang_id`, `article_id`, `lang_id`, `keyword`, `title`, `content`) VALUES
(1, 1, 1, 'something-good', 'Something Good', '<h1>Something Good</h1>'),
(2, 1, 2, 'ceva-bun', 'Ceva Bun', '<h1>Ceva Bun</h1>'),
(3, 2, 1, 'blah-blah', 'Blahhhhhhhh!', '<h2>Blahhhhhhhh!</h2>'),
(4, 2, 2, 'mana-mana', 'Mana! Mana!', '<h2>Mana! Mana!</h2>');

-- --------------------------------------------------------

--
-- Table structure for table `article_user`
--

CREATE TABLE IF NOT EXISTS `article_user` (
  `article_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`article_user_id`),
  KEY `article_id` (`article_id`,`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `article_user`
--

INSERT INTO `article_user` (`article_user_id`, `article_id`, `user_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`image_id`, `filename`) VALUES
(1, 'duck.jpg'),
(2, 'mouse.jpg'),
(3, 'pigeon.jpg'),
(4, 'lion.png'),
(5, 'cat.gif');

-- --------------------------------------------------------

--
-- Table structure for table `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `lang_id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lang`
--

INSERT INTO `lang` (`lang_id`, `language`) VALUES
(1, 'English'),
(2, 'Romanian');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `status`) VALUES
(1, 'Radu', 1),
(2, 'Vlad', 0),
(3, 'Diablo', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
