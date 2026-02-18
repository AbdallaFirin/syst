-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2026 at 07:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fssyst`
--

-- --------------------------------------------------------

--
-- Table structure for table `awareness_activities`
--

CREATE TABLE `awareness_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `activity_date` date NOT NULL,
  `beneficiaries_count` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-test@example.com|127.0.0.1', 'i:1;', 1769958427),
('laravel-cache-test@example.com|127.0.0.1:timer', 'i:1769958427;', 1769958427),
('laravel-cache-test@exmple.com|127.0.0.1', 'i:1;', 1769958416),
('laravel-cache-test@exmple.com|127.0.0.1:timer', 'i:1769958416;', 1769958416);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chemicals`
--

CREATE TABLE `chemicals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `chemical_type` varchar(255) NOT NULL,
  `manufacture_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(255) NOT NULL DEFAULT 'liters',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chemicals`
--

INSERT INTO `chemicals` (`id`, `name`, `chemical_type`, `manufacture_date`, `expiry_date`, `quantity`, `unit`, `created_at`, `updated_at`) VALUES
(12, 'Co2', 'Budo', '2025-12-04', '2026-01-07', 0, 'liters', '2026-01-05 20:09:45', '2026-01-05 20:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `chemical_place_category`
--

CREATE TABLE `chemical_place_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_category_id` bigint(20) UNSIGNED NOT NULL,
  `chemical_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chemical_place_category`
--

INSERT INTO `chemical_place_category` (`id`, `place_category_id`, `chemical_id`, `created_at`, `updated_at`) VALUES
(5, 9, 12, NULL, NULL),
(6, 10, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fire_incidents`
--

CREATE TABLE `fire_incidents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `incident_cause_id` bigint(20) UNSIGNED NOT NULL,
  `incident_date` datetime NOT NULL,
  `status` enum('pending','investigating','resolved','closed') NOT NULL DEFAULT 'pending',
  `human_loss` int(11) NOT NULL DEFAULT 0,
  `injured_people` int(11) NOT NULL DEFAULT 0,
  `financial_loss` decimal(15,2) NOT NULL DEFAULT 0.00,
  `property_damage` varchar(255) DEFAULT NULL,
  `rescued_people` int(11) NOT NULL DEFAULT 0,
  `rescued_assets` text DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fire_incidents`
--

INSERT INTO `fire_incidents` (`id`, `place_id`, `incident_cause_id`, `incident_date`, `status`, `human_loss`, `injured_people`, `financial_loss`, `property_damage`, `rescued_people`, `rescued_assets`, `additional_notes`, `created_at`, `updated_at`) VALUES
(8, 7, 2, '2026-01-05 14:35:00', 'pending', 2, 12, 12000.00, 'Gaari Harier ah', 11, 'Guri', NULL, '2026-01-05 13:36:36', '2026-01-05 13:36:36'),
(9, 8, 2, '2026-01-04 21:49:00', 'pending', 9, 12, 1299.00, 'Haan Gaas', 11, 'Alaab Badan', NULL, '2026-01-05 15:49:59', '2026-01-05 15:49:59'),
(10, 7, 3, '2025-12-30 07:19:00', 'pending', 4, 34, 12000.00, 'Guri Dhan iyo Laba Gaari', 18, 'Hotel-ka', NULL, '2026-01-05 16:23:54', '2026-01-06 01:19:13'),
(11, 8, 1, '2026-01-03 01:56:00', 'pending', 6, 7, 5.00, 'kk', 7, 'hhh', 'y', '2026-01-05 19:57:07', '2026-01-05 19:57:07'),
(12, 7, 2, '2026-01-05 07:09:00', 'pending', 1, 12, 12000.00, NULL, 0, NULL, NULL, '2026-01-06 01:09:36', '2026-01-06 01:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `incident_causes`
--

CREATE TABLE `incident_causes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incident_causes`
--

INSERT INTO `incident_causes` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'birjiko', NULL, '2025-12-25 13:55:02', '2025-12-25 13:55:02'),
(2, 'shidaal', 'sssssssssssssssssss', '2025-12-28 06:01:56', '2025-12-28 06:01:56'),
(3, 'Electric', NULL, '2026-01-05 16:23:22', '2026-01-05 16:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `incident_images`
--

CREATE TABLE `incident_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fire_incident_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'general',
  `caption` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incident_images`
--

INSERT INTO `incident_images` (`id`, `fire_incident_id`, `image_path`, `category`, `caption`, `created_at`, `updated_at`) VALUES
(1, 12, 'incident_evidence/g0djwmOJlfUzbigWkuOHeBG6xELBFpZ3U3KJ42CS.jpg', 'death_evidence', 'Death Casualty Evidence', '2026-01-06 01:09:36', '2026-01-06 01:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_logs`
--

CREATE TABLE `maintenance_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_name` varchar(255) NOT NULL,
  `maintenance_type` varchar(255) NOT NULL,
  `performed_at` date NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `details` text DEFAULT NULL,
  `performed_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_25_161742_create_place_categories_table', 1),
(5, '2025_12_25_161744_create_places_table', 1),
(6, '2025_12_25_161746_create_staff_table', 1),
(7, '2025_12_25_161747_create_vehicles_table', 1),
(8, '2025_12_25_161749_create_chemicals_table', 1),
(9, '2025_12_25_161750_create_policies_table', 1),
(10, '2025_12_25_161751_create_incident_causes_table', 1),
(11, '2025_12_25_161752_create_fire_incidents_table', 1),
(12, '2025_12_25_174559_create_organizations_table', 2),
(13, '2025_12_25_175220_create_reports_table', 3),
(14, '2025_12_25_175223_create_report_sections_table', 3),
(15, '2025_12_25_175224_create_report_recommendations_table', 3),
(16, '2025_12_25_175226_create_trainings_table', 3),
(17, '2025_12_25_175228_create_maintenance_logs_table', 3),
(18, '2025_12_25_175230_create_awareness_activities_table', 3),
(19, '2025_12_25_184155_add_property_damage_to_fire_incidents_table', 4),
(20, '2026_01_05_162018_create_chemical_place_category_table', 5),
(21, '2026_01_05_162026_add_icon_to_place_categories_table', 5),
(22, '2026_01_06_100000_add_status_to_fire_incidents', 6),
(23, '2026_01_06_100001_create_incident_images_table', 6),
(24, '2026_01_06_040613_add_category_to_incident_images_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'Fire Safety Department',
  `contact_info` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `footer_info` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `contact_info`, `logo_path`, `footer_info`, `created_at`, `updated_at`) VALUES
(1, 'Fire Safety Department', '252907024306', 'logos/nBXjVA4tkzr1cpFDToeiTgeqQN6kTJOzPvTSZfu7.jpg', 'Fadlan Wixii Cabasha la xariir Maamulka Dabdamiska\r\n252907024306', '2025-12-25 14:48:01', '2025-12-28 06:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('test@example.com', '$2y$12$iGFQ56zCLADb25.EzebNPedDedJ33BPquMDWl.2mmAsmEgYudMoFG', '2025-12-28 07:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `place_category_id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `phone_number_1` varchar(255) NOT NULL,
  `phone_number_2` varchar(255) DEFAULT NULL,
  `phone_number_3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `place_category_id`, `location`, `contact_person`, `phone_number_1`, `phone_number_2`, `phone_number_3`, `created_at`, `updated_at`) VALUES
(7, 'Guureeye Hotel', 9, 'Guureeye Road, Garowe Puntland Somalia', 'ABDULLAHI F.SAID', '0900798123', NULL, NULL, '2026-01-05 13:29:47', '2026-01-05 13:29:47'),
(8, 'Horn Petroleum', 10, 'Guureeye Road, Garowe Puntland Somalia', 'ABDULLAHI F.SAID', '0900798123', NULL, NULL, '2026-01-05 15:49:09', '2026-01-05 15:49:09');

-- --------------------------------------------------------

--
-- Table structure for table `place_categories`
--

CREATE TABLE `place_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `policy_id` bigint(20) UNSIGNED DEFAULT NULL,
  `required_equipment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `place_categories`
--

INSERT INTO `place_categories` (`id`, `name`, `policy_id`, `required_equipment`, `created_at`, `updated_at`, `icon`) VALUES
(9, 'Hotel', NULL, '[]', '2026-01-05 13:25:12', '2026-01-05 13:25:12', '🏢'),
(10, 'Fuel Station', NULL, '[]', '2026-01-05 15:42:35', '2026-01-05 15:42:35', '⛽');

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `original_title` varchar(255) DEFAULT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_recommendations`
--

CREATE TABLE `report_recommendations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_id` bigint(20) UNSIGNED NOT NULL,
  `recommendation_text` text NOT NULL,
  `priority` varchar(255) NOT NULL DEFAULT 'Medium',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_sections`
--

CREATE TABLE `report_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_id` bigint(20) UNSIGNED NOT NULL,
  `introduction` text DEFAULT NULL,
  `conclusion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('c4Hyv3TT4mr6xcry7ybhgqtB9CzoNCOBTAhywwvc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNncwd1ZCemNrSDNNUDBhbkQyU2dDa0h6bGdSeWF0Q3FYbmF4N2hwdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769974636),
('DHjWwiOKg0eWl59yDGsgK4ZLxdX8EopUxb9Zda4a', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWxFR1dRT09iNGJobE14dEd5WkZoQ21wR2loelBHNGs3c0FIeGFsMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1767702768),
('fnONstIuPuytcIpi0Odjz1bFLifafmxgIFn2JpzI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaUdJeTJHMEphb2FCakR0ZEVJWEl3V29VanFZbURWTUI5NWhSd202RiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769960399),
('LWbfvEdfNcv5M9coeJcPTJz3lV56RQIJARYvLVPE', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOG1mb09xa0hOMlZsUVoyYkIzZGdxRDlVN2JiaGZWVDdhbEdEaHQ1aSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9maXJlLWluY2lkZW50cyI7czo1OiJyb3V0ZSI7czoyMDoiZmlyZS1pbmNpZGVudHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1769959834),
('PkN7crxSyJ3xpGXzte613qNrpcenmTNwvHWNATIO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWHRxYUJEQ0JCclBlWjRvQUxuZ1paRlQwUEh0Nlc5SmcxSXFFMWFENCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770017018),
('TMepg7LIOIx7iaI1MWygYA41dnE8PASGZxJJZP7b', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaXp2V2JEMlFWMjNuM3B1Z0JDSUdMN0FnTFA1emZtRGdsMkZBQ1hwZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2ZpcmUtaW5jaWRlbnRzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769974623),
('yttMMlWnT6nXqqYGE5DDVQ7Q559f8VsXR7UsarlA', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiejdWWGtib1NrN0wwVHhLY1RFdWhJb3VnalpvelNsblNVR2dVb3o4TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9maXJlLWluY2lkZW50cy84L2Nhc2UtZmlsZSI7czo1OiJyb3V0ZSI7czoyNDoiZmlyZS1pbmNpZGVudHMuY2FzZS1maWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1767676194);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `shift` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `trainer_name` varchar(255) NOT NULL,
  `conducted_at` date NOT NULL,
  `attendees_count` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-12-25 13:35:29', '$2y$12$Woj9wqETsvY6YkMbQSgKeugyr8h2fSdb9stY5H.OJnJhA/qNEao1C', 'SBqaTQHu77v7eQR9N764Byy9Y2dPW8msOXrACs6ouVnK0epo5aQIg4zG6na3', '2025-12-25 13:35:29', '2025-12-25 13:35:29'),
(2, 'Firin', 'admin@admin.com', '2026-01-05 12:58:18', '$2y$12$PogcqnoaBCXyOSsKoarYdewiG4NSfN/9IlMPhXpFU.Q/IVrA/dQdm', 'UEqDLsxObj', '2026-01-05 12:58:19', '2026-01-05 12:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `plate_number` varchar(255) NOT NULL,
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `awareness_activities`
--
ALTER TABLE `awareness_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chemicals`
--
ALTER TABLE `chemicals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chemical_place_category`
--
ALTER TABLE `chemical_place_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chemical_place_category_place_category_id_foreign` (`place_category_id`),
  ADD KEY `chemical_place_category_chemical_id_foreign` (`chemical_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fire_incidents`
--
ALTER TABLE `fire_incidents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fire_incidents_place_id_foreign` (`place_id`),
  ADD KEY `fire_incidents_incident_cause_id_foreign` (`incident_cause_id`);

--
-- Indexes for table `incident_causes`
--
ALTER TABLE `incident_causes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incident_images`
--
ALTER TABLE `incident_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incident_images_fire_incident_id_foreign` (`fire_incident_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_logs`
--
ALTER TABLE `maintenance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `places_place_category_id_foreign` (`place_category_id`);

--
-- Indexes for table `place_categories`
--
ALTER TABLE `place_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_recommendations`
--
ALTER TABLE `report_recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_recommendations_report_id_foreign` (`report_id`);

--
-- Indexes for table `report_sections`
--
ALTER TABLE `report_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_sections_report_id_foreign` (`report_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_plate_number_unique` (`plate_number`),
  ADD KEY `vehicles_staff_id_foreign` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `awareness_activities`
--
ALTER TABLE `awareness_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chemicals`
--
ALTER TABLE `chemicals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `chemical_place_category`
--
ALTER TABLE `chemical_place_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fire_incidents`
--
ALTER TABLE `fire_incidents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `incident_causes`
--
ALTER TABLE `incident_causes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `incident_images`
--
ALTER TABLE `incident_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_logs`
--
ALTER TABLE `maintenance_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `place_categories`
--
ALTER TABLE `place_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_recommendations`
--
ALTER TABLE `report_recommendations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_sections`
--
ALTER TABLE `report_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chemical_place_category`
--
ALTER TABLE `chemical_place_category`
  ADD CONSTRAINT `chemical_place_category_chemical_id_foreign` FOREIGN KEY (`chemical_id`) REFERENCES `chemicals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chemical_place_category_place_category_id_foreign` FOREIGN KEY (`place_category_id`) REFERENCES `place_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fire_incidents`
--
ALTER TABLE `fire_incidents`
  ADD CONSTRAINT `fire_incidents_incident_cause_id_foreign` FOREIGN KEY (`incident_cause_id`) REFERENCES `incident_causes` (`id`),
  ADD CONSTRAINT `fire_incidents_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incident_images`
--
ALTER TABLE `incident_images`
  ADD CONSTRAINT `incident_images_fire_incident_id_foreign` FOREIGN KEY (`fire_incident_id`) REFERENCES `fire_incidents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_place_category_id_foreign` FOREIGN KEY (`place_category_id`) REFERENCES `place_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_recommendations`
--
ALTER TABLE `report_recommendations`
  ADD CONSTRAINT `report_recommendations_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_sections`
--
ALTER TABLE `report_sections`
  ADD CONSTRAINT `report_sections_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
