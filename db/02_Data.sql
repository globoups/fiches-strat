-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2016 at 12:49 PM
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
(16, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\r\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 8),
(17, 2, NULL, 'Général', 1, 14, NULL),
(18, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 17),
(19, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 17),
(20, 1, NULL, 'Phase 1', 2, 14, NULL),
(21, 2, NULL, 'Général', 1, NULL, 20),
(22, 3, NULL, 'Commence au pull.', 1, NULL, 21),
(23, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 21),
(24, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 21),
(25, 2, NULL, 'Mon rôle', 2, NULL, 20),
(26, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 25),
(27, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 25),
(28, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 25),
(29, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 25),
(30, 1, NULL, 'Phase 2', 3, 14, NULL),
(31, 2, NULL, 'Général', 1, NULL, 30),
(32, 2, NULL, 'Mon rôle test', 2, NULL, 30),
(33, 2, NULL, 'Général', 1, 15, NULL),
(34, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 33),
(35, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 33),
(36, 1, NULL, 'Phase 1', 2, 15, NULL),
(37, 2, NULL, 'Général', 1, NULL, 36),
(38, 3, NULL, 'Commence au pull.', 1, NULL, 37),
(39, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 37),
(40, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 37),
(41, 2, NULL, 'Mon rôle', 2, NULL, 36),
(42, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 41),
(43, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 41),
(44, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 41),
(45, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 41),
(46, 1, NULL, 'Phase 2', 3, 15, NULL),
(47, 2, NULL, 'Général', 1, NULL, 46),
(48, 2, NULL, 'Mon rôle test', 2, NULL, 46),
(49, 2, NULL, 'Général', 1, 16, NULL),
(50, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 49),
(51, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 49),
(52, 1, NULL, 'Phase 1', 2, 16, NULL),
(53, 2, NULL, 'Général', 1, NULL, 52),
(54, 3, NULL, 'Commence au pull.', 1, NULL, 53),
(55, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 53),
(56, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 53),
(57, 2, NULL, 'Mon rôle', 2, NULL, 52),
(58, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 57),
(59, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 57),
(60, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 57),
(61, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 57),
(62, 1, NULL, 'Phase 2', 3, 16, NULL),
(63, 2, NULL, 'Général', 1, NULL, 62),
(64, 2, NULL, 'Mon rôle test', 2, NULL, 62),
(65, 2, NULL, 'Général', 1, 17, NULL),
(66, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 65),
(67, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 65),
(68, 1, NULL, 'Phase 1', 2, 17, NULL),
(69, 2, NULL, 'Général', 1, NULL, 68),
(70, 3, NULL, 'Commence au pull.', 1, NULL, 69),
(71, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 69),
(72, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 69),
(73, 2, NULL, 'Mon rôle', 2, NULL, 68),
(74, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 73),
(75, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 73),
(76, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 73),
(77, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 73),
(78, 1, NULL, 'Phase 2', 3, 17, NULL),
(79, 2, NULL, 'Général', 1, NULL, 78),
(80, 2, NULL, 'Mon rôle test', 2, NULL, 78),
(81, 2, NULL, 'Général', 1, 18, NULL),
(82, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 81),
(83, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 81),
(84, 1, NULL, 'Phase 1', 2, 18, NULL),
(85, 2, NULL, 'Général', 1, NULL, 84),
(86, 3, NULL, 'Commence au pull.', 1, NULL, 85),
(87, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 85),
(88, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 85),
(89, 2, NULL, 'Mon rôle', 2, NULL, 84),
(90, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 89),
(91, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 89),
(92, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 89),
(93, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 89),
(94, 1, NULL, 'Phase 2', 3, 18, NULL),
(95, 2, NULL, 'Général', 1, NULL, 94),
(96, 2, NULL, 'Mon rôle test', 2, NULL, 94),
(97, 3, NULL, 'erzerzer', 1, NULL, 96),
(98, 3, NULL, 'azerzer', 2, NULL, 96),
(99, 2, NULL, 'Général', 1, 19, NULL),
(100, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 99),
(101, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 99),
(102, 1, NULL, 'Phase 1', 2, 19, NULL),
(103, 2, NULL, 'Général', 1, NULL, 102),
(104, 3, NULL, 'Commence au pull.', 1, NULL, 103),
(105, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 103),
(106, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 103),
(107, 2, NULL, 'Mon rôle', 2, NULL, 102),
(108, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 107),
(109, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 107),
(110, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 107),
(111, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 107),
(112, 1, NULL, 'Phase 2', 3, 19, NULL),
(113, 2, NULL, 'Général', 1, NULL, 112),
(114, 2, NULL, 'Général', 1, 20, NULL),
(115, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 114),
(116, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 114),
(117, 1, NULL, 'Phase 2', 2, 20, NULL),
(118, 2, NULL, 'Général', 1, NULL, 117),
(119, 1, NULL, 'Phase 1', 3, 20, NULL),
(120, 2, NULL, 'Général', 1, NULL, 119),
(121, 3, NULL, 'Commence au pull.', 1, NULL, 120),
(122, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 120),
(123, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 120),
(124, 2, NULL, 'Mon rôle', 2, NULL, 119),
(125, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 124),
(126, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 124),
(127, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 124),
(128, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 124),
(129, 2, NULL, 'Général', 1, 21, NULL),
(130, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 129),
(131, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 129),
(132, 1, NULL, 'Phase 1', 2, 21, NULL),
(133, 2, NULL, 'Général', 1, NULL, 132),
(134, 3, NULL, 'Commence au pull.', 1, NULL, 133),
(135, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 133),
(136, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 133),
(137, 2, NULL, 'Mon rôle', 2, NULL, 132),
(138, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 137),
(139, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 137),
(140, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 137),
(141, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 137),
(142, 1, NULL, 'Phase 2', 3, 21, NULL),
(143, 2, NULL, 'Général', 1, NULL, 142),
(144, 2, NULL, 'Général', 1, 22, NULL),
(145, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 144),
(146, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 144),
(147, 1, NULL, 'Phase 1', 2, 22, NULL),
(148, 2, NULL, 'Général', 1, NULL, 147),
(149, 3, NULL, 'Commence au pull.', 1, NULL, 148),
(150, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 148),
(151, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 148),
(152, 2, NULL, 'Mon rôle', 2, NULL, 147),
(153, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 152),
(154, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 152),
(155, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 152),
(156, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 152),
(157, 1, NULL, 'Phase 2', 3, 22, NULL),
(158, 2, NULL, 'Général', 1, NULL, 157),
(159, 2, NULL, 'Général', 1, 23, NULL),
(160, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 159),
(161, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 159),
(162, 1, NULL, 'Phase 1', 2, 23, NULL),
(163, 2, NULL, 'Général', 1, NULL, 162),
(164, 3, NULL, 'Commence au pull.', 1, NULL, 163),
(165, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 163),
(166, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 163),
(167, 2, NULL, 'Mon rôle', 2, NULL, 162),
(168, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 167),
(169, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 167),
(170, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 167),
(171, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 167),
(172, 1, NULL, 'Phase 2', 3, 23, NULL),
(173, 2, NULL, 'Général', 1, NULL, 172),
(174, 2, NULL, 'Général', 1, 24, NULL),
(175, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 174),
(176, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 174),
(177, 1, NULL, 'Phase 1', 2, 24, NULL),
(178, 2, NULL, 'Général', 1, NULL, 177),
(179, 3, NULL, 'Commence au pull.', 1, NULL, 178),
(180, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 178),
(181, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 178),
(182, 2, NULL, 'Mon rôle', 2, NULL, 177),
(183, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 182),
(184, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 182),
(185, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 182),
(186, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 182),
(187, 1, NULL, 'Phase 2', 3, 24, NULL),
(188, 2, NULL, 'Général', 1, NULL, 187),
(189, 2, NULL, 'Général', 1, 25, NULL),
(190, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 189),
(191, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 189),
(192, 1, NULL, 'Phase 1', 2, 25, NULL),
(193, 2, NULL, 'Général', 1, NULL, 192),
(194, 3, NULL, 'Commence au pull.', 1, NULL, 193),
(195, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 193),
(196, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 193),
(197, 2, NULL, 'Mon rôle', 2, NULL, 192),
(198, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 197),
(199, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 197),
(200, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 197),
(201, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 197),
(202, 1, NULL, 'Phase 2', 3, 25, NULL),
(203, 2, NULL, 'Général', 1, NULL, 202),
(204, 2, NULL, 'Général', 1, 26, NULL),
(205, 3, NULL, 'Timer d\'enrage : 10 minutes (fin de la 2ème phase 2)', 1, NULL, 204),
(206, 3, NULL, 'Le combat alterne entre la phase 1 et la phase 2.', 2, NULL, 204),
(207, 1, NULL, 'Phase 1', 2, 26, NULL),
(208, 2, NULL, 'Général', 1, NULL, 207),
(209, 3, NULL, 'Commence au pull.', 1, NULL, 208),
(210, 3, NULL, 'Se termine quand l\'énergie du boss arrive à 0.', 2, NULL, 208),
(211, 3, NULL, 'Recommence quand la phase 2 se termine.', 3, NULL, 208),
(212, 2, NULL, 'Mon rôle', 2, NULL, 207),
(213, 3, NULL, 'Je place le boss vers le milieu de la salle.', 1, NULL, 212),
(214, 3, NULL, 'Quand je main tank et que je reçois le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je m\'éloigne le plus possible du raid vers le mur derrière moi puis j\'attends la fin du debuff pour poser les flaques de [wh:spell=203537|Sol contaminé].\n⇒ Je deviens off tank.', 2, NULL, 212),
(215, 3, NULL, 'Quand j\'off tank et que le main tank reçoit le debuff [wh:spell=204463|Pourriture explosive].\n⇒ Je taunt le boss.\n⇒ Je deviens main tank.', 3, NULL, 212),
(216, 3, NULL, 'Quand le boss se tourne vers un joueur et incante [wh:spell=202977|Souffle contaminé].\n⇒ Je ne reste pas devant le boss. Une fois le souffle terminé je retourne à ma place.', 4, NULL, 212);

--
-- Dumping data for table `fs_bloc_role`
--

INSERT INTO `fs_bloc_role` (`bloc_id`, `role_id`) VALUES
(13, 1),
(14, 1),
(15, 1),
(16, 1);

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

--
-- Dumping data for table `fs_card`
--

INSERT INTO `fs_card` (`id`, `boss_id`, `difficulty_id`, `role_id`, `version`, `deleted`, `user_id`) VALUES
(1, 2, 3, 2, 1, 0, 1),
(2, 2, 3, 3, 1, 0, 1),
(3, 6, 1, 1, 1, 0, 1),
(4, 6, 1, 2, 1, 0, 1),
(5, 6, 1, 3, 1, 0, 1),
(6, 2, 3, 2, 2, 1, 1),
(7, 6, 1, 1, 2, 1, 1),
(14, 6, 1, 1, 4, 0, 1),
(13, 6, 1, 1, 3, 0, 1),
(15, 6, 1, 1, 5, 0, 1),
(16, 6, 1, 1, 6, 0, 1),
(17, 6, 1, 1, 7, 0, 1),
(18, 6, 1, 1, 8, 0, 1),
(19, 6, 1, 1, 9, 0, 1),
(20, 6, 1, 1, 10, 0, 1),
(21, 6, 1, 1, 11, 0, 1),
(22, 6, 1, 1, 12, 0, 1),
(23, 6, 1, 1, 13, 0, 1),
(24, 6, 1, 1, 14, 0, 1),
(25, 6, 1, 1, 15, 0, 1),
(26, 6, 1, 1, 16, 0, 1);

--
-- Dumping data for table `fs_difficulty`
--

INSERT INTO `fs_difficulty` (`id`, `key`, `name`, `order`) VALUES
(1, 'nm', 'Mode normal', 1),
(2, 'hm', 'Mode héroïque', 2),
(3, 'mm', 'Mode mythique', 3);

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

--
-- Dumping data for table `fs_instance_type`
--

INSERT INTO `fs_instance_type` (`id`, `key`, `name`, `order`) VALUES
(1, 'dj', 'Donjons', 2),
(2, 'ra', 'Raids', 1);

--
-- Dumping data for table `fs_role`
--

INSERT INTO `fs_role` (`id`, `key`, `name`, `order`) VALUES
(1, 'tank', 'Tank', 1),
(2, 'heal', 'Heal', 2),
(3, 'dps', 'DPS', 3);

--
-- Dumping data for table `fs_user`
--

INSERT INTO `fs_user` (`id`, `name`, `password`) VALUES
(1, 'globoups', 'e5477ea7bce02dc5a261adaba6acd4c4ba8f45a66c8da0b44910bd7a85874c01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
