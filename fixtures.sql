-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2026 at 07:28 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_ghrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `fixtures`
--

CREATE TABLE `fixtures` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `team1_id` bigint UNSIGNED DEFAULT NULL,
  `team2_id` bigint UNSIGNED DEFAULT NULL,
  `actual_team1_goals` int DEFAULT NULL,
  `actual_team2_goals` int DEFAULT NULL,
  `winning_team` int DEFAULT NULL,
  `is_draw` int DEFAULT NULL,
  `venue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staduim_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `round` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fixtures`
--

INSERT INTO `fixtures` (`id`, `date`, `team1_id`, `team2_id`, `actual_team1_goals`, `actual_team2_goals`, `winning_team`, `is_draw`, `venue`, `staduim_name`, `time`, `round`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2026-06-11', 27, 40, NULL, NULL, NULL, NULL, 'Mexico City', 'Estadio Azteca', '1:00 AM', '1', 1, NULL, '2026-06-04 01:09:30'),
(2, '2026-06-12', 41, 13, NULL, NULL, NULL, NULL, 'Guadalajara', 'Estadio Akron', '8:00 AM', '1', 1, NULL, '2026-06-03 22:58:35'),
(3, '2026-06-12', 9, 6, NULL, NULL, NULL, NULL, 'Toronto', 'BMO Field', '1:00 AM', '1', 1, NULL, '2026-06-03 22:59:37'),
(4, '2026-06-13', 48, 33, NULL, NULL, NULL, NULL, 'Los Angeles', 'SoFi Stadium', '7:00 AM', '1', 1, NULL, '2026-06-03 05:08:06'),
(5, '2026-06-13', 3, 45, NULL, NULL, NULL, NULL, 'Vancouver', 'BC Place', '10:00 AM', '1', 1, NULL, NULL),
(6, '2026-06-13', 36, 43, NULL, NULL, NULL, NULL, 'San Francisco', 'Levi\'s Stadium', '1:00 AM', '1', 1, NULL, '2026-06-03 05:11:18'),
(7, '2026-06-14', 7, 28, NULL, NULL, NULL, NULL, 'New York-New Jersey', 'MetLife Stadium', '4:00 AM', '1', 1, NULL, NULL),
(8, '2026-06-14', 21, 38, NULL, NULL, NULL, NULL, 'Boston', 'Gillette Stadium', '7:00 AM', '1', 1, NULL, NULL),
(9, '2026-06-14', 19, 12, NULL, NULL, NULL, NULL, 'Houston', 'NRG Stadium', '11:00 PM', '1', 1, NULL, NULL),
(10, '2026-06-14', 29, 25, NULL, NULL, NULL, NULL, 'Dallas', 'AT&T Stadium', '2:00 AM', '1', 1, NULL, NULL),
(11, '2026-06-15', 24, 15, NULL, NULL, NULL, NULL, 'Philadelphia', 'Lincoln Financial Field', '5:00 AM', '1', 1, NULL, NULL),
(12, '2026-06-15', NULL, 44, NULL, NULL, NULL, NULL, 'Monterrey', 'Estadio BBVA', '8:00 AM', '1', 1, NULL, NULL),
(13, '2026-06-15', 42, 8, NULL, NULL, NULL, NULL, 'Atlanta', 'Mercedes-Benz Stadium', '10:00 PM', '1', 1, NULL, NULL),
(14, '2026-06-15', 5, 16, NULL, NULL, NULL, NULL, 'Seattle', 'Lumen Field', '1:00 AM', '1', 1, NULL, NULL),
(15, '2026-06-16', 37, 47, NULL, NULL, NULL, NULL, 'Miami', 'Hard Rock Stadium', '4:00 AM', '1', 1, NULL, NULL),
(16, '2026-06-16', 22, 30, NULL, NULL, NULL, NULL, 'Los Angeles', 'SoFi Stadium', '7:00 AM', '1', 1, NULL, NULL),
(17, '2026-06-16', 4, 26, NULL, NULL, NULL, NULL, 'San Francisco', 'Levi\'s Stadium', '10:00 AM', '1', 1, NULL, NULL),
(18, '2026-06-16', 18, 39, NULL, NULL, NULL, NULL, 'New York-New Jersey', 'MetLife Stadium', '1:00 AM', '1', 1, NULL, NULL),
(19, '2026-06-17', NULL, 31, NULL, NULL, NULL, NULL, 'Boston', 'Gillette Stadium', '4:00 AM', '1', 1, NULL, NULL),
(20, '2026-06-17', 2, 1, NULL, NULL, NULL, NULL, 'Kansas City', 'Arrowhead Stadium', '7:00 AM', '1', 1, NULL, NULL),
(21, '2026-06-17', 35, NULL, NULL, NULL, NULL, NULL, 'Houston', 'NRG Stadium', '11:00 PM', '1', 1, NULL, NULL),
(22, '2026-06-17', 17, 11, NULL, NULL, NULL, NULL, 'Dallas', 'AT&T Stadium', '2:00 AM', '1', 1, NULL, NULL),
(23, '2026-06-18', 20, 32, NULL, NULL, NULL, NULL, 'Toronto', 'BMO Field', '5:00 AM', '1', 1, NULL, NULL),
(24, '2026-06-18', 46, 10, NULL, NULL, NULL, NULL, 'Mexico City', 'Estadio Azteca', '8:00 AM', '1', 1, NULL, NULL),
(25, '2026-06-18', NULL, 40, NULL, NULL, NULL, NULL, 'Atlanta', 'Mercedes-Benz Stadium', '10:00 PM', '1', 1, NULL, NULL),
(26, '2026-06-18', 43, NULL, NULL, NULL, NULL, NULL, 'Los Angeles', 'SoFi Stadium', '1:00 AM', '1', 1, NULL, NULL),
(27, '2026-06-19', 9, 36, NULL, NULL, NULL, NULL, 'Vancouver', 'BC Place', '4:00 AM', '1', 1, NULL, NULL),
(28, '2026-06-19', 27, 41, NULL, NULL, NULL, NULL, 'Guadalajara', 'Estadio Akron', '7:00 AM', '1', 1, NULL, NULL),
(29, '2026-06-19', NULL, 33, NULL, NULL, NULL, NULL, 'San Francisco', 'Levi\'s Stadium', '10:00 AM', '1', 1, NULL, NULL),
(30, '2026-06-19', 48, 3, NULL, NULL, NULL, NULL, 'Seattle', 'Lumen Field', '1:00 AM', '1', 1, NULL, NULL),
(31, '2026-06-20', 38, 28, NULL, NULL, NULL, NULL, 'Boston', 'Gillette Stadium', '4:00 AM', '1', 1, NULL, NULL),
(32, '2026-06-20', 7, 21, NULL, NULL, NULL, NULL, 'Philadelphia', 'Lincoln Financial Field', '7:00 AM', '1', 1, NULL, NULL),
(33, '2026-06-20', 44, 25, NULL, NULL, NULL, NULL, 'Monterrey', 'Estadio BBVA', '10:00 AM', '1', 1, NULL, NULL),
(34, '2026-06-20', 29, NULL, NULL, NULL, NULL, NULL, 'Houston', 'NRG Stadium', '11:00 PM', '1', 1, NULL, NULL),
(35, '2026-06-20', 19, 24, NULL, NULL, NULL, NULL, 'Toronto', 'BMO Field', '2:00 AM', '1', 1, NULL, NULL),
(36, '2026-06-21', 15, 12, NULL, NULL, NULL, NULL, 'Kansas City', 'Arrowhead Stadium', '6:00 AM', '1', 1, NULL, NULL),
(37, '2026-06-21', 42, 37, NULL, NULL, NULL, NULL, 'Atlanta', 'Mercedes-Benz Stadium', '10:00 PM', '1', 1, NULL, NULL),
(38, '2026-06-21', 5, 22, NULL, NULL, NULL, NULL, 'Los Angeles', 'SoFi Stadium', '1:00 AM', '1', 1, NULL, NULL),
(39, '2026-06-22', 47, 8, NULL, NULL, NULL, NULL, 'Miami', 'Hard Rock Stadium', '4:00 AM', '1', 1, NULL, NULL),
(40, '2026-06-22', 30, 16, NULL, NULL, NULL, NULL, 'Vancouver', 'BC Place', '7:00 AM', '1', 1, NULL, NULL),
(41, '2026-06-22', 2, 4, NULL, NULL, NULL, NULL, 'Dallas', 'AT&T Stadium', '11:00 PM', '1', 1, NULL, NULL),
(42, '2026-06-22', 18, NULL, NULL, NULL, NULL, NULL, 'Philadelphia', 'Lincoln Financial Field', '3:00 AM', '1', 1, NULL, NULL),
(43, '2026-06-23', 31, 39, NULL, NULL, NULL, NULL, 'New York-New Jersey', 'MetLife Stadium', '6:00 AM', '1', 1, NULL, NULL),
(44, '2026-06-23', 26, 1, NULL, NULL, NULL, NULL, 'San Francisco', 'Levi\'s Stadium', '9:00 AM', '1', 1, NULL, NULL),
(45, '2026-06-23', 35, 46, NULL, NULL, NULL, NULL, 'Houston', 'NRG Stadium', '11:00 PM', '1', 1, NULL, NULL),
(46, '2026-06-23', 17, 20, NULL, NULL, NULL, NULL, 'Boston', 'Gillette Stadium', '2:00 AM', '1', 1, NULL, NULL),
(47, '2026-06-24', 32, 11, NULL, NULL, NULL, NULL, 'Toronto', 'BMO Field', '5:00 AM', '1', 1, NULL, NULL),
(48, '2026-06-24', 10, NULL, NULL, NULL, NULL, NULL, 'Guadalajara', 'Estadio Akron', '8:00 AM', '1', 1, NULL, NULL),
(49, '2026-06-24', 9, 43, NULL, NULL, NULL, NULL, 'Vancouver', 'BC Place', '1:00 AM', '1', 1, NULL, NULL),
(50, '2026-06-24', NULL, 36, NULL, NULL, NULL, NULL, 'Seattle', 'Lumen Field', '1:00 AM', '1', 1, NULL, NULL),
(51, '2026-06-25', 38, 7, NULL, NULL, NULL, NULL, 'Miami', 'Hard Rock Stadium', '4:00 AM', '1', 1, NULL, NULL),
(52, '2026-06-25', 28, 21, NULL, NULL, NULL, NULL, 'Atlanta', 'Mercedes-Benz Stadium', '4:00 AM', '1', 1, NULL, NULL),
(53, '2026-06-25', 27, NULL, NULL, NULL, NULL, NULL, 'Mexico City', 'Estadio Azteca', '7:00 AM', '1', 1, NULL, NULL),
(54, '2026-06-25', 41, 40, NULL, NULL, NULL, NULL, 'Monterrey', 'Estadio BBVA', '7:00 AM', '1', 1, NULL, NULL),
(55, '2026-06-25', 15, 19, NULL, NULL, NULL, NULL, 'New York-New Jersey', 'MetLife Stadium', '2:00 AM', '1', 1, NULL, NULL),
(56, '2026-06-25', 12, 24, NULL, NULL, NULL, NULL, 'Philadelphia', 'Lincoln Financial Field', '2:00 AM', '1', 1, NULL, NULL),
(57, '2026-06-26', 25, NULL, NULL, NULL, NULL, NULL, 'Dallas', 'AT&T Stadium', '5:00 AM', '1', 1, NULL, NULL),
(58, '2026-06-26', 44, 29, NULL, NULL, NULL, NULL, 'Kansas City', 'Arrowhead Stadium', '5:00 AM', '1', 1, NULL, NULL),
(59, '2026-06-26', 48, NULL, NULL, NULL, NULL, NULL, 'Los Angeles', 'SoFi Stadium', '8:00 AM', '1', 1, NULL, NULL),
(60, '2026-06-26', 33, 3, NULL, NULL, NULL, NULL, 'San Francisco', 'Levi\'s Stadium', '8:00 AM', '1', 1, NULL, NULL),
(61, '2026-06-26', 31, 18, NULL, NULL, NULL, NULL, 'Boston', 'Gillette Stadium', '1:00 AM', '1', 1, NULL, NULL),
(62, '2026-06-26', 39, NULL, NULL, NULL, NULL, NULL, 'Toronto', 'BMO Field', '1:00 AM', '1', 1, NULL, NULL),
(63, '2026-06-27', 47, 42, NULL, NULL, NULL, NULL, 'Guadalajara', 'Estadio Akron', '6:00 AM', '1', 1, NULL, NULL),
(64, '2026-06-27', 8, 37, NULL, NULL, NULL, NULL, 'Houston', 'NRG Stadium', '6:00 AM', '1', 1, NULL, NULL),
(65, '2026-06-27', 30, 5, NULL, NULL, NULL, NULL, 'Vancouver', 'BC Place', '9:00 AM', '1', 1, NULL, NULL),
(66, '2026-06-27', 16, 22, NULL, NULL, NULL, NULL, 'Seattle', 'Lumen Field', '9:00 AM', '1', 1, NULL, NULL),
(67, '2026-06-27', 32, 17, NULL, NULL, NULL, NULL, 'New York-New Jersey', 'MetLife Stadium', '3:00 AM', '1', 1, NULL, NULL),
(68, '2026-06-27', 11, 20, NULL, NULL, NULL, NULL, 'Philadelphia', 'Lincoln Financial Field', '3:00 AM', '1', 1, NULL, NULL),
(69, '2026-06-28', 10, 35, NULL, NULL, NULL, NULL, 'Miami', 'Hard Rock Stadium', '5:30 AM', '1', 1, NULL, NULL),
(70, '2026-06-28', NULL, 46, NULL, NULL, NULL, NULL, 'Atlanta', 'Mercedes-Benz Stadium', '5:30 AM', '1', 1, NULL, NULL),
(71, '2026-06-28', 26, 2, NULL, NULL, NULL, NULL, 'Dallas', 'AT&T Stadium', '8:00 AM', '1', 1, NULL, NULL),
(72, '2026-06-28', 1, 4, NULL, NULL, NULL, NULL, 'Kansas City', 'Arrowhead Stadium', '8:00 AM', '1', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fixtures`
--
ALTER TABLE `fixtures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fixtures`
--
ALTER TABLE `fixtures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
