-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2024 at 08:50 AM
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
-- Database: `courierboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `permissions` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT 1 COMMENT '0= super_admin, 1 = staff user',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 = inactive, 1 = active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `phone_no`, `permissions`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$KjP1gZGqL2brgzcTi7hFPOOCIVmudART/bjCt6s6mt5kzaB7.YCu.', NULL, NULL, 0, 1, '2022-04-15 12:25:42', '2024-07-18 08:12:30');

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
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail_address_1` varchar(255) DEFAULT NULL,
  `mail_address_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `company_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Shipper 1: 3rd Party 2: Freight 3: Courier',
  `motor_carrier_no` varchar(255) DEFAULT NULL,
  `dot_no` varchar(255) DEFAULT NULL,
  `intrastate_no` varchar(255) DEFAULT NULL,
  `alert_email_1` varchar(255) DEFAULT NULL,
  `alert_email_2` varchar(255) DEFAULT NULL,
  `alert_freight` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `alert_vehicle` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `alert_rpf` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `alert_driver` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `drivers` varchar(255) DEFAULT NULL,
  `insurance_company` varchar(255) DEFAULT NULL,
  `gen_liability` varchar(255) DEFAULT NULL,
  `cargo_insurance` varchar(255) DEFAULT NULL,
  `other_insurance` varchar(255) DEFAULT NULL,
  `insurance_declaration` varchar(255) DEFAULT NULL,
  `insurance_expiration` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_mobile` varchar(255) DEFAULT NULL,
  `account_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Exchange, 1: Premium',
  `billing_info_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Not Added, 1: Added',
  `card_number` varchar(255) DEFAULT NULL,
  `cvv` varchar(255) DEFAULT NULL,
  `expiry_month` varchar(255) DEFAULT NULL,
  `expiry_year` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `mail_address_1`, `mail_address_2`, `city`, `state`, `country`, `zip`, `company_type`, `motor_carrier_no`, `dot_no`, `intrastate_no`, `alert_email_1`, `alert_email_2`, `alert_freight`, `alert_vehicle`, `alert_rpf`, `alert_driver`, `created_at`, `updated_at`, `image`, `website`, `drivers`, `insurance_company`, `gen_liability`, `cargo_insurance`, `other_insurance`, `insurance_declaration`, `insurance_expiration`, `company_phone`, `company_mobile`, `account_type`, `billing_info_status`, `card_number`, `cvv`, `expiry_month`, `expiry_year`) VALUES
(3, 'Lorem Ipsum', '7162 Broadway', 'Manhattan', 'New York City', 'New York', 'United States', '11011', 0, '', '', '', NULL, NULL, 0, 0, 0, 0, '2024-07-22 04:54:13', '2024-07-22 04:54:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(10, 'Premium Logistics', '981 Ricford Ave', 'Queens', 'New York City', 'New York', 'United States', '11011', 3, '162781', '183726', NULL, NULL, NULL, 0, 0, 0, 0, '2024-07-22 06:09:50', '2024-07-22 06:28:44', NULL, 'https://premiumlogs.com', '10', 'Dorlq Simmit', '89000', '671928', '8912', 'Premium Logistics1721646590.pdf', NULL, NULL, NULL, 1, 1, '4242424242424242', '124', '9', '2025'),
(15, 'Robocop inc.', NULL, NULL, NULL, NULL, NULL, '10001', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '2024-07-24 01:48:26', '2024-07-24 01:48:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL);

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
(4, '2024_07_22_092956_create_companies_table', 1),
(5, '2024_07_22_094158_add_field_to_users_table', 2),
(6, '2024_07_22_100924_add_fields_to_companies_table', 3),
(7, '2024_07_22_102540_add_field_to_companies_table', 4),
(8, '2024_07_22_111546_add_field_into_companies_table', 5),
(9, '2024_07_23_082249_create_quote_requests_table', 6),
(10, '2024_07_23_115328_add_fields_to_quote_requests_table', 7),
(11, '2024_07_24_061659_add_zip_field_to_users_table', 8);

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
-- Table structure for table `quote_requests`
--

CREATE TABLE `quote_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pickup_date` varchar(255) DEFAULT NULL,
  `pickup_time` varchar(255) DEFAULT NULL,
  `start_point` varchar(255) DEFAULT NULL,
  `pickup_address_1` varchar(255) DEFAULT NULL,
  `pickup_address_2` varchar(255) DEFAULT NULL,
  `pickup_city` varchar(255) DEFAULT NULL,
  `pickup_state` varchar(255) DEFAULT NULL,
  `pickup_country` varchar(255) DEFAULT NULL,
  `pickup_zip` varchar(255) DEFAULT NULL,
  `pickup_contact_name` varchar(255) DEFAULT NULL,
  `pickup_contact_phone` varchar(255) DEFAULT NULL,
  `pickup_contact_email` varchar(255) DEFAULT NULL,
  `pickup_company` varchar(255) DEFAULT NULL,
  `delivery_point` varchar(255) DEFAULT NULL,
  `delivery_time` varchar(255) DEFAULT NULL,
  `delivery_address_1` varchar(255) DEFAULT NULL,
  `delivery_address_2` varchar(255) DEFAULT NULL,
  `delivery_city` varchar(255) DEFAULT NULL,
  `delivery_state` varchar(255) DEFAULT NULL,
  `delivery_country` varchar(255) DEFAULT NULL,
  `delivery_zip` varchar(255) DEFAULT NULL,
  `delivery_contact_name` varchar(255) DEFAULT NULL,
  `delivery_contact_phone` varchar(255) DEFAULT NULL,
  `delivery_contact_email` varchar(255) DEFAULT NULL,
  `delivery_company` varchar(255) DEFAULT NULL,
  `estimated_mileage` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `vehicle` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Any, 1 - car, 2 - minivan, 3 - suv, 4 - cargo van, 5 - sprinter, 6 - covered pickup, 7 - 16 ft Box Truck, 8 - and so on till 14 - Tractor Trailer',
  `reefer` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=No, 1 Yes',
  `hazmat` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=No, 1 Yes',
  `lift_gate` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=No, 1 Yes',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quote_requests`
--

INSERT INTO `quote_requests` (`id`, `pickup_date`, `pickup_time`, `start_point`, `pickup_address_1`, `pickup_address_2`, `pickup_city`, `pickup_state`, `pickup_country`, `pickup_zip`, `pickup_contact_name`, `pickup_contact_phone`, `pickup_contact_email`, `pickup_company`, `delivery_point`, `delivery_time`, `delivery_address_1`, `delivery_address_2`, `delivery_city`, `delivery_state`, `delivery_country`, `delivery_zip`, `delivery_contact_name`, `delivery_contact_phone`, `delivery_contact_email`, `delivery_company`, `estimated_mileage`, `weight`, `dimensions`, `description`, `vehicle`, `reefer`, `hazmat`, `lift_gate`, `user_id`, `company_id`, `transaction_id`, `created_at`, `updated_at`) VALUES
(5, '2023-12-12', '1600', '10002, Knickerbocker, NY', 'Suite 105, Tashker Hotel', 'Long Island', 'New York City', 'New York', 'United States', '10002', 'Raju Mehta', '+14567812312', 'mharis@outlook.com', 'Soft Rubber Solutions', '15470, Ohiopyle, PA', '1200', 'Alpha Store', 'Roma Barista Avenue', 'Ohiopyle', 'Pennsylvania', 'United States', '15470', 'Harold Cooper', '+!9871230908', 'mharis@outlook.com', 'FBI Black Site Ops', '335 mi', '45', '12x12x12 ft', 'Radio-active Waste', 0, 0, 1, 1, 2, 3, NULL, '2024-07-23 07:18:17', '2024-07-23 08:22:21'),
(9, '2024-12-12', '1200', NULL, NULL, NULL, 'New York', 'New York', 'United States', '10001', 'Irfan Junejo', '+18917263511', 'sceneonhai@gmail.com', 'Robocop inc.', NULL, NULL, NULL, NULL, 'New York', 'New York', 'United States', NULL, NULL, NULL, NULL, NULL, '4.7 mi', '5 lbs', '12x12x12 inches', 'Mustard Gas', 0, 0, 0, 0, 12, 15, NULL, '2024-07-24 01:48:28', '2024-07-24 01:48:28');

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
('2SGNMHLfWFktbZ8uKDLWY4tmjJF8M7mNml9blz1I', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZG1JTlRhZEJWUk42TVJZZDJnMDBOckFvOTlVZGc0R2I5cDVuM1BITSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3VzZXJzL2RldGFpbC83Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1721741213);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `meta_tag` varchar(255) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `meta_tag`, `meta_key`, `meta_value`) VALUES
(1, 'project', 'site_title', 'Drivv Courier Board'),
(2, 'project', 'short_site_title', 'DCB'),
(3, 'project', 'site_logo', 'logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: inactive, 1: active',
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_major_user` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `zip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `title`, `phone`, `fax`, `email`, `email_verified_at`, `password`, `company_id`, `status`, `phone_verified_at`, `username`, `remember_token`, `created_at`, `updated_at`, `is_major_user`, `zip`) VALUES
(2, 'John', 'Doe', 'Lorem Ipsum', '+14567189283', '+14567189283', 'john@gmail.com', NULL, '$2y$12$6ZQoHTtOR35fpfXAiabxIeNOILsqdHp5KHnFaFvzVHueTMbW7cKf6', 3, 1, NULL, 'john@gmail.com', NULL, '2024-07-22 04:54:13', '2024-07-22 04:57:02', 1, NULL),
(7, 'Ali', 'Doe', 'Assistant Director', '+14567189283', '+14567189283', 'ali@gmail.com', NULL, '$2y$12$wrklIcv.YDyhJXrDlwqOR.yTjvdhMSUy/ytsXGB/02LN2nHC928OS', 10, 1, NULL, 'ali@gmail.com', NULL, '2024-07-22 06:09:50', '2024-07-22 06:09:50', 1, NULL),
(12, 'Irfan', 'Junejo', NULL, '+18917263511', '+18917263511', 'sceneonhai@gmail.com', NULL, '$2y$12$SJnGtz3d5tgMWDrRhWBdI.QC/GDMs2MYKxO0ciTDv6lLirEvAt17C', 15, 1, NULL, 'sceneonhai@gmail.com', NULL, '2024-07-24 01:48:26', '2024-07-24 01:48:26', 1, '10001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
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
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `quote_requests`
--
ALTER TABLE `quote_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quote_requests`
--
ALTER TABLE `quote_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
