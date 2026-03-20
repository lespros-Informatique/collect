-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 20 mars 2026 à 16:27
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `code_article`, `libelle_article`, `etat_article`, `famille_code`, `image_article`) VALUES
(8, 'ART-F66JKX', 'Neque minim cupidata', 1, 'FAM-F7VVP6', 'public/uploads/articles/img_69a86c6c4e5f6_1772645484.png'),
(9, 'ART-M8BEWY', 'ARticle2', 1, 'FAM-I5UAQU', 'public/uploads/articles/img_69a86c7f5c7c1_1772645503.png'),
(10, 'ART-BLR8E2', 'ARticle2', 1, 'FAM-F7VVP6', 'public/uploads/articles/img_69a86c8bcf85e_1772645515.png');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `img_categorie` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `etat_categorie` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COMMENT='la categorie des choix';

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `code_categorie`, `libelle_categorie`, `description_categorie`, `nombre_jour`, `date_debut`, `date_fin`, `img_categorie`, `etat_categorie`) VALUES
(1, 'CAT-2026-001', 'Collecte 2026', 'Programme annuel 2026', 365, '2026-01-01 00:00:00', '2026-12-31 23:59:59', NULL, 1),
(2, 'CAT-LMNRJB', 'quibusdam ratione derelinquo', 'quibusdam ratione derelinquo', 65, '1957-01-18 00:00:00', '1957-01-18 00:00:00', NULL, 1),
(3, 'CAT-113B9E', 'Omnis voluptas amet', 'Adipisicing do et co', 53, '2024-10-11 00:00:00', '2023-05-07 00:00:00', 'public/uploads/categories/img_69a84e8b6687c_1772637835.webp', 1),
(4, 'CAT-LTSD1B', 'pauper nostrum utrimque', 'aucune desc', 28, '2026-03-12 00:00:00', '2026-03-29 00:00:00', 'public/uploads/categories/img_69b2949768b30_1773311127.jpg', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `choix`
--

INSERT INTO `choix` (`id_choix`, `code_choix`, `categorie_code`, `libelle_choix`, `description_choix`, `cotisation_choix`, `img_choix`, `etat_choix`, `deleted_by`, `deleted_why`, `deleted_at`) VALUES
(1, 'CHOIX-KIT-001', 'CAT-2026-001', 'Kit Vaisselle Premium', 'Kit complet pour mariage ou foyer', 500, NULL, 0, 1, 'Suppression', '2026-03-05 00:13:55'),
(2, 'CHOIX-KIT-RQU4IZ', 'CAT-113B9E', 'pauper nostrum utrimque', 'pauper nostrum utrimquea', 25, 'public/uploads/kits/img_69a8d60dbc25b_1772672525.jpg', 1, NULL, NULL, NULL),
(3, 'CHOIX-KIT-U4355U', 'CAT-2026-001', 'pauper nostrum utrimque', 'desc', 25, 'public/uploads/kits/img_69a8a21f9093b_1772659231.png', 1, NULL, NULL, NULL),
(4, 'CHOIX-KIT-CG5K17', 'CAT-2026-001', 'kit1', 'des', 23, 'public/uploads/kits/img_69a8d9f2a6b3f_1772673522.png', 1, NULL, NULL, NULL),
(5, 'CHOIX-KIT-8YCYF9', 'CAT-LMNRJB', 'kit1', 'descr', 23, 'public/uploads/kits/img_69a8dcee4a8b3_1772674286.png', 1, NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `code_client`, `user_code`, `nom_client`, `telephone_client`, `quartier_client`, `zone_client`, `created_at_client`, `etat_client`, `deleted_why`, `deleted_by`, `deleted_at`) VALUES
(1, 'CLIENT-001', '', 'DIALLO Mariam', '0709090909', 'Kennedy', 'Bouake Sud', '2026-01-05 10:00:00', 1, NULL, NULL, NULL),
(2, 'CLIENT-5DBVLE', '', 'Eligendi alias sit', '0566192277', 'Incididunt eum et vo', 'Et et nihil distinct', '2026-03-04 16:14:36', 1, NULL, NULL, NULL),
(3, 'CLIENT-WRIXY7', 'USER-COM-001', 'Eligendi alias sit', '0566192273', 'Incididunt eum et vo', 'Et et nihil distinct', '2026-03-04 16:32:39', 1, NULL, NULL, NULL),
(4, 'CLIENT-IWNZF9', 'USER-COM-001', 'Eligendi alias sit', '0566192270', 'Incididunt eum et vo', 'Et et nihil distinct', '2026-03-04 16:48:23', 1, NULL, NULL, NULL),
(5, 'CLIENT-WDPGTY', 'USER-COM-001', 'Eligendi alias sit', '0566192272', 'Incididunt eum et vo', 'Et et nihil distinct', '2026-03-04 21:31:49', 1, NULL, NULL, NULL);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `familles`
--

INSERT INTO `familles` (`id_famille`, `code_famille`, `libelle_famille`, `description_famille`, `created_at_famille`, `etat_famille`) VALUES
(1, 'FAM-F7VVP6', 'Neque minim cupidata', 'Sit eiusmod cum cons', '2026-03-04 13:57:57', 1),
(2, 'FAM-I5UAQU', 'Neque minim cupidata', 'dd', '2026-03-04 14:29:14', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id_inscription`, `code_inscription`, `user_code`, `client_code`, `demande_code`, `etat_inscription`, `type_inscription`, `date_debut`, `date_fin`, `deleted_why`, `deleted_by`, `deleted_at`) VALUES
(1, 'INS-001', 'USER-COM-001', 'CLIENT-001', '', 1, 'annuel', '2026-01-05 00:00:00', '2026-12-31 23:59:59', NULL, NULL, NULL),
(2, 'INS-LYLXE9', 'USER-COM-001', 'CLIENT-WDPGTY', '', 1, 'annuel', '2026-03-04 23:30:08', '2027-03-04 00:00:00', NULL, NULL, NULL),
(3, 'INS-LPDK3S', 'USER-COM-001', 'CLIENT-001', '', 1, 'annuel', '2026-03-05 00:03:36', '2027-03-05 00:00:00', NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ligne_articles`
--

INSERT INTO `ligne_articles` (`id_ligne_article`, `code_ligne_article`, `quantite_ligne_article`, `article_code`, `choix_code`, `date_created`, `etat_ligne_article`, `deleted_why`, `deleted_by`, `deleted_at`) VALUES
(1, 'LIG-ART-J7MDR9', 1, 'ART-M8BEWY', 'CHOIX-KIT-CG5K17', '2026-03-05 09:43:28', 1, NULL, NULL, NULL),
(2, 'LIG-ART-P0H26O', 1, 'ART-BLR8E2', 'CHOIX-KIT-CG5K17', '2026-03-05 09:45:09', 1, NULL, NULL, NULL),
(3, 'LIG-ART-HOS7GQ', 1, 'ART-F66JKX', 'CHOIX-KIT-CG5K17', '2026-03-05 09:45:09', 1, NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ligne_choix`
--

INSERT INTO `ligne_choix` (`id_ligne_choix`, `code_ligne_choix`, `created_at_ligne_choix`, `inscription_code`, `choix_code`, `etat_ligne_choix`, `deleted_why`, `deleted_by`, `deleted_at`) VALUES
(1, 'LIG-CHOIX-001', '2026-03-03 13:21:42', 'INS-001', 'CHOIX-KIT-001', 1, NULL, NULL, NULL),
(2, 'LIG-CHOIX-5FEKLA', '2026-03-04 23:30:08', 'INS-LYLXE9', 'CHOIX-KIT-RQU4IZ', 1, NULL, NULL, NULL),
(3, 'LIG-CHOIX-7I6R7F', '2026-03-04 23:30:08', 'INS-LYLXE9', 'CHOIX-KIT-U4355U', 1, NULL, NULL, NULL),
(4, 'LIG-CHOIX-QMRY4M', '2026-03-04 23:30:08', 'INS-LYLXE9', 'CHOIX-KIT-001', 1, NULL, NULL, NULL),
(5, 'LIG-CHOIX-CMMM8K', '2026-03-05 00:03:36', 'INS-LPDK3S', 'CHOIX-KIT-U4355U', 1, NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id_paiement`, `code_paiement`, `versement_code`, `user_code`, `inscription_code`, `montant_paiement`, `telephone_paiement`, `reseau_paiement`, `nombre_jour_paye`, `created_at_paiement`, `type_paiement`, `statut_paiement`, `etat_paiement`, `deleted_why`, `deleted_by`, `deleted_at`) VALUES
(1, 'PAY-AJD7J8', NULL, 'USER-COM-001', 'INS-001', 500, NULL, 'ESPECES', 1, '2026-03-05 12:21:17', 'manuel', 1, 1, NULL, NULL, NULL),
(2, 'PAY-03T302', NULL, 'USER-COM-001', 'INS-LYLXE9', 550, NULL, 'ESPECES', 1, '2026-03-05 14:55:36', 'manuel', 1, 1, NULL, NULL, NULL),
(3, 'PAY-8NCU6Z', NULL, 'USER-COM-001', 'INS-LPDK3S', 100, NULL, 'ESPECES', 4, '2026-03-05 14:56:15', 'manuel', 1, 1, NULL, NULL, NULL),
(4, 'PAY-22XOAC', NULL, 'USER-COM-001', 'INS-LPDK3S', 25, NULL, 'ESPECES', 1, '2026-03-05 15:15:04', 'manuel', 1, 1, NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `retraits`
--

INSERT INTO `retraits` (`id_retrait`, `code_retrait`, `date_retrait`, `user_code`, `inscription_code`, `details`, `type_retrait`, `etat_retrait`) VALUES
(1, 'RET-001', '2026-12-31 10:00:00', 'USER-ADMIN-001', 'INS-001', '{\"choix\":\"Kit Vaisselle Premium\",\"articles\":[\"Assiettes 24 pieces\",\"Verres 24 pieces\",\"Casseroles 3 pieces\"]}', 'inscription', 1),
(2, 'RET-MLNXX8', '2026-03-12 10:26:16', 'USER-ADMIN-001', 'INS-LPDK3S', '{\"inscription\":\"INS-LPDK3S\",\"type\":\"inscription\"}', 'inscription', 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `etat_user` int NOT NULL DEFAULT '1',
  `role_code` varchar(50) NOT NULL,
  `deleted_why` text,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `code_user`, `nom_user`, `prenom_user`, `telephone_user`, `email_user`, `password_user`, `quartier_user`, `zone_user`, `piece_user`, `photo_user`, `date_created_user`, `user_code`, `etat_user`, `role_code`, `deleted_why`, `deleted_by`, `deleted_at`) VALUES
(1, 'USER-ADMIN-001', 'KONE', 'Moussa', '0701010101', 'admin@collect.ci', '$2y$10$kxHoUmjW8mz0v9BoFqajrexyR02JttNjF.wyfelmowf1CgbIqu7Sa', 'Commerce', 'Bouake Centre', NULL, NULL, '2026-03-03 13:21:42', 'USER-ADMIN-001', 1, 'code-commercial', NULL, NULL, NULL),
(2, 'USER-COMP-001', 'TRAORE', 'Aminata', '0702020202', 'comptable@collect.ci', '$2y$10$ComptableHashExample', 'Air France', 'Bouake Nord', NULL, NULL, '2026-03-03 13:21:42', 'USER-COMP-001', 1, 'code-comptable', NULL, NULL, NULL),
(3, 'USER-COM-001', 'KOUASSI', 'Jean', '0703030303', 'commercial@collect.ci', '$2y$10$CommercialHashExample', 'Dar Es Salam', 'Bouake Zone 1', NULL, NULL, '2026-03-03 13:21:42', 'USER-COM-001', 1, 'code-commercial', NULL, NULL, NULL);

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
