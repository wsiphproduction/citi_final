-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2022 at 09:19 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `citi_hardware`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fields` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_matrix`
--

CREATE TABLE `account_matrix` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double DEFAULT NULL,
  `code` tinyint(1) NOT NULL,
  `beyond` tinyint(1) DEFAULT NULL,
  `regardless` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_matrix`
--

INSERT INTO `account_matrix` (`id`, `name`, `number`, `amount`, `code`, `beyond`, `regardless`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Stripping Charge', 'sc-1012', 10000, 1, 1, NULL, 1, 'Splakatutay', NULL, '2022-03-02 05:24:08', '2022-03-02 05:24:08'),
(2, 'Production Cost Clearing', '231', 222, 1, 1, NULL, 0, 'Splakatutay', NULL, '2022-03-02 06:42:11', '2022-03-02 06:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `account_transactions`
--

CREATE TABLE `account_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pcv_id` int(10) UNSIGNED DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_transactions`
--

INSERT INTO `account_transactions` (`id`, `name`, `pcv_id`, `details`, `created_at`, `updated_at`, `deleted_at`, `status`, `approval_code`, `approved_by`, `approved_date`, `remarks`) VALUES
(1, 'Meals', 1, '{\"vendor\":\"Vendor 1\",\"per_diem\":\"2\",\"no_of_days\":\"2\",\"total_amount\":\"2\",\"description\":\"test description\"}', '2022-03-03 18:34:31', '2022-03-03 18:34:31', NULL, 'approved', NULL, NULL, NULL, NULL),
(2, 'Transportation', 2, '{\"no_of_days\":\"5\",\"amount\":\"2000\",\"description\":\"TEST DESCRIPTION\"}', '2022-03-03 18:36:41', '2022-03-03 18:36:41', NULL, 'approved', NULL, NULL, NULL, NULL),
(3, 'Meals', 3, '{\"vendor\":\"Vendor 1\",\"per_diem\":\"1000\",\"no_of_days\":\"2\",\"amount\":\"2000\",\"description\":\"TEST\"}', '2022-03-03 23:12:32', '2022-03-03 23:12:32', NULL, 'approved', NULL, NULL, NULL, NULL),
(4, 'Overtime', 4, '{\"ot_date\":\"2022-03-04\",\"no_of_pax\":\"5\",\"amount\":\"2000\",\"description\":\"TEST DESCRIPTION\"}', '2022-03-03 23:14:01', '2022-03-03 23:14:01', NULL, 'approved', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_ref` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `from`, `from_ref`, `type`, `ref`, `date`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 'pcv', '1', 'ATM Slip', 'ref102', '2022-03-04', 'PCV-2203-1_04-03-2022-02-34_explosives.jfif', '2022-03-03 18:34:31', '2022-03-03 18:34:31'),
(2, 'pcv', '2', 'Withdrawal Slip', 'ref101', '2022-03-04', 'PCV-2203-2_04-03-2022-02-36_Australia Invoice blank.png', '2022-03-03 18:36:41', '2022-03-03 18:36:41'),
(3, 'pcv', '3', 'Cash Count Sheet', 'ref102', '2022-03-04', 'PCV-2203-3_04-03-2022-07-12_explosives.jfif', '2022-03-03 23:12:32', '2022-03-03 23:12:32'),
(4, 'pcv', '4', 'Withdrawal Slip', 'ref101', '2022-03-04', 'PCV-2203-4_04-03-2022-07-13_Hnet.com-image.png', '2022-03-03 23:14:01', '2022-03-03 23:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `branch_departments`
--

CREATE TABLE `branch_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_departments`
--

INSERT INTO `branch_departments` (`id`, `branch_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'dept 1', NULL, NULL),
(2, 1, 'dept 2', NULL, NULL),
(3, 1, 'dept 3', NULL, NULL),
(4, 2, 'dept 1', NULL, NULL),
(5, 3, 'dept 2', NULL, NULL),
(6, 3, 'dept 4', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch_groups`
--

CREATE TABLE `branch_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_groups`
--

INSERT INTO `branch_groups` (`id`, `name`, `size`, `branch`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Group A', 'medium', '[\"D-C MATINA\",\"SSC DAVAO\",\"STORE SM\"]', 1, 'Splakatutay', NULL, '2022-03-01 22:20:23', '2022-03-01 22:20:23');

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge_to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `charges`
--

INSERT INTO `charges` (`id`, `name`, `charge_to`, `code`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Stripping Charge', 'Store', '51002', 'expense', '2022-03-01 22:17:56', '2022-03-01 22:17:56', NULL),
(2, 'Stripping Charge', 'Vendor', '11701', 'receivable', '2022-03-01 22:18:11', '2022-03-01 22:18:11', NULL),
(3, 'Pakyawan', 'Store', '60102', 'expense', '2022-03-01 22:19:13', '2022-03-01 22:19:13', NULL),
(4, 'Pakyawan', 'Supplier', '11701', 'receivable', '2022-03-01 22:19:29', '2022-03-01 22:19:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(119, '2014_10_12_000000_create_users_table', 1),
(120, '2014_10_12_100000_create_password_resets_table', 1),
(121, '2019_08_19_000000_create_failed_jobs_table', 1),
(122, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(123, '2022_02_02_031145_create_permission_tables', 1),
(124, '2022_02_03_015042_create_modules_table', 1),
(125, '2022_02_05_013549_create_accounts_table', 1),
(126, '2022_02_09_015430_create_temporary_slips_table', 1),
(127, '2022_02_09_072325_create_pcv_table', 1),
(128, '2022_02_10_025221_create_vendors_table', 1),
(129, '2022_02_14_022228_create_charges_table', 1),
(130, '2022_02_16_091010_create_account_transactions_table', 1),
(131, '2022_02_17_054612_create_attachments_table', 1),
(132, '2022_02_22_053721_update_pcv_table', 1),
(133, '2022_02_24_083835_update_temporary_slips_table', 1),
(134, '2022_02_28_024201_update_account_transactions_table', 1),
(135, '2022_02_28_054209_create_temp_pos_transaction_table', 1),
(136, '2022_03_01_030610_create_temp_branch_table', 1),
(137, '2022_03_01_033939_create_branch_group_table', 1),
(138, '2022_03_01_062131_update_users_table', 1),
(139, '2022_03_02_014140_create_temp_truckers_table', 1),
(143, '2022_03_02_112056_create_account_matrix_table', 2),
(146, '2022_03_02_145937_update_userss_table', 3),
(147, '2022_03_03_061438_branch_departments', 4),
(148, '2022_03_03_090104_update_temporary_slips_tablee', 5),
(157, '2022_03_03_144036_update_usersss_table', 6),
(160, '2022_03_03_155715_update_pcv_tablee', 7),
(161, '2022_03_03_194005_create_pcfr_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `actions`, `created_at`, `updated_at`) VALUES
(1, 'ts', '[\"view\",\"add\",\"edit\",\"delete\"]', '2022-03-01 22:14:27', '2022-03-01 22:14:27'),
(2, 'pcv', '[\"view\",\"add\",\"edit\",\"delete\"]', '2022-03-01 22:14:37', '2022-03-01 22:14:37'),
(3, 'pcfr', '[\"view\",\"add\",\"edit\",\"delete\"]', '2022-03-01 22:14:56', '2022-03-01 22:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pcfr`
--

CREATE TABLE `pcfr` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pcfr_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` date NOT NULL,
  `branche_id` int(11) NOT NULL,
  `doc_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `total_temp_slip` int(11) NOT NULL,
  `total_replenishment` int(11) NOT NULL,
  `total_unreplenished` int(11) NOT NULL,
  `total_unapproved_pcv` int(11) NOT NULL,
  `total_returned_pcv` int(11) NOT NULL,
  `total_accounted` int(11) NOT NULL,
  `pcf_accountability` double NOT NULL,
  `pcf_diff` double NOT NULL,
  `atm_balance` double NOT NULL,
  `cash_on_hand` double NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pcv`
--

CREATE TABLE `pcv` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slip_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `change` double NOT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` date NOT NULL,
  `pcv_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `received_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `cancelled_date` date DEFAULT NULL,
  `cancelled_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `approver_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tl_approved` tinyint(1) NOT NULL DEFAULT '0',
  `py_staff_approved` tinyint(1) NOT NULL DEFAULT '0',
  `dh_approved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pcv`
--

INSERT INTO `pcv` (`id`, `slip_no`, `change`, `account_name`, `date_created`, `pcv_no`, `status`, `approval_code`, `approved_by`, `approved_date`, `received_by`, `received_date`, `user_id`, `created_at`, `updated_at`, `amount`, `cancelled_date`, `cancelled_by`, `remarks`, `approver_name`, `tl_approved`, `py_staff_approved`, `dh_approved`) VALUES
(1, NULL, 1000, 'Meals', '2022-03-04', 'PCV-2203-1', 'submitted', NULL, 'dctl', '2022-03-04', 'Me', '2022-03-04', 8, '2022-03-03 18:34:31', '2022-03-03 22:25:41', 10000, NULL, NULL, NULL, NULL, 0, 0, 0),
(2, NULL, 22, 'Transportation', '2022-03-04', 'PCV-2203-2', 'saved', NULL, NULL, NULL, NULL, NULL, 8, '2022-03-03 18:36:41', '2022-03-03 18:36:41', 2000, NULL, NULL, NULL, NULL, 0, 0, 0),
(3, NULL, 500, 'Meals', '2022-03-04', 'PCV-2203-3', 'approved', NULL, 'sscdh', '2022-03-04', 'You', '2022-03-04', 11, '2022-03-03 23:12:32', '2022-03-04 00:08:37', 2000, NULL, NULL, NULL, NULL, 1, 0, 0),
(4, NULL, 0, 'Overtime', '2022-03-04', 'PCV-2203-4', 'submitted', NULL, NULL, NULL, 'hello', '2022-03-04', 14, '2022-03-03 23:14:01', '2022-03-03 23:14:32', 4000, NULL, NULL, NULL, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ts view', 'web', '2022-03-01 22:15:13', '2022-03-01 22:15:13'),
(2, 'ts add', 'web', '2022-03-01 22:15:13', '2022-03-01 22:15:13'),
(3, 'ts edit', 'web', '2022-03-01 22:15:13', '2022-03-01 22:15:13'),
(4, 'ts delete', 'web', '2022-03-01 22:15:13', '2022-03-01 22:15:13'),
(5, 'pcv view', 'web', '2022-03-01 22:15:14', '2022-03-01 22:15:14'),
(6, 'pcv add', 'web', '2022-03-01 22:15:14', '2022-03-01 22:15:14'),
(7, 'pcv edit', 'web', '2022-03-01 22:15:14', '2022-03-01 22:15:14'),
(8, 'pcv delete', 'web', '2022-03-01 22:15:14', '2022-03-01 22:15:14'),
(9, 'pcfr view', 'web', '2022-03-01 22:15:14', '2022-03-01 22:15:14'),
(10, 'pcfr add', 'web', '2022-03-01 22:15:14', '2022-03-01 22:15:14'),
(11, 'pcfr edit', 'web', '2022-03-01 22:15:14', '2022-03-01 22:15:14'),
(12, 'pcfr delete', 'web', '2022-03-01 22:15:14', '2022-03-01 22:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'web', '2022-03-01 22:13:55', '2022-03-01 22:13:55'),
(2, 'Requestor', 'web', '2022-03-02 20:51:56', '2022-03-02 20:51:56'),
(3, 'TL Approver', 'web', '2022-03-02 21:33:32', '2022-03-03 19:04:10'),
(4, 'Payable Approver', 'web', '2022-03-03 19:04:19', '2022-03-03 19:04:19'),
(5, 'Department Head', 'web', '2022-03-03 22:37:13', '2022-03-03 22:37:13'),
(6, 'Division Head', 'web', '2022-03-03 22:37:21', '2022-03-03 22:37:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(3, 1),
(3, 2),
(3, 3),
(3, 5),
(4, 1),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(8, 1),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `temporary_slips`
--

CREATE TABLE `temporary_slips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ts_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `running_balance` double NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `received_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_date` date DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_created` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `cancelled_date` date DEFAULT NULL,
  `cancelled_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `approver_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temporary_slips`
--

INSERT INTO `temporary_slips` (`id`, `ts_no`, `account_name`, `amount`, `running_balance`, `description`, `status`, `approval_code`, `approved_by`, `approved_date`, `received_by`, `received_date`, `user_id`, `date_created`, `created_at`, `updated_at`, `deleted_at`, `cancelled_date`, `cancelled_by`, `remarks`, `approver_name`) VALUES
(1, 'TS-0001', 'Stripping Charge', 20000, 20000, 'TEST CHARGE', 'approved', 'TEST CODE', 'dctl', '2022-03-04', 'me', '2022-03-04', 8, '2022-03-04', '2022-03-03 17:51:26', '2022-03-03 18:01:38', NULL, NULL, NULL, 'TEST REMARKS', 'dcareahead'),
(2, 'TS-0002', 'Production Cost Clearing', 5000, 5000, 'TEST DESCRIPTION', 'approved', NULL, NULL, NULL, 'you', '2022-03-04', 8, '2022-03-04', '2022-03-03 17:51:53', '2022-03-03 17:54:54', NULL, NULL, NULL, NULL, NULL),
(3, 'TS-0003', 'Extra Labor', 6000, 6000, 'TEST DESCRIPTION', 'approved', NULL, NULL, NULL, 'ME', '2022-03-04', 8, '2022-03-04', '2022-03-03 17:57:59', '2022-03-03 17:58:51', NULL, NULL, NULL, NULL, NULL),
(4, 'TS-0004', 'Delivery Charges', 5000, 5000, 'TEST DESCRIPTION', 'approved', NULL, 'sscdh', '2022-03-04', 'me', '2022-03-04', 11, '2022-03-04', '2022-03-03 22:49:55', '2022-03-03 23:09:30', NULL, NULL, NULL, NULL, NULL),
(5, 'TS-0005', 'Stripping Charge', 2222, 2222, '222', 'submitted', NULL, NULL, NULL, 'me', '2022-03-04', 14, '2022-03-04', '2022-03-03 22:57:43', '2022-03-03 22:57:43', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `temp_branch`
--

CREATE TABLE `temp_branch` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` double NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_branch`
--

INSERT INTO `temp_branch` (`id`, `name`, `budget`, `created_by`, `updated_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SSC DAVAO', 50000, 'Splakatutay', NULL, 1, '2022-03-01 22:19:50', '2022-03-01 22:19:50'),
(2, 'D-C MATINA', 40000, 'Splakatutay', NULL, 1, '2022-03-01 22:19:59', '2022-03-01 22:19:59'),
(3, 'STORE SM', 30000, 'Splakatutay', NULL, 1, '2022-03-01 22:20:08', '2022-03-01 22:20:08');

-- --------------------------------------------------------

--
-- Table structure for table `temp_pos_transactions`
--

CREATE TABLE `temp_pos_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pos_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_qty` int(11) NOT NULL,
  `qty_with_pcv` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_truckers`
--

CREATE TABLE `temp_truckers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slps_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plate_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trucker` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode_of_payment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_truckers`
--

INSERT INTO `temp_truckers` (`id`, `slps_no`, `plate_no`, `trucker`, `mode_of_payment`, `created_at`, `updated_at`) VALUES
(1, '55-66', 'plate123', 'trucker a', 'cod', NULL, NULL),
(2, '55-66', 'plate456', 'trucker b', 'cod', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_group_id` int(11) DEFAULT NULL,
  `assign_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `email_verified_at`, `password`, `remember_token`, `status`, `created_at`, `updated_at`, `deleted_at`, `lastname`, `middlename`, `position`, `branch_group_id`, `assign_to`, `assign_name`, `created_by`, `updated_by`) VALUES
(1, 'Splakatutay', 'rey', NULL, '$2y$10$Wyoi0Z90WCcA2dBvR787ieF5iTY8lCqSaqT9yjkCAC7G82QHt5xs.', NULL, 1, NULL, NULL, NULL, 'last', 'name', 'Administrator', NULL, '', '', '', ''),
(7, 'dctl', 'TL', NULL, '$2y$10$DWSj6OALEHzz4TLX8gjh0.XfzDJ6g7dmzcIfUUys/O6NAXAy23ec6', NULL, 1, '2022-03-03 17:47:10', '2022-03-03 17:48:20', NULL, 'DC', 'TEST', 'team leader', NULL, '2', 'dept 1', 'Splakatutay', NULL),
(8, 'dcrequestor', 'REQUESTOR', NULL, '$2y$10$By4tMZLEw5YLcLHf1BkPYeFHozs5bn9jLLYIRbOONZ3xCsBr5529m', NULL, 1, '2022-03-03 17:48:04', '2022-03-03 17:48:04', NULL, 'DC', 'TEST', 'department staff', NULL, '2', 'dept 1', 'Splakatutay', NULL),
(9, 'dcareahead', 'AREA HEAD', NULL, '$2y$10$Nl3pHljg4Bk/x7o4j4Z3xeBrTpfbEufQlJ0N6yROvZdN8pFrnNVge', NULL, 1, '2022-03-03 17:50:25', '2022-03-03 17:50:25', NULL, 'DC', 'TEST', 'area head', 1, NULL, NULL, 'Splakatutay', NULL),
(10, 'dcpayable', 'PAYABLE', NULL, '$2y$10$G4XVjCE/RBKky0WdTk.6Ne2LrPZ.SQbhCwv1S/K63nlRgEDr0UPTG', NULL, 1, '2022-03-03 18:51:27', '2022-03-03 18:51:27', NULL, 'DC', 'TEST', 'payables staff', NULL, '2', 'dept 1', 'Splakatutay', NULL),
(11, 'sscrequestor', 'REQUESTOR', NULL, '$2y$10$0xC4dqLgmrinlMMrw0j7WOtg5mX4t1kgAzSXnXvO/gbXUrJlawL1O', NULL, 1, '2022-03-03 22:34:11', '2022-03-03 22:34:11', NULL, 'SSC', 'TEST', 'department staff', NULL, '1', 'dept 2', 'Splakatutay', NULL),
(12, 'sscdh', 'DEPT HEAD', NULL, '$2y$10$UPSe/hx9kQW55EHPP43nQ.WKytcSQa3bGSYB6dMr1BvlI/m0X55zO', NULL, 1, '2022-03-03 22:35:34', '2022-03-03 22:35:34', NULL, 'SSC', 'TEST', 'department head', NULL, '1', 'dept 2', 'Splakatutay', NULL),
(13, 'ssddivh', 'DIV HEAD', NULL, '$2y$10$nzfSdJtu7Ee26Q6qU/gugOKBXmXi6gaNhtftM2UkYCkGk1wDHK.72', NULL, 1, '2022-03-03 22:36:57', '2022-03-03 22:36:57', NULL, 'SSC', 'TEST', 'division head', NULL, '1', 'dept 2', 'Splakatutay', NULL),
(14, 'sscrequestor1', 'REQUESTOR 1', NULL, '$2y$10$JsOMUEGrWORoaHXU/l4YFOTg2fGMQ80Nzz14OrEU3/ql5jp05Rf/2', NULL, 1, '2022-03-03 22:57:05', '2022-03-03 22:57:05', NULL, 'SSC', 'TEST', 'department staff', NULL, '1', 'dept 1', 'Splakatutay', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `tin`, `contact_number`, `address`, `status`, `attachment`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Vendor 1', '123', '321', 'Test address', 1, '[]', 'Splakatutay', NULL, '2022-03-01 22:16:54', '2022-03-01 22:16:54', NULL),
(2, 'Vendor 2', '5553', '213', 'test address 2', 1, '[\"Vendor_2-1646201841-Australia Invoice blank.png\"]', 'Splakatutay', NULL, '2022-03-01 22:17:21', '2022-03-01 22:17:21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_matrix`
--
ALTER TABLE `account_matrix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_departments`
--
ALTER TABLE `branch_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_groups`
--
ALTER TABLE `branch_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pcfr`
--
ALTER TABLE `pcfr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pcv`
--
ALTER TABLE `pcv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `temporary_slips`
--
ALTER TABLE `temporary_slips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_branch`
--
ALTER TABLE `temp_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_pos_transactions`
--
ALTER TABLE `temp_pos_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_truckers`
--
ALTER TABLE `temp_truckers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_matrix`
--
ALTER TABLE `account_matrix`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `account_transactions`
--
ALTER TABLE `account_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branch_departments`
--
ALTER TABLE `branch_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `branch_groups`
--
ALTER TABLE `branch_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pcfr`
--
ALTER TABLE `pcfr`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pcv`
--
ALTER TABLE `pcv`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `temporary_slips`
--
ALTER TABLE `temporary_slips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `temp_branch`
--
ALTER TABLE `temp_branch`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `temp_pos_transactions`
--
ALTER TABLE `temp_pos_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_truckers`
--
ALTER TABLE `temp_truckers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
