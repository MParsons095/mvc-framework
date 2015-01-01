-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2014 at 12:27 AM
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
  `slug` varchar(255) NOT NULL,
  `registrationTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accountType` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_meta`
--

CREATE TABLE IF NOT EXISTS `account_meta` (
  `uid` char(36) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `accountUid` char(36) NOT NULL,
  `bio` text NOT NULL,
  `yearJoined` int(4) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `accountUid` (`accountUid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE IF NOT EXISTS `award` (
  `uid` char(36) NOT NULL,
  `accountUid` char(36) NOT NULL,
  `awardMetaUid` char(36) NOT NULL,
  `placing` int(2) NOT NULL,
  `level` varchar(25) NOT NULL,
  `yearOf` int(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  KEY `accountUid` (`accountUid`),
  KEY `awardMetaUid` (`awardMetaUid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `award_meta`
--

CREATE TABLE IF NOT EXISTS `award_meta` (
  `uid` char(36) NOT NULL,
  `competition` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `value` (`competition`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `award_meta`
--

INSERT INTO `award_meta` (`uid`, `competition`) VALUES
('944eb475-bdaf-11e3-9690-88ae1de0dfc2', 'Animatronics'),
('944f379b-bdaf-11e3-9690-88ae1de0dfc2', 'Architectural Renovation'),
('944fae71-bdaf-11e3-9690-88ae1de0dfc2', 'Biotechnology Design'),
('94501b37-bdaf-11e3-9690-88ae1de0dfc2', 'Career Preparation'),
('945085a4-bdaf-11e3-9690-88ae1de0dfc2', 'Chapter Team'),
('9451d795-bdaf-11e3-9690-88ae1de0dfc2', 'Computer Numerical Control (CNC) Production'),
('9450f493-bdaf-11e3-9690-88ae1de0dfc2', 'Computer-Aided Design (CAD) 2D, Architecture'),
('9451683e-bdaf-11e3-9690-88ae1de0dfc2', 'Computer-Aided Design (CAD) 3D, Engineering'),
('94524a3a-bdaf-11e3-9690-88ae1de0dfc2', 'Debating Technological Issues'),
('9452c7ec-bdaf-11e3-9690-88ae1de0dfc2', 'Desktop Publishing'),
('94534235-bdaf-11e3-9690-88ae1de0dfc2', 'Digital Video Production'),
('9453b1de-bdaf-11e3-9690-88ae1de0dfc2', 'Dragster Design'),
('94542158-bdaf-11e3-9690-88ae1de0dfc2', 'Engineering Design'),
('94549e32-bdaf-11e3-9690-88ae1de0dfc2', 'Essays on Technology'),
('94550ac4-bdaf-11e3-9690-88ae1de0dfc2', 'Extemporaneous Speech'),
('f21e9651-bdaf-11e3-9690-88ae1de0dfc2', 'Fashion Design'),
('f21f4a25-bdaf-11e3-9690-88ae1de0dfc2', 'Flight Endurance'),
('f21fe3a6-bdaf-11e3-9690-88ae1de0dfc2', 'Future Technology Teacher'),
('f22070dc-bdaf-11e3-9690-88ae1de0dfc2', 'Manufacturing Prototype'),
('f22106ef-bdaf-11e3-9690-88ae1de0dfc2', 'On Demand Video'),
('f221a0db-bdaf-11e3-9690-88ae1de0dfc2', 'Open Source Software Development'),
('f222294c-bdaf-11e3-9690-88ae1de0dfc2', 'Photographic Technology'),
('f222bd07-bdaf-11e3-9690-88ae1de0dfc2', 'Prepared Presentation'),
('f22346a1-bdaf-11e3-9690-88ae1de0dfc2', 'Promotional Graphics'),
('3c100669-bdb0-11e3-9690-88ae1de0dfc2', 'SciVis'),
('3c10a697-bdb0-11e3-9690-88ae1de0dfc2', 'Structural Engineering'),
('3c11419e-bdb0-11e3-9690-88ae1de0dfc2', 'System Control Technology'),
('3c11d54e-bdb0-11e3-9690-88ae1de0dfc2', 'Technical Sketching and Application'),
('3c125d90-bdb0-11e3-9690-88ae1de0dfc2', 'Technology Bowl'),
('3c12e260-bdb0-11e3-9690-88ae1de0dfc2', 'Technology Problem Solving'),
('3c136bdc-bdb0-11e3-9690-88ae1de0dfc2', 'Transportation Modeling'),
('3c13f309-bdb0-11e3-9690-88ae1de0dfc2', 'Video Game Design'),
('3c148e1a-bdb0-11e3-9690-88ae1de0dfc2', 'Webmaster');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `uid` char(36) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `course_meta`
--

CREATE TABLE IF NOT EXISTS `course_meta` (
  `uid` char(36) NOT NULL,
  `courseId` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `isRequired` tinyint(1) NOT NULL DEFAULT '1',
  `isChild` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  KEY `course_id` (`courseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `uid` char(36) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_meta`
--

CREATE TABLE IF NOT EXISTS `project_meta` (
  `uid` char(36) NOT NULL,
  `projectUid` char(36) NOT NULL,
  `accountUid` char(36) NOT NULL,
  `role` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_meta`
--
ALTER TABLE `account_meta`
  ADD CONSTRAINT `account_meta_ibfk_2` FOREIGN KEY (`accountUid`) REFERENCES `account` (`uid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `award`
--
ALTER TABLE `award`
  ADD CONSTRAINT `award_ibfk_1` FOREIGN KEY (`accountUid`) REFERENCES `account` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `award_ibfk_2` FOREIGN KEY (`awardMetaUid`) REFERENCES `award_meta` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_meta`
--
ALTER TABLE `course_meta`
  ADD CONSTRAINT `course_meta_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `course` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
