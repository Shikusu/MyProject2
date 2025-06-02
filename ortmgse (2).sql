-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 02 juin 2025 à 06:34
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
-- Base de données : `ortmgse`
--

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
  `reference` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('radio','television') COLLATE utf8mb4_unicode_ci NOT NULL,
  `localisation_id` bigint UNSIGNED NOT NULL,
  `date_installation` date NOT NULL,
  `derniere_maintenance` date DEFAULT NULL,
  `maintenance_prevue` date DEFAULT NULL,
  `status` enum('Actif','En panne','En cours de réparation') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Actif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `panne_declenchee` tinyint(1) NOT NULL DEFAULT '0',
  `date_panne` date DEFAULT NULL,
  `date_entree` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emetteurs_reference_unique` (`reference`),
  KEY `emetteurs_localisation_id_foreign` (`localisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `emetteurs`
--

INSERT INTO `emetteurs` (`id`, `reference`, `type`, `localisation_id`, `date_installation`, `derniere_maintenance`, `maintenance_prevue`, `status`, `created_at`, `updated_at`, `panne_declenchee`, `date_panne`, `date_entree`, `date_sortie`) VALUES
(65, 'ET - 12345', 'television', 12, '2024-02-14', '2025-04-02', '2025-09-05', 'En panne', '2025-05-26 09:18:37', '2025-05-28 11:15:11', 1, '2025-05-26', NULL, NULL),
(66, 'ER - 12345', 'radio', 15, '2024-04-30', '2025-05-17', '2025-05-28', 'En cours de réparation', '2025-05-26 09:30:56', '2025-05-27 09:28:05', 1, '2025-05-22', NULL, NULL),
(67, 'ET - 00013', 'television', 9, '2024-01-31', '2025-05-28', '2025-06-19', 'En panne', '2025-05-26 11:29:33', '2025-05-28 11:16:40', 1, '2025-05-24', NULL, NULL),
(68, 'ER - 00027', 'radio', 10, '2025-05-26', '2025-05-28', '2025-05-31', 'Actif', '2025-05-26 12:01:23', '2025-05-28 09:20:54', 1, '2025-05-02', NULL, NULL),
(69, 'ER - 00028', 'radio', 11, '2025-05-26', '2025-05-28', '2025-05-29', 'Actif', '2025-05-27 03:02:50', '2025-05-28 09:20:54', 1, '2025-05-18', NULL, NULL),
(70, 'ET - 00026', 'television', 3, '2025-05-27', '2025-05-27', '2025-06-01', 'Actif', '2025-05-27 03:07:54', '2025-05-28 07:27:56', 1, '2025-05-07', NULL, NULL),
(71, 'ER - 23456', 'radio', 4, '2025-04-29', '2025-04-29', '2025-07-10', 'En panne', '2025-05-27 03:23:32', '2025-05-27 11:16:25', 1, '2025-05-01', NULL, NULL);

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
  `piece_id` bigint UNSIGNED DEFAULT NULL,
  `date_panne` date NOT NULL,
  `type_alerte` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `date_reparation` date DEFAULT NULL,
  `pieces_utilisees` text COLLATE utf8mb4_unicode_ci,
  `description_reparation` text COLLATE utf8mb4_unicode_ci,
  `etat` enum('en attente','réparé','en cours') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_resolution` timestamp NULL DEFAULT NULL,
  `date_reparation_fait` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `interventions_emetteur_id_foreign` (`emetteur_id`),
  KEY `interventions_piece_id_foreign` (`piece_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `interventions`
--

INSERT INTO `interventions` (`id`, `emetteur_id`, `piece_id`, `date_panne`, `type_alerte`, `message`, `date_reparation`, `pieces_utilisees`, `description_reparation`, `etat`, `created_at`, `updated_at`, `date_resolution`, `date_reparation_fait`) VALUES
(18, 43, NULL, '2025-05-24', 'Panne matériel', 'simbaaa', '2025-06-08', NULL, NULL, 'en attente', '2025-05-25 10:40:51', '2025-05-25 10:42:18', NULL, '2025-05-25'),
(19, 65, NULL, '2025-05-08', 'Panne matériel', 'Panne urgent', '2025-05-31', NULL, NULL, 'en attente', '2025-05-27 08:00:41', '2025-05-27 09:22:19', NULL, '2025-05-27'),
(17, 38, NULL, '2025-05-15', 'Panne matériel', 'zeifbjkjkfbrfkjzbdbc', '2025-05-31', NULL, NULL, 'en attente', '2025-05-24 07:12:06', '2025-05-24 07:12:58', NULL, '2025-05-24'),
(14, 26, NULL, '2025-05-18', 'Panne matériel', 'Panne urgent', '2025-05-21', NULL, NULL, 'en attente', '2025-05-21 05:06:31', '2025-05-21 05:07:36', NULL, '2025-05-21'),
(15, 27, NULL, '2025-05-20', 'Panne matériel', 'bbbbbbbbbbb', '2025-05-21', NULL, NULL, 'en attente', '2025-05-21 05:43:01', '2025-05-21 05:43:35', NULL, '2025-05-21'),
(16, 44, NULL, '2025-05-21', 'Problème réseau', 'Panne réseaux', '2025-05-24', NULL, NULL, 'en attente', '2025-05-24 06:55:51', '2025-05-24 06:58:08', NULL, '2025-05-24'),
(13, 23, NULL, '2025-05-19', 'Panne matériel', 'Vonjeoo eeeee', '2025-06-08', NULL, NULL, 'en attente', '2025-05-20 04:06:24', '2025-05-20 06:09:23', NULL, '2025-05-20'),
(12, 24, NULL, '2025-05-10', 'Panne matériel', 'Panne Urgente', '2025-05-18', NULL, NULL, 'en attente', '2025-05-12 04:41:44', '2025-05-12 05:07:57', NULL, '2025-05-12'),
(11, 22, NULL, '2025-05-03', 'Panne matériel', 'azertyuiop', '2025-05-25', NULL, NULL, 'en attente', '2025-05-09 05:53:48', '2025-05-09 06:10:08', NULL, '2025-05-09'),
(10, 23, NULL, '2025-05-08', 'Problème réseau', 'Panne urgent (2)', '2025-05-10', NULL, NULL, 'en attente', '2025-05-09 05:22:12', '2025-05-09 05:52:48', NULL, '2025-05-09'),
(9, 24, NULL, '2025-04-23', 'Panne matériel', 'Panne URGENT', '2025-05-09', NULL, NULL, 'en attente', '2025-04-24 04:42:54', '2025-05-08 03:52:03', NULL, '2025-05-08'),
(20, 66, NULL, '2025-05-22', 'Panne matériel', 'azertyuio', '2025-06-08', NULL, NULL, 'en attente', '2025-05-27 09:27:28', '2025-05-27 09:28:05', NULL, '2025-05-27'),
(21, 67, NULL, '2025-05-20', 'Panne matériel', 'qsdfghjklm', '2025-05-27', NULL, NULL, 'en attente', '2025-05-27 09:56:50', '2025-05-27 09:57:40', NULL, '2025-05-27'),
(22, 68, NULL, '2025-05-02', 'Panne matériel', 'ssssssssssssss', '2025-05-27', NULL, NULL, 'en attente', '2025-05-27 10:13:05', '2025-05-27 11:14:34', NULL, '2025-05-27'),
(23, 69, NULL, '2025-05-18', 'Problème réseau', 'wwwwwwwwww', '2025-05-27', NULL, NULL, 'en attente', '2025-05-27 10:13:17', '2025-05-27 10:14:15', NULL, '2025-05-27'),
(24, 70, NULL, '2025-05-07', 'Panne matériel', 'bbbbbbbbbbbbbb', '2025-06-01', NULL, NULL, 'en attente', '2025-05-27 11:15:19', '2025-05-28 07:27:56', NULL, '2025-05-28'),
(25, 71, NULL, '2025-05-01', 'Panne matériel', 'ddddddddddddd', NULL, NULL, NULL, 'en attente', '2025-05-27 11:16:25', '2025-05-27 11:16:25', NULL, NULL),
(26, 65, NULL, '2025-05-26', 'Panne matériel', 'qsdfghjkrftrfdcd', NULL, NULL, NULL, 'en attente', '2025-05-28 11:15:11', '2025-05-28 11:15:11', NULL, NULL),
(27, 67, NULL, '2025-05-24', 'Problème réseau', 'hjbhjjvhgvnb', NULL, NULL, NULL, 'en attente', '2025-05-28 11:16:40', '2025-05-28 11:16:40', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `intervention_piece`
--

INSERT INTO `intervention_piece` (`id`, `intervention_id`, `piece_id`, `created_at`, `updated_at`) VALUES
(1, 3, 11, '2025-04-22 10:32:11', '2025-04-22 10:32:11'),
(2, 1, 4, '2025-04-22 10:34:14', '2025-04-22 10:34:14'),
(3, 2, 12, '2025-04-22 10:36:36', '2025-04-22 10:36:36'),
(4, 4, 14, '2025-04-22 10:39:07', '2025-04-22 10:39:07'),
(5, 5, 13, '2025-04-23 07:42:51', '2025-04-23 07:42:51'),
(6, 5, 18, '2025-04-23 07:42:51', '2025-04-23 07:42:51'),
(7, 9, 12, '2025-05-08 03:52:03', '2025-05-08 03:52:03'),
(8, 10, 17, '2025-05-09 05:52:48', '2025-05-09 05:52:48'),
(9, 11, 13, '2025-05-09 06:10:08', '2025-05-09 06:10:08'),
(10, 12, 9, '2025-05-12 05:07:57', '2025-05-12 05:07:57'),
(11, 12, 26, '2025-05-12 05:07:57', '2025-05-12 05:07:57'),
(12, 13, 17, '2025-05-20 06:09:23', '2025-05-20 06:09:23'),
(13, 14, 19, '2025-05-21 05:07:36', '2025-05-21 05:07:36'),
(14, 16, 19, '2025-05-24 06:58:08', '2025-05-24 06:58:08'),
(15, 16, 17, '2025-05-24 06:58:08', '2025-05-24 06:58:08'),
(16, 18, 16, '2025-05-25 10:42:18', '2025-05-25 10:42:18');

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `localisations`
--

INSERT INTO `localisations` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(5, 'Toliara', NULL, NULL),
(4, 'Mahajanga', NULL, NULL),
(3, 'Fianarantsoa', NULL, NULL),
(2, 'Toamasina', NULL, NULL),
(1, 'Antananarivo', NULL, NULL),
(6, 'Antsiranana', NULL, NULL),
(7, 'Ambatondrazaka', NULL, NULL),
(8, 'Moramanga', NULL, NULL),
(9, 'Manakara', NULL, NULL),
(10, 'Nosy Be', NULL, NULL),
(11, 'Sambava', NULL, NULL),
(12, 'Antsirabe', NULL, NULL),
(13, 'Farafangana', NULL, NULL),
(14, 'Ambositra', NULL, NULL),
(15, 'Ihosy', NULL, NULL),
(16, 'Marovoay', NULL, NULL),
(17, 'Vatomandry', NULL, NULL),
(18, 'Amboasary Atsimo', NULL, NULL),
(19, 'Andapa', NULL, NULL),
(20, 'Tsiroanomandidy', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_23_064558_create_pieces_table', 1),
(5, '2025_02_03_080352_create_localisations_table', 1),
(6, '2025_02_04_081902_create_emetteurs_table', 1),
(7, '2025_02_18_062825_create_alertes_table', 1),
(8, '2025_02_18_071323_add_resolved_to_alertes_table', 1),
(9, '2025_02_25_065048_create_interventions_table', 1),
(10, '2025_02_26_083825_add_columns_to_alertes_table', 1),
(11, '2025_02_26_121608_add_panne_declenchee_to_emetteurs_table', 1),
(12, '2025_02_26_124259_add_status_to_emetteurs_table', 1),
(13, '2025_02_26_124955_add_date_panne_to_emetteurs_table', 1),
(14, '2025_02_27_065356_add_date_resolution_to_interventions_table', 1),
(15, '2025_03_03_104622_add_message_to_interventions_table', 1),
(16, '2025_03_04_073157_add_is_declenchee_to_pannes_table', 1),
(17, '2025_03_04_084738_add_is_read_to_alertes_table', 1),
(18, '2025_03_04_103427_create_pannes_table', 1),
(19, '2025_03_13_080643_create_intervention_piece_table', 1),
(20, '2025_03_26_134624_create_stations_table', 1),
(21, '2025_03_27_113220_intervention', 1),
(22, '2025_03_28_061506_update_intervention', 1),
(23, '2025_04_18_114719_remove_type_from_notifications_table', 1),
(24, '2025_04_18_120730_create_notifications_table', 2),
(26, '2025_05_26_061119_add_matricule_prenom_photo_to_users_table', 3),
(27, '2025_05_26_083655_add_reference_to_emetteur_table', 3),
(28, '2025_05_26_084553_add_unique_reference_to_emetteurs', 4),
(29, '2025_05_27_114014_add_dates_to_emetteurs_table', 5);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `est_lu` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `user_id`, `est_lu`, `created_at`, `updated_at`) VALUES
(1, 'La radio localisée à Mahajanga est en panne', 1, 1, '2025-04-22 10:07:46', '2025-04-22 10:34:21'),
(2, 'La television localisée à Ihosy est en panne', 1, 1, '2025-04-22 10:12:07', '2025-04-22 10:34:23'),
(3, 'La television localisée à Ihosy est en cours de réparation', 2, 1, '2025-04-22 10:32:11', '2025-04-22 10:32:40'),
(4, 'La radio localisée à Mahajanga est en cours de réparation', 2, 1, '2025-04-22 10:34:14', '2025-04-22 10:36:56'),
(5, 'La radio localisée à Mahajanga est en cours de réparation', 2, 1, '2025-04-22 10:36:36', '2025-04-22 10:37:03'),
(6, 'La television localisée à Antsirabe est en panne', 1, 1, '2025-04-22 10:37:45', '2025-04-22 10:39:12'),
(7, 'La television localisée à Antsirabe est en cours de réparation', 2, 1, '2025-04-22 10:39:07', '2025-04-22 10:39:24'),
(8, 'La radio localisée à Antananarivo est en panne', 1, 1, '2025-04-23 07:41:33', '2025-04-23 07:42:59'),
(9, 'La radio localisée à Antananarivo est en cours de réparation', 2, 1, '2025-04-23 07:42:51', '2025-04-23 07:43:26'),
(10, 'La radio localisée à Mahajanga est en panne', 1, 1, '2025-04-24 04:34:19', '2025-04-24 04:43:37'),
(11, 'La television localisée à Ihosy est en panne', 1, 1, '2025-04-24 04:40:27', '2025-04-24 04:43:41'),
(12, 'La television localisée à Antsirabe est en panne', 1, 1, '2025-04-24 04:41:11', '2025-04-24 04:43:39'),
(13, 'La radio localisée à Mahajanga est en panne', 1, 1, '2025-04-24 04:42:54', '2025-04-24 04:43:43'),
(14, 'La radio localisée à Mahajanga est en cours de réparation', 2, 1, '2025-05-08 03:52:03', '2025-05-08 03:52:42'),
(15, 'La television localisée à Ihosy est en panne', 1, 1, '2025-05-09 05:22:12', '2025-05-09 05:52:19'),
(16, 'La television localisée à Ihosy est en cours de réparation', 2, 1, '2025-05-09 05:52:48', '2025-05-09 05:53:37'),
(17, 'La television localisée à Antsirabe est en panne', 1, 1, '2025-05-09 05:53:48', '2025-05-09 06:10:16'),
(18, 'La television localisée à Antsirabe est en cours de réparation', 2, 1, '2025-05-09 06:10:09', '2025-05-09 06:10:43'),
(19, 'La radio localisée à Mahajanga est en panne', 1, 1, '2025-05-12 04:41:44', '2025-05-12 04:45:31'),
(20, 'La radio localisée à Mahajanga est en cours de réparation', 2, 1, '2025-05-12 05:07:57', '2025-05-20 04:06:07'),
(21, 'La television localisée à Ihosy est en panne', 1, 1, '2025-05-20 04:06:24', '2025-05-20 04:07:04'),
(22, 'La television localisée à Ihosy est en cours de réparation', 2, 1, '2025-05-20 06:09:23', '2025-05-20 06:41:12'),
(23, 'La radio localisée à Sambava est en panne', 1, 1, '2025-05-21 05:06:31', '2025-05-21 05:07:42'),
(24, 'La radio localisée à Sambava est en cours de réparation', 2, 1, '2025-05-21 05:07:36', '2025-05-21 05:41:31'),
(25, 'La radio localisée à Farafangana est en panne', 1, 1, '2025-05-21 05:43:01', '2025-05-21 05:43:41'),
(26, 'La radio localisée à Farafangana est en cours de réparation', 2, 1, '2025-05-21 05:43:35', '2025-05-21 05:43:55'),
(27, 'La radio localisée à Ambatondrazaka est en panne', 1, 1, '2025-05-24 06:55:51', '2025-05-24 06:57:24'),
(28, 'La radio localisée à Ambatondrazaka est en cours de réparation', 2, 1, '2025-05-24 06:58:08', '2025-05-26 05:49:11'),
(29, 'La radio localisée à Vatomandry est en panne', 1, 1, '2025-05-24 07:12:06', '2025-05-27 08:09:00'),
(30, 'La radio localisée à Vatomandry est en cours de réparation', 2, 1, '2025-05-24 07:12:58', '2025-05-26 05:49:14'),
(31, 'La television localisée à Manakara est en panne', 1, 1, '2025-05-25 10:40:51', '2025-05-27 08:09:02'),
(32, 'La television localisée à Manakara est en cours de réparation', 2, 1, '2025-05-25 10:42:18', '2025-05-26 05:49:15'),
(33, 'La television localisée à Antsirabe est en panne', 1, 1, '2025-05-27 08:00:41', '2025-05-27 08:09:04'),
(34, 'La television localisée à Antsirabe est en cours de réparation', 2, 1, '2025-05-27 09:22:20', '2025-05-27 09:26:08'),
(35, 'La radio localisée à Ihosy est en panne', 1, 1, '2025-05-27 09:27:28', '2025-05-27 09:27:41'),
(36, 'La radio localisée à Ihosy est en cours de réparation', 2, 1, '2025-05-27 09:28:05', '2025-05-27 09:28:35'),
(37, 'La television localisée à Manakara est en panne', 1, 1, '2025-05-27 09:56:50', '2025-05-27 09:57:08'),
(38, 'La television localisée à Manakara est en cours de réparation', 2, 1, '2025-05-27 09:57:40', '2025-05-27 09:57:56'),
(39, 'La radio localisée à Nosy Be est en panne', 1, 1, '2025-05-27 10:13:05', '2025-05-27 10:13:38'),
(40, 'La radio localisée à Sambava est en panne', 1, 1, '2025-05-27 10:13:17', '2025-05-27 10:13:40'),
(41, 'La radio localisée à Sambava est en cours de réparation', 2, 1, '2025-05-27 10:14:15', '2025-05-27 11:15:02'),
(42, 'La radio localisée à Nosy Be est en cours de réparation', 2, 1, '2025-05-27 11:14:34', '2025-05-27 11:15:04'),
(43, 'La television localisée à Fianarantsoa est en panne', 1, 1, '2025-05-27 11:15:19', '2025-05-28 08:54:38'),
(44, 'La radio localisée à Mahajanga est en panne', 1, 1, '2025-05-27 11:16:25', '2025-05-28 09:02:45'),
(45, 'La television localisée à Fianarantsoa est en cours de réparation', 2, 1, '2025-05-28 07:27:56', '2025-05-28 07:28:15'),
(46, 'La television localisée à Antsirabe est en panne', 1, 0, '2025-05-28 11:15:11', '2025-05-28 11:15:11'),
(47, 'La television localisée à Manakara est en panne', 1, 0, '2025-05-28 11:16:40', '2025-05-28 11:16:40');

-- --------------------------------------------------------

--
-- Structure de la table `pannes`
--

DROP TABLE IF EXISTS `pannes`;
CREATE TABLE IF NOT EXISTS `pannes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_declenchee` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pieces`
--

INSERT INTO `pieces` (`id`, `nom`, `type`, `quantite`, `created_at`, `updated_at`) VALUES
(1, 'Transmetteur Alpha', 'Émetteur', 10, NULL, NULL),
(2, 'Récepteur Beta', 'Émetteur', 15, NULL, NULL),
(3, 'Amplificateur Gamma', 'Émetteur', 20, NULL, NULL),
(4, 'Câble HDMI', 'Connecteur', 49, NULL, '2025-04-22 10:34:14'),
(5, 'Antenne Omnidirectionnelle', 'Émetteur', 5, NULL, NULL),
(6, 'Modulateur Delta', 'Émetteur', 8, NULL, NULL),
(7, 'Décodeur Sigma', 'Récepteur', 12, NULL, NULL),
(8, 'Filtre RF', 'Émetteur', 18, NULL, NULL),
(9, 'Transformateur Zeta', 'Connecteur', 24, NULL, '2025-05-12 05:07:57'),
(10, 'Écran LCD', 'Interface', 7, NULL, NULL),
(11, 'Connecteur Optique', 'Connecteur', 39, NULL, '2025-04-22 10:32:11'),
(13, 'Alimentation AC', 'Émetteur', 2, NULL, '2025-05-09 06:10:08'),
(14, 'Cartes d\'Émetteur', 'Accessoire', 6, NULL, '2025-04-22 10:39:07'),
(15, 'Adaptateur USB', 'Accessoire', 50, NULL, NULL),
(16, 'Capteur de Signal', 'Émetteur', 12, NULL, '2025-05-25 10:42:18'),
(17, 'Boîtier de Transmission', 'Émetteur', 14, NULL, '2025-05-24 06:58:08'),
(18, 'Microprocesseur', 'Émetteur', 20, NULL, '2025-04-23 07:42:51'),
(19, 'Condensateur Haute Tension', 'Émetteur', 30, NULL, '2025-05-24 06:58:08'),
(20, 'Équipement d\'Étalonnage', 'Accessoire', 11, NULL, NULL),
(21, 'Amplificateur Audio', 'Récepteur', 17, NULL, NULL),
(22, 'Antenne Directionnelle', 'Émetteur', 9, NULL, NULL),
(23, 'Oscillateur Fréquentiel', 'Connecteur', 14, NULL, NULL),
(24, 'Convertisseur AC/DC', 'Connecteur', 20, NULL, NULL),
(25, 'Capteur de Puissance', 'Émetteur', 8, NULL, NULL),
(26, 'Carte Mère', 'Émetteur', 9, NULL, '2025-05-12 05:07:57'),
(27, 'Émetteur de Radio', 'Émetteur', 6, NULL, NULL),
(28, 'Module de Fréquence', 'Émetteur', 8, NULL, NULL),
(29, 'Moteur RF', 'Émetteur', 5, NULL, NULL),
(30, 'Capteur Température', 'Accessoire', 13, NULL, NULL);

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
('XdKkajbNL9L6HalHaZjPLVIKkRT5PWqVeyl6ni0l', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVnRHTmFEcnpoRE1XOFRRdVpRUGZybE02VzlYRGtTRkZ6cDlSNldmUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZWNobmljaWVuIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1748441822),
('83c21xjxysspC25AZ0M6aWKrrO9idn7DMKrk9Pdr', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRGRJd1lXRlFDNU96VXViYnRISlIxZ0U5TW1LeWpqbDhPNGRueHprTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1748441993),
('1lyuMlWeArD5l1TN8Xj57REe6hovzRNtwoF45ly6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNmdaY2Ewd3RuZDl6WFA3V1llbkM0c3NKUkdMU1VIRWpwN0o3V284VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1748845869);

-- --------------------------------------------------------

--
-- Structure de la table `stations`
--

DROP TABLE IF EXISTS `stations`;
CREATE TABLE IF NOT EXISTS `stations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_alerte`
--

DROP TABLE IF EXISTS `type_alerte`;
CREATE TABLE IF NOT EXISTS `type_alerte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `typeA` varchar(45) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type_alerte`
--

INSERT INTO `type_alerte` (`id`, `typeA`, `updated_at`, `created_at`) VALUES
(3, 'Panne matérielle', '2025-04-22 05:00:53', '2025-04-22 05:00:53'),
(4, 'Probléme reseau', '2025-04-22 05:02:47', '2025-04-22 05:02:47'),
(5, 'Maintenance Prévue', '2025-04-22 05:14:30', '2025-04-22 05:14:30');

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
  `matricule` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_matricule_unique` (`matricule`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `matricule`, `photo`, `prenom`) VALUES
(1, 'RAKOTONDRANAIVO', 'adminr@gmail.com', NULL, '$2y$12$zFVyJiuci5tgyBA7.OEY9egXndYzIGmXU4rnknFlcNqUgs2Lvqs.i', 'admin', NULL, '2025-04-18 09:05:44', '2025-05-27 04:37:25', NULL, '1748331445_Auth.PNG', 'Lantosoa'),
(2, 'Nasandratra', 'nasandratrar@gmail.com', NULL, '$2y$12$yDGMgYWUtPnhkbGlNfA7QOIiRZpJFNtROew498quma.PBtcAQWZK6', 'technicien', NULL, '2025-04-18 09:05:59', '2025-05-28 09:26:50', NULL, 'techniciens/photos/VYva0t3bGvLDTById5qZ1wr6aPhuXNXpG5xZH4EI.jpg', 'Rakoto'),
(3, 'Fanantenana', 'fanantenana@gmail.com', NULL, '$2y$12$8AZuIoZcpzQWkCrXnQGnF.XwcWOA/EuGT62X0WgcDmDf1Ojh.00bW', 'technicien', NULL, '2025-05-08 06:45:22', '2025-05-08 06:45:22', NULL, NULL, NULL),
(4, 'Rakotondranaivo', 'rakoto2405@gmail.com', NULL, '$2y$12$EfFD2XWoJ5OiXHfbulWHyu/HTnhNeiczU/Wly41dbuhpFtMi3Tp8y', 'technicien', NULL, '2025-05-19 09:53:50', '2025-05-19 09:53:50', NULL, NULL, NULL),
(5, 'Rakotondrazafy', 'rakotondrazafy@gmail.com', NULL, '$2y$12$aCvb83995F8/4wua6Q9/6.l2QtUD4ZqrxVUyviyTZEe1nUrHz.PAG', 'technicien', NULL, '2025-05-19 10:04:23', '2025-05-19 10:04:23', NULL, NULL, NULL),
(6, 'Nantenaina', 'nantenaina@gmail.com', NULL, '$2y$12$vKQK4iU/Tc6HMZj51sisOO51llGKr8tLg374GlRCfvlIHQACCyxYS', 'technicien', NULL, '2025-05-19 10:06:08', '2025-05-19 10:06:08', NULL, NULL, NULL),
(8, 'Nandrianina', 'nandrianina@gmail.com', NULL, '$2y$12$gCbk7nfR6fAMgrnDwqIsZu9.6tumI0RnKQyZ2Hl9Ix24nrl.AawZK', 'technicien', NULL, '2025-05-19 10:28:07', '2025-05-19 10:28:07', NULL, NULL, NULL),
(9, 'Lantosoa', 'lantosoa@gmail.com', NULL, '$2y$12$PVgujJL5RNGzLkgJH7CjbeEQaZVShtDO1PvDhfhuiVE0sk1rvO8cG', 'technicien', NULL, '2025-05-19 10:52:13', '2025-05-19 10:52:13', NULL, NULL, NULL),
(10, 'Marcellin', 'marcelin@gmail.com', NULL, '$2y$12$4cRSyUGYO5DviBL/7jsViu6hKXEEQLwvOdGGX.zWfd.nzkZyYCTGO', 'technicien', NULL, '2025-05-19 11:30:01', '2025-05-19 11:30:01', NULL, NULL, NULL),
(11, 'Volasoa Rakoto', 'volasoa@gmail.com', NULL, '$2y$12$5CPX5bvbeSSd.SIJy.ySq.LjA4PDSQdRJHImDTvEZgsY0gMQJ6XyW', 'technicien', NULL, '2025-05-20 03:53:13', '2025-05-20 03:53:13', NULL, NULL, NULL),
(14, 'Dafetra', 'dafetra@gmail.com', NULL, '$2y$12$y1SeZjip0f6Sh4uXZqJAS.pjGgmVZ/i41vv6HL4KKI5kB9mqb9RlW', 'technicien', NULL, '2025-05-25 10:39:43', '2025-05-25 10:39:43', NULL, NULL, NULL),
(13, 'Finaritra', 'finaritra@gmail.com', NULL, '$2y$12$B6fhtoHsotj.8oHYbISlnumbOTU5pqZ/uNk6EXTxGL4iFH4C1LOqW', 'technicien', NULL, '2025-05-22 07:34:53', '2025-05-22 07:34:53', NULL, NULL, NULL),
(15, 'RAKOTONDRAZAFY', 'nasandratrar2@gmail.com', NULL, '$2y$12$YUYn9MuiOXMWxMC4o6frse9lDji0mqLXHFrovw/DByat6f0egjyKO', 'technicien', NULL, '2025-05-26 03:33:04', '2025-05-26 05:31:07', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
