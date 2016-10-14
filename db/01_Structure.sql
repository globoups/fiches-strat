-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2016 at 12:48 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fiches`
--

-- --------------------------------------------------------

--
-- Table structure for table `fs_bloc`
--

CREATE TABLE `fs_bloc` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '3' COMMENT '1: wrapper, 2: info, 3: info line, 4: modal',
  `key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `card_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_bloc_role`
--

CREATE TABLE `fs_bloc_role` (
  `bloc_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_boss`
--

CREATE TABLE `fs_boss` (
  `id` int(11) NOT NULL,
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `instance_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_card`
--

CREATE TABLE `fs_card` (
  `id` int(11) NOT NULL,
  `boss_id` int(11) NOT NULL,
  `difficulty_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_difficulty`
--

CREATE TABLE `fs_difficulty` (
  `id` int(11) NOT NULL,
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_instance`
--

CREATE TABLE `fs_instance` (
  `id` int(11) NOT NULL,
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `expanded` tinyint(1) NOT NULL DEFAULT '1',
  `instance_type_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_instance_type`
--

CREATE TABLE `fs_instance_type` (
  `id` int(11) NOT NULL,
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_log`
--

CREATE TABLE `fs_log` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `level` int(11) NOT NULL COMMENT '1: info, 2: warning, 3: error',
  `message` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_role`
--

CREATE TABLE `fs_role` (
  `id` int(11) NOT NULL,
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fs_user`
--

CREATE TABLE `fs_user` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fs_bloc`
--
ALTER TABLE `fs_bloc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `fs_bloc_role`
--
ALTER TABLE `fs_bloc_role`
  ADD PRIMARY KEY (`bloc_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `fs_boss`
--
ALTER TABLE `fs_boss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instance_id` (`instance_id`);

--
-- Indexes for table `fs_card`
--
ALTER TABLE `fs_card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `version` (`boss_id`,`difficulty_id`,`role_id`,`version`) USING BTREE;

--
-- Indexes for table `fs_difficulty`
--
ALTER TABLE `fs_difficulty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs_instance`
--
ALTER TABLE `fs_instance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instance_type_id` (`instance_type_id`);

--
-- Indexes for table `fs_instance_type`
--
ALTER TABLE `fs_instance_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs_log`
--
ALTER TABLE `fs_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs_role`
--
ALTER TABLE `fs_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs_user`
--
ALTER TABLE `fs_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fs_bloc`
--
ALTER TABLE `fs_bloc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;
--
-- AUTO_INCREMENT for table `fs_boss`
--
ALTER TABLE `fs_boss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `fs_card`
--
ALTER TABLE `fs_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `fs_difficulty`
--
ALTER TABLE `fs_difficulty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fs_instance`
--
ALTER TABLE `fs_instance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `fs_instance_type`
--
ALTER TABLE `fs_instance_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fs_log`
--
ALTER TABLE `fs_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fs_role`
--
ALTER TABLE `fs_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fs_user`
--
ALTER TABLE `fs_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
