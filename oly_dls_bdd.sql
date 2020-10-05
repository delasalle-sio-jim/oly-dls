-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 21 déc. 2019 à 16:08
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+01:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `oly_dls_bdd`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `vider_scores`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `vider_scores` ()  BEGIN
	DELETE FROM oly_dls_bdd.match;
  DELETE FROM oly_dls_bdd.participer;
END$$

DELIMITER ;

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `com_id` int(2) NOT NULL AUTO_INCREMENT,
  `com_login` varchar(20) NOT NULL,
  `com_mdp` varchar(45) NOT NULL,
  `com_num_privilege` int(1) NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`com_id`, `com_login`, `com_mdp`, `com_num_privilege`) VALUES
(1, 'Admin', 'admin', 2),
(2, 'Prof', 'prof', 1);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `equi_id` int(3) NOT NULL AUTO_INCREMENT,
  `equi_nom` varchar(10) NOT NULL,
  PRIMARY KEY (`equi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`equi_id`, `equi_nom`) VALUES
(1, 'SIO1'),
(2, 'SIO2'),
(3, 'SIO3'),
(4, 'SIO4'),
(5, 'SIO5'),
(6, 'CG1'),
(7, 'CG2');

-- --------------------------------------------------------

--
-- Structure de la table `horaire`
--

DROP TABLE IF EXISTS `horaire`;
CREATE TABLE IF NOT EXISTS `horaire` (
  `hor_id` int(2) NOT NULL AUTO_INCREMENT,
  `hor_heure` time NOT NULL,
  PRIMARY KEY (`hor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `horaire`
--

INSERT INTO `horaire` (`hor_id`, `hor_heure`) VALUES
(1, '10:00:00'),
(2, '10:15:00'),
(3, '10:30:00'),
(4, '10:45:00'),
(5, '11:00:00'),
(6, '11:15:00'),
(7, '11:30:00'),
(8, '11:45:00'),
(9, '12:00:00'),
(10, '12:15:00'),
(11, '12:30:00'),
(12, '12:45:00'),
(13, '13:00:00'),
(14, '13:15:00'),
(15, '13:30:00'),
(16, '13:45:00'),
(17, '14:00:00'),
(18, '14:15:00'),
(19, '14:30:00'),
(20, '14:45:00'),
(21, '15:00:00'),
(22, '15:15:00'),
(23, '15:30:00'),
(24, '15:45:00');

-- --------------------------------------------------------

--
-- Structure de la table `jeu`
--

DROP TABLE IF EXISTS `jeu`;
CREATE TABLE IF NOT EXISTS `jeu` (
  `jeu_id` int(3) NOT NULL AUTO_INCREMENT,
  `jeu_nom` varchar(20) NOT NULL,
  `jeu_regle` text NOT NULL,
  `jeu_type` varchar(1) NOT NULL,
  PRIMARY KEY (`jeu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jeu`
--

INSERT INTO `jeu` (`jeu_id`, `jeu_nom`, `jeu_regle`, `jeu_type`) VALUES
(1, 'Chamboultout', 'Dégommer le plus de boîtes possible. 2 équipes, 3 tireurs par équipe et 3 tirs par tireur. L\'équipe qui dégomme le plus de boite remporte l\'épreuve.', 'N'),
(2, 'Bouteille percée', 'Course relai. Transporter de l\'eau d\'un bac à l\'autre avec une bouteille percée. 2 équipes face à face, 7 participants par équipe. L\'équipe qui a le bac le plus rempli remporte l\'épreuve', 'N'),
(3, 'Tire à la corde', '2 équipes tirent, chacun de leur côté, sur une même corde. Une limite centrale démarque chaque côté. L\'équipe qui parvient a tirer l\'autre de son côté à gagné. Si une équipe tombe, elle perd', 'N'),
(4, 'Quest-rep', 'Répondre à des questions de culture générale.', 'B'),
(5, 'Molky', '', 'B');

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

DROP TABLE IF EXISTS `match`;
CREATE TABLE IF NOT EXISTS `match` (
  `mat_jeu` int(3) NOT NULL,
  `mat_equipe` int(3) NOT NULL,
  `mat_horaire` int(2) NOT NULL,
  `mat_nb_point` int(2) DEFAULT NULL,
  PRIMARY KEY (`mat_jeu`,`mat_equipe`,`mat_horaire`),
  KEY `fk_equipe_mat` (`mat_equipe`),
  KEY `fk_horaire_mat` (`mat_horaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `match`
--

INSERT INTO `match` (`mat_jeu`, `mat_equipe`, `mat_horaire`, `mat_nb_point`) VALUES
(1, 1, 1, 10),
(1, 2, 1, 5),
(1, 3, 2, 0),
(2, 1, 3, 10);

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

DROP TABLE IF EXISTS `participer`;
CREATE TABLE IF NOT EXISTS `participer` (
  `par_jeu` int(3) NOT NULL,
  `par_equipe` int(3) NOT NULL,
  `par_nb_point` int(2) NOT NULL,
  PRIMARY KEY (`par_jeu`,`par_equipe`),
  KEY `fk_equipe_par` (`par_equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `participer`
--

INSERT INTO `participer` (`par_jeu`, `par_equipe`, `par_nb_point`) VALUES
(4, 1, 2),
(4, 2, 4),
(4, 3, 7),
(4, 4, 9),
(5, 1, 5);

-- --------------------------------------------------------


--
-- Contraintes pour la table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `fk_equipe_mat` FOREIGN KEY (`mat_equipe`) REFERENCES `equipe` (`equi_id`),
  ADD CONSTRAINT `fk_horaire_mat` FOREIGN KEY (`mat_horaire`) REFERENCES `horaire` (`hor_id`),
  ADD CONSTRAINT `fk_jeu_mat` FOREIGN KEY (`mat_jeu`) REFERENCES `jeu` (`jeu_id`);

--
-- Contraintes pour la table `participer`
--
ALTER TABLE `participer`
  ADD CONSTRAINT `fk_equipe_par` FOREIGN KEY (`par_equipe`) REFERENCES `equipe` (`equi_id`),
  ADD CONSTRAINT `fk_jeu_par` FOREIGN KEY (`par_jeu`) REFERENCES `jeu` (`jeu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE OR REPLACE VIEW `classement_bonus`  AS  select `equipe`.`equi_id` AS `equi_id`,`equipe`.`equi_nom` AS `equi_nom`,sum(`participer`.`par_nb_point`) AS `resultat` , count(participer.par_nb_point) AS jeu_bonus_effectue from (`equipe` left join `participer` on `equipe`.`equi_id` = `participer`.`par_equipe`) group by `equipe`.`equi_id` order by `resultat` desc ;

CREATE OR REPLACE VIEW `classement_normal`  AS  select `equipe`.`equi_id` AS `equi_id`,`equipe`.`equi_nom` AS `equi_nom`,sum(`match`.`mat_nb_point`) AS `resultat`, count(match.mat_nb_point) AS jeu_normal_effectue from (`equipe` left join `match` on `equipe`.`equi_id` = `match`.`mat_equipe`) group by `equipe`.`equi_id` order by `resultat` desc ;

CREATE OR REPLACE VIEW `classement_general`  AS  select `classement_normal`.`equi_id`, `classement_normal`.`equi_nom` AS `equi_nom`,(COALESCE(`classement_normal`.`resultat`, 0) + COALESCE(`classement_bonus`.`resultat`, 0)) AS resultat, jeu_normal_effectue, jeu_bonus_effectue from (`classement_normal` join `classement_bonus`) where (`classement_normal`.`equi_id` = `classement_bonus`.`equi_id`) group by `classement_normal`.`equi_id` order by `resultat` desc ;

CREATE OR REPLACE VIEW planning AS SELECT equi_id, equi_nom, jeu_id, jeu_nom, hor_id, hor_heure FROM equipe, jeu, horaire, oly_dls_bdd.match WHERE equi_id = mat_equipe AND jeu_id = mat_jeu AND hor_id = mat_horaire
