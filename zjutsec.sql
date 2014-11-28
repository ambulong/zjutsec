-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 28, 2014 at 03:25 PM
-- Server version: 5.5.39-MariaDB
-- PHP Version: 5.5.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zjutsec`
--

-- --------------------------------------------------------

--
-- Table structure for table `z_bin`
--

CREATE TABLE IF NOT EXISTS `z_bin` (
`id` int(11) NOT NULL,
  `data` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `operator` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `z_config`
--

CREATE TABLE IF NOT EXISTS `z_config` (
`id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `label` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `expiretime` int(11) NOT NULL,
  `alert` int(11) NOT NULL DEFAULT '0',
  `alertmails` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `z_logs`
--

CREATE TABLE IF NOT EXISTS `z_logs` (
`id` int(11) NOT NULL,
  `data` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `z_reports`
--

CREATE TABLE IF NOT EXISTS `z_reports` (
`id` int(11) NOT NULL,
  `sid` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `nid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `anonymous` int(11) NOT NULL DEFAULT '0',
  `ori_title` varchar(500) COLLATE utf8mb4_bin NOT NULL,
  `ori_incharge` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `ori_tags` varchar(300) COLLATE utf8mb4_bin NOT NULL,
  `ori_desc` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `ori_comment` text COLLATE utf8mb4_bin NOT NULL,
  `ori_rank` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_bin NOT NULL,
  `incharge` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `tags` varchar(300) COLLATE utf8mb4_bin NOT NULL,
  `summary` text COLLATE utf8mb4_bin NOT NULL,
  `desc` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `comment` text COLLATE utf8mb4_bin NOT NULL,
  `resp` text COLLATE utf8mb4_bin NOT NULL,
  `note` text COLLATE utf8mb4_bin NOT NULL,
  `canbepub` int(11) NOT NULL DEFAULT '1',
  `time` datetime NOT NULL,
  `mgmt_time` datetime NOT NULL,
  `ext` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `z_tags`
--

CREATE TABLE IF NOT EXISTS `z_tags` (
`id` int(11) NOT NULL,
  `sid` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `z_users`
--

CREATE TABLE IF NOT EXISTS `z_users` (
`id` int(11) NOT NULL,
  `sid` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `avatar` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `label` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `desc` text COLLATE utf8mb4_bin NOT NULL,
  `url` varchar(300) COLLATE utf8mb4_bin NOT NULL,
  `org` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `qq` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `time` datetime NOT NULL,
  `mgmt_time` datetime NOT NULL,
  `ext` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `z_bin`
--
ALTER TABLE `z_bin`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `z_config`
--
ALTER TABLE `z_config`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `z_logs`
--
ALTER TABLE `z_logs`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `z_reports`
--
ALTER TABLE `z_reports`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`,`sid`);

--
-- Indexes for table `z_tags`
--
ALTER TABLE `z_tags`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `z_users`
--
ALTER TABLE `z_users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `z_bin`
--
ALTER TABLE `z_bin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `z_config`
--
ALTER TABLE `z_config`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `z_logs`
--
ALTER TABLE `z_logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `z_reports`
--
ALTER TABLE `z_reports`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `z_tags`
--
ALTER TABLE `z_tags`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `z_users`
--
ALTER TABLE `z_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
