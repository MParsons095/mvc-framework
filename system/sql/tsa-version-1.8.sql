-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2014 at 06:28 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `uid` char(36) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` char(32) NOT NULL,
  `registrationTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accountType` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`uid`, `firstName`, `lastName`, `email`, `password`, `salt`, `registrationTimestamp`, `accountType`) VALUES
('73434fa2-a880-11e3-a465-88ae1de0dfc2', 'John', 'Doe', 'john@doe2.com', '6febdb99e5746df8b0fcc3b9fd1cd001602dd79d5d72cf81083f31cdd58a9e43', '2a81fde6e251a1f51840f02cf0f3480e', '2014-03-10 18:18:59', 'user'),
('c05fd36e-a7de-11e3-a465-88ae1de0dfc2', 'John', 'Doe', 'john@doe.com', '1db0d8e324f44586644b90d59ef013d1024353e02ec80922571b166a31b26988', '84a17740b8a1c0037d7ae4f16b9b946a', '2014-03-09 23:01:30', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE IF NOT EXISTS `award` (
  `uid` char(32) NOT NULL,
  `user_uid` char(32) NOT NULL,
  `award_category_uid` char(32) NOT NULL,
  `year` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `award_category`
--

CREATE TABLE IF NOT EXISTS `award_category` (
  `uuid` mediumint(9) NOT NULL,
  `category` varchar(255) NOT NULL,
  `registration_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` char(32) NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `uid` char(32) NOT NULL,
  `addedBy` char(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `description` text NOT NULL,
  `credit` int(11) NOT NULL,
  `registrationTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`uid`, `addedBy`, `title`, `slug`, `caption`, `description`, `credit`, `registrationTimestamp`) VALUES
('798fe89f-aa11-11e3-a465-88ae1de0', '73434fa2-a880-11e3-a465-88ae1de0', 'course0', 'course-0', '', 'this is course 0', 0, '2014-03-12 18:09:38'),
('79a2c214-aa11-11e3-a465-88ae1de0', '73434fa2-a880-11e3-a465-88ae1de0', 'course1', 'course-1', '', 'this is course 1', 1, '2014-03-12 18:09:38'),
('79b0ecf1-aa11-11e3-a465-88ae1de0', '73434fa2-a880-11e3-a465-88ae1de0', 'course2', 'course-2', '', 'this is course 2', 2, '2014-03-12 18:09:38'),
('79bdab6a-aa11-11e3-a465-88ae1de0', '73434fa2-a880-11e3-a465-88ae1de0', 'course3', 'course-3', '', 'this is course 3', 3, '2014-03-12 18:09:38'),
('cfb26fb7-a935-11e3-a465-88ae1de0', '73434fa2-a880-11e3-a465-88ae1de0', 'Introduction to Engineering Design', 'introduction-to-engineering-design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sagittis rhoncus egestas.', 'In this course, students use 3D solid modeling design software to help them design solutions to solve proposed problems. Students will learn how to document their work and communicate solutions to peers and members of the professional community. This course is designed for 9th or 10th grade students. The major focus of the IED course is to expose students to the design process, research and analysis, teamwork, communication methods, global and human impacts, engineering standards and technical documentation.', 4, '2014-03-11 15:57:13');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `uid` char(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
