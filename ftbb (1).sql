-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 avr. 2021 à 13:59
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ftbb`
--

-- --------------------------------------------------------

--
-- Structure de la table `classement`
--

CREATE TABLE `classement` (
  `id` int(11) NOT NULL,
  `id_phase` int(11) NOT NULL,
  `id_competition` int(11) NOT NULL,
  `id_team` int(11) NOT NULL,
  `nbr_pts_P` int(11) DEFAULT NULL,
  `nbr_pts_G` int(11) DEFAULT NULL,
  `nbr_pts_D` int(11) DEFAULT NULL,
  `pts_diff` int(11) DEFAULT NULL,
  `nbr_pts` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `classement`
--

INSERT INTO `classement` (`id`, `id_phase`, `id_competition`, `id_team`, `nbr_pts_P`, `nbr_pts_G`, `nbr_pts_D`, `pts_diff`, `nbr_pts`) VALUES
(37, 1, 18, 11, 3, 3, 0, NULL, 6);

-- --------------------------------------------------------

--
-- Structure de la table `competition`
--

CREATE TABLE `competition` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `calendar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `competition`
--

INSERT INTO `competition` (`id`, `name`, `calendar`) VALUES
(18, 'PRO A', NULL),
(19, 'Pro B', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `id_competition` int(11) NOT NULL,
  `id_phase` int(11) NOT NULL,
  `id_week` int(11) NOT NULL,
  `id_team_home` int(11) NOT NULL,
  `id_team_away` int(11) NOT NULL,
  `score_home` int(11) NOT NULL,
  `score_away` int(11) NOT NULL,
  `id_statistique` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `salle` varchar(255) NOT NULL,
  `time` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `phase`
--

CREATE TABLE `phase` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `phase`
--

INSERT INTO `phase` (`id`, `name`) VALUES
(1, 'PlayOff'),
(2, 'PlayOut');

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `id_team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `statistique`
--

CREATE TABLE `statistique` (
  `id` int(11) NOT NULL,
  `doc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_competition` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `team`
--

INSERT INTO `team` (`id`, `name`, `id_competition`, `logo`) VALUES
(11, 'USM', 18, NULL),
(12, 'ASH', 19, NULL),
(13, 'DSG', 19, NULL),
(16, 'ESSA', 18, 'http://127.0.0.1/uploads/img.png');

-- --------------------------------------------------------

--
-- Structure de la table `week`
--

CREATE TABLE `week` (
  `id` int(11) NOT NULL,
  `Name_week` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `week`
--

INSERT INTO `week` (`id`, `Name_week`) VALUES
(1, 'Week 1'),
(2, 'Week 2');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classement`
--
ALTER TABLE `classement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c2` (`id_competition`),
  ADD KEY `ph1` (`id_phase`),
  ADD KEY `t2` (`id_team`);

--
-- Index pour la table `competition`
--
ALTER TABLE `competition`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t3` (`id_team_away`),
  ADD KEY `t4` (`id_team_home`),
  ADD KEY `c3` (`id_competition`),
  ADD KEY `ph2` (`id_phase`),
  ADD KEY `statistique` (`id_statistique`),
  ADD KEY `w1` (`id_week`);

--
-- Index pour la table `phase`
--
ALTER TABLE `phase`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t1` (`id_team`);

--
-- Index pour la table `statistique`
--
ALTER TABLE `statistique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c1` (`id_competition`);

--
-- Index pour la table `week`
--
ALTER TABLE `week`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classement`
--
ALTER TABLE `classement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `competition`
--
ALTER TABLE `competition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `phase`
--
ALTER TABLE `phase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `statistique`
--
ALTER TABLE `statistique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `week`
--
ALTER TABLE `week`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `classement`
--
ALTER TABLE `classement`
  ADD CONSTRAINT `c2` FOREIGN KEY (`id_competition`) REFERENCES `competition` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ph1` FOREIGN KEY (`id_phase`) REFERENCES `phase` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t2` FOREIGN KEY (`id_team`) REFERENCES `team` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `c3` FOREIGN KEY (`id_competition`) REFERENCES `competition` (`id`),
  ADD CONSTRAINT `ph2` FOREIGN KEY (`id_phase`) REFERENCES `phase` (`id`),
  ADD CONSTRAINT `statistique` FOREIGN KEY (`id_statistique`) REFERENCES `statistique` (`id`),
  ADD CONSTRAINT `t3` FOREIGN KEY (`id_team_away`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t4` FOREIGN KEY (`id_team_home`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `w1` FOREIGN KEY (`id_week`) REFERENCES `week` (`id`);

--
-- Contraintes pour la table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `t1` FOREIGN KEY (`id_team`) REFERENCES `team` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `c1` FOREIGN KEY (`id_competition`) REFERENCES `competition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
