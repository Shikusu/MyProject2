-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 24 mars 2025 à 16:15
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
-- Base de données : `ortm`
--

-- --------------------------------------------------------

--
-- Structure de la table `alertes`
--

DROP TABLE IF EXISTS `alertes`;
CREATE TABLE IF NOT EXISTS `alertes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emetteur_id` bigint UNSIGNED NOT NULL,
  `technicien_id` bigint UNSIGNED DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resolue` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT '0',
  `date_alerte` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `alertes_emetteur_id_foreign` (`emetteur_id`),
  KEY `alertes_technicien_id_foreign` (`technicien_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `alertes`
--

INSERT INTO `alertes` (`id`, `emetteur_id`, `technicien_id`, `message`, `resolue`, `type`, `created_at`, `updated_at`, `resolved`, `date_alerte`, `is_read`) VALUES
(24, 1, 1, 'L\'émetteur 1 est en panne, intervention requise.', 0, 'Problème Réseau', '2025-02-27 11:31:14', '2025-02-27 11:31:14', 0, '2025-02-27 11:31:14', 0),
(17, 6, 3, 'Maintenance préventive effectuée, tout est opérationnel', 0, 'Maintenance Préventive', NULL, NULL, 0, '2025-02-27 09:53:47', 0),
(16, 5, 1, 'Problème d\'alimentation sur le site', 0, 'Problème Réseau', NULL, NULL, 0, '2025-02-27 09:53:47', 0),
(15, 4, 2, 'Émetteur en panne, nécessite un remplacement', 0, 'Panne Matérielle', NULL, NULL, 0, '2025-02-27 09:53:47', 0),
(14, 3, 4, 'Maintenance préventive programmée pour demain', 0, 'Maintenance Préventive', NULL, NULL, 0, '2025-02-27 09:53:47', 0),
(13, 2, 3, 'Problème de réseau, vérification en cours', 0, 'Problème Réseau', NULL, NULL, 0, '2025-02-27 09:53:47', 0),
(12, 1, 2, 'Émetteur défectueux, intervention nécessaire', 0, 'Panne Matérielle', NULL, NULL, 0, '2025-02-27 09:53:47', 0),
(22, 1, 2, 'aaaaaaaaa', 0, 'Panne Matérielle', '2025-02-27 11:24:07', '2025-02-27 11:24:07', 0, '2025-02-27 11:24:07', 0),
(20, 9, 1, 'Mise à jour système requise pour l\'émetteur', 0, 'Maintenance Préventive', NULL, NULL, 0, '2025-02-27 09:53:47', 0),
(21, 10, 3, 'Inspection du matériel nécessaire après alerte', 0, 'Panne Matérielle', NULL, NULL, 0, '2025-02-27 09:53:47', 0),
(23, 1, 2, 'xxxxxxx', 0, 'Maintenance Prévue', '2025-02-27 11:27:33', '2025-02-27 11:27:33', 0, '2025-02-27 11:27:33', 0),
(25, 2, 1, 'L\'émetteur 2 est en panne, intervention requise.', 0, 'Problème Réseau', '2025-03-03 04:33:18', '2025-03-03 04:33:18', 0, '2025-03-03 04:33:18', 0),
(26, 3, 1, 'L\'émetteur 3 est en panne, intervention requise.', 0, 'Panne Matérielle', '2025-03-03 04:54:54', '2025-03-03 04:54:54', 0, '2025-03-03 04:54:54', 0),
(27, 4, 1, 'L\'émetteur 4 est en panne, intervention requise.', 0, 'Maintenance Préventive', '2025-03-03 05:12:05', '2025-03-03 05:12:05', 0, '2025-03-03 05:12:05', 0),
(28, 5, 1, 'L\'émetteur 5 est en panne, intervention requise.', 0, 'Panne Matérielle', '2025-03-03 06:19:59', '2025-03-03 06:19:59', 0, '2025-03-03 06:19:59', 0),
(29, 6, 1, 'L\'émetteur 6 est en panne, intervention requise.', 0, 'Panne Matérielle', '2025-03-03 07:48:59', '2025-03-03 07:48:59', 0, '2025-03-03 07:48:59', 0),
(30, 7, 1, 'L\'émetteur 7 est en panne, intervention requise.', 0, 'Panne Matérielle', '2025-03-03 08:31:33', '2025-03-03 08:31:33', 0, '2025-03-03 08:31:33', 0),
(31, 8, 1, 'L\'émetteur 8 est en panne, intervention requise.', 0, 'Problème Réseau', '2025-03-03 08:44:12', '2025-03-03 08:44:12', 0, '2025-03-03 08:44:12', 0),
(32, 9, 1, 'Ataovy mipoitra amzay moa e', 0, 'Panne Matérielle', '2025-03-03 09:52:54', '2025-03-03 09:52:54', 0, '2025-03-03 09:52:54', 0),
(33, 10, 1, 'Teste declenche panne n°2', 0, 'Panne Matérielle', '2025-03-04 04:25:16', '2025-03-04 04:25:16', 0, '2025-03-04 04:25:16', 0),
(34, 11, 1, 'mba jerena kely azafady', 0, 'Panne Matérielle', '2025-03-04 07:46:57', '2025-03-04 07:46:57', 0, '2025-03-04 07:46:57', 0),
(35, 12, 1, 'Teste voalohany', 0, 'Panne Matérielle', '2025-03-05 09:52:51', '2025-03-05 09:52:51', 0, '2025-03-05 09:52:51', 0),
(36, 13, 1, 'Teste faharoa', 0, 'Problème Réseau', '2025-03-05 10:03:59', '2025-03-05 10:03:59', 0, '2025-03-05 10:03:59', 0),
(37, 14, 1, 'Teste n03', 0, 'Problème Réseau', '2025-03-05 11:16:18', '2025-03-05 11:16:18', 0, '2025-03-05 11:16:18', 0),
(38, 15, 1, 'Mba amboarina azafady', 0, 'Panne Matérielle', '2025-03-07 05:05:00', '2025-03-07 05:05:00', 0, '2025-03-07 05:05:00', 0),
(39, 16, 1, 'Tokony mety amzay anh', 0, 'Maintenance Prévue', '2025-03-07 05:33:29', '2025-03-07 05:33:29', 0, '2025-03-07 05:33:29', 0),
(40, 17, 1, 'Ty amzay nama a', 0, 'Panne Matérielle', '2025-03-07 05:48:32', '2025-03-07 05:48:32', 0, '2025-03-07 05:48:32', 0),
(41, 19, 1, 'ito ndray ohhhh', 0, 'Panne Matérielle', '2025-03-10 03:58:59', '2025-03-10 03:58:59', 0, '2025-03-10 03:58:59', 0),
(42, 18, 1, 'poopy', 0, 'Panne Matérielle', '2025-03-10 04:37:08', '2025-03-10 04:37:08', 0, '2025-03-10 04:37:08', 0),
(43, 21, 1, 'ataovy mande amzay ty ray ty', 0, 'Panne Matérielle', '2025-03-10 05:13:35', '2025-03-10 05:13:35', 0, '2025-03-10 05:13:35', 0),
(44, 20, 1, 'ssssssssssssssssssss', 0, 'Panne Matérielle', '2025-03-10 05:24:24', '2025-03-10 05:24:24', 0, '2025-03-10 05:24:24', 0),
(45, 22, 1, 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 0, 'Panne Matérielle', '2025-03-10 05:46:42', '2025-03-10 05:46:42', 0, '2025-03-10 05:46:42', 0),
(46, 23, 1, 'teste faranyyyy', 0, 'Maintenance Préventive', '2025-03-10 06:07:32', '2025-03-10 06:07:32', 0, '2025-03-10 06:07:32', 0),
(47, 24, 1, 'cocota', 0, 'Panne Matérielle', '2025-03-10 06:42:39', '2025-03-10 06:42:39', 0, '2025-03-10 06:42:39', 0),
(48, 25, 1, 'azertyui', 0, 'Problème Réseau', '2025-03-10 06:49:35', '2025-03-10 06:49:35', 0, '2025-03-10 06:49:35', 0),
(49, 26, 1, 'xxxxxxxxxxxxxxxxxxx', 0, 'Problème Réseau', '2025-03-10 06:51:55', '2025-03-10 06:51:55', 0, '2025-03-10 06:51:55', 0),
(50, 27, 1, 'pppppppppppppppopopopoopo', 0, 'Problème Réseau', '2025-03-10 07:17:16', '2025-03-10 07:17:16', 0, '2025-03-10 07:17:16', 0);

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emetteurs`
--

DROP TABLE IF EXISTS `emetteurs`;
CREATE TABLE IF NOT EXISTS `emetteurs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('radio','television') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_localisation` bigint UNSIGNED NOT NULL,
  `date_installation` date NOT NULL,
  `dernier_maintenance` date DEFAULT NULL,
  `maintenance_prevue` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `panne_declenchee` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `date_panne` date DEFAULT NULL,
  `localisation_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emetteurs_id_localisation_foreign` (`id_localisation`),
  KEY `fk_localisation` (`localisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `emetteurs`
--

INSERT INTO `emetteurs` (`id`, `type`, `id_localisation`, `date_installation`, `dernier_maintenance`, `maintenance_prevue`, `created_at`, `updated_at`, `panne_declenchee`, `status`, `date_panne`, `localisation_id`) VALUES
(21, 'television', 5, '2019-01-30', '2025-03-10', '2025-03-12', '2025-03-10 05:13:08', '2025-03-10 05:13:35', 1, 'panne', '2025-03-22', NULL),
(20, 'radio', 5, '2022-12-26', '2025-03-10', '2025-03-20', '2025-03-10 05:12:35', '2025-03-10 05:24:24', 1, 'panne', '2025-03-12', NULL),
(19, 'television', 4, '2018-12-31', '2025-03-10', '2025-03-26', '2025-03-10 03:58:39', '2025-03-10 03:58:59', 1, 'panne', '2025-03-13', NULL),
(18, 'radio', 4, '2020-01-06', '2025-03-10', '2025-03-21', '2025-03-10 03:58:01', '2025-03-10 04:37:08', 1, 'panne', '2025-03-15', NULL),
(17, 'television', 1, '2021-01-09', '2025-03-07', '2025-03-30', '2025-03-07 05:48:11', '2025-03-07 05:48:32', 1, 'panne', '2025-03-15', NULL),
(16, 'radio', 3, '2018-06-16', '2025-03-07', '2025-04-10', '2025-03-07 05:33:09', '2025-03-07 05:33:29', 1, 'panne', '2025-03-08', NULL),
(15, 'television', 2, '2014-01-10', '2025-03-07', '2025-03-15', '2025-03-07 04:35:55', '2025-03-07 05:05:00', 1, 'panne', '2025-03-08', NULL),
(14, 'radio', 2, '2022-02-02', '2025-03-05', '2025-03-11', '2025-03-05 11:16:01', '2025-03-05 11:16:18', 1, 'panne', '2025-03-10', NULL),
(13, 'radio', 1, '2020-07-01', '2025-03-05', '2025-03-06', '2025-03-05 10:03:34', '2025-03-05 10:03:59', 1, 'panne', '2025-03-09', NULL),
(12, 'television', 1, '2018-01-03', '2025-03-05', '2025-03-21', '2025-03-05 09:52:23', '2025-03-05 09:52:51', 1, 'panne', '2025-03-07', NULL),
(24, 'radio', 6, '2018-02-10', '2025-03-10', '2025-03-28', '2025-03-10 06:42:20', '2025-03-10 06:42:39', 1, 'panne', '2025-03-10', NULL),
(23, 'television', 6, '2018-02-08', '2025-03-10', '2025-03-30', '2025-03-10 06:06:53', '2025-03-10 06:07:32', 1, 'panne', '2025-03-08', NULL),
(25, 'radio', 3, '2022-12-26', '2025-03-10', '2025-04-06', '2025-03-10 06:49:21', '2025-03-10 06:49:35', 1, 'panne', '2025-03-11', NULL),
(26, 'radio', 1, '2025-02-26', '2025-03-10', '2025-04-25', '2025-03-10 06:51:34', '2025-03-10 06:51:55', 1, 'panne', '2025-03-10', NULL),
(27, 'television', 3, '2020-01-16', '2025-03-10', '2025-04-06', '2025-03-10 07:16:58', '2025-03-10 07:17:16', 1, 'panne', '2025-03-11', NULL),
(22, 'radio', 1, '2025-01-01', NULL, NULL, '2025-03-11 13:36:39', '2025-03-11 13:36:39', 0, 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `interventions`
--

DROP TABLE IF EXISTS `interventions`;
CREATE TABLE IF NOT EXISTS `interventions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emetteur_id` bigint UNSIGNED NOT NULL,
  `date_panne` date NOT NULL,
  `type_alerte` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_resolution` timestamp NULL DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fk_emetteur` (`emetteur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `interventions`
--

INSERT INTO `interventions` (`id`, `emetteur_id`, `date_panne`, `type_alerte`, `created_at`, `updated_at`, `date_resolution`, `message`) VALUES
(17, 17, '2025-03-15', 'Panne Matérielle', '2025-03-07 05:48:32', '2025-03-07 05:48:32', NULL, 'Ty amzay nama a'),
(16, 16, '2025-03-08', 'Maintenance Prévue', '2025-03-07 05:33:29', '2025-03-07 05:33:29', NULL, 'Tokony mety amzay anh'),
(15, 15, '2025-03-08', 'Panne Matérielle', '2025-03-07 05:05:00', '2025-03-07 05:05:00', NULL, 'Mba amboarina azafady'),
(14, 14, '2025-03-10', 'Problème Réseau', '2025-03-05 11:16:18', '2025-03-05 11:16:18', NULL, 'Teste n03'),
(12, 12, '2025-03-07', 'Panne Matérielle', '2025-03-05 09:52:51', '2025-03-05 09:52:51', NULL, 'Teste voalohany'),
(13, 13, '2025-03-09', 'Problème Réseau', '2025-03-05 10:03:59', '2025-03-05 10:03:59', NULL, 'Teste faharoa'),
(18, 19, '2025-03-13', 'Panne Matérielle', '2025-03-10 03:58:59', '2025-03-10 03:58:59', NULL, 'ito ndray ohhhh'),
(19, 18, '2025-03-15', 'Panne Matérielle', '2025-03-10 04:37:08', '2025-03-10 04:37:08', NULL, 'poopy'),
(20, 21, '2025-03-22', 'Panne Matérielle', '2025-03-10 05:13:35', '2025-03-10 05:13:35', NULL, 'ataovy mande amzay ty ray ty'),
(21, 20, '2025-03-12', 'Panne Matérielle', '2025-03-10 05:24:24', '2025-03-10 05:24:24', NULL, 'ssssssssssssssssssss'),
(28, 22, '2025-03-06', 'Problème Réseau', '2025-03-13 03:56:50', '2025-03-13 03:56:50', NULL, 'azeuiop'),
(23, 23, '2025-03-08', 'Maintenance Préventive', '2025-03-10 06:07:32', '2025-03-10 06:07:32', NULL, 'teste faranyyyy'),
(24, 24, '2025-03-10', 'Panne Matérielle', '2025-03-10 06:42:39', '2025-03-10 06:42:39', NULL, 'cocota'),
(25, 25, '2025-03-11', 'Problème Réseau', '2025-03-10 06:49:35', '2025-03-10 06:49:35', NULL, 'azertyui'),
(26, 26, '2025-03-10', 'Problème Réseau', '2025-03-10 06:51:55', '2025-03-10 06:51:55', NULL, 'xxxxxxxxxxxxxxxxxxx'),
(27, 27, '2025-03-11', 'Problème Réseau', '2025-03-10 07:17:16', '2025-03-10 07:17:16', NULL, 'pppppppppppppppopopopoopo'),
(29, 22, '2025-03-16', 'Panne Matérielle', '2025-03-20 06:36:38', '2025-03-20 06:36:38', NULL, 'ssssssssssssssssssssssssssssssssss'),
(30, 22, '2025-03-04', 'Panne Matérielle', '2025-03-20 06:40:18', '2025-03-20 06:40:18', NULL, 'qqqqqqqqqqqqqq'),
(31, 22, '2025-03-13', 'Panne Matérielle', '2025-03-20 07:49:30', '2025-03-20 07:49:30', NULL, 'aaaaaaaaaaaaaaaaaaaaaa'),
(32, 22, '2025-03-25', 'Maintenance Préventive', '2025-03-24 05:39:43', '2025-03-24 05:39:43', NULL, 'asdfghj'),
(33, 22, '2025-03-27', 'Panne Matérielle', '2025-03-24 05:53:55', '2025-03-24 05:53:55', NULL, 'sssssssssssss'),
(34, 22, '2025-03-11', 'Problème Réseau', '2025-03-24 10:42:15', '2025-03-24 10:42:15', NULL, 'ssssssssssssssqqqqq'),
(35, 22, '2025-03-14', 'Problème Réseau', '2025-03-24 10:43:48', '2025-03-24 10:43:48', NULL, 'tandremo lesy zanyle'),
(36, 22, '2025-03-06', 'Panne Matérielle', '2025-03-24 10:57:03', '2025-03-24 10:57:03', NULL, 'xoxoxxxxxxxxx'),
(37, 22, '2025-03-14', 'Problème Réseau', '2025-03-24 11:03:03', '2025-03-24 11:03:03', NULL, 'viviviviviviviviviviiviviviviviviv');

-- --------------------------------------------------------

--
-- Structure de la table `intervention_piece`
--

DROP TABLE IF EXISTS `intervention_piece`;
CREATE TABLE IF NOT EXISTS `intervention_piece` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `intervention_id` bigint UNSIGNED NOT NULL,
  `piece_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `intervention_piece_intervention_id_foreign` (`intervention_id`),
  KEY `intervention_piece_piece_id_foreign` (`piece_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `localisations`
--

DROP TABLE IF EXISTS `localisations`;
CREATE TABLE IF NOT EXISTS `localisations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `localisations`
--

INSERT INTO `localisations` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'Antananarivo', '2025-02-27 04:29:16', '2025-02-27 04:29:16'),
(2, 'Toliara', '2025-02-27 04:29:41', '2025-02-27 04:29:41'),
(3, 'Mahajanga', '2025-02-27 04:29:48', '2025-02-27 04:29:48'),
(4, 'Toamasina', '2025-02-27 04:29:55', '2025-02-27 04:29:55'),
(5, 'Fianarantsoa', '2025-02-27 04:30:03', '2025-02-27 04:30:03'),
(6, 'Antsiranana', '2025-02-27 04:30:10', '2025-02-27 04:30:10'),
(7, 'Ihosy', '2025-03-13 08:47:42', '2025-03-13 08:47:42');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(16, '0001_01_01_000000_create_users_table', 1),
(17, '0001_01_01_000001_create_cache_table', 1),
(18, '0001_01_01_000002_create_jobs_table', 1),
(19, '2025_01_23_064558_create_pieces_table', 1),
(20, '2025_02_03_080352_create_localisations_table', 1),
(21, '2025_02_04_081902_create_emetteurs_table', 1),
(22, '2025_02_18_062825_create_alertes_table', 1),
(23, '2025_02_18_071323_add_resolved_to_alertes_table', 1),
(24, '2025_02_25_064724_create_notifications_table', 1),
(25, '2025_02_25_065048_create_interventions_table', 1),
(26, '2025_02_26_083825_add_columns_to_alertes_table', 1),
(27, '2025_02_26_121608_add_panne_declenchee_to_emetteurs_table', 1),
(28, '2025_02_26_124259_add_status_to_emetteurs_table', 1),
(29, '2025_02_26_124955_add_date_panne_to_emetteurs_table', 1),
(30, '2025_02_27_065356_add_date_resolution_to_interventions_table', 1),
(32, '2025_03_03_104622_add_message_to_interventions_table', 2),
(36, '2025_03_04_073157_add_is_declenchee_to_pannes_table', 3),
(37, '2025_03_04_084738_add_is_read_to_alertes_table', 3),
(50, '2025_03_04_103427_create_pannes_table', 4),
(51, '2025_03_13_080643_create_intervention_piece_table', 5);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18446744073709551615 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `data`, `read_at`, `created_at`, `updated_at`, `user_id`, `message`) VALUES
(6727, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"L\'\\u00e9metteur television est en panne, intervention requise.\",\"emetteur_id\":1,\"intervention_id\":1}', NULL, '2025-02-27 11:31:16', '2025-02-27 11:31:16', 0, NULL),
(550, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"L\'\\u00e9metteur radio est en panne, intervention requise.\",\"emetteur_id\":2,\"intervention_id\":2}', NULL, '2025-03-03 04:33:18', '2025-03-03 04:33:18', 0, NULL),
(41, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"L\'\\u00e9metteur television est en panne, intervention requise.\",\"emetteur_id\":3,\"intervention_id\":3}', NULL, '2025-03-03 04:54:54', '2025-03-03 04:54:54', 0, NULL),
(6728, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"L\'\\u00e9metteur radio est en panne, intervention requise.\",\"emetteur_id\":4,\"intervention_id\":4}', NULL, '2025-03-03 05:12:05', '2025-03-03 05:12:05', 0, NULL),
(6729, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"\\u00c9metteur 5 est en panne. Intervention requise.\",\"emetteur_id\":5,\"intervention_id\":5}', NULL, '2025-03-03 06:19:59', '2025-03-03 06:19:59', 0, NULL),
(8, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"\\u00c9metteur 6 est en panne. Intervention requise.\",\"emetteur_id\":6,\"intervention_id\":6}', NULL, '2025-03-03 07:48:59', '2025-03-03 07:48:59', 0, NULL),
(6730, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"\\u00c9metteur 7 est en panne. Intervention requise.\",\"emetteur_id\":7,\"intervention_id\":7}', NULL, '2025-03-03 08:31:33', '2025-03-03 08:31:33', 0, NULL),
(6731, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"\\u00c9metteur 8 est en panne. Intervention requise.\",\"emetteur_id\":8,\"intervention_id\":8}', NULL, '2025-03-03 08:44:12', '2025-03-03 08:44:12', 0, NULL),
(6732, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"\\u00c9metteur 9 est en panne. Intervention requise.\",\"emetteur_id\":9,\"intervention_id\":9}', NULL, '2025-03-03 09:52:54', '2025-03-03 09:52:54', 0, NULL),
(5281891, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"\\u00c9metteur 10 est en panne. Intervention requise.\",\"emetteur_id\":10,\"intervention_id\":10}', NULL, '2025-03-04 04:25:16', '2025-03-04 04:25:16', 0, NULL),
(18446744073709551615, 'App\\Notifications\\PanneDeclencheeNotification', '{\"message\":\"\\u00c9metteur 11 est en panne. Intervention requise.\",\"emetteur_id\":11,\"intervention_id\":11}', NULL, '2025-03-04 07:46:57', '2025-03-04 07:46:57', 0, NULL),
(940, 'App\\Notifications\\AlertePanneNotification', '{\"message\":\"Une panne a \\u00e9t\\u00e9 d\\u00e9tect\\u00e9e pour l\'\\u00e9metteur ID : 13. Interventions requises.\",\"alerte_id\":36,\"emetteur_id\":13}', NULL, '2025-03-05 10:04:02', '2025-03-05 10:04:02', 0, NULL),
(8799, 'App\\Notifications\\AlertePanneNotification', '{\"message\":\"Une panne a \\u00e9t\\u00e9 d\\u00e9tect\\u00e9e pour l\'\\u00e9metteur ID : 14. Interventions requises.\",\"alerte_id\":37,\"emetteur_id\":14}', NULL, '2025-03-05 11:16:18', '2025-03-05 11:16:18', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `pannes`
--

DROP TABLE IF EXISTS `pannes`;
CREATE TABLE IF NOT EXISTS `pannes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_declenchee` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

DROP TABLE IF EXISTS `pieces`;
CREATE TABLE IF NOT EXISTS `pieces` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pieces`
--

INSERT INTO `pieces` (`id`, `nom`, `type`, `quantite`, `created_at`, `updated_at`) VALUES
(14, 'Récepteur DVB-T', 'Récepteur', 10, NULL, NULL),
(13, 'Modulateur numérique', 'Modulateur', 20, NULL, NULL),
(12, 'Amplificateur à gain variable', 'Amplificateur', 15, NULL, NULL),
(11, 'Antenne parabolique', 'Antenne', 10, NULL, NULL),
(16, 'Filtre passe-bas', 'Filtre', 30, NULL, NULL),
(17, 'Câble coaxial RG6', 'Câble coaxial', 50, NULL, NULL),
(18, 'Bloc d?alimentation 12V', 'Bloc d?alimentation', 8, NULL, NULL),
(19, 'Station de contrôle à distance', 'Station de contrôle', 3, NULL, NULL),
(20, 'Ventilateur à haute capacité', 'Ventilateur', 25, NULL, NULL),
(21, 'Antenne sectorielle', 'Antenne', 12, NULL, NULL),
(22, 'Alimentation UPS', 'Alimentation', 7, NULL, NULL),
(23, 'Récepteur satellite à haute définition', 'Récepteur', 6, NULL, NULL),
(24, 'Transmetteur UHF', 'Transmetteur', 14, NULL, NULL),
(25, 'Onduleur à batterie lithium', 'Onduleur', 9, NULL, NULL),
(26, 'Multiplexeur de signal', 'Multiplexeur', 4, NULL, NULL),
(28, 'Serveur de diffusion', 'Serveur', 2, NULL, NULL),
(29, 'Filtre passe-bande actif', 'Filtre', 11, NULL, NULL),
(30, 'Amplificateur RF à large bande', 'Amplificateur RF', 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2NthlMNfFvvBnLqn7GLjFecWkBIciEtjvqW5GO1R', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicEY0MVZtak5PQWZKakZvYnRDYUg4NFIzTlJxTjFUMzg3SDhFVGc5eSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9pbnRlcnZlbnRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1742819678),
('wyXerOW0qjG73xddnbGI6pk1b89FB4rcc42qn7D4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYXlMN1pqUWJVbDI0SFlvWEg1S2MxajRJc1dQbkw1RDRCcVloYlgwUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9pbnRlcnZlbnRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1742819673),
('CNDoGwvGZd57knEsIeEL9qObjxywOz0XEz1ltp5S', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWUxSNHl3NjdmUzdYdmVVUVFXa2tnUDg0b2RYdHBDUlRTM3dnRkxPbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZWNobmljaWVuL2hpc3RvcmlxdWVzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1742824994);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','technicien') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'technicien',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'adminr@gmail.com', NULL, '$2y$12$WBYTsAdh.K9wujQstH2ZYOy4z524xp4cZHnKKTeiv4oV33AllAA5W', 'admin', NULL, '2025-02-27 04:24:48', '2025-02-27 04:24:48'),
(2, 'Nasandratra', 'nasandratrar@gmail.com', NULL, '$2y$12$SyMcgfsYT5GfDCkEEMKkp.jFlQSWEL7E21B.eDgPZ9e6MOcj80MRS', 'technicien', NULL, '2025-02-27 04:25:10', '2025-02-27 04:25:10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
