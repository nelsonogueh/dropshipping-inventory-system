-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2019 at 01:54 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13
--
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1688-items`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_url_1688` varchar(255) DEFAULT NULL,
  `our_sku` varchar(255) DEFAULT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `item_price_yuan` varchar(255) DEFAULT NULL,
  `item_weight_kg` varchar(255) DEFAULT NULL,
  `date_added` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_name`, `item_url_1688`, `our_sku`, `item_image`, `item_price_yuan`, `item_weight_kg`, `date_added`) VALUES
(6, 'Anchor live karaoke monitor headphones MP3 subwoofer 3 meter line long sound card recording universal headset factory direct sales', 'https://detail.1688.com/offer/583875322012.html?spm=a262eq.12572798.jsczf959.291.15ba2fb1A1uVGN', 'ESH007583600 1559173581', 'item_images/Anchor live karaoke monitor headphones MP3 subwoofer 3 meter line long sound card recording universal headset factory direct sales_007586600 1559173581.jpg', '0.99 - 3.50', '0.015', '2019-05-30 01:46:21'),
(7, 'Spot factory direct in-ear double-motion sports headset line control with wheat call smart phone headset', 'https://detail.1688.com/offer/588850289293.html?spm=a262eq.12572798.jsczf959.298.15ba2fb1A1uVGN#next', 'ESH044904400 1559173861', 'item_images/Spot factory direct in-ear double-motion sports headset line control with wheat call smart phone headset_044907800 1559173861.jpg', '3.50 - 5.40', '0.026', '2019-05-30 01:51:01'),
(8, 'In Zhuo GS100 esports game vibration headset headset computer headset with microphone subwoofer USB7.1', 'https://detail.1688.com/offer/555603238490.html?spm=a262eq.12572798.jsczf959.283.15ba2fb1A1uVGN', 'ESH012627800 1559173945', 'item_images/In Zhuo GS100 esports game vibration headset headset computer headset with microphone subwoofer USB7.1_012630600 1559173945.jpg', '199.00 -229.00', '0.9', '2019-05-30 01:52:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `our_sku` (`our_sku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
