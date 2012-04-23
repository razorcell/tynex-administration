-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 20 Avril 2012 à 16:15
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `tynexadmin`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `genre_client` enum('Femme','Homme') NOT NULL,
  `tel` varchar(15) NOT NULL,
  `tel2` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `adresse` text NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `genre_client`, `tel`, `tel2`, `fax`, `email`, `adresse`) VALUES
(1, 'Pacha', 'CISSE', 'Femme', '05 27 68 47 0.3', '05 23 56 89 02', '05 26 25 26 24', 'attack2363@yahoo.fr', 'Salam; Dahkla, Agadir'),
(2, 'Phenix', 'Man', 'Femme', '02 56 58 69 45', '05 12 45 78 63 ', '05 25 25 25 25', 'atack23@yahoo.fr', 'Ansermat, Agadir, Maroc');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `libelle_commande` varchar(30) NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_client`, `libelle_commande`) VALUES
(3, 2, 'Application Web'),
(4, 2, 'Application Bureau'),
(5, 2, 'Application Web'),
(6, 2, 'Application Bureau'),
(7, 2, 'Application Web'),
(8, 2, 'Application Bureau'),
(9, 2, 'Application Web'),
(10, 2, 'Application Bureau');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `texte_commentaire` varchar(200) NOT NULL,
  `id_employe` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `id_employe` (`id_employe`),
  KEY `id_projet` (`id_projet`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `texte_commentaire`, `id_employe`, `id_projet`) VALUES
(9, 'xxcbcx cbcx bcvb xcvb', 9, 0),
(10, 'xc vb cb cvbxc', 5, 0),
(11, 'xxcbcx cbcx bcvb xcvb', 9, 0),
(12, 'xc vb cb cvbxc', 5, 0),
(13, 'xxcbcx cbcx bcvb xcvb', 9, 0),
(14, 'xc vb cb cvbxc', 5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE IF NOT EXISTS `employe` (
  `id_employe` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(15) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `genre` enum('Femme','Homme') NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `email` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `id_poste` int(11) NOT NULL,
  PRIMARY KEY (`id_employe`),
  KEY `id_poste` (`id_poste`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `employe`
--

INSERT INTO `employe` (`id_employe`, `nom`, `prenom`, `genre`, `username`, `password`, `tel`, `email`, `adresse`, `id_poste`) VALUES
(5, 'Boul', 'Hassane', 'Femme', 'khalifa', 'khalifa', '02 23 23 2 33', 'hassane@mail.com', 'xgfgfgfg', 2),
(6, 'Farel', 'Man', 'Femme', 'karima', 'karima', '45 45 45 4 5 45', 'farel@mail.com', 'fdhfdfc', 5),
(7, 'Boul', 'Hassane', 'Femme', 'khalifa', 'khalifa', '02 23 23 2 33', 'hassane@mail.com', 'xgfgfgfg', 2),
(8, 'Farel', 'Man', 'Femme', 'karima', 'karima', '45 45 45 4 5 45', 'farel@mail.com', 'fdhfdfc', 5),
(9, 'Boul', 'Hassane', 'Femme', 'khalifa', 'khalifa', '02 23 23 2 33', 'hassane@mail.com', 'xgfgfgfg', 2),
(10, 'Farel', 'Man', 'Femme', 'karima', 'karima', '45 45 45 4 5 45', 'farel@mail.com', 'fdhfdfc', 5);

-- --------------------------------------------------------

--
-- Structure de la table `occupation`
--

CREATE TABLE IF NOT EXISTS `occupation` (
  `id_occup` int(11) NOT NULL AUTO_INCREMENT,
  `nom_occup` varchar(25) NOT NULL,
  PRIMARY KEY (`id_occup`),
  UNIQUE KEY `nom_occup` (`nom_occup`),
  KEY `nom_occup_2` (`nom_occup`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `occupation`
--

INSERT INTO `occupation` (`id_occup`, `nom_occup`) VALUES
(2, 'Agent Commercial'),
(5, 'Developpeur Web'),
(4, 'Finance Manager'),
(6, 'Integrateur'),
(1, 'Programmeur'),
(3, 'Web Designer');

-- --------------------------------------------------------

--
-- Structure de la table `occuper`
--

CREATE TABLE IF NOT EXISTS `occuper` (
  `id_employe` int(11) NOT NULL,
  `id_occup` int(11) NOT NULL,
  PRIMARY KEY (`id_employe`,`id_occup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `occuper`
--


-- --------------------------------------------------------

--
-- Structure de la table `pack_service`
--

CREATE TABLE IF NOT EXISTS `pack_service` (
  `id_pack` int(10) NOT NULL AUTO_INCREMENT,
  `libelle_pack` varchar(20) NOT NULL,
  PRIMARY KEY (`id_pack`),
  UNIQUE KEY `libelle_pack_2` (`libelle_pack`),
  KEY `libelle_pack` (`libelle_pack`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `pack_service`
--

INSERT INTO `pack_service` (`id_pack`, `libelle_pack`) VALUES
(7, 'Audit'),
(8, 'Nom de Domaine'),
(3, 'tm Basic'),
(4, 'tm Business'),
(1, 'tm Etudiant'),
(5, 'tm Pro'),
(2, 'tm Start'),
(6, 'tm VPServer');

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

CREATE TABLE IF NOT EXISTS `poste` (
  `id_poste` int(11) NOT NULL AUTO_INCREMENT,
  `nom_poste` varchar(15) NOT NULL,
  PRIMARY KEY (`id_poste`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `poste`
--

INSERT INTO `poste` (`id_poste`, `nom_poste`) VALUES
(1, 'Personnel'),
(2, 'Stagiaire'),
(5, 'Freelance');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE IF NOT EXISTS `projet` (
  `id_projet` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) NOT NULL,
  `prix` float NOT NULL,
  `progresseion` int(11) NOT NULL,
  `status_projet` enum('Actif','Non-Actif') NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `id_employe` int(11) NOT NULL,
  `id_type_projet` int(11) NOT NULL,
  `payer` enum('Non','Oui') NOT NULL,
  `id_commande` int(11) NOT NULL,
  PRIMARY KEY (`id_projet`),
  KEY `id_employe` (`id_employe`),
  KEY `id_type_projet` (`id_type_projet`),
  KEY `id_commande` (`id_commande`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `projet`
--


-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id_service` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `prix` smallint(6) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `status` enum('Actif','No-Actif') NOT NULL,
  `id_type_service` int(11) NOT NULL,
  `id_pack` int(11) NOT NULL,
  `payer` enum('Non','Oui') NOT NULL,
  `id_commande` int(11) NOT NULL,
  PRIMARY KEY (`id_service`),
  KEY `id_type_service` (`id_type_service`),
  KEY `id_pack` (`id_pack`),
  KEY `id_commande` (`id_commande`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `service`
--

INSERT INTO `service` (`id_service`, `description`, `prix`, `date_debut`, `date_fin`, `status`, `id_type_service`, `id_pack`, `payer`, `id_commande`) VALUES
(1, 'Hebergment', 0, '2012-04-06 11:01:20', '2013-07-24 11:01:25', '', 1, 0, 'Oui', 0),
(2, 'Nom de Domaine', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 4, 0, 'Oui', 0),
(3, 'Hebergment', 0, '2012-04-06 11:01:20', '2013-07-24 11:01:25', 'Actif', 1, 0, 'Oui', 0),
(4, 'Nom de Domaine', 0, '2012-04-06 11:44:16', '2012-04-06 11:44:20', 'Actif', 1, 0, 'Oui', 0);

-- --------------------------------------------------------

--
-- Structure de la table `type_projet`
--

CREATE TABLE IF NOT EXISTS `type_projet` (
  `id_type_projet` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type_projet` varchar(30) NOT NULL,
  PRIMARY KEY (`id_type_projet`),
  UNIQUE KEY `nom_type_projet` (`nom_type_projet`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `type_projet`
--

INSERT INTO `type_projet` (`id_type_projet`, `nom_type_projet`) VALUES
(4, 'Application Bureautique'),
(3, 'Application Web'),
(1, 'Site Web');

-- --------------------------------------------------------

--
-- Structure de la table `type_service`
--

CREATE TABLE IF NOT EXISTS `type_service` (
  `id_type_service` int(10) NOT NULL AUTO_INCREMENT,
  `id_pack` int(11) NOT NULL,
  `libelle_type_service` varchar(30) NOT NULL,
  PRIMARY KEY (`id_type_service`),
  UNIQUE KEY `libelle_type_service` (`libelle_type_service`),
  KEY `id_pack` (`id_pack`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `type_service`
--

INSERT INTO `type_service` (`id_type_service`, `id_pack`, `libelle_type_service`) VALUES
(1, 1, 'Hebergement'),
(2, 2, 'Audit'),
(3, 3, 'Web Design'),
(4, 4, 'Nom de Domaine');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_employe`) REFERENCES `employe` (`id_employe`);

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`id_poste`) REFERENCES `poste` (`id_poste`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`id_employe`) REFERENCES `employe` (`id_employe`),
  ADD CONSTRAINT `projet_ibfk_3` FOREIGN KEY (`id_type_projet`) REFERENCES `type_projet` (`id_type_projet`);

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`id_type_service`) REFERENCES `type_service` (`id_type_service`);

--
-- Contraintes pour la table `type_service`
--
ALTER TABLE `type_service`
  ADD CONSTRAINT `type_service_ibfk_1` FOREIGN KEY (`id_pack`) REFERENCES `pack_service` (`id_pack`);
