-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 03:01 AM
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
-- Database: `cashier`
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('cashier-cache-maker@gmail.com|127.0.0.1', 'i:1;', 1778488875),
('cashier-cache-maker@gmail.com|127.0.0.1:timer', 'i:1778488875;', 1778488875);

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
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fund_code` varchar(20) NOT NULL,
  `fund_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2026_04_30_000000_create_funds_table', 1),
(5, '2026_04_30_000001_create_transaction_types_table', 1),
(6, '2026_04_30_000002_create_transactions_table', 1),
(7, '2026_05_04_000001_create_payments_table', 1),
(8, '2026_05_11_002937_rename_position_to_role_in_users_table', 1),
(9, '2026_05_11_010000_create_roles_table', 2);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `fund_type` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `op_number` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `status` varchar(255) NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `transaction_type`, `fund_type`, `amount`, `name`, `contact`, `address`, `email`, `op_number`, `payment_mode`, `meta`, `status`, `created_at`, `updated_at`) VALUES
(15, 'appeal_fee', 'F01', 1000.00, 'Justine Velasquez', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0001', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:15:34', '2026-05-11 16:35:51'),
(16, 'bidding_documents', 'F01', 1200.00, 'Justine Velasquez', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0002', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:16:03', '2026-05-11 16:35:48'),
(17, 'cash_bond', 'F01', 1400.00, 'James Balane', '09163742303', 'Baao, Camarines Sur', 'admin@example.com', 'F01-2026-05-0003', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:16:46', '2026-05-11 16:35:40'),
(18, 'certification_copy_fee', 'F01', 15.00, 'Justine Velasquez', '09163742303', 'Nabua, Camarines Sur', 'admin@example.com', 'F01-2026-05-0004', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_type\":[],\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:17:22', '2026-05-11 16:35:36'),
(19, 'consignment', 'F01', 5000.00, 'Justine Velasquez', '09163742303', 'Dasmarinas, Cavite', 'admin@example.com', 'F01-2026-05-0005', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:17:57', '2026-05-11 16:35:33'),
(20, 'unwithheld_remittances', 'F01', 16600.00, 'Justine Velasquez', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0006', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":\"1231\",\"exec_txn_type_paid\":\"Transaction Type?\",\"exec_remarks\":\"(Remark Sample)\",\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null,\"remit_type\":[]}', 'under_review', '2026-05-04 13:18:26', '2026-05-11 16:31:16'),
(21, 'filing_fee', 'F01', 15.00, 'James Balane', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0007', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:18:54', '2026-05-11 16:35:01'),
(22, 'income_unserviceable', 'F01', 1500.00, 'Justine Velasquez', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0008', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:19:20', '2026-05-11 16:35:30'),
(23, 'legal_research', 'F01', 12000.00, 'Justine Velasquez', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0009', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:19:38', '2026-05-11 16:35:28'),
(24, 'performance_bond', 'F01', 15000.00, 'James Balane', '09163742303', 'Baao, Camarines Sur', 'admin@example.com', 'F01-2026-05-0010', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:20:24', '2026-05-11 16:35:25'),
(25, 'refund_cash_advances', 'F01', 15000.00, 'Justine Velasquez', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0011', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:20:52', '2026-05-11 16:35:22'),
(26, 'refund_overpayment', 'F01', 15000.00, 'Justine Velasquez', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0012', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:21:09', '2026-05-11 16:35:19'),
(27, 'settlement_disallowances', 'F01', 73287000.00, 'Sarah Geronimo', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0013', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'under_review', '2026-05-04 13:22:13', '2026-05-11 16:35:17'),
(28, 'unwithheld_remittances', 'F01', 305020.00, 'Justine Velasquez', '09163742303', 'Molino, Cavite', 'admin@example.com', 'F01-2026-05-0014', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_type\":[],\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'approved', '2026-05-04 13:22:33', '2026-05-11 16:53:24'),
(29, 'performance_bond', 'F01', 9199.00, 'Rudy Boringot', '09162344569', '061 Soriano Street, San Nicolas, Baao, Camarines Sur', 'offjustine.velasquez@gmail.com', 'F01-2026-05-0015', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'approved', '2026-05-10 14:19:08', '2026-05-11 16:56:20'),
(30, 'settlement_disallowances', 'F02-GOP', 1230.00, 'Jerald Ricabuerta', '09163742123', 'Perriwinkle Street, Grand Royale', 'ijuarmana21@gmail.com', 'F02-GOP-2026-05-0001', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null,\"accountant_remarks\":\"Wrong Credentials\"}', 'approved', '2026-05-11 16:20:14', '2026-05-11 16:53:23'),
(31, 'settlement_disallowances', 'F02-GOP', 1230.00, 'Jerald Ricabuerta', '09163742123', 'Perriwinkle Street, Grand Royale', 'ijuarmana21@gmail.com', 'F02-GOP-2026-05-0002', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'approved', '2026-05-11 16:22:32', '2026-05-11 16:53:20'),
(32, 'refund_cash_advances', 'F02-LP', 1500.00, 'Anne Psylocked', '09163742303', 'Perriwinkle Street, Grand Royale', 'ijuarmana21@gmail.com', 'F02-LP-2026-05-0001', 'cash', '{\"op_number\":null,\"appeal_remarks\":null,\"bid_details\":null,\"bid_remarks\":null,\"area_hectares\":null,\"zonal_value\":null,\"property_location\":null,\"assessment_form\":null,\"cash_bond_remarks\":null,\"letter_request\":null,\"cert_remarks\":null,\"consignment_assessment_form\":null,\"consignment_case_no\":null,\"consignment_remarks\":null,\"exec_assessment_form\":null,\"exec_txn_type_paid\":null,\"exec_remarks\":null,\"filing_assessment_form\":null,\"filing_remarks\":null,\"rdc_resolution_no\":null,\"unserviceable_remarks\":null,\"legal_research_remarks\":null,\"pb_area_hectares\":null,\"pb_zonal_value\":null,\"pb_property_location\":null,\"pb_assessment_form\":null,\"pb_remarks\":null,\"check_lddap_ada\":null,\"cash_advance_date\":null,\"division_section\":null,\"cash_advance_remarks\":null,\"refund_division_section\":null,\"refund_op_remarks\":null,\"disallowance_no\":null,\"disallowance_remarks\":null,\"remit_other_specify\":null,\"remit_remarks\":null,\"reviewer_remarks\":null}', 'approved', '2026-05-11 16:25:19', '2026-05-11 16:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'reviewer', 'Reviewer', '2026-05-10 22:16:36', '2026-05-10 22:16:36'),
(2, 'admin', 'Admin', '2026-05-10 22:16:36', '2026-05-10 22:16:36'),
(3, 'accountant', 'Accountant', '2026-05-10 22:16:36', '2026-05-10 22:16:36'),
(4, 'maker', 'Maker', '2026-05-10 22:16:36', '2026-05-10 22:16:36');

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
('RM7enGdnmSqFkb0ZOV4LlfUq0cxTQE58TcuTZbrd', 17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHZreVh6bksyQUpMdnFjOXlXOHFhS2JXeXU2UzEwTG1pOWR6VVE1dSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wYXltZW50cy5qc29uIjtzOjU6InJvdXRlIjtzOjEzOiJwYXltZW50cy5qc29uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTc7fQ==', 1778547630),
('ZSm4HiKbUUFXfFGOizx5Yg3XaAhGHZks4VM0QeCY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.119.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0dBR3dpRWVyV0dSeVhXUzFrY0Vrd3Foa05yTFV0eTBuUHJyck9qdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778545118);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fund_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `op_number` varchar(100) NOT NULL,
  `payment_mode` varchar(50) NOT NULL DEFAULT 'Cash',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

CREATE TABLE `transaction_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_code` varchar(50) NOT NULL,
  `type_name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','banned') NOT NULL DEFAULT 'active',
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `phone_number`, `address`, `position`, `status`, `profile_picture`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Admin', NULL, 'User', 'admin', 'admin@example.com', '2026-05-10 23:26:49', '$2y$12$h4xPOViR3KtPmjWsR5AVmOVGncS3tdSxfkFzcbwELu.ShPFy6fZaS', 'zit1d9ZNPs', NULL, NULL, 'admin', 'active', NULL, '2026-05-10 23:26:49', '2026-05-10 23:26:49', 2),
(15, 'Accountant', NULL, 'User', 'accountant', 'accountant@example.com', '2026-05-10 23:26:49', '$2y$12$7iP4z3ySrOEdlmplcnE8Jut6m0wM9/YOwCV2205M.R2AKt/sej2PK', 'fSF3lNZ1mO1VgaEDoXwl3cGNJn9dXvbT26rEzfCaUlZxwH6Pi4BgbJf3lJLT', NULL, NULL, 'accountant', 'active', NULL, '2026-05-10 23:26:50', '2026-05-10 23:26:50', 3),
(16, 'Reviewer', NULL, 'User', 'reviewer', 'reviewer@example.com', '2026-05-10 23:26:50', '$2y$12$23f.0O108RhtPGABAPzhme98iGZLY9Hv.5lxY4uhs3FVSPKP11FKO', 'O4wcTpPY8ZERqbhjjaQy3chynpZVoFZp73Hv9RV6F85KUfm1IzVAes0oVfoc', NULL, NULL, 'reviewer', 'active', NULL, '2026-05-10 23:26:50', '2026-05-10 23:26:50', 1),
(17, 'Maker', NULL, 'User', 'maker', 'maker@example.com', '2026-05-10 23:26:50', '$2y$12$WgTSR2m1tJIBV3cAaoYqGeJLyvhZkWyePav7jDr/VNZHdOEA16lgS', 'N5HiMykffm1D6HLMllPTaOyVaMg8sFvWlDIHfx52nmc1qW93Cmob58eKga5S', NULL, NULL, 'maker', 'active', NULL, '2026-05-10 23:26:50', '2026-05-10 23:26:50', 4);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `funds_fund_code_unique` (`fund_code`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_fund_id_foreign` (`fund_id`),
  ADD KEY `transactions_transaction_type_id_foreign` (`transaction_type_id`);

--
-- Indexes for table `transaction_types`
--
ALTER TABLE `transaction_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_types_type_code_unique` (`type_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
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
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_types`
--
ALTER TABLE `transaction_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_fund_id_foreign` FOREIGN KEY (`fund_id`) REFERENCES `funds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_transaction_type_id_foreign` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
