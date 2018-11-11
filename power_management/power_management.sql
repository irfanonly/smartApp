-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 07, 2018 at 04:17 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `power_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` varchar(20) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `suport_device` varchar(100) NOT NULL,
  `limit_value` varchar(20) NOT NULL,
  `created_date` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `voltage` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `device_name`, `suport_device`, `limit_value`, `created_date`, `created_by`, `voltage`) VALUES
('DIV1111', 'AC', 'thermal sensor', '20', '2018-09-02 01:29:53', 'achsuthan@icloud.com', '20'),
('DIV1112', 'AC', 'thermal sensor', '20', '2018-09-02 01:32:46', 'shankavi3.st@gmail.com', '5'),
('DIV1113', 'AC', 'thermal sensor', '20', '2018-09-22 10:16:35', 'shankavi3.st@gmail.com', '10'),
('DIV1114', 'AC', 'thermal sensor', '20', '2018-10-07 03:53:36', 'senthu', '10');

-- --------------------------------------------------------

--
-- Table structure for table `reading`
--

CREATE TABLE `reading` (
  `id` varchar(20) NOT NULL,
  `value` varchar(20) NOT NULL,
  `recorded_date` varchar(25) NOT NULL,
  `is_on` varchar(10) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `usage` varchar(100) NOT NULL,
  `device_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reading_month`
--

CREATE TABLE `reading_month` (
  `id` int(11) NOT NULL,
  `usage_time` varchar(100) NOT NULL,
  `wastage_time` varchar(100) NOT NULL,
  `usageCharge` varchar(100) NOT NULL,
  `wastageCharge` varchar(100) NOT NULL,
  `device_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reading_month`
--

INSERT INTO `reading_month` (`id`, `usage_time`, `wastage_time`, `usageCharge`, `wastageCharge`, `device_id`) VALUES
(1754687, '66', '50', '0.00071958333333333', '5.4513888888889E-5', ''),
(1754688, '5', '5', '5.4513888888889E-5', '5.4513888888889E-6', 'DIV1112'),
(1754689, '6', '6', '0.00026166666666667', '2.6166666666667E-5', 'DIV1111'),
(1754690, '16', '16', '0', '0', 'DIV1112'),
(1754691, '468', '468', '0.01', '0', 'DIV1112'),
(1754692, '12', '12', '0.00013083333333333', '1.3083333333333E-5', 'DIV1112');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reading`
--
ALTER TABLE `reading`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `reading_month`
--
ALTER TABLE `reading_month`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reading_month`
--
ALTER TABLE `reading_month`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1754693;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reading`
--
ALTER TABLE `reading`
  ADD CONSTRAINT `reading_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
