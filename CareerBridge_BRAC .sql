-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2026 at 09:21 PM
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
-- Database: `careerbridge_brac`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ADMIN_ID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMIN_ID`, `NAME`, `username`, `password`) VALUES
(1, 'Tanvir', 'admin123', 'admin@1122'),
(2, 'Tadrib', 'admin184', 'admin@184');

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `APPLICATION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `OPPORTUNITY_ID` int(11) NOT NULL,
  `STATUS` enum('PENDING','ACCEPTED','REJECTED') NOT NULL,
  `APPLIED_ON` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`APPLICATION_ID`, `USER_ID`, `OPPORTUNITY_ID`, `STATUS`, `APPLIED_ON`) VALUES
(6, 2, 4, 'REJECTED', '2025-12-30'),
(7, 2, 3, 'ACCEPTED', '2025-12-30'),
(9, 5, 4, 'REJECTED', '2025-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `COMPANY_ID` int(11) NOT NULL,
  `COMPANY_NAME` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(150) NOT NULL DEFAULT 'Unknown',
  `industry` varchar(100) NOT NULL DEFAULT 'General'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`COMPANY_ID`, `COMPANY_NAME`, `username`, `password`, `location`, `industry`) VALUES
(2, 'xenon', 'xenon202', '$2y$10$LMerNJa4CVA7SA33FcWR5eZQ0yiTTx9.JhHZNqRi/abfR7MVE9o4.', 'Dhaka', 'Development'),
(3, 'BrightWay Solutions Ltd.', 'BrightWay Solutions Ltd.', '$2y$10$6gdqjGqP5sdfB2y41GjDo.h.Buc2cR2ZDNsz9gNA12BnXF4qGpS7.', 'Bangladesh', 'usiness Consulting & Professional Services');

-- --------------------------------------------------------

--
-- Table structure for table `manages`
--

CREATE TABLE `manages` (
  `USER_ID` int(11) NOT NULL,
  `ADMIN_ID` int(11) NOT NULL,
  `OPPORTUNITY_ID` int(11) NOT NULL,
  `COMPANY_ID` int(11) NOT NULL,
  `ANALYSIS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opportunity`
--

CREATE TABLE `opportunity` (
  `OPPORTUNITY_ID` int(11) NOT NULL,
  `TITLE` varchar(200) NOT NULL,
  `DEADLINE` date DEFAULT NULL,
  `REQ_CGPA` decimal(3,2) DEFAULT NULL,
  `EXPERIENCE` int(11) DEFAULT 0,
  `LOCATION` varchar(100) DEFAULT NULL,
  `DURATION` varchar(50) DEFAULT NULL,
  `STIPEND` decimal(10,2) DEFAULT NULL,
  `SALARY` decimal(10,2) DEFAULT NULL,
  `TYPE` enum('JOB','INTERNSHIP') NOT NULL,
  `COMPANY_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opportunity`
--

INSERT INTO `opportunity` (`OPPORTUNITY_ID`, `TITLE`, `DEADLINE`, `REQ_CGPA`, `EXPERIENCE`, `LOCATION`, `DURATION`, `STIPEND`, `SALARY`, `TYPE`, `COMPANY_ID`) VALUES
(3, 'jr web developer', '2025-12-29', 3.50, 5, 'Dhaka', '6', NULL, 40000.00, 'JOB', 2),
(4, 'game developer', '2025-12-30', 3.80, 2, 'Dhaka', '5', NULL, 30000.00, 'JOB', 2);

-- --------------------------------------------------------

--
-- Table structure for table `probability_analysis`
--

CREATE TABLE `probability_analysis` (
  `ANALYSIS_ID` int(11) NOT NULL,
  `SKILL_MATCH_PERCENTAGE` decimal(5,2) NOT NULL DEFAULT 0.00,
  `EXPERIENCE_MATCH_PERCENTAGE` decimal(5,2) NOT NULL DEFAULT 0.00,
  `OVERALL_PROBABILITY_SCORE` decimal(5,2) DEFAULT 0.00,
  `APPLICATION_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `probability_analysis`
--

INSERT INTO `probability_analysis` (`ANALYSIS_ID`, `SKILL_MATCH_PERCENTAGE`, `EXPERIENCE_MATCH_PERCENTAGE`, `OVERALL_PROBABILITY_SCORE`, `APPLICATION_ID`) VALUES
(1, 100.00, 50.00, 80.00, 7),
(2, 20.00, 80.00, 44.00, 6),
(4, 67.00, 56.00, 62.60, 9);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `REVIEW_ID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `REVIEW_TEXT` text DEFAULT NULL,
  `RATING` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`REVIEW_ID`, `ID`, `REVIEW_TEXT`, `RATING`) VALUES
(2, 2, 'good', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `CGPA` decimal(3,2) NOT NULL,
  `SKILL` varchar(256) NOT NULL,
  `EXPERIENCE` int(11) NOT NULL,
  `department` varchar(100) DEFAULT 'CSE',
  `status` enum('ONGOING','GRADUATED') DEFAULT 'ONGOING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `NAME`, `username`, `password`, `CGPA`, `SKILL`, `EXPERIENCE`, `department`, `status`) VALUES
(2, 'Tanvir', 'Atik162', '$2y$10$9rM9.of5mAMJVt6BWP4gEO49yap.fpbD5MVRoyJdt.t6Srg6N7.42', 3.95, 'Developer', 3, '0', 'ONGOING'),
(5, 'Tanvir Ahmed', 'atikullahtanvir162@gmail.com', '$2y$10$0RSiL3t6.tTYrpmMBhyJ2Os.0bEfkbHASh9BIXc4f.ngLdAs6kIPK', 3.99, 'web developer', 2, '0', 'GRADUATED'),
(6, 'Tadrib', 'Tadrib Ishat', '$2y$10$gHJwKIWcJQ6Eibd.BajA6e5czPfAvdS7tY3P2QrwsfuK3vr.yaPT6', 3.80, 'Developer', 0, 'CSE', 'ONGOING');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ADMIN_ID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`APPLICATION_ID`),
  ADD KEY `fk_opportunity` (`OPPORTUNITY_ID`),
  ADD KEY `fk_user` (`USER_ID`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`COMPANY_ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- Indexes for table `manages`
--
ALTER TABLE `manages`
  ADD PRIMARY KEY (`USER_ID`,`ADMIN_ID`,`OPPORTUNITY_ID`,`COMPANY_ID`,`ANALYSIS_ID`),
  ADD KEY `ADMIN_ID` (`ADMIN_ID`),
  ADD KEY `OPPORTUNITY_ID` (`OPPORTUNITY_ID`),
  ADD KEY `COMPANY_ID` (`COMPANY_ID`),
  ADD KEY `ANALYSIS_ID` (`ANALYSIS_ID`);

--
-- Indexes for table `opportunity`
--
ALTER TABLE `opportunity`
  ADD PRIMARY KEY (`OPPORTUNITY_ID`),
  ADD UNIQUE KEY `OPPORTUNITY_ID` (`OPPORTUNITY_ID`),
  ADD KEY `fk_company` (`COMPANY_ID`);

--
-- Indexes for table `probability_analysis`
--
ALTER TABLE `probability_analysis`
  ADD PRIMARY KEY (`ANALYSIS_ID`),
  ADD UNIQUE KEY `uq_application` (`APPLICATION_ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`REVIEW_ID`),
  ADD KEY `fk_review_user` (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `APPLICATION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `COMPANY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `opportunity`
--
ALTER TABLE `opportunity`
  MODIFY `OPPORTUNITY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `probability_analysis`
--
ALTER TABLE `probability_analysis`
  MODIFY `ANALYSIS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `REVIEW_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `fk_opportunity` FOREIGN KEY (`OPPORTUNITY_ID`) REFERENCES `opportunity` (`OPPORTUNITY_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `manages`
--
ALTER TABLE `manages`
  ADD CONSTRAINT `manages_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `manages_ibfk_2` FOREIGN KEY (`ADMIN_ID`) REFERENCES `admin` (`ADMIN_ID`),
  ADD CONSTRAINT `manages_ibfk_3` FOREIGN KEY (`OPPORTUNITY_ID`) REFERENCES `opportunity` (`OPPORTUNITY_ID`),
  ADD CONSTRAINT `manages_ibfk_4` FOREIGN KEY (`COMPANY_ID`) REFERENCES `company` (`COMPANY_ID`),
  ADD CONSTRAINT `manages_ibfk_5` FOREIGN KEY (`ANALYSIS_ID`) REFERENCES `probability_analysis` (`ANALYSIS_ID`);

--
-- Constraints for table `opportunity`
--
ALTER TABLE `opportunity`
  ADD CONSTRAINT `fk_company` FOREIGN KEY (`COMPANY_ID`) REFERENCES `company` (`COMPANY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `probability_analysis`
--
ALTER TABLE `probability_analysis`
  ADD CONSTRAINT `fk_application` FOREIGN KEY (`APPLICATION_ID`) REFERENCES `application` (`APPLICATION_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `fk_review_user` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
