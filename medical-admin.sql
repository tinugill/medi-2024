-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2023 at 08:10 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medical-admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `accredition_certificates`
--

CREATE TABLE `accredition_certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `doc_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accredition_certificates`
--

INSERT INTO `accredition_certificates` (`id`, `parent_id`, `doc_name`, `proof`, `is_deleted`, `created_at`, `updated_at`) VALUES
(4, 5, 'ISO', 'd-442461668266160.jpeg', '0', '2022-11-12 09:46:00', '2022-11-12 09:46:00'),
(5, 5, 'QCI', 'd-677031668266160.jpeg', '0', '2022-11-12 09:46:00', '2022-11-12 09:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `ambulances`
--

CREATE TABLE `ambulances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_certificate` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhar_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstin_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_on_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `micr_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_cheque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ambulances`
--

INSERT INTO `ambulances` (`id`, `name`, `owner_name`, `image`, `public_number`, `banner`, `about`, `registration_certificate`, `aadhar_proof`, `gstin_proof`, `gstin`, `aadhar`, `latitude`, `longitude`, `address`, `city`, `pincode`, `country`, `slug`, `name_on_bank`, `bank_name`, `branch_name`, `ifsc`, `ac_no`, `ac_type`, `micr_code`, `pan_no`, `cancel_cheque`, `pan_image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Ambulance', 'owner', 'd-116341671383316.png', '1234567890', '', 'about', '', '', '', 'gstin', 'aadhar', '28.4894154', '77.01186960000001', 'F2Q6 MQJ, Old Railway Rd, Kheri, Ashok Vihar, Sector 3, Gurugram, Haryana 122006, India', 'Gurgaon', '122006', 'India', 'ambulance', '', '', '', '', '', '', '', '', '', '', '0', '2022-10-18 02:42:53', '2022-12-18 11:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `ambulance_bookings`
--

CREATE TABLE `ambulance_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambulance_id` int(11) NOT NULL,
  `service_ambulance_id` int(11) NOT NULL,
  `booking_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 pending 1 accepted 2 out for service 3 reached 4 completed 5 canceled',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ambulance_bookings`
--

INSERT INTO `ambulance_bookings` (`id`, `user_id`, `name`, `mobile`, `ambulance_id`, `service_ambulance_id`, `booking_type`, `date`, `booking_for`, `address`, `payment_id`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 11, 'Deepak', '8787858432', 1, 1, 'day', '2022-12-18', '2', '', '', '0', '0', '2022-12-18 12:48:16', '2022-12-18 12:48:16'),
(2, 11, 'deepak', '8447469656', 1, 1, 'day', '2022-12-20', '3', '', '36', '1', '0', '2022-12-18 12:53:40', '2022-12-18 13:38:35');

-- --------------------------------------------------------

--
-- Table structure for table `ambulance_driver_lists`
--

CREATE TABLE `ambulance_driver_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amb_id` int(11) NOT NULL,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `liscence_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `liscence_photo` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ambulance_driver_lists`
--

INSERT INTO `ambulance_driver_lists` (`id`, `amb_id`, `driver_name`, `image`, `liscence_no`, `liscence_photo`, `address`, `mobile`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 1, 'driver', 'd-490061666087616.jpeg', 'licn', 'd-744361666087616.jpeg', '', '94949494', '2022-10-18 04:36:56', '2022-10-18 04:36:56', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ambulance_lists`
--

CREATE TABLE `ambulance_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amb_id` int(11) NOT NULL,
  `regis_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regis_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambulance_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charges_per_day` int(11) NOT NULL,
  `discount_per_day` int(11) NOT NULL,
  `charges_per_km` int(11) NOT NULL,
  `discount_per_km` int(11) NOT NULL,
  `img_1` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_2` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_3` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_4` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_5` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_6` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ambulance_lists`
--

INSERT INTO `ambulance_lists` (`id`, `amb_id`, `regis_no`, `regis_proof`, `ambulance_type`, `charges_per_day`, `discount_per_day`, `charges_per_km`, `discount_per_km`, `img_1`, `img_2`, `img_3`, `img_4`, `img_5`, `img_6`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Regis no', 'd-995191666086129.png', 'Air ambulance', 100, 10, 50, 10, 'd-62011666086129.jpeg', '', '', '', '', '', '0', '2022-10-18 04:12:09', '2022-12-18 10:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `member_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `time_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locality` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `payment_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_accepted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not not 1 for yes',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `customer_id`, `member_id`, `type`, `date`, `time_slot`, `address`, `locality`, `pincode`, `city`, `hospital_id`, `doctor_id`, `payment_id`, `is_accepted`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Online', '2022-11-08', '08:03 PM', '', '', '', '', 3, 1, '32', '1', '0', '2022-11-08 08:16:08', '2022-11-08 08:16:44');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `type`, `uid`, `title`, `image`, `date`, `desc`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Hospital', 6, 'Blog Title -  new', 'd-670101657439520.png', '2022-07-23', '<p>This is blog info</p><p>updted</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', 'blog-title', '0', '2022-07-10 02:22:00', '2022-07-10 02:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `blog_id`, `name`, `email`, `comment`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 0, 'deepak', 'aon@gmail.com', 'comment', '0', '2022-07-10 07:16:25', '2022-07-10 07:16:25'),
(2, 1, 'name', 'aon@gmail.com', 'deepak', '0', '2022-07-10 07:21:36', '2022-07-10 07:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `bloodbanks`
--

CREATE TABLE `bloodbanks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `about` varchar(6000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `liscence_no` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `liscence_file` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bloodbanks`
--

INSERT INTO `bloodbanks` (`id`, `name`, `owner_name`, `public_number`, `hospital_id`, `about`, `email`, `mobile`, `address`, `city`, `pincode`, `country`, `latitude`, `longitude`, `password`, `image`, `banner_image`, `cp_name`, `liscence_no`, `liscence_file`, `days`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Bloodbank', 'Owner name', '123456', NULL, '', 'bloodbank@gmail.com', '6564646464', 'J482, Block RZ, Sagar Pur, New Delhi, Delhi 110046, India', 'South West Delhi', '110046', 'India', '28.607643947779643', '77.0969700088623', '$2y$10$XPFdKnhmKalcX4Uj.vfgoerYxOfLl15xYzEtaW8c5CFbKnVPGKmuC', 'd-581371677766285.png', '', '', 'baisbix', 'd-546221677766285.jpeg', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\"]', 'bb', '0', '2022-07-06 13:47:00', '2023-03-02 08:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `bloodbankstocks`
--

CREATE TABLE `bloodbankstocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bloodbank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `component_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avialablity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bloodbankstocks`
--

INSERT INTO `bloodbankstocks` (`id`, `bloodbank_id`, `component_name`, `avialablity`, `available_unit`, `is_deleted`, `created_at`, `updated_at`) VALUES
(4, 1, 'B+', 'No', '0', '0', '2022-07-10 01:28:36', '2022-09-22 13:22:08'),
(6, 1, 'O+', 'Yes', '111', '0', '2022-07-10 01:30:38', '2022-09-22 13:22:19'),
(7, 1, 'O+', 'Yes', '100', '0', '2023-03-02 08:41:53', '2023-03-02 08:41:53');

-- --------------------------------------------------------

--
-- Table structure for table `bloodbank_components`
--

CREATE TABLE `bloodbank_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bloodbank_components`
--

INSERT INTO `bloodbank_components` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'O+', NULL, NULL),
(2, 'B+', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blood_doners`
--

CREATE TABLE `blood_doners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bloodbank_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blood_group` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available_in_emergency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_donated` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blood_doners`
--

INSERT INTO `blood_doners` (`id`, `bloodbank_id`, `user_id`, `name`, `blood_group`, `email`, `mobile`, `date`, `available_in_emergency`, `is_donated`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '1', 0, 'Deepak Chahar', '', 'aon@gmail.com', '323232323', '2022-07-29', 'Yes', '1', '0', '2022-07-24 13:34:30', '2022-07-24 14:26:48'),
(2, '1', 0, 'Deepak Chahar', 'O', 'imdc@gmail.com', '775757577', '2022-09-23', 'Yes', '0', '0', '2022-09-22 13:35:26', '2022-09-22 13:35:26'),
(3, '1', 0, 'Deepak Chahar', 'B%2B', 'aon@gmail.com', '3232312312', '2022-09-24', 'Yes', '0', '0', '2022-09-22 13:41:20', '2022-09-22 13:41:20'),
(4, '1', 0, 'Deepak Chahar', 'B+', 'aon@gmail.com', '4343434343', '2022-09-24', 'Yes', '0', '0', '2022-09-22 13:44:00', '2022-09-22 13:44:00'),
(5, '1', 1, 'deepak', 'O+', 'imchahardeepak@gmail.com', '8447469656', '2022-12-18', 'Yes', '0', '0', '2022-12-18 06:31:55', '2022-12-18 06:31:55'),
(6, '1', 1, 'Deepak', 'O+', 'imchahardeepak@gmail.com', '8787878787', '2023-03-17', 'Yes', '0', '0', '2023-03-02 08:43:51', '2023-03-02 08:43:51');

-- --------------------------------------------------------

--
-- Table structure for table `buy_carts`
--

CREATE TABLE `buy_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `req_date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_completed` enum('0','1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not 1 completed',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buy_carts`
--

INSERT INTO `buy_carts` (`id`, `user_id`, `order_id`, `item_id`, `item_type`, `price`, `discount`, `qty`, `payment_id`, `req_date`, `record_image`, `is_completed`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 4, 'order_KM5nJ4UsLF9ZyG', 4, 'product', '1000', '100', '1', '26', '', '', '2', '0', '2022-09-25 04:30:23', '2022-09-25 04:33:01'),
(2, 4, 'order_KM5nJ4UsLF9ZyG', 1, 'product', '100', '9', '2', '26', '', '', '0', '0', '2022-09-25 04:30:24', '2022-09-25 04:31:13'),
(3, 1, 'order_Kda5Y7wHgVCk8R', 1, 'product', '100', '9', '2', '33', '', '', '0', '0', '2022-11-08 09:11:27', '2022-11-08 09:12:02'),
(4, 1, '', 1, 'product', '200', '10', '1', '', '', '', '0', '0', '2023-02-19 03:38:57', '2023-02-19 03:38:57'),
(5, 1, 'order_LIFXePnUSdr4O8', 1, 'product', '200', '20', '1', '47', '', '', '0', '0', '2023-02-19 03:44:39', '2023-02-19 03:45:31'),
(6, 4, '', 2, 'treatment', '122', '2', '1', '', '', '', '0', '0', '2023-02-27 12:10:21', '2023-02-27 12:10:21'),
(7, 4, '', 3, 'treatment', '1000', '10', '1', '', '', '', '0', '0', '2023-02-27 12:10:21', '2023-02-27 12:10:21'),
(8, 4, '', 2, 'treatment', '122', '2', '1', '', '', '', '0', '0', '2023-02-27 12:36:16', '2023-02-27 12:36:16'),
(9, 4, '', 3, 'treatment', '1000', '10', '1', '', '', '', '0', '0', '2023-02-27 12:36:16', '2023-02-27 12:36:16'),
(10, 4, 'order_LLYtGDnmhiG31h', 2, 'treatment', '122', '2', '1', '50', '', '', '0', '0', '2023-02-27 12:37:11', '2023-02-27 12:37:57'),
(11, 4, 'order_LLYtGDnmhiG31h', 3, 'treatment', '1000', '10', '1', '50', '', '', '0', '0', '2023-02-27 12:37:11', '2023-02-27 12:37:57'),
(12, 1, 'order_LLZ8gQ6O8VkRo1', 2, 'treatment', '122', '2', '1', '51', '2023-02-28', '', '0', '0', '2023-02-27 12:51:48', '2023-02-27 12:54:47'),
(13, 1, 'order_LLZ8gQ6O8VkRo1', 3, 'treatment', '1000', '10', '1', '51', '2023-02-28', '', '0', '0', '2023-02-27 12:51:48', '2023-02-27 12:54:47'),
(14, 1, 'order_LMhDKt9QicQStZ', 2, 'treatment', '122', '2', '1', '52', '2023-03-10', '', '0', '0', '2023-03-02 09:24:45', '2023-03-02 09:27:13'),
(15, 2, 'order_LRsk21gQGMaZNE', 2, 'treatment', '122', '2', '1', '53', '2023-03-15', '[\"d-503681678901220.jpeg\"]', '0', '0', '2023-03-15 11:56:19', '2023-03-15 11:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `buy_cart_order_infos`
--

CREATE TABLE `buy_cart_order_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_boy` int(11) NOT NULL,
  `buy_cart_items` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prescription` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_completed` enum('0','1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not 1 completed',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buy_cart_order_infos`
--

INSERT INTO `buy_cart_order_infos` (`id`, `user_id`, `order_id`, `delivery_boy`, `buy_cart_items`, `total_amount`, `total_discount`, `address`, `pincode`, `city`, `locality`, `prescription`, `payment_id`, `is_completed`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'order_KM5nJ4UsLF9ZyG', 3, '1,2', '1200', '118', 'address', 'pincode', 'city', 'Locality', 'p-768471664100073.jpeg', '26', '1', '0', '2022-09-25 04:31:13', '2022-12-03 05:07:16'),
(2, 1, 'order_Kda5Y7wHgVCk8R', 3, '3', '200', '182', 'address', '122001', 'city', 'locality', 'p-335801667918522.jpeg', '33', '0', '0', '2022-11-08 09:12:02', '2022-12-03 05:07:22'),
(3, 1, 'order_LIFXePnUSdr4O8', 0, '5', '200', '20', 'address', '122001', 'city', 'locality', 'p-739111676798132.jpeg', '47', '0', '0', '2023-02-19 03:45:32', '2023-02-19 03:45:32'),
(4, 1, 'order_LLYtGDnmhiG31h', 0, '10,11', '1122', '12', '', '', '', '', '', '50', '0', '0', '2023-02-27 12:37:57', '2023-02-27 12:37:57'),
(5, 1, 'order_LLZ8gQ6O8VkRo1', 0, '12,13', '1122', '12', '', '', '', '', '', '51', '0', '0', '2023-02-27 12:54:47', '2023-02-27 12:54:47'),
(6, 1, 'order_LMhDKt9QicQStZ', 0, '14', '122', '2', '', '', '', '', '', '52', '0', '0', '2023-03-02 09:27:13', '2023-03-02 09:27:13'),
(7, 1, 'order_LRsk21gQGMaZNE', 0, '15', '122', '2', '', '', '', '', '', '53', '0', '0', '2023-03-15 11:57:00', '2023-03-15 11:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `image`, `description`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Health', '1653053077.webp', 'Description', 'health', '1', '2022-04-16 04:14:40', '2022-06-23 12:05:01'),
(2, 'Baby', '1653053772.webp', 'test desc', 'baby', '0', '2022-05-20 08:06:12', '2022-05-20 08:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `category_eqps`
--

CREATE TABLE `category_eqps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_eqps`
--

INSERT INTO `category_eqps` (`id`, `title`, `image`, `description`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Equipment', '1676736776.jpeg', 'des', 'eqp-1', '0', '2023-02-18 10:42:56', '2023-02-18 10:43:15');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `appointment_id`, `sender_id`, `sender_type`, `message`, `msg_type`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Doctor', '6', 'zoom', '0', '2022-11-08 08:27:27', '2022-11-08 08:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `chat_reports`
--

CREATE TABLE `chat_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `apn_id` int(11) NOT NULL,
  `reported_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `mobile`, `dob`, `gender`, `address`, `city`, `pincode`, `country`, `latitude`, `longitude`, `image`, `password`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Deepak Chahar', 'user@gmail.com', '8447469656', '0000-00-00', '', '', '', '', '', '', '', '', '$2y$10$gNC9WZjlSp4uTezZRMNFK./Ul5mVXw.esz3Zz1ElRGp4DFSPekV9C', '0', '2022-07-06 12:53:44', '2022-07-06 12:53:44'),
(2, 'User 2', 'user2@gmail.com', '7878787878', '0000-00-00', '', '', '', '', '', '', '', '', '$2y$10$zMW5VqPggMHZ.6PpbjajSONtc21pYLkzCli66ZwftKGrcFxobNqCm', '0', '2022-11-06 13:09:15', '2022-11-06 13:09:15'),
(3, 'user', 'user22@gmail.com', '8767876787', '0000-00-00', '', '', '', '', '', '', '', '', '$2y$10$Xi6b3Bd0/9mMI1sAQogdUOvYPdvdpl53yldJElDy3NAMV.b6KHAXW', '0', '2022-11-27 02:34:31', '2022-11-27 02:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `dealers`
--

CREATE TABLE `dealers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_certificate` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tin_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstin_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstin` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tin` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_on_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `micr_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_cheque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealers`
--

INSERT INTO `dealers` (`id`, `name`, `owner_name`, `owner_id`, `partner_name`, `partner_id`, `image`, `banner`, `about`, `registration_certificate`, `tin_proof`, `gstin_proof`, `gstin`, `tin`, `latitude`, `longitude`, `address`, `city`, `pincode`, `country`, `slug`, `name_on_bank`, `bank_name`, `branch_name`, `ifsc`, `ac_no`, `ac_type`, `micr_code`, `pan_no`, `cancel_cheque`, `pan_image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Dealer', 'owner name', 'd-546871669658469.jpeg', 'partner name', 'd-543651669658469.jpeg', 'd-959171661879076.jpeg', 'd-442631661879076.jpeg', 'about', 'd-140391661879076.png', 'd-750211661879076.png', 'd-999671661879076.png', 'gstinh', 'tin', '13.0826802', '80.2707184', '7, 2nd St, Chinnaiyan Colony, State Bank Colony, Perambur, Chennai, Tamil Nadu 600012, India', 'Chennai', '600012', 'India', '', 'bank', 'name', 'brnch', 'ifsc', 'acn', 'saving', 'micr', 'pan', 'd-550571661879139.png', 'd-333541661879139.png', '0', '2022-08-29 13:41:28', '2022-11-28 12:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `dealer_products`
--

CREATE TABLE `dealer_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dealer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mrp` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `delivery_charges` int(11) NOT NULL,
  `is_rent` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not 1 yes',
  `rent_per_day` int(11) NOT NULL,
  `security_for_rent` int(11) NOT NULL,
  `delivery_charges_for_rent` int(11) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 inactive 1 active',
  `manufacturer_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_prescription_required` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pack_size` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealer_products`
--

INSERT INTO `dealer_products` (`id`, `dealer_id`, `item_name`, `company`, `image`, `description`, `mrp`, `discount`, `delivery_charges`, `is_rent`, `rent_per_day`, `security_for_rent`, `delivery_charges_for_rent`, `status`, `manufacturer_address`, `category_id`, `is_prescription_required`, `pack_size`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '4', 'item name', 'company', 'd-626751661883025.png', '<p><strong>Details :</strong></p><p>detail</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', 100, 10, 100, '1', 100, 100, 100, '0', 'b mv', 1, '0', '100 pack', '0', '2022-08-30 12:40:25', '2023-02-19 02:21:37'),
(2, '4', 'Items', 'Company', 'd-998431676737744.jpeg', '<p><strong>Details :</strong></p><p>Details</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', 1000, 20, 100, '1', 200, 10, 100, '1', 'Address', 1, '0', '10pack', '0', '2023-02-18 10:59:04', '2023-02-19 02:21:52'),
(3, '10', 'Item 4', 'company', '', '<p><strong>Details :</strong></p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', 1000, 20, 10, '0', 0, 0, 0, '1', 'address', 1, '0', 'seze 100', '0', '2023-02-19 02:25:51', '2023-02-19 02:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `dealer_product_purchases`
--

CREATE TABLE `dealer_product_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 pending 1 accepted 2 out for delivery 3 delivered 4 picked 5 returned to seller 6 canceled',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealer_product_purchases`
--

INSERT INTO `dealer_product_purchases` (`id`, `user_id`, `type`, `qty`, `product_id`, `price`, `address`, `city`, `pincode`, `payment_id`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'purchase', 0, 1, '396', 'address', 'city', 'pincode', '19', '1', '0', '2022-08-31 04:00:14', '2022-08-31 04:40:58'),
(2, 1, 'rent', 0, 1, '600', 'address', 'city', '123455', '20', '0', '0', '2022-08-31 04:02:16', '2022-08-31 04:03:00'),
(3, 1, 'rent', 0, 1, '300', 'address', 'city', 'pincode', '21', '0', '0', '2022-08-31 04:05:40', '2022-08-31 04:06:17'),
(4, 1, 'rent', 2, 1, '500', 'address', 'city', '122001', '', '0', '0', '2022-12-18 13:58:30', '2022-12-18 13:58:30'),
(5, 1, 'purchase', 1, 1, '190', 'address', 'city', '122001', '', '0', '0', '2022-12-18 13:58:49', '2022-12-18 13:58:49'),
(6, 1, 'purchase', 3, 1, '370', 'address', 'city', '122001', '', '0', '0', '2022-12-18 13:58:58', '2022-12-18 13:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boys`
--

CREATE TABLE `delivery_boys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_boys`
--

INSERT INTO `delivery_boys` (`id`, `name`, `type`, `mobile`, `parent_id`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'NAME', 'Sample Collector', '943049394394', '5', '0', '2022-11-28 12:12:52', '2022-11-28 12:12:52'),
(2, 'NAME 1', 'Delivery Boy', '13131', '5', '0', '2022-11-28 12:13:07', '2022-11-28 12:13:19'),
(3, 'DD', 'Delivery Boy', '434344343443', '4', '0', '2022-12-03 04:54:58', '2022-12-03 04:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `designation_lists`
--

CREATE TABLE `designation_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not 1 yes',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designation_lists`
--

INSERT INTO `designation_lists` (`id`, `title`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Designation 1', '1', '0', NULL, '2022-09-09 03:12:46'),
(2, 'Desi2', '1', '0', NULL, NULL),
(3, 'Desi3', '1', '0', NULL, NULL),
(4, 'Desi4', '1', '0', NULL, NULL),
(5, 'Desi new', '0', '1', '2022-09-09 03:19:09', '2022-09-09 03:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `dignosis_lists`
--

CREATE TABLE `dignosis_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not 1 yes',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dignosis_lists`
--

INSERT INTO `dignosis_lists` (`id`, `title`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Dig', '1', '0', '2022-10-02 07:35:05', '2022-10-02 07:35:05'),
(2, 'd2', '1', '0', '2022-10-02 07:35:18', '2022-10-02 07:35:18'),
(3, 'ddddd', '1', '0', '2022-10-02 07:35:29', '2022-10-02 07:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Doctor','Nurse','Staff') COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `specialization_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialities_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symptom_i_see` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deasies_i_treat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `treatment_and_surgery` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `working_days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_timing` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_visit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consultancy_fee` int(11) NOT NULL,
  `home_consultancy_fee` int(11) NOT NULL,
  `online_consultancy_fee` int(11) NOT NULL,
  `about` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `award` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `memberships_detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medical_counsiling` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_certificate` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `letterhead` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signature` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode_2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude_2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude_2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 Not Delete 1 Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `full_name`, `email`, `mobile`, `password`, `type`, `gender`, `user_id`, `specialization_id`, `specialities_id`, `symptom_i_see`, `deasies_i_treat`, `treatment_and_surgery`, `degree_file`, `working_days`, `doctor_image`, `doctor_banner`, `appointment_timing`, `home_visit`, `consultancy_fee`, `home_consultancy_fee`, `online_consultancy_fee`, `about`, `award`, `experience`, `memberships_detail`, `registration_details`, `medical_counsiling`, `registration_certificate`, `letterhead`, `signature`, `designation`, `latitude`, `longitude`, `hospital_id`, `address`, `city`, `pincode`, `slug`, `country`, `address_2`, `city_2`, `pincode_2`, `country_2`, `latitude_2`, `longitude_2`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Dr Deepak', 'doctor@gmail.com', '8786858483', '$2y$10$erb8fEKok79ST3lkzSn7RumTzzqaPcdR9TG3gt6QGTTC/KaRVz5sq', 'Doctor', 'Male', NULL, '[1,2,6]', '[3,5,1,2]', '[1,2,5,6,8]', '[2,5,6,1]', '[1,5,6,2]', '', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', 'd-634281677768167.png', 'd-449841677768167.jpeg', '', 'Yes', 100, 200, 20, 'aboutffffb', '<p>Gold medalist</p>', '1', 'Membership detailsbjhv hjxeddff', 'rnnnnnnn', 'Delhi', 'd-808041677768167.png', 'd-291451677768167.png', 'd-561361677768167.jpeg', 'Desi4', '28.497384064062526', '76.99006537619627', '3', '185, Daulatabad, Gurugram, Haryana 122006, India', 'Gurugram', '122006', 'dr-deepak', 'India', 'F25G QMR, Gurugram, Haryana, India', 'Gurugram', '', 'India', '28.4594965', '77.0266383', '0', '2022-07-06 13:33:43', '2023-03-02 09:19:49'),
(4, 'Dr ajay', 'ajay@gmail.com', '8765654343', '$2y$10$GIl6NZga1GHkp6d3hjWwteBKPrkrPPDsdGSpj2MB5OXsKWX1Jh4ri', 'Doctor', 'Male', NULL, '[1,2]', '[1,2]', '[1,2]', '[1,2]', '[1,2]', '', '[\"Monday\",\"Wednesday\",\"Thursday\"]', '1650851433.png', '', '', 'Yes', 150, 250, 0, 'about', '<p>awards</p>', '4', '122', 'regis', '', 'd-146211657542124.png', '', '', 'des', '', '', '3', '886, Near sector 106, Gurugram', 'GURGAON', '122001', 'dr-ajay', 'India', 'undefined', 'undefined', 'undefined', 'undefined', '', '', '0', '2022-07-11 06:52:04', '2022-07-24 08:39:30'),
(5, 'Dr.', 'hospital@gmail.com', '9494949494', '$2y$10$jxi8CVBDCW1BvJbaFzdsXet9kZCfKhyEDr3ETZNpt9r2hRVPh/Fru', 'Doctor', 'Male', NULL, NULL, NULL, '', '', '', '', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', '', '', '', 'No', 100, 100, 100, 'about', '', '9', '', 'rerfdfer', '5', '', '', '', 'designation', '', '', '3', '', '', '', '', '', '', '', '', '', '', '', '0', '2022-12-19 20:34:09', '2022-12-19 20:34:09'),
(7, 'Dr.', 'hospital2@gmail.com', '9494949494', '$2y$10$.n/VJIAmGUoi8NcLsmQqEu1jl36WBdV/sVRyivP.dR7/pXBtZWnlG', 'Doctor', 'Male', NULL, '[1,2]', '[1]', '[1]', '[2]', '[4]', '', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', '', '', '', 'No', 100, 100, 100, 'about', '', '9', '', 'rerfdfer', '5', '', '', '', 'designation', '', '', '3', '', '', '', 'dr', '', '', '', '', '', '', '', '0', '2022-12-19 20:36:28', '2022-12-19 20:37:01');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_bank_docs`
--

CREATE TABLE `doctor_bank_docs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `micr_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_cheque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_bank_docs`
--

INSERT INTO `doctor_bank_docs` (`id`, `doctor_id`, `name`, `bank_name`, `branch_name`, `ifsc`, `ac_no`, `ac_type`, `micr_code`, `cancel_cheque`, `pan_no`, `pan_image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 4, 'Germany', 'sdvsd', 'mict2', 'dv', 'vds', 'current', 'vdsvd', '', 'cascascsacs', '', '0', '2022-07-11 06:52:04', '2022-07-24 08:33:28'),
(2, 1, 'Bank', 'Name', 'Brnach', '10101010', '123456789088', 'saving', '121211', 'd-487571677768623.jpeg', 'gdgdyewjsjg', 'd-504371677768623.jpeg', '0', '2022-07-15 07:10:40', '2023-03-02 09:20:23'),
(3, 5, '', '', '', '', '', '', '', '', '', '', '0', '2022-12-19 20:34:09', '2022-12-19 20:34:09'),
(4, 7, '', '', '', '', '', '', '', '', '', '', '0', '2022-12-19 20:36:28', '2022-12-19 20:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_comments`
--

CREATE TABLE `doctor_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `relevent_point_from_history` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provisional_diagnosis` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `investigation_suggested` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `treatment_suggested` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `special_instruction` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `followup_advice` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_comments`
--

INSERT INTO `doctor_comments` (`id`, `appointment_id`, `doctor_id`, `relevent_point_from_history`, `provisional_diagnosis`, `investigation_suggested`, `treatment_suggested`, `special_instruction`, `followup_advice`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '<p>rev</p>', '<p>prv</p>', 'inv', '<p>tret</p>', '<p>psec</p>', '', '0', '2022-10-02 13:09:25', '2022-10-02 13:09:25');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_edus`
--

CREATE TABLE `doctor_edus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `qualification_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `certificate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_edus`
--

INSERT INTO `doctor_edus` (`id`, `doctor_id`, `qualification_id`, `certificate`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, '1', 'd-275541658668646.png', '0', '2022-07-24 05:15:58', '2022-07-24 07:47:26'),
(2, 1, '2', 'd-300431677768188.png', '0', '2022-07-24 05:20:21', '2023-03-02 09:13:08'),
(3, 1, '3', 'd-573181677768191.jpeg', '1', '2022-07-24 05:20:25', '2023-03-02 09:13:11'),
(4, 1, '6', 'd-747191677768195.png', '0', '2023-03-02 09:13:15', '2023-03-02 09:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_medicine_advice`
--

CREATE TABLE `doctor_medicine_advice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `medi_id` int(11) NOT NULL,
  `formulation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `strength` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_of_administration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequncy` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `special_instruction` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_medicine_advice`
--

INSERT INTO `doctor_medicine_advice` (`id`, `appointment_id`, `doctor_id`, `medi_id`, `formulation`, `name`, `strength`, `route_of_administration`, `frequncy`, `duration`, `special_instruction`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 'SN', 'J', 'J', 'J', 'J', '', '', '0', '2022-10-02 12:55:29', '2022-10-02 12:55:29'),
(2, 1, 1, 4, 'qqq', 'jjjj', 'jjj', 'jjj', 'jjj', 'ddd', 'si', '0', '2022-10-02 13:01:54', '2022-10-02 13:01:54'),
(3, 1, 1, 4, 'f', 'dwdwd', 's', 'dwdw', 'ssdsd', 'dds', 'ss', '0', '2022-10-02 13:01:54', '2022-10-02 13:01:54'),
(4, 1, 1, 1, 'for', 'name', 'strength', 'route', 'fre', 'dur', 'spi', '0', '2022-10-02 13:09:25', '2022-10-02 13:09:25'),
(5, 1, 1, 1, 'form', 'name', 'str', 'rout', 'fe', 'dur', 'spi', '0', '2022-10-02 13:09:25', '2022-10-02 13:09:25');

-- --------------------------------------------------------

--
-- Table structure for table `empanelments`
--

CREATE TABLE `empanelments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empanelments`
--

INSERT INTO `empanelments` (`id`, `title`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Star health', '1', '0', NULL, '2022-09-25 14:19:16'),
(2, 'ICICI Lombard', '0', '0', NULL, NULL),
(3, 'emp', '0', '0', '2022-09-25 13:54:12', '2022-09-25 13:54:12'),
(4, 'emp', '0', '0', '2022-09-25 13:55:19', '2022-09-25 13:55:19'),
(5, 'emp', '0', '0', '2022-09-25 13:56:10', '2022-09-25 13:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `title`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'ICU', '1', '0', NULL, '2022-09-25 14:19:54'),
(2, 'Dialysis', '0', '0', NULL, NULL),
(3, 'Fac', '0', '0', '2022-09-25 13:54:12', '2022-09-25 13:54:12'),
(4, 'Fac', '0', '0', '2022-09-25 13:55:18', '2022-09-25 13:55:18'),
(5, 'Fac', '0', '0', '2022-09-25 13:56:10', '2022-09-25 13:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formulations`
--

CREATE TABLE `formulations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `formulations`
--

INSERT INTO `formulations` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Tablet', NULL, NULL),
(2, 'Capsule', NULL, NULL),
(3, 'Injection', NULL, NULL),
(4, 'Syrup', NULL, NULL),
(5, 'Ointment', NULL, NULL),
(6, 'Drops', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `home_care_requests`
--

CREATE TABLE `home_care_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_proof` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `care_id` int(11) NOT NULL,
  `procedure_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `book_for` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 pending 1 accepted 2 out for delivery 3 delivered 4 picked 5 returned to seller 6 canceled',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_care_requests`
--

INSERT INTO `home_care_requests` (`id`, `user_id`, `id_proof`, `qty`, `type`, `care_id`, `procedure_id`, `date`, `book_for`, `price`, `address`, `city`, `pincode`, `payment_id`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, '', 1, 'day', 1, 0, NULL, '0', '300', 'address', 'city', 'pincode', '22', '0', '0', '2022-08-31 13:00:58', '2022-08-31 13:42:35'),
(2, 1, '', 1, 'Procedure', 1, 2, '2022-09-03', 'procedure', '200', 'address', 'city', '123456', '', '0', '0', '2022-09-01 03:35:01', '2022-09-01 03:35:01'),
(3, 1, '', 1, 'Procedure', 1, 2, '2022-09-03', 'procedure', '200', 'address', 'city', '123456', '23', '0', '0', '2022-09-01 03:35:59', '2022-09-01 03:36:51'),
(4, 1, '', 1, 'Procedure', 1, 1, '2022-11-12', 'procedure', '1000', 'address', 'city', 'pincode', '', '0', '0', '2022-11-13 08:24:20', '2022-11-13 08:24:20'),
(5, 1, '', 1, 'Procedure', 1, 2, '2022-11-13', 'procedure', '200', 'address', 'city', '12345', '', '0', '0', '2022-11-13 08:27:36', '2022-11-13 08:27:36'),
(6, 1, 'd-605351671392391.png', 1, 'Procedure', 1, 3, '2022-12-02', 'procedure', '156', 'address', 'city', 'city', '', '0', '0', '2022-12-18 14:09:51', '2022-12-18 14:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beds_quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialities_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `procedures_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_details` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_file` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accredition_details` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accredition_certificate` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empanelments` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` varchar(7000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facilities_avialable` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Hospital','Clinic') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_on_bank` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `micr_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_cheque` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 Not Delete 1 Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `phone_no`, `address`, `city`, `pincode`, `country`, `beds_quantity`, `specialities_id`, `procedures_id`, `image`, `registration_details`, `registration_file`, `accredition_details`, `accredition_certificate`, `empanelments`, `about`, `facilities_avialable`, `latitude`, `longitude`, `type`, `name_on_bank`, `bank_name`, `branch_name`, `ifsc`, `ac_no`, `ac_type`, `micr_code`, `pan_no`, `cancel_cheque`, `pan_image`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'hospital', '8765434565', '4, East Ave, Railway Colony, East Punjabi Bagh, Punjabi Bagh, Delhi, 110026, India', 'West Delhi', '110026', 'India', '100', '[1,3]', '[1]', '1651497509.png', 'regis', '', 'ISO,QCI,NABH,Oth,aaa', '', '[1]', 'about', '[1]', '28.6729056', '77.1458761', 'Clinic', 'name', 'bank', 'branch', 'ifsc', 'ac', 'saving', '1000', 'pan', 'd-632751671957793.png', 'd-514171671957793.png', 'hospital', '0', '2022-07-06 13:40:11', '2023-02-19 05:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `hospital__staff`
--

CREATE TABLE `hospital__staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_super` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospital__staff`
--

INSERT INTO `hospital__staff` (`id`, `name`, `email`, `mobile`, `hospital_id`, `address`, `city`, `pincode`, `country`, `image`, `password`, `is_super`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 'Yogis kitchen', 'aonuu@gmail.com', '9392010990', '3', '886, Near sector 106, Gurugram', 'GURGAON', '122001', 'Redhunt Tech', 'd-118101651325899.png', '$2y$10$mflHSZPosGAmwriPGctaMuytF89/rd/wdfEDcQvcGQjWMKmXDbrQC', '1', '0', '2022-04-30 08:08:19', '2022-04-30 08:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `illness_lists`
--

CREATE TABLE `illness_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `illness_lists`
--

INSERT INTO `illness_lists` (`id`, `title`, `created_at`, `updated_at`, `is_approved`, `is_deleted`) VALUES
(1, 'Illness 1', NULL, NULL, '0', '0'),
(2, 'Illness 2', NULL, NULL, '0', '0'),
(3, 'i2', '2022-09-21 13:53:20', '2022-09-21 13:53:20', '0', '0'),
(4, 's4', '2022-09-21 13:53:20', '2022-09-21 13:53:20', '0', '0'),
(5, 'Illness new', '2022-09-21 13:58:43', '2022-09-22 11:45:57', '1', '0'),
(6, 's4', '2022-09-21 13:58:43', '2022-09-22 11:45:38', '0', '1'),
(7, 'NEW 2', '2022-09-22 11:46:13', '2022-09-22 11:46:13', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `laboratorists`
--

CREATE TABLE `laboratorists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` varchar(6000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_detail` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_file` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_on_bank` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `micr_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_cheque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accredition_details` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accredition_certificate` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `owner_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_c_fee` int(11) NOT NULL,
  `h_c_fee_apply_before` int(11) NOT NULL,
  `r_d_fee` int(11) NOT NULL,
  `r_d_fee_apply_before` int(11) NOT NULL,
  `ambulance_fee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratorists`
--

INSERT INTO `laboratorists` (`id`, `name`, `hospital_id`, `email`, `mobile`, `about`, `address`, `city`, `pincode`, `country`, `latitude`, `longitude`, `password`, `image`, `banner_image`, `registration_detail`, `registration_file`, `cp_name`, `days`, `name_on_bank`, `bank_name`, `branch_name`, `ifsc`, `ac_no`, `ac_type`, `micr_code`, `pan_no`, `cancel_cheque`, `pan_image`, `accredition_details`, `accredition_certificate`, `slug`, `is_deleted`, `created_at`, `updated_at`, `owner_name`, `owner_id`, `phone_no`, `h_c_fee`, `h_c_fee_apply_before`, `r_d_fee`, `r_d_fee_apply_before`, `ambulance_fee`) VALUES
(1, 'Lab name', 0, 'lab@gmail.com', '6564636262', '', 'F25G QMR, Gurugram, Haryana, India', 'Gurugram', '', 'India', '28.4594965', '77.0266383', '$2y$10$BvVK243XLgi7MztWTWBW5OPQrUQzIxw4WUFEpb./.7y6/gWY0N.wK', 'd-451601658264088.jpeg', '', 'registration number', 'd-768691658264088.png', '', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\"]', 'name in bank account', 'bank', 'PPPP', 'ifsc', '6e82787', 'saving', 'qr3rwq', '324', 'd-923601658264137.png', 'd-447481658264137.png', 'ISO,QCI', 'd-356081658264787.png', 'slug', '0', '2022-07-06 13:46:17', '2023-02-18 13:53:43', 'owner name', '0', '2323232', 100, 1000, 122, 100, 200);

-- --------------------------------------------------------

--
-- Table structure for table `labtestcategories`
--

CREATE TABLE `labtestcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labtestcategories`
--

INSERT INTO `labtestcategories` (`id`, `title`, `image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'lab category', '1656005575.png', '0', '2022-06-23 12:02:55', '2022-06-23 12:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `labtestpackages`
--

CREATE TABLE `labtestpackages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_id` bigint(20) UNSIGNED DEFAULT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_ids` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_sample_collection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_home_delivery` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambulance_available` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambulance_fee` int(11) NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 Not Delete 1 Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labtestpackages`
--

INSERT INTO `labtestpackages` (`id`, `lab_id`, `package_name`, `test_ids`, `price`, `discount`, `image`, `home_sample_collection`, `report_home_delivery`, `ambulance_available`, `ambulance_fee`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'pkgnm', '[1,4]', 123, 10, '1656148157.png', 'Yes', 'No', 'Yes', 100, '0', '2022-06-25 02:55:28', '2023-02-18 13:51:13'),
(2, 3, 'Package name', '[3]', 100, 1, 'd-30851656180844.png', 'Yes', 'Yes', '', 0, '0', '2022-06-25 12:44:04', '2022-06-25 12:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `labtests`
--

CREATE TABLE `labtests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `test_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `prerequisite` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_sample_collection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_home_delivery` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambulance_available` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambulance_fee` int(11) NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 Not Delete 1 Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labtests`
--

INSERT INTO `labtests` (`id`, `lab_id`, `category_id`, `test_name`, `image`, `price`, `discount`, `prerequisite`, `home_sample_collection`, `report_home_delivery`, `ambulance_available`, `ambulance_fee`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'test name', 'd-484961659882471.jpeg', 1000, 10, 'no', 'Yes', 'Yes', 'Yes', 110, '0', '2022-06-23 13:27:53', '2023-02-18 13:32:02'),
(2, NULL, 1, 'Test name', '', 100, 100, 'no', 'Yes', 'Yes', '', 0, '0', '2022-06-25 09:38:53', '2022-06-25 09:38:53'),
(3, 3, 1, 'test new', 'd-18581656169913.png', 10, 1, 'no', 'No', 'Yes', '', 0, '0', '2022-06-25 09:41:53', '2022-06-25 09:41:53'),
(4, 1, 1, 'Test 2', 'd-449831659882490.png', 100, 10, 'rr', 'Yes', 'Yes', 'Yes', 10, '0', '2022-08-07 08:17:44', '2023-02-18 13:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `labtest_bookings`
--

CREATE TABLE `labtest_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `sample_collector` int(11) NOT NULL,
  `delivery_boy` int(11) NOT NULL,
  `is_home_collection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_home_delivery` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_ambulance` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_c_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_d_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambulance_price` int(11) NOT NULL,
  `address` varchar(600) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_file` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_completed` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labtest_bookings`
--

INSERT INTO `labtest_bookings` (`id`, `user_id`, `lab_id`, `sample_collector`, `delivery_boy`, `is_home_collection`, `is_home_delivery`, `is_ambulance`, `price`, `h_c_price`, `h_d_price`, `ambulance_price`, `address`, `report_file`, `payment_id`, `is_completed`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 'Yes', 'Yes', '0', '500.7', '100', '0', 200, 'address', '', '42', '1', '0', '2022-12-25 01:41:54', '2022-12-25 02:42:54'),
(2, 5, 1, 0, 0, 'No', 'No', '0', '1100', '0', '0', 110, '', '', '43', '0', '0', '2023-02-18 14:16:37', '2023-02-18 14:18:36'),
(3, 5, 1, 0, 0, 'No', 'No', 'Yes', '1100', '0', '0', 110, '', '', '', '0', '0', '2023-02-18 14:32:42', '2023-02-18 14:32:42'),
(4, 5, 1, 0, 0, 'No', 'No', 'Yes', '1100', '0', '0', 110, 'address', '', '45', '0', '0', '2023-02-18 14:34:12', '2023-02-18 14:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `labtest_masterdbs`
--

CREATE TABLE `labtest_masterdbs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not 1 yes',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labtest_masterdbs`
--

INSERT INTO `labtest_masterdbs` (`id`, `title`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Labtest', '1', '0', '2022-09-23 09:17:53', '2022-09-23 09:17:53'),
(2, 'New test', '1', '0', '2022-09-23 09:18:05', '2022-09-23 09:18:05'),
(3, 'new labtest', '1', '0', '2022-09-23 09:18:34', '2022-09-23 09:18:34'),
(4, 'test name', '0', '0', '2022-09-23 13:10:15', '2022-09-23 13:10:15'),
(5, 'Test 2', '0', '0', '2023-02-18 12:39:46', '2023-02-18 12:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `lab_booking_info_lists`
--

CREATE TABLE `lab_booking_info_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 pending 1 accepted 2 out for service 3 reached 4 completed 5 canceled',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_booking_info_lists`
--

INSERT INTO `lab_booking_info_lists` (`id`, `order_id`, `test_id`, `type`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'test', '0', '0', '2022-12-25 01:41:54', '2022-12-25 01:41:54'),
(2, 1, 1, 'labpackage', '0', '0', '2022-12-25 01:41:54', '2022-12-25 01:41:54'),
(3, 2, 4, 'test', '0', '0', '2023-02-18 14:16:37', '2023-02-18 14:16:37'),
(4, 2, 1, 'test', '0', '0', '2023-02-18 14:16:37', '2023-02-18 14:16:37'),
(5, 3, 1, 'test', '0', '0', '2023-02-18 14:32:42', '2023-02-18 14:32:42'),
(6, 3, 4, 'test', '0', '0', '2023-02-18 14:32:42', '2023-02-18 14:32:42'),
(7, 4, 4, 'test', '0', '0', '2023-02-18 14:34:12', '2023-02-18 14:34:12'),
(8, 4, 1, 'test', '0', '0', '2023-02-18 14:34:12', '2023-02-18 14:34:12');

-- --------------------------------------------------------

--
-- Table structure for table `medical_counsilings`
--

CREATE TABLE `medical_counsilings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_counsilings`
--

INSERT INTO `medical_counsilings` (`id`, `title`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Delhi', '1', '0', NULL, NULL),
(2, 'Mumbai', '1', '0', NULL, NULL),
(3, 'Kolkata', '1', '0', '2022-09-09 03:13:29', '2022-09-09 03:14:16'),
(4, 'Jaipur', '1', '0', '2022-09-09 03:14:02', '2022-09-09 03:18:58'),
(5, 'Channai', '1', '0', '2022-09-09 03:17:32', '2022-09-09 03:18:51'),
(6, 'AIMS', '1', '0', '2022-09-09 03:18:41', '2022-09-09 03:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meeting_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occurrences` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `meeting_id`, `host_id`, `host_email`, `topic`, `type`, `start_url`, `join_url`, `occurrences`, `password`, `created_at`, `updated_at`) VALUES
(1, '79832119525', 'twsU3RWQSMqjMWreks6qXA', 'imchahardeepak@gmail.com', 'Meeting', '8', 'https://us04web.zoom.us/s/79832119525?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InR3c1UzUldRU01xak1XcmVrczZxWEEiLCJpc3MiOiJ3ZWIiLCJzayI6IjM0MzE4MTA2ODY4OTg5MDc3NTQiLCJzdHkiOjEwMCwid', 'https://us04web.zoom.us/j/79832119525?pwd=6TlT2mgEJFmRYoQgobrop7iJ6OnB6r.1', '[{\"occurrence_id\":\"1660751940000\",\"start_time\":\"2022-08-17T15:59:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1661356740000\",\"start_time\":\"2022-08-24T15:59:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1661961540000\",\"start_time', '123456', '2022-08-17 10:29:54', '2022-08-17 10:29:54'),
(2, '72115242981', 'twsU3RWQSMqjMWreks6qXA', 'imchahardeepak@gmail.com', 'Meeting', '8', 'https://us04web.zoom.us/s/72115242981?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InR3c1UzUldRU01xak1XcmVrczZxWEEiLCJpc3MiOiJ3ZWIiLCJzayI6IjM0MzE4MTA2ODY4OTg5MDc3NTQiLCJzdHkiOjEwMCwid', 'https://us04web.zoom.us/j/72115242981?pwd=a9mso0WDfJRJ4Z3OU8-yOtgwRpS5lO.1', '[{\"occurrence_id\":\"1660822200000\",\"start_time\":\"2022-08-18T11:30:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1661427000000\",\"start_time\":\"2022-08-25T11:30:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1662031800000\",\"start_time', '123456', '2022-08-18 06:00:45', '2022-08-18 06:00:45'),
(3, '77619413328', 'twsU3RWQSMqjMWreks6qXA', 'imchahardeepak@gmail.com', 'Meeting', '8', 'https://us04web.zoom.us/s/77619413328?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InR3c1UzUldRU01xak1XcmVrczZxWEEiLCJpc3MiOiJ3ZWIiLCJzayI6IjM0MzE4MTA2ODY4OTg5MDc3NTQiLCJzdHkiOjEwMCwid', 'https://us04web.zoom.us/j/77619413328?pwd=DJdd3L5tvyBwMSeK2MlvxxL46-uR1g.1', '[{\"occurrence_id\":\"1660827900000\",\"start_time\":\"2022-08-18T13:05:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1661432700000\",\"start_time\":\"2022-08-25T13:05:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1662037500000\",\"start_time', '123456', '2022-08-18 07:35:52', '2022-08-18 07:35:52'),
(4, '78600264456', 'twsU3RWQSMqjMWreks6qXA', 'imchahardeepak@gmail.com', 'Meeting', '8', 'https://us04web.zoom.us/s/78600264456?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InR3c1UzUldRU01xak1XcmVrczZxWEEiLCJpc3MiOiJ3ZWIiLCJzayI6IjM0MzE4MTA2ODY4OTg5MDc3NTQiLCJzdHkiOjEwMCwid', 'https://us04web.zoom.us/j/78600264456?pwd=U9caEQrichzBf0WZH1vbwOQwnycgrj.1', '[{\"occurrence_id\":\"1667914140000\",\"start_time\":\"2022-11-08T13:29:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1668518940000\",\"start_time\":\"2022-11-15T13:29:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1669123740000\",\"start_time', '123456', '2022-11-08 07:59:05', '2022-11-08 07:59:05'),
(5, '72129272831', 'twsU3RWQSMqjMWreks6qXA', 'imchahardeepak@gmail.com', 'Meeting', '8', 'https://us04web.zoom.us/s/72129272831?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InR3c1UzUldRU01xak1XcmVrczZxWEEiLCJpc3MiOiJ3ZWIiLCJzayI6IjM0MzE4MTA2ODY4OTg5MDc3NTQiLCJzdHkiOjEwMCwid', 'https://us04web.zoom.us/j/72129272831?pwd=jp4F8pijEOIwq2elYdYWr1NLA4BhYY.1', '[{\"occurrence_id\":\"1667914260000\",\"start_time\":\"2022-11-08T13:31:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1668519060000\",\"start_time\":\"2022-11-15T13:31:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1669123860000\",\"start_time', '123456', '2022-11-08 08:01:56', '2022-11-08 08:01:56'),
(6, '71703041961', 'twsU3RWQSMqjMWreks6qXA', 'imchahardeepak@gmail.com', 'Meeting', '8', 'https://us04web.zoom.us/s/71703041961?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InR3c1UzUldRU01xak1XcmVrczZxWEEiLCJpc3MiOiJ3ZWIiLCJzayI6IjM0MzE4MTA2ODY4OTg5MDc3NTQiLCJzdHkiOjEwMCwid', 'https://us04web.zoom.us/j/71703041961?pwd=WJvDHv3a8GAkj76crbSIl8N3y6JrMy.1', '[{\"occurrence_id\":\"1667915820000\",\"start_time\":\"2022-11-08T13:57:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1668520620000\",\"start_time\":\"2022-11-15T13:57:00Z\",\"duration\":60,\"status\":\"available\"},{\"occurrence_id\":\"1669125420000\",\"start_time', '123456', '2022-11-08 08:27:27', '2022-11-08 08:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2022_04_03_163106_create_superadmin_table', 1),
(10, '2022_04_04_174255_create_specializations_table', 1),
(11, '2022_04_04_174334_create_procedures_table', 1),
(12, '2022_04_05_164302_create_specialities_table', 1),
(14, '2022_04_07_154943_create_doctors_table', 1),
(15, '2022_04_08_163539_create_pharmacists_table', 1),
(16, '2022_04_08_184523_create_laboratorists_table', 1),
(19, '2022_04_14_172043_create_pharmacies_table', 1),
(23, '2022_04_16_085445_create_categories_table', 2),
(24, '2022_04_16_090002_create_sub_categories_table', 2),
(25, '2022_04_17_055622_create_price_table', 3),
(26, '2022_04_17_060114_create_product_image_table', 3),
(27, '2022_04_15_161156_create_products_table', 4),
(28, '2022_04_05_164632_create_hospitals_table', 5),
(30, '2022_04_29_112103_create_otps_table', 7),
(32, '2014_10_12_000000_create_users_table', 8),
(33, '2022_04_26_035648_create_appointments_table', 9),
(35, '2022_04_09_110654_create_customers_table', 10),
(37, '2022_04_10_170726_create_hospital__staff_table', 11),
(38, '2022_05_01_145811_create_timeslots_table', 12),
(39, '2022_05_22_082419_create_prices_table', 13),
(40, '2022_06_15_093659_create_medical_counsilings_table', 14),
(41, '2022_06_16_031835_create_doctor_bank_docs_table', 15),
(42, '2022_06_18_120536_create_facilities_table', 16),
(43, '2022_06_18_123151_create_empanelments_table', 17),
(44, '2022_06_19_181117_create_formulations_table', 18),
(45, '2022_06_22_095836_create_labtests_table', 19),
(46, '2022_06_22_101442_create_labtestcategories_table', 19),
(47, '2022_06_22_101803_create_labtestpackages_table', 19),
(48, '2022_06_26_081620_create_bloodbanks_table', 20),
(49, '2022_06_26_115250_create_bloodbankstocks_table', 21),
(50, '2022_06_29_085752_create_treatments_table', 22),
(51, '2022_07_06_192333_create_blogs_table', 22),
(52, '2022_07_10_061201_create_bloodbank_components_table', 22),
(53, '2022_07_10_112938_create_blog_comments_table', 23),
(54, '2022_07_10_191146_create_illness_lists_table', 24),
(55, '2022_07_15_115424_create_symptoms_lists_table', 25),
(56, '2022_07_15_115534_create_treatment_and_surgery_lists_table', 25),
(57, '2022_07_20_080135_create_blood_doners_table', 26),
(58, '2022_07_20_080637_create_doctor_edus_table', 27),
(59, '2022_08_02_034422_create_patient_lists_table', 28),
(60, '2022_08_07_094341_create_payments_table', 29),
(61, '2022_08_07_172532_create_labtest_bookings_table', 30),
(62, '2022_08_08_182018_create_buy_carts_table', 31),
(63, '2022_08_08_193452_create_buy_cart_order_infos_table', 32),
(64, '2022_08_16_114846_create_chats_table', 33),
(65, '2022_08_17_081909_create_meetings_table', 34),
(66, '2022_08_17_081957_create_zoomtokens_table', 34),
(67, '2022_08_28_122223_create_nursings_table', 35),
(68, '2022_08_29_174307_create_dealers_table', 36),
(69, '2022_08_30_172259_create_dealer_products_table', 37),
(70, '2022_08_31_091720_create_dealer_product_purchases_table', 38),
(71, '2022_08_31_180203_create_home_care_requests_table', 39),
(72, '2022_08_31_192039_create_nursing_procedures_table', 40),
(73, '2022_09_03_104910_create_pincode_maps_table', 41),
(74, '2022_09_07_172636_create_designation_lists_table', 42),
(75, '2022_09_23_143710_create_labtest_masterdbs_table', 43),
(76, '2022_10_01_034843_create_doctor_comments_table', 44),
(77, '2022_10_01_062418_create_doctor_medicine_advice_table', 44),
(78, '2022_10_02_125400_create_dignosis_lists_table', 45),
(79, '2022_10_18_070245_create_ambulances_table', 46),
(80, '2022_10_18_084925_create_ambulance_lists_table', 47),
(81, '2022_10_18_085435_create_ambulance_driver_lists_table', 47),
(82, '2022_11_12_145121_create_accredition_certificates_table', 48),
(83, '2022_11_26_111005_create_chat_reports_table', 49),
(84, '2022_11_28_170408_create_delivery_boys_table', 50),
(85, '2022_12_18_180019_create_ambulance_bookings_table', 51),
(87, '2022_12_25_063407_create_lab_booking_info_lists_table', 52),
(88, '2023_02_18_125258_create_category_eqps_table', 53),
(89, '2023_03_18_151059_create_service_payments_table', 54),
(90, '2023_03_18_163659_create_service_payment_histories_table', 55),
(91, '2023_03_22_181509_create_reviews_table', 56);

-- --------------------------------------------------------

--
-- Table structure for table `nursings`
--

CREATE TABLE `nursings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buero_id` int(11) NOT NULL,
  `mobile` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regis_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` int(11) NOT NULL,
  `registration_certificate` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_fill_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_weekof_replacement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_remarks` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visit_charges` int(11) NOT NULL,
  `per_hour_charges` int(11) NOT NULL,
  `per_days_charges` int(11) NOT NULL,
  `per_month_charges` int(11) NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_on_bank` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `micr_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_cheque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nursings`
--

INSERT INTO `nursings` (`id`, `buero_id`, `mobile`, `regis_type`, `name`, `type`, `gender`, `image`, `banner`, `about`, `experience`, `registration_certificate`, `id_proof`, `qualification`, `degree`, `part_fill_time`, `work_hours`, `is_weekof_replacement`, `custom_remarks`, `visit_charges`, `per_hour_charges`, `per_days_charges`, `per_month_charges`, `latitude`, `longitude`, `address`, `city`, `pincode`, `country`, `name_on_bank`, `bank_name`, `branch_name`, `ifsc`, `ac_no`, `ac_type`, `micr_code`, `pan_no`, `cancel_cheque`, `pan_image`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 9, '8483829382', 'Buero', 'Deepak Chahar', 'Nurse', 'Male', 'd-757461661716174.png', 'd-27381661948129.jpeg', 'About', 10, 'd-450501661716174.jpeg', 'd-495161661716174.jpeg', 'qualifoication', 'd-189651661716174.png', 'Full time', '2', 'Yes (without replacement)', 'no', 100, 200, 300, 9000, '25.4484257', '78.5684594', 'कुंज बिहारी मंदिर के पास आँटिया तालाब, Prathvipur, Civil Lines, Jhansi, Uttar Pradesh 284001, India', 'Jhansi', '284001', 'India', 'NEW BANK 2', 'BANK', 'BRANCH', 'IFSC', '123CA', 'saving', 'MIRC', 'PAN', 'd-246371661716590.png', 'd-936681661716590.png', 'nursing', '0', '2022-08-28 09:22:22', '2022-12-19 21:07:46'),
(3, 9, '3232323232', '', 'Nursing2', 'Nurse', 'Male', '', '', '', 0, '', '', 'mca', '', 'Full time', '1', '', '', 0, 0, 0, 0, '', '', '', '', '', '', 'Bank new', 'bb', 'vv', 'wqdqwd', 'dada', 'saving', 'micr', 'cascscsa', 'd-256961668346948.jpeg', '', 'n2', '0', '2022-11-13 08:09:50', '2022-11-13 08:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `nursing_procedures`
--

CREATE TABLE `nursing_procedures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nursing_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 inactive 1 active',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nursing_procedures`
--

INSERT INTO `nursing_procedures` (`id`, `nursing_id`, `title`, `price`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Procedure namee', 1000, '1', '0', '2022-08-31 14:27:59', '2022-08-31 14:38:33'),
(2, 1, 'Procedure 2', 200, '1', '0', '2022-08-31 14:38:50', '2022-08-31 14:38:50'),
(3, 1, 'Procedure 3', 56, '1', '0', '2022-08-31 14:39:08', '2022-08-31 14:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('04aacbcdbbcc7fc8302bf8e3d94a967043827d9143bc9473e4d1a4eeaf7f5974614e3d7bb41922d8', 1, 1, 'login', '[]', 0, '2022-11-26 05:19:33', '2022-11-26 05:19:33', '2023-11-26 10:49:33'),
('067d4a78badad94ee7a0928827965ae5bdeaad9fca73814a4ad280d116fd46f51d15eb92caa931a6', 4, 1, 'login', '[]', 0, '2022-12-20 08:26:46', '2022-12-20 08:26:46', '2023-12-20 13:56:46'),
('08e52cda56048a712692ab6765d06cc774d73925504a76d58da4f5823a0c5bae7ad3e8bf249db8e8', 12, 1, 'login', '[]', 0, '2022-06-18 03:21:36', '2022-06-18 03:21:36', '2023-06-18 08:51:36'),
('091967bef7ecf81c7fb97707087ee29624088da7b151285538fac17063cc6ef146d1f551690767df', 1, 1, 'login', '[]', 0, '2022-04-26 05:00:56', '2022-04-26 05:00:56', '2023-04-26 10:30:56'),
('0a4f8b2ccc4ef5cf468022bbe6626478895397c2dd8355a138abd2e1b164ae9afe1bafc985c83c88', 2, 1, 'login', '[]', 0, '2023-03-02 08:50:37', '2023-03-02 08:50:37', '2024-03-02 14:20:37'),
('0b45905c121c808e2326a9f00d1e4604ba0eda8c5e0ea3468fb7d49fb85e00721fbfc312937f908e', 2, 1, 'login', '[]', 0, '2022-11-27 12:59:48', '2022-11-27 12:59:48', '2023-11-27 18:29:48'),
('0c2a3090c938c46cff16a145cbb4340f1254c462620e30662def1f56c0055e133db9c9874b611149', 2, 1, 'login', '[]', 0, '2022-08-16 05:06:51', '2022-08-16 05:06:51', '2023-08-16 10:36:51'),
('0fa14159dae1fb7ce594ce9f7cd6ca505f17d515268736c1e5f1d20059e3ddb3166a7f4719296f7b', 3, 1, 'login', '[]', 0, '2022-12-25 02:44:06', '2022-12-25 02:44:06', '2023-12-25 08:14:06'),
('0fd5ddbb06f00672e87e60639a6bb420381adee9cc314b33c8af46cb39f928d250ff1aa97e8dd3b2', 9, 1, 'login', '[]', 0, '2022-12-20 08:50:44', '2022-12-20 08:50:44', '2023-12-20 14:20:44'),
('120e5bf71f768540d9cdc25fb0a059622b9d41ad2a9dd6f19082faea24e593ac5b691903aff6f021', 7, 1, 'login', '[]', 0, '2022-04-30 08:33:25', '2022-04-30 08:33:25', '2023-04-30 14:03:25'),
('138ecd0cea6c9e16c2a042df91515d8f517bb4f040bea7819d789bc5a8cbf3768436688b56c00ef6', 10, 1, 'login', '[]', 0, '2023-02-19 02:24:38', '2023-02-19 02:24:38', '2024-02-19 07:54:38'),
('138f63977f82ae99762039c60d3f2d5837839cf3f37708133ac2fafe66addf64ea2edb67e9857cb9', 9, 1, 'login', '[]', 0, '2022-11-13 01:28:05', '2022-11-13 01:28:05', '2023-11-13 06:58:05'),
('1591f50a0d2f29ec48375a19753bce9dba0465381efb4f9335cb1803d05166a1e82cdbd0f71355c1', 2, 1, 'login', '[]', 0, '2022-11-27 03:04:14', '2022-11-27 03:04:14', '2023-11-27 08:34:14'),
('167f4c6e68b82d52397d032d2f4108a9f88c4acdadcc371f2437f2313063491cb02a1926746ed71f', 20, 1, 'login', '[]', 0, '2022-06-29 03:51:41', '2022-06-29 03:51:41', '2023-06-29 09:21:41'),
('16a4e84d61f725b74dae76ba2fbedd096c078ffddb061f34bf5b52496060cc53271d355ddd125549', 5, 1, 'login', '[]', 0, '2022-11-12 07:45:50', '2022-11-12 07:45:50', '2023-11-12 13:15:50'),
('172e49d31241804cac9e9e6990472c33cd77b548e5d6d72e02be533d6243b42f4daa724c83702c85', 2, 1, 'login', '[]', 0, '2022-11-06 12:46:38', '2022-11-06 12:46:38', '2023-11-06 18:16:38'),
('18cc28487d48223adf0d6d21a4dcb44cadb65eae4fd599d2b81fa80080ffe45f6dd69ac4475c1106', 7, 1, 'login', '[]', 0, '2022-04-30 08:23:27', '2022-04-30 08:23:27', '2023-04-30 13:53:27'),
('194963a7d26cf5c658650da465270cc6b56817589f3531305e43c13ec3581a9780b290c65b5d7b7b', 2, 1, 'login', '[]', 0, '2022-07-15 07:31:54', '2022-07-15 07:31:54', '2023-07-15 13:01:54'),
('19c8292a52c0d58e564d7076d69f7dc1c5f5291ef5930995892116877a2cb4c254b6c59dff316c42', 12, 1, 'login', '[]', 0, '2022-11-06 13:09:22', '2022-11-06 13:09:22', '2023-11-06 18:39:22'),
('19cd296cfd3c7164cba5fd6741db1648dd58118c27d9fdf1d945882eee96848f5cfed34dbc792bae', 4, 1, 'login', '[]', 0, '2022-12-03 04:23:35', '2022-12-03 04:23:35', '2023-12-03 09:53:35'),
('1b08c65bdec4589b2b5f2374b7f5f406ed8101f5a7b8c89b630e86b3cf932727ed3c830815c282d7', 10, 1, 'login', '[]', 0, '2022-12-20 08:40:21', '2022-12-20 08:40:21', '2023-12-20 14:10:21'),
('1c8c30d1f0d9c1d28a048612ac168e20d441f0784ad7bb786d52067697d3886f04bd11401b777daa', 2, 1, 'login', '[]', 0, '2022-08-13 12:53:27', '2022-08-13 12:53:27', '2023-08-13 18:23:27'),
('1eed975401cdf8a6c9f4dfe56fa0fb5e42442799099d4c63e20819414a4fa8fdccdf073ded24f72b', 4, 1, 'login', '[]', 0, '2022-08-15 03:21:02', '2022-08-15 03:21:02', '2023-08-15 08:51:02'),
('1faaf2df1ba63e633df369e5c971016fce6d630082f6f11d83acf3bb04c0f5bcff6815972a13cabe', 28, 1, 'login', '[]', 0, '2022-06-21 10:24:17', '2022-06-21 10:24:17', '2023-06-21 15:54:17'),
('2006120ecddb23552f48a9f29b1db0c5663559187fa63ba9d4d1cecb422dfaff96b20b7d9068d4aa', 2, 1, 'login', '[]', 0, '2022-07-14 12:17:18', '2022-07-14 12:17:18', '2023-07-14 17:47:18'),
('2141a2d42c1e9507929efe1b79ccbe1418624a3f818d43c3d1c14edec8b998fad81c50a327c56d78', 10, 1, 'login', '[]', 0, '2022-10-03 08:09:32', '2022-10-03 08:09:32', '2023-10-03 13:39:32'),
('214afb154664c31f3caba37ae88d8f281740b8ef277a3556b18751f4a91dfcf79aa7dd4946d1d195', 3, 1, 'login', '[]', 0, '2022-07-15 07:26:13', '2022-07-15 07:26:13', '2023-07-15 12:56:13'),
('22e325c85453395f00a3323ac1526ee181ee3e9c3608b4e8402474f843fd8cb5aab8d29d2a812881', 5, 1, 'login', '[]', 0, '2022-08-18 07:42:36', '2022-08-18 07:42:36', '2023-08-18 13:12:36'),
('25a75be602d5ef6adb620420bb98794bf5d4bbf810005dcd33f6a9a87a67c023de363e4ab94f236c', 3, 1, 'login', '[]', 0, '2022-11-12 07:49:55', '2022-11-12 07:49:55', '2023-11-12 13:19:55'),
('2672222cf334efec2ce0e71d9f3ca6161a6fed9d9e9753ba0309dc9a9d7ee5dd354b7a34b423bf4e', 4, 1, 'login', '[]', 0, '2022-08-10 04:29:38', '2022-08-10 04:29:38', '2023-08-10 09:59:38'),
('268203071381a02bc8045df798b7b54ae3c50b8eb1323e42d5db8d779f72298a4b6b04dc229b38f0', 2, 1, 'login', '[]', 0, '2022-07-10 14:21:50', '2022-07-10 14:21:50', '2023-07-10 19:51:50'),
('26a023ec71b42ab94ae7b7a319d44d54ed1232303733fb9b9d0a76b1d34fa1dbd33bc16602470a12', 4, 1, 'login', '[]', 0, '2023-02-19 02:58:09', '2023-02-19 02:58:09', '2024-02-19 08:28:09'),
('2742a979f28da2a4079888afc6e1c772f8b45744151f307f05a96b9c383bc7ce8cfcefbd4b6bfd52', 15, 1, 'login', '[]', 0, '2022-06-13 11:05:40', '2022-06-13 11:05:40', '2023-06-13 16:35:40'),
('2baa31014edda700af422fad634ce138e3c1c5f98785c9156b58a35513b17e561d33e2c185076a4d', 5, 1, 'login', '[]', 0, '2022-07-15 08:25:51', '2022-07-15 08:25:51', '2023-07-15 13:55:51'),
('2c7a6cbeb5a853307c0420a29a0014afee9350d401c04ae6dcca889dd831e492c73d3ee96bfd9484', 4, 1, 'login', '[]', 0, '2022-11-08 05:38:28', '2022-11-08 05:38:28', '2023-11-08 11:08:28'),
('2caab47c3d203ecd2886269b3c0d069318d30281799dc094322723c8079a5c65e07d178eea092e7f', 3, 1, 'login', '[]', 0, '2022-09-28 22:09:02', '2022-09-28 22:09:02', '2023-09-29 03:39:02'),
('2e82091a7a67f313b8d9da6952801715541b17a5f197535053c377ede1027ef696e8670de75eb64d', 11, 1, 'login', '[]', 0, '2022-12-20 08:34:47', '2022-12-20 08:34:47', '2023-12-20 14:04:47'),
('2eb195294a7417671da6bcb1ec02e6bad751d967ca9a46e36eb0a2a30d1db84813ca1346df5ce815', 2, 1, 'login', '[]', 0, '2022-10-13 11:36:07', '2022-10-13 11:36:07', '2023-10-13 17:06:07'),
('31b7dd81863fe81e88f7d8283f265fdb824fc3b2600e7971555f4625e85d156a6bba5cf36d5da864', 1, 1, 'login', '[]', 0, '2022-11-08 08:13:07', '2022-11-08 08:13:07', '2023-11-08 13:43:07'),
('321956842087972fa0e4ee637084d62c4fbb10a075875e025bd4283b9e2716b94358f4ca40cab06c', 2, 1, 'login', '[]', 0, '2022-11-08 07:48:49', '2022-11-08 07:48:49', '2023-11-08 13:18:49'),
('32ecebfaa37e8145426dd90fa09893b78853d0170b17dae89d43cd6a1fea3e59847aa4d3ce438985', 31, 1, 'login', '[]', 0, '2022-06-30 03:59:51', '2022-06-30 03:59:51', '2023-06-30 09:29:51'),
('3408047d865fd4be550c68b36664c430eda3a138c82bd5cd8a84d9652347986309433470f78f2744', 7, 1, 'login', '[]', 0, '2022-04-30 03:25:47', '2022-04-30 03:25:47', '2023-04-30 08:55:47'),
('35ac88956306b879fd32f49cf98fc47f4c49fdc422fcfa1e6f15a9a851b1874b226aba603caa67df', 1, 1, 'login', '[]', 0, '2022-08-31 04:57:39', '2022-08-31 04:57:39', '2023-08-31 10:27:39'),
('35f0499c1b84847bbd5a4c050b79092cda489c8e3f12bb9079625dcba5e4c2df01bd859e53c5c314', 6, 1, 'login', '[]', 0, '2022-09-05 06:31:58', '2022-09-05 06:31:58', '2023-09-05 12:01:58'),
('36e92c343b3138ac01858b200172941bf1b48a7c40e13302099f8e7b052dfebc6296dd6d20c6b26c', 18, 1, 'login', '[]', 0, '2022-05-12 13:20:21', '2022-05-12 13:20:21', '2023-05-12 18:50:21'),
('375b8d5934149ee91a0e7923f8c5cbd6f9e8d998d4b68ddff8279c469ae5d5e2eb476da5be2502cd', 1, 1, 'login', '[]', 0, '2022-07-06 12:53:54', '2022-07-06 12:53:54', '2023-07-06 18:23:54'),
('376545fcdd5830ca705ffd7271a38af041549f8a5678abe8884c6831d778ca5a55ac09b4995476e2', 9, 1, 'login', '[]', 0, '2023-02-18 11:28:37', '2023-02-18 11:28:37', '2024-02-18 16:58:37'),
('37b4fda3fa2bdc64b346c35070369a0ca3f7912637e888dbafb08a148c7749e971eb8eed70b7df07', 9, 1, 'login', '[]', 0, '2023-02-18 11:25:26', '2023-02-18 11:25:26', '2024-02-18 16:55:26'),
('39a606234276f91c0a89a009dccfb18e6db4d92951e26bcf544f1b2a75584e65e33a5a5679a91252', 2, 1, 'login', '[]', 0, '2022-11-27 12:59:50', '2022-11-27 12:59:50', '2023-11-27 18:29:50'),
('39e20b46b7f7fbe4c272b6f030d2f8bf6ca2058d2ee57d9abb0c97efaf46e8afa19724e666f71c4b', 19, 1, 'login', '[]', 0, '2022-06-30 04:19:06', '2022-06-30 04:19:06', '2023-06-30 09:49:06'),
('3b90b2ba53b198c46e507433367cb3497c74ace0d4fcdc5400b243d2b7df32f1bdf3f237f5973223', 19, 1, 'login', '[]', 0, '2022-05-12 13:23:59', '2022-05-12 13:23:59', '2023-05-12 18:53:59'),
('3c1c896c0e50cf0dc6cd7164d83db83c795b1b05748fe453415bf3d5a683bd823442d7ec7121f9ce', 5, 1, 'login', '[]', 0, '2022-08-14 01:31:52', '2022-08-14 01:31:52', '2023-08-14 07:01:52'),
('3d48a401a9409b23f4ed54b879edf001f96a5052c2b37713320cb94aabbe84db6d7e350bea9a987d', 1, 1, 'login', '[]', 0, '2022-12-18 13:47:52', '2022-12-18 13:47:52', '2023-12-18 19:17:52'),
('3f21581c61d04fe991f3e43caf753b5d41252b546ac76abfc374825d7204d42eac15f7b6bc731f8d', 2, 1, 'login', '[]', 0, '2023-03-22 12:28:57', '2023-03-22 12:28:57', '2024-03-22 17:58:57'),
('40227d67fe3ad6ba3d22443d838c0cc399a6ac1708cbfebbfd460d69219e3c97309c46b2cf934fcd', 12, 1, 'login', '[]', 0, '2022-05-02 08:14:55', '2022-05-02 08:14:55', '2023-05-02 13:44:55'),
('40b738bc5e87e0eda8f3ba86bed44d1e1d8f3a3cc6573232443ff25ca8eb233e36c3d92887c41c12', 6, 1, 'login', '[]', 0, '2022-07-10 00:52:50', '2022-07-10 00:52:50', '2023-07-10 06:22:50'),
('422c340000f4ab13e77dae58c2e56a716d42adb26f4b4f9096e98fc649c738e36062f555675e245e', 4, 1, 'login', '[]', 0, '2022-09-25 02:31:44', '2022-09-25 02:31:44', '2023-09-25 08:01:44'),
('422e500a58bc8643b11cddf61ca96e58ca5a99b7dcf7d32d1d0d185dbd8d8429998a52e9196f9cf0', 2, 1, 'login', '[]', 0, '2022-07-06 13:51:03', '2022-07-06 13:51:03', '2023-07-06 19:21:03'),
('42313395849bf2f54dbebcb59fbff3ca97fb59e6c300a341a1e485e01d6f465d24c7d37c05c42e79', 4, 1, 'login', '[]', 0, '2022-08-29 11:47:16', '2022-08-29 11:47:16', '2023-08-29 17:17:16'),
('42ba3295516cfc995a28115f1a5edcebe76227a7280d918002be501aff79f513c34e5894dc16a005', 2, 1, 'login', '[]', 0, '2022-07-19 02:12:25', '2022-07-19 02:12:25', '2023-07-19 07:42:25'),
('430a8482d474753537c226f474bc812660b6b66a08eb9d5e2a0e187eb8c3dea9545cdf344265a369', 1, 1, 'login', '[]', 0, '2023-02-27 12:51:11', '2023-02-27 12:51:11', '2024-02-27 18:21:11'),
('4315295e97b64c877934ec28dac09914d0641afd11990a0992c08eb7003dd21eb8daf0aeb7e8e7e5', 3, 1, 'login', '[]', 0, '2022-12-20 09:24:16', '2022-12-20 09:24:16', '2023-12-20 14:54:16'),
('4342c231c02ae27cb9e807ed80b88578703e831ae47af5572e539899e70a0a396675d3ee06c90b37', 2, 1, 'login', '[]', 0, '2022-09-30 14:21:26', '2022-09-30 14:21:26', '2023-09-30 19:51:26'),
('44437b122074f1ca54d22044ff040562c6b41d223e20fcb2ec924ff62b2077117409194895bf16d0', 7, 1, 'login', '[]', 0, '2022-04-30 08:22:20', '2022-04-30 08:22:20', '2023-04-30 13:52:20'),
('447d24ea7dcdd4ee3ff91876f359ee5e92520ac2efd43a10063e476c418cc2e21f0ab9e017ea9b65', 10, 1, 'login', '[]', 0, '2022-08-29 13:41:44', '2022-08-29 13:41:44', '2023-08-29 19:11:44'),
('4549fbd1909a8cecd430b44b612ad0cb0a3ee9b22ad69e5f169296ac070a31157addc2169258b852', 1, 1, 'login', '[]', 0, '2022-04-26 05:19:36', '2022-04-26 05:19:36', '2023-04-26 10:49:36'),
('45f8ecb3cfbe7ace457741d0cce69fae29e66eae02d53299f4c77e409db304287915a88f6b50b60b', 2, 1, 'login', '[]', 0, '2022-09-05 05:02:21', '2022-09-05 05:02:21', '2023-09-05 10:32:21'),
('477d6bce49fcb396e02f53237363aee09f2e0944fb692dab2e4127b911c0e0aa223f2a9e1f695b02', 1, 1, 'login', '[]', 0, '2022-11-26 05:19:35', '2022-11-26 05:19:35', '2023-11-26 10:49:35'),
('48b5a2fe4fd85a4af7c0a1057ddaf23db583a99851aa8be455cf8935c216f85183caa5405c816045', 1, 1, 'login', '[]', 0, '2022-08-31 04:57:38', '2022-08-31 04:57:38', '2023-08-31 10:27:38'),
('4b0160e0d50bd7022366141b19dd4fdc706cecfb16b5126bd09c3bb430b8ca026d189930a7a9bf76', 9, 1, 'login', '[]', 0, '2022-09-28 23:23:05', '2022-09-28 23:23:05', '2023-09-29 04:53:05'),
('4c80898a9f46f4996e291ec78f8930b410e0909037843c42c91b792fbc8b68555b5f38d74f578ff7', 3, 1, 'login', '[]', 0, '2022-07-06 13:40:19', '2022-07-06 13:40:19', '2023-07-06 19:10:19'),
('4cb880092db5196062d39ed323b57523d2c1968df20fb2891907964110b08a98a970a194676c4922', 2, 1, 'login', '[]', 0, '2022-09-26 11:20:22', '2022-09-26 11:20:22', '2023-09-26 16:50:22'),
('4e2997b0a46dfaca6dd49be89d14d45cbfecdb7fb3b8f50f7da1945899ec1507122d97d4fd774a4d', 2, 1, 'login', '[]', 0, '2022-09-07 12:43:58', '2022-09-07 12:43:58', '2023-09-07 18:13:58'),
('4f4d9d19a56a26e693d0c2acc16fe4c681fe34e49d5e5ef6645c314f533e9097aaba2e0b40335e56', 6, 1, 'login', '[]', 0, '2022-07-10 00:52:48', '2022-07-10 00:52:48', '2023-07-10 06:22:48'),
('5145994438d15cc7e181507bc23d22818fdff133b0b06b9fdf39b9554aca8e58c524154425645ae7', 5, 1, 'login', '[]', 0, '2022-09-05 07:17:29', '2022-09-05 07:17:29', '2023-09-05 12:47:29'),
('5232523fe0f5dc1c102812f270dd6a410919fc332f64d76329742e4807678aeded29221bbf50802b', 9, 1, 'login', '[]', 0, '2022-10-03 08:20:48', '2022-10-03 08:20:48', '2023-10-03 13:50:48'),
('5331dfab8c8c742063955f001219813cc2de2359387db2e63e68b618229829063f22f40ec39b4890', 3, 1, 'login', '[]', 0, '2022-11-12 07:16:05', '2022-11-12 07:16:05', '2023-11-12 12:46:05'),
('54a64f59406ae11bca7cab2b3cb31c7065a5c482b114ee5050efd77f2df13681da8d9875097147b4', 3, 1, 'login', '[]', 0, '2022-07-11 05:02:48', '2022-07-11 05:02:48', '2023-07-11 10:32:48'),
('55dbe99c390a8810acf16e83e269405618979577f4df77456e1f8233e7f8e98488e421c7767bef50', 9, 1, 'login', '[]', 0, '2022-12-18 21:23:22', '2022-12-18 21:23:22', '2023-12-19 02:53:22'),
('567e3da841a154d1fe332e27676696efd37577dde2e58b8e2a29f9c6b5d96dcac658b5a7b152aa81', 20, 1, 'login', '[]', 0, '2022-05-22 10:56:34', '2022-05-22 10:56:34', '2023-05-22 16:26:34'),
('56b9bad565601c9603cba0188cbe706d7843af4a109b6df8f315c2105009166d2ac39cccada10f61', 7, 1, 'login', '[]', 0, '2022-04-30 13:18:12', '2022-04-30 13:18:12', '2023-04-30 18:48:12'),
('57a4f91baf3e727e02f26547feeeb55690dd36b073120fabe67bf0d0fd8b5027a19e95e632568968', 5, 1, 'login', '[]', 0, '2022-10-03 08:01:41', '2022-10-03 08:01:41', '2023-10-03 13:31:41'),
('57dcbaeee73430e5f97ab0245a8e4b7571d62bd25590b6f8725cce40c0fab7f3eee8c52edb87d29c', 31, 1, 'login', '[]', 0, '2022-06-26 03:31:58', '2022-06-26 03:31:58', '2023-06-26 09:01:58'),
('583ca9395693a6ddaa6529ec996a7bfca1f14f0e3a77bcbbc37657ac07fef49c843e87cb64d7e5fa', 15, 1, 'login', '[]', 0, '2022-06-30 03:54:42', '2022-06-30 03:54:42', '2023-06-30 09:24:42'),
('584343435c08a7a1e6d86d16929506c4e7a2dc84d4b786a8c2c3f9e0111c254f375d888094c4d0b3', 10, 1, 'login', '[]', 0, '2022-11-28 12:21:02', '2022-11-28 12:21:02', '2023-11-28 17:51:02'),
('5b5b2113d30948ff96f2d75021c8c32f27ad836567208d1bc6f9562f51466837127ff8906de38898', 12, 1, 'login', '[]', 0, '2022-06-18 03:21:42', '2022-06-18 03:21:42', '2023-06-18 08:51:42'),
('5c6d7e51ef2f6c08f6045ba918fff7af75662de9f10e98cca968e49304903617538e64f9ffc3d331', 1, 1, 'login', '[]', 0, '2022-12-20 09:49:42', '2022-12-20 09:49:42', '2023-12-20 15:19:42'),
('5d4a4b54a06ce1507185a1f1b9833eda9cf3b377474df066e53c713c0aca582056cd17ef17fe6fa2', 2, 1, 'login', '[]', 0, '2022-12-18 03:55:16', '2022-12-18 03:55:16', '2023-12-18 09:25:16'),
('5e1083fc78ecf0a8086a604f00cf1072b22a742ba617d703bc699a5fd97a79e43479bda3833db5ce', 4, 1, 'login', '[]', 0, '2023-02-19 02:40:42', '2023-02-19 02:40:42', '2024-02-19 08:10:42'),
('5f0efe3ecc706635d42548c1189b37f76328528dc8adc804c6e6f3c8b61bed0b875b6cda20493dad', 2, 1, 'login', '[]', 0, '2022-11-27 02:59:00', '2022-11-27 02:59:00', '2023-11-27 08:29:00'),
('60ef30ed19177ee1c5ac352e1db5bab516c60b227224e0af28abfc56d82b397d6160f5ede74f39b6', 9, 1, 'login', '[]', 0, '2022-08-31 05:11:01', '2022-08-31 05:11:01', '2023-08-31 10:41:01'),
('60f883f5101b88e7f40b348548c958dc262f7532b1e69fb02437d80e542139762c850ce37319ffa7', 6, 1, 'login', '[]', 0, '2023-03-02 08:39:25', '2023-03-02 08:39:25', '2024-03-02 14:09:25'),
('61741bd335e0bca11e1ca7848450c1dd229a2a80bceb4ddb1d6de7af254000d106ac26a9de23df47', 2, 1, 'login', '[]', 0, '2022-07-15 07:32:55', '2022-07-15 07:32:55', '2023-07-15 13:02:55'),
('62fd3dac2645cad94addf046ee756e6e166808a198c69a2a8ea9bcb5ee5196047d3e2fb73fb9d185', 9, 1, 'login', '[]', 0, '2022-11-13 01:28:06', '2022-11-13 01:28:06', '2023-11-13 06:58:06'),
('6326dadd9f0b7aceaa510dac4f3a89d1e7a0fe0ccf6c66604d7fd6147696daaf51dd6ce3f2f3158b', 5, 1, 'login', '[]', 0, '2022-09-22 13:52:13', '2022-09-22 13:52:13', '2023-09-22 19:22:13'),
('636e9d30fad0e3d5494e6e0b180345a225470cdb1d11adbb994be37fd135ce41de71420b3dc9b8bc', 11, 1, 'login', '[]', 0, '2022-10-18 02:43:23', '2022-10-18 02:43:23', '2023-10-18 08:13:23'),
('639b37f446616bf26fee859e0e84529f262a55ebe27a0a0e2cbe1d6b1ec805b40a0991835f670c50', 5, 1, 'login', '[]', 0, '2022-11-06 13:00:44', '2022-11-06 13:00:44', '2023-11-06 18:30:44'),
('65b43eb23d7072288839668d2967ebdcc9d7f583416ad65d92810038c74996492d9bfcc182158277', 4, 1, 'login', '[]', 0, '2022-12-20 09:59:19', '2022-12-20 09:59:19', '2023-12-20 15:29:19'),
('67353fc0564ef9f3449171e825371da4bb5491fd1303c3044807b476fbec92d35fecff77f8f0fbef', 9, 1, 'login', '[]', 0, '2022-12-19 20:47:14', '2022-12-19 20:47:14', '2023-12-20 02:17:14'),
('68e707d436894c8fc5e8eed98dd3aec84aed522f31370657c49cd6891e267962117ebe6f2d7007f7', 14, 1, 'login', '[]', 0, '2022-11-27 02:42:25', '2022-11-27 02:42:25', '2023-11-27 08:12:25'),
('6987370f1a5e7c8d6071dc7570c9c107bba8facb0189116103808e1faccfacbe0603cee5d53091c1', 1, 1, 'login', '[]', 0, '2023-02-19 03:01:07', '2023-02-19 03:01:07', '2024-02-19 08:31:07'),
('69ed071369344899b6913f0c44ccd3ca2dddbcd0075fe42bedc1389db60f515ae1eda0f13646cae0', 5, 1, 'login', '[]', 0, '2022-12-25 02:42:36', '2022-12-25 02:42:36', '2023-12-25 08:12:36'),
('6ad32b7ddb303a80f3605fb20d33caeed13300b044e3d99ffdb253f16b3bc4c382982e87de51eaa2', 10, 1, 'login', '[]', 0, '2022-12-20 08:40:23', '2022-12-20 08:40:23', '2023-12-20 14:10:23'),
('6b17b6fa04af51c03c077dc8469d2d24669c634091e9475c2d5f3ea23ec0a82f24cd4f0957ddbaaa', 11, 1, 'login', '[]', 0, '2022-12-18 06:46:10', '2022-12-18 06:46:10', '2023-12-18 12:16:10'),
('6be8be69bbfa7a391bac9b811c28ce8fdcde8eca2a586a0af575c0287ade9e6e1a5858b1e8e9fbdc', 10, 1, 'login', '[]', 0, '2022-12-18 13:42:29', '2022-12-18 13:42:29', '2023-12-18 19:12:29'),
('6bf5c586e40667bf4c8e35d94dba28a5239ba0f52d2586ea4f7d1cbb664b2b0747e29f07914e5bd9', 10, 1, 'login', '[]', 0, '2022-12-20 08:44:28', '2022-12-20 08:44:28', '2023-12-20 14:14:28'),
('6c5f29a5af5c0e40e0d6e26af57d79aada065f7fb988b41d29b32b78bb36c8e1289e358d638c9008', 6, 1, 'login', '[]', 0, '2022-04-29 14:21:15', '2022-04-29 14:21:15', '2023-04-29 19:51:15'),
('6cb53320041185e4eddd03ed11f025a6c18eb7fce7965581a56c54389e9e25d38c95747629eedadf', 1, 1, 'login', '[]', 0, '2022-09-22 13:48:40', '2022-09-22 13:48:40', '2023-09-22 19:18:40'),
('6eec8240fc47b93e21a8a4eccc55ac6977de2bd0d69093828200cf66aeef77e57b55092b97da1105', 4, 1, 'login', '[]', 0, '2022-08-08 04:52:07', '2022-08-08 04:52:07', '2023-08-08 10:22:07'),
('6f633a2430cf9057b1fe2a9226f32e26cf0a5490f9e060c3fec63b10608415ad2c0bf1359b7691dd', 30, 1, 'login', '[]', 0, '2022-06-26 03:28:40', '2022-06-26 03:28:40', '2023-06-26 08:58:40'),
('6f8ac90d27fa8548ef01c275fff5d77c35e860fdc9e8014dc5bb2e693999575abfb5fa2728e8024f', 5, 1, 'login', '[]', 0, '2022-07-26 08:00:24', '2022-07-26 08:00:24', '2023-07-26 13:30:24'),
('710df5da6d864979281e269bb8855f99db12a781d87c0c4ea219188ef295d44d516831a699818c34', 4, 1, 'login', '[]', 0, '2022-10-03 08:06:49', '2022-10-03 08:06:49', '2023-10-03 13:36:49'),
('720c3ed97bc672a0e05b449cf055faee08b9d9806f00f2f8fe1e5ce9cf20d9b6a3d6ff33ea13d5b9', 8, 1, 'login', '[]', 0, '2022-04-30 02:04:49', '2022-04-30 02:04:49', '2023-04-30 07:34:49'),
('72d7abb530e868256f5b8214656a8be10bab1bb3df9313ac3aa374b92a1bd1437cfcc8bceeba361a', 3, 1, 'login', '[]', 0, '2023-03-02 08:38:52', '2023-03-02 08:38:52', '2024-03-02 14:08:52'),
('7433b56bb5c736daf8112752195b3bfc22ba907b9930d9f91d5ed2e12f4aeb96dc072280e2accf29', 12, 1, 'login', '[]', 0, '2022-05-02 06:21:16', '2022-05-02 06:21:16', '2023-05-02 11:51:16'),
('74382a87a834668f160e2f9f6d3836cc18d9f4119fca3bd8c53d4fc4a29a1d504ab098adb1ec14e1', 1, 1, 'login', '[]', 0, '2022-12-18 13:39:24', '2022-12-18 13:39:24', '2023-12-18 19:09:24'),
('78e1da92774c58baec9e8ca3ddaf6691c2a06698e18340f0af241f272bd880e2765d8d765362d126', 11, 1, 'login', '[]', 0, '2022-12-18 06:46:11', '2022-12-18 06:46:11', '2023-12-18 12:16:11'),
('796bc66303ab15668d3e1127daed029f82120290f4f99cf8a92a1d629b3d748d3a7b21d2365ddfed', 8, 1, 'login', '[]', 0, '2022-12-19 19:39:56', '2022-12-19 19:39:56', '2023-12-20 01:09:56'),
('79a5bf56aaeec5a2a8066d59da882658367b8620c94007ccf2a279a8a185ebf81e628b985c58d9b0', 3, 1, 'login', '[]', 0, '2022-11-12 07:16:06', '2022-11-12 07:16:06', '2023-11-12 12:46:06'),
('7c08b608fa9e5bac3037559bcb422b7d8a216ad30d2e63f2a3bb153aa971630f5c79f28f8fb99aa1', 7, 1, 'login', '[]', 0, '2022-04-30 08:27:10', '2022-04-30 08:27:10', '2023-04-30 13:57:10'),
('7c221e9d1d1452da184938bbc64a5512ddd68d005bbd9173a92916ff6822fbb7b2c5d265059fb83f', 10, 1, 'login', '[]', 0, '2023-02-18 07:18:46', '2023-02-18 07:18:46', '2024-02-18 12:48:46'),
('7f227003bd0c48aed6ee12768c40d57b0b7b4996e3b6440ff75eacf31da73e7feb7e4d7cf226665b', 4, 1, 'login', '[]', 0, '2022-08-18 07:45:18', '2022-08-18 07:45:18', '2023-08-18 13:15:18'),
('8030b9241255b621972aa34d7e0cea702782606b049e9fb74c4126bcfae0b9e8dac34b36a4b97118', 2, 1, 'login', '[]', 0, '2022-12-18 03:44:23', '2022-12-18 03:44:23', '2023-12-18 09:14:23'),
('8066e87531f10619831b4473fa4a2939e05c13a473c00c50149716cbec3cfa142cbb6e22fc5de23d', 29, 1, 'login', '[]', 0, '2022-06-26 03:05:33', '2022-06-26 03:05:33', '2023-06-26 08:35:33'),
('823f45759c7aeeab8517555e5769918379bc9d15ea459e3bc4a004be0443f6c23eca91ad63166cdd', 9, 1, 'login', '[]', 0, '2023-02-18 11:10:33', '2023-02-18 11:10:33', '2024-02-18 16:40:33'),
('85f50329ece0454b0fe56d1eb52a3b504f71f3b4e6e654e375e047550f102cdc4404918fcd096dbb', 4, 1, 'login', '[]', 0, '2022-08-10 04:29:32', '2022-08-10 04:29:32', '2023-08-10 09:59:32'),
('860cc63c207498dddf7ffa62f2cccf6de6172c7c27638962ae7be12fad1473476e25638cb50b7d28', 3, 1, 'login', '[]', 0, '2022-07-14 09:23:58', '2022-07-14 09:23:58', '2023-07-14 14:53:58'),
('8610a70a1831f8c4b9a189282b2748d1e65cb579e04193b110dd7d74aeec7ce0164ef4c4848e30a8', 4, 1, 'login', '[]', 0, '2023-02-18 14:38:55', '2023-02-18 14:38:55', '2024-02-18 20:08:55'),
('87284a25649636fb32850baf07796f0cdb4f1a9293ec2bcf8e52522314e85bca978171e363361fba', 12, 1, 'login', '[]', 0, '2022-05-02 05:02:36', '2022-05-02 05:02:36', '2023-05-02 10:32:36'),
('877af9989e903bc1736b1c44f0e2e4d16443cfdbc0f1ca77cf25a0ec6eda856d45140bc7162ae13f', 1, 1, 'login', '[]', 0, '2022-04-26 05:19:15', '2022-04-26 05:19:15', '2023-04-26 10:49:15'),
('8a45acec396115dcf1d4430cb97bf29a83c74c23413a3b6e6a24ee4e9cc3f2ad64b4bf17c85d6ff6', 9, 1, 'login', '[]', 0, '2022-08-28 09:22:55', '2022-08-28 09:22:55', '2023-08-28 14:52:55'),
('8b71855736ed437257c313f54851b9c9635cd6d2e27ef1f7c350aee6522dc7ef427f378c55fa2489', 3, 1, 'login', '[]', 0, '2022-12-19 20:20:21', '2022-12-19 20:20:21', '2023-12-20 01:50:21'),
('8f228fea6822858b5d95517471d01afe552ac84535e9f4ee9efaa2c40eff2a7219d1322760add68c', 7, 1, 'login', '[]', 0, '2022-04-30 01:27:22', '2022-04-30 01:27:22', '2023-04-30 06:57:22'),
('8fa5660c365d8f9f10e3a5a913237a8b53f364740e934bfa07add8951141b3426e4a9b8ed015fb86', 12, 1, 'login', '[]', 0, '2022-06-30 04:06:04', '2022-06-30 04:06:04', '2023-06-30 09:36:04'),
('90b0b95697cb14bea725a96f6f22007fe03733f663cd10e78401f21c71da9c65db36e554e0cf785f', 9, 1, 'login', '[]', 0, '2022-11-13 07:13:00', '2022-11-13 07:13:00', '2023-11-13 12:43:00'),
('9112742ff5fdc8dec2ff6c01684efd4e052936ebd2bd2a0dd74820f6a38fecc6993a809bdad810ea', 6, 1, 'login', '[]', 0, '2022-07-15 08:29:09', '2022-07-15 08:29:09', '2023-07-15 13:59:09'),
('92936deb08a068ca9b1daf561276dd4d484d49db3c65d056fe7ed1fb5baebee18650d8af5d0ab8f8', 1, 1, 'login', '[]', 0, '2022-08-07 07:44:31', '2022-08-07 07:44:31', '2023-08-07 13:14:31'),
('9315645e2bc66a09ccc3b2bffabfac7a81d4f0bd9e59a30531d45d5e1ad4bbcd31cfef840be982ff', 2, 1, 'login', '[]', 0, '2022-12-18 03:44:27', '2022-12-18 03:44:27', '2023-12-18 09:14:27'),
('954b2fb8f3d627ffe23717365ae4b1d3552f62786e8874a594bff9d7847c0f5c6819b80a68c68646', 5, 1, 'login', '[]', 0, '2022-11-30 11:15:35', '2022-11-30 11:15:35', '2023-11-30 16:45:35'),
('959d71a1619be70aaff1ab484341a91342aa7f40d80ac932dc5b431cd904474df33e0520ebfacafc', 2, 1, 'login', '[]', 0, '2022-07-10 12:00:49', '2022-07-10 12:00:49', '2023-07-10 17:30:49'),
('981cb9b9eed5f7e083043d09ff11fb567effdfd2c278f70ab098a1c43b7ed5cab68fd25037fb4e72', 4, 1, 'login', '[]', 0, '2022-09-28 22:57:40', '2022-09-28 22:57:40', '2023-09-29 04:27:40'),
('9b48d0b2aebb443bb4c753807e164bc26caadc54a339f6e8345c14529bc5869e85b3a67ab6d17a75', 3, 1, 'login', '[]', 0, '2022-07-11 05:02:55', '2022-07-11 05:02:55', '2023-07-11 10:32:55'),
('9c2e5ac03d07e741c754e8b271586c46448362657f68bb9308c83e7e53fefb4a3abd15bf0ae6ec47', 7, 1, 'login', '[]', 0, '2022-05-12 03:42:33', '2022-05-12 03:42:33', '2023-05-12 09:12:33'),
('9cd8152f8806e83c0920659bf300157ae6949be1c2944165222fc622d0ece505a1e2d83fd1a10dd3', 1, 1, 'login', '[]', 0, '2022-08-07 07:56:31', '2022-08-07 07:56:31', '2023-08-07 13:26:31'),
('9ea9fffdae2e50f825ce7dd6550cdfd1509d9af22b7d55af31a43c7ab8b02646cf081dd2333967b7', 5, 1, 'login', '[]', 0, '2022-09-28 23:29:09', '2022-09-28 23:29:09', '2023-09-29 04:59:09'),
('a0b7e58908486138eb6a5bf235c323da71544e5b2ad30a1de1d4ee0d377ed7766e9fe97498ae6236', 4, 1, 'login', '[]', 0, '2023-02-26 07:27:41', '2023-02-26 07:27:41', '2024-02-26 12:57:41'),
('a231c80d60c3ce5470da7334dee1bcef7c1bd6d969f5c136b7557cf45e71b94158c050530d7cb90b', 4, 1, 'login', '[]', 0, '2022-07-06 13:44:49', '2022-07-06 13:44:49', '2023-07-06 19:14:49'),
('a57274736e703ee0b0f42e3c08d42450f74b32fe07e1c95a14c9c68d9ad64fbadb642b652fe3f1c5', 1, 1, 'login', '[]', 0, '2022-12-25 01:40:54', '2022-12-25 01:40:54', '2023-12-25 07:10:54'),
('a6744fe66db43a3408186d2952aa60d1a622e0cf15181bb267616a57e719280178abf9e3344f66fa', 1, 1, 'login', '[]', 0, '2022-08-16 08:55:36', '2022-08-16 08:55:36', '2023-08-16 14:25:36'),
('a76cf534e5f0e7d6897dbe0ecc72abfa43f63f2fa4d8cace94aff9a58746fbadd755c5faad0453fc', 5, 1, 'login', '[]', 0, '2022-07-26 08:00:20', '2022-07-26 08:00:20', '2023-07-26 13:30:20'),
('a8d9fbdb13d29928f000547fa4775e0314b7a581559682fd4ab39da154189f4902ac64bd7459eb1e', 4, 1, 'login', '[]', 0, '2022-09-05 07:46:49', '2022-09-05 07:46:49', '2023-09-05 13:16:49'),
('a91487e2a61e1f384488da24e9a841cf357c6c966e6bd011e2ef903487824ea8136b0dc8e033f5cf', 2, 1, 'login', '[]', 0, '2022-11-27 05:00:34', '2022-11-27 05:00:34', '2023-11-27 10:30:34'),
('aa822875cbd0a2d59c139fdb05b0cda94a12d97ff98a1928dda7bac070d7119608737c743af89bcf', 1, 1, 'login', '[]', 0, '2022-08-18 07:28:35', '2022-08-18 07:28:35', '2023-08-18 12:58:35'),
('ab20fcf8c0f8882d74157c20b4eb849afe285f03b4b13713cb0005393cf4e3fd8531d094891154b0', 1, 1, 'login', '[]', 0, '2022-12-18 06:21:30', '2022-12-18 06:21:30', '2023-12-18 11:51:30'),
('ab517b09d849b44cb4e5b6ba14c7e892898da43b803b52517da3bc0d7448f78dbea25944735174c2', 4, 1, 'login', '[]', 0, '2022-08-15 06:20:57', '2022-08-15 06:20:57', '2023-08-15 11:50:57'),
('ab8a8539cc9bd64ca205620e080f0a51789b3c164886aec3197707e97cc788018133df4c3751bdab', 3, 1, 'login', '[]', 0, '2022-09-25 04:50:09', '2022-09-25 04:50:09', '2023-09-25 10:20:09'),
('aba0d597f7f296a4e13c110b16a90c655365878dfa9335f1dec7678b4ea6ad468b64bcfb6cb0f032', 2, 1, 'login', '[]', 0, '2022-08-15 05:45:39', '2022-08-15 05:45:39', '2023-08-15 11:15:39'),
('abd100caf6a8d2e3972c2c1ed317b649e5e6251fc2260b0cffc443a1096fdbf70e7509f98f7311a7', 2, 1, 'login', '[]', 0, '2022-08-18 07:29:09', '2022-08-18 07:29:09', '2023-08-18 12:59:09'),
('ac202ff58d0c1f856935d6049e59f88e9030013583320b8320adf4c9efd6e5857b4f3266688400d6', 5, 1, 'login', '[]', 0, '2022-07-19 15:14:58', '2022-07-19 15:14:58', '2023-07-19 20:44:58'),
('ac65d4a789a00b7c0eea75345427293f0f3babf59c0d5f85213cb28adf02549e65b01036f0f6f4b5', 4, 1, 'login', '[]', 0, '2022-12-20 08:52:22', '2022-12-20 08:52:22', '2023-12-20 14:22:22'),
('aecb8723de8164b1bcf24687bdfeea94baf2547da3f64a8bd07befaab0b52247fa244d174415f118', 4, 1, 'login', '[]', 0, '2022-12-03 04:23:33', '2022-12-03 04:23:33', '2023-12-03 09:53:33'),
('af52f760746b460dd21a82ae7e67f431990bbccf9fe1804cac9c1181053dce5eb73769610f41f1d8', 5, 1, 'login', '[]', 0, '2022-07-06 13:46:22', '2022-07-06 13:46:22', '2023-07-06 19:16:22'),
('b1c2f4415ccb3dafe60f009fc1d0da442226f51219c94be48a9ccb144f86d9a4247cae8cb007d15f', 2, 1, 'login', '[]', 0, '2022-07-11 07:32:06', '2022-07-11 07:32:06', '2023-07-11 13:02:06'),
('b2db141de2936cca1ddf590ab1e0513ecee35b42e2165c324ee2d3ff164d1d4673a9e872737007d0', 3, 1, 'login', '[]', 0, '2023-03-02 06:20:33', '2023-03-02 06:20:33', '2024-03-02 11:50:33'),
('b382156bd55eab910417bcc16b07c488d974f7a47da596f65c384103e9dedce976fcd4d3160da831', 20, 1, 'login', '[]', 0, '2022-05-22 10:24:49', '2022-05-22 10:24:49', '2023-05-22 15:54:49'),
('b4e925d324554b0c90b0c4b76fb27046d3a856377a906f0efa3eca9b8f536987226c3de36bc14aca', 14, 1, 'login', '[]', 0, '2022-05-02 06:13:06', '2022-05-02 06:13:06', '2023-05-02 11:43:06'),
('b600cb9ec50b6aa54cdfca849c6aef3afc227503d2b9702649a4a2053a1a69394a1c759d1a515272', 1, 1, 'login', '[]', 0, '2022-04-26 05:28:10', '2022-04-26 05:28:10', '2023-04-26 10:58:10'),
('b79c22096c776b6b90f0917e1c17fbb1df5da6a099c8b953d8695acd0521b94b03189ae0662fab3a', 5, 1, 'login', '[]', 0, '2022-12-20 09:40:46', '2022-12-20 09:40:46', '2023-12-20 15:10:46'),
('b97e99b7717fb510450a64b3da589f03f867525fa27cc72db8007944b5ba52cc5fecd7cb851be7f2', 5, 1, 'login', '[]', 0, '2022-11-28 11:41:39', '2022-11-28 11:41:39', '2023-11-28 17:11:39'),
('ba1d42a9bbe252814ccc2cc88da1a3022296261e315176198a050c36a5b6ba4183d16168cd965267', 3, 1, 'login', '[]', 0, '2022-07-14 09:24:01', '2022-07-14 09:24:01', '2023-07-14 14:54:01'),
('bc1874b59c5d6d1bcd7c523cb888cd1657ecabc7add6014db584de21a573350617d78531c9214468', 4, 1, 'login', '[]', 0, '2022-07-15 07:48:09', '2022-07-15 07:48:09', '2023-07-15 13:18:09'),
('bdb888baa52c7ed35918f65bc3c21f1e069e0dd446e8d161a04e751a8cef1c777f69c0a72f20c574', 10, 1, 'login', '[]', 0, '2022-05-02 08:16:03', '2022-05-02 08:16:03', '2023-05-02 13:46:03'),
('c087f9cb3658905e613b8234ace4cbf6e1791eec61fb2becf1d0d65bdc817be990e62b354d89bd25', 2, 1, 'login', '[]', 0, '2022-11-26 12:06:50', '2022-11-26 12:06:50', '2023-11-26 17:36:50'),
('c2a5d97786d86669c8c796531f892eed938671fcd4916f1d73b44704949a25548c3b127b399bafe3', 5, 1, 'login', '[]', 0, '2022-08-14 01:31:54', '2022-08-14 01:31:54', '2023-08-14 07:01:54'),
('c3b8c7cf76e184de4963b76ad274d9c2c43073084d00ae939d756a8436d6bd11a75d8b2e19199352', 5, 1, 'login', '[]', 0, '2023-02-18 11:43:18', '2023-02-18 11:43:18', '2024-02-18 17:13:18'),
('c460c3322c0ee8c8b25a13e9fdbb11e92c61e73367028c5b992945440fe81425b20123bd1305f5b4', 10, 1, 'login', '[]', 0, '2022-12-20 08:54:07', '2022-12-20 08:54:07', '2023-12-20 14:24:07'),
('c4667aad48016a156a6a7c160193b6813e35ee452c28a63413e4d05eff6242243dceead1adaf1503', 10, 1, 'login', '[]', 0, '2022-09-28 23:08:06', '2022-09-28 23:08:06', '2023-09-29 04:38:06'),
('c48d2103ed0772208d5bcae80cf4ebe865dae574e7103ff149bb21edacd7524999437b46763ec9c7', 10, 1, 'login', '[]', 0, '2022-05-01 22:49:14', '2022-05-01 22:49:14', '2023-05-02 04:19:14'),
('c5f7a4b14a2eed570ec3faa100780b912446bb9172d850bed9c3a6a5527db6bea6d1d2903c2fe109', 2, 1, 'login', '[]', 0, '2022-12-20 09:10:48', '2022-12-20 09:10:48', '2023-12-20 14:40:48'),
('c636617ebfc6c5a2b77e1f74f250025be2bca0e0ead7a1f65e6354db80c1e8de4cba395b2bf228c9', 6, 1, 'login', '[]', 0, '2022-09-28 22:31:51', '2022-09-28 22:31:51', '2023-09-29 04:01:51'),
('c66c38c63dc8bf45dfda7a2e84c9cab52ca2c82212c156e1a7a872d63aeb2a280ae09432f41a3aa4', 9, 1, 'login', '[]', 0, '2022-11-13 07:01:29', '2022-11-13 07:01:29', '2023-11-13 12:31:29'),
('c685431b82bcdb3e82275f4f89b61d1bee378474091813b982453a08afa7e912de78ba81d4095219', 1, 1, 'login', '[]', 0, '2022-09-28 23:47:18', '2022-09-28 23:47:18', '2023-09-29 05:17:18'),
('c69b96361aa44e009fdb9128f38ba3bd5f28563ae03cdc38bb5fbea3596a689b8c83224d7dd6f9ab', 1, 1, 'login', '[]', 0, '2022-11-08 07:49:27', '2022-11-08 07:49:27', '2023-11-08 13:19:27'),
('c71eb299d065570b7aaaa8b5308a4c570b62f8ae8d4f50cc69726efe26a51f11414d1c28203a0bd2', 10, 1, 'login', '[]', 0, '2023-02-19 02:54:06', '2023-02-19 02:54:06', '2024-02-19 08:24:06'),
('c85218ce0b6e131edf5b4e1f71edc0c3434e797b9dd727ed24f81c9017bfe5d4acd063d84b613f92', 2, 1, 'login', '[]', 0, '2022-11-06 21:29:08', '2022-11-06 21:29:08', '2023-11-07 02:59:08'),
('c85efb61be1d16cc866ffd014ce21d483a61049b3c196593af20a45ad2b7dd5766766c308a94b6ac', 4, 1, 'login', '[]', 0, '2022-09-25 02:31:47', '2022-09-25 02:31:47', '2023-09-25 08:01:47'),
('cceeac463dedf4bb8d3748ce7a107b37c62ce0121df0f6125e7dde9a7b209eee5f1d6b2024c06f41', 12, 1, 'login', '[]', 0, '2022-04-30 08:08:36', '2022-04-30 08:08:36', '2023-04-30 13:38:36'),
('ce2faa2ae61b96198dde037258b727328ee5b15447c5cb9d0fffc8a93d7ea6bc699dfd0da4beaea9', 4, 1, 'login', '[]', 0, '2022-07-19 02:37:35', '2022-07-19 02:37:35', '2023-07-19 08:07:35'),
('cea3229a386c6988540d9c9dcb49eab7f2fa8361c3f8494623e2d453575efdcb0f07a5941a9ac6de', 1, 1, 'login', '[]', 0, '2022-12-18 13:47:53', '2022-12-18 13:47:53', '2023-12-18 19:17:53'),
('cf713821ad2fd1b31af95fb9b5e6b68cba9a8e6cef9d8979b10b406bdf42fbac70f9bddb5206b957', 6, 1, 'login', '[]', 0, '2022-09-22 12:46:21', '2022-09-22 12:46:21', '2023-09-22 18:16:21'),
('d043664e3bea4a22283e3a0cc5830955cdc9b004bd34e14a602c717aba9101f8f1d2859dcba17b11', 4, 1, 'login', '[]', 0, '2022-09-24 02:41:43', '2022-09-24 02:41:43', '2023-09-24 08:11:43'),
('d10d26a554b6b5fddbf3b7f01b7df5ae81d99cea937d07bfb989625acf1e993ac381e92dd2855ddf', 10, 1, 'login', '[]', 0, '2022-05-02 04:50:09', '2022-05-02 04:50:09', '2023-05-02 10:20:09'),
('d1b4a0ea24d4804356695fff1d1fe91195c0f9d1c973a7ce2961a1022be68c6fc49d787f927d0830', 3, 1, 'login', '[]', 0, '2023-02-19 03:56:28', '2023-02-19 03:56:28', '2024-02-19 09:26:28'),
('d48e005cd6b2708cb9cc796b730f1ae6f5c99c76f6bb7daa1290f89217fcd353c609e95d52ba1b91', 1, 1, 'login', '[]', 0, '2022-08-14 11:36:29', '2022-08-14 11:36:29', '2023-08-14 17:06:29'),
('d867bd8e0f09e8ec4231ecf4d373cdaf51d67e40b44ad002f7ac7cb7d9fac4066c8750a8849c0c73', 6, 1, 'login', '[]', 0, '2022-07-06 13:47:08', '2022-07-06 13:47:08', '2023-07-06 19:17:08'),
('d9efd20f68cfb995f0abfd05de9d8811f215f9cc43e1a2938cdfdba2ee5851c0f115d62da172eee9', 2, 1, 'login', '[]', 0, '2022-07-20 02:37:23', '2022-07-20 02:37:23', '2023-07-20 08:07:23'),
('d9fbd2e21d9a2fd86f3fdf059b5e833c80b00c62f4862b858bb356d7c867170186d2fb68752bea72', 7, 1, 'login', '[]', 0, '2022-05-02 08:13:34', '2022-05-02 08:13:34', '2023-05-02 13:43:34'),
('d9ff26e55e5e77b485fabafa314f45df8e06b1273cb0b641b5f159ebb58b4e507421cc08b15d6e86', 9, 1, 'login', '[]', 0, '2022-12-20 08:58:52', '2022-12-20 08:58:52', '2023-12-20 14:28:52'),
('da48b9e0d5f7f4db65fa1d8719875137c3a9c250b5d09d86bae860c7302f41e94a17e82bd6752c3d', 2, 1, 'login', '[]', 0, '2022-07-06 13:33:52', '2022-07-06 13:33:52', '2023-07-06 19:03:52'),
('dc2a8b4698b1183d2c7d13329d1401e527996a50682b12db32743884574f5a4ab722aa7d2e611534', 14, 1, 'login', '[]', 0, '2022-11-27 02:56:33', '2022-11-27 02:56:33', '2023-11-27 08:26:33'),
('dc31e06c136c27180b89613ca1f212a59e796b011fb992f7559e81eb8c2813ff263dafd1b63997f5', 10, 1, 'login', '[]', 0, '2022-12-03 12:10:25', '2022-12-03 12:10:25', '2023-12-03 17:40:25'),
('df8e5b12271a040de53e82cb405621e2500c7c20e60faa4e41140995eca23e8cca2e6a2c534303e3', 2, 1, 'login', '[]', 0, '2022-09-26 11:20:23', '2022-09-26 11:20:23', '2023-09-26 16:50:23'),
('dfd0df4b530d866a08a5a9abe66342ab4500975333b830b69d4cc80617846e178dfbff21554a2c70', 3, 1, 'login', '[]', 0, '2022-09-05 08:19:19', '2022-09-05 08:19:19', '2023-09-05 13:49:19'),
('e1ffd711ea981aed2d915885052438d0a177727f772bcc818e9a50659f0d163b8bf90b310ff704c5', 1, 1, 'login', '[]', 0, '2023-03-02 08:43:05', '2023-03-02 08:43:05', '2024-03-02 14:13:05'),
('e27e881b3de890659588bc585130cf96e44541346419c896364e805a732673c1833e789329dee3f3', 15, 1, 'login', '[]', 0, '2022-05-02 07:51:32', '2022-05-02 07:51:32', '2023-05-02 13:21:32'),
('e281a10d365a96cec89d5c917bbdd56b09e48b467f531190970c5ea46391daadab686263e25b45a2', 10, 1, 'login', '[]', 0, '2022-12-20 08:40:22', '2022-12-20 08:40:22', '2023-12-20 14:10:22'),
('e2cc25a9627beed10675c762f9570eb2524a37bbd0a882e68a746fae182e89f9b58fbcf30ff25c18', 3, 1, 'login', '[]', 0, '2022-07-24 06:35:41', '2022-07-24 06:35:41', '2023-07-24 12:05:41'),
('e51b06aa925e5f95491af8bfeabbdec85d9c9c296d044bf0c1f6f1f5bc18ed9fb5d0fe8e767621ad', 4, 1, 'login', '[]', 0, '2022-12-25 03:24:09', '2022-12-25 03:24:09', '2023-12-25 08:54:09'),
('e5655c2dd7d501ac25a86bc8f6a531a32ffbe70c7a0821afca95392c7122c0fda7732994eec720f9', 6, 1, 'login', '[]', 0, '2022-04-29 14:20:51', '2022-04-29 14:20:51', '2023-04-29 19:50:51'),
('e68567e23ac7eca73399171ac0c6c02a0fdf47ada6330576949f6a65d61e82d1aae0193ba494e7ee', 6, 1, 'login', '[]', 0, '2022-07-24 08:44:13', '2022-07-24 08:44:13', '2023-07-24 14:14:13'),
('e70b65e61cac3750deb29eda15113b7e055616470e8faf723f09aa0ff48668d0bfe98bc31998a19c', 5, 1, 'login', '[]', 0, '2022-08-15 06:20:18', '2022-08-15 06:20:18', '2023-08-15 11:50:18'),
('e7340f49eeb42c1b562c1e45077c80055a39c5ca95b5d9ff77239e221e3aefd65dca1750c67dec70', 10, 1, 'login', '[]', 0, '2022-04-30 06:43:06', '2022-04-30 06:43:06', '2023-04-30 12:13:06'),
('e7ea727d9c7ddbd14a7f92c8ef5815ddfcbc70f84f4c48460b1eb620b65beb3796f341012439c22a', 27, 1, 'login', '[]', 0, '2022-06-30 04:01:29', '2022-06-30 04:01:29', '2023-06-30 09:31:29'),
('e8be2ab1f12826c8ec289655df52a2ced30c48ddf6ce5cceed0f7d8247269157269dff26cf4880c4', 1, 1, 'login', '[]', 0, '2023-03-22 12:31:58', '2023-03-22 12:31:58', '2024-03-22 18:01:58'),
('eb4ae6f6214ff3b8f434a6fa9a1f684515f64358833f38317c97b01e6d455f67b518a62cd838410c', 7, 1, 'login', '[]', 0, '2022-05-01 12:22:06', '2022-05-01 12:22:06', '2023-05-01 17:52:06'),
('ed0a11c211625cf5b12911c11e2712501e33dac1dc5ae461bcfbf96099f4180eff6549e6e3bc0445', 5, 1, 'login', '[]', 0, '2023-02-19 02:54:38', '2023-02-19 02:54:38', '2024-02-19 08:24:38'),
('ed243cc717718f158bcd65bea0f714ac1f00d909f06f1da6ef4bacbe9121cfe4dd9d1b213710a5a8', 11, 1, 'login', '[]', 0, '2022-12-20 08:41:35', '2022-12-20 08:41:35', '2023-12-20 14:11:35'),
('eee8330681abcfdd145d6dafcf0c7b05c4dfad2f3177a1476d56edad760c6a5b6a459d75f7f9cfd9', 3, 1, 'login', '[]', 0, '2022-10-03 08:14:04', '2022-10-03 08:14:04', '2023-10-03 13:44:04'),
('eeeb73ca7e549bcca8bb26c03c283f57d203b51257d28dfb0c5b8bb7b518a4815d64e63caea78121', 6, 1, 'login', '[]', 0, '2022-10-03 07:58:02', '2022-10-03 07:58:02', '2023-10-03 13:28:02'),
('f1c06f97b6253880928a9d7ab254e5fce30b7ff51bcb8dd52741522e37bf97552e006d1d801a5b91', 4, 1, 'login', '[]', 0, '2022-11-08 09:13:58', '2022-11-08 09:13:58', '2023-11-08 14:43:58'),
('f2d439063420c123ea058edf5abc128abda94f55bab32be0cb5e5b91523916d59fb5250b291df8de', 5, 1, 'login', '[]', 0, '2022-08-07 08:11:57', '2022-08-07 08:11:57', '2023-08-07 13:41:57'),
('f2f9ac846c1b5ba0ce97e4f0670a7eb0fc8a37cb4fd735b306e1574f16ae77795732a3cfa416ffce', 20, 1, 'login', '[]', 0, '2022-06-30 04:10:09', '2022-06-30 04:10:09', '2023-06-30 09:40:09'),
('f36d79288258342ffa557dc17fd2d2e5c64c3de63b8f3bbc088b2a56013b92f665b33bfeb878e729', 3, 1, 'login', '[]', 0, '2022-09-28 22:09:00', '2022-09-28 22:09:00', '2023-09-29 03:39:00'),
('f48bbad0e9aa99ce098e23df2a701471f38e63c5797bab1d6abfd2f6724bed974935c584891a4abc', 6, 1, 'login', '[]', 0, '2022-08-18 07:47:42', '2022-08-18 07:47:42', '2023-08-18 13:17:42'),
('fa2c3a02bde2b09bcdeeddd9a6cc764e5b578f2ebf0aa3094eb85e33c2b10ee19217744adefebdc2', 2, 1, 'login', '[]', 0, '2022-10-03 07:33:47', '2022-10-03 07:33:47', '2023-10-03 13:03:47'),
('fbdc45479b7acafb78cc922c0fbb5f30a9ab45bc76fcb6b365d9168e8ec2151639dc57dc15a45c70', 2, 1, 'login', '[]', 0, '2022-11-08 08:13:17', '2022-11-08 08:13:17', '2023-11-08 13:43:17'),
('fc77e5c386f1209ebf8e01de9374ffcffb466802ddee2babcf286c2fed30faccd90c71dafaeab431', 5, 1, 'login', '[]', 0, '2022-12-20 09:51:19', '2022-12-20 09:51:19', '2023-12-20 15:21:19'),
('fe02f497ab3d7a3feb77edebcae8b3122727e2e104adfe66d917dbaa44d4cfffbdac37cce5df9188', 5, 1, 'login', '[]', 0, '2022-08-15 01:10:19', '2022-08-15 01:10:19', '2023-08-15 06:40:19'),
('fe413522942478115608463efaafd2e6d65f7225c18613b981044419bdfa99321e97ec5873395404', 2, 1, 'login', '[]', 0, '2022-07-31 04:15:40', '2022-07-31 04:15:40', '2023-07-31 09:45:40');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'BvzuCExdNiPAwnkqLVI1PSBhcU4xeWwyUAv5lw9M', NULL, 'http://localhost', 1, 0, 0, '2022-04-26 05:00:43', '2022-04-26 05:00:43'),
(2, NULL, 'Laravel Password Grant Client', 'n090E3Wx7nHWHAcz1rjtQb48t9glouGqrhZexAvt', 'users', 'http://localhost', 0, 1, 0, '2022-04-26 05:00:44', '2022-04-26 05:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-04-26 05:00:44', '2022-04-26 05:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Doctor','Hospital','User','Pharmacy','Lab','Bloodbank','Nursing','Dealer','Ambulance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `uid`, `otp`, `type`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '19', '463912', 'User', '0', NULL, NULL),
(2, '20', '123456', 'Pharmacy', '0', NULL, NULL),
(3, '23', '123456', 'Pharmacy', '0', NULL, NULL),
(4, '24', '123456', 'Pharmacy', '0', NULL, NULL),
(5, '28', '123456', 'Lab', '0', NULL, NULL),
(6, '29', '123456', 'Bloodbank', '0', NULL, NULL),
(7, '30', '123456', 'Bloodbank', '0', NULL, NULL),
(8, '31', '123456', 'Bloodbank', '0', NULL, NULL),
(9, '27', '123456', 'Lab', '0', NULL, NULL),
(10, '12', '123456', 'Hospital', '0', NULL, NULL),
(11, '1', '123456', 'User', '0', NULL, NULL),
(12, '2', '123456', 'Doctor', '0', NULL, NULL),
(13, '3', '123456', 'Hospital', '0', NULL, NULL),
(14, '4', '123456', 'Pharmacy', '0', NULL, NULL),
(15, '5', '123456', 'Lab', '0', NULL, NULL),
(16, '6', '123456', 'Bloodbank', '0', NULL, NULL),
(17, '9', '123456', 'Nursing', '0', NULL, NULL),
(18, '10', '123456', 'Dealer', '0', NULL, NULL),
(19, '11', '123456', 'Ambulance', '0', NULL, NULL),
(20, '12', '123456', 'User', '0', NULL, NULL),
(21, '14', '123456', 'User', '0', NULL, NULL),
(22, '8', '123456', 'Doctor', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_lists`
--

CREATE TABLE `patient_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_reports` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_consent` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_relationship` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_relationship_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consent_with_proof` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_complaints_w_t_duration` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dietary_habits` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_menstrual_period` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_pregnancy_abortion` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vaccination_in_children` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `residence` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pulse` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_p` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `temprature` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blood_suger_fasting` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blood_suger_random` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `history_of_previous_diseases` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `history_of_allergies` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `history_of_previous_surgeries_or_procedures` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `significant_family_history` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `history_of_substance_abuse` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_lists`
--

INSERT INTO `patient_lists` (`id`, `user_id`, `name`, `image`, `dob`, `gender`, `p_reports`, `id_proof`, `is_consent`, `c_relationship`, `c_relationship_proof`, `consent_with_proof`, `current_complaints_w_t_duration`, `marital_status`, `religion`, `occupation`, `dietary_habits`, `last_menstrual_period`, `previous_pregnancy_abortion`, `vaccination_in_children`, `residence`, `height`, `weight`, `pulse`, `b_p`, `temprature`, `blood_suger_fasting`, `blood_suger_random`, `history_of_previous_diseases`, `history_of_allergies`, `history_of_previous_surgeries_or_procedures`, `significant_family_history`, `history_of_substance_abuse`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 1, 'Deepak Chahar', '', '2022-08-03', 'Male', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '2022-08-02 13:39:33', '2022-08-02 13:39:33'),
(3, 1, 'New Mmber', '', '2022-08-05', 'Female', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '2022-08-04 12:46:08', '2022-08-04 12:46:08'),
(4, 1, 'Dcn22', '', '2022-09-30', 'Female', 'd-854631664566930.jpeg', '', 'Yes', 'none', 'd-643401664566930.jpeg', 'd-573241664566930.jpeg', 'n', 'Married', 'Hindu', 'oc', 'Nonvegetarian', 'lmc', 'dsdas\ndasdasdas\ndadas', 'fdfsdf\nfsdfsdfsd', 'rch', '10', 'w', 'p', 'bp', 'bt', '1', '2', '3232\n3232', 'da\nDADa', 'xAXAx\nxaXaCSCCS', 'xaxAX\nXAxa', 'KLKLKL', '0', '2022-09-30 14:12:10', '2022-09-30 22:02:55'),
(5, 2, 'Patient', '', '2022-11-07', 'Female', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '2022-11-06 13:27:03', '2022-11-06 13:27:03'),
(6, 4, 'AJAY 2', '', '2022-12-20', 'Male', '', '', 'false', '', '', '', 'Complaints', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '2022-12-19 20:00:13', '2022-12-19 20:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_paid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_due` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_date` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `amount_paid`, `amount_due`, `currency`, `receipt`, `status`, `attempts`, `entity`, `notes`, `response`, `post_date`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'order_K2kQoQ4qAN7SH4', '100', '100', '0', 'INR', 'rcptid_165987633211', 'paid', '1', 'order', '', '', '', '0', '2022-08-07 07:15:33', '2022-08-07 07:16:15'),
(2, 'order_K2kYd8qTRvTEGb', '100', '100', '0', 'INR', 'rcptid_165987677662', 'paid', '1', 'order', '', '', '', '0', '2022-08-07 07:22:57', '2022-08-07 07:23:25'),
(3, 'order_K2qXM3wy1CJWoQ', '90', '90', '0', 'INR', 'rcptid_165989783340', 'paid', '1', 'order', '', '', '', '0', '2022-08-07 13:13:54', '2022-08-07 13:16:13'),
(4, 'order_K2qgue9zPMRQB4', '290', '290', '0', 'INR', 'rcptid_165989837689', 'paid', '1', 'order', '', '', '', '0', '2022-08-07 13:22:57', '2022-08-07 13:23:34'),
(5, 'order_K2riV1NL2qqI01', '123', '123', '0', 'INR', 'rcptid_165990198827', 'paid', '1', 'order', '', '', '', '0', '2022-08-07 14:23:08', '2022-08-07 14:23:37'),
(6, 'order_K3FaTGrrxc6Pps', '5370', '5370', '0', 'INR', 'rcptid_165998605023', 'paid', '1', 'order', '', '', '', '0', '2022-08-08 13:44:11', '2022-08-08 13:44:46'),
(7, 'order_K3Ff1HWnIGzPwo', '5370', '5370', '0', 'INR', 'rcptid_165998630939', 'paid', '1', 'order', '', '', '', '0', '2022-08-08 13:48:29', '2022-08-08 13:49:00'),
(8, 'order_K4exBhgOm6CK6q', '109000', '0', '109000', 'INR', 'rcptid_166029372252', 'created', '0', 'order', '', '', '', '0', '2022-08-12 03:12:05', '2022-08-12 03:12:05'),
(9, 'order_K57ZTHAKRXFsOf', '1090', '1090', '0', 'INR', 'rcptid_166039450325', 'paid', '1', 'order', '', '', '', '0', '2022-08-13 07:11:45', '2022-08-13 07:12:22'),
(10, 'order_K57i3Dc8me7yFw', '1090', '1090', '0', 'INR', 'rcptid_166039499226', 'paid', '1', 'order', '', '', '', '0', '2022-08-13 07:19:52', '2022-08-13 07:20:21'),
(11, 'order_K5DQ8kPF5yg9Oy', '100', '100', '0', 'INR', 'rcptid_166041510262', 'paid', '1', 'order', '', '', '', '0', '2022-08-13 12:55:05', '2022-08-13 12:55:57'),
(12, 'order_K5DRotP0BYWWk3', '100', '100', '0', 'INR', 'rcptid_166041519967', 'paid', '1', 'order', '', '', '', '0', '2022-08-13 12:56:40', '2022-08-13 12:58:31'),
(13, 'order_K5EVTMi5FRK1GX', '10000', '0', '10000', 'INR', 'AP-166041892790', 'created', '0', 'order', '', '', '', '0', '2022-08-13 13:58:49', '2022-08-13 13:58:49'),
(14, 'order_K5EZttaM4hFnDc', '100', '100', '0', 'INR', 'AP-166041918077', 'paid', '1', 'order', '', '', '', '0', '2022-08-13 14:03:01', '2022-08-13 14:03:38'),
(15, 'order_K5SWPVZqQkzhJK', '100', '100', '0', 'INR', 'AP-166046828355', 'paid', '1', 'order', '', '', '', '0', '2022-08-14 03:41:25', '2022-08-14 03:41:55'),
(16, 'order_K5qk4NNlmWLDyb', '1080', '1080', '0', 'INR', 'AP-166055357879', 'paid', '1', 'order', '', '', '', '0', '2022-08-15 03:23:00', '2022-08-15 03:23:34'),
(17, 'order_K76cceAF3MlARL', '200', '200', '0', 'INR', 'AP-166082784399', 'paid', '1', 'order', '', '', '', '0', '2022-08-18 07:34:05', '2022-08-18 07:34:53'),
(18, 'order_K76uLkvM1kC0lT', '2180', '2180', '0', 'INR', 'AP-166082885145', 'paid', '1', 'order', '', '', '', '0', '2022-08-18 07:50:52', '2022-08-18 07:51:23'),
(19, 'order_KCBvAB6OMoMOVQ', '396', '396', '0', 'INR', 'AP-166193821519', 'paid', '1', 'order', '', '', '', '0', '2022-08-31 04:00:16', '2022-08-31 04:01:01'),
(20, 'order_KCBxJIR0Xh3HV2', '600', '600', '0', 'INR', 'AP-166193833817', 'paid', '1', 'order', '', '', '', '0', '2022-08-31 04:02:18', '2022-08-31 04:02:59'),
(21, 'order_KCC0tSgRCd4B89', '300', '300', '0', 'INR', 'AP-166193854118', 'paid', '1', 'order', '', '', '', '0', '2022-08-31 04:05:42', '2022-08-31 04:06:17'),
(22, 'order_KCL8NP50ATyqgh', '300', '300', '0', 'INR', 'AP-166197066024', 'paid', '1', 'order', '', '', '', '0', '2022-08-31 13:01:01', '2022-08-31 13:01:58'),
(23, 'order_KCa2eplVOKNcit', '200', '200', '0', 'INR', 'AP-166202316185', 'paid', '1', 'order', '', '', '', '0', '2022-09-01 03:36:02', '2022-09-01 03:36:51'),
(24, 'order_KM2UVh6BVjcZCS', '4160', '4160', '0', 'INR', 'AP-166408839262', 'paid', '2', 'order', '', '', '', '0', '2022-09-25 01:16:35', '2022-09-25 01:17:34'),
(25, 'order_KM4EAzn8pMi8Q3', '127000', '0', '127000', 'INR', 'AP-166409450778', 'created', '0', 'order', '', '', '', '0', '2022-09-25 02:58:30', '2022-09-25 02:58:30'),
(26, 'order_KM5nJ4UsLF9ZyG', '1082', '1082', '0', 'INR', 'AP-166410002557', 'paid', '1', 'order', '', '', '', '0', '2022-09-25 04:30:27', '2022-09-25 04:31:13'),
(27, 'order_KcrNQ67J3Ea8XU', '100', '100', '0', 'INR', 'AP-166776102983', 'paid', '1', 'order', '', '', '', '0', '2022-11-06 13:27:11', '2022-11-06 13:27:39'),
(28, 'order_KczoUOE6KsPmaU', '10000', '0', '10000', 'INR', 'AP-166779074081', 'created', '0', 'order', '', '', '', '0', '2022-11-06 21:42:21', '2022-11-06 21:42:21'),
(29, 'order_KczpGRbSTZogi6', '10000', '0', '10000', 'INR', 'AP-166779078498', 'created', '0', 'order', '', '', '', '0', '2022-11-06 21:43:05', '2022-11-06 21:43:05'),
(30, 'order_KczptuwY73YpXS', '10000', '0', '10000', 'INR', 'AP-166779082055', 'created', '0', 'order', '', '', '', '0', '2022-11-06 21:43:41', '2022-11-06 21:43:41'),
(31, 'order_KdYhfoUQfi5snZ', '100', '100', '0', 'INR', 'AP-166791361013', 'paid', '1', 'order', '', '', '', '0', '2022-11-08 07:50:12', '2022-11-08 07:50:40'),
(32, 'order_KdZ96eUTaJlJFA', '20', '20', '0', 'INR', 'AP-166791516925', 'paid', '1', 'order', '', '', '', '0', '2022-11-08 08:16:10', '2022-11-08 08:16:44'),
(33, 'order_Kda5Y7wHgVCk8R', '182', '182', '0', 'INR', 'AP-166791848942', 'paid', '1', 'order', '', '', '', '0', '2022-11-08 09:11:29', '2022-11-08 09:12:02'),
(34, 'order_KfXxNoNXgLzuzr', '100000', '0', '100000', 'INR', 'AP-166834766187', 'created', '0', 'order', '', '', '', '0', '2022-11-13 08:24:23', '2022-11-13 08:24:23'),
(35, 'order_KfY0pSSErYo08u', '30000', '0', '30000', 'INR', 'AP-166834785757', 'created', '0', 'order', '', '', '', '0', '2022-11-13 08:27:38', '2022-11-13 08:27:38'),
(36, 'order_KtTF7iWs6k07Zg', '270', '270', '0', 'INR', 'AP-167138782234', 'paid', '1', 'order', '', '', '', '0', '2022-12-18 12:53:42', '2022-12-18 12:54:30'),
(37, 'order_KtULbOe7bZCtUZ', '50000', '0', '50000', 'INR', 'AP-167139171145', 'created', '0', 'order', '', '', '', '0', '2022-12-18 13:58:32', '2022-12-18 13:58:32'),
(38, 'order_KtULwSL3zqPXD2', '19000', '0', '19000', 'INR', 'AP-167139173066', 'created', '0', 'order', '', '', '', '0', '2022-12-18 13:58:51', '2022-12-18 13:58:51'),
(39, 'order_KtUM6O6nnov0YB', '37000', '0', '37000', 'INR', 'AP-167139174084', 'created', '0', 'order', '', '', '', '0', '2022-12-18 13:59:00', '2022-12-18 13:59:00'),
(40, 'order_KtUXbRQ0w3sEnm', '15600', '0', '15600', 'INR', 'AP-167139239392', 'created', '0', 'order', '', '', '', '0', '2022-12-18 14:09:53', '2022-12-18 14:09:53'),
(41, 'order_Kw3QCu7lmx1wlL', '500.7', '500.7', '0', 'INR', 'AP-167195191012', 'paid', '1', 'order', '', '', '', '0', '2022-12-25 01:35:11', '2022-12-25 01:35:48'),
(42, 'order_Kw3XKW7IgjNrL9', '500.7', '500.7', '0', 'INR', 'AP-167195231536', 'paid', '1', 'order', '', '', '', '0', '2022-12-25 01:41:56', '2022-12-25 01:42:36'),
(43, 'order_LI1m84yLHTSqbC', '1100', '1100', '0', 'INR', 'AP-167674960091', 'paid', '1', 'order', '', '', '', '0', '2023-02-18 14:16:41', '2023-02-18 14:18:36'),
(44, 'order_LI239tugdxP3Qc', '110000', '0', '110000', 'INR', 'AP-167675056694', 'created', '0', 'order', '', '', '', '0', '2023-02-18 14:32:48', '2023-02-18 14:32:48'),
(45, 'order_LI24h8z21Slzqz', '1100', '1100', '0', 'INR', 'AP-167675065588', 'paid', '1', 'order', '', '', '', '0', '2023-02-18 14:34:15', '2023-02-18 14:35:24'),
(46, 'order_LIFRdVsCQvpCui', '19000', '0', '19000', 'INR', 'AP-167679773922', 'created', '0', 'order', '', '', '', '0', '2023-02-19 03:39:01', '2023-02-19 03:39:01'),
(47, 'order_LIFXePnUSdr4O8', '180', '180', '0', 'INR', 'AP-167679808147', 'paid', '1', 'order', '', '', '', '0', '2023-02-19 03:44:42', '2023-02-19 03:45:31'),
(48, 'order_LLYQuxQExT1eGA', '111000', '0', '111000', 'INR', 'AP-167751962276', 'created', '0', 'order', '', '', '', '0', '2023-02-27 12:10:23', '2023-02-27 12:10:23'),
(49, 'order_LLYsHDTQMJ9HJh', '111000', '0', '111000', 'INR', 'AP-167752117717', 'created', '0', 'order', '', '', '', '0', '2023-02-27 12:36:17', '2023-02-27 12:36:17'),
(50, 'order_LLYtGDnmhiG31h', '1110', '1110', '0', 'INR', 'AP-167752123285', 'paid', '1', 'order', '', '', '', '0', '2023-02-27 12:37:13', '2023-02-27 12:37:57'),
(51, 'order_LLZ8gQ6O8VkRo1', '1110', '1110', '0', 'INR', 'AP-167752210936', 'paid', '1', 'order', '', '', '', '0', '2023-02-27 12:51:49', '2023-02-27 12:52:26'),
(52, 'order_LMhDKt9QicQStZ', '120', '120', '0', 'INR', 'AP-167776888698', 'paid', '1', 'order', '', '', '', '0', '2023-03-02 09:24:46', '2023-03-02 09:27:13'),
(53, 'order_LRsk21gQGMaZNE', '120', '120', '0', 'INR', 'AP-167890118143', 'paid', '1', 'order', '', '', '', '0', '2023-03-15 11:56:22', '2023-03-15 11:57:00'),
(54, 'order_LTSScHoFpq62LX', '280', '280', '0', 'INR', 'AP-167924531032', 'paid', '1', 'order', '', '', '', '0', '2023-03-19 11:31:51', '2023-03-19 11:32:29'),
(55, 'order_LTSdmrL9PonFzp', '390', '390', '0', 'INR', 'AP-167924594437', 'paid', '1', 'order', '', '', '', '0', '2023-03-19 11:42:26', '2023-03-19 11:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacies`
--

CREATE TABLE `pharmacies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pharmacist_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pharmacist_regis_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pharmacist_regis_upload` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstin` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstin_certificate` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drug_liscence_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drug_liscence_file` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drug_liscence_valid_upto` date DEFAULT NULL,
  `cp_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_on_bank` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `micr_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_cheque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacies`
--

INSERT INTO `pharmacies` (`id`, `name`, `hospital_id`, `owner_name`, `owner_id`, `partner_name`, `partner_id`, `pharmacist_name`, `pharmacist_regis_no`, `pharmacist_regis_upload`, `gstin`, `gstin_certificate`, `email`, `mobile`, `fax`, `address`, `city`, `pincode`, `country`, `latitude`, `longitude`, `password`, `image`, `banner_image`, `drug_liscence_number`, `drug_liscence_file`, `drug_liscence_valid_upto`, `cp_name`, `name_on_bank`, `bank_name`, `branch_name`, `ifsc`, `ac_no`, `ac_type`, `micr_code`, `pan_no`, `cancel_cheque`, `pan_image`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Pharmasy Name', NULL, 'owner name', 'd-852851664014765.gif', 'partner name', 'd-277571664014765.jpeg', 'pharmacist', 'regis no', 'd-618821664014765.jpeg', 'Registration details', 'd-305241664014765.jpeg', 'pharmasy@gmail.com', '7858483838', '', 'Sikanderpur Metro (HYB), A Block, DLF Phase 1, Sector 28, Gurugram, Haryana 122002, India', 'Gurugram', '122002', 'India', '28.481398696233562', '77.09357421540528', '$2y$10$zPaalc3HymF792CdpgO19OEA/0QnR8Bb95VJPNNYf9LVciG8HChoS', 'd-934771658260855.jpeg', '', '31e2e3qd', 'd-15981658260855.png', '2022-07-16', '', 'CITY', 'bank', 'branch', 'CEO', 'Deepak Chahar', 'current', 'qsqs', 'qsws', 'd-357881658263247.png', 'd-231741658263247.png', '', '0', '2022-07-06 13:44:26', '2022-12-20 08:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacists`
--

CREATE TABLE `pharmacists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacists`
--

INSERT INTO `pharmacists` (`id`, `name`, `hospital_id`, `email`, `mobile`, `address`, `city`, `pincode`, `country`, `latitude`, `longitude`, `password`, `image`, `banner_image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'aon@gmail.com', 2, 'aon@gmail.com', '08744769656', 'JM43 5GR, Bhatti Gate, Jhajjar, Jhajjar, Haryana 124103, India', 'Jhajjar', '124103', 'India', '28.6054875', '76.6537749', '123456', 'logo - Copy.png', 'iotafactor2.png', '0', '2022-04-17 12:20:20', '2022-09-28 22:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `pincode_maps`
--

CREATE TABLE `pincode_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `json_info` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pincode_maps`
--

INSERT INTO `pincode_maps` (`id`, `pincode`, `lat`, `lng`, `address`, `json_info`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '122006', '28.4813712', '76.9931074', 'Tikampur, Haryana 122006, India', '{\n   \"results\" : [\n      {\n         \"address_components\" : [\n            {\n               \"long_name\" : \"122006\",\n               \"short_name\" : \"122006\",\n               \"types\" : [ \"postal_code\" ]\n            },\n            {\n               \"long_name\" : \"Tikampur\",\n               \"short_name\" : \"Tikampur\",\n               \"types\" : [ \"locality\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"Gurgaon\",\n               \"short_name\" : \"Gurgaon\",\n               \"types\" : [ \"administrative_area_level_2\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"Haryana\",\n               \"short_name\" : \"HR\",\n               \"types\" : [ \"administrative_area_level_1\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"India\",\n               \"short_name\" : \"IN\",\n               \"types\" : [ \"country\", \"political\" ]\n            }\n         ],\n         \"formatted_address\" : \"Tikampur, Haryana 122006, India\",\n         \"geometry\" : {\n            \"bounds\" : {\n               \"northeast\" : {\n                  \"lat\" : 28.5071194,\n                  \"lng\" : 77.0232702\n               },\n               \"southwest\" : {\n                  \"lat\" : 28.4574089,\n                  \"lng\" : 76.9618861\n               }\n            },\n            \"location\" : {\n               \"lat\" : 28.4813712,\n               \"lng\" : 76.99310740000001\n            },\n            \"location_type\" : \"APPROXIMATE\",\n            \"viewport\" : {\n               \"northeast\" : {\n                  \"lat\" : 28.5071194,\n                  \"lng\" : 77.0232702\n               },\n               \"southwest\" : {\n                  \"lat\" : 28.4574089,\n                  \"lng\" : 76.9618861\n               }\n            }\n         },\n         \"place_id\" : \"ChIJX7uyv6EWDTkRPo7iQG2ra_4\",\n         \"postcode_localities\" : [\n            \"Ashok Vihar Phase II\",\n            \"Ashok Vihar Phase- 1\",\n            \"Babupur Village\",\n            \"Block I\",\n            \"Daulatabad\",\n            \"Gurgaon Rural\",\n            \"Kherki Majra\",\n            \"Mohammad Heri Village\",\n            \"Pawala Khasrupur\",\n            \"Sector 101\",\n            \"Sector 102\",\n            \"Sector 103\",\n            \"Sector 104\",\n            \"Sector 105\",\n            \"Sector 106\",\n            \"Sector 107\",\n            \"Sector 3\",\n            \"Sector 5\",\n            \"Sector 9B\",\n            \"Tikampur\",\n            \"Tikampur Village\"\n         ],\n         \"types\" : [ \"postal_code\" ]\n      }\n   ],\n   \"status\" : \"OK\"\n}\n', '0', '2022-09-03 21:35:50', '2022-09-03 21:35:50'),
(2, 'V6Z 2E7', '49.2830255', '-123.1228227', 'Vancouver, BC V6Z 2E7, Canada', '{\n   \"results\" : [\n      {\n         \"address_components\" : [\n            {\n               \"long_name\" : \"V6Z 2E7\",\n               \"short_name\" : \"V6Z 2E7\",\n               \"types\" : [ \"postal_code\" ]\n            },\n            {\n               \"long_name\" : \"Central Vancouver\",\n               \"short_name\" : \"Central Vancouver\",\n               \"types\" : [ \"neighborhood\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"Vancouver\",\n               \"short_name\" : \"Vancouver\",\n               \"types\" : [ \"locality\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"Metro Vancouver\",\n               \"short_name\" : \"Metro Vancouver\",\n               \"types\" : [ \"administrative_area_level_2\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"British Columbia\",\n               \"short_name\" : \"BC\",\n               \"types\" : [ \"administrative_area_level_1\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"Canada\",\n               \"short_name\" : \"CA\",\n               \"types\" : [ \"country\", \"political\" ]\n            }\n         ],\n         \"formatted_address\" : \"Vancouver, BC V6Z 2E7, Canada\",\n         \"geometry\" : {\n            \"bounds\" : {\n               \"northeast\" : {\n                  \"lat\" : 49.283282,\n                  \"lng\" : -123.1217879\n               },\n               \"southwest\" : {\n                  \"lat\" : 49.2825334,\n                  \"lng\" : -123.123186\n               }\n            },\n            \"location\" : {\n               \"lat\" : 49.28302550000001,\n               \"lng\" : -123.1228227\n            },\n            \"location_type\" : \"APPROXIMATE\",\n            \"viewport\" : {\n               \"northeast\" : {\n                  \"lat\" : 49.28425668029151,\n                  \"lng\" : -123.1211379697085\n               },\n               \"southwest\" : {\n                  \"lat\" : 49.28155871970851,\n                  \"lng\" : -123.1238359302915\n               }\n            }\n         },\n         \"place_id\" : \"ChIJ38b7JoBxhlQRUwjVSoBC4eM\",\n         \"types\" : [ \"postal_code\" ]\n      }\n   ],\n   \"status\" : \"OK\"\n}\n', '0', '2022-09-03 22:01:28', '2022-09-03 22:01:28'),
(3, '122001', '28.4554726', '77.0219019', 'Sector 9, Gurugram, Haryana 122001, India', '{\n   \"results\" : [\n      {\n         \"address_components\" : [\n            {\n               \"long_name\" : \"122001\",\n               \"short_name\" : \"122001\",\n               \"types\" : [ \"postal_code\" ]\n            },\n            {\n               \"long_name\" : \"Sector 9\",\n               \"short_name\" : \"Sector 9\",\n               \"types\" : [ \"political\", \"sublocality\", \"sublocality_level_1\" ]\n            },\n            {\n               \"long_name\" : \"Gurugram\",\n               \"short_name\" : \"Gurugram\",\n               \"types\" : [ \"locality\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"Gurgaon\",\n               \"short_name\" : \"Gurgaon\",\n               \"types\" : [ \"administrative_area_level_2\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"Haryana\",\n               \"short_name\" : \"HR\",\n               \"types\" : [ \"administrative_area_level_1\", \"political\" ]\n            },\n            {\n               \"long_name\" : \"India\",\n               \"short_name\" : \"IN\",\n               \"types\" : [ \"country\", \"political\" ]\n            }\n         ],\n         \"formatted_address\" : \"Sector 9, Gurugram, Haryana 122001, India\",\n         \"geometry\" : {\n            \"bounds\" : {\n               \"northeast\" : {\n                  \"lat\" : 28.4890902,\n                  \"lng\" : 77.06629959999999\n               },\n               \"southwest\" : {\n                  \"lat\" : 28.4011715,\n                  \"lng\" : 76.9598127\n               }\n            },\n            \"location\" : {\n               \"lat\" : 28.4554726,\n               \"lng\" : 77.0219019\n            },\n            \"location_type\" : \"APPROXIMATE\",\n            \"viewport\" : {\n               \"northeast\" : {\n                  \"lat\" : 28.4890902,\n                  \"lng\" : 77.06629959999999\n               },\n               \"southwest\" : {\n                  \"lat\" : 28.4011715,\n                  \"lng\" : 76.9598127\n               }\n            }\n         },\n         \"place_id\" : \"ChIJm523QqkZDTkR06eT1PrbRxM\",\n         \"postcode_localities\" : [\n            \"Ashok Vihar Phase II\",\n            \"Ashok Vihar Phase- 1\",\n            \"Civil Lines\",\n            \"Gopalpur\",\n            \"Gurgaon Rural\",\n            \"Inayatpur\",\n            \"Patel Nagar\",\n            \"Police Lines\",\n            \"Roshan Pura\",\n            \"Sector 10\",\n            \"Sector 100\",\n            \"Sector 101\",\n            \"Sector 10A\",\n            \"Sector 11\",\n            \"Sector 12\",\n            \"Sector 13\",\n            \"Sector 14\",\n            \"Sector 15\",\n            \"Sector 17\",\n            \"Sector 29\",\n            \"Sector 30\",\n            \"Sector 31\",\n            \"Sector 32\",\n            \"Sector 33\",\n            \"Sector 34\",\n            \"Sector 37\",\n            \"Sector 37C\",\n            \"Sector 37D\",\n            \"Sector 38\",\n            \"Sector 39\",\n            \"Sector 3A\",\n            \"Sector 4\",\n            \"Sector 40\",\n            \"Sector 41\",\n            \"Sector 45\",\n            \"Sector 48\",\n            \"Sector 5\",\n            \"Sector 6\",\n            \"Sector 7\",\n            \"Sector 72\",\n            \"Sector 8\",\n            \"Sector 9\",\n            \"Sector 99\",\n            \"Sector 9B\"\n         ],\n         \"types\" : [ \"postal_code\" ]\n      }\n   ],\n   \"status\" : \"OK\"\n}\n', '0', '2022-09-05 05:28:56', '2022-09-05 05:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `p_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mrp` double(8,2) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `product_id`, `p_name`, `mrp`, `discount`, `description`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Name', 1100.00, 10.00, '25 test', '0', '2022-05-22 03:33:38', '2022-07-19 07:07:28'),
(2, 1, '', 100.00, 10.00, '50 test', '0', '2022-05-22 04:20:30', '2022-07-15 08:21:56'),
(3, 2, '', 300.00, 20.00, 'Descripion', '0', '2022-05-22 04:55:18', '2022-05-22 04:55:18'),
(4, 4, 'Variant name', 100.00, 10.00, '500ml', '0', '2022-05-24 10:08:22', '2022-08-15 03:36:26'),
(5, 4, '', 1000.00, 10.00, '500', '0', '2022-05-24 10:10:03', '2022-05-24 10:10:03'),
(6, 4, '', 10009.00, 10.00, '500ml', '0', '2022-05-24 10:12:06', '2022-05-24 10:20:08'),
(7, 4, '', 6000.00, 10.00, '500ml', '0', '2022-05-24 10:18:15', '2022-05-24 10:18:15'),
(8, 4, '', 5454.00, 55.00, '500ml', '0', '2022-05-24 10:19:53', '2022-05-24 10:19:53'),
(9, 5, 'Variant name', 1000.00, 100.00, 'Specification', '0', '2022-08-10 05:49:49', '2022-08-10 05:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `procedures`
--

CREATE TABLE `procedures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 Not Delete 1 Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `procedures`
--

INSERT INTO `procedures` (`id`, `name`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Bone Marrow Transplant (BMT)', '1', '0', '2022-04-17 01:59:02', '2022-09-25 14:07:01'),
(2, 'Kidney Transplant', '0', '0', '2022-04-24 12:33:33', '2022-04-24 12:33:33'),
(3, 'Thoracic Surgery', '0', '0', '2022-04-24 12:33:46', '2022-04-24 12:33:46'),
(4, 'Bariatric Surgery', '0', '0', '2022-04-24 12:33:57', '2022-04-24 12:33:57'),
(5, 'Knee Replacement Surgery', '0', '0', '2022-04-24 12:34:14', '2022-04-24 12:34:14'),
(6, 'HIPEC Treatment', '0', '0', '2022-04-24 12:34:29', '2022-04-24 12:34:29'),
(7, 'proc', '0', '0', '2022-09-25 13:56:11', '2022-09-25 13:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `strength` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mrp` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `pharmacy_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `formulation_id` int(11) NOT NULL,
  `avaliblity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_2` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_3` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_4` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_month` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manufacturer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manufacturer_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prescription_required` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `variant_name`, `strength`, `mrp`, `discount`, `pharmacy_id`, `category_id`, `sub_category_id`, `formulation_id`, `avaliblity`, `brand_name`, `image`, `image_2`, `image_3`, `image_4`, `salt_name`, `expiry_type`, `expiry_month`, `expiry_year`, `title`, `description`, `manufacturer_name`, `manufacturer_address`, `prescription_required`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '', 'vRIANT', 'Specification', 200, 10, 1, 2, 1, 1, 'No', 'brand', 'd-191391677426478.jpeg', 'd-250211676752000.jpeg', 'd-44221676752000.jpeg', 'd-408911676752000.jpeg', 'salt', 'after', 'Jan', '2023', 'Equinox 1 Personal Weighing Scale-Digital EQ-EB-9300', '<p>desccription</p>', 'Manufacturer', '886, Near sector 106, Gurugram', 'Yes', 'equinox-1-personal-weighing-scale-digital-eq-eb-9300', '0', '2022-05-21 09:10:00', '2023-02-26 10:17:58'),
(2, '', 'variant', 'specifiacation', 100, 10, 1, 1, 2, 0, '', '', 'd-141681664022323.gif', '', '', '', '', '', '', '', 'Equinox 2 Personal Weighing Scale-Digital EQ-EB-9300', 'Description', 'Manufacturer', '886, Near sector 106, Gurugram', 'Yes', 'equinox-2-personal-weighing-scale-digital-eq-eb-9300', '0', '2022-05-22 04:55:18', '2022-05-22 04:55:18'),
(4, '', 'varrient', 'specification', 1000, 100, 1, 2, 1, 2, '', 'brand', 'd-141681664022323.gif', '', '', '', 'salt', '', '', '', 'title', '<p>desc</p>', 'Company', 'address', 'Yes', 'title', '0', '2022-05-24 06:30:41', '2022-06-29 03:48:31'),
(5, '', 'vari', 'spec', 10, 1, 1, 2, 4, 2, 'Yes', 'null', 'd-141681664022323.gif', '', '', '', 'Salt', '', '', '', 'Product name', '<p>desc</p>', 'Company', '', 'Yes', 'product-name', '0', '2022-08-10 05:48:29', '2022-08-10 05:48:29'),
(8, '', 'vari abv', 'spec', 10, 1, 1, 2, 4, 2, 'Yes', 'null', 'd-141681664022323.gif', '', '', '', 'Salt', '', '', '', 'Product name variant', '<p>desc</p>', 'Company', '', 'Yes', 'product-name-vv', '0', '2022-08-10 05:48:29', '2022-08-10 05:48:29'),
(9, '', 'vRIANT', 'Specification', 200, 10, 1, 2, NULL, 1, 'No', 'brand', 'd-191391677426478.jpeg', 'd-250211676752000.jpeg', 'd-44221676752000.jpeg', 'd-408911676752000.jpeg', 'salt', 'after', 'Jan', '2023', 'Equinox 1 Personal Weighing Scale-Digital EQ-EB-9300', '<p>desccription</p>', 'Manufacturer', '886, Near sector 106, Gurugram', 'Yes', 'equinox-1-personal-weighing-scale-digital-eq-eb-9300-1', '0', '2023-02-26 13:15:15', '2023-02-26 13:15:15');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `file_name`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'p-249741658224583.png', '0', '2022-05-21 23:08:34', '2022-07-19 04:26:23'),
(2, 1, '16532056501.output-onlinepngtools.png', '0', '2022-05-21 23:13:41', '2022-05-22 02:17:30'),
(3, 1, '1653194622.p1.jpg', '0', '2022-05-21 23:13:42', '2022-05-21 23:13:42'),
(4, 2, 'p-441691659954249.png', '0', '2022-05-22 04:55:18', '2022-08-08 04:54:09'),
(5, 4, 'p-672841653418861.jpeg', '0', '2022-05-24 13:26:24', '2022-05-24 13:31:01'),
(6, 4, 'p-695681653418847.jpeg', '0', '2022-05-24 13:30:34', '2022-05-24 13:30:47'),
(7, 1, 'p-402591658224559.png', '0', '2022-07-19 04:25:59', '2022-07-19 04:25:59'),
(8, 5, 'p-925911660130358.jpeg', '0', '2022-08-10 05:49:18', '2022-08-10 05:49:18');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stars` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `customer_id`, `user_id`, `service_id`, `type`, `stars`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1', 'Appointments', 3, 'hello', '2023-03-23 12:31:42', '2023-03-23 13:20:32'),
(2, 1, 1, '1', 'Labtest', 3, 'review', '2023-03-24 11:21:20', '2023-03-24 11:21:20'),
(5, 1, 1, '3', 'Medicine', 3, '', '2023-03-24 12:21:05', '2023-03-24 12:24:10'),
(6, 1, 1, 'order_LMhDKt9QicQStZ', 'Treatment', 3, '', '2023-03-24 13:06:54', '2023-03-24 13:06:54'),
(7, 1, 1, '1', 'Homecare', 3, '', '2023-03-24 13:12:55', '2023-03-24 13:12:55'),
(8, 1, 1, '2', 'Equipment', 3, '', '2023-03-24 13:20:41', '2023-03-24 13:20:41'),
(9, 1, 1, '6', 'Bloodbank', 3, '', '2023-03-24 13:26:20', '2023-03-24 13:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `service_payments`
--

CREATE TABLE `service_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `price_4` int(11) NOT NULL,
  `discount_4` int(11) NOT NULL,
  `price_6` int(11) NOT NULL,
  `discount_6` int(11) NOT NULL,
  `price_12` int(11) NOT NULL,
  `discount_12` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_payments`
--

INSERT INTO `service_payments` (`id`, `title`, `price`, `discount`, `price_4`, `discount_4`, `price_6`, `discount_6`, `price_12`, `discount_12`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Listing charges', 200, 22, 300, 20, 430, 43, 444, 54, '2023-03-18 10:21:06', '2023-03-18 10:21:37'),
(2, 'Hospital Listing Charges', 1000, 20, 300, 20, 430, 43, 444, 54, '2023-03-18 10:22:40', '2023-03-18 10:22:40'),
(3, 'Pharmacy Listing', 1000, 32, 300, 20, 430, 43, 444, 54, '2023-03-18 10:24:32', '2023-03-18 10:24:32'),
(4, 'Lab Listing', 1700, 32, 300, 20, 430, 43, 444, 54, '2023-03-18 10:24:55', '2023-03-18 10:24:55'),
(5, 'Bloodbank Listing', 1700, 32, 300, 20, 430, 43, 444, 54, '2023-03-18 10:25:10', '2023-03-18 10:25:10'),
(6, 'Homecare Buero Listing', 1700, 32, 300, 20, 430, 43, 444, 54, '2023-03-18 10:25:24', '2023-03-18 10:25:24'),
(7, 'Homecare Indipendent Listing', 1700, 32, 300, 20, 430, 43, 444, 54, '2023-03-18 10:25:38', '2023-03-18 10:25:38'),
(8, 'Dealer (Homecare equipment) Listing', 1700, 32, 300, 20, 430, 43, 444, 54, '2023-03-18 10:27:57', '2023-03-18 10:27:57'),
(9, 'Ambulance Listing', 1700, 32, 300, 20, 430, 43, 444, 54, '2023-03-18 10:28:24', '2023-03-18 10:28:24'),
(10, 'Dr. Treatment Package Listing', 1700, 32, 0, 0, 0, 0, 0, 0, '2023-03-18 10:32:37', '2023-03-18 10:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `service_payment_histories`
--

CREATE TABLE `service_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `from_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `for_count` int(11) NOT NULL,
  `order_id` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_payment_histories`
--

INSERT INTO `service_payment_histories` (`id`, `user_id`, `service_id`, `from_date`, `end_date`, `for_count`, `order_id`, `payment_id`, `created_at`, `updated_at`) VALUES
(2, 2, 1, '2023-03-19', '2024-03-13', 360, '0', 55, '2023-03-19 11:43:36', '2023-03-19 11:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `specialities`
--

CREATE TABLE `specialities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `specialization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `speciality_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 Not Delete 1 Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specialities`
--

INSERT INTO `specialities` (`id`, `specialization_id`, `speciality_name`, `image`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'Anaesthesiology', '1650823671.jpg', '1', '0', '2022-04-17 01:57:08', '2022-09-15 13:56:02'),
(2, 2, 'Anaesthesiology 2', '1650823671.jpg', '0', '0', '2022-04-17 01:57:08', '2022-04-24 12:37:51'),
(3, 1, 'Spacility 3', '1663270000.jpg', '1', '0', '2022-09-15 13:56:41', '2022-09-15 13:56:41'),
(5, 1, 'sp', '', '0', '0', '2022-09-21 13:58:44', '2022-09-21 13:58:44'),
(7, NULL, 'spc', '', '0', '0', '2022-09-25 13:55:19', '2022-09-25 13:55:19'),
(8, NULL, 'spc', '', '0', '0', '2022-09-25 13:56:10', '2022-09-25 13:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 Not Delete 1 Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `type`, `degree`, `is_approved`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'UG', 'Bachelor of Science', '1', '0', '2022-04-17 01:54:51', '2022-09-14 15:00:35'),
(2, 'UG', 'Bachelor of Science in Genetics', '1', '0', '2022-04-17 01:56:04', '2022-10-03 07:45:37'),
(3, 'PG', 'Doctor of Medicine (MD)', '0', '0', '2022-04-24 12:26:18', '2022-04-24 12:26:50'),
(4, 'UG', 'BDS – Bachelor of Dental Surgery', '0', '0', '2022-04-25 06:45:50', '2022-04-25 06:45:50'),
(5, 'UG', 'DOC', '0', '0', '2022-09-14 15:01:30', '2022-09-14 15:01:30'),
(6, 'UG', 'NEW', '1', '0', '2022-09-14 15:03:32', '2022-09-14 15:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `title`, `image`, `description`, `slug`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'Baby Sub Cat', '1650960346.png', 'Desc', 'baby-sub-cat-1', '0', '2022-04-16 04:16:28', '2022-05-21 08:41:03'),
(2, 1, 'Subcategory 2', '1650960357.png', 'Description', 'subcategory-2-1', '0', '2022-04-17 02:16:31', '2022-04-26 02:35:57'),
(3, 1, 'Sub 3', '1650960368.png', 'desc', 'sub-3-1', '0', '2022-04-17 02:17:16', '2022-04-26 02:36:22'),
(4, 1, 'Health Sub', '1653142165.webp', 'desc', 'health-sub', '0', '2022-05-21 08:39:25', '2022-05-21 08:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`id`, `name`, `email`, `mobile`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@gmail.com', '1234567890', '$2y$10$UdRMtE4bMEFjvp.wHYrvkuJvb6Zy2Lprf6fY658/oqiwuFNxkj62W', '2022-04-15 11:30:09', '2022-04-15 11:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `symptoms_lists`
--

CREATE TABLE `symptoms_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `symptoms_lists`
--

INSERT INTO `symptoms_lists` (`id`, `title`, `created_at`, `updated_at`, `is_approved`, `is_deleted`) VALUES
(1, 'Symptoms 1', NULL, NULL, '0', '0'),
(2, 'Symptoms 2', NULL, NULL, '0', '0'),
(3, 's2', '2022-09-21 13:53:21', '2022-09-21 13:53:21', '0', '0'),
(4, 's3', '2022-09-21 13:53:21', '2022-09-22 11:46:37', '0', '1'),
(5, 'syn', '2022-09-21 13:58:44', '2022-09-22 11:46:49', '1', '0'),
(6, 's3', '2022-09-21 13:58:44', '2022-09-22 11:46:32', '0', '1'),
(7, 'snew', '2022-09-22 11:47:01', '2022-09-22 11:47:01', '1', '0'),
(8, 's4', '2023-03-02 09:19:19', '2023-03-02 09:19:19', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slot_interval` int(11) NOT NULL,
  `shift1_start_at` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift1_end_at` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift2_start_at` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift2_end_at` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`id`, `doctor_id`, `day`, `slot_interval`, `shift1_start_at`, `shift1_end_at`, `shift2_start_at`, `shift2_end_at`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 7, 'Monday', 10, '06:36', '11:36', '14:37', '18:37', '0', '2022-05-12 07:39:12', '2022-05-12 12:04:47'),
(2, 7, 'Wednesday', 5, '06:36', '11:36', '06:37', '06:37', '0', '2022-05-12 07:39:12', '2022-05-12 08:30:00'),
(3, 15, 'Monday', 20, '14:56', '14:59', '15:57', '14:01', '0', '2022-06-30 03:57:10', '2022-06-30 03:57:10'),
(4, 15, 'Tuesday', 20, '14:56', '14:59', '15:57', '14:01', '0', '2022-06-30 03:57:10', '2022-06-30 03:57:10'),
(5, 15, 'Wednesday', 20, '14:56', '14:59', '15:57', '14:01', '0', '2022-06-30 03:57:10', '2022-06-30 03:57:10'),
(6, 15, 'Thursday', 20, '14:56', '14:59', '15:57', '14:01', '0', '2022-06-30 03:57:10', '2022-06-30 03:57:10'),
(7, 2, 'Monday', 20, '19:03', '22:04', '12:04', '20:04', '0', '2022-07-11 08:04:20', '2022-07-11 08:04:20'),
(8, 2, 'Tuesday', 20, '19:03', '22:04', '12:04', '20:04', '0', '2022-07-11 08:04:20', '2022-07-11 08:04:20'),
(9, 2, 'Wednesday', 20, '19:03', '22:04', '12:04', '20:04', '0', '2022-07-11 08:04:20', '2022-07-11 08:04:20'),
(10, 2, 'Thursday', 20, '19:03', '22:04', '12:04', '20:04', '0', '2022-07-11 08:04:20', '2022-07-11 08:04:20'),
(11, 2, 'Friday', 20, '19:03', '22:04', '12:04', '20:04', '0', '2022-07-11 08:04:21', '2022-07-11 08:04:21'),
(12, 2, 'Saturday', 20, '19:03', '22:04', '12:04', '20:04', '0', '2022-07-11 08:04:21', '2022-07-11 08:04:21'),
(13, 8, 'Monday', 10, '06:47', '12:47', '', '', '0', '2022-12-19 19:48:54', '2022-12-19 19:48:54'),
(14, 8, 'Tuesday', 10, '06:47', '12:47', '', '', '0', '2022-12-19 19:48:54', '2022-12-19 19:48:54'),
(15, 8, 'Wednesday', 10, '06:47', '12:47', '', '', '0', '2022-12-19 19:48:54', '2022-12-19 19:48:54'),
(16, 8, 'Thursday', 10, '06:47', '12:47', '', '', '0', '2022-12-19 19:48:54', '2022-12-19 19:48:54'),
(17, 8, 'Friday', 10, '06:47', '12:47', '', '', '0', '2022-12-19 19:48:54', '2022-12-19 19:48:54'),
(18, 8, 'Saturday', 10, '06:47', '12:47', '', '', '0', '2022-12-19 19:48:54', '2022-12-19 19:48:54'),
(19, 2, 'Monday', 5, '20:14', '20:14', '20:15', '20:15', '0', '2022-12-20 09:14:18', '2022-12-20 09:15:24'),
(20, 2, 'Tuesday', 5, '20:14', '20:14', '', '', '0', '2022-12-20 09:14:18', '2022-12-20 09:14:18'),
(21, 2, 'Wednesday', 5, '20:14', '20:14', '', '', '0', '2022-12-20 09:14:18', '2022-12-20 09:14:18'),
(22, 2, 'Thursday', 5, '20:14', '20:14', '', '', '0', '2022-12-20 09:14:18', '2022-12-20 09:14:18'),
(23, 2, 'Friday', 5, '20:14', '20:14', '', '', '0', '2022-12-20 09:14:18', '2022-12-20 09:14:18'),
(24, 2, 'Saturday', 5, '20:14', '20:14', '', '', '0', '2022-12-20 09:14:18', '2022-12-20 09:14:18'),
(25, 2, 'Sunday', 5, '20:14', '20:14', '', '', '0', '2022-12-20 09:14:18', '2022-12-20 09:14:18'),
(26, 2, 'Monday', 20, '20:16', '20:18', '20:21', '20:22', '0', '2022-12-20 09:17:02', '2022-12-20 09:17:02');

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `speciality_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `illness` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stay_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charges_in_rs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_in_rs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charges_in_doller` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_in_doller` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 not inactive 1 active',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treatments`
--

INSERT INTO `treatments` (`id`, `uid`, `doctor_id`, `hospital_id`, `speciality_id`, `illness`, `package_name`, `package_location`, `hospital_name`, `hospital_address`, `stay_type`, `charges_in_rs`, `discount_in_rs`, `charges_in_doller`, `discount_in_doller`, `details`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 0, '1', '1', 'Package Name', 'Clinic', 'Hospital Name', 'Hospital Address', 'PREMIUM SUITE', '122', '2', '311', '2', '<p><strong>Package Includes :</strong></p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p><strong>Package Excludes :</strong></p><p>&nbsp;</p><p>&nbsp;</p>', '1', '0', '2022-07-10 14:18:31', '2022-10-13 12:27:07'),
(3, 3, 1, 1, '1', '2', 'Package 1', 'Clinic', '', '', 'SINGLE ROOM / ONE PATIENT IN ONE ROOM', '1000', '10', '', '', '<p><strong>Package Includes :</strong></p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p><strong>Package Excludes :</strong></p><p>&nbsp;</p><p>&nbsp;</p>', '1', '0', '2023-02-19 07:12:10', '2023-02-19 07:12:10'),
(4, 2, 1, 0, '1', '1', 'New pack', 'Clinic', '', '', 'Daycare ward', '1000', '10', '', '', '<p><strong>Package Includes :</strong></p><p>everything</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p><strong>Package Excludes :</strong></p><p>&nbsp;</p><p>&nbsp;</p>', '1', '0', '2023-03-02 09:23:35', '2023-03-02 09:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_and_surgery_lists`
--

CREATE TABLE `treatment_and_surgery_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treatment_and_surgery_lists`
--

INSERT INTO `treatment_and_surgery_lists` (`id`, `title`, `created_at`, `updated_at`, `is_approved`, `is_deleted`) VALUES
(1, 'Treatment 1', NULL, NULL, '0', '0'),
(2, 'Treatment 2', NULL, NULL, '0', '0'),
(3, 'tt', '2022-09-21 13:53:20', '2022-09-22 11:47:21', '0', '1'),
(4, 'Surgery', '2022-09-21 13:53:20', '2022-09-22 11:47:36', '1', '0'),
(5, 'tt', '2022-09-21 13:58:43', '2022-09-22 11:47:17', '0', '1'),
(6, 'tt3', '2022-09-21 13:58:43', '2022-09-22 11:47:13', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('User','Doctor','Hospital','Hospitalstaff','Pharmacy','Lab','Bloodbank','Nursing','Dealer','Ambulance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `my_referal` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joined_from` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not verified 1 verified',
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 not deleted 1 deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `name`, `email`, `mobile`, `type`, `password`, `my_referal`, `joined_from`, `is_verified`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dr Deepak', 'user@gmail.com', '8447469656', 'User', '$2y$10$erb8fEKok79ST3lkzSn7RumTzzqaPcdR9TG3gt6QGTTC/KaRVz5sq', 'REF0002', '', '1', '1', '0', '2022-07-06 12:53:44', '2023-03-02 09:12:47'),
(2, 1, 'Doctor', 'doctor@gmail.com', '8786858483', 'Doctor', '$2y$10$.goEDzU3xTOSIYbUbQ08e.IGBa1yjGT8y2rJ4JOJMiWgmMQiocTGe', 'DOC0003', '', '1', '1', '0', '2022-07-06 13:33:43', '2022-07-06 13:33:52'),
(3, 1, 'Dr Deepak', 'hospital@gmail.com', '8765434565', 'Hospital', '$2y$10$TYA7TLt/zrC1tL.j22a0OObbuI5awfW7oxAdoUHJbAwpHlDjcpwiK', 'HS0004', '', '1', '1', '0', '2022-07-06 13:40:11', '2022-07-11 06:26:12'),
(4, 1, 'Pharmasy', 'pharmasy@gmail.com', '7858483838', 'Pharmacy', '$2y$10$zPaalc3HymF792CdpgO19OEA/0QnR8Bb95VJPNNYf9LVciG8HChoS', 'PH0005', '', '1', '1', '0', '2022-07-06 13:44:26', '2022-08-10 04:30:05'),
(5, 1, 'Lab name', 'lab@gmail.com', '6564636262', 'Lab', '$2y$10$BvVK243XLgi7MztWTWBW5OPQrUQzIxw4WUFEpb./.7y6/gWY0N.wK', 'LB0006', '', '1', '1', '0', '2022-07-06 13:46:17', '2022-07-06 13:46:22'),
(6, 1, 'Bloodbank', 'bloodbank@gmail.com', '6564646464', 'Bloodbank', '$2y$10$XPFdKnhmKalcX4Uj.vfgoerYxOfLl15xYzEtaW8c5CFbKnVPGKmuC', 'BB0007', '', '1', '1', '0', '2022-07-06 13:47:00', '2022-07-06 13:47:08'),
(8, 4, 'Dr ajay', 'ajay@gmail.com', '8765654343', 'Doctor', '$2y$10$GIl6NZga1GHkp6d3hjWwteBKPrkrPPDsdGSpj2MB5OXsKWX1Jh4ri', 'DOC0008', '', '1', '1', '0', '2022-07-11 06:52:04', '2022-12-19 19:39:55'),
(9, 1, 'Deepak Chahar', 'nursing@gmail.com', '7675757575', 'Nursing', '$2y$10$3nJUX.UD/boaBhtWPmTy8OuM1SDACPvBDQpuiLO43EvMvlaTAolvO', 'NR0009', '', '1', '1', '0', '2022-08-28 09:22:22', '2022-08-28 09:22:53'),
(10, 1, 'Dealer2', 'dealer@gmail.com', '7777469656', 'Dealer', '$2y$10$sJQlOfqdt2PofBSpVVUTdO39ZAFtwEM2x2wTRG3LJdGlVdpvyCW92', 'DL0010', '', '1', '1', '0', '2022-08-29 13:41:28', '2022-08-30 11:34:54'),
(11, 1, 'Ambulance cp', 'ambulance@gmail.com', '87837363', 'Ambulance', '$2y$10$kyPBAkIg60IQulEPv0LPJeTq0pj1It9fCBbDg.YRTNb6vc/xZxpge', 'AMB0011', '', '1', '1', '0', '2022-10-18 02:42:53', '2022-10-18 03:18:03'),
(12, 2, 'User 2', 'user2@gmail.com', '7878787878', 'User', '$2y$10$zMW5VqPggMHZ.6PpbjajSONtc21pYLkzCli66ZwftKGrcFxobNqCm', 'REF0012', '', '1', '1', '0', '2022-11-06 13:09:15', '2022-11-06 13:09:22'),
(13, 3, 'Nursing2', 'nursing2@gmail.com', '3232323232', 'Nursing', '$2y$10$odp70N47R614ljqryNAgQe0rRv.X9qmgXaZXbhjm4xlYCyEo5q9Pi', 'NUR0013', '', '0', '1', '0', '2022-11-13 08:09:50', '2022-11-13 08:12:44'),
(14, 3, 'user', 'user22@gmail.com', '8767876787', 'User', '$2y$10$Xi6b3Bd0/9mMI1sAQogdUOvYPdvdpl53yldJElDy3NAMV.b6KHAXW', 'REF0014', 'ref', '1', '1', '0', '2022-11-27 02:34:31', '2022-11-27 02:42:24'),
(16, 7, 'Dr.', 'hospital2@gmail.com', '9494949494', 'Doctor', '$2y$10$.n/VJIAmGUoi8NcLsmQqEu1jl36WBdV/sVRyivP.dR7/pXBtZWnlG', '', '', '0', '1', '0', '2022-12-19 20:36:28', '2022-12-19 20:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `zoomtokens`
--

CREATE TABLE `zoomtokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `access_token` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refresh_token` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zoomtokens`
--

INSERT INTO `zoomtokens` (`id`, `access_token`, `refresh_token`, `created_at`, `updated_at`) VALUES
(1, 'eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiI2NjU1YWNjZS1mYzBlLTQ3ZjEtODJhYS1jMDhjMjE1YjY5ZGEifQ.eyJ2ZXIiOjcsImF1aWQiOiJjMmYwMDM1MGE2NTNlNGU3MzNkOGVjM2QzMmZmZTc0NyIsImNvZGUiOiJlUGdwajRnek5XRm1rWjA3NjBfUjIyVU1CSVhpYldhMHciLCJpc3MiOiJ6bTpjaWQ6T3h5OGxHY1pSVnVGWk9QTXFScVh4ZyIsImdubyI6MCwidHlwZSI6MCwidGlkIjowLCJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJ0d3NVM1JXUVNNcWpNV3Jla3M2cVhBIiwibmJmIjoxNjY3OTE0MDkzLCJleHAiOjE2Njc5MTc2OTMsImlhdCI6MTY2NzkxNDA5MywiYWlkIjoiN0ViNUxhemhTdS05cWRoX3MxWnBtZyIsImp0aSI6IjA0M2QyYzdjLTM4MjYtNDUzZC04NDk2LTcwMTcyMTQ5MTJjYyJ9.EVRBFekYzef9h-1WwKmVilwN1AkU76t4cTl7fixQlqTBpjYfgRgwSGsWq40AStrn_PVBwE0hBjV4kHAPmqWCDQ', 'eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiJmMTMxMmFmNC1kMzkzLTRkMmMtODEzYS00MzJhNGQxZmIxZDQifQ.eyJ2ZXIiOjcsImF1aWQiOiJjMmYwMDM1MGE2NTNlNGU3MzNkOGVjM2QzMmZmZTc0NyIsImNvZGUiOiJlUGdwajRnek5XRm1rWjA3NjBfUjIyVU1CSVhpYldhMHciLCJpc3MiOiJ6bTpjaWQ6T3h5OGxHY1pSVnVGWk9QTXFScVh4ZyIsImdubyI6MCwidHlwZSI6MSwidGlkIjowLCJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJ0d3NVM1JXUVNNcWpNV3Jla3M2cVhBIiwibmJmIjoxNjY3OTE0MDkzLCJleHAiOjIxNDA5NTQwOTMsImlhdCI6MTY2NzkxNDA5MywiYWlkIjoiN0ViNUxhemhTdS05cWRoX3MxWnBtZyIsImp0aSI6ImJhMjVhZDliLWQ5ZGItNDdkNy1hNmYzLTYxMzA4NjMwZTg0NSJ9.XttcMz8_R9RbWLqDZ0bSoEemZw3NXsLgiEncmm7nGq39IzEvRpiN-IVjdsOp_-GF8eG6O52OL2NwfXvHbI9HRQ', '2022-08-17 10:23:14', '2022-11-08 07:58:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accredition_certificates`
--
ALTER TABLE `accredition_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ambulances`
--
ALTER TABLE `ambulances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ambulance_bookings`
--
ALTER TABLE `ambulance_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ambulance_driver_lists`
--
ALTER TABLE `ambulance_driver_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ambulance_lists`
--
ALTER TABLE `ambulance_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bloodbanks`
--
ALTER TABLE `bloodbanks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bloodbanks_email_unique` (`email`),
  ADD UNIQUE KEY `bloodbanks_slug_unique` (`slug`);

--
-- Indexes for table `bloodbankstocks`
--
ALTER TABLE `bloodbankstocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bloodbankstocks_bloodbank_id_foreign` (`bloodbank_id`);

--
-- Indexes for table `bloodbank_components`
--
ALTER TABLE `bloodbank_components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_doners`
--
ALTER TABLE `blood_doners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buy_carts`
--
ALTER TABLE `buy_carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buy_cart_order_infos`
--
ALTER TABLE `buy_cart_order_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `category_eqps`
--
ALTER TABLE `category_eqps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_eqps_slug_unique` (`slug`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_reports`
--
ALTER TABLE `chat_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_mobile_unique` (`mobile`);

--
-- Indexes for table `dealers`
--
ALTER TABLE `dealers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dealer_products`
--
ALTER TABLE `dealer_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dealer_product_purchases`
--
ALTER TABLE `dealer_product_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation_lists`
--
ALTER TABLE `designation_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dignosis_lists`
--
ALTER TABLE `dignosis_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_email_unique` (`email`),
  ADD UNIQUE KEY `doctors_slug_unique` (`slug`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Indexes for table `doctor_bank_docs`
--
ALTER TABLE `doctor_bank_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_comments`
--
ALTER TABLE `doctor_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_edus`
--
ALTER TABLE `doctor_edus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_medicine_advice`
--
ALTER TABLE `doctor_medicine_advice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empanelments`
--
ALTER TABLE `empanelments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `formulations`
--
ALTER TABLE `formulations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_care_requests`
--
ALTER TABLE `home_care_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hospitals_slug_unique` (`slug`);

--
-- Indexes for table `hospital__staff`
--
ALTER TABLE `hospital__staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hospital__staff_email_unique` (`email`),
  ADD UNIQUE KEY `hospital__staff_mobile_unique` (`mobile`);

--
-- Indexes for table `illness_lists`
--
ALTER TABLE `illness_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laboratorists`
--
ALTER TABLE `laboratorists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `laboratorists_email_unique` (`email`),
  ADD UNIQUE KEY `laboratorists_slug_unique` (`slug`);

--
-- Indexes for table `labtestcategories`
--
ALTER TABLE `labtestcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labtestpackages`
--
ALTER TABLE `labtestpackages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `labtestpackages_lab_id_foreign` (`lab_id`);

--
-- Indexes for table `labtests`
--
ALTER TABLE `labtests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `labtests_lab_id_foreign` (`lab_id`);

--
-- Indexes for table `labtest_bookings`
--
ALTER TABLE `labtest_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labtest_masterdbs`
--
ALTER TABLE `labtest_masterdbs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_booking_info_lists`
--
ALTER TABLE `lab_booking_info_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_counsilings`
--
ALTER TABLE `medical_counsilings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nursings`
--
ALTER TABLE `nursings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nursing_procedures`
--
ALTER TABLE `nursing_procedures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patient_lists`
--
ALTER TABLE `patient_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacies`
--
ALTER TABLE `pharmacies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pharmacies_email_unique` (`email`),
  ADD UNIQUE KEY `pharmacies_slug_unique` (`slug`),
  ADD KEY `pharmacies_hospital_id_foreign` (`hospital_id`);

--
-- Indexes for table `pharmacists`
--
ALTER TABLE `pharmacists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pharmacists_email_unique` (`email`),
  ADD KEY `pharmacists_hospital_id_foreign` (`hospital_id`);

--
-- Indexes for table `pincode_maps`
--
ALTER TABLE `pincode_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prices_product_id_foreign` (`product_id`);

--
-- Indexes for table `procedures`
--
ALTER TABLE `procedures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_pharmacy_id_foreign` (`pharmacy_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_image_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_payments`
--
ALTER TABLE `service_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_payment_histories`
--
ALTER TABLE `service_payment_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialities`
--
ALTER TABLE `specialities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specialities_specialization_id_foreign` (`specialization_id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_categories_slug_unique` (`slug`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superadmin_email_unique` (`email`);

--
-- Indexes for table `symptoms_lists`
--
ALTER TABLE `symptoms_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatment_and_surgery_lists`
--
ALTER TABLE `treatment_and_surgery_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `zoomtokens`
--
ALTER TABLE `zoomtokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accredition_certificates`
--
ALTER TABLE `accredition_certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ambulances`
--
ALTER TABLE `ambulances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ambulance_bookings`
--
ALTER TABLE `ambulance_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ambulance_driver_lists`
--
ALTER TABLE `ambulance_driver_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ambulance_lists`
--
ALTER TABLE `ambulance_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bloodbanks`
--
ALTER TABLE `bloodbanks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bloodbankstocks`
--
ALTER TABLE `bloodbankstocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bloodbank_components`
--
ALTER TABLE `bloodbank_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blood_doners`
--
ALTER TABLE `blood_doners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `buy_carts`
--
ALTER TABLE `buy_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `buy_cart_order_infos`
--
ALTER TABLE `buy_cart_order_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category_eqps`
--
ALTER TABLE `category_eqps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat_reports`
--
ALTER TABLE `chat_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dealers`
--
ALTER TABLE `dealers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dealer_products`
--
ALTER TABLE `dealer_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dealer_product_purchases`
--
ALTER TABLE `dealer_product_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designation_lists`
--
ALTER TABLE `designation_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dignosis_lists`
--
ALTER TABLE `dignosis_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctor_bank_docs`
--
ALTER TABLE `doctor_bank_docs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctor_comments`
--
ALTER TABLE `doctor_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_edus`
--
ALTER TABLE `doctor_edus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctor_medicine_advice`
--
ALTER TABLE `doctor_medicine_advice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `empanelments`
--
ALTER TABLE `empanelments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formulations`
--
ALTER TABLE `formulations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `home_care_requests`
--
ALTER TABLE `home_care_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hospital__staff`
--
ALTER TABLE `hospital__staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `illness_lists`
--
ALTER TABLE `illness_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `laboratorists`
--
ALTER TABLE `laboratorists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `labtestcategories`
--
ALTER TABLE `labtestcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `labtestpackages`
--
ALTER TABLE `labtestpackages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `labtests`
--
ALTER TABLE `labtests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `labtest_bookings`
--
ALTER TABLE `labtest_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `labtest_masterdbs`
--
ALTER TABLE `labtest_masterdbs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_booking_info_lists`
--
ALTER TABLE `lab_booking_info_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `medical_counsilings`
--
ALTER TABLE `medical_counsilings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `nursings`
--
ALTER TABLE `nursings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nursing_procedures`
--
ALTER TABLE `nursing_procedures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `patient_lists`
--
ALTER TABLE `patient_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `pharmacies`
--
ALTER TABLE `pharmacies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pharmacists`
--
ALTER TABLE `pharmacists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pincode_maps`
--
ALTER TABLE `pincode_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `procedures`
--
ALTER TABLE `procedures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service_payments`
--
ALTER TABLE `service_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_payment_histories`
--
ALTER TABLE `service_payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `specialities`
--
ALTER TABLE `specialities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `symptoms_lists`
--
ALTER TABLE `symptoms_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `treatment_and_surgery_lists`
--
ALTER TABLE `treatment_and_surgery_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `zoomtokens`
--
ALTER TABLE `zoomtokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bloodbankstocks`
--
ALTER TABLE `bloodbankstocks`
  ADD CONSTRAINT `bloodbankstocks_bloodbank_id_foreign` FOREIGN KEY (`bloodbank_id`) REFERENCES `bloodbanks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `labtestpackages`
--
ALTER TABLE `labtestpackages`
  ADD CONSTRAINT `labtestpackages_lab_id_foreign` FOREIGN KEY (`lab_id`) REFERENCES `laboratorists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `labtests`
--
ALTER TABLE `labtests`
  ADD CONSTRAINT `labtests_lab_id_foreign` FOREIGN KEY (`lab_id`) REFERENCES `laboratorists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pharmacies`
--
ALTER TABLE `pharmacies`
  ADD CONSTRAINT `pharmacies_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pharmacists`
--
ALTER TABLE `pharmacists`
  ADD CONSTRAINT `pharmacists_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_pharmacy_id_foreign` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_image_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `specialities`
--
ALTER TABLE `specialities`
  ADD CONSTRAINT `specialities_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
