-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2024 at 01:18 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `app_id` int(11) NOT NULL,
  `app_date_time` datetime NOT NULL,
  `d_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`app_id`, `app_date_time`, `d_id`) VALUES
(3, '2024-04-25 08:15:00', 2),
(4, '2024-04-25 09:14:00', 5),
(5, '2024-04-26 09:30:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `app_patient`
--

CREATE TABLE `app_patient` (
  `AP_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_patient`
--

INSERT INTO `app_patient` (`AP_id`, `app_id`) VALUES
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `b_id` int(11) NOT NULL,
  `checkout_date` date DEFAULT NULL,
  `P_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`b_id`, `checkout_date`, `P_id`, `total_amount`) VALUES
(1, NULL, 1, 150),
(3, NULL, 5, 250),
(6, NULL, 4, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `d_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`d_id`) VALUES
(2),
(5);

-- --------------------------------------------------------

--
-- Table structure for table `nurse`
--

CREATE TABLE `nurse` (
  `n_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse`
--

INSERT INTO `nurse` (`n_id`) VALUES
(4),
(7);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `P_id` int(11) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` char(11) NOT NULL,
  `gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`P_id`, `Fname`, `Lname`, `username`, `password`, `phone`, `gender`) VALUES
(1, 'mariem', 'emad', 'mariemEmad', 'e10adc3949ba59abbe56e057f20f883e', '01278138617', 'F'),
(2, 'yasmin', 'eihab', 'yasminramy', 'b6af3f19458ec8e6faff8ee1e0440ecb', '01275118617', 'F'),
(3, 'alaa', 'ahmed', 'alaaAhmed', 'e13dd027be0f2152ce387ac0ea83d863', '01128168216', 'F'),
(4, 'yasser', 'alaa', 'yasseralaa', 'b6af3f19458ec8e6faff8ee1e0440ecb', '01274565816', 'M'),
(5, 'manal', 'walid', 'manalwalid', 'e13dd027be0f2152ce387ac0ea83d863', '01125560000', 'F'),
(6, 'yassen', 'adel', 'yassenadel', 'e10adc3949ba59abbe56e057f20f883e', '01223668940', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `patient_disease`
--

CREATE TABLE `patient_disease` (
  `disease` varchar(255) NOT NULL,
  `P_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_disease`
--

INSERT INTO `patient_disease` (`disease`, `P_id`) VALUES
('have headache ', 5);

-- --------------------------------------------------------

--
-- Table structure for table `resident_patient`
--

CREATE TABLE `resident_patient` (
  `RP_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `RoomNum` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `leave_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resident_patient`
--

INSERT INTO `resident_patient` (`RP_id`, `d_id`, `RoomNum`, `entry_date`, `leave_date`) VALUES
(1, 2, 1, '2024-04-26 04:12:12', NULL),
(4, 2, 2, '2024-04-26 04:22:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `num` int(11) NOT NULL,
  `availability` char(1) NOT NULL,
  `type` varchar(255) NOT NULL,
  `room_price` int(11) NOT NULL,
  `n_id` int(11) DEFAULT NULL,
  `w_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`num`, `availability`, `type`, `room_price`, `n_id`, `w_id`) VALUES
(1, 'N', 'Ward', 500, 7, 6),
(2, 'N', 'ICU', 1000, 7, 3),
(3, 'Y', 'Operation Theater', 1500, NULL, NULL),
(4, 'Y', 'Ward', 600, NULL, NULL),
(5, 'Y', 'ICU', 1200, NULL, NULL),
(6, 'Y', 'Operation Theater', 2000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `s_id` int(11) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `salary` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` char(11) NOT NULL,
  `gender` char(1) NOT NULL,
  `AcessData` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`s_id`, `Fname`, `Lname`, `salary`, `username`, `password`, `phone`, `gender`, `AcessData`) VALUES
(1, 'menna', 'saed', 2000, 'mennasaed', 'e10adc3949ba59abbe56e057f20f883e', '01278138916', 'F', 'Y'),
(2, 'irinie', 'magued', 2000, 'iriniemaged', 'b6af3f19458ec8e6faff8ee1e0440ecb', '01278138121', 'F', 'N'),
(3, 'ali', 'ahmed', 1000, 'aliahmed', 'e10adc3949ba59abbe56e057f20f883e', '01278158917', 'M', 'N'),
(4, 'manar', 'hessiun', 1500, 'manaradel', 'e10adc3949ba59abbe56e057f20f883e', '01278058917', 'F', 'N'),
(5, 'mohamed', 'taha', 2000, 'mohamedmagdy', 'b6af3f19458ec8e6faff8ee1e0440ecb', '01178168914', 'M', 'N'),
(6, 'kamel', 'yossef', 1500, 'kamelyossef', 'b6af3f19458ec8e6faff8ee1e0440ecb', '01278928516', 'M', 'N'),
(7, 'marina', 'adly', 1200, 'marinaadly', 'b6af3f19458ec8e6faff8ee1e0440ecb', '01287138914', 'F', 'N');

-- --------------------------------------------------------

--
-- Stand-in structure for view `staff_position`
-- (See below for the actual view)
--
CREATE TABLE `staff_position` (
`Fname` varchar(255)
,`Lname` varchar(255)
,`Position` varchar(8)
);

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `price` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `P_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`price`, `name`, `P_id`) VALUES
(100, 'insulin', 1),
(50, 'parasytamol', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ward_boys`
--

CREATE TABLE `ward_boys` (
  `w_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ward_boys`
--

INSERT INTO `ward_boys` (`w_id`) VALUES
(3),
(6);

-- --------------------------------------------------------

--
-- Structure for view `staff_position`
--
DROP TABLE IF EXISTS `staff_position`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `staff_position`  AS SELECT `s`.`Fname` AS `Fname`, `s`.`Lname` AS `Lname`, CASE WHEN `d`.`d_id` is not null THEN 'Doctor' WHEN `n`.`n_id` is not null THEN 'Nurse' WHEN `w`.`w_id` is not null THEN 'Ward Boy' ELSE 'Admin' END AS `Position` FROM (((`staff` `s` left join `doctor` `d` on(`s`.`s_id` = `d`.`d_id`)) left join `nurse` `n` on(`s`.`s_id` = `n`.`n_id`)) left join `ward_boys` `w` on(`s`.`s_id` = `w`.`w_id`))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `d_id` (`d_id`);

--
-- Indexes for table `app_patient`
--
ALTER TABLE `app_patient`
  ADD PRIMARY KEY (`AP_id`),
  ADD KEY `app_patient_ibfk_2` (`app_id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `bill_ibfk_1` (`P_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `nurse`
--
ALTER TABLE `nurse`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`P_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `patient_disease`
--
ALTER TABLE `patient_disease`
  ADD PRIMARY KEY (`disease`,`P_id`),
  ADD KEY `patient_disease_ibfk_1` (`P_id`);

--
-- Indexes for table `resident_patient`
--
ALTER TABLE `resident_patient`
  ADD PRIMARY KEY (`RP_id`),
  ADD KEY `d_id` (`d_id`),
  ADD KEY `RoomNum` (`RoomNum`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`num`),
  ADD KEY `n_id` (`n_id`),
  ADD KEY `w_id` (`w_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`s_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`name`,`P_id`),
  ADD KEY `treatment_ibfk_1` (`P_id`);

--
-- Indexes for table `ward_boys`
--
ALTER TABLE `ward_boys`
  ADD PRIMARY KEY (`w_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `P_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `doctor` (`d_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app_patient`
--
ALTER TABLE `app_patient`
  ADD CONSTRAINT `app_patient_ibfk_1` FOREIGN KEY (`AP_id`) REFERENCES `patient` (`P_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `app_patient_ibfk_2` FOREIGN KEY (`app_id`) REFERENCES `appointment` (`app_id`) ON DELETE CASCADE;

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`P_id`) REFERENCES `patient` (`P_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `staff` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `nurse`
--
ALTER TABLE `nurse`
  ADD CONSTRAINT `nurse_ibfk_1` FOREIGN KEY (`n_id`) REFERENCES `staff` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_disease`
--
ALTER TABLE `patient_disease`
  ADD CONSTRAINT `patient_disease_ibfk_1` FOREIGN KEY (`P_id`) REFERENCES `patient` (`P_id`) ON DELETE CASCADE;

--
-- Constraints for table `resident_patient`
--
ALTER TABLE `resident_patient`
  ADD CONSTRAINT `resident_patient_ibfk_1` FOREIGN KEY (`RP_id`) REFERENCES `patient` (`P_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resident_patient_ibfk_2` FOREIGN KEY (`d_id`) REFERENCES `doctor` (`d_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resident_patient_ibfk_3` FOREIGN KEY (`RoomNum`) REFERENCES `room` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`n_id`) REFERENCES `nurse` (`n_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `room_ibfk_2` FOREIGN KEY (`w_id`) REFERENCES `ward_boys` (`w_id`) ON DELETE SET NULL;

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `treatment_ibfk_1` FOREIGN KEY (`P_id`) REFERENCES `patient` (`P_id`) ON DELETE CASCADE;

--
-- Constraints for table `ward_boys`
--
ALTER TABLE `ward_boys`
  ADD CONSTRAINT `ward_boys_ibfk_1` FOREIGN KEY (`w_id`) REFERENCES `staff` (`s_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
