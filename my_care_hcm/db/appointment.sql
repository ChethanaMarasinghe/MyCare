-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 07:19 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_care_hcm`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `Appointment_id` int(11) NOT NULL,
  `Patient_id` int(11) DEFAULT NULL,
  `Doctor_id` int(11) DEFAULT NULL,
  `Room_id` int(11) DEFAULT 1,
  `Date` date NOT NULL,
  `Start_time` varchar(10) NOT NULL,
  `End_time` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`Appointment_id`, `Patient_id`, `Doctor_id`, `Room_id`, `Date`, `Start_time`, `End_time`) VALUES
(1, 1, 1, 1, '2024-06-15', '9:00 AM', '9:30 AM'),
(2, 2, 1, 2, '2024-06-15', '10:00 AM', '10:30 AM'),
(3, 3, 1, 3, '2024-06-15', '11:00 AM', '11:30 AM'),
(4, 4, 2, 4, '2024-06-15', '12:00 PM', '12:30 PM'),
(5, 5, 2, 5, '2024-06-15', '1:00 PM', '1:30 PM'),
(6, 2, 10, 1, '2024-06-15', '8:00 AM', '8:30 AM'),
(7, 1, 1, 1, '2024-06-15', '10:30 AM', '11:00 AM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`Appointment_id`),
  ADD KEY `Patient_id` (`Patient_id`),
  ADD KEY `Doctor_id` (`Doctor_id`),
  ADD KEY `Room_id` (`Room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `Appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`Patient_id`) REFERENCES `patient` (`Patient_id`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`Doctor_id`) REFERENCES `doctor` (`Doctor_id`),
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`Room_id`) REFERENCES `room` (`Room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
