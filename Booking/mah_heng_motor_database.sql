-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 02:27 PM
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
-- Database: `mah heng motor database`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `component`
--

CREATE TABLE `component` (
  `Component_ID` int(6) NOT NULL,
  `Component_Name` varchar(255) NOT NULL,
  `Component_Quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `component`
--

INSERT INTO `component` (`Component_ID`, `Component_Name`, `Component_Quantity`) VALUES
(1, 'Tayar', 0),
(2, 'Minyak', 97),
(3, 'Cermin', 99),
(4, 'Ring', 99),
(5, 'Helemt', 99),
(6, 'Jacket', 100),
(7, 'Lampu', 97);

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `Customer_ID` int(6) NOT NULL,
  `Customer_Name` varchar(255) NOT NULL,
  `Customer_Contact_Number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`Customer_ID`, `Customer_Name`, `Customer_Contact_Number`) VALUES
(5, 'Ali', '0197893762'),
(6, 'Bee', '0148306749'),
(7, 'Coco', '0182637356'),
(8, 'Diamond', '0193845731'),
(9, 'Elvin', '0182830312'),
(10, 'Fatimah', '0189271372'),
(11, 'LEE', '012345689');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `Invoice_ID` int(6) NOT NULL,
  `Invoice_Date` date DEFAULT NULL,
  `Invoice_Total_Price` decimal(10,2) DEFAULT NULL,
  `Supplier_ID` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`Invoice_ID`, `Invoice_Date`, `Invoice_Total_Price`, `Supplier_ID`) VALUES
(42, '2024-04-23', '1200.00', 11),
(43, '2024-04-24', '800.00', 12),
(44, '2024-04-25', '500.00', 13),
(45, '2024-05-01', '400.00', 14),
(46, '2024-05-02', '2000.00', 11),
(47, '2024-05-04', '1000.00', 15),
(48, '2024-05-05', '300.00', 16),
(49, '2024-05-06', '20.00', 11);

-- --------------------------------------------------------

--
-- Table structure for table `ordered_component`
--

CREATE TABLE `ordered_component` (
  `Invoice_ID` int(6) NOT NULL,
  `Component_ID` int(6) NOT NULL,
  `Ordered_Component_Price` decimal(10,2) NOT NULL,
  `Ordered_Component_Quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordered_component`
--

INSERT INTO `ordered_component` (`Invoice_ID`, `Component_ID`, `Ordered_Component_Price`, `Ordered_Component_Quantity`) VALUES
(42, 1, '12.00', 100),
(43, 2, '8.00', 100),
(44, 3, '5.00', 100),
(45, 4, '4.00', 100),
(46, 5, '20.00', 100),
(47, 6, '10.00', 100),
(48, 7, '3.00', 100),
(49, 1, '10.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `Service_ID` int(6) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Service_Total_Price` decimal(10,2) NOT NULL,
  `Service_Date` date NOT NULL,
  `Motor_ID` varchar(255) NOT NULL,
  `Customer_ID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`Service_ID`, `Description`, `Service_Total_Price`, `Service_Date`, `Motor_ID`, `Customer_ID`) VALUES
(6, 'Tukar Tayar', '20.00', '2024-04-25', 'JBA6384', 5),
(7, 'Tukar Cermin', '20.00', '2024-04-27', 'JSW6926', 6),
(8, 'Tukar Minyak', '10.00', '2024-04-27', 'JBN8351', 7),
(9, 'Tukar Ring', '30.00', '2024-04-27', 'JHD3491', 8),
(10, 'Beli Helemt', '50.00', '2024-04-28', 'JAQ8412', 9),
(11, 'Tukar Lampu depan dan belakang', '30.00', '2024-05-01', 'JYA9310', 10),
(14, 'Tukar Lampu depan dan belakang', '30.00', '2024-05-01', 'JYA9310', 5),
(17, 'tukar minyak', '30.00', '2024-05-07', 'JBA1475', 11),
(18, 'beli tayar', '1010.00', '2024-05-15', 'asd1w', 11);

-- --------------------------------------------------------

--
-- Table structure for table `service_component`
--

CREATE TABLE `service_component` (
  `Service_ID` int(6) NOT NULL,
  `Component_ID` int(6) NOT NULL,
  `Service_Component_Price_Per_Unit` decimal(10,2) NOT NULL,
  `Service_Component_Quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_component`
--

INSERT INTO `service_component` (`Service_ID`, `Component_ID`, `Service_Component_Price_Per_Unit`, `Service_Component_Quantity`) VALUES
(6, 1, '20.00', 1),
(6, 2, '10.00', 1),
(7, 2, '10.00', 2),
(8, 3, '10.00', 1),
(9, 4, '30.00', 1),
(10, 5, '50.00', 1),
(11, 7, '10.00', 3),
(17, 2, '30.00', 1),
(18, 1, '10.00', 101);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_details`
--

CREATE TABLE `supplier_details` (
  `Supplier_ID` int(6) NOT NULL,
  `Supplier_Name` varchar(255) NOT NULL,
  `Supplier_Contact_Number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_details`
--

INSERT INTO `supplier_details` (`Supplier_ID`, `Supplier_Name`, `Supplier_Contact_Number`) VALUES
(11, 'Ah Boon SDN BHD', '0127941027'),
(12, 'BoonLong SDN BHD', '0108833738'),
(13, 'Cystal SHN BHD', '0167962226'),
(14, 'David SHE', '0162866926'),
(15, 'Edumd SHD', '01126276360'),
(16, 'Faris SDN BHD', '0127229919');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `component`
--
ALTER TABLE `component`
  ADD PRIMARY KEY (`Component_ID`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`Customer_ID`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`Invoice_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`);

--
-- Indexes for table `ordered_component`
--
ALTER TABLE `ordered_component`
  ADD PRIMARY KEY (`Invoice_ID`,`Component_ID`),
  ADD KEY `Component_ID` (`Component_ID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`Service_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

--
-- Indexes for table `service_component`
--
ALTER TABLE `service_component`
  ADD PRIMARY KEY (`Service_ID`,`Component_ID`),
  ADD KEY `Component_ID` (`Component_ID`);

--
-- Indexes for table `supplier_details`
--
ALTER TABLE `supplier_details`
  ADD PRIMARY KEY (`Supplier_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `component`
--
ALTER TABLE `component`
  MODIFY `Component_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `Customer_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `Invoice_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `Service_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `supplier_details`
--
ALTER TABLE `supplier_details`
  MODIFY `Supplier_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_details_ibfk_1` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier_details` (`Supplier_ID`);

--
-- Constraints for table `ordered_component`
--
ALTER TABLE `ordered_component`
  ADD CONSTRAINT `ordered_component_ibfk_1` FOREIGN KEY (`Invoice_ID`) REFERENCES `invoice_details` (`Invoice_ID`),
  ADD CONSTRAINT `ordered_component_ibfk_2` FOREIGN KEY (`Component_ID`) REFERENCES `component` (`Component_ID`);

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer_details` (`Customer_ID`);

--
-- Constraints for table `service_component`
--
ALTER TABLE `service_component`
  ADD CONSTRAINT `service_component_ibfk_1` FOREIGN KEY (`Service_ID`) REFERENCES `service` (`Service_ID`),
  ADD CONSTRAINT `service_component_ibfk_2` FOREIGN KEY (`Component_ID`) REFERENCES `component` (`Component_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
