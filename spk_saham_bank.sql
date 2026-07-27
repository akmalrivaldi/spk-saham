-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2026 at 01:58 PM
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
-- Database: `spk_saham_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `attribute` enum('benefit','cost') NOT NULL,
  `weight` decimal(10,4) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `code`, `name`, `attribute`, `weight`, `description`, `created_at`, `updated_at`) VALUES
(1, 'C1', 'ROE', 'benefit', 0.3621, 'Return on Equity', '2026-04-05 21:48:37', '2026-04-05 21:48:37'),
(2, 'C2', 'PER', 'cost', 0.2780, 'Price to Earnings Ratio', '2026-04-05 21:48:37', '2026-04-05 21:48:37'),
(3, 'C3', 'PBV', 'cost', 0.2241, 'Price to Book Value', '2026-04-05 21:48:37', '2026-04-05 21:48:37'),
(4, 'C4', 'Dividend Yield', 'benefit', 0.0776, 'Dividend Yield', '2026-04-05 21:48:37', '2026-04-05 21:48:37'),
(5, 'C5', 'DER', 'cost', 0.0582, 'Debt to Equity Ratio', '2026-04-05 21:48:37', '2026-04-05 21:48:37');

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
(4, '2026_04_06_032040_create_stocks_table', 1),
(5, '2026_04_06_032054_create_criteria_table', 1),
(6, '2026_04_06_032107_create_periods_table', 1),
(7, '2026_04_06_032119_create_stock_values_table', 1),
(8, '2026_04_06_032150_create_rankings_table', 1),
(9, '2026_07_01_000001_add_role_and_approval_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

CREATE TABLE `periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `periods`
--

INSERT INTO `periods` (`id`, `name`, `year`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'Penilaian tahun 2025 Q4', '2025', NULL, 1, '2026-06-23 01:48:53', '2026-06-23 01:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `rankings`
--

CREATE TABLE `rankings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `period_id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `vector_s` decimal(20,10) NOT NULL,
  `vector_v` decimal(20,10) NOT NULL,
  `rank` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rankings`
--

INSERT INTO `rankings` (`id`, `period_id`, `stock_id`, `vector_s`, `vector_v`, `rank`, `created_at`, `updated_at`) VALUES
(135, 3, 11, 2.0554807864, 0.0868520034, 1, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(136, 3, 12, 2.0359717313, 0.0860276705, 2, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(137, 3, 10, 1.9239197591, 0.0812930418, 3, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(138, 3, 15, 1.7677126268, 0.0746926870, 4, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(139, 3, 7, 1.7575334397, 0.0742625771, 5, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(140, 3, 8, 1.6933795938, 0.0715518293, 6, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(141, 3, 6, 1.6217251541, 0.0685241524, 7, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(142, 3, 13, 1.4770058060, 0.0624092009, 8, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(143, 3, 5, 1.4126585522, 0.0596902808, 9, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(144, 3, 18, 1.3709493910, 0.0579279077, 10, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(145, 3, 19, 1.3570334159, 0.0573399040, 11, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(146, 3, 17, 1.2465021663, 0.0526695317, 12, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(147, 3, 21, 1.1942036237, 0.0504597162, 13, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(148, 3, 9, 1.1854406670, 0.0500894475, 14, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(149, 3, 14, 0.5746873956, 0.0242827624, 15, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(150, 3, 16, 0.5503924083, 0.0232562054, 16, '2026-06-23 02:10:46', '2026-06-23 02:10:46'),
(151, 3, 20, 0.4418786991, 0.0186710820, 17, '2026-06-23 02:10:46', '2026-06-23 02:10:46');

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
('YQliTiQJ6ckITDNrl9fWv0NeRWme5Ot3A1utyEuJ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSW91bzdnQjB2ODNXZ1ZFWndZcDB2N1hEOUlwUld5dXJtUnBtQ2hvcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4udXNlcnMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1784779242);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `issuer` varchar(255) NOT NULL,
  `subsector` varchar(255) NOT NULL DEFAULT 'Perbankan',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `code`, `name`, `issuer`, `subsector`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'BBCA', 'Bank Central Asia', 'PT. Bank Central Asia Tbk.', 'Perbankan', 1, '2026-06-22 03:11:08', '2026-06-22 03:11:08'),
(6, 'BBRI', 'Bank Rakyat Indonesia', 'PT. Bank Rakyat Indonesia (Persero) Tbk.', 'Perbankan', 1, '2026-06-22 03:11:45', '2026-06-22 03:11:45'),
(7, 'BMRI', 'Bank Mandiri', 'PT. Bank Mandiri (Persero) Tbk.', 'Perbankan', 1, '2026-06-22 03:12:12', '2026-06-22 03:12:12'),
(8, 'BBNI', 'Bank Negara Indonesia', 'PT. Bank Negara Indonesia (Persero) Tbk.', 'Perbankan', 1, '2026-06-22 03:12:44', '2026-06-22 03:12:44'),
(9, 'BRIS', 'Bank Syariah Indonesia', 'PT. Bank Syariah Indonesia Tbk.', 'Perbankan', 1, '2026-06-22 03:13:15', '2026-06-22 03:13:15'),
(10, 'BNGA', 'Bank CIMB Niaga', 'PT. Bank CIMB Niaga Tbk.', 'Perbankan', 1, '2026-06-22 03:13:45', '2026-06-22 03:13:45'),
(11, 'BJTM', 'Bank Pembangunan Jawa Timur', 'PT. Bank Pembangunan Daerah Jawa Timur Tbk', 'Perbankan', 1, '2026-06-22 03:14:13', '2026-06-22 03:14:13'),
(12, 'NISP', 'Bank OCBC NISP', 'PT. Bank OCBC NISP Tbk.', 'Perbankan', 1, '2026-06-22 03:14:40', '2026-06-22 03:14:40'),
(13, 'BJBR', 'Bank Pembangunan Jawa Barat', 'PT. Bank Pembangunan Daerah Jawa Barat Tbk.', 'Perbankan', 1, '2026-06-22 03:15:16', '2026-06-22 03:15:16'),
(14, 'BBHI', 'Allo Bank Indonesia', 'PT. Allo Bank Indonesia Tbk.', 'Perbankan', 1, '2026-06-22 03:15:43', '2026-06-22 03:15:43'),
(15, 'BDMN', 'Bank Danamon Indonesia', 'PT. Bank Danamon Indonesia Tbk.', 'Perbankan', 1, '2026-06-22 03:16:14', '2026-06-22 03:16:14'),
(16, 'BNLI', 'Bank Permata', 'PT. Bank Permata Tbk.', 'Perbankan', 1, '2026-06-22 03:16:43', '2026-06-22 03:16:43'),
(17, 'BNII', 'Bank Maybank Indonesia', 'PT. Bank Maybank Indonesia Tbk.', 'Perbankan', 1, '2026-06-22 03:17:09', '2026-06-22 03:17:09'),
(18, 'MEGA', 'Bank Mega', 'PT. Bank Mega Tbk.', 'Perbankan', 1, '2026-06-22 03:17:30', '2026-06-22 03:17:30'),
(19, 'PNBN', 'Bank Pan Indonesia', 'PT. Bank Pan Indonesia Tbk.', 'Perbankan', 1, '2026-06-22 03:18:11', '2026-06-22 03:18:11'),
(20, 'BTPN', 'Bank SMBC Indonesia', 'PT. Bank SMBC Indonesia Tbk.', 'Perbankan', 1, '2026-06-22 03:18:36', '2026-06-22 03:18:36'),
(21, 'AMAR', 'Bank Amar Indonesia', 'PT. Bank Amar Indonesia Tbk.', 'Perbankan', 1, '2026-06-22 03:19:04', '2026-06-22 03:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `stock_values`
--

CREATE TABLE `stock_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `period_id` bigint(20) UNSIGNED NOT NULL,
  `criterion_id` bigint(20) UNSIGNED NOT NULL,
  `value` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_values`
--

INSERT INTO `stock_values` (`id`, `stock_id`, `period_id`, `criterion_id`, `value`, `created_at`, `updated_at`) VALUES
(106, 9, 3, 1, 15.6000, '2026-06-23 01:49:40', '2026-06-23 01:49:40'),
(107, 9, 3, 2, 13.5900, '2026-06-23 01:49:40', '2026-06-23 01:49:40'),
(108, 9, 3, 3, 1.9800, '2026-06-23 01:49:40', '2026-06-23 01:49:40'),
(109, 9, 3, 4, 0.7700, '2026-06-23 01:49:40', '2026-06-23 01:49:40'),
(110, 9, 3, 5, 0.2800, '2026-06-23 01:49:40', '2026-06-23 01:49:40'),
(111, 10, 3, 1, 12.4000, '2026-06-23 01:50:17', '2026-06-23 01:50:17'),
(112, 10, 3, 2, 6.5400, '2026-06-23 01:50:17', '2026-06-23 01:50:17'),
(113, 10, 3, 3, 0.7800, '2026-06-23 01:50:17', '2026-06-23 01:50:17'),
(114, 10, 3, 4, 8.4000, '2026-06-23 01:50:17', '2026-06-23 01:50:17'),
(115, 10, 3, 5, 0.4700, '2026-06-23 01:50:17', '2026-06-23 01:50:17'),
(116, 11, 3, 1, 11.8100, '2026-06-23 01:50:52', '2026-06-23 01:50:52'),
(117, 11, 3, 2, 5.2500, '2026-06-23 01:50:52', '2026-06-23 01:50:52'),
(118, 11, 3, 3, 0.5900, '2026-06-23 01:50:52', '2026-06-23 01:50:52'),
(119, 11, 3, 4, 9.7700, '2026-06-23 01:50:52', '2026-06-23 01:50:52'),
(120, 11, 3, 5, 1.1400, '2026-06-23 01:50:52', '2026-06-23 01:50:52'),
(121, 12, 3, 1, 11.9600, '2026-06-23 01:51:25', '2026-06-23 01:51:25'),
(122, 12, 3, 2, 6.2200, '2026-06-23 01:51:25', '2026-06-23 01:51:25'),
(123, 12, 3, 3, 0.7200, '2026-06-23 01:51:25', '2026-06-23 01:51:25'),
(124, 12, 3, 4, 8.0000, '2026-06-23 01:51:25', '2026-06-23 01:51:25'),
(125, 12, 3, 5, 0.2300, '2026-06-23 01:51:25', '2026-06-23 01:51:25'),
(126, 13, 3, 1, 6.9200, '2026-06-23 01:52:34', '2026-06-23 01:52:34'),
(127, 13, 3, 2, 8.0700, '2026-06-23 01:52:34', '2026-06-23 01:52:34'),
(128, 13, 3, 3, 0.5000, '2026-06-23 01:52:34', '2026-06-23 01:52:34'),
(129, 13, 3, 4, 8.9300, '2026-06-23 01:52:34', '2026-06-23 01:52:34'),
(130, 13, 3, 5, 2.5800, '2026-06-23 01:52:34', '2026-06-23 01:52:34'),
(131, 14, 3, 1, 7.7800, '2026-06-23 01:53:15', '2026-06-23 01:53:15'),
(132, 14, 3, 2, 56.2600, '2026-06-23 01:53:15', '2026-06-23 01:53:15'),
(133, 14, 3, 3, 4.3000, '2026-06-23 01:53:15', '2026-06-23 01:53:15'),
(134, 14, 3, 4, 1.5900, '2026-06-23 01:53:15', '2026-06-23 01:53:15'),
(135, 14, 3, 5, 0.1400, '2026-06-23 01:53:15', '2026-06-23 01:53:15'),
(136, 15, 3, 1, 7.5400, '2026-06-23 01:53:55', '2026-06-23 01:53:55'),
(137, 15, 3, 2, 6.3200, '2026-06-23 01:53:55', '2026-06-23 01:53:55'),
(138, 15, 3, 3, 0.4400, '2026-06-23 01:53:55', '2026-06-23 02:09:39'),
(139, 15, 3, 4, 5.5500, '2026-06-23 01:53:55', '2026-06-23 01:53:55'),
(140, 15, 3, 5, 0.5600, '2026-06-23 01:53:55', '2026-06-23 01:53:55'),
(141, 16, 3, 1, 8.1100, '2026-06-23 01:54:37', '2026-06-23 01:54:37'),
(142, 16, 3, 2, 51.9400, '2026-06-23 01:54:37', '2026-06-23 01:54:37'),
(143, 16, 3, 3, 4.0600, '2026-06-23 01:54:37', '2026-06-23 01:54:37'),
(144, 16, 3, 4, 1.0300, '2026-06-23 01:54:37', '2026-06-23 01:54:37'),
(145, 16, 3, 5, 0.3900, '2026-06-23 01:54:37', '2026-06-23 01:54:37'),
(146, 17, 3, 1, 5.2600, '2026-06-23 01:55:20', '2026-06-23 01:55:20'),
(147, 17, 3, 2, 9.4700, '2026-06-23 01:55:20', '2026-06-23 01:55:20'),
(148, 17, 3, 3, 0.4800, '2026-06-23 01:55:20', '2026-06-23 01:55:20'),
(149, 17, 3, 4, 3.0000, '2026-06-23 01:55:20', '2026-06-23 01:55:20'),
(150, 17, 3, 5, 1.1000, '2026-06-23 01:55:20', '2026-06-23 01:55:20'),
(151, 18, 3, 1, 14.5500, '2026-06-23 01:56:04', '2026-06-23 01:56:04'),
(152, 18, 3, 2, 11.4500, '2026-06-23 01:56:04', '2026-06-23 01:56:04'),
(153, 18, 3, 3, 1.5400, '2026-06-23 01:56:04', '2026-06-23 01:56:04'),
(154, 18, 3, 4, 2.4200, '2026-06-23 01:56:04', '2026-06-23 01:56:04'),
(155, 18, 3, 5, 0.4100, '2026-06-23 01:56:04', '2026-06-23 02:10:40'),
(156, 19, 3, 1, 5.1300, '2026-06-23 01:56:41', '2026-06-23 01:56:41'),
(157, 19, 3, 2, 9.4500, '2026-06-23 01:56:41', '2026-06-23 01:56:41'),
(158, 19, 3, 3, 0.4700, '2026-06-23 01:56:41', '2026-06-23 01:56:41'),
(159, 19, 3, 4, 3.6400, '2026-06-23 01:56:41', '2026-06-23 01:56:41'),
(160, 19, 3, 5, 0.3100, '2026-06-23 01:56:41', '2026-06-23 01:56:41'),
(161, 20, 3, 1, 1.0600, '2026-06-23 01:57:19', '2026-06-23 01:57:19'),
(162, 20, 3, 2, 44.6400, '2026-06-23 01:57:19', '2026-06-23 01:57:19'),
(163, 20, 3, 3, 0.4800, '2026-06-23 01:57:19', '2026-06-23 01:57:19'),
(164, 20, 3, 4, 2.1900, '2026-06-23 01:57:19', '2026-06-23 01:57:19'),
(165, 20, 3, 5, 1.1300, '2026-06-23 01:57:19', '2026-06-23 01:57:19'),
(166, 21, 3, 1, 7.3800, '2026-06-23 01:57:57', '2026-06-23 01:57:57'),
(167, 21, 3, 2, 16.2000, '2026-06-23 01:57:57', '2026-06-23 01:57:57'),
(168, 21, 3, 3, 1.1600, '2026-06-23 01:57:57', '2026-06-23 01:57:57'),
(169, 21, 3, 4, 4.7600, '2026-06-23 01:57:57', '2026-06-23 01:57:57'),
(170, 21, 3, 5, 0.0900, '2026-06-23 01:57:57', '2026-06-23 01:57:57'),
(171, 5, 3, 1, 21.1500, '2026-06-23 01:58:48', '2026-06-23 01:58:48'),
(172, 5, 3, 2, 18.7700, '2026-06-23 01:58:48', '2026-06-23 01:58:48'),
(173, 5, 3, 3, 3.5300, '2026-06-23 01:58:48', '2026-06-23 01:58:48'),
(174, 5, 3, 4, 4.1600, '2026-06-23 01:58:48', '2026-06-23 01:58:48'),
(175, 5, 3, 5, 0.0200, '2026-06-23 01:58:48', '2026-06-23 01:58:48'),
(176, 6, 3, 1, 17.6700, '2026-06-23 01:59:17', '2026-06-23 01:59:17'),
(177, 6, 3, 2, 9.7300, '2026-06-23 01:59:17', '2026-06-23 01:59:17'),
(178, 6, 3, 3, 1.7000, '2026-06-23 01:59:17', '2026-06-23 01:59:17'),
(179, 6, 3, 4, 9.1400, '2026-06-23 01:59:17', '2026-06-23 01:59:17'),
(180, 6, 3, 5, 0.6700, '2026-06-23 01:59:17', '2026-06-23 01:59:17'),
(181, 7, 3, 1, 19.4900, '2026-06-23 02:00:22', '2026-06-23 02:00:22'),
(182, 7, 3, 2, 8.4500, '2026-06-23 02:00:22', '2026-06-23 02:00:22'),
(183, 7, 3, 3, 1.6200, '2026-06-23 02:00:22', '2026-06-23 02:00:22'),
(184, 7, 3, 4, 11.2100, '2026-06-23 02:00:22', '2026-06-23 02:00:22'),
(185, 7, 3, 5, 0.9600, '2026-06-23 02:00:22', '2026-06-23 02:00:22'),
(186, 8, 3, 1, 11.9900, '2026-06-23 02:00:52', '2026-06-23 02:00:52'),
(187, 8, 3, 2, 8.1300, '2026-06-23 02:00:52', '2026-06-23 02:00:52'),
(188, 8, 3, 3, 0.9500, '2026-06-23 02:00:52', '2026-06-23 02:00:52'),
(189, 8, 3, 4, 8.0000, '2026-06-23 02:00:52', '2026-06-23 02:00:52'),
(190, 8, 3, 5, 0.5300, '2026-06-23 02:00:52', '2026-06-23 02:00:52');

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
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_approved`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@spksaham.com', NULL, '$2y$12$/vP9FXL1TEO8RKm.dPV2..XzdMVZjlVDihAMIwzmmRra3SyR2Pmiy', 'admin', 1, NULL, '2026-04-05 21:48:38', '2026-07-01 17:37:34'),
(2, 'akmal rivaldi', 'akmal@gmail.com', NULL, '$2y$12$X4Y8yscY12TSTQA0H7BADeC4WB1PKTRa/sMyaNzGz5Kv8lA.5kmhK', 'user', 1, NULL, '2026-07-01 22:35:23', '2026-07-03 04:19:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `criteria_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periods_year_unique` (`year`);

--
-- Indexes for table `rankings`
--
ALTER TABLE `rankings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `period_stock_ranking_unique` (`period_id`,`stock_id`),
  ADD KEY `rankings_stock_id_foreign` (`stock_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stocks_code_unique` (`code`);

--
-- Indexes for table `stock_values`
--
ALTER TABLE `stock_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_period_criterion_unique` (`stock_id`,`period_id`,`criterion_id`),
  ADD KEY `stock_values_period_id_foreign` (`period_id`),
  ADD KEY `stock_values_criterion_id_foreign` (`criterion_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rankings`
--
ALTER TABLE `rankings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `stock_values`
--
ALTER TABLE `stock_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rankings`
--
ALTER TABLE `rankings`
  ADD CONSTRAINT `rankings_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rankings_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_values`
--
ALTER TABLE `stock_values`
  ADD CONSTRAINT `stock_values_criterion_id_foreign` FOREIGN KEY (`criterion_id`) REFERENCES `criteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_values_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_values_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
