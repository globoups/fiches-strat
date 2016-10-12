-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2016 at 03:41 PM
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
  `type` int(11) NOT NULL DEFAULT '3' COMMENT '1: main, 2: sub, 3: line, 4: modal',
  `key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `card_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fs_bloc`
--

INSERT INTO `fs_bloc` (`id`, `type`, `key`, `content`, `order`, `card_id`, `parent_id`) VALUES
(1, 2, NULL, 'Général', 1, 3, NULL),
(2, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 1),
(3, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 1),
(4, 1, 'p1', 'Phase 1', 2, 3, NULL),
(5, 1, 'p2', 'Phase 2', 3, 3, NULL),
(6, 2, NULL, 'Général', 1, NULL, 4),
(7, 2, NULL, 'Général', 1, NULL, 5),
(8, 2, NULL, 'Mon rôle', 2, NULL, 4),
(9, 2, NULL, 'Mon rôle', 2, NULL, 5),
(10, 3, NULL, 'Commence au pull.', 1, NULL, 6),
(11, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 6),
(12, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 6),
(13, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 8),
(14, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\r\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\r\n⇒ Je deviens off tank.', 2, NULL, 8),
(15, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\r\n⇒ Je taunt le boss.\r\n⇒ Je deviens main tank.', 3, NULL, 8),
(16, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\r\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `fs_bloc_role`
--

CREATE TABLE `fs_bloc_role` (
  `bloc_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fs_bloc_role`
--

INSERT INTO `fs_bloc_role` (`bloc_id`, `role_id`) VALUES
(13, 1),
(14, 1),
(15, 1),
(16, 1);

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

--
-- Dumping data for table `fs_boss`
--

INSERT INTO `fs_boss` (`id`, `key`, `name`, `order`, `instance_id`) VALUES
(1, 'serpentrix', 'Serpentrix', 1, 3),
(2, 'parjesh', 'Seigneur de guerre Parjesh', 2, 3),
(3, 'glissefiel', 'Dame Glissefiel', 3, 3),
(4, 'barbefond', 'Roi Barbe-Fond', 4, 3),
(5, 'courrouxazshara', 'Courroux d’Azshara', 5, 3),
(6, 'nythendra', 'Nythendra', 1, 1),
(7, 'elerethe', 'Elerethe Renferal', 2, 1),
(8, 'ilgynoth', 'Il\'gynoth, le Coeur de la Corruption', 3, 1),
(9, 'ursoc', 'Ursoc', 4, 1),
(10, 'dragons_cauchemar', 'Dragons du cauchemar', 5, 1),
(11, 'cenarius', 'Cénarius', 6, 1),
(12, 'xavius', 'Xavius', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs_card`
--

CREATE TABLE `fs_card` (
  `id` int(11) NOT NULL,
  `boss_id` int(11) NOT NULL,
  `difficulty_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fs_card`
--

INSERT INTO `fs_card` (`id`, `boss_id`, `difficulty_id`, `role_id`) VALUES
(1, 2, 3, 2),
(2, 2, 3, 3),
(3, 6, 1, 1),
(4, 6, 1, 2),
(5, 6, 1, 3);

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

--
-- Dumping data for table `fs_difficulty`
--

INSERT INTO `fs_difficulty` (`id`, `key`, `name`, `order`) VALUES
(1, 'nm', 'Mode normal', 1),
(2, 'hm', 'Mode héroïque', 2),
(3, 'mm', 'Mode mythique', 3);

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

--
-- Dumping data for table `fs_instance`
--

INSERT INTO `fs_instance` (`id`, `key`, `name`, `order`, `expanded`, `instance_type_id`) VALUES
(1, 'ce', 'Cauchemar d\'émeraude', 1, 1, 2),
(2, 'ps', 'Palais de Sacrenuit', 2, 0, 2),
(3, 'oeil_aszhara', 'L’Œil d’Azshara', 1, 0, 1),
(4, 'fourre_sombrecoeur', 'Fourré Sombrecœur', 2, 0, 1),
(5, 'repaire_neltharion', 'Repaire de Neltharion', 3, 0, 1),
(6, 'salles_valeureux', 'Salles des Valeureux', 4, 0, 1),
(7, 'fort_pourpre', 'Le fort Pourpre', 5, 0, 1),
(8, 'bastion_freux', 'Bastion du Freux', 6, 0, 1),
(9, 'caveau_gardiennes', 'Caveau des Gardiennes', 7, 0, 1),
(10, 'gueule_ames', 'Gueule des Âmes', 8, 0, 1),
(11, 'arcavia', 'L’Arcavia', 9, 0, 1),
(12, 'cours_etoiles', 'Cour des Étoiles', 10, 0, 1);

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

--
-- Dumping data for table `fs_instance_type`
--

INSERT INTO `fs_instance_type` (`id`, `key`, `name`, `order`) VALUES
(1, 'dj', 'Donjons', 2),
(2, 'ra', 'Raids', 1);

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

--
-- Dumping data for table `fs_role`
--

INSERT INTO `fs_role` (`id`, `key`, `name`, `order`) VALUES
(1, 'tank', 'Tank', 1),
(2, 'heal', 'Heal', 2),
(3, 'dps', 'DPS', 3);

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
-- Dumping data for table `fs_user`
--

INSERT INTO `fs_user` (`id`, `name`, `password`) VALUES
(1, 'globoups', 'e5477ea7bce02dc5a261adaba6acd4c4ba8f45a66c8da0b44910bd7a85874c01');

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
  ADD UNIQUE KEY `boss_id` (`boss_id`,`difficulty_id`,`role_id`),
  ADD KEY `difficulty_id` (`difficulty_id`),
  ADD KEY `role_id` (`role_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `fs_boss`
--
ALTER TABLE `fs_boss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `fs_card`
--
ALTER TABLE `fs_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
