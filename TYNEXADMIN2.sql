-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 07 Mai 2012 à 01:36
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `TYNEXADMIN2`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `tel_societe` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `adresse` text,
  `type` enum('Particulier','Entreprise') NOT NULL,
  `gender` enum('Homme','Femme') DEFAULT NULL,
  `societe` varchar(35) DEFAULT NULL,
  `email_societe` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `tel`, `tel_societe`, `fax`, `email`, `adresse`, `type`, `gender`, `societe`, `email_societe`) VALUES
(1, 'Kevin', 'nixon', '0600548565', '', '', 'kevin@gmail.com', 'Bloc A N56 Rabat', 'Particulier', 'Homme', '', ''),
(2, 'Fadili', 'Ahmed', NULL, '0521625342', NULL, NULL, NULL, 'Entreprise', NULL, 'AKWA', 'akwa@akwa.com'),
(3, 'Slimani', 'ahmed', '0621458595', '0562125242', '', 'slimani@kotobia.com', 'Bloc N marrakech', 'Entreprise', 'Homme', 'Koutobia', 'koutobia@kotobia.com'),
(4, 'Omar', 'mahmoud', '', '0534543465', '', 'omar@clubmoving.com', '', 'Entreprise', 'Homme', 'Club Moving', 'moving@clubmoving.com'),
(5, 'ahmadi', 'toriya', '0667564532', '', '', 'touriya.ahmadi@gmail.com', '', 'Particulier', 'Femme', '', ''),
(6, 'Fouad', 'tanjaoui', '0665453426', '', '', 'fouad.tanjaoui@gmail.com', '', 'Particulier', 'Homme', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `libelle_commande` text NOT NULL,
  PRIMARY KEY (`id_commande`),
  UNIQUE KEY `id_commande` (`id_commande`,`id_client`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_client`, `libelle_commande`) VALUES
(1, 1, 'Economic forum, from M.ALAMI'),
(2, 1, 'commande desc');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `texte` varchar(200) NOT NULL,
  `id_employe` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `id_employe` (`id_employe`),
  KEY `id_projet` (`id_projet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `email` varchar(35) NOT NULL,
  `adresse` text NOT NULL,
  `id_poste` int(11) NOT NULL,
  `role` enum('administrateur','invite') NOT NULL DEFAULT 'invite',
  PRIMARY KEY (`id_employe`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `id_poste` (`id_poste`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `employe`
--

INSERT INTO `employe` (`id_employe`, `nom`, `prenom`, `genre`, `username`, `password`, `tel`, `email`, `adresse`, `id_poste`, `role`) VALUES
(2, 'mendili', 'karima', 'Femme', 'karima', 'pass', '0632201252', 'karima@gmail.com', 'Bloc A Agadir', 7, 'administrateur'),
(5, 'test', 'test', 'Homme', 'test', 'test', '0632521245', 'test@test.com', 'bloc chi l3ba', 6, 'invite');

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE IF NOT EXISTS `intervention` (
  `id_employe` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL,
  KEY `id_employe` (`id_employe`),
  KEY `id_projet` (`id_projet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `intervention`
--

INSERT INTO `intervention` (`id_employe`, `id_projet`) VALUES
(2, 58),
(2, 59),
(2, 60),
(2, 61);

-- --------------------------------------------------------

--
-- Structure de la table `occupation`
--

CREATE TABLE IF NOT EXISTS `occupation` (
  `id_occup` int(11) NOT NULL AUTO_INCREMENT,
  `nom_occup` varchar(25) NOT NULL,
  PRIMARY KEY (`id_occup`),
  UNIQUE KEY `nom_occup` (`nom_occup`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `occupation`
--

INSERT INTO `occupation` (`id_occup`, `nom_occup`) VALUES
(12, 'Designer'),
(15, 'Manager'),
(14, 'Network security expert'),
(11, 'Programmer'),
(13, 'SEO expert'),
(16, 'testooo');

-- --------------------------------------------------------

--
-- Structure de la table `occuper`
--

CREATE TABLE IF NOT EXISTS `occuper` (
  `id_employe` int(11) NOT NULL,
  `id_occup` int(11) NOT NULL,
  PRIMARY KEY (`id_employe`,`id_occup`),
  KEY `id_occup` (`id_occup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `occuper`
--

INSERT INTO `occuper` (`id_employe`, `id_occup`) VALUES
(1, 11),
(4, 11),
(5, 12),
(4, 14),
(2, 15),
(3, 15),
(5, 15);

-- --------------------------------------------------------

--
-- Structure de la table `pack`
--

CREATE TABLE IF NOT EXISTS `pack` (
  `id_pack` int(10) NOT NULL AUTO_INCREMENT,
  `libelle_pack` varchar(20) NOT NULL,
  `id_type_service` int(11) NOT NULL,
  PRIMARY KEY (`id_pack`),
  KEY `libelle_pack` (`libelle_pack`),
  KEY `id_type_service` (`id_type_service`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `pack`
--

INSERT INTO `pack` (`id_pack`, `libelle_pack`, `id_type_service`) VALUES
(7, 'Pack Etudiant', 13),
(8, 'Pack Professionnel', 13),
(9, 'Pack Entreprise', 13),
(10, 'Pack Silver', 14),
(11, 'Pack Gold', 14),
(12, 'Pack DÃ©butant', 15),
(13, 'Pack Amateur', 15),
(14, 'Pack Professionnel', 15);

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

CREATE TABLE IF NOT EXISTS `poste` (
  `id_poste` int(11) NOT NULL AUTO_INCREMENT,
  `nom_poste` varchar(15) NOT NULL,
  PRIMARY KEY (`id_poste`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `poste`
--

INSERT INTO `poste` (`id_poste`, `nom_poste`) VALUES
(6, 'Stagiaire'),
(7, 'Personnel'),
(8, 'Freelance');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE IF NOT EXISTS `projet` (
  `id_projet` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `progression` int(11) NOT NULL,
  `status` enum('Actif','Interrompu') NOT NULL,
  `date_debut` text NOT NULL,
  `date_fin` text NOT NULL,
  `id_type_projet` int(11) NOT NULL,
  `paye` enum('Non','Oui') NOT NULL,
  `id_commande` int(11) NOT NULL,
  PRIMARY KEY (`id_projet`),
  KEY `id_type_projet` (`id_type_projet`),
  KEY `id_commande` (`id_commande`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`id_projet`, `description`, `prix`, `progression`, `status`, `date_debut`, `date_fin`, `id_type_projet`, `paye`, `id_commande`) VALUES
(58, 'project desc', 6300, 54, 'Interrompu', '01.05.2012', '27.09.2012', 3, 'Non', 2),
(59, 'project desc', 6300, 100, 'Actif', '01.05.2012', '18.10.2012', 4, 'Non', 2),
(60, 'project desc', 6300, 100, 'Actif', '01.05.2012', '22.05.2012', 4, 'Oui', 2),
(61, 'project desc', 6300, 100, 'Actif', '01.05.2012', '25.05.2012', 4, 'Non', 2);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id_service` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `prix` smallint(6) NOT NULL,
  `date_debut` text NOT NULL,
  `date_fin` text NOT NULL,
  `status` enum('Actif','Interrompu') NOT NULL,
  `id_type_service` int(11) DEFAULT NULL,
  `id_pack` int(11) DEFAULT NULL,
  `paye` enum('Non','Oui') NOT NULL,
  `id_commande` int(11) NOT NULL,
  PRIMARY KEY (`id_service`),
  KEY `id_pack` (`id_pack`),
  KEY `id_commande` (`id_commande`),
  KEY `id_type_service` (`id_type_service`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `service`
--

INSERT INTO `service` (`id_service`, `description`, `prix`, `date_debut`, `date_fin`, `status`, `id_type_service`, `id_pack`, `paye`, `id_commande`) VALUES
(4, 'test service', 1250, '05.01.2012', '21.06.2012', 'Interrompu', 16, NULL, 'Non', 1),
(9, 'service desc', 2300, '05.05.2012', '20.09.2012', 'Interrompu', 13, 14, 'Non', 2),
(10, 'service desc', 2300, '05.05.2012', '20.09.2012', 'Interrompu', 14, 11, 'Non', 2),
(11, 'service desc', 2300, '05.05.2012', '23.05.2012', 'Interrompu', 15, 13, 'Non', 2);

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
(3, 'Desktop application'),
(2, 'Mobile application'),
(4, 'Web application');

-- --------------------------------------------------------

--
-- Structure de la table `type_service`
--

CREATE TABLE IF NOT EXISTS `type_service` (
  `id_type_service` int(10) NOT NULL AUTO_INCREMENT,
  `libelle_type_service` varchar(30) NOT NULL,
  PRIMARY KEY (`id_type_service`),
  UNIQUE KEY `libelle_type_service` (`libelle_type_service`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `type_service`
--

INSERT INTO `type_service` (`id_type_service`, `libelle_type_service`) VALUES
(13, 'Hebergement'),
(14, 'Nom de Domaine'),
(15, 'Referencement'),
(16, 'Vectors');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`id_poste`) REFERENCES `poste` (`id_poste`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `intervention_ibfk_1` FOREIGN KEY (`id_employe`) REFERENCES `employe` (`id_employe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `intervention_ibfk_2` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `occuper`
--
ALTER TABLE `occuper`
  ADD CONSTRAINT `occuper_ibfk_1` FOREIGN KEY (`id_occup`) REFERENCES `occupation` (`id_occup`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `pack`
--
ALTER TABLE `pack`
  ADD CONSTRAINT `pack_ibfk_1` FOREIGN KEY (`id_type_service`) REFERENCES `type_service` (`id_type_service`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_5` FOREIGN KEY (`id_type_projet`) REFERENCES `type_projet` (`id_type_projet`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projet_ibfk_6` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_2` FOREIGN KEY (`id_pack`) REFERENCES `pack` (`id_pack`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_ibfk_3` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_ibfk_4` FOREIGN KEY (`id_type_service`) REFERENCES `type_service` (`id_type_service`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
