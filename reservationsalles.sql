-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 21, 2021 at 09:36 PM
-- Server version: 5.7.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `reservationsalles`
--
CREATE DATABASE IF NOT EXISTS `reservationsalles` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `reservationsalles`;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text,
  `debut` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES
(2, 'premier meeting', 'avec le boss et les actionnaires', '2021-01-05 16:00:00', '2021-01-05 17:00:00', 4),
(3, 'RDV avec les actionnnaires', 'V&eacute;rification du march&eacute; avec les actionnaires.', '2021-01-08 10:00:00', '2021-01-08 11:00:00', 4),
(4, 'RDV avec les actionnnaires', 'V&eacute;rification du march&eacute; avec les actionnaires.', '2021-01-08 10:00:00', '2021-01-08 11:00:00', 4),
(5, 'test: antidat&eacute;', 'test pour voir si je peux rajouter un &eacute;v&eacute;nement anti-dat&eacute;.', '2021-01-04 09:00:00', '2021-01-04 10:00:00', 4),
(7, 'RDV avec les actionnaires', 'test, donc', '2021-01-11 16:00:00', '2021-01-11 17:00:00', 3),
(8, 'HowTo \"Apprendre à apprendre\"', 'ça pourrait être utile... ', '2021-01-12 16:00:00', '2021-01-12 17:00:00', 1),
(9, 'Réussir dans la vie', 'Tout est dans le titre... Osez réussir, enfin c\'est quand même pas compliqué!', '2021-01-13 16:00:00', '2021-01-13 17:00:00', 4),
(10, 'café-philo', 'Savoir en finir sans se louper, quand on a raté sa vie', '2021-01-13 17:00:00', '2021-01-13 18:00:00', 2),
(11, 'Conférence: les bienfaits de la méditation', 'pour les grands et les petits, de 7 à 77 ans, avec un masque et avec son coussin de méditation: venez nombreux!', '2021-01-15 10:00:00', '2021-01-15 13:00:00', 2),
(12, 'café-philo: la bière: avec ou sans faux-col?', 'Nous posons cette question si importante en temps de pandémie, autour d\'un verre de vin rouge et des masques FFP2.', '2021-01-20 09:00:00', '2021-01-20 10:00:00', 5),
(13, 'Concert unplugged marathon', 'Mes plus grands succès, seul accompagné par un kazoo.', '2021-01-21 08:00:00', '2021-01-21 11:00:00', 3),
(14, 'Masterclass: les nombres premiers', 'tout savoir sur les nombres premiers, et tous les connaitre.', '2021-01-19 13:00:00', '2021-01-19 15:00:00', 5),
(15, 'howTo: drop tables', 'Un vrai sujet pour tous', '2021-01-20 17:00:00', '2021-01-20 18:00:00', 1),
(16, 'goûter avec les actionnaires', 'avec des Chocapics et du Fanta.', '2021-01-21 16:00:00', '2021-01-21 17:00:00', 4),
(17, 'howTo: readymade', 'Vous aussi vous pouvez marquer l\'histoire de l\'art avec une pissotière (si vous en trouvez une)!', '2021-01-20 15:00:00', '2021-01-20 17:00:00', 2),
(19, 'test pour Jeudi 28 janvier', 'test, donc', '2021-01-28 11:00:00', '2021-01-28 12:00:00', 5),
(20, 'méditation collective', 'oooooooooooooom', '2021-01-22 08:00:00', '2021-01-22 15:00:00', 5),
(21, 'groupe tupperware', 'découvert des produits phares', '2021-01-25 08:00:00', '2021-01-25 10:00:00', 4),
(22, 'Body-Pump', 'cardio-muscu', '2021-01-25 11:00:00', '2021-01-25 13:00:00', 1),
(23, 'séance de dédicace', 'venez avec vos goodies', '2021-01-26 10:00:00', '2021-01-26 12:00:00', 3),
(24, 'Tournoi de Combat de coq', 'à mort', '2021-01-27 11:00:00', '2021-01-27 18:00:00', 5),
(25, 'Dégustation de beaujollais Nouveau, mais vieux', 'Viendez!', '2021-01-26 14:00:00', '2021-01-26 16:00:00', 2),
(26, 'méditation collective', 'deuxième séance', '2021-01-25 14:00:00', '2021-01-25 17:00:00', 5),
(27, 'jam-session', 'venez avec vos instruments\r\n', '2021-01-27 10:00:00', '2021-01-27 11:00:00', 8),
(28, '4\'33&quot;', 'Un long moment de silence', '2021-02-02 10:00:00', '2021-02-02 14:00:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(1, 'Mrs Roberts', '$2y$10$Vb1IKQvKzoJ/Iu9cqO/i3OlBEJFcFXU7b.QJAw/sofs./MvEMgm7u'),
(2, 'duchamp', '$2y$10$DFADcG5l.OcosZB.yi816efdKUJqoK9bFpJpApYkYWeUDy/qBCRjm'),
(3, 'sardou', '$2y$10$f1IzUiLovp15GfC4nfHueu5a6PoH2p7vUkfcUpLBzUDdMJLwMMqMK'),
(4, 'johndoe', '$2y$10$Rq6rcFQrKZKZm427w2qCjeP5HDKq6hl2Xq05hd0/KfSnVEhKiB3EK'),
(5, 'stockhausen', '$2y$10$e5zT.FwjLTGcUyS1ODAasucsxiK7tY1/gKn7tBV.556avY7BmN60i'),
(6, 'user', '$2y$10$MgcyIyrhgjma.1qZvtoUBeTzpaL9Z7xx1FP7.Fw5xbDyg3irtAmIy'),
(7, 'user1', '$2y$10$qS4mXwUuOZX60p5lup0zF.lTw7YIjqYUBe3Bf/xcyK.f80XGhxB4G'),
(8, 'boulez', '$2y$10$BPVxliitHSlKlJSMomzihOumy7fAanUZYWeUucEVYBZv/LV27f/wi'),
(9, 'johncage', '$2y$10$p7Y9r6ewz8zSqHUOqgSjQe4wZn40vNipSpXCZIHD7tb6PKCtKUocW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
