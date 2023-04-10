-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 09 mars 2023 à 11:21
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bddoiseaux`
--

-- --------------------------------------------------------

--
-- Structure de la table `oiseaux`
--

DROP TABLE IF EXISTS `oiseaux`;
CREATE TABLE IF NOT EXISTS `oiseaux` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nb_individue` int(4) NOT NULL,
  `nb_couple` int(4) NOT NULL,
  `indice_nidif` char(50) NOT NULL,
  `remarque` varchar(150) NOT NULL,
  `checkbox` varchar(30) NOT NULL,
  `id_typ` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=213 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `oiseaux`
--

INSERT INTO `oiseaux` (`id`, `nb_individue`, `nb_couple`, `indice_nidif`, `remarque`, `checkbox`, `id_typ`) VALUES
(211, 65, 8, 'E', 'jkhvxjjk', 'value2', 3),
(210, 6, 0, 'C', 'mouder', 'value2, value3', 3),
(209, 5, 45, 'P', 'hananeeeeeeeeeeee', 'value2, value3', 3),
(208, 6, 6, 'P', '2emerrrrr', 'value2', 2),
(207, 5, 5, 'C', 'premierrrrr', 'value1, value2', 1),
(206, 7, 7, '0', '3Ã©me', 'value1,value2,value3', 3),
(212, 8, 5, 'E', 'kjkjl', 'value2', 4);

-- --------------------------------------------------------

--
-- Structure de la table `type_oiseaux`
--

DROP TABLE IF EXISTS `type_oiseaux`;
CREATE TABLE IF NOT EXISTS `type_oiseaux` (
  `id_type` int(4) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_oiseaux`
--

INSERT INTO `type_oiseaux` (`id_type`, `type`) VALUES
(1, 'a'),
(2, 'b'),
(3, 'c'),
(4, 'd');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `password`, `email`) VALUES
(19, '', 'admin@'),
(17, 'Myoutlook1*', 'hananemouder558@gmail.com'),
(14, 'b2bdbd6d1c179498e98a1227976149d7', 'hananemouder@univ-rouen.fr'),
(16, '8ec19704db4e755651b1e00f88b05a3c', 'hananemouder558@gmail.com'),
(18, '8c96e40b2cce707244819adfd0237a2a', 'hananemouder558@gmail.com'),
(20, '', ''),
(22, '$2y$10$Iv6s91RFe4DDjVbxh05k1.tO8gYbRqcG6g6L9P2obudpt5XsakjHC', 'admin@gmail.com'),
(23, '$2y$10$Bsd566D8nctGA4mjfFVATutzneihp9gGnr2MAII6nJv2Uf8H1FBQi', 'hanane@gmail.com'),
(24, '$2y$10$o1Dan6abo9MtZfjSad264eLu2oEWk.kfapnDMm6OShhMZeaMgOvse', 'hanane2@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
