-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 01:44 PM
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
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `name`, `city`, `country`, `code`, `created_at`, `updated_at`) VALUES
(2, 'John F. Kennedy International Airport', 'Queens, NYC', 'United States of America', 'JFK', '2024-08-12 03:05:18', '2024-08-28 03:37:16'),
(3, 'Chicago O\'Hare International Airport', 'Chicago', 'United States of America', 'ORD', '2024-08-12 05:59:42', '2024-08-28 03:37:07'),
(5, 'Los Angeles International Airport', 'Los Angeles', 'United States of America', 'LAX', '2024-08-28 03:36:58', '2024-08-28 03:36:58');

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
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_company_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_company_id` bigint(20) UNSIGNED NOT NULL,
  `quote_request_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `sender_company_id`, `receiver_id`, `receiver_company_id`, `quote_request_id`, `created_at`, `updated_at`) VALUES
(1, 4, 4, NULL, 3, 7, '2024-08-27 07:49:34', '2024-08-27 07:49:34');

-- --------------------------------------------------------

--
-- Table structure for table `classifieds`
--

CREATE TABLE `classifieds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `screen_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `category` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: For Sale, 1: Help Wanted, 2: Other, 3: Position Sought, 4: Want to Purchase, 5: Warehousing',
  `photo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Inactive, 1: Active, 2: Expired',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
  `expiry_year` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `mail_address_1`, `mail_address_2`, `city`, `state`, `country`, `zip`, `company_type`, `motor_carrier_no`, `dot_no`, `intrastate_no`, `alert_email_1`, `alert_email_2`, `alert_freight`, `alert_vehicle`, `alert_rpf`, `alert_driver`, `created_at`, `updated_at`, `image`, `website`, `drivers`, `insurance_company`, `gen_liability`, `cargo_insurance`, `other_insurance`, `insurance_declaration`, `insurance_expiration`, `company_phone`, `company_mobile`, `account_type`, `billing_info_status`, `card_number`, `cvv`, `expiry_month`, `expiry_year`, `lat`, `long`) VALUES
(3, 'Transport Inrants', 'Joshua Street', '5th Avenue', 'Los Angeles', 'California', 'United States', '90001', 3, '', '', '', NULL, NULL, 0, 0, 0, 0, '2024-08-19 05:58:56', '2024-08-19 05:58:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, '33.9697897', '-118.2468148'),
(4, 'Premium Logistics', '981 Ricford Ave', 'Queens', 'New York City', 'New York', 'United States', '11011', 3, '162781', '183726', NULL, NULL, NULL, 0, 0, 0, 0, '2024-08-19 05:59:13', '2024-08-19 06:00:39', NULL, 'https://premiumlogs.com', '10', 'Dorlq Simmit', '89000', '671928', '8912', NULL, NULL, NULL, NULL, 1, 1, '4242424242424242', '124', '9', '2025', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_airports`
--

CREATE TABLE `company_airports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `airport_id` bigint(20) UNSIGNED NOT NULL,
  `operation_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_airports`
--

INSERT INTO `company_airports` (`id`, `company_id`, `airport_id`, `operation_active`, `created_at`, `updated_at`) VALUES
(2, 4, 2, 1, '2024-08-19 07:20:30', '2024-08-19 07:20:30'),
(3, 4, 3, 1, '2024-08-19 07:20:50', '2024-08-19 07:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reefer` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `hazmat` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `lift_gate` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `24_hr_dispatch` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `tsa_certified` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `on_demand_service` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `scheduled_routes` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `distributed_delivery` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `warehouse_facility` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `climate_controlled` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `biohazard_exp` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `pharma_distribution` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `international_freight` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `indirect_aircarrier` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `gps_fleet_system` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `uniformed_drivers` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `interstate_service` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `whiteglove_service` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `process_legal_service` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `car` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `minivan` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `suv` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `cargo_van` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `sprinter` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `covered_pickup` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `16ft_truck` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `18ft_truck` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `20ft_truck` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `22ft_truck` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `24ft_truck` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `26ft_truck` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `flatbed` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `tractor_trailer` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `company_id`, `reefer`, `hazmat`, `lift_gate`, `24_hr_dispatch`, `tsa_certified`, `on_demand_service`, `scheduled_routes`, `distributed_delivery`, `warehouse_facility`, `climate_controlled`, `biohazard_exp`, `pharma_distribution`, `international_freight`, `indirect_aircarrier`, `gps_fleet_system`, `uniformed_drivers`, `interstate_service`, `whiteglove_service`, `process_legal_service`, `car`, `minivan`, `suv`, `cargo_van`, `sprinter`, `covered_pickup`, `16ft_truck`, `18ft_truck`, `20ft_truck`, `22ft_truck`, `24ft_truck`, `26ft_truck`, `flatbed`, `tractor_trailer`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2024-08-19 05:58:56', '2024-08-19 05:58:56'),
(2, 4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2024-08-19 05:59:13', '2024-08-19 05:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `driver_ads`
--

CREATE TABLE `driver_ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: Independent, 1: Full Time, 2: Part time, 3: Temporary, 4: Seasonal',
  `compensation` varchar(255) DEFAULT NULL,
  `compensation_type` varchar(255) DEFAULT NULL,
  `vehicle_types` varchar(255) DEFAULT NULL,
  `reefer` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `hazmat` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `lift_gate` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `tsa_certified` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `experience` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Any, 1: 0-6 mo, 2: 7-12 mo, 3: 13-18 mo, 4: 19-24 mo, 5: more than 24 mo',
  `insurance_coverage` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `show_company_name` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: No, 1: Yes',
  `ad_title` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `response_info` mediumtext DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `div_id` varchar(255) DEFAULT NULL,
  `fee` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: Inactive, 1: Active, 2: Expired',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `driver_ads`
--

INSERT INTO `driver_ads` (`id`, `user_id`, `company_id`, `type`, `compensation`, `compensation_type`, `vehicle_types`, `reefer`, `hazmat`, `lift_gate`, `tsa_certified`, `city`, `state`, `zip`, `experience`, `insurance_coverage`, `company_name`, `show_company_name`, `ad_title`, `description`, `response_info`, `company_logo`, `contact_email`, `div_id`, `fee`, `status`, `created_at`, `updated_at`) VALUES
(3, 3, 3, 0, '12000 - 16000', 'Per Month', '[0,1,2,3]', 0, 1, 0, 1, 'Chicago', 'Illinois', '60007', 1, '1200', NULL, 1, 'Driver Wanted Independent Contractor Chicago With Benefits & Allowances', 'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', 'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', 'Transport-Inrants16081724327199.png', 'red@gmail.com', '929', NULL, 1, '2024-08-22 06:24:17', '2024-08-22 06:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `driver_contact_lists`
--

CREATE TABLE `driver_contact_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `driver_ad_id` bigint(20) UNSIGNED NOT NULL,
  `driver_response_id` bigint(20) UNSIGNED NOT NULL,
  `email_sent` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `driver_contact_lists`
--

INSERT INTO `driver_contact_lists` (`id`, `user_id`, `company_id`, `driver_ad_id`, `driver_response_id`, `email_sent`, `created_at`, `updated_at`) VALUES
(2, 3, 3, 3, 1, 1, '2024-08-23 07:11:04', '2024-08-23 07:25:32');

-- --------------------------------------------------------

--
-- Table structure for table `driver_responses`
--

CREATE TABLE `driver_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_ad_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `vehicle_types` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: Inactive, 1: Active, 2: Accepted, 3: Rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `driver_responses`
--

INSERT INTO `driver_responses` (`id`, `driver_ad_id`, `company_id`, `user_id`, `name`, `city`, `state`, `vehicle_types`, `contact_email`, `contact_phone`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 4, 'John F Kennedy', 'Chicago', 'Illinois', '[0,1,2,3]', 'arslan@gmail.com', '+1987265121', 'All the details and bids etc.', 1, '2024-08-22 07:08:15', '2024-08-22 07:08:15');

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
-- Table structure for table `filings`
--

CREATE TABLE `filings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: company, 1: freight, 2:vehicle, 3: rfp',
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `filings`
--

INSERT INTO `filings` (`id`, `company_id`, `user_id`, `post_id`, `type`, `city`, `state`, `note`, `created_at`, `updated_at`) VALUES
(2, 4, 4, 3, 0, 'Los Angeles', 'California', 'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', '2024-08-19 07:05:39', '2024-08-19 07:07:19');

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_company_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_company_id` bigint(20) UNSIGNED NOT NULL,
  `message` mediumtext NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: unread, 1: read',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `sender_id`, `sender_company_id`, `receiver_id`, `receiver_company_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 4, NULL, 3, 'Hello, Please share mroe info regarding your post', 0, '2024-08-27 07:49:34', '2024-08-27 07:49:34'),
(2, 1, 4, 4, NULL, 3, 'Hello, Please share mroe info regarding your post', 0, '2024-08-28 05:34:40', '2024-08-28 05:34:40'),
(4, 1, 3, 3, NULL, 4, 'Replied', 0, '2024-08-28 06:36:04', '2024-08-28 06:36:04'),
(5, 1, 3, 3, NULL, 4, 'What else do you wanna ask?', 0, '2024-08-28 06:36:34', '2024-08-28 06:36:34');

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
(11, '2024_07_24_061659_add_zip_field_to_users_table', 8),
(12, '2024_07_24_102722_create_quote_bids_table', 9),
(13, '2024_07_24_115239_add_field_to_quote_requests_table', 10),
(14, '2024_07_24_115435_add_field_to_quote_bids_table', 11),
(15, '2024_07_25_065743_add_fields_to_users_table', 12),
(16, '2024_07_30_124021_create_rfps_table', 13),
(17, '2024_07_31_100412_add_fields_to_rfps_table', 14),
(18, '2024_08_02_062429_add_field_to_rfps_table', 15),
(19, '2024_08_02_073700_create_rfp_bids_table', 16),
(20, '2024_08_02_115732_add_fields_to_rfps_table', 17),
(21, '2024_08_02_133349_add_field_to_rfp_bids_table', 18),
(22, '2024_08_05_063340_add_fields_to_companies_table', 19),
(23, '2024_08_05_092024_add_fields_to_rfps_table', 20),
(24, '2024_08_05_105735_add_fields_to_quote_requests_table', 21),
(32, '2024_08_08_090556_company_profile', 22),
(33, '2024_08_08_101232_airports', 22),
(34, '2024_08_08_102400_create_company_airports_table', 22),
(35, '2024_08_08_102738_create_warehouses_table', 22),
(37, '2024_08_19_085338_create_filings_table', 23),
(38, '2024_08_21_094621_create_vehicle_posts_table', 24),
(39, '2024_08_21_094632_create_vehicle_stops_table', 24),
(40, '2024_08_22_093931_create_driver_ads_table', 25),
(42, '2024_08_22_120158_create_driver_responses_table', 26),
(43, '2024_08_23_052904_create_driver_contact_lists_table', 27),
(44, '2024_08_26_103626_add_field_to_users_table', 28),
(45, '2024_08_26_103719_create_classifieds_table', 29),
(50, '2024_08_27_101842_create_chats_table', 30),
(51, '2024_08_27_102040_create_messages_table', 30);

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
-- Table structure for table `quote_bids`
--

CREATE TABLE `quote_bids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `contact_fname` varchar(255) DEFAULT NULL,
  `contact_lname` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 : listed, 1 : unlisted , 2 : accepted 3 : completed, 4: removed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '	0 : listed, 1 : bid , 2 : accepted 3 : completed, 4: removed	',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_lat` decimal(10,8) DEFAULT NULL,
  `start_long` decimal(10,8) DEFAULT NULL,
  `dellivery_lat` decimal(10,8) DEFAULT NULL,
  `dellivery_long` decimal(10,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quote_requests`
--

INSERT INTO `quote_requests` (`id`, `pickup_date`, `pickup_time`, `start_point`, `pickup_address_1`, `pickup_address_2`, `pickup_city`, `pickup_state`, `pickup_country`, `pickup_zip`, `pickup_contact_name`, `pickup_contact_phone`, `pickup_contact_email`, `pickup_company`, `delivery_point`, `delivery_time`, `delivery_address_1`, `delivery_address_2`, `delivery_city`, `delivery_state`, `delivery_country`, `delivery_zip`, `delivery_contact_name`, `delivery_contact_phone`, `delivery_contact_email`, `delivery_company`, `estimated_mileage`, `weight`, `dimensions`, `description`, `vehicle`, `reefer`, `hazmat`, `lift_gate`, `status`, `user_id`, `company_id`, `transaction_id`, `created_at`, `updated_at`, `start_lat`, `start_long`, `dellivery_lat`, `dellivery_long`) VALUES
(7, '2024-08-29', '1600', '10001, New York, NY', NULL, NULL, 'New York', 'New York', 'United States', '10001', 'Ola Amista', NULL, 'red@gmail.com', NULL, '15470, Ohiopyle, PA', '1200', NULL, NULL, 'Ohiopyle', 'Pennsylvania', 'United States', '15470', 'Ola Amista', NULL, 'red@gmail.com', NULL, '334 mi', '45', '12x12x12 ft', 'Lorem Ipsum Dolor Simit', 0, 0, 1, 1, 0, 3, 3, NULL, '2024-08-27 07:48:00', '2024-08-27 07:48:00', 40.75368540, -73.99916370, 39.84484310, -79.52662110);

-- --------------------------------------------------------

--
-- Table structure for table `rfps`
--

CREATE TABLE `rfps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `route_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Dedicated, 1: Distribution',
  `multiple_routes` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `vehicle_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Any, 1 - car, 2 - minivan, 3 - suv, 4 - cargo van, 5 - sprinter, 6 - covered pickup, 7 - 16 ft Box Truck, 8 - and so on till 14 - Tractor Trailer',
  `reefer` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=No, 1 Yes',
  `hazmat` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=No, 1 Yes',
  `lift_gate` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=No, 1 Yes',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '	0 : listed, 1 : bid , 2 : accepted 3 : completed, 4: removed',
  `start_point` varchar(255) DEFAULT NULL,
  `delivery_point` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `payment_terms` varchar(255) DEFAULT NULL,
  `bid_price` text DEFAULT NULL,
  `estimated_mileage` varchar(255) DEFAULT NULL,
  `insurance_coverage` varchar(255) DEFAULT NULL,
  `bid_per_stop` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: No, 1:Yes',
  `bid_per_route` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: No, 1:Yes',
  `other_requirements` text DEFAULT NULL,
  `bid_due` varchar(255) DEFAULT NULL,
  `recipients` text DEFAULT NULL,
  `doc_1` varchar(255) DEFAULT NULL,
  `doc_2` varchar(255) DEFAULT NULL,
  `contact_company` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_city` varchar(255) DEFAULT NULL,
  `start_state` varchar(255) DEFAULT NULL,
  `start_zip` varchar(255) DEFAULT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `long` decimal(10,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rfp_bids`
--

CREATE TABLE `rfp_bids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rfp_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `terms` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 : listed, 1 : unlisted , 2 : accepted 3 : completed, 4: removed ',
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
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
('YSTVe7oYprub0Mp2tkDgBY0jkjjNnxccjf6EJ0Rp', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:129.0) Gecko/20100101 Firefox/129.0', 'YTo0OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NToiaHR0cDovL2xvY2FsaG9zdC9jb3VyaWVyYm9hcmQvYWRtaW4vY29tcGFuaWVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6InRjM3BpWnUxUjN3VHE3TXZGV0drRTQ5ZEJXSGpWejQwYUhLaHRBb3EiO3M6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1724843506);

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
  `phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: inactive, 1: active, 2: softdeleted',
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_major_user` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `has_alerts` tinyint(4) NOT NULL DEFAULT 0,
  `has_post_func` tinyint(4) NOT NULL DEFAULT 0,
  `has_acc_info` tinyint(4) NOT NULL DEFAULT 0,
  `zip` varchar(255) DEFAULT NULL,
  `screen_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `title`, `phone`, `fax`, `email`, `email_verified_at`, `password`, `company_id`, `status`, `phone_verified_at`, `username`, `remember_token`, `created_at`, `updated_at`, `is_major_user`, `has_alerts`, `has_post_func`, `has_acc_info`, `zip`, `screen_name`) VALUES
(3, 'Raymond', 'Reddington', 'Director Operations', '+14567199881', '+14567199881', 'red@gmail.com', NULL, '$2y$12$eJ6wyVXsqyzawuPuAvffF.IuRvYcBqfwHdRhufKH.BWQ7zHg64hRq', 3, 1, NULL, 'red@gmail.com', NULL, '2024-08-19 05:58:56', '2024-08-19 05:58:56', 1, 0, 0, 0, NULL, NULL),
(4, 'John', 'Doe', 'Assistant Director', '+14567189283', '+14567189283', 'john@gmail.com', NULL, '$2y$12$wOr05sOWbtm6IWcf4JuHUO3wdMY9OPqamgvEeEtSQz96sod4Kp6QS', 4, 1, NULL, 'john@gmail.com', NULL, '2024-08-19 05:59:13', '2024-08-19 05:59:13', 1, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_posts`
--

CREATE TABLE `vehicle_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `route_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: On Demand, 1: Scheduled',
  `vehicle_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Car, 1: Bike, 2: Truck and so on',
  `date_available` varchar(255) DEFAULT NULL,
  `start_city` varchar(255) DEFAULT NULL,
  `start_state` varchar(255) DEFAULT NULL,
  `start_zip` varchar(255) DEFAULT NULL,
  `start_lat` decimal(10,6) DEFAULT NULL,
  `start_lng` decimal(10,6) DEFAULT NULL,
  `departure` varchar(255) DEFAULT NULL,
  `destination_city` varchar(255) DEFAULT NULL,
  `destination_state` varchar(255) DEFAULT NULL,
  `destination_zip` varchar(255) DEFAULT NULL,
  `destination_lat` decimal(10,6) DEFAULT NULL,
  `destination_lng` decimal(10,6) DEFAULT NULL,
  `arrival` varchar(255) DEFAULT NULL,
  `mileage` varchar(255) DEFAULT NULL,
  `reefer` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `liftgate` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `hazmat` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `round_trip` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
  `other_info` text DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: Inactive, 1: Active, 2: Expired, 3: Availed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_posts`
--

INSERT INTO `vehicle_posts` (`id`, `user_id`, `company_id`, `route_type`, `vehicle_type`, `date_available`, `start_city`, `start_state`, `start_zip`, `start_lat`, `start_lng`, `departure`, `destination_city`, `destination_state`, `destination_zip`, `destination_lat`, `destination_lng`, `arrival`, `mileage`, `reefer`, `liftgate`, `hazmat`, `round_trip`, `other_info`, `contact_name`, `contact_phone`, `contact_email`, `status`, `created_at`, `updated_at`) VALUES
(7, 4, 4, 0, 1, '22-08-2024', 'Manhattan', 'New York', '10001', 40.783060, -73.971249, '1400', 'Chicago', 'Illinois', NULL, 41.878114, -87.629798, '2200', '798 mi', 1, 0, 1, 1, 'Lorem Ipsum', 'John Snow', '+!9872341019', 'johnsnow@gmail.com', 1, '2024-08-21 05:12:57', '2024-08-21 07:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_stops`
--

CREATE TABLE `vehicle_stops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_post_id` bigint(20) UNSIGNED NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `lat` decimal(10,6) DEFAULT NULL,
  `lng` decimal(10,6) DEFAULT NULL,
  `arrival` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_stops`
--

INSERT INTO `vehicle_stops` (`id`, `vehicle_post_id`, `city`, `state`, `zip`, `lat`, `lng`, `arrival`, `created_at`, `updated_at`) VALUES
(10, 6, 'New York', 'New York', '10012', NULL, NULL, '1600', '2024-08-21 06:48:04', '2024-08-21 06:48:04'),
(11, 6, 'Philadelphia', 'Pennsylvania', '19107', NULL, NULL, '1800', '2024-08-21 06:48:04', '2024-08-21 06:48:04'),
(12, 7, 'New York', 'New York', '10012', NULL, NULL, '1600', '2024-08-21 07:13:57', '2024-08-21 07:13:57'),
(13, 7, 'Philadelphia', 'Pennsylvania', '19107', NULL, NULL, '1800', '2024-08-21 07:13:57', '2024-08-21 07:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `company_id`, `city`, `state`, `country`, `zip`, `lat`, `long`, `created_at`, `updated_at`) VALUES
(2, 'Alpha Warehouses', 4, 'New York', 'New York', 'United States', '10003', '40.7322535', '-73.9874105', '2024-08-19 07:21:00', '2024-08-19 07:21:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `airports_code_unique` (`code`);

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
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classifieds`
--
ALTER TABLE `classifieds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_airports`
--
ALTER TABLE `company_airports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_ads`
--
ALTER TABLE `driver_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_contact_lists`
--
ALTER TABLE `driver_contact_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_responses`
--
ALTER TABLE `driver_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `filings`
--
ALTER TABLE `filings`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
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
-- Indexes for table `quote_bids`
--
ALTER TABLE `quote_bids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quote_requests`
--
ALTER TABLE `quote_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfps`
--
ALTER TABLE `rfps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfp_bids`
--
ALTER TABLE `rfp_bids`
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
-- Indexes for table `vehicle_posts`
--
ALTER TABLE `vehicle_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_stops`
--
ALTER TABLE `vehicle_stops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `airports`
--
ALTER TABLE `airports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classifieds`
--
ALTER TABLE `classifieds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_airports`
--
ALTER TABLE `company_airports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `driver_ads`
--
ALTER TABLE `driver_ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `driver_contact_lists`
--
ALTER TABLE `driver_contact_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `driver_responses`
--
ALTER TABLE `driver_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `filings`
--
ALTER TABLE `filings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `quote_bids`
--
ALTER TABLE `quote_bids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote_requests`
--
ALTER TABLE `quote_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rfps`
--
ALTER TABLE `rfps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rfp_bids`
--
ALTER TABLE `rfp_bids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_posts`
--
ALTER TABLE `vehicle_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicle_stops`
--
ALTER TABLE `vehicle_stops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
