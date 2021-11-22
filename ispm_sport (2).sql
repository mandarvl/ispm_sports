-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 19 Décembre 2020 à 03:27
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `ispm_sport`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `idAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  PRIMARY KEY (`idAdmin`),
  UNIQUE KEY `identifiant` (`identifiant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `admins`
--

INSERT INTO `admins` (`idAdmin`, `identifiant`, `nom`, `prenom`, `mdp`) VALUES
(1, 'rLhP2FaaoYyj9kvpj3s+iA==', 'OSQ3OTu65fK0CSZu/HRCtA==', 'HJt0iYMHtiitsG058CIH4g==', 'CDZhH8XDg7ZRY/UqjQxUog==');

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `idClasse` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` tinyint(4) NOT NULL,
  `idFiliere` int(11) NOT NULL,
  PRIMARY KEY (`idClasse`),
  KEY `idFiliere` (`idFiliere`),
  KEY `idFiliere_2` (`idFiliere`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Contenu de la table `classes`
--

INSERT INTO `classes` (`idClasse`, `niveau`, `idFiliere`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 1, 2),
(7, 2, 2),
(8, 3, 2),
(9, 4, 2),
(10, 5, 2),
(11, 1, 3),
(12, 2, 3),
(13, 3, 3),
(14, 4, 3),
(15, 5, 3),
(16, 1, 4),
(17, 2, 4),
(18, 3, 4),
(19, 4, 4),
(20, 5, 4),
(21, 1, 5),
(22, 2, 5),
(23, 3, 5),
(24, 4, 5),
(25, 5, 5),
(26, 1, 6),
(27, 2, 6),
(28, 3, 6),
(29, 4, 6),
(30, 5, 6),
(31, 1, 7),
(32, 2, 7),
(33, 3, 7),
(34, 4, 7),
(35, 5, 7),
(36, 1, 8),
(37, 2, 8),
(38, 3, 8),
(39, 4, 8),
(40, 5, 8);

-- --------------------------------------------------------

--
-- Structure de la table `dates_exception`
--

CREATE TABLE IF NOT EXISTS `dates_exception` (
  `idDate` int(11) NOT NULL AUTO_INCREMENT,
  `debException` date NOT NULL,
  `finException` date NOT NULL,
  PRIMARY KEY (`idDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

CREATE TABLE IF NOT EXISTS `equipes` (
  `idEquipe` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  `idClasse` int(11) NOT NULL,
  `idTournoi` int(11) NOT NULL,
  PRIMARY KEY (`idEquipe`),
  KEY `idClasse` (`idClasse`),
  KEY `idTournoi` (`idTournoi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `equipes`
--

INSERT INTO `equipes` (`idEquipe`, `logo`, `idClasse`, `idTournoi`) VALUES
(1, 'HwMbrkm3SsOXbyMdpsnHKcIfj/KmuFF/9ET54HjmLx+1X2NHqczBeQN/tEG5qCiK', 21, 1),
(2, 'r/d+qAJYhJg9b4F1hxL87q5877hvNroJ9MySA6MjV+a1X2NHqczBeQN/tEG5qCiK', 22, 1),
(3, 'H8OMaFLK8TNMHh/0lWGMd8Ifj/KmuFF/9ET54HjmLx+1X2NHqczBeQN/tEG5qCiK', 36, 1),
(4, '6FHrEDDjFKXiRTbEozeAmgHTb3X7j0SqQ0G6So89wQO1X2NHqczBeQN/tEG5qCiK', 6, 1),
(5, 'E/6ZMmWQr/7GBUhfvd0S01UXRSCgYhNXrEAfK77RYgi1X2NHqczBeQN/tEG5qCiK', 26, 1),
(6, 'vZQ35njgMInQWcRE3kP3fem9I2GjLRFC0UiHsJhEJ/+1X2NHqczBeQN/tEG5qCiK', 11, 1),
(7, 'f4Q7Pga744wgNnpAU9gQH+m9I2GjLRFC0UiHsJhEJ/+1X2NHqczBeQN/tEG5qCiK', 16, 1),
(8, 'qyI7O9oBT73S7LTkgevOa+vZ6KKGz8JrmnQsFXXLSnS1X2NHqczBeQN/tEG5qCiK', 1, 1),
(9, 'daVmmFYeCEjeRy078Ms8POO7s+gBKeuZKCFuu+vyGIS1X2NHqczBeQN/tEG5qCiK', 27, 1),
(10, 'IvoyURjF3ftI56Wcjp5T1irQuim68Ur8DcfN7F48ASq1X2NHqczBeQN/tEG5qCiK', 12, 1),
(11, 'gLml7nYqbHEsRqGuTaVuPSpz0MKR01v46ClYJzek5qW1X2NHqczBeQN/tEG5qCiK', 7, 1),
(12, 'ZBP0446/flw1nm2mMVrI38Ifj/KmuFF/9ET54HjmLx+1X2NHqczBeQN/tEG5qCiK', 17, 1),
(13, 'YmN8kISmih8wdxag9s53HevZ6KKGz8JrmnQsFXXLSnS1X2NHqczBeQN/tEG5qCiK', 31, 1),
(14, 'vwmgNGFyJo4KtYeDJMOHgdL4jztvGlw1pOuGRVTBbHG1X2NHqczBeQN/tEG5qCiK', 2, 1),
(15, 'YkF2feAh70edXV9osUxZaSrQuim68Ur8DcfN7F48ASq1X2NHqczBeQN/tEG5qCiK', 32, 1),
(16, '2P/T2qHolWG8PaDuqJm6JOO7s+gBKeuZKCFuu+vyGIS1X2NHqczBeQN/tEG5qCiK', 37, 1);

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE IF NOT EXISTS `filieres` (
  `idFiliere` int(11) NOT NULL AUTO_INCREMENT,
  `libelleFiliere` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`idFiliere`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `filieres`
--

INSERT INTO `filieres` (`idFiliere`, `libelleFiliere`, `description`) VALUES
(1, 'IGGLIA', 'Informatique, Gestion, Génie Logiciel et Intelligence Artificielle'),
(2, 'IMTICIA', 'Informatique, Multimédia, Technologies de l''Information, de la Télécommunication et Intelligence Artificielle'),
(3, 'FIC', 'Finance et Comptabilité'),
(4, 'ESIIA', 'Electronique, Syst&egrave;mes Informatiques et Intelligence Artificielle'),
(5, 'ISAIA', 'Informatique, Statistiques Appliqu&eacute;es et Intelligence Artificielle'),
(6, 'CAA', 'Commerce et Administration des Affaires'),
(7, 'DTJA', 'Droit et Techniques Juridiques des Affaires '),
(8, 'EMP', 'Economie et Management de Projet');

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE IF NOT EXISTS `matchs` (
  `idMatch` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `idEquipe1` int(11) NOT NULL,
  `idEquipe2` int(11) NOT NULL,
  `score1` varchar(255) DEFAULT NULL,
  `score2` varchar(255) DEFAULT NULL,
  `idTournoi` int(11) NOT NULL,
  `idSport` int(11) NOT NULL,
  PRIMARY KEY (`idMatch`),
  KEY `idMatch` (`idMatch`),
  KEY `idSaison` (`idTournoi`),
  KEY `idSport` (`idSport`),
  KEY `idEquipe1` (`idEquipe1`),
  KEY `idEquipe2` (`idEquipe2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

--
-- Contenu de la table `matchs`
--

INSERT INTO `matchs` (`idMatch`, `date`, `idEquipe1`, `idEquipe2`, `score1`, `score2`, `idTournoi`, `idSport`) VALUES
(1, '2020-12-14', 3, 11, NULL, NULL, 1, 1),
(2, '2020-12-14', 5, 8, NULL, NULL, 1, 1),
(3, '2020-12-15', 15, 2, NULL, NULL, 1, 1),
(4, '2020-12-15', 9, 1, NULL, NULL, 1, 1),
(5, '2020-12-16', 7, 8, NULL, NULL, 1, 1),
(6, '2020-12-16', 12, 13, NULL, NULL, 1, 1),
(7, '2020-12-17', 10, 11, NULL, NULL, 1, 1),
(8, '2020-12-17', 1, 16, NULL, NULL, 1, 1),
(9, '2020-12-18', 13, 16, NULL, NULL, 1, 1),
(10, '2020-12-18', 8, 6, NULL, NULL, 1, 1),
(11, '2020-12-21', 2, 4, NULL, NULL, 1, 1),
(12, '2020-12-21', 4, 11, NULL, NULL, 1, 1),
(13, '2020-12-22', 16, 6, NULL, NULL, 1, 1),
(14, '2020-12-22', 11, 14, NULL, NULL, 1, 1),
(15, '2020-12-23', 14, 6, NULL, NULL, 1, 1),
(16, '2020-12-23', 3, 15, NULL, NULL, 1, 1),
(17, '2020-12-24', 5, 4, NULL, NULL, 1, 1),
(18, '2020-12-24', 15, 7, NULL, NULL, 1, 1),
(19, '2020-12-25', 9, 2, NULL, NULL, 1, 1),
(20, '2020-12-25', 7, 12, NULL, NULL, 1, 1),
(21, '2020-12-28', 12, 8, NULL, NULL, 1, 1),
(22, '2020-12-28', 10, 13, NULL, NULL, 1, 1),
(23, '2020-12-29', 1, 6, NULL, NULL, 1, 1),
(24, '2020-12-29', 13, 6, NULL, NULL, 1, 1),
(25, '2020-12-30', 8, 16, NULL, NULL, 1, 1),
(26, '2020-12-30', 2, 14, NULL, NULL, 1, 1),
(27, '2020-12-31', 4, 16, NULL, NULL, 1, 1),
(28, '2020-12-31', 16, 14, NULL, NULL, 1, 1),
(29, '2021-01-01', 11, 6, NULL, NULL, 1, 1),
(30, '2021-01-04', 3, 6, NULL, NULL, 1, 1),
(31, '2021-01-04', 5, 1, NULL, NULL, 1, 1),
(32, '2021-01-05', 15, 12, NULL, NULL, 1, 1),
(33, '2021-01-05', 9, 10, NULL, NULL, 1, 1),
(34, '2021-01-06', 7, 4, NULL, NULL, 1, 1),
(35, '2021-01-06', 12, 16, NULL, NULL, 1, 1),
(36, '2021-01-07', 10, 2, NULL, NULL, 1, 1),
(37, '2021-01-07', 1, 8, NULL, NULL, 1, 1),
(38, '2021-01-08', 13, 11, NULL, NULL, 1, 1),
(39, '2021-01-08', 8, 14, NULL, NULL, 1, 1),
(40, '2021-01-11', 2, 16, NULL, NULL, 1, 1),
(41, '2021-01-11', 4, 14, NULL, NULL, 1, 1),
(42, '2021-01-12', 16, 11, NULL, NULL, 1, 1),
(43, '2021-01-13', 3, 10, NULL, NULL, 1, 1),
(44, '2021-01-14', 5, 7, NULL, NULL, 1, 1),
(45, '2021-01-14', 15, 6, NULL, NULL, 1, 1),
(46, '2021-01-15', 9, 4, NULL, NULL, 1, 1),
(47, '2021-01-15', 7, 14, NULL, NULL, 1, 1),
(48, '2021-01-18', 12, 2, NULL, NULL, 1, 1),
(49, '2021-01-18', 10, 6, NULL, NULL, 1, 1),
(50, '2021-01-19', 1, 4, NULL, NULL, 1, 1),
(51, '2021-01-19', 13, 4, NULL, NULL, 1, 1),
(52, '2021-01-20', 8, 4, NULL, NULL, 1, 1),
(53, '2021-01-20', 2, 6, NULL, NULL, 1, 1),
(54, '2021-01-21', 4, 6, NULL, NULL, 1, 1),
(55, '2021-01-25', 3, 14, NULL, NULL, 1, 1),
(56, '2021-01-25', 5, 15, NULL, NULL, 1, 1),
(57, '2021-01-26', 15, 8, NULL, NULL, 1, 1),
(58, '2021-01-26', 9, 12, NULL, NULL, 1, 1),
(59, '2021-01-27', 7, 16, NULL, NULL, 1, 1),
(60, '2021-01-27', 12, 11, NULL, NULL, 1, 1),
(61, '2021-01-28', 10, 4, NULL, NULL, 1, 1),
(62, '2021-01-28', 1, 13, NULL, NULL, 1, 1),
(63, '2021-01-29', 13, 8, NULL, NULL, 1, 1),
(64, '2021-01-29', 8, 11, NULL, NULL, 1, 1),
(65, '2021-02-01', 2, 11, NULL, NULL, 1, 1),
(66, '2021-02-03', 3, 13, NULL, NULL, 1, 1),
(67, '2021-02-04', 5, 13, NULL, NULL, 1, 1),
(68, '2021-02-04', 15, 11, NULL, NULL, 1, 1),
(69, '2021-02-05', 9, 13, NULL, NULL, 1, 1),
(70, '2021-02-05', 7, 2, NULL, NULL, 1, 1),
(71, '2021-02-08', 12, 14, NULL, NULL, 1, 1),
(72, '2021-02-08', 10, 1, NULL, NULL, 1, 1),
(73, '2021-02-09', 1, 2, NULL, NULL, 1, 1),
(74, '2021-02-09', 13, 2, NULL, NULL, 1, 1),
(75, '2021-02-10', 8, 2, NULL, NULL, 1, 1),
(76, '2021-02-15', 3, 16, NULL, NULL, 1, 1),
(77, '2021-02-15', 5, 11, NULL, NULL, 1, 1),
(78, '2021-02-16', 15, 10, NULL, NULL, 1, 1),
(79, '2021-02-16', 9, 14, NULL, NULL, 1, 1),
(80, '2021-02-17', 7, 10, NULL, NULL, 1, 1),
(81, '2021-02-17', 12, 6, NULL, NULL, 1, 1),
(82, '2021-02-18', 10, 14, NULL, NULL, 1, 1),
(83, '2021-02-18', 1, 14, NULL, NULL, 1, 1),
(84, '2021-02-19', 13, 14, NULL, NULL, 1, 1),
(85, '2021-02-24', 3, 5, NULL, NULL, 1, 1),
(86, '2021-02-25', 5, 9, NULL, NULL, 1, 1),
(87, '2021-02-25', 15, 9, NULL, NULL, 1, 1),
(88, '2021-02-26', 9, 11, NULL, NULL, 1, 1),
(89, '2021-02-26', 7, 6, NULL, NULL, 1, 1),
(90, '2021-03-01', 12, 4, NULL, NULL, 1, 1),
(91, '2021-03-01', 10, 16, NULL, NULL, 1, 1),
(92, '2021-03-02', 1, 11, NULL, NULL, 1, 1),
(93, '2021-03-08', 3, 1, NULL, NULL, 1, 1),
(94, '2021-03-08', 5, 10, NULL, NULL, 1, 1),
(95, '2021-03-09', 15, 16, NULL, NULL, 1, 1),
(96, '2021-03-09', 9, 8, NULL, NULL, 1, 1),
(97, '2021-03-10', 7, 13, NULL, NULL, 1, 1),
(98, '2021-03-10', 12, 10, NULL, NULL, 1, 1),
(99, '2021-03-11', 10, 8, NULL, NULL, 1, 1),
(100, '2021-03-17', 3, 12, NULL, NULL, 1, 1),
(101, '2021-03-18', 5, 6, NULL, NULL, 1, 1),
(102, '2021-03-18', 15, 4, NULL, NULL, 1, 1),
(103, '2021-03-19', 9, 7, NULL, NULL, 1, 1),
(104, '2021-03-19', 7, 1, NULL, NULL, 1, 1),
(105, '2021-03-22', 12, 1, NULL, NULL, 1, 1),
(106, '2021-03-29', 3, 2, NULL, NULL, 1, 1),
(107, '2021-03-29', 5, 14, NULL, NULL, 1, 1),
(108, '2021-03-30', 15, 14, NULL, NULL, 1, 1),
(109, '2021-03-30', 9, 16, NULL, NULL, 1, 1),
(110, '2021-03-31', 7, 11, NULL, NULL, 1, 1),
(111, '2021-04-07', 3, 8, NULL, NULL, 1, 1),
(112, '2021-04-08', 5, 16, NULL, NULL, 1, 1),
(113, '2021-04-08', 15, 13, NULL, NULL, 1, 1),
(114, '2021-04-09', 9, 6, NULL, NULL, 1, 1),
(115, '2021-04-19', 3, 9, NULL, NULL, 1, 1),
(116, '2021-04-19', 5, 2, NULL, NULL, 1, 1),
(117, '2021-04-20', 15, 1, NULL, NULL, 1, 1),
(118, '2021-04-28', 3, 4, NULL, NULL, 1, 1),
(119, '2021-04-29', 5, 12, NULL, NULL, 1, 1),
(120, '2021-05-10', 3, 7, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sports`
--

CREATE TABLE IF NOT EXISTS `sports` (
  `idSport` int(11) NOT NULL AUTO_INCREMENT,
  `libelleSport` varchar(255) NOT NULL,
  PRIMARY KEY (`idSport`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `sports`
--

INSERT INTO `sports` (`idSport`, `libelleSport`) VALUES
(1, 'Football');

-- --------------------------------------------------------

--
-- Structure de la table `tournois`
--

CREATE TABLE IF NOT EXISTS `tournois` (
  `idTournoi` int(11) NOT NULL AUTO_INCREMENT,
  `nomTournoi` varchar(255) NOT NULL,
  `dateDeb` date NOT NULL,
  `niveauMin` tinyint(4) NOT NULL,
  `niveauMax` tinyint(4) NOT NULL,
  PRIMARY KEY (`idTournoi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `tournois`
--

INSERT INTO `tournois` (`idTournoi`, `nomTournoi`, `dateDeb`, `niveauMin`, `niveauMax`) VALUES
(1, 'Interclasse L1 L2', '2020-12-14', 1, 2);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_id_filiere` FOREIGN KEY (`idFiliere`) REFERENCES `filieres` (`idFiliere`);

--
-- Contraintes pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD CONSTRAINT `fk_id_classe` FOREIGN KEY (`idClasse`) REFERENCES `classes` (`idClasse`),
  ADD CONSTRAINT `fk_id_tournoi_equpe` FOREIGN KEY (`idTournoi`) REFERENCES `tournois` (`idTournoi`);

--
-- Contraintes pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD CONSTRAINT `fk_id_equipe1` FOREIGN KEY (`idEquipe1`) REFERENCES `equipes` (`idEquipe`),
  ADD CONSTRAINT `fk_id_equipe2` FOREIGN KEY (`idEquipe2`) REFERENCES `equipes` (`idEquipe`),
  ADD CONSTRAINT `fk_id_sport` FOREIGN KEY (`idSport`) REFERENCES `sports` (`idSport`),
  ADD CONSTRAINT `fk_id_tournoi_match` FOREIGN KEY (`idTournoi`) REFERENCES `tournois` (`idTournoi`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
