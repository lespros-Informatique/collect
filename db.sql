-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 14 avr. 2026 à 14:14
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_collect`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `code_article` varchar(50) NOT NULL,
  `libelle_article` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `etat_article` int NOT NULL DEFAULT '1',
  `famille_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `image_article` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `campagnes`
--

DROP TABLE IF EXISTS `campagnes`;
CREATE TABLE IF NOT EXISTS `campagnes` (
  `id_campagne` int NOT NULL AUTO_INCREMENT,
  `code_campagne` varchar(50) NOT NULL,
  `libelle_campagne` varchar(150) NOT NULL,
  `entreprise_code` varchar(50) NOT NULL,
  `etat_campagne` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_campagne`),
  UNIQUE KEY `code_campagne` (`code_campagne`),
  KEY `fk_campagne_entreprise` (`entreprise_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `campagnes`
--

INSERT INTO `campagnes` (`id_campagne`, `code_campagne`, `libelle_campagne`, `entreprise_code`, `etat_campagne`) VALUES
(1, 'CAMPPV4WRLLV', 'Campagne 2026', 'ENTRE123456', 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `code_categorie` varchar(50) NOT NULL,
  `libelle_categorie` varchar(100) NOT NULL,
  `description_categorie` text,
  `nombre_jour` int DEFAULT NULL,
  `campagne_code` varchar(50) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `img_categorie` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `etat_categorie` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_categorie`),
  UNIQUE KEY `campagne_code` (`campagne_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COMMENT='la categorie des choix';

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `code_categorie`, `libelle_categorie`, `description_categorie`, `nombre_jour`, `campagne_code`, `date_debut`, `date_fin`, `img_categorie`, `etat_categorie`) VALUES
(1, 'CAT-3DZ33X', 'dsbvwsd', 'xdvwsdvb', 200, '', '2026-04-14 00:00:00', '2026-11-30 00:00:00', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `choix`
--

DROP TABLE IF EXISTS `choix`;
CREATE TABLE IF NOT EXISTS `choix` (
  `id_choix` int NOT NULL AUTO_INCREMENT,
  `code_choix` varchar(50) NOT NULL,
  `categorie_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `libelle_choix` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description_choix` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `cotisation_choix` double NOT NULL,
  `img_choix` text,
  `etat_choix` int NOT NULL DEFAULT '1',
  `deleted_by` int DEFAULT NULL,
  `deleted_why` text,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_choix`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `code_client` varchar(250) DEFAULT NULL,
  `user_code` varchar(50) NOT NULL,
  `nom_client` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `telephone_client` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `quartier_client` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `zone_client` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at_client` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `etat_client` int NOT NULL DEFAULT '1',
  `deleted_why` text,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

DROP TABLE IF EXISTS `demandes`;
CREATE TABLE IF NOT EXISTS `demandes` (
  `id_demande` int NOT NULL AUTO_INCREMENT,
  `code_demande` varchar(50) NOT NULL,
  `total_demande` int NOT NULL,
  `created_at_demande` datetime NOT NULL,
  `etat_demande` int NOT NULL DEFAULT '1',
  `gestionnaire_code` varchar(50) DEFAULT NULL,
  `utilisateur_code` varchar(50) NOT NULL,
  `categorie_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_demande`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

DROP TABLE IF EXISTS `entreprises`;
CREATE TABLE IF NOT EXISTS `entreprises` (
  `id_entreprise` int NOT NULL AUTO_INCREMENT,
  `code_entreprise` varchar(50) NOT NULL,
  `libelle_entreprise` varchar(150) NOT NULL,
  `email_entreprise` varchar(150) NOT NULL,
  `password_entreprise` varchar(255) NOT NULL,
  `etat_entreprise` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_entreprise`),
  UNIQUE KEY `code_entreprise` (`code_entreprise`),
  UNIQUE KEY `email_entreprise` (`email_entreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id_entreprise`, `code_entreprise`, `libelle_entreprise`, `email_entreprise`, `password_entreprise`, `etat_entreprise`) VALUES
(1, 'ENTRE123456', 'Test collect entreprise', 'test@collect.ci', '$2y$10$kxHoUmjW8mz0v9BoFqajrexyR02JttNjF.wyfelmowf1CgbIqu7Sa', 1);

-- --------------------------------------------------------

--
-- Structure de la table `familles`
--

DROP TABLE IF EXISTS `familles`;
CREATE TABLE IF NOT EXISTS `familles` (
  `id_famille` int NOT NULL AUTO_INCREMENT,
  `code_famille` varchar(50) NOT NULL,
  `libelle_famille` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description_famille` text NOT NULL,
  `created_at_famille` datetime NOT NULL,
  `etat_famille` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_famille`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int NOT NULL AUTO_INCREMENT,
  `code_inscription` varchar(100) NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `client_code` varchar(50) NOT NULL,
  `demande_code` varchar(50) NOT NULL,
  `etat_inscription` int NOT NULL DEFAULT '1',
  `type_inscription` varchar(50) DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `deleted_why` text,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_inscription`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_articles`
--

DROP TABLE IF EXISTS `ligne_articles`;
CREATE TABLE IF NOT EXISTS `ligne_articles` (
  `id_ligne_article` int NOT NULL AUTO_INCREMENT,
  `code_ligne_article` varchar(50) NOT NULL,
  `quantite_ligne_article` int NOT NULL,
  `article_code` varchar(50) NOT NULL,
  `choix_code` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL,
  `etat_ligne_article` int NOT NULL,
  `deleted_why` text,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_ligne_article`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_article_inscriptions`
--

DROP TABLE IF EXISTS `ligne_article_inscriptions`;
CREATE TABLE IF NOT EXISTS `ligne_article_inscriptions` (
  `id_ligne_article_inscription` int NOT NULL AUTO_INCREMENT,
  `code_ligne_article_inscription` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ligne_choix_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ligne_article_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `etat_ligne_article_inscription` int DEFAULT '1',
  `deleted_by` int DEFAULT NULL,
  `deleted_why` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `deleted_at` datetime DEFAULT NULL,
  `created_at_ligne_article_inscription` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ligne_article_inscription`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_choix`
--

DROP TABLE IF EXISTS `ligne_choix`;
CREATE TABLE IF NOT EXISTS `ligne_choix` (
  `id_ligne_choix` int NOT NULL AUTO_INCREMENT,
  `code_ligne_choix` varchar(50) NOT NULL,
  `created_at_ligne_choix` datetime NOT NULL,
  `inscription_code` varchar(50) NOT NULL,
  `choix_code` varchar(50) NOT NULL,
  `etat_ligne_choix` int NOT NULL,
  `deleted_why` text,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_ligne_choix`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
CREATE TABLE IF NOT EXISTS `paiements` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `code_paiement` varchar(255) DEFAULT NULL,
  `versement_code` varchar(100) DEFAULT NULL,
  `user_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `inscription_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `montant_paiement` double NOT NULL,
  `telephone_paiement` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `reseau_paiement` varchar(50) DEFAULT NULL,
  `nombre_jour_paye` int NOT NULL,
  `created_at_paiement` datetime DEFAULT NULL,
  `type_paiement` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `statut_paiement` int NOT NULL DEFAULT '1',
  `etat_paiement` int NOT NULL DEFAULT '1',
  `deleted_why` text,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_paiement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rapports`
--

DROP TABLE IF EXISTS `rapports`;
CREATE TABLE IF NOT EXISTS `rapports` (
  `id_rapport` int NOT NULL AUTO_INCREMENT,
  `code_rapport` varchar(100) DEFAULT NULL,
  `date_rapport` datetime NOT NULL,
  `observation` longtext,
  `moyen_paiement` varchar(100) NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `update_id` int DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `etat_rapport` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_rapport`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `retraits`
--

DROP TABLE IF EXISTS `retraits`;
CREATE TABLE IF NOT EXISTS `retraits` (
  `id_retrait` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_retrait` varchar(50) NOT NULL,
  `date_retrait` datetime NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `inscription_code` varchar(50) NOT NULL COMMENT 'ID de l’inscription retirée',
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'JSON contenant les choix et articles retirés',
  `type_retrait` enum('inscription') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'inscription',
  `etat_retrait` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_retrait`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `code_role` varchar(50) NOT NULL,
  `libelle_role` varchar(50) NOT NULL,
  `etat_role` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_role`, `code_role`, `libelle_role`, `etat_role`) VALUES
(1, 'code-admin', 'admin', 1),
(2, 'code-comptable', 'comptable', 1),
(3, 'code-superviseur', 'superviseur', 1),
(4, 'code-commercial', 'commercial', 1);

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
CREATE TABLE IF NOT EXISTS `stocks` (
  `id_stock` int NOT NULL AUTO_INCREMENT,
  `code_stock` varchar(50) NOT NULL,
  `type_mouvement` enum('ENTREE','SORTIE','RETOUR') NOT NULL,
  `quantite_stock` int NOT NULL,
  `date_mouvement` datetime NOT NULL,
  `demande_code` varchar(50) DEFAULT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  `categorie_code` varchar(50) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_stock`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `succursales`
--

DROP TABLE IF EXISTS `succursales`;
CREATE TABLE IF NOT EXISTS `succursales` (
  `id_succursale` int NOT NULL AUTO_INCREMENT,
  `code_succursale` varchar(50) NOT NULL,
  `libelle_succursale` varchar(150) NOT NULL,
  `entreprise_code` varchar(50) NOT NULL,
  `etat_succursale` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_succursale`),
  UNIQUE KEY `code_succursale` (`code_succursale`),
  KEY `fk_succursale_entreprise` (`entreprise_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `succursales`
--

INSERT INTO `succursales` (`id_succursale`, `code_succursale`, `libelle_succursale`, `entreprise_code`, `etat_succursale`) VALUES
(1, 'SUCCCFXFLUZ0', 'Bouaké 01', 'ENTRE123456', 1),
(2, 'SUCCHGFAYZYX', 'Bouaké 02', 'ENTRE123456', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `code_user` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nom_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `prenom_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `telephone_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `quartier_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `zone_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `piece_user` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `photo_user` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `date_created_user` datetime NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `succursale_code` varchar(100) NOT NULL,
  `etat_user` int NOT NULL DEFAULT '1',
  `role_code` varchar(50) NOT NULL,
  `deleted_why` text,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `succursale_code` (`succursale_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `versements`
--

DROP TABLE IF EXISTS `versements`;
CREATE TABLE IF NOT EXISTS `versements` (
  `id_versement` int NOT NULL AUTO_INCREMENT,
  `code_versement` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rapport_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `user_code` varchar(50) NOT NULL,
  `montant_versement` float NOT NULL,
  `date_created_versement` datetime NOT NULL,
  `date_expires_versement` datetime NOT NULL,
  `reseau_versement` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Wave',
  `statut_versement` enum('pending','succès','échec','annulé') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'pending',
  `etat_versement` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_versement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
