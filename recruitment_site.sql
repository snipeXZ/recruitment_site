-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2022 at 01:07 PM
-- Server version: 8.0.29-0ubuntu0.22.04.2
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recruitment_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `applicant_id` int NOT NULL,
  `first_name` varchar(300) NOT NULL,
  `last_name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `account_status` varchar(300) NOT NULL,
  `resume` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`applicant_id`, `first_name`, `last_name`, `email`, `password`, `account_status`, `resume`) VALUES
(1, 'rashid', 'rashid', 'rashid@gmail.com', '$2y$10$D09o5WUdSqSL.ugdUF8tzOB48IVOjMpcKDgaC2uDKWY0Iqi9.OLSW', 'disabled', NULL),
(2, 'kofi', 'kofi', 'kofi@gmail.com', '$2y$10$Jipb7Iil4kmtDaIrsfnIqOd1xGcyHRwzCF3sncGzLigb2cUfw3rpS', 'disabled', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `account_status` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `email`, `password`, `account_status`) VALUES
(2, 'gtuc', 'gtuc@gmail.com', '$2y$10$Stx3EDSIWY9Ya6vPGfs.xe8LlHEmjf1lH/VqRGSnLCpgSFyrL1mKy', 'enabled'),
(14, 'africa', 'africa@gmail.com', '$2y$10$260JgB0Mfizydngk./udZOc2DQ.vj/4SijpSVcrGqGCCTJtJT3xJy', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `job_applied`
--

CREATE TABLE `job_applied` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `applicant_id` int NOT NULL,
  `status` int DEFAULT NULL,
  `interview_time` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `job_applied`
--

INSERT INTO `job_applied` (`id`, `company_id`, `applicant_id`, `status`, `interview_time`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `job_name` varchar(350) NOT NULL,
  `discription` varchar(400) NOT NULL,
  `requirements` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `company_id`, `job_name`, `discription`, `requirements`, `status`) VALUES
(1, 2, 'Network Admin', 'In general, network administrators perform the following duties: Setting up new networks. Maintaining and upgrading existing computer networks, including hardware like VPNs and routers. Troubleshooting flaws in software, hardware configuration, and communications equipment, and then fixing problems as they arise.', 'DEGREE', 'opened'),
(2, 2, 'Penetration Tester', 'As a penetration tester, you will perform authorised tests on computer systems in order to expose weaknesses in their security that could be exploited by criminals. You can choose to specialise in manipulating a particular type of system, such as: networks and infrastructures. Windows, Linux and Mac operating systems.', 'DEGREE', 'opened');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`applicant_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applied`
--
ALTER TABLE `job_applied`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `applicant_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `job_applied`
--
ALTER TABLE `job_applied`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
